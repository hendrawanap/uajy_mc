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

    Route::get('/kuis/index','KuisController@index')->name('kuis.index');
    Route::get('/kuis/create','KuisController@create')->name('kuis.create');
    Route::post('/kuis/action','KuisController@store')->name('kuis.store');
    Route::get('/kuis/{kuis}/edit','KuisController@edit')->name('kuis.edit');
    Route::put('/kuis/{kuis}/update','KuisController@update')->name('kuis.update');
    Route::get('/kuis-json','KuisController@json')->name('kuis.json');
    Route::get('/kuis-delete/{kuis}','KuisController@destroy')->name('kuis.delete');

    Route::get('/kuis/{kuis}/soal','KuisController@kuisSoal')->name('kuis.soal');
    Route::post('/kuis/{kuis}/soal/action','KuisController@kuisSoalAction')->name('kuis.soal_action');
    Route::get('/kuis/{kuis}/soal/json','KuisController@soal_json')->name('kuis.soal_json');

    Route::get('/kuis/soal/{soal}/view','KuisController@soalShow')->name('soal.show');
    Route::get('/kuis/soal/{soal}/edit','KuisController@soalEdit')->name('soal.edit');
    Route::post('/kuis/soal/{soal}/update','KuisController@soalUpdate')->name('soal.update');
    Route::get('/kuis/soal/{soal}/delete','KuisController@soalDelete')->name('soal.delete');

    Route::get('/kuis/{kuis}/jadwal','KuisController@setKuis')->name('jadwal.index');
    Route::post('/kuis/{kuis}/jadwal/action','KuisController@setKuisAction')->name('jadwal.action');
    Route::put('/kuis/{setkuis}/jadwal/update','KuisController@setKuisUpdate')->name('jadwal.update');
    Route::get('/kuis/{setkuis}/jadwal/delete','KuisController@setKuisDelete')->name('jadwal.delete');
    Route::get('/kuis/{setkuis}/jadwal/edit','KuisController@setKuisEdit')->name('jadwal.edit');
    Route::get('/kuis/{kuis}/jadwal/json','KuisController@setKuisJson')->name('jadwal.json');

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

    Route::get('/kuis/list','KuisController@aksesKuis')->name('kuis.jawab.list');
    Route::get('/kuis/list/nilai','KuisController@history_nilai')->name('kuis.jawab.list.nilai');
    Route::get('/kuis/list/nilai/json','KuisController@history_nilai_json')->name('kuis.jawab.list.nilai_json');

    Route::get('/kuis/{setkuis}/show','KuisController@showAksesKuis')->name('kuis.jawab.show');
    Route::get('/kuis/ajax/{type}','KuisController@ajaxAksesKuis')->name('kuis.jawab.ajax');
    Route::post('/kuis/{setkuis}/upload/{id}', 'KuisController@uploadAksesKuisFile')->name('kuis.jawab.upload');
    Route::post('/kuis/{setkuis}/patch/{id}', 'KuisController@patchAksesKuisFile')->name('kuis.jawab.patch');
    Route::delete('/kuis/{setkuis}/delete/{id}', 'KuisController@deleteAksesKuisFile')->name('kuis.jawab.delete');
    Route::post('/kuis/{setkuis}/jawab/action','KuisController@jawabAksesKuis')->name('kuis.jawab.action');
    Route::get('/kuis/{kuis}/set-kuis','KuisController@cek_akses_set_kuis')->name('kuis.akses_set_kuis');
    Route::get('/kuis/{kuis}/set-kuis/json','KuisController@cek_akses_set_kuis_json')->name('kuis.akses_set_kuis_json');

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
