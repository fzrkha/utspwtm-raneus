<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware('guest')->group(function () {
    Route::get('/', [SesiController::class, 'index'])->name('login');
    Route::post('/', [SesiController::class, 'login']);
});

Route::middleware(['auth'])->group(function() {
    Route::get('/logout', [SesiController::class, 'logout']);

    Route::middleware(['cekUser:administrasi'])->group(function () {
        Route::get('/admin', [AdminController::class, 'index']);
    });

    Route::middleware(['cekUser:gurubk'])->group(function () {
        Route::get('/guru', [GuruController::class, 'index']);
    });
});