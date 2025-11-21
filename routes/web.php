<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ==========================
// 🔐 AUTH CONTROLLERS
// ==========================
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;

// ==========================
// 🌐 PUBLIC/CORE CONTROLLERS
// ==========================
use App\Http\Controllers\ContactFormController;
use App\Http\Controllers\NewsArticleController;
use App\Http\Controllers\PaymentController;

// ==========================
// 🧑‍💼 ADMIN CONTROLLERS
// ==========================
use App\Http\Controllers\Admin\{
    AdminController,
    UserManagementController,
    ArticleController,
    NutritionProgramController,
    TrainerMemberController,
    WorkoutPlanController,
    GoalController,
    BodyMetricController,
    NotificationBroadcasterController,
    ContactMessageController,
    ExerciseController,
    ProfileController,
    SettingsController,
    HelpSupportController,
    TrainerManagementController,
};

// ==========================
// 🧑‍🏫 TRAINER CONTROLLERS
// ==========================
use App\Http\Controllers\Trainer\{
    DashboardController as TrainerDashboardController,
    MemberController,
    ChatController as TrainerChatController,
    NotificationController as TrainerNotificationController,
    ProgramController,
    QualityController,
    NutritionManagementController,
    TrainerProfileController
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
    UserTrainingController,
    NotificationController as UserNotificationController
};

/*
|--------------------------------------------------------------------------
| 🌟 WEB ROUTES - MUSCLETRACK
|--------------------------------------------------------------------------
*/

// ==========================
// 🏠 HALAMAN UTAMA & AUTH
// ==========================
Route::get('/', fn() => view('welcome'))->name('home');

// ==========================
// 🏠 GOOGLE OAUTH ROUTES - FIXED
// ==========================
Route::controller(GoogleController::class)->group(function () {
    Route::get('auth/google', 'redirectToGoogle')->name('login.google');
    Route::get('auth/google/callback', 'handleGoogleCallback');
    Route::get('register/google/complete', 'showCompleteRegistrationForm')->name('register.google.complete');
    Route::post('register/google/complete', 'completeRegistration')->name('register.google.complete.store');
});

Route::controller(AuthenticatedSessionController::class)->group(function () {
    Route::get('/login', 'create')->name('login');
    Route::post('/login', 'store');
    Route::post('/logout', 'destroy')->name('logout');
});

// Password Reset Routes
Route::middleware('guest')->group(function () {
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

Route::view('/dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard');

// ==========================
// 🧑‍💼 ADMIN
// ==========================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Exercises Management
        Route::prefix('exercises')->name('exercises.')->group(function () {
            Route::get('/', [ExerciseController::class, 'index'])->name('index');
            Route::get('/create', [ExerciseController::class, 'create'])->name('create');
            Route::post('/', [ExerciseController::class, 'store'])->name('store');
            Route::get('/{exercise}/edit', [ExerciseController::class, 'edit'])->name('edit');
            Route::put('/{exercise}', [ExerciseController::class, 'update'])->name('update');
            Route::delete('/{exercise}', [ExerciseController::class, 'destroy'])->name('destroy');
        });

        // Other Resources
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

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
        Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
        Route::get('/help-support', [HelpSupportController::class, 'index'])->name('help-support.index');

        // Trainer Management
        Route::prefix('trainers')->name('trainers.')->group(function () {
            Route::get('/', [TrainerManagementController::class, 'index'])->name('index');
            Route::get('/{trainer}', [TrainerManagementController::class, 'show'])->name('show');
            Route::get('/{trainer}/verification', [TrainerManagementController::class, 'editVerification'])->name('verification.edit');
            Route::put('/{trainer}/verification', [TrainerManagementController::class, 'updateVerification'])->name('verification.update');
            Route::put('/{trainer}/toggle-status', [TrainerManagementController::class, 'toggleStatus'])->name('toggle-status');
            Route::delete('/{trainer}', [TrainerManagementController::class, 'destroy'])->name('destroy');
        });
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

        // Trainer Profile Routes
        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/', [TrainerProfileController::class, 'index'])->name('index');
            Route::get('/edit', [TrainerProfileController::class, 'edit'])->name('edit');
            Route::post('/update', [TrainerProfileController::class, 'update'])->name('update');
            Route::post('/password', [TrainerProfileController::class, 'updatePassword'])->name('password.update');
            Route::post('/settings', [TrainerProfileController::class, 'updateSettings'])->name('settings.update');
            Route::delete('/avatar', [TrainerProfileController::class, 'deleteAvatar'])->name('avatar.delete');
        });

        Route::prefix('communication')->name('communication.')->group(function () {
            Route::get('/chat', [TrainerChatController::class, 'index'])->name('chat.index');
            Route::post('/chat', [TrainerChatController::class, 'store'])->name('chat.store');
            Route::delete('/chat/{id}', [TrainerChatController::class, 'destroy'])->name('chat.destroy');
            Route::post('/chat/read', [TrainerChatController::class, 'markAllRead'])->name('chat.markAllRead');

            // Trainer Notifications
            Route::get('/notifications', [TrainerNotificationController::class, 'index'])->name('notifications.index');
            Route::post('/notifications/{id}/read', [TrainerNotificationController::class, 'markAsRead'])->name('notifications.read');
            Route::post('/notifications/mark-all-read', [TrainerNotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
            Route::delete('/notifications/{id}', [TrainerNotificationController::class, 'destroy'])->name('notifications.destroy');
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

        // 🏋️ WORKOUT ACTIONS
        Route::post('/workout/{schedule}/start', [UserSummaryController::class, 'startWorkout'])->name('workout.start');
        Route::post('/workout/{schedule}/complete', [UserSummaryController::class, 'completeWorkout'])->name('workout.complete');

        // 💬 Chat
        Route::prefix('chat')->name('chat.')->group(function () {
            Route::get('/', [UserChatController::class, 'index'])->name('index');
            Route::post('/', [UserChatController::class, 'store'])->name('store');
            Route::post('/read', [UserChatController::class, 'markAllRead'])->name('markAllRead');
            Route::delete('/{id}', [UserChatController::class, 'destroy'])->name('destroy');
            Route::post('/typing', [UserChatController::class, 'typing'])->name('typing');
        });

        // 🏋️ Training - FIXED VERSION
        Route::prefix('training')->name('training.')->group(function () {
            Route::get('/', [UserTrainingController::class, 'index'])->name('index');
            Route::get('/trainer/{trainerId}', [UserTrainingController::class, 'show'])->name('show');
            Route::post('/order/{trainerId}', [UserTrainingController::class, 'order'])->name('order');
            Route::get('/payment/{paymentId}', [UserTrainingController::class, 'payment'])->name('payment');

            // HAPUS DUPLIKASI INI:
            // Route::post('/process-payment/{trainerId}', [UserTrainingController::class, 'processPayment'])->name('process-payment');

            // INVOICE ROUTE - PASTIKAN ADA
            Route::get('/invoice/{paymentId}', [UserTrainingController::class, 'invoice'])->name('invoice');
            Route::get('/refresh-status/{paymentId}', [UserTrainingController::class, 'refreshPaymentStatus'])->name('refresh-status');

            // HANYA GUNAKAN SATU confirm-payment (GET method):
            Route::get('/confirm-payment/{paymentId}', [UserTrainingController::class, 'confirmPayment'])->name('confirm-payment');

            // HAPUS DUPLIKASI INI:
            // Route::post('/confirm/{paymentId}', [UserTrainingController::class, 'confirmPayment'])->name('confirm');

            Route::post('/cancel-order/{paymentId}', [UserTrainingController::class, 'cancelOrder'])->name('cancel-order');
            Route::get('/my-trainer', [UserTrainingController::class, 'myTrainer'])->name('my-trainer');
            Route::get('/switch-trainer', [UserTrainingController::class, 'showSwitchTrainer'])->name('switch-trainer');
            Route::post('/switch-trainer/{newTrainerId}', [UserTrainingController::class, 'switchTrainer'])->name('switch-trainer.process');
            Route::get('/rate/{trainerId}', [UserTrainingController::class, 'createRating'])->name('rate');
            Route::post('/rate/{trainerId}', [UserTrainingController::class, 'storeRating'])->name('rate.store');
            Route::put('/rating/{feedbackId}', [UserTrainingController::class, 'updateRating'])->name('rating.update');
            Route::get('/history', [UserTrainingController::class, 'trainerHistory'])->name('history');
            Route::get('/my-ratings', [UserTrainingController::class, 'myRatings'])->name('my-ratings');
            Route::post('/ai-chat', [UserTrainingController::class, 'chatAI'])->name('ai.chat');
            Route::post('/reset-ai-chat', [UserTrainingController::class, 'resetAIChatCount'])->name('reset-ai-chat');
        });

        // 👤 Profile
        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/', [UserProfileController::class, 'index'])->name('index');
            Route::get('/edit', [UserProfileController::class, 'edit'])->name('edit');
            Route::patch('/update', [UserProfileController::class, 'update'])->name('update');
            Route::put('/avatar', [UserProfileController::class, 'updateAvatar'])->name('avatar.update');
            Route::get('/password', [UserProfileController::class, 'editPassword'])->name('password.edit');
            Route::patch('/password', [UserProfileController::class, 'updatePassword'])->name('password.update');
        });

        // 📚 Artikel
        Route::get('/articles', [UserArticleController::class, 'index'])->name('articles.index');
        Route::get('/articles/{article}', [UserArticleController::class, 'show'])->name('articles.show');

        // 🔔 Notifikasi User
        Route::prefix('notifications')->name('notifications.')->group(function () {
            Route::get('/', [UserNotificationController::class, 'index'])->name('index');
            Route::post('/mark-all-read', [UserNotificationController::class, 'markAllRead'])->name('markAllRead');
            Route::delete('/clear-all', [UserNotificationController::class, 'clearAll'])->name('clearAll');
            Route::post('/{id}/read', [UserNotificationController::class, 'markAsRead'])->name('read');
            Route::delete('/{id}', [UserNotificationController::class, 'destroy'])->name('destroy');

            // API Routes for real-time features
            Route::get('/unread-count', [UserNotificationController::class, 'getUnreadCount'])->name('unreadCount');
            Route::post('/{id}/read-ajax', [UserNotificationController::class, 'markAsReadAjax'])->name('readAjax');
            Route::get('/filter', [UserNotificationController::class, 'filter'])->name('filter');

            // Reminder Routes
            Route::post('/reminder-preferences', [UserNotificationController::class, 'saveReminderPreferences'])->name('reminder-preferences');
            Route::post('/toggle-reminder', [UserNotificationController::class, 'toggleQuickReminder'])->name('toggle-reminder');
            Route::post('/test-reminder', [UserNotificationController::class, 'testReminder'])->name('test-reminder');

            // Push Notification Routes
            Route::post('/test-push', [UserNotificationController::class, 'testPushNotification'])->name('testPush');
            Route::post('/fcm-token', [UserNotificationController::class, 'storeFCMToken'])->name('storeFCMToken');
            Route::delete('/fcm-token', [UserNotificationController::class, 'removeFCMToken'])->name('removeFCMToken');
            Route::get('/devices', [UserNotificationController::class, 'getUserDevices'])->name('devices');
            Route::post('/push-preferences', [UserNotificationController::class, 'savePushPreferences'])->name('push-preferences');
        });
    });

// ==========================
// 🌐 RUTE PUBLIK (DILUAR LOGIN)
// ==========================
Route::get('/articles_publik', [NewsArticleController::class, 'index'])->name('public.articles.index');
Route::get('/articles_publik/{article:slug}', [NewsArticleController::class, 'show'])->name('public.articles.show');

Route::get('/contact', [ContactFormController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactFormController::class, 'store'])->name('contact.store');

// ==========================
// 💳 PAYMENT MIDTRANS - FIXED
// ==========================

// Route callback HARUS di luar auth middleware
Route::post('/midtrans/callback', [PaymentController::class, 'callback'])->name('midtrans.callback');

// Route dengan auth middleware
Route::middleware('auth')->group(function () {
    Route::post('/payment/create', [PaymentController::class, 'createPayment'])->name('payment.create');
});
// TEST ROUTE - Hapus setelah selesai
Route::get('/test-midtrans', function () {
    return [
        'server_key' => config('midtrans.server_key'),
        'client_key' => config('midtrans.client_key'),
        'is_production' => config('midtrans.is_production'),
        'merchant_id' => config('midtrans.merchant_id'),
        'all_midtrans_config' => config('midtrans')
    ];
});

// ==========================
// ⚙️ AUTH LARAVEL DEFAULT
// ==========================
require __DIR__ . '/auth.php';
