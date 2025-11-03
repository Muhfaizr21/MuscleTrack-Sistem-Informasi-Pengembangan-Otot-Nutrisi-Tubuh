<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // (Diperlukan untuk auth.php)

// ==========================
// 🔐 AUTH CONTROLLERS
// ==========================
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\GoogleRegisterController;

// ==========================
// 🌐 PUBLIC/CORE CONTROLLERS
// ==========================
use App\Http\Controllers\AdminController; // <-- DIPINDAH KE SINI (INI PERBAIKANNYA)
use App\Http\Controllers\ContactFormController;
use App\Http\Controllers\NewsArticleController;

// ==========================
// 🧑‍💼 ADMIN CONTROLLERS (Hanya yang di dalam folder Admin/)
// ==========================
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\NutritionProgramController;
use App\Http\Controllers\Admin\TrainerMemberController;
use App\Http\Controllers\Admin\WorkoutPlanController;
use App\Http\Controllers\Admin\GoalController;
use App\Http\Controllers\Admin\BodyMetricController;

// ==========================
// 🧑‍🏫 TRAINER CONTROLLERS
// ==========================
use App\Http\Controllers\Trainer\{
    DashboardController as TrainerDashboardController,
    MemberController,
    ChatController as TrainerChatController, // Beri alias agar tidak bentrok
    NotificationController,
    ProgramController,
    SupplementController,
    QualityController,
    NutritionManagementController
};

// ==========================
// 🧍 USER CONTROLLERS
// ==========================
use App\Http\Controllers\User\{
    UserDashboardController,
    UserProgressController,
    UserProteinController,
    UserWorkoutController,
    UserNutritionController,
    UserSummaryController,
    UserChatController,
    UserProfileController,
    UserArticleController
};

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
Route::controller(AuthenticatedSessionController::class)->group(function () {
    Route::get('/login', 'create')->name('login');
    Route::post('/login', 'store');
    Route::post('/logout', 'destroy')->name('logout');
});

Route::controller(GoogleController::class)->group(function () {
    Route::get('login/google', 'redirectToGoogle')->name('login.google');
    Route::get('login/google/callback', 'handleGoogleCallback');
});

Route::controller(GoogleRegisterController::class)->group(function () {
    Route::get('register/google', 'redirectToGoogle')->name('register.google');
    Route::get('register/google/callback', 'handleGoogleCallback');
    Route::get('register/google/role', 'showRoleForm')->name('register.role');
    Route::post('register/google/role', 'storeRole')->name('register.role.store');
});

// ==========================
// 🧭 Dashboard umum
// ==========================
Route::view('/dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// ==========================
// 🧑‍💼 ROLE: ADMIN
// ==========================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Rute ini sekarang akan menunjuk ke \App\Http\Controllers\AdminController (Benar)
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        Route::resources([
            'users' => UserManagementController::class,
            'articles' => ArticleController::class,
            'nutrition-programs' => NutritionProgramController::class,
            'goals' => GoalController::class,
            'workout-plans' => WorkoutPlanController::class,
            'body-metrics' => BodyMetricController::class,
        ]);

        Route::resource('trainer-memberships', TrainerMemberController::class)
            ->except(['show', 'edit', 'update']);
    });

// ==========================
// 🧑‍🏫 ROLE: TRAINER
// ==========================
Route::middleware(['auth', 'role:trainer'])
    ->prefix('trainer')
    ->name('trainer.')
    ->group(function () {

        Route::get('/dashboard', [TrainerDashboardController::class, 'index'])->name('dashboard');

        Route::prefix('members')->name('members.')->group(function () {
            Route::get('/', [MemberController::class, 'index'])->name('index');
            Route::get('/{member}', [MemberController::class, 'show'])->name('show');
            Route::post('/{member}/update-progress', [MemberController::class, 'updateProgress'])->name('updateProgress');
        });

        Route::prefix('communication')->name('communication.')->group(function () {
            Route::get('/chat', [TrainerChatController::class, 'index'])->name('chat.index');
            Route::post('/chat', [TrainerChatController::class, 'store'])->name('chat.store');
            Route::delete('/chat/{id}', [TrainerChatController::class, 'destroy'])->name('chat.destroy');
            Route::post('/chat/read', [TrainerChatController::class, 'markAllRead'])->name('chat.markAllRead');
            Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
            Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
        });

        Route::prefix('programs')->name('programs.')->group(function () {
            Route::get('/', [ProgramController::class, 'index'])->name('index');
            Route::get('/{memberId}/edit', [ProgramController::class, 'edit'])->name('edit');
            Route::patch('/{memberId}/update', [ProgramController::class, 'update'])->name('update');
            Route::prefix('nutrition')->name('nutrition.')->group(function () {
                Route::get('/{memberId}', [NutritionManagementController::class, 'index'])->name('index');
                Route::get('/{memberId}/edit', [NutritionManagementController::class, 'edit'])->name('edit');
                Route::post('/{memberId}/update', [NutritionManagementController::class, 'update'])->name('update');
                Route::delete('/{memberId}/supplement/{supplementId}', [NutritionManagementController::class, 'destroySupplement'])->name('supplement.destroy');
                Route::post('/{memberId}/supplement', [NutritionManagementController::class, 'storeSupplement'])->name('supplement.store');
            });
            Route::post('/{memberId}/progress-note', [ProgramController::class, 'storeProgressNote'])->name('progress.note.store');
            Route::get('/daftar', [ProgramController::class, 'daftar'])->name('daftar');
            Route::post('/daftar', [ProgramController::class, 'ajukan'])->name('ajukan');
        });

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

        Route::resources([
            'progress' => UserProgressController::class,
            'protein' => UserProteinController::class,
            'workouts' => UserWorkoutController::class,
            'nutrition' => UserNutritionController::class,
            'weekly-summary' => UserSummaryController::class,
        ]);

        Route::get('/chat', [UserChatController::class, 'index'])->name('chat.index');
        Route::post('/chat', [UserChatController::class, 'store'])->name('chat.store');
        Route::post('/chat/read', [UserChatController::class, 'markAllRead'])->name('chat.markAllRead');
        Route::delete('/chat/{id}', [UserChatController::class, 'destroy'])->name('user.chat.destroy');
        Route::get('/chat/refresh', [UserChatController::class, 'refresh'])->name('chat.refresh');
        Route::post('/chat/typing', [UserChatController::class, 'typing'])->name('chat.typing');



        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/', [UserProfileController::class, 'index'])->name('index');
            Route::get('/edit', [UserProfileController::class, 'edit'])->name('edit');
            Route::patch('/update', [UserProfileController::class, 'update'])->name('update');
            Route::get('/password', [UserProfileController::class, 'editPassword'])->name('password.edit');
            Route::patch('/password', [UserProfileController::class, 'updatePassword'])->name('password.update');
        });

        Route::get('/articles', [UserArticleController::class, 'index'])->name('articles.index');
        Route::get('/articles/{article}', [UserArticleController::class, 'show'])->name('articles.show');
    });

// ==========================
// 🌐 Rute Publik
// ==========================
Route::get('/articles_publik', [NewsArticleController::class, 'index'])->name('public.articles.index');
Route::get('/articles_publik/{article:slug}', [NewsArticleController::class, 'show'])->name('public.articles.show');

Route::get('/contact', [ContactFormController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactFormController::class, 'store'])->name('contact.store');

// ==========================
// ⚙️ Default Laravel Auth Routes
// ==========================
require __DIR__ . '/auth.php';
