<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\GoogleRegisterController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Trainer\DashboardController as TrainerDashboardController;
use App\Http\Controllers\Trainer\LatihanController;
use App\Http\Controllers\Trainer\NutrisiController;
use App\Http\Controllers\Trainer\LaporanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NewsArticleController;
use App\Http\Controllers\ContactFormController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserManagementController;

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

Route::get('login/google', [GoogleController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::get('register/google', [GoogleRegisterController::class, 'redirectToGoogle'])->name('register.google');
Route::get('register/google/callback', [GoogleRegisterController::class, 'handleGoogleCallback']);
Route::get('register/google/role', [GoogleRegisterController::class, 'showRoleForm'])->name('register.role');
Route::post('register/google/role', [GoogleRegisterController::class, 'storeRole'])->name('register.role.store');

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
// Dashboard per Role
// ==========================

// ----- Admin -----
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('users', UserManagementController::class);
});

// ----- Trainer -----
Route::middleware(['auth', 'role:trainer'])->prefix('trainer')->name('trainer.')->group(function () {
    Route::get('/dashboard', [TrainerDashboardController::class, 'index'])->name('dashboard');

    // Data Latihan
    Route::get('/latihan', [LatihanController::class, 'index'])->name('latihan.index');

    // Data Nutrisi
    Route::get('/nutrisi', [NutrisiController::class, 'index'])->name('nutrisi.index');

    // Laporan Peserta
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
});

// ----- User -----
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');
    // Tambahkan route user lainnya di sini
});

// ==========================
// Rute Publik
// ==========================

// Artikel
Route::get('/articles', [NewsArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{article}', [NewsArticleController::class, 'show'])->name('articles.show');

// Kontak
Route::get('/contact', [ContactFormController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactFormController::class, 'store'])->name('contact.store');

// Include default auth routes
require __DIR__ . '/auth.php';
