<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Routes untuk aplikasi MuscleTrack: login/logout, dashboard per role, profil.
*/

// Halaman utama
Route::get('/', function () {
    return view('welcome');
});

// ==========================
// Auth Routes
// ==========================
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// ==========================
// Dashboard umum (auth + verified)
// ==========================
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ==========================
// Profil user (hanya user login)
// ==========================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==========================
// Dashboard per Role (menggunakan middleware role yang sudah dibuat)
// ==========================

// Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

// Trainer
Route::middleware(['auth', 'role:trainer'])->group(function () {
    Route::get('/trainer/dashboard', [TrainerController::class, 'index'])->name('trainer.dashboard');
});

// User
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
});

// ==========================
// Include Auth routes default
// ==========================
require __DIR__ . '/auth.php';
