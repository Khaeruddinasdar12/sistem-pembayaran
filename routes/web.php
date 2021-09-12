<?php

use Illuminate\Support\Facades\Route;
Auth::routes([
    'register' => false
]);

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/tagihan', 'TagihanController@index')->name('tagihan');
Route::get('/riwayat-tagihan', 'TagihanController@riwayat')->name('riwayat.tagihan');
Route::get('/profile', 'HomeController@profile')->name('profile');

Route::post('/ubah-password', 'HomeController@ubahPassword')->name('ubah.password');

Route::get('/pdf/{id}', 'TagihanController@pdf')->name('pdf');
Route::get('/pdf-test', function(){
    return view('user.pdf-test');
});

Route::prefix('admin')->group(function() {
    // AUTH
    Route::get('/login', 'Auth\AdminAuthController@getLogin')->name('admin.login');
    Route::post('/login', 'Auth\AdminAuthController@postLogin')->name('admin.submit.login');
    Route::post('/logout', 'Auth\AdminAuthController@postLogout')->name('admin.logout');
    Route::get('/profile', 'Admin\DashboardController@profile')->name('admin.profile');
    Route::post('/profile', 'Admin\DashboardController@updateProfile')->name('admin.profile');
    // END AUTH

    // DASHBOARD
    Route::get('/', 'Admin\DashboardController@index');
    Route::get('/dashboard', 'Admin\DashboardController@index')->name('admin.dashboard');
    // END DASHBOARD


    // USER
    Route::get('/inaktif-user', 'Admin\UserController@inaktifIndex')->name('user.inaktif');
    Route::get('/table-user-inaktif', 'Admin\UserController@tableInaktifUser')->name('table.user.inaktif');

    Route::get('/aktif-user', 'Admin\UserController@index')->name('user.index');
    Route::post('/aktif-user', 'Admin\UserController@store')->name('user.store');
    Route::get('/table-user-aktif', 'Admin\UserController@tableAktifUser')->name('table.user.aktif');

    Route::put('status-user/{id}', 'Admin\UserController@status')->name('user.status');
    Route::put('edit-user', 'Admin\UserController@update')->name('user.edit');
    // END USER

    // PENAGIHAN
    Route::get('/penagihan/{id}', 'Admin\PenagihanController@index')->name('penagihan.index');
    Route::post('/penagihan/{id}', 'Admin\PenagihanController@store')->name('penagihan.store');
    Route::put('/penagihan/{id}', 'Admin\PenagihanController@update')->name('penagihan.update');

    // MANAGE ADMIN
    Route::get('/manage-admin', 'Admin\ManageAdminController@index')->name('admin.index');
    Route::post('/manage-admin', 'Admin\ManageAdminController@store')->name('admin.store');

    Route::get('/table-admin', 'Admin\ManageAdminController@tableAdmin')->name('table.admin');

    // MANAGE PENAGIH
    Route::get('/manage-penagih', 'Admin\ManagePenagihController@index')->name('penagih.index');
    Route::post('/manage-penagih', 'Admin\ManagePenagihController@store')->name('penagih.store');

    Route::get('/table-penagih', 'Admin\ManagePenagihController@tablePenagih')->name('table.penagih');

    // LAPORAN
    Route::get('/laporan', 'Admin\LaporanController@index')->name('laporan');
    Route::post('/laporan-pdf', 'Admin\LaporanController@pdf')->name('laporan.pdf');
});
