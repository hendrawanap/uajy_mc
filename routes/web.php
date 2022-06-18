<?php

use Illuminate\Support\Facades\Route;

Route::get('/config-clear',function() {
    Artisan::call("config:cache");
    Artisan::call("config:clear");
    echo Artisan::output();
});
Auth::routes(['register' => false]);


Route::get('/', 'HomeController@index')->name('home');

Route::middleware(['auth', 'check_admin'])->prefix('admin')->group(function() {
    Route::get('/setting', 'HomeController@setting')->name('setting');

    Route::get('/user-json','UserController@json')->name('user.json');
    Route::get('/user/delete/{user}','UserController@destroy')->name('user.delete');
    Route::get('/user/elimination/{user}','UserController@elimination')->name('user.elimination');
    Route::resource('user','UserController');

    Route::get('/quizzes','QuizAdminController@index')->name('admin.quizzes.index');
    Route::post('/quizzes','QuizAdminController@store')->name('admin.quizzes.store');
    Route::get('/quizzes/create','QuizAdminController@create')->name('admin.quizzes.create');
    Route::put('/quizzes/{quiz}','QuizAdminController@update')->name('admin.quizzes.update');
    Route::get('/quizzes/{quiz}/edit','QuizAdminController@edit')->name('admin.quizzes.edit');
    Route::get('/quizzes/{quiz}/delete','QuizAdminController@destroy')->name('admin.quizzes.delete');

    Route::get('/quizzes/{quiz}/questions','QuizAdminController@questionsIndex')->name('admin.quizzes.questions_index');
    Route::post('/quizzes/{quiz}/questions','QuizAdminController@questionsStore')->name('admin.quizzes.questions_store');
    Route::get('/quizzes/{quiz}/questions/tables','QuizAdminController@questionsTables')->name('admin.quizzes.questions_tables');
    Route::get('/quizzes/{quiz}/questions/{question}/edit','QuizAdminController@questionsEdit')->name('admin.quizzes.questions_edit');
    Route::post('/quizzes/{quiz}/questions/{question}/update','QuizAdminController@questionsUpdate')->name('admin.quizzes.questions_update');
    Route::get('/quizzes/{quiz}/questions/{question}/delete','QuizAdminController@questionsDestroy')->name('admin.quizzes.questions_delete');

    Route::get('/quizzes/{quiz}/schedules','QuizAdminController@schedulesIndex')->name('admin.quizzes.schedules_index');
    Route::post('/quizzes/{quiz}/schedules','QuizAdminController@schedulesStore')->name('admin.quizzes.schedules_store');
    Route::get('/quizzes/{quiz}/schedules/{schedule}/edit','QuizAdminController@schedulesEdit')->name('admin.quizzes.schedules_edit');
    Route::put('/quizzes/{quiz}/schedules/{schedule}','QuizAdminController@schedulesUpdate')->name('admin.quizzes.schedules_update');
    Route::get('/quizzes/{quiz}/schedules/{schedule}/delete','QuizAdminController@schedulesDestroy')->name('admin.quizzes.schedules_delete');
    Route::get('/quizzes/{quiz}/schedules/tables','QuizAdminController@schedulesTables')->name('admin.quizzes.schedules_tables');

    Route::get('/quizzes/{quiz}/schedules/submissions','QuizAdminController@submissionsIndex')->name('admin.quizzes.submissions_index');
    Route::get('/quizzes/{quiz}/schedules/submissions/tables','QuizAdminController@submissionsTables')->name('admin.quizzes.submissions_tables');
    Route::get('/quizzes/{quiz}/schedules/{schedule}/submissions/users','QuizAdminController@submissionsUsersIndex')->name('admin.quizzes.submissions_users_index');
    Route::get('/quizzes/{quiz}/schedules/{schedule}/submissions/users/tables','QuizAdminController@submissionsUsersTables')->name('admin.quizzes.submissions_users_tables');
    Route::get('/quizzes/{quiz}/schedules/{schedule}/users/{user}/submissions','QuizAdminController@submissionsUsersShow')->name('admin.quizzes.submissions_users_show');
    Route::post('/quizzes/{quiz}/schedules/{schedule}/users/{user}/submissions/update','QuizAdminController@submissionsUsersUpdate')->name('admin.quizzes.submissions_users_update');

    Route::get('/cases','CaseAdminController@index')->name('admin.cases.index');
    Route::get('/cases/create','CaseAdminController@create')->name('admin.cases.create');
    Route::post('/cases','CaseAdminController@store')->name('admin.cases.store');
    Route::get('/cases/{case}/edit','CaseAdminController@edit')->name('admin.cases.edit');
    Route::put('/cases/{case}','CaseAdminController@update')->name('admin.cases.update');
    Route::get('/cases/{case}/delete','CaseAdminController@destroy')->name('admin.cases.delete');

    Route::get('/cases/{case}/submissions','CaseAdminController@submissionIndex')->name('admin.cases.submissions.index');
    Route::get('/cases/{case}/submissions/tables','CaseAdminController@submissionTables')->name('admin.cases.submissions.tables');
    Route::get('/cases/{case}/users/{user}/submissions','CaseAdminController@submissionShow')->name('admin.cases.submissions.show');
});

Route::group(['middleware' => ['auth','check_peserta']], function () {

    Route::get('/quizzes','QuizController@index')->name('quizzes.index');
    Route::get('/quizzes/submissions','QuizController@submissionsIndex')->name('quizzes.submissions_index');
    Route::get('/quizzes/submissions/tables','QuizController@submissionsTables')->name('quizzes.submissions_tables');

    Route::get('/quizzes/{schedule}/show','QuizController@show')->name('kuis.jawab.show');
    Route::get('/quizzes/ajax/{type}','QuizController@quizAjax')->name('kuis.jawab.ajax');
    Route::post('/quizzes/{schedule}/upload', 'QuizController@quizTempUpload')->name('quizzes.upload_temp');
    Route::post('/quizzes/{schedule}/patch', 'QuizController@quizTempPatch')->name('quizzes.patch_temp');
    Route::delete('/quizzes/{schedule}/delete', 'QuizController@quizTempDelete')->name('quizzes.delete_temp');
    Route::post('/quizzes/{schedule}/submit','QuizController@quizAnswer')->name('quizzes.submit');

    Route::get('/cases','CaseController@index')->name('cases.index');
    Route::get('/cases/{case}/submissions','CaseController@submissionsIndex')->name('cases.submissions.index');
    Route::post('/cases/{case}/submissions','CaseController@submissionsStore')->name('cases.submissions.store');
    Route::get('/cases/{case}/submissions/{submission}/delete','CaseController@submissionsDelete')->name('cases.submissions.delete');
    Route::get('/cases/{case}/submissions/tables','CaseController@submissionsTables')->name('cases.submissions.tables');
    Route::post('/cases/{case}/submissions/upload', 'CaseController@submissionsUploadTemporary')->name('cases.submissions.upload_temp');
    Route::post('/cases/{case}/submissions/patch', 'CaseController@submissionsPatchTemporary')->name('cases.submissions.patch_temp');
    Route::delete('/cases/{case}/submissions/delete', 'CaseController@submissionsDeleteTemporary')->name('cases.submissions.delete_temp');
});

Route::get('logout',function() {
    Auth::logout();
    return redirect('login')->with('success','Berhasil Logout !');
})->name('logout');
