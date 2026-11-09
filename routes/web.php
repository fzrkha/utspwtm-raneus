<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\MuridController;

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

        Route::resource('/admin/murid', MuridController::class)->names('admin.murid');
    });

    Route::middleware(['cekUser:gurubk'])->group(function () {
        Route::get('/guru', [GuruController::class, 'index']);

        Route::resource('/guru/murid', MuridController::class)->names('guru.murid');
    });
});