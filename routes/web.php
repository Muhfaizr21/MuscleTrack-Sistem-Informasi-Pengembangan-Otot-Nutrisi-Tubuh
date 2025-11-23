<?php

use Illuminate\Support\Facades\Route;

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
    AdminCommunityController,
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
    NotificationController as UserNotificationController,
    UserCommunityController,
    UserCommunityPostController,
    UserCommunityCommentController,
    UserCommunityLikeController
};

/*
|----------------------------------------------------------------------
| 🌟 WEB ROUTES - MUSCLETRACK
|----------------------------------------------------------------------
*/

// ==========================
// 🏠 HALAMAN UTAMA
// ==========================
Route::get('/', fn() => view('welcome'))->name('home');


// ==========================
// 🏠 GOOGLE OAUTH ROUTES (FINAL)
// ==========================
Route::controller(GoogleController::class)->group(function () {

    // LOGIN GOOGLE
    Route::get('auth/google', 'redirectToGoogle')->name('login.google');
    Route::get('auth/google/callback', 'handleGoogleCallback');

    // REGISTER VIA GOOGLE (FIXED)
    Route::get('/register/google', 'redirectToGoogle')->name('register.google');

    // COMPLETE REGISTRATION FORM
    Route::get('register/google/complete', 'showCompleteRegistrationForm')->name('register.google.complete');
    Route::post('register/google/complete', 'completeRegistration')->name('register.google.complete.store');
});


// ==========================
// 🔐 AUTH (LOGIN, LOGOUT, FORGOT PASSWORD)
// ==========================
Route::controller(AuthenticatedSessionController::class)->group(function () {
    Route::get('/login', 'create')->name('login');
    Route::post('/login', 'store');
    Route::post('/logout', 'destroy')->name('logout');
});

// Forgot Password
Route::middleware('guest')->group(function () {
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});


// ==========================
// 🧑‍💼 ADMIN ROUTES
// ==========================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Exercises
        Route::resource('exercises', ExerciseController::class);

        // Other CRUD Resources
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

        // Notifications Broadcast
        Route::get('broadcast', [NotificationBroadcasterController::class, 'index'])->name('broadcast.index');
        Route::post('broadcast', [NotificationBroadcasterController::class, 'store'])->name('broadcast.store');

        // Contact Messages
        Route::get('contact-messages', [ContactMessageController::class, 'index'])->name('contact.index');
        Route::get('contact-messages/{id}', [ContactMessageController::class, 'show'])->name('contact.show');
        Route::delete('contact-messages/{id}', [ContactMessageController::class, 'destroy'])->name('contact.destroy');

        // Settings, Profile & Support
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

        Route::prefix('communities')->name('communities.')->group(function () {
            Route::get('/', [AdminCommunityController::class, 'index'])->name('index');
            Route::get('/dashboard', [AdminCommunityController::class, 'dashboard'])->name('dashboard');
            Route::get('/reports', [AdminCommunityController::class, 'reports'])->name('reports');
            Route::get('/statistics', [AdminCommunityController::class, 'statistics'])->name('statistics');
              Route::get('/{community}', [AdminCommunityController::class, 'show'])->name('show');
            Route::get('/activity', [AdminCommunityController::class, 'activity'])->name('activity');
            Route::delete('/{community}', [AdminCommunityController::class, 'destroy'])->name('destroy');
            Route::delete('/posts/{post}', [AdminCommunityController::class, 'destroyPost'])->name('posts.destroy');

        });
    });


// ==========================
// 🧑‍🏫 TRAINER ROUTES
// ==========================
Route::middleware(['auth', 'role:trainer'])
    ->prefix('trainer')
    ->name('trainer.')
    ->group(function () {

        Route::get('/dashboard', [TrainerDashboardController::class, 'index'])->name('dashboard');

        // Members
        Route::prefix('members')->name('members.')->group(function () {
            Route::get('/', [MemberController::class, 'index'])->name('index');
            Route::get('/{member}', [MemberController::class, 'show'])->name('show');
            Route::post('/{member}/update-progress', [MemberController::class, 'updateProgress'])->name('updateProgress');
            Route::get('/{id}/real-time-status', [MemberController::class, 'getRealTimeStatus'])->name('real-time-status');
            Route::delete('/{id}/remove', [MemberController::class, 'removeExpiredMember'])->name('remove');
            Route::post('/check-status', [MemberController::class, 'checkAllMembersStatus'])->name('check-status');
        });

        // Profile
        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/', [TrainerProfileController::class, 'index'])->name('index');
            Route::get('/edit', [TrainerProfileController::class, 'edit'])->name('edit');
            Route::post('/update', [TrainerProfileController::class, 'update'])->name('update');
            Route::post('/password', [TrainerProfileController::class, 'updatePassword'])->name('password.update');
            Route::post('/settings', [TrainerProfileController::class, 'updateSettings'])->name('settings.update');
            Route::delete('/avatar', [TrainerProfileController::class, 'deleteAvatar'])->name('avatar.delete');
        });

        // Communication
        Route::prefix('communication')->name('communication.')->group(function () {
            // Chat Routes
            Route::get('/chat', [TrainerChatController::class, 'index'])->name('chat.index');
            Route::post('/chat', [TrainerChatController::class, 'store'])->name('chat.store');
            Route::delete('/chat/{id}', [TrainerChatController::class, 'destroy'])->name('chat.destroy');
            Route::post('/chat/read', [TrainerChatController::class, 'markAllRead'])->name('chat.markAllRead');

            // Notifications
            Route::get('/notifications', [TrainerNotificationController::class, 'index'])->name('notifications.index');
            Route::post('/notifications/{id}/read', [TrainerNotificationController::class, 'markAsRead'])->name('notifications.read');
            Route::post('/notifications/mark-all-read', [TrainerNotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
            Route::delete('/notifications/{id}', [TrainerNotificationController::class, 'destroy'])->name('notifications.destroy');
        });

        // Programs
        Route::prefix('programs')->name('programs.')->group(function () {
            Route::get('/', [ProgramController::class, 'index'])->name('index');
            Route::get('/create', [ProgramController::class, 'create'])->name('create');
            Route::post('/', [ProgramController::class, 'store'])->name('store');
            Route::get('/{memberId}', [ProgramController::class, 'show'])->name('show');
            Route::get('/{memberId}/edit', [ProgramController::class, 'edit'])->name('edit');
            Route::patch('/{memberId}/update', [ProgramController::class, 'update'])->name('update');
            Route::delete('/{memberId}', [ProgramController::class, 'destroy'])->name('destroy');
            Route::get('/{memberId}/progress', [ProgramController::class, 'progress'])->name('progress');
            Route::get('/{memberId}/progress/create', [ProgramController::class, 'createProgress'])->name('progress.create');
            Route::post('/{memberId}/progress', [ProgramController::class, 'storeProgress'])->name('progress.store');

            // Nutrition Routes
            Route::prefix('{memberId}/nutrition')->name('nutrition.')->group(function () {
                Route::get('/', [NutritionManagementController::class, 'index'])->name('index');
                Route::get('/create', [NutritionManagementController::class, 'create'])->name('create');
                Route::post('/', [NutritionManagementController::class, 'store'])->name('store');
                Route::get('/{planId}/edit', [NutritionManagementController::class, 'edit'])->name('edit');
                Route::patch('/{planId}', [NutritionManagementController::class, 'update'])->name('update');
                Route::delete('/{planId}', [NutritionManagementController::class, 'destroy'])->name('destroy');

                Route::post('/supplements', [NutritionManagementController::class, 'storeSupplement'])->name('supplement.store');
                Route::delete('/supplements/{supplementId}', [NutritionManagementController::class, 'destroySupplement'])->name('supplement.destroy');

                Route::get('/analysis', [NutritionManagementController::class, 'analysis'])->name('analysis');

                Route::post('/{planId}/recommend', [NutritionManagementController::class, 'recommend'])->name('recommend');
                Route::post('/{planId}/unrecommend', [NutritionManagementController::class, 'unrecommend'])->name('unrecommend');
            });

            Route::post('/{memberId}/progress-note', [ProgramController::class, 'storeProgressNote'])->name('progress.note.store');

            // Program Registration
            Route::get('/daftar', [ProgramController::class, 'daftar'])->name('daftar');
            Route::post('/daftar', [ProgramController::class, 'ajukan'])->name('ajukan');
        });

        // ✅ TAMBAHKAN: Nutrition Routes Standar (di LUAR group programs agar tidak butuh memberId)
        Route::prefix('nutrition')->name('nutrition.')->group(function () {
            Route::get('/dashboard', [NutritionManagementController::class, 'dashboard'])->name('dashboard');
            Route::get('/create/{memberId}', [NutritionManagementController::class, 'create'])->name('create');
            Route::post('/store/{memberId}', [NutritionManagementController::class, 'store'])->name('store');
            Route::get('/{memberId}', [NutritionManagementController::class, 'index'])->name('index');
            Route::get('/{memberId}/analysis', [NutritionManagementController::class, 'analysis'])->name('analysis');
            Route::get('/{memberId}/edit/{planId}', [NutritionManagementController::class, 'edit'])->name('edit');
            Route::patch('/{memberId}/update/{planId}', [NutritionManagementController::class, 'update'])->name('update');
            Route::delete('/{memberId}/destroy/{planId}', [NutritionManagementController::class, 'destroy'])->name('destroy');
            Route::post('/{memberId}/supplements', [NutritionManagementController::class, 'storeSupplement'])->name('supplement.store');
            Route::delete('/{memberId}/supplements/{supplementId}', [NutritionManagementController::class, 'destroySupplement'])->name('supplement.destroy');
        });

        // Quality
        Route::prefix('quality')->name('quality.')->group(function () {
    Route::get('/verification-status', [QualityController::class, 'showVerificationStatus'])->name('verification.status');
    Route::get('/feedback', [QualityController::class, 'feedbackIndex'])->name('feedback');
    Route::post('/feedback', [QualityController::class, 'sendFeedback'])->name('feedback.store');
    Route::get('/ratings', [QualityController::class, 'showRatings'])->name('ratings');
});
    });// <- TUTUP GROUP TRAINER YANG TERTINGGAL

// ==========================
// 🧍 USER ROUTES
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

        // Start/Complete workout
        Route::post('/workout/{schedule}/start', [UserSummaryController::class, 'startWorkout'])->name('workout.start');
        Route::post('/workout/{schedule}/complete', [UserSummaryController::class, 'completeWorkout'])->name('workout.complete');

        // Chat
        Route::prefix('chat')->name('chat.')->group(function () {
            Route::get('/', [UserChatController::class, 'index'])->name('index');
            Route::post('/', [UserChatController::class, 'store'])->name('store');
            Route::post('/read', [UserChatController::class, 'markAllRead'])->name('markAllRead');
            Route::delete('/{id}', [UserChatController::class, 'destroy'])->name('destroy');
            Route::post('/typing', [UserChatController::class, 'typing'])->name('typing');
        });

        // Training
        Route::prefix('training')->name('training.')->group(function () {
            Route::get('/', [UserTrainingController::class, 'index'])->name('index');
            Route::get('/trainer/{trainerId}', [UserTrainingController::class, 'show'])->name('show');
            Route::post('/order/{trainerId}', [UserTrainingController::class, 'order'])->name('order');
            Route::get('/payment/{paymentId}', [UserTrainingController::class, 'payment'])->name('payment');

            Route::get('/invoice/{paymentId}', [UserTrainingController::class, 'invoice'])->name('invoice');
            Route::get('/refresh-status/{paymentId}', [UserTrainingController::class, 'refreshPaymentStatus'])->name('refresh-status');

            Route::get('/confirm-payment/{paymentId}', [UserTrainingController::class, 'confirmPayment'])->name('confirm-payment');
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

        // Profile
        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/', [UserProfileController::class, 'index'])->name('index');
            Route::get('/edit', [UserProfileController::class, 'edit'])->name('edit');
            Route::patch('/update', [UserProfileController::class, 'update'])->name('update');
            Route::put('/avatar', [UserProfileController::class, 'updateAvatar'])->name('avatar.update');
            Route::get('/password', [UserProfileController::class, 'editPassword'])->name('password.edit');
            Route::patch('/password', [UserProfileController::class, 'updatePassword'])->name('password.update');
        });

        // User Articles
        Route::get('/articles', [UserArticleController::class, 'index'])->name('articles.index');
        Route::get('/articles/{article}', [UserArticleController::class, 'show'])->name('articles.show');

        // Notifications
        Route::prefix('notifications')->name('notifications.')->group(function () {
            Route::get('/', [UserNotificationController::class, 'index'])->name('index');
            Route::post('/mark-all-read', [UserNotificationController::class, 'markAllRead'])->name('markAllRead');
            Route::delete('/clear-all', [UserNotificationController::class, 'clearAll'])->name('clearAll');
            Route::post('/{id}/read', [UserNotificationController::class, 'markAsRead'])->name('read');
            Route::delete('/{id}', [UserNotificationController::class, 'destroy'])->name('destroy');

            Route::get('/unread-count', [UserNotificationController::class, 'getUnreadCount'])->name('unreadCount');
            Route::post('/{id}/read-ajax', [UserNotificationController::class, 'markAsReadAjax'])->name('readAjax');
            Route::get('/filter', [UserNotificationController::class, 'filter'])->name('filter');

            Route::post('/reminder-preferences', [UserNotificationController::class, 'saveReminderPreferences'])->name('reminder-preferences');
            Route::post('/toggle-reminder', [UserNotificationController::class, 'toggleQuickReminder'])->name('toggle-reminder');
            Route::post('/test-reminder', [UserNotificationController::class, 'testReminder'])->name('test-reminder');

            Route::post('/test-push', [UserNotificationController::class, 'testPushNotification'])->name('testPush');
            Route::post('/fcm-token', [UserNotificationController::class, 'storeFCMToken'])->name('storeFCMToken');
            Route::delete('/fcm-token', [UserNotificationController::class, 'removeFCMToken'])->name('removeFCMToken');
            Route::get('/devices', [UserNotificationController::class, 'getUserDevices'])->name('devices');
            Route::post('/push-preferences', [UserNotificationController::class, 'savePushPreferences'])->name('push-preferences');
        });

        // ==========================
        // 👥 COMMUNITY
        // ==========================
        Route::prefix('communities')->name('communities.')->group(function () {

            Route::get('/', [UserCommunityController::class, 'index'])->name('index');
            Route::get('/create', [UserCommunityController::class, 'create'])->name('create');
            Route::post('/', [UserCommunityController::class, 'store'])->name('store');
            Route::get('/{community}', [UserCommunityController::class, 'show'])->name('show');
            Route::get('/{community}/edit', [UserCommunityController::class, 'edit'])->name('edit');
            Route::put('/{community}', [UserCommunityController::class, 'update'])->name('update');
            Route::delete('/{community}', [UserCommunityController::class, 'destroy'])->name('destroy');

            // Membership
            Route::post('/{community}/join', [UserCommunityController::class, 'join'])->name('join');
            Route::post('/{community}/leave', [UserCommunityController::class, 'leave'])->name('leave');

            // Posts
            Route::post('/{community}/posts', [UserCommunityPostController::class, 'store'])->name('posts.store');
            Route::put('/posts/{post}', [UserCommunityPostController::class, 'update'])->name('posts.update');
            Route::delete('/posts/{post}', [UserCommunityPostController::class, 'destroy'])->name('posts.destroy');

            // Comments
            Route::post('/posts/{post}/comments', [UserCommunityCommentController::class, 'store'])->name('posts.comments.store');
            Route::put('/comments/{comment}', [UserCommunityCommentController::class, 'update'])->name('posts.comments.update');
            Route::delete('/comments/{comment}', [UserCommunityCommentController::class, 'destroy'])->name('posts.comments.destroy');

            // Likes
            Route::post('/posts/{post}/like', [UserCommunityLikeController::class, 'store'])->name('posts.like');
            Route::post('/comments/{comment}/like', [UserCommunityLikeController::class, 'commentLike'])->name('comments.like');
        });
    });


// ==========================
// 🌐 PUBLIC ROUTES
// ==========================
Route::get('/articles_publik', [NewsArticleController::class, 'index'])->name('public.articles.index');
Route::get('/articles_publik/{article:slug}', [NewsArticleController::class, 'show'])->name('public.articles.show');

Route::get('/articles', [NewsArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{article}', [NewsArticleController::class, 'show'])->name('articles.show');

Route::get('/contact', [ContactFormController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactFormController::class, 'store'])->name('contact.store');


// ==========================
// 💳 PAYMENT MIDTRANS
// ==========================
Route::middleware('auth')->group(function () {
    Route::post('/payment/create', [PaymentController::class, 'createPayment'])->name('payment.create');
});

Route::get('/test-midtrans', function () {
    return [
        'server_key'   => config('midtrans.server_key'),
        'client_key'   => config('midtrans.client_key'),
        'is_production'=> config('midtrans.is_production'),
        'merchant_id'  => config('midtrans.merchant_id'),
        'all_midtrans_config' => config('midtrans')
    ];
});


// ==========================
// ⚙️ LARAVEL DEFAULT AUTH
// ==========================
require __DIR__.'/auth.php';
