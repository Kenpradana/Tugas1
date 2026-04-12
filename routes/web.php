<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\PoliController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

route::get('/login', [AuthController::class, 'showLogin'])->name('login');
route::post('/login', [AuthController::class, 'login']);
route::get('/register', [AuthController::class, 'showRegister'])->name('register');
route::post('/register', [AuthController::class, 'register']);
route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::resource('polis', PoliController::class);
});

Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->group(function () {
    Route::get('/dashboard', function () {
        return view('dokter.dashboard');
    })->name('dokter.dashboard');
});

Route::middleware(['auth', 'role:pasien'])->prefix('pasien')->group(function () {
    Route::get('/dashboard', function () {
        return view('pasien.dashboard');
    })->name('pasien.dashboard');
});

