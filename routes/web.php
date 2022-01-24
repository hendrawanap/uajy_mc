<?php

use Illuminate\Support\Facades\Route;

Route::get('/config-clear',function() {
    Artisan::call("config:cache");
    Artisan::call("config:clear");
    echo Artisan::output();
});
Auth::routes(['register' => false]);


Route::get('/', 'HomeController@index')->name('home');
Route::group(['middleware' => ['auth','check_peserta']], function () {
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
    Route::get('/kuis/{kuis}/jadwal/delete','KuisController@setKuisDelete')->name('jadwal.delete');
    Route::get('/kuis/{setkuis}/jadwal/edit','KuisController@setKuisEdit')->name('jadwal.edit');
    Route::get('/kuis/{kuis}/jadwal/json','KuisController@setKuisJson')->name('jadwal.json');

    Route::get('/kuis/list','KuisController@aksesKuis')->name('kuis.jawab.list');
    Route::get('/kuis/list/nilai','KuisController@history_nilai')->name('kuis.jawab.list.nilai');
    Route::get('/kuis/list/nilai/json','KuisController@history_nilai_json')->name('kuis.jawab.list.nilai_json');

    Route::get('/kuis/{setkuis}/show','KuisController@showAksesKuis')->name('kuis.jawab.show');
    Route::get('/kuis/ajax/{type}','KuisController@ajaxAksesKuis')->name('kuis.jawab.ajax');
    Route::post('/kuis/{setkuis}/upload/{id}', 'KuisController@uploadAksesKuisFile')->name('kuis.jawab.upload');
    Route::delete('/kuis/{setkuis}/delete/{id}', 'KuisController@deleteAksesKuisFile')->name('kuis.jawab.delete');
    Route::post('/kuis/{setkuis}/jawab/action','KuisController@jawabAksesKuis')->name('kuis.jawab.action');
    Route::get('/kuis/{kuis}/set-kuis','KuisController@cek_akses_set_kuis')->name('kuis.akses_set_kuis');
    Route::get('/kuis/{kuis}/set-kuis/json','KuisController@cek_akses_set_kuis_json')->name('kuis.akses_set_kuis_json');

    Route::get('/kuis/{setkuis}/peserta-kuis','KuisController@cek_akses_peserta_kuis')->name('kuis.akses_peserta_kuis');
    Route::get('/kuis/{setkuis}/peserta-kuis/json','KuisController@cek_akses_peserta_kuis_json')->name('kuis.akses_peserta_kuis_json');
    Route::get('/kuis/{kuis_submit}/jawaban-kuis','KuisController@cek_akses_jawaban_kuis')->name('kuis.cek_akses_jawaban_kuis');
    Route::post('/kuis/{kuis_submit}/update/nilai/kuis','KuisController@update_nilai_kuis')->name('kuis.update_nilai_kuis');

    Route::get('/event/json','EventController@json')->name('event.json');
    Route::get('/event/{event}/delete','EventController@destroy')->name('event.delete');

    Route::get('/event/{event}/peserta','EventController@event_peserta')->name('event.peserta');
    Route::get('/event/{event}/peserta/json','EventController@event_peserta_json')->name('event.peserta.json');
    Route::get('/event/{event}/peserta/show','EventController@event_peserta_show')->name('event.peserta.show');

    Route::get('/event/list','EventController@list')->name('event.list');
    Route::get('/event/{event}/submit','EventController@submit')->name('event.submit');
    Route::get('/event/{event}/submit/delete','EventController@submit_delete')->name('event.submit.delete');
    Route::get('/event/{event}/submit/json','EventController@submit_json')->name('event.submit.json');
    Route::post('/event/{event}/upload', 'KuisController@uploadAksesKuisFile')->name('kuis.jawab.upload');
    Route::delete('/event/{event}/delete', 'KuisController@deleteAksesKuisFile')->name('kuis.jawab.delete');
    Route::post('/event/{event}/submit/action','EventController@submit_action')->name('event.submit.action');
    
    Route::get('/event/{event}/delete','EventController@destroy')->name('event.delete');
    
    Route::resource('event','EventController');
});
Route::get('logout',function() {
    Auth::logout();
    return redirect('login')->with('success','Berhasil Logout !');
})->name('logout');
