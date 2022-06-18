<?php

namespace App\Http\Controllers;

use App\Event;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;

class CaseAdminController extends Controller {
    private static function checkIsDirectoryExisted($directory) {
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
    }

    public function index() {
        return view('admin.cases.index');
    }

    public function create() {
        return view('admin.cases.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'soal' => 'required',
            'tanggal' => 'required',
            'jam' => 'required',
            'durasi' => 'required'
        ]);

        $file = $request->file('soal');
        $file_name = "blank";
        if ($file) {
            $CASE_QUESTIONS_URL = config('app.case_questions_url');
            CaseAdminController::checkIsDirectoryExisted(public_path($CASE_QUESTIONS_URL));

            $file_name = time().$file->getClientOriginalName();
            $file->move(public_path($CASE_QUESTIONS_URL),$file_name);
        }

        Event::create([
            'tanggal_mulai' => $request->tanggal.' '.$request->jam,
            'tanggal_selesai' => Carbon::parse($request->tanggal.' '.$request->jam)->addMinutes($request->durasi)->format('Y-m-d H:i:s'),
            'soal' => $file_name,
            'name' => $request->name
        ]);
        return redirect()->route('admin.cases.index')->with('success','Berhasil !');
    }

    public function edit(Event $case) {
        return view('admin.cases.edit', compact('case'));
    }

    public function update(Request $request, Event $case) {
        $newData = [
            'tanggal_mulai' => $request->tanggal.' '.$request->jam,
            'tanggal_selesai' => Carbon::parse($request->tanggal.' '.$request->jam)->addMinutes($request->durasi)->format('Y-m-d H:i:s'),
            'name' => $request->name
        ];

        $file = $request->file('soal');

        if ($file) {
            $CASE_QUESTIONS_URL = config('app.case_questions_url');
            CaseAdminController::checkIsDirectoryExisted(public_path($CASE_QUESTIONS_URL));

            $file_name = time().$file->getClientOriginalName();
            $file->move(public_path($CASE_QUESTIONS_URL),$file_name);
            $newData['soal'] = $file_name;
            unlink(public_path($case->getSoalURL()));
        }

        $case->update($newData);
        return redirect()->route('admin.cases.index')->with('success','Berhasil !');
    }

    private function backupCaseSubmissionFile(Event $case) {
        if ($case->event_submit()->exists()) {
            $event_submits = $case->event_submit;
            $FILES_BACKUP_URL = config('app.files_backup_url');
            $CASE_SUBMISSIONS_URL = config('app.case_submissions_url');
            CaseAdminController::checkIsDirectoryExisted(public_path($FILES_BACKUP_URL));
            CaseAdminController::checkIsDirectoryExisted(public_path($CASE_SUBMISSIONS_URL));

            foreach ($event_submits as $event_submit) {
                if ($event_submit->file) {
                    $submissionFilePath = public_path($CASE_SUBMISSIONS_URL.'/'.$event_submit->file);
                    $backupFilePath = public_path($FILES_BACKUP_URL.'/'.$event_submit->file);

                    try {
                        File::move($submissionFilePath, $backupFilePath);
                    } catch (Exception $error) {}
                }
            }
        }
    }

    private function backupCaseQuestionFile(Event $case) {
        $FILES_BACKUP_URL = config('app.files_backup_url');
        CaseAdminController::checkIsDirectoryExisted(public_path($FILES_BACKUP_URL));

        $questionFilePath = public_path($case->getSoalURL());
        $backupFilePath = public_path($FILES_BACKUP_URL.'/'.$case->soal);

        try {
            File::move($questionFilePath, $backupFilePath);
        } catch (Exception $error) {}
    }

    public function destroy(Event $case) {
        $this->backupCaseSubmissionFile($case);
        $case->event_submit()->delete();

        $this->backupCaseQuestionFile($case);
        $case->delete();

        return redirect()->route('admin.cases.index')->with('success','Berhasil !');
    }

    public function submissionIndex(Event $case) {
        return view('admin.cases.submissions.index',compact('case'));
    }

    public function submissionTables(Event $case) {
        $data = $case
            ->event_submit()
            ->with('user')
            ->orderByDesc('created_at')
            ->get()
            ->unique('user_id');

        return DataTables::of($data)
            ->addColumn('tanggal', function ($data) {
                return $data->created_at->format('Y-m-d H:i:s');
            })
            ->addColumn('action', function ($data) use ($case) {
                return '
                <a href="'.route('admin.cases.submissions.show', ['case' => $case->id, 'user' => $data->user_id]).'" class="btn btn-sm 
                btn-warning"><i class="fa fa-sign-in"></i> Lihat</a>';
            })
            ->make(true);
    }

    public function submissionShow(Event $case, User $user) {
        return view('admin.cases.submissions.show', compact('case', 'user'));
    }
}
