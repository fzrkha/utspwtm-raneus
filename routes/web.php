<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\MuridController;
use App\Http\Controllers\PelanggaranController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware('guest', 'noCache')->group(function () {
    Route::get('/', [SesiController::class, 'index'])->name('login');
    Route::post('/', [SesiController::class, 'login']);
});

Route::middleware(['auth', 'noCache'])->group(function() {
    Route::get('/logout', [SesiController::class, 'logout']);

    Route::middleware(['cekUser:administrasi'])->group(function () {
        Route::get('/admin', [AdminController::class, 'index']);

        Route::resource('/admin/pengguna', PenggunaController::class)->names('admin.pengguna');
        Route::resource('/admin/murid', MuridController::class)->names('admin.murid');
        Route::resource('/admin/pelanggaran', PelanggaranController::class)->names('admin.pelanggaran');
    });

    Route::middleware(['cekUser:gurubk'])->group(function () {
        Route::get('/guru', [GuruController::class, 'index']);

        Route::resource('/guru/murid', MuridController::class)->names('guru.murid');
        Route::resource('/guru/pelanggaran', PelanggaranController::class)->names('guru.pelanggaran');
    });
});