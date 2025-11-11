<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ==========================
// 🔐 AUTH CONTROLLERS
// ==========================
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\GoogleRegisterController;

// ==========================
// 🌐 PUBLIC/CORE CONTROLLERS
// ==========================
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactFormController;
use App\Http\Controllers\NewsArticleController;
use App\Http\Controllers\Admin\ContactMessageController;

// ==========================
// 🧑‍💼 ADMIN CONTROLLERS
// ==========================
use App\Http\Controllers\Admin\{
    UserManagementController,
    ArticleController,
    NutritionProgramController,
    TrainerMemberController,
    WorkoutPlanController,
    GoalController,
    BodyMetricController,
    NotificationBroadcasterController
};

// ==========================
// 🧑‍🏫 TRAINER CONTROLLERS
// ==========================
use App\Http\Controllers\Trainer\{
    DashboardController as TrainerDashboardController,
    MemberController,
    ChatController as TrainerChatController,
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
    UserArticleController,
    UserTrainingController
};
use App\Http\Controllers\User\NotificationController as UserNotificationController;

/*
|--------------------------------------------------------------------------
| 🌟 WEB ROUTES - MUSCLETRACK
|--------------------------------------------------------------------------
*/

// ==========================
// 🏠 Halaman Utama
// ==========================
Route::get('/', fn() => view('welcome'))->name('home');
Route::get('/auth/google/redirect', [GoogleController::class, 'redirect']);
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);

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
// 🧑‍💼 ADMIN
// ==========================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
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

        Route::get('broadcast', [NotificationBroadcasterController::class, 'index'])->name('broadcast.index');
        Route::post('broadcast', [NotificationBroadcasterController::class, 'store'])->name('broadcast.store');

        Route::get('/contact-messages', [ContactMessageController::class, 'index'])->name('contact.index');
        Route::get('/contact-messages/{id}', [ContactMessageController::class, 'show'])->name('contact.show');
        Route::delete('/contact-messages/{id}', [ContactMessageController::class, 'destroy'])->name('contact.destroy');
    });

// ==========================
// 🧑‍🏫 TRAINER
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
// 🧍 USER
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

        // 💬 Chat System
        Route::get('/chat', [UserChatController::class, 'index'])->name('chat.index');
        Route::post('/chat', [UserChatController::class, 'store'])->name('chat.store');
        Route::post('/chat/read', [UserChatController::class, 'markAllRead'])->name('chat.markAllRead');
        Route::delete('/chat/{id}', [UserChatController::class, 'destroy'])->name('chat.destroy');
        Route::post('/chat/typing', [UserChatController::class, 'typing'])->name('chat.typing');

        // 🏋️ Training: Cari & Pesan Trainer
        Route::get('/training', [UserTrainingController::class, 'index'])->name('training.index');
        Route::get('/training/{trainerId}', [UserTrainingController::class, 'show'])->name('training.show');
        Route::post('/training/{trainerId}/order', [UserTrainingController::class, 'order'])->name('training.order');
        Route::get('/training/payment/{paymentId}', [UserTrainingController::class, 'payment'])->name('training.payment');
        Route::post('/training/payment/{paymentId}/confirm', [UserTrainingController::class, 'confirmPayment'])->name('training.confirm');

        // 💬 Chat AI Trainer (limit 5 pesan)
        Route::post('/training/ai-chat', [UserTrainingController::class, 'chatAI'])->name('training.ai.chat');

        // 👤 Profile - DIPERBARUI DENGAN ROUTE AVATAR
        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/', [UserProfileController::class, 'index'])->name('index');
            Route::get('/edit', [UserProfileController::class, 'edit'])->name('edit');
            Route::patch('/update', [UserProfileController::class, 'update'])->name('update');
            Route::put('/avatar', [UserProfileController::class, 'updateAvatar'])->name('avatar.update'); // ROUTE BARU
            Route::get('/password', [UserProfileController::class, 'editPassword'])->name('password.edit');
            Route::patch('/password', [UserProfileController::class, 'updatePassword'])->name('password.update');
        });

        // 📚 Artikel & Notifikasi
        Route::get('/articles', [UserArticleController::class, 'index'])->name('articles.index');
        Route::get('/articles/{article}', [UserArticleController::class, 'show'])->name('articles.show');
        Route::get('/notifications', [UserNotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notifications/{id}/read', [UserNotificationController::class, 'markAsRead'])->name('notifications.read');

        // 🔄 Training Management - ROUTE BARU
        Route::get('/my-trainer', [UserTrainingController::class, 'myTrainer'])->name('training.my-trainer');
        Route::post('/switch-trainer', [UserTrainingController::class, 'switchTrainer'])->name('training.switch-trainer');
        Route::post('/cancel-order/{paymentId}', [UserTrainingController::class, 'cancelOrder'])->name('training.cancel-order');
        Route::post('/reset-ai-chat', [UserTrainingController::class, 'resetAIChatCount'])->name('training.reset-ai-chat');
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
