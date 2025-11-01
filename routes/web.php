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
use App\Http\Controllers\Admin\ArticleController;

// ========== TRAINER ==========
use App\Http\Controllers\Trainer\DashboardController as TrainerDashboardController;
use App\Http\Controllers\Trainer\MemberController;
use App\Http\Controllers\Trainer\ChatController;
use App\Http\Controllers\Trainer\NotificationController;
use App\Http\Controllers\Trainer\ProgramController;
use App\Http\Controllers\Trainer\SupplementController;
use App\Http\Controllers\Trainer\QualityController;

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
// 🧭 Dashboard umum
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
        Route::resource('articles', ArticleController::class);
    });

// ==========================
// 🧑‍🏫 ROLE: TRAINER
// ==========================
Route::middleware(['auth', 'role:trainer'])
    ->prefix('trainer')
    ->name('trainer.')
    ->group(function () {
        // 🏠 Dashboard
        Route::get('/dashboard', [TrainerDashboardController::class, 'index'])->name('dashboard');

        // 1️⃣ MEMBER MANAGEMENT
        Route::prefix('members')->name('members.')->group(function () {
            Route::get('/', [MemberController::class, 'index'])->name('index');
            Route::get('/{member}', [MemberController::class, 'show'])->name('show');
            Route::post('/{member}/update-progress', [MemberController::class, 'updateProgress'])->name('updateProgress');
        });

        // 2️⃣ COMMUNICATION
        Route::prefix('communication')->name('communication.')->group(function () {
            // 💬 Chat
            Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
            Route::get('/chat/{user}', [ChatController::class, 'show'])->name('chat.show');
            Route::post('/chat', [ChatController::class, 'store'])->name('chat.store');
            Route::post('/chat/read', [ChatController::class, 'markAllRead'])->name('chat.read');

            // 🔔 Notifications
            Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
            Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
        });

        // 3️⃣ PROGRAM & NUTRITION MANAGEMENT
        Route::prefix('programs')->name('programs.')->group(function () {
            Route::get('/{member}/edit', [ProgramController::class, 'edit'])->name('edit');
            Route::patch('/{member}/update', [ProgramController::class, 'update'])->name('update');
            Route::get('/daftar', [ProgramController::class, 'daftar'])->name('daftar');
            Route::post('/daftar', [ProgramController::class, 'ajukan'])->name('ajukan');



            // 💊 Supplements
            Route::get('/{member}/supplements', [SupplementController::class, 'index'])->name('supplements.index');
            Route::post('/{member}/supplements', [SupplementController::class, 'store'])->name('supplements.store');
        });

        // 4️⃣ TRAINER QUALITY & SUPPORT
        Route::prefix('quality')->name('quality.')->group(function () {
            Route::get('/verification-status', [QualityController::class, 'showVerificationStatus'])->name('verification.status');
            Route::get('/feedback', [QualityController::class, 'feedbackIndex'])->name('feedback.index');
            Route::post('/feedback', [QualityController::class, 'sendFeedback'])->name('feedback.store');
        });
    });

// ==========================
// 🧍 ROLE: USER
// ==========================
Route::middleware(['auth', 'role:user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
        Route::resource('progress', UserProgressController::class);
        Route::resource('protein', UserProteinController::class);
        Route::resource('workouts', UserWorkoutController::class);
        Route::resource('nutrition', UserNutritionController::class);
        Route::resource('weekly-summary', UserSummaryController::class)
            ->parameters(['weekly-summary' => 'summary']);

        Route::get('/chat', [UserChatController::class, 'index'])->name('chat.index');
        Route::post('/chat', [UserChatController::class, 'store'])->name('chat.store');
        Route::post('/chat/read', [UserChatController::class, 'markAllRead'])->name('chat.markAllRead');

        Route::get('profile', [UserProfileController::class, 'index'])->name('profile.index');
        Route::get('profile/edit', [UserProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('profile/update', [UserProfileController::class, 'update'])->name('profile.update');
        Route::get('profile/password', [UserProfileController::class, 'editPassword'])->name('profile.password.edit');
        Route::patch('profile/password', [UserProfileController::class, 'updatePassword'])->name('profile.password.update');

        Route::get('/articles', [UserArticleController::class, 'index'])->name('articles.index');
        Route::get('/articles/{article}', [UserArticleController::class, 'show'])->name('articles.show');
    });

// ==========================
// 🌐 Rute Publik
// ==========================
Route::get('/articles_publik', [NewsArticleController::class, 'index'])
     ->name('public.articles.index');

Route::get('/articles_publik/{article:slug}', [NewsArticleController::class, 'show'])
     ->name('public.articles.show');


// 📬 Kontak publik
Route::get('/contact', [ContactFormController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactFormController::class, 'store'])->name('contact.store');

// ==========================
// ⚙️ Default auth routes
// ==========================
require __DIR__ . '/auth.php';
