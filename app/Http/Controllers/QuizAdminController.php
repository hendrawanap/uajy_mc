<?php

namespace App\Http\Controllers;

use App\AksesKuis;
use App\Kuis;
use App\KuisSubmit;
use App\SetKuis;
use App\Soal;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;

class QuizAdminController extends Controller {
    private static function checkIsDirectoryExisted($directory) {
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
    }

    public function index() {
        return view('admin.quizzes.index');
    }

    public function create() {
        return view('admin.quizzes.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'soal_value' => 'required|numeric'
        ]);

        $attachments = '';
        $fileName = '';

        if ($request->hasFile('attachments')) {
            $ATTACHMENTS_URL = config('app.quiz_attachments_url');
            QuizAdminController::checkIsDirectoryExisted(public_path($ATTACHMENTS_URL));

            foreach ($request->file('attachments') as $file) {
                $fileName = time().'-'.$file->getClientOriginalName();
                $fileName = str_replace(',', '_', $fileName);
                $file->move(public_path($ATTACHMENTS_URL), $fileName);

                if (empty($attachments)) {
                    $attachments = $fileName;
                } else {
                    $attachments = $attachments.','.$fileName;
                }
            }
        }

        $quiz = new Kuis;
        $quiz->name = $request->input('name');
        $quiz->soal_value = $request->input('soal_value');
        $quiz->attachments = $attachments;
        $quiz->save();

        return redirect()->route('admin.quizzes.index')->with('success','Berhasil Tambah Data');
    }

    public function edit(Kuis $quiz) {
        $data = $quiz;
        return view('admin.quizzes.edit', compact('quiz'));
    }

    public function update(Request $request, Kuis $quiz) {
        if ($request->has('replace_attachments') || empty($quiz->attachments)) {
            $attachments = '';
            $fileName = '';
            $ATTACHMENTS_URL = config('app.quiz_attachments_url');
            QuizAdminController::checkIsDirectoryExisted(public_path($ATTACHMENTS_URL));

            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $fileName = time().'-'.$file->getClientOriginalName();
                    $fileName = str_replace(',', '_', $fileName);
                    $file->move(public_path($ATTACHMENTS_URL), $fileName);

                    if (empty($attachments)) {
                        $attachments = $fileName;
                    } else {
                        $attachments = $attachments.','.$fileName;
                    }
                }
            }

            $this->removeQuizAttachmentFiles($quiz);
            $quiz->attachments = $attachments;
        }

        $quiz->name = $request->input('name');
        $quiz->soal_value = $request->input('soal_value');
        $quiz->save();

        return redirect()->route('admin.quizzes.index')->with('success','Berhasil Update Data');
    }

    private function removeQuestionImageFile(Soal $question, $useBackup = false) {
        $QUESTIONS_IMG_URL = config('app.quiz_questions_img_url');
        $BACKUP_URL = config('app.files_backup_url');
        QuizAdminController::checkIsDirectoryExisted(public_path($BACKUP_URL));

        if ($question->foto) {
            if ($useBackup) {
                File::move(public_path($QUESTIONS_IMG_URL.'/'.$question->foto), public_path($BACKUP_URL.'/'.$question->foto));
            } else {
                File::delete(public_path($QUESTIONS_IMG_URL.'/'.$question->foto));
            }
        }
    }

    private function removeQuizSubmissionFile(AksesKuis $submission, $useBackup = false) {
        $SUBMISSIONS_URL = config('app.quiz_submissions_url');
        $BACKUP_URL = config('app.files_backup_url');
        QuizAdminController::checkIsDirectoryExisted(public_path($BACKUP_URL));

        if ($submission->type == 0 && $submission->jawaban) {
            if ($useBackup) {
                File::move(public_path($SUBMISSIONS_URL.'/'.$submission->jawaban), public_path($BACKUP_URL.'/'.$submission->jawaban));
            } else {
                File::delete(public_path($SUBMISSIONS_URL.'/'.$submission->jawaban));
            }
        }
    }

    private function removeQuizAttachmentFiles(Kuis $quiz, $useBackup = false) {
        $ATTACHMENTS_URL = config('app.quiz_attachments_url');
        $BACKUP_URL = config('app.files_backup_url');
        QuizAdminController::checkIsDirectoryExisted(public_path($BACKUP_URL));

        if (!empty($quiz->attachments)) {
            foreach (explode(',',$quiz->attachments) as $attachment) {
                if ($useBackup) {
                    File::move(public_path($ATTACHMENTS_URL.'/'.$attachment), public_path($BACKUP_URL.'/'.$attachment));
                } else {
                    File::delete(public_path($ATTACHMENTS_URL.'/'.$attachment));
                }
            }
        }
    }

    public function destroy(Kuis $quiz) {
        DB::beginTransaction();
        try {
            if ($quiz->soal()->exists()) {
                $soals = $quiz->soal;

                foreach ($soals as $soal) {
                    $this->removeQuestionImageFile($soal, true);
                }

                $quiz->soal()->delete();
            }

            $set_kuisses = SetKuis::where('kuis_id', $quiz->id)->get();

            if ($set_kuisses->count() > 0) {
                foreach ($set_kuisses as $set_kuis) {
                    if ($set_kuis->akses_kuis()->exists()) {
                        foreach ($set_kuis->akses_kuis as $akses_kuis) {
                            $this->removeQuizSubmissionFile($akses_kuis, true);
                        }

                        $set_kuis->akses_kuis()->delete();
                        if ($set_kuis->kuis_submit()->exists()) $set_kuis->kuis_submit()->delete();
                    }
                    $set_kuis->delete();
                }
            }

            $this->removeQuizAttachmentFiles($quiz, true);
            $quiz->delete();
            DB::commit();
            return redirect()->route('admin.quizzes.index')->with('success','Berhasil Hapus Data');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal !, kesalahan tidak terduga.'.$e->getMessage());
        }
    }

    public function questionsIndex(Kuis $quiz) {
        return view('admin.quizzes.questions.index', compact('quiz'));
    }

    public function questionsStore(Request $request, Kuis $quiz) {
        $QUESTIONS_IMG_URL = config('app.quiz_questions_img_url');
        QuizAdminController::checkIsDirectoryExisted(public_path($QUESTIONS_IMG_URL));

        $no = Soal::where('kuis_id', $quiz->id)->count()+1;
        $file = $request->file('foto');

        if ($request->isPilihan == 1) {
            $data = [
                'kuis_id' => $quiz->id,
                'name' => $request->name,
                'a' => $request->a,
                'b' => $request->b,
                'c' => $request->c,
                'd' => $request->d,
                'isPilihan' => 1,
                'jawaban' => $request->jawaban,
                'no' => $no,
            ];
        } else {
            $data = [
                'kuis_id' => $quiz->id,
                'name' => $request->name,
                'no' => $no
            ];
        }

        if ($request->file('foto') == true) {
            $file_name = time().$file->getClientOriginalName();
            $data['foto'] = $file_name;
            $file->move(public_path($QUESTIONS_IMG_URL), $file_name);
        }

        $question = Soal::create($data);
        return redirect()->route('admin.quizzes.questions_index', $quiz->id)->with('success', 'Berhasil Menambahkan Data #'.$question->id);
    }

    public function questionsEdit(Kuis $quiz, Soal $question) {
        return view('admin.quizzes.questions.edit', compact('quiz', 'question'));
    }

    public function questionsUpdate(Request $request, Kuis $quiz, Soal $question) {
        $QUESTIONS_IMG_URL = config('app.quiz_questions_img_url');
        QuizAdminController::checkIsDirectoryExisted(public_path($QUESTIONS_IMG_URL));

        $file = $request->file('foto');

        if ($request->isPilihan == 1) {
            $data = [
                'kuis_id' => $quiz->id,
                'name' => $request->name,
                'a' => $request->a,
                'b' => $request->b,
                'c' => $request->c,
                'd' => $request->d,
                'jawaban' => $request->jawaban,
                'isPilihan' => 1
            ];
        } else {
            $data = [
                'kuis_id' => $quiz->id,
                'name' => $request->name,
                'a' => '',
                'b' => '',
                'c' => '',
                'd' => '',
                'isPilihan' => 0
            ];
        }

        if ($request->file('foto') == TRUE) {
            $nama_foto = time().$file->getClientOriginalName();
            $data['foto'] = $nama_foto;
            $file->move(public_path($QUESTIONS_IMG_URL), $nama_foto);
            $this->removeQuestionImageFile($question);
        }

        $question->update($data);
        return redirect()->route('admin.quizzes.questions_index', $quiz->id)->with('success','Berhasil simpan data');
    }

    public function questionsDestroy(Kuis $quiz, Soal $question) {
        $this->removeQuestionImageFile($question);
        $question->delete();
        return redirect()->back()->with('success', 'Berhasil Menghapus Pertanyaan');
    }

    public function questionsTables(Kuis $quiz) {
        $question = Soal::where('kuis_id',$quiz->id)->get();

        return DataTables::of($question)
            ->addColumn('action', function ($question) use ($quiz) {
                return '
                <a href="'.route('admin.quizzes.questions_edit', [$quiz->id, $question->id]).'"  class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                <a href="'.route('admin.quizzes.questions_delete', [$quiz->id, $question->id]).'" class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i></a>';
            })
            ->addColumn('soal', function ($question) {
                return $question->name;
            })
            ->rawColumns(['action','soal'])
            ->addIndexColumn()
            ->make(true);
    }

    public function schedulesIndex(Kuis $quiz) {
        return view('admin.quizzes.schedules.index', compact('quiz'));
    }

    public function schedulesStore(Request $request, Kuis $quiz) {
        SetKuis::create([
            'kuis_id' => $quiz->id,
            'tanggal_mulai' => $request->tanggal.' '.$request->waktu,
            'durasi' => $request->durasi
        ]);

        return redirect()->back()->with('success','Berhasil Membuat Jadwal!');
    }

    public function schedulesEdit(Kuis $quiz, SetKuis $schedule) {
        return view('admin.quizzes.schedules.edit', compact('quiz', 'schedule'));
    }

    public function schedulesUpdate(Request $request, Kuis $quiz, SetKuis $schedule) {
        $schedule->update([
            'tanggal_mulai' => $request->tanggal.' '.$request->waktu,
            'durasi' => $request->durasi
        ]);

        return redirect()->route('admin.quizzes.schedules_index', $quiz->id)->with('success','Berhasil Mengubah Jadwal!');
    }

    public function schedulesDestroy(Kuis $quiz, SetKuis $schedule) {
        $BACKUP_URL = config('app.files_backup_url');
        $SUBMISSIONS_URL = config('app.quiz_submissions_url');
        QuizAdminController::checkIsDirectoryExisted(public_path($BACKUP_URL));
        QuizAdminController::checkIsDirectoryExisted(public_path($SUBMISSIONS_URL));

        if ($schedule->akses_kuis()->exists()) {
            foreach ($schedule->akses_kuis as $akses_kuis) {
                $this->removeQuizSubmissionFile($akses_kuis, true);
            }

            $schedule->akses_kuis()->delete();
        }

        if ($schedule->kuis_submit()->exists()) {
            $schedule->kuis_submit()->delete();
        }

        $schedule->delete();
        return redirect()->back()->with('success','Berhasil Menghapus Jadwal!');
    }

    public function schedulesTables(Kuis $quiz) {
        $schedules = $quiz->set_kuis()->with('kuis')->get();
        return DataTables::of($schedules)
            ->addIndexColumn()
            ->addColumn('action', function ($schedule) use ($quiz) {
                return '
                <a href="'.route('admin.quizzes.schedules_edit',[$quiz->id, $schedule->id]).'"  class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                <a href="'.route('admin.quizzes.schedules_delete',[$quiz->id, $schedule->id]).'" class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i></a>';
            })
            ->make(true);
    }

    public function submissionsIndex(Kuis $quiz) {
        return view('admin.quizzes.submissions.index', compact('quiz'));
    }

    public function submissionsTables(Kuis $quiz) {
        $schedules = $quiz->set_kuis()->get();
        return DataTables::of($schedules)
            ->addColumn('tanggal', function ($schedule) {
                return $schedule->getTanggalMulai();
            })
            ->addColumn('kuis_name', function ($schedule) {
                return $schedule->kuis->name;
            })
            ->addColumn('action', function ($schedule) use ($quiz) {
                return '
                <a href="'.route('admin.quizzes.submissions_users_index', [$quiz->id, $schedule->id]).'" class="btn btn-sm btn-success"><i class="fa fa-fw mr-2 fa-sign-in"></i>Akses ( '.$schedule->kuis_submit()->count().' )</a>';
            })
            ->addIndexColumn()
            ->make(true);
    }

    public function submissionsUsersIndex(Kuis $quiz, SetKuis $schedule) {
        return view('admin.quizzes.submissions.users-index', compact('quiz', 'schedule'));
    }

    public function submissionsUsersTables(Kuis $quiz, SetKuis $schedule) {
        $data = $schedule->kuis_submit()->with('user')->get();
        return DataTables::of($data)
            ->addColumn('action', function ($data) use ($quiz, $schedule) {
                return '
                <a href="'.route('admin.quizzes.submissions_users_show', [$quiz->id, $schedule->id, $data->user_id]).'" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> Periksa Kuis</a>';
            })
            ->addColumn('users', function ($data) {
                return '<img class="rounded-circle" alt="image" width="50" src="/template/images/avatar/1.png">';
            })
            ->addIndexColumn()
            ->rawColumns(['users','action'])
            ->make(true);
    }

    public function submissionsUsersShow(Kuis $quiz, SetKuis $schedule, User $user) {
        $questions = AksesKuis::where('user_id', $user->id)->where('set_kuis_id', $schedule->id)->get();
        $data = [];

        foreach ($questions as $question) {
            if(!isset($data[$question->soal->no])) {
                $data[$question->soal->no] = array(); 
            }

            array_push($data[$question->soal->no], $question);
        }

        $submission = KuisSubmit::where('user_id', $user->id)->where('set_kuis_id', $schedule->id)->first();

        return view('admin.quizzes.submissions.users-show', compact('quiz', 'schedule', 'user', 'submission'))->with('questions', $data);
    }

    public function submissionsUsersUpdate(Request $request, Kuis $quiz, SetKuis $schedule, User $user) {
        $submission = KuisSubmit::where('user_id', $user->id)->where('set_kuis_id', $schedule->id)->first();
        $submission->nilai = $request->nilai;
        $submission->save();
        return redirect()->route('admin.quizzes.submissions_users_show', [$quiz->id, $schedule->id, $user->id])->with('success','Berhasil !');
    }
}
