<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlatformController;

# Auth
Route::get('/', [AuthController::class, 'login'])
    ->name('login.form');
Route::get('/register', [AuthController::class, 'register'])
    ->name('register.form');
Route::post('login', [AuthController::class, 'storeLogin'])
    ->name('login');
Route::post('register', [AuthController::class, 'storeRegister'])
    ->name('register');

# Platform
Route::name('platform.')->middleware('auth')->prefix('platform')->group(function () {
    Route::get('/', [PlatformController::class, 'index'])->name('index');
    Route::post('application', [PlatformController::class, 'store'])->name('application.store');
});

