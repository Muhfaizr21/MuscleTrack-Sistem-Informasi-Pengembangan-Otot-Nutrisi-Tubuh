<?php

use Illuminate\Support\Facades\Route;

// ========== AUTH ==========
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\GoogleRegisterController;

// ========== CORE ==========
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\ContactFormController;
use App\Http\Controllers\NewsArticleController;

// ========== TRAINER ==========
use App\Http\Controllers\Trainer\DashboardController as TrainerDashboardController;
use App\Http\Controllers\Trainer\LatihanController;
use App\Http\Controllers\Trainer\NutrisiController;
use App\Http\Controllers\Trainer\LaporanController;

// ========== USER ==========
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\UserProgressController;
use App\Http\Controllers\User\UserProteinController;
use App\Http\Controllers\User\UserWorkoutController;
use App\Http\Controllers\User\UserNutritionController;
use App\Http\Controllers\User\UserSummaryController;
use App\Http\Controllers\User\UserChatController;
use App\Http\Controllers\User\UserProfileController;
use App\Http\Controllers\User\UserArticleController;

/*
|--------------------------------------------------------------------------
| 🌟 WEB ROUTES - MUSCLETRACK
|--------------------------------------------------------------------------
*/

// ==========================
// 🏠 Halaman Utama
// ==========================
Route::get('/', fn() => view('welcome'))->name('home');

// ==========================
// 🔐 AUTH ROUTES
// ==========================
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// 🔹 Google Auth
Route::get('login/google', [GoogleController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [GoogleController::class, 'handleGoogleCallback']);
Route::get('register/google', [GoogleRegisterController::class, 'redirectToGoogle'])->name('register.google');
Route::get('register/google/callback', [GoogleRegisterController::class, 'handleGoogleCallback']);
Route::get('register/google/role', [GoogleRegisterController::class, 'showRoleForm'])->name('register.role');
Route::post('register/google/role', [GoogleRegisterController::class, 'storeRole'])->name('register.role.store');

// ==========================
// 🧭 Dashboard umum (auth + verified)
// ==========================
Route::get('/dashboard', fn() => view('dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// ==========================
// 🧑‍💼 ROLE: ADMIN
// ==========================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::resource('users', UserManagementController::class);
    });

// ==========================
// 🧑‍🏫 ROLE: TRAINER
// ==========================
Route::middleware(['auth', 'role:trainer'])
    ->prefix('trainer')
    ->name('trainer.')
    ->group(function () {
        Route::get('/dashboard', [TrainerDashboardController::class, 'index'])->name('dashboard');
        Route::resource('latihan', LatihanController::class);
        Route::resource('nutrisi', NutrisiController::class);
        Route::resource('laporan', LaporanController::class);
    });

// ==========================
// 🧍 ROLE: USER
// ==========================
Route::middleware(['auth', 'role:user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        // 🏠 Dashboard utama
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

        // 📈 Modul user
        Route::resource('progress', UserProgressController::class);
        Route::resource('protein', UserProteinController::class);
        Route::resource('workouts', UserWorkoutController::class);
        Route::resource('nutrition', UserNutritionController::class);
        Route::resource('weekly-summary', UserSummaryController::class)
            ->parameters(['weekly-summary' => 'summary']);
        Route::resource('chat', UserChatController::class);

        // 👤 Profile user (semua logika di UserProfileController)
        Route::get('profile', [UserProfileController::class, 'index'])->name('profile.index');
        Route::get('profile/edit', [UserProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('profile/update', [UserProfileController::class, 'update'])->name('profile.update');
        Route::get('profile/password', [UserProfileController::class, 'editPassword'])->name('profile.password.edit');
        Route::patch('profile/password', [UserProfileController::class, 'updatePassword'])->name('profile.password.update');

        // 📰 Artikel user
        Route::get('/articles', [UserArticleController::class, 'index'])->name('articles.index');
        Route::get('/articles/{article}', [UserArticleController::class, 'show'])->name('articles.show');
    });

// ==========================
// 🌐 Rute Publik
// ==========================
Route::get('/articles', [NewsArticleController::class, 'index'])->name('public.articles.index');
Route::get('/articles/{article}', [NewsArticleController::class, 'show'])->name('public.articles.show');

// 📬 Kontak publik
Route::get('/contact', [ContactFormController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactFormController::class, 'store'])->name('contact.store');

// ==========================
// ⚙️ Default auth routes
// ==========================
require __DIR__ . '/auth.php';
