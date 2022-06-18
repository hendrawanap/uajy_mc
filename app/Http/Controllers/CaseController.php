<?php

namespace App\Http\Controllers;

use App\CaseTemporaryFile;
use App\Event;
use App\EventSubmit;
use Carbon\Carbon;
use DirectoryIterator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class CaseController extends Controller {
    private static function checkIsDirectoryExisted($directory) {
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
    }

    public function index() {
        return view('cases.index');
    }

    public function submissionsIndex(Event $case) {
        if (Carbon::parse($case->getTanggalSelesai())->format('Y-m-d H:i:s') < date('Y-m-d H:i:s')) {
            return redirect()->back()->with('error','Waktu sudah habis !');
            exit;
        }

        $this->removeAllTemporaryFiles($case);
        return view('cases.submissions.index', compact('case'));
    }

    public function submissionsStore(Request $request, Event $case) {
        $temporaryFiles = array();

        foreach ($request->fileUploads as $foldername) {
            array_push(
                $temporaryFiles,
                CaseTemporaryFile::where('folder', $foldername)
                    ->where('event_id', $case->id)
                    ->where('user_id', Auth::user()->id)
                    ->first()
            );
        }

        if (count($temporaryFiles) > 0) {
            $CASE_TEMP_SUBMISSIONS_URL = config('app.case_temp_submissions_url');
            $CASE_SUBMISSIONS_URL = config('app.case_submissions_url');
            CaseController::checkIsDirectoryExisted(public_path($CASE_TEMP_SUBMISSIONS_URL));
            CaseController::checkIsDirectoryExisted(public_path($CASE_SUBMISSIONS_URL));

            foreach ($temporaryFiles as $index => $temporaryFile) {
                EventSubmit::create([
                    'event_id' => $case->id,
                    'file' => $temporaryFile->filename,
                    'user_id' => Auth::user()->id,
                ]);

                $tempFilePath = public_path($CASE_TEMP_SUBMISSIONS_URL . '/' . $temporaryFile->folder . '/' . $temporaryFile->filename);
                $submitFilePath = public_path($CASE_SUBMISSIONS_URL . '/' . $temporaryFile->filename);

                File::move($tempFilePath, $submitFilePath);

                $temporaryFile->delete();
                rmdir(public_path($CASE_TEMP_SUBMISSIONS_URL . '/' . $temporaryFile->folder));
            }
        }

        Session::flash('success', 'Berhasil !');
        return 'Berhasil!';
    }

    public function submissionsDelete(Event $case, EventSubmit $submission) {
        unlink(public_path($submission->getFile()));
        $submission->delete();
        return redirect()->back()->with('success','Berhasil !');
    }

    public function submissionsTables(Event $case) {
        $data = $case->event_submit()->where('user_id', Auth::user()->id)->get();
        return DataTables::of($data)
            ->addColumn('file', function ($data) {
                return '<a href="'.$data->getFile().'" download>'.$data->file.'</a>';
            })
            ->addColumn('created_at', function ($data) {
                return Carbon::parse($data->created_at)->format('Y-m-d H:i:s');
            })
            ->addColumn('action', function ($data) use($case) {
                return '
                <a href="'.route('cases.submissions.delete',['case' => $case->id, 'submission' => $data->id]).'" class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i></a>';
            })
            ->rawColumns(['file','action'])
            ->make(true);
    }

    public function submissionsUploadTemporary(Request $request, Event $case) {
        if ($request->input('useChunk')) {
            $folder = $case->id.Auth::user()->id.'-'.uniqid().'-'.now()->timestamp;
            return $folder;
        } else {
            if ($request->hasFile('file')) {
                $files = $request->file('file');

                $CASE_TEMP_SUBMISSIONS_URL = config('app.case_temp_submissions_url');
                CaseController::checkIsDirectoryExisted(public_path($CASE_TEMP_SUBMISSIONS_URL));
    
                foreach ($files as $file) {
                    $extension = explode('.', $file->getClientOriginalName());
                    $extension = $extension[count($extension) - 1];
                    $filename = strtoupper($case->name).'_'.strtoupper(Auth::user()->name).'_'.uniqid().'.'.$extension;
                    $folder = $case->id.Auth::user()->id.'-'.uniqid().'-'.now()->timestamp;
                    $file->move(public_path($CASE_TEMP_SUBMISSIONS_URL . '/' . $folder), $filename);

                    CaseTemporaryFile::create([
                        'user_id' => Auth::user()->id,
                        'event_id' => $case->id,
                        'folder' => $folder,
                        'filename' => $filename
                    ]);

                    return $folder;
                }
            }
        }

        return '';
    }

    public function submissionsPatchTemporary(Request $request, Event $case) {
        $loaded = $request->input('loaded');
        $chunkSize = $request->input('chunkSize');
        $fileSize = $request->input('fileSize');
        $chunk = $request->file('filedata');
        $chunkName = $chunk->getClientOriginalName();
        $folder = $request->input('folder');

        try {
            $CASE_TEMP_SUBMISSIONS_URL = config('app.case_temp_submissions_url');
            CaseController::checkIsDirectoryExisted(public_path($CASE_TEMP_SUBMISSIONS_URL));

            $chunk->move($CASE_TEMP_SUBMISSIONS_URL . '/' . $folder, $chunkName);

            if ($loaded + $chunkSize > $fileSize) {
                $dir = new DirectoryIterator(public_path($CASE_TEMP_SUBMISSIONS_URL . '/' .$folder));
                $extension = $request->input('fileExtension');
                $filename = strtoupper($case->name).'_'.strtoupper(Auth::user()->name).'_'.explode('-', $folder)[1].'.'.$extension;

                foreach ($dir as $fileinfo) {
                    if (!$fileinfo->isDot()) {
                        $chunkPath = public_path($CASE_TEMP_SUBMISSIONS_URL . '/' .$folder.'/'.$fileinfo->getFileName());
                        $chunkFile = fopen($chunkPath, 'rb');
                        $buff = fread($chunkFile, $chunkSize);
                        fclose($chunkFile);

                        $filePath = public_path($CASE_TEMP_SUBMISSIONS_URL . '/' .$folder.'/'.$filename);
                        $combineFile = fopen($filePath,'ab');
                        $write = fwrite($combineFile, $buff);
                        fclose($combineFile);
                        unlink($chunkPath);
                    }
                }

                $tempFiles = CaseTemporaryFile::where('event_id', $case->id)
                    ->where('user_id', Auth::user()->id)
                    ->where('folder', $folder)
                    ->get();

                foreach ($tempFiles as $tempFile) {
                    $tempFile->delete();
                }

                CaseTemporaryFile::create([
                    'user_id' => Auth::user()->id,
                    'event_id' => $case->id,
                    'folder' => $folder,
                    'filename' => $filename
                ]);
            } else {
                CaseTemporaryFile::create([
                    'user_id' => Auth::user()->id,
                    'event_id' => $case->id,
                    'folder' => $folder,
                    'filename' => $chunkName
                ]);
            }
        } catch (Exception $error) {
            $CASE_TEMP_SUBMISSIONS_URL = config('app.case_temp_submissions_url');
            CaseController::checkIsDirectoryExisted(public_path($CASE_TEMP_SUBMISSIONS_URL));

            try {
                array_map('unlink', glob(public_path($CASE_TEMP_SUBMISSIONS_URL . '/' . $folder . '/*.*')));
                rmdir(public_path($CASE_TEMP_SUBMISSIONS_URL . '/' . $folder));
            } catch (Exception $error) {}

            return response($error, 500);
        }
        return $folder;
    }

    public function submissionsDeleteTemporary(Request $request) {
        $CASE_TEMP_SUBMISSIONS_URL = config('app.case_temp_submissions_url');
        CaseController::checkIsDirectoryExisted(public_path($CASE_TEMP_SUBMISSIONS_URL));

        $foldername = $request->foldername;
        array_map('unlink', glob(public_path($CASE_TEMP_SUBMISSIONS_URL . '/' . $foldername . '/*')));
        rmdir(public_path($CASE_TEMP_SUBMISSIONS_URL . '/' . $foldername));
        CaseTemporaryFile::where('folder', $foldername)->delete();
        return $foldername;
    }

    private function removeAllTemporaryFiles(Event $case) {
        $temporaryFiles = CaseTemporaryFile::where('event_id', $case->id)->where('user_id', Auth::user()->id)->get();

        if ($temporaryFiles->count() > 0) {
            $CASE_TEMP_SUBMISSIONS_URL = config('app.case_temp_submissions_url');
            CaseController::checkIsDirectoryExisted(public_path($CASE_TEMP_SUBMISSIONS_URL));

            foreach ($temporaryFiles as $temporaryFile) {
                try {
                    $temporaryFile->delete();
                    array_map('unlink', glob(public_path($CASE_TEMP_SUBMISSIONS_URL . '/' . $temporaryFile->folder . '/*')));
                    rmdir(public_path($CASE_TEMP_SUBMISSIONS_URL . '/' . $temporaryFile->folder));
                } catch (Exception $error) {}
            }
        }
    }
}
