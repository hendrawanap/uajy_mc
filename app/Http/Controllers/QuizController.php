<?php

namespace App\Http\Controllers;

use App\AksesKuis;
use App\KuisSubmit;
use App\QuizTemporaryFile;
use App\SetKuis;
use Carbon\Carbon;
use DirectoryIterator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class QuizController extends Controller {
    private static function checkIsDirectoryExisted($directory) {
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
    }
    public function index() {
        return view('quizzes.index');
    }

    public function submissionsIndex() {
        return view('quizzes.submissions');
    }

    public function submissionsTables() {
        $data = KuisSubmit::where('user_id', Auth::user()->id)->whereNotNull('nilai')->with(['user','set_kuis'])->get();
        return DataTables::of($data)->addColumn('kuis_name', function($data) {
            return $data->set_kuis->kuis->name;
        })->make(true);
    }

    private function removeAllTempFiles(SetKuis $schedule) {
        $temporaryFiles = QuizTemporaryFile::where('set_kuis_id', $schedule->id)->where('user_id', Auth::user()->id)->get();

        if ($temporaryFiles->count() > 0) {
            $TEMP_SUBMISSIONS_URL = config('app.quiz_temp_submissions_url');
            QuizController::checkIsDirectoryExisted(public_path($TEMP_SUBMISSIONS_URL));

            foreach ($temporaryFiles as $temporaryFile) {
                try {
                    $temporaryFile->delete();
                    array_map('unlink', glob(public_path($TEMP_SUBMISSIONS_URL . '/' . $temporaryFile->folder . '/*')));
                    rmdir(public_path($TEMP_SUBMISSIONS_URL . '/' . $temporaryFile->folder));
                } catch(Exception $error) {}
            }
        }
    }

    public function show(SetKuis $schedule) {
        $this->removeAllTempFiles($schedule);

        $aksesKuises = AksesKuis::where('set_kuis_id', $schedule->id)
            ->where('user_id', Auth::user()->id)
            ->where('type', 0)
            ->get();

        if ($aksesKuises->count() > 0) {
            foreach ($aksesKuises as $aksesKuis) {
                $aksesKuis->jawaban = null;
                $aksesKuis->save();
            }
        }

        if (Carbon::parse($schedule->getTanggalMulai())->addMinutes($schedule->durasi)->format('Y-m-d H:i:s') < date('Y-m-d H:i:s')) {
            return redirect()->route('kuis.jawab.list')->with('error','ujian telah berakhir');
            exit;
        }

        if (AksesKuis::where('user_id',Auth::user()->id)->where('set_kuis_id',$schedule->id)->count() < 1) {
            DB::beginTransaction();

            try {
                foreach ($schedule->kuis->soal()->get() as $data) {
                    AksesKuis::create([
                        'user_id' => Auth::user()->id,
                        'kuis_id' => $data->kuis_id,
                        'set_kuis_id' => $schedule->id,
                        'soal_id' => $data->id,
                        'type' => $data->isPilihan // 0 = essai , 1 = pilihan ganda
                    ]);
                }

                KuisSubmit::create([
                    'user_id' => Auth::user()->id,
                    'set_kuis_id' => $schedule->id
                ]);
                DB::commit();
            } catch(Exception $e) {
                DB::rollback();
                return redirect()->back()->with('error', 'Gagal !, kesalahan tidak terduga.');
            }
        }

        return view('quizzes.show', compact('schedule'));
    }

    private function isiJawabanSoalFile($schedule, $folder, $filename, $id) {
        $akseskuis = AksesKuis::findOrFail($id);
    
        QuizTemporaryFile::create([
            'user_id' => Auth::user()->id,
            'kuis_id' => $akseskuis->soal->kuis_id,
            'set_kuis_id' => $schedule->id,
            'soal_id' => $akseskuis->soal->id,
            'folder' => $folder,
            'filename' => $filename
        ]);

        $akseskuis->jawaban = '1';
        $akseskuis->save();
    }

    public function quizTempUpload(Request $request, SetKuis $schedule) {
        $questionId = $request->query('questionId');
        $TEMP_SUBMISSIONS_URL = config('app.quiz_temp_submissions_url');
        QuizController::checkIsDirectoryExisted(public_path($TEMP_SUBMISSIONS_URL));
        // return $request->file('jawaban')['56']->getClientOriginalName();

        if ($request->input('useChunk')) {
            $folder = $questionId.$schedule->id.Auth::user()->id.'-'.uniqid().'-'.now()->timestamp;
            return $folder;
        } else {
            if ($request->hasFile('jawaban')) {
                $files = $request->file('jawaban');
                
                foreach ($files as $file) {
                    $extension = explode('.', $file->getClientOriginalName());
                    $extension = $extension[count($extension) - 1];

                    $filename = strtoupper($schedule->kuis->name).'_'.strtoupper(Auth::user()->name).'_'.uniqid().'.'.$extension;
                    $folder = $questionId.$schedule->id.Auth::user()->id.'-'.uniqid().'-'.now()->timestamp;
                    $file->move(public_path($TEMP_SUBMISSIONS_URL . '/' . $folder), $filename);
                    $this->isiJawabanSoalFile($schedule, $folder, $filename, $questionId);
                    return $folder;
                }
            }
        }

        return '';
    }

    public function quizTempPatch(Request $request, SetKuis $schedule) {
        $questionId = $request->query('questionId');
        $loaded = $request->input('loaded');
        $chunkSize = $request->input('chunkSize');
        $fileSize = $request->input('fileSize');
        $chunk = $request->file('filedata');
        $chunkName = $chunk->getClientOriginalName();
        $folder = $request->input('folder');

        $TEMP_SUBMISSIONS_URL = config('app.quiz_temp_submissions_url');
        QuizController::checkIsDirectoryExisted(public_path($TEMP_SUBMISSIONS_URL));

        try {
            $chunk->move($TEMP_SUBMISSIONS_URL . '/' . $folder, $chunkName);
            $isComplete = $loaded + $chunkSize > $fileSize;

            if ($isComplete) {
                $dir = new DirectoryIterator(public_path($TEMP_SUBMISSIONS_URL . '/' .$folder));
                $extension = $request->input('fileExtension');
                $filename = strtoupper($schedule->kuis->name).'_'.strtoupper(Auth::user()->name).'_'.explode('-', $folder)[1].'.'.$extension;

                foreach ($dir as $fileinfo) {
                    if (!$fileinfo->isDot()) {
                        $chunkPath = public_path($TEMP_SUBMISSIONS_URL . '/' .$folder.'/'.$fileinfo->getFileName());
                        $file = fopen($chunkPath, 'rb');
                        $buff = fread($file, $chunkSize);
                        fclose($file);

                        $filePath = public_path($TEMP_SUBMISSIONS_URL . '/' .$folder.'/'.$filename);
                        $final = fopen($filePath,'ab');
                        $write = fwrite($final, $buff);
                        fclose($final);
                        unlink($chunkPath);
                    }
                }

                $tempFiles = QuizTemporaryFile::where('set_kuis_id', $schedule->id)
                    ->where('user_id', Auth::user()->id)
                    ->where('folder', $folder)
                    ->get();

                foreach ($tempFiles as $tempFile) {
                    $tempFile->delete();
                }

                $this->isiJawabanSoalFile($schedule, $folder, $filename, $questionId);
            } else {
                $akseskuis = AksesKuis::findOrFail($questionId);
                QuizTemporaryFile::create([
                    'user_id' => Auth::user()->id,
                    'kuis_id' => $akseskuis->soal->kuis_id,
                    'set_kuis_id' => $schedule->id,
                    'soal_id' => $akseskuis->soal->id,
                    'folder' => $folder,
                    'filename' => $chunkName
                ]);
            }
        } catch (Exception $error) {
            array_map('unlink', glob(public_path($TEMP_SUBMISSIONS_URL . '/' . $folder . '/*.*')));
            rmdir(public_path($TEMP_SUBMISSIONS_URL . '/' . $folder));
            return response($error, 500);
        }

        return $folder;
    }

    public function quizTempDelete(Request $request, SetKuis $schedule) {
        $questionId = $request->query('questionId');
        $foldername = $request->foldername;

        $TEMP_SUBMISSIONS_URL = config('app.quiz_temp_submissions_url');
        QuizController::checkIsDirectoryExisted(public_path($TEMP_SUBMISSIONS_URL));

        try {
            array_map('unlink', glob(public_path($TEMP_SUBMISSIONS_URL . '/' . $foldername . '/*')));
            rmdir(public_path($TEMP_SUBMISSIONS_URL . '/' . $foldername));
        } catch (Exception $error) {}

        QuizTemporaryFile::where('folder', $foldername)->delete();
        $aksesKuis = AksesKuis::findOrFail($questionId);
        $quizTemporary = QuizTemporaryFile::where('set_kuis_id', $schedule->id)
            ->where('kuis_id', $aksesKuis->kuis_id)
            ->where('soal_id', $aksesKuis->soal_id)
            ->where('user_id', Auth::user()->id)
            ->first();

        if (!$quizTemporary) {
            $aksesKuis->jawaban = null;
            $aksesKuis->save();
        }

        return $foldername;
    }

    public function quizAnswer(Request $request, SetKuis $schedule) {
        $jawaban = array();

        if (array_key_exists('jawaban', $request->postData)) {
            $jawaban = $request->postData['jawaban'];
        }

        $total_nilai_pilgan = 0;
        $nilai_per_soal = $schedule->kuis->soal_value;

        // cek file essay
        if(AksesKuis::where('set_kuis_id',$schedule->id)->where('jawaban','0')->where('user_id',Auth::user()->id)->count() > 0) {
            return redirect()->back()->with('error','Ada Kesalahan ! Silahkan Masukkan Ulang File Essay');
            exit;
        }

        DB::beginTransaction();

        try {
            foreach($jawaban as $key => $value) {
                if ($value) {
                    $data = AksesKuis::where('id',$key)->where('user_id',Auth::user()->id)->first();

                    if ($request->postData['isian'][$key] == 1) {
                        $temporaryFiles = array();

                        foreach ($request->fileUploads[$key] as $foldername) {
                            array_push($temporaryFiles, QuizTemporaryFile::where('folder', $foldername)->where('set_kuis_id', $schedule->id)->where('user_id', Auth::user()->id)->first());
                        }

                        if (count($temporaryFiles) > 0) {
                            $TEMP_SUBMISSIONS_URL = config('app.quiz_temp_submissions_url');
                            $SUBMISSIONS_URL = config('app.quiz_submissions_url');
                            QuizController::checkIsDirectoryExisted(public_path($TEMP_SUBMISSIONS_URL));
                            QuizController::checkIsDirectoryExisted(public_path($SUBMISSIONS_URL));

                            foreach ($temporaryFiles as $index => $temporaryFile) {
                                if ($index == 0) {
                                    $data->update([
                                        'jawaban' => $temporaryFile->filename,
                                        'isRagu' => 0,
                                        'isCheck' => 1,
                                    ]);
                                } else {
                                    AksesKuis::create([
                                        'user_id' => Auth::user()->id,
                                        'kuis_id' => $temporaryFile->kuis_id,
                                        'set_kuis_id' => $temporaryFile->set_kuis_id,
                                        'soal_id' => $temporaryFile->soal_id,
                                        'type' => 0, // 0 = essai , 1 = pilihan ganda
                                        'jawaban' => $temporaryFile->filename,
                                        'isRagu' => 0,
                                        'isCheck' => 1,
                                    ]);
                                }

                                try {
                                    File::move(public_path($TEMP_SUBMISSIONS_URL . '/' . $temporaryFile->folder . '/' . $temporaryFile->filename), public_path($SUBMISSIONS_URL . '/' . $temporaryFile->filename));
                                    $temporaryFile->delete();
                                    rmdir(public_path($TEMP_SUBMISSIONS_URL . '/' . $temporaryFile->folder));
                                } catch (Exception $error) {}
                            }
                        }
                    } else {
                        // cek otomatis jawaban pilgan
                        $update_data = [
                            'jawaban' => $value,
                            'isRagu' => 0,
                            'isCheck' => 1
                        ];
                        if ($value == $data->soal->jawaban) {
                            $total_nilai_pilgan+=$nilai_per_soal;
                            $update_data['isTrue'] = 1;
                        } else {
                            $update_data['isFalse'] = 1;
                        }
                        $data->update($update_data);
                    }
                }
            }
            KuisSubmit::where('set_kuis_id',$schedule->id)->where('user_id',Auth::user()->id)->where('status',0)->update([
                'status' => 1,
                'nilai' => $total_nilai_pilgan
            ]);
            DB::commit();
            Session::flash('success', 'Berhasil Submit Jawaban');
            return 'Berhasil Submit Jawaban';
        } catch(Exception $e) {
            DB::rollback();
            Session::flash('error', 'Ada kesalahan sistem');
        }
    }

    public function quizAjax(Request $request, $type) {
        if ($type == "no-soal") {
            $data = AksesKuis::where('user_id',Auth::user()->id)->where('set_kuis_id',$request->setkuis)->get();
            return view('quizzes.questions-number', compact('data'));
        } else if ($type == "jawab" ) {
            AksesKuis::findOrFail($request->id)->update([
                'jawaban' => $request->jawaban
            ]);
            return 'ok jawab';
        }
    }
}
