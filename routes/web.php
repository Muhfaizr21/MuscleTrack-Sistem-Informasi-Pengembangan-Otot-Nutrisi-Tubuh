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
use App\Http\Controllers\PublicArticleController;
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
    TrainerChatController as TrainerChatController,
    NotificationController as TrainerNotificationController,
    ProgramController,
    QualityController,
    NutritionManagementController,
    TrainerProfileController,
    TrainerCommunityController
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
// 🏠 HALAMAN UTAMA & PUBLIC ROUTES
// ==========================
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Public Articles - GUNAKAN SATU SET SAJA untuk menghindari duplikasi
Route::get('/articles', [PublicArticleController::class, 'index'])->name('public.articles.index');
Route::get('/articles/{slug}', [PublicArticleController::class, 'show'])->name('public.articles.show');

// Contact
Route::get('/contact', [ContactFormController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactFormController::class, 'store'])->name('contact.store');

// About us
Route::get('/about', function () {
    return view('about.about');
})->name('about');

// ==========================
// 🔐 AUTHENTICATION ROUTES
// ==========================

// Google OAuth
Route::controller(GoogleController::class)->group(function () {
    Route::get('auth/google', 'redirectToGoogle')->name('login.google');
    Route::get('auth/google/callback', 'handleGoogleCallback');
    Route::get('/register/google', 'redirectToGoogle')->name('register.google');
    Route::get('register/google/complete', 'showCompleteRegistrationForm')->name('register.google.complete');
    Route::post('register/google/complete', 'completeRegistration')->name('register.google.complete.store');
});

// Traditional Auth
Route::controller(AuthenticatedSessionController::class)->group(function () {
    Route::get('/login', 'create')->name('login');
    Route::post('/login', 'store');
    Route::post('/logout', 'destroy')->name('logout');
});

// Password Reset
Route::middleware('guest')->group(function () {
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

// ==========================
// 💳 PAYMENT ROUTES
// ==========================
Route::middleware('auth')->group(function () {
    Route::post('/payment/create', [PaymentController::class, 'createPayment'])->name('payment.create');
});

// Payment Debug
Route::get('/test-midtrans', function () {
    return [
        'server_key'   => config('midtrans.server_key'),
        'client_key'   => config('midtrans.client_key'),
        'is_production' => config('midtrans.is_production'),
        'merchant_id'  => config('midtrans.merchant_id'),
        'all_midtrans_config' => config('midtrans')
    ];
});

// ==========================
// 🧑‍💼 ADMIN ROUTES
// ==========================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // CRUD Resources
        Route::resources([
            'users' => UserManagementController::class,
            'articles' => ArticleController::class,
            'exercises' => ExerciseController::class,
            'nutrition-programs' => NutritionProgramController::class,
            'goals' => GoalController::class,
            'workout-plans' => WorkoutPlanController::class,
            'body-metrics' => BodyMetricController::class,
        ]);

        // Trainer Memberships
        Route::resource('trainer-memberships', TrainerMemberController::class)
            ->except(['show', 'edit', 'update']);

        // Notifications
        Route::get('broadcast', [NotificationBroadcasterController::class, 'index'])->name('broadcast.index');
        Route::post('broadcast', [NotificationBroadcasterController::class, 'store'])->name('broadcast.store');

        // Contact Messages
        Route::get('contact-messages', [ContactMessageController::class, 'index'])->name('contact.index');
        Route::get('contact-messages/{id}', [ContactMessageController::class, 'show'])->name('contact.show');
        Route::delete('contact-messages/{id}', [ContactMessageController::class, 'destroy'])->name('contact.destroy');

        // Settings & Profile
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

        // Communities Management
        Route::prefix('communities')->name('communities.')->group(function () {
            Route::get('/', [AdminCommunityController::class, 'index'])->name('index');
            Route::get('/dashboard', [AdminCommunityController::class, 'dashboard'])->name('dashboard');
            Route::get('/reports', [AdminCommunityController::class, 'reports'])->name('reports');
            Route::get('/statistics', [AdminCommunityController::class, 'statistics'])->name('statistics');
            Route::get('/activity', [AdminCommunityController::class, 'activity'])->name('activity');
            Route::get('/{community}', [AdminCommunityController::class, 'show'])->name('show');

            // Community Actions
            Route::post('/{community}/suspend', [AdminCommunityController::class, 'suspend'])->name('suspend');
            Route::post('/{community}/activate', [AdminCommunityController::class, 'activate'])->name('activate');
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

        // Dashboard
        Route::get('/dashboard', [TrainerDashboardController::class, 'index'])->name('dashboard');
        // Members Management
        Route::prefix('members')->name('members.')->group(function () {
            Route::get('/', [MemberController::class, 'index'])->name('index');
            Route::get('/{member}', [MemberController::class, 'show'])->name('show');
            Route::post('/{member}/update-progress', [MemberController::class, 'updateProgress'])->name('updateProgress');
            Route::get('/{id}/real-time-status', [MemberController::class, 'getRealTimeStatus'])->name('real-time-status');
            Route::delete('/{id}/remove', [MemberController::class, 'removeExpiredMember'])->name('remove');
            Route::post('/check-status', [MemberController::class, 'checkAllMembersStatus'])->name('check-status');
        });

        // Profile Management
        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/', [TrainerProfileController::class, 'index'])->name('index');
            Route::get('/edit', [TrainerProfileController::class, 'edit'])->name('edit');
            Route::post('/update', [TrainerProfileController::class, 'update'])->name('update');
            Route::post('/password', [TrainerProfileController::class, 'updatePassword'])->name('password.update');
            Route::post('/settings', [TrainerProfileController::class, 'updateSettings'])->name('settings.update');
            Route::delete('/avatar', [TrainerProfileController::class, 'deleteAvatar'])->name('avatar.delete');
        });

        // Communication - PERBAIKAN: Hapus duplikat 'chat' dalam prefix
        Route::prefix('communication')->name('communication.')->group(function () {
            // Chat Routes - Fixed: menggunakan TrainerChatController dengan benar
            Route::prefix('chat')->name('chat.')->group(function () {
                Route::get('/', [TrainerChatController::class, 'index'])->name('index');
                Route::post('/', [TrainerChatController::class, 'store'])->name('store');
                Route::delete('/{id}', [TrainerChatController::class, 'destroy'])->name('destroy');
                Route::post('/mark-read', [TrainerChatController::class, 'markAllRead'])->name('markAllRead');

                // Debug routes (optional)
                Route::get('/debug', [TrainerChatController::class, 'debugReadStatus'])->name('debug');
                Route::get('/unread-count', [TrainerChatController::class, 'getUnreadCount'])->name('unreadCount');
            });

            // Notifications
            Route::get('/notifications', [TrainerNotificationController::class, 'index'])->name('notifications.index');
            Route::post('/notifications/{id}/read', [TrainerNotificationController::class, 'markAsRead'])->name('notifications.read');
            Route::post('/notifications/mark-all-read', [TrainerNotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
            Route::delete('/notifications/{id}', [TrainerNotificationController::class, 'destroy'])->name('notifications.destroy');
        });

        // Programs Management
        Route::prefix('programs')->name('programs.')->group(function () {
            Route::get('/', [ProgramController::class, 'index'])->name('index');
            Route::get('/create', [ProgramController::class, 'create'])->name('create');
            Route::post('/', [ProgramController::class, 'store'])->name('store');
            Route::get('/{memberId}', [ProgramController::class, 'show'])->name('show');
            Route::get('/{memberId}/edit', [ProgramController::class, 'edit'])->name('edit');
            Route::patch('/{memberId}/update', [ProgramController::class, 'update'])->name('update');
            Route::delete('/{memberId}', [ProgramController::class, 'destroy'])->name('destroy');

            // Progress Tracking
            Route::get('/{memberId}/progress', [ProgramController::class, 'progress'])->name('progress');
            Route::get('/{memberId}/progress/create', [ProgramController::class, 'createProgress'])->name('progress.create');
            Route::post('/{memberId}/progress', [ProgramController::class, 'storeProgress'])->name('progress.store');
            Route::post('/{memberId}/progress-note', [ProgramController::class, 'storeProgressNote'])->name('progress.note.store');

            // Nutrition Management
            Route::prefix('{memberId}/nutrition')->name('nutrition.')->group(function () {
                Route::get('/', [NutritionManagementController::class, 'index'])->name('index');
                Route::get('/create', [NutritionManagementController::class, 'create'])->name('create');
                Route::post('/', [NutritionManagementController::class, 'store'])->name('store');
                Route::get('/{planId}/edit', [NutritionManagementController::class, 'edit'])->name('edit');
                Route::patch('/{planId}', [NutritionManagementController::class, 'update'])->name('update');
                Route::delete('/{planId}', [NutritionManagementController::class, 'destroy'])->name('destroy');

                // Supplements
                Route::post('/supplements', [NutritionManagementController::class, 'storeSupplement'])->name('supplement.store');
                Route::delete('/supplements/{supplementId}', [NutritionManagementController::class, 'destroySupplement'])->name('supplement.destroy');

                // Analysis & Recommendations
                Route::get('/analysis', [NutritionManagementController::class, 'analysis'])->name('analysis');
                Route::post('/{planId}/recommend', [NutritionManagementController::class, 'recommend'])->name('recommend');
                Route::post('/{planId}/unrecommend', [NutritionManagementController::class, 'unrecommend'])->name('unrecommend');
            });

            // Program Registration
            Route::get('/daftar', [ProgramController::class, 'daftar'])->name('daftar');
            Route::post('/daftar', [ProgramController::class, 'ajukan'])->name('ajukan');
        });

        // Standalone Nutrition Routes
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

        // Quality & Feedback
        Route::prefix('quality')->name('quality.')->group(function () {
            Route::get('/verification-status', [QualityController::class, 'showVerificationStatus'])->name('verification.status');
            Route::get('/feedback', [QualityController::class, 'feedbackIndex'])->name('feedback');
            Route::post('/feedback', [QualityController::class, 'sendFeedback'])->name('feedback.store');
            Route::get('/ratings', [QualityController::class, 'showRatings'])->name('ratings');
        });


        // ==========================
        // 🧑‍🏫 TRAINER COMMUNITY ROUTES
        // ==========================
        Route::prefix('communities')->name('communities.')->group(function () {
            // Main Community Routes
            Route::get('/', [TrainerCommunityController::class, 'index'])->name('index');
            Route::get('/create', [TrainerCommunityController::class, 'create'])->name('create');
            Route::post('/', [TrainerCommunityController::class, 'store'])->name('store');
            Route::get('/{community:slug}', [TrainerCommunityController::class, 'show'])->name('show');
            Route::get('/{community:slug}/edit', [TrainerCommunityController::class, 'edit'])->name('edit');
            Route::put('/{community:slug}', [TrainerCommunityController::class, 'update'])->name('update');
            Route::delete('/{community:slug}', [TrainerCommunityController::class, 'destroy'])->name('destroy');

            // Membership Management
            Route::post('/{community:slug}/join', [TrainerCommunityController::class, 'join'])->name('join');
            Route::post('/{community:slug}/leave', [TrainerCommunityController::class, 'leave'])->name('leave');

            // Members Management - GET untuk menampilkan halaman
            Route::get('/{community:slug}/members', [TrainerCommunityController::class, 'members'])->name('members');
            Route::get('/{community:slug}/members/{user}/role', [TrainerCommunityController::class, 'editRole'])->name('members.role');
            Route::post('/{community:slug}/members/{user}/role', [TrainerCommunityController::class, 'updateRole'])->name('members.role.update');

            // Members Management Actions - POST untuk aksi
            Route::post('/{community:slug}/members/{user}/approve', [TrainerCommunityController::class, 'approveMember'])->name('members.approve');
            Route::post('/{community:slug}/members/{user}/reject', [TrainerCommunityController::class, 'rejectMember'])->name('members.reject');
            Route::post('/{community:slug}/members/{user}/promote', [TrainerCommunityController::class, 'promoteMember'])->name('members.promote');
            Route::post('/{community:slug}/members/{user}/demote', [TrainerCommunityController::class, 'demoteMember'])->name('members.demote');
            Route::delete('/{community:slug}/members/{user}', [TrainerCommunityController::class, 'removeMember'])->name('members.remove');

            // Transfer Ownership
            Route::post('/{community:slug}/transfer-ownership/{user}', [TrainerCommunityController::class, 'transferOwnership'])->name('transfer-ownership');

            // Posts Management
            Route::post('/{community:slug}/posts', [TrainerCommunityController::class, 'storePost'])->name('posts.store');
            Route::put('/posts/{post}', [TrainerCommunityController::class, 'updatePost'])->name('posts.update');
            Route::delete('/posts/{post}', [TrainerCommunityController::class, 'destroyPost'])->name('posts.destroy');
            Route::post('/posts/{post}/like', [TrainerCommunityController::class, 'likePost'])->name('posts.like');
            Route::post('/posts/{post}/unlike', [TrainerCommunityController::class, 'unlikePost'])->name('posts.unlike');

            // Comments Management
            Route::post('/posts/{post}/comments', [TrainerCommunityController::class, 'storeComment'])->name('comments.store');
            Route::put('/comments/{comment}', [TrainerCommunityController::class, 'updateComment'])->name('comments.update');
            Route::delete('/comments/{comment}', [TrainerCommunityController::class, 'destroyComment'])->name('comments.destroy');
            Route::post('/comments/{comment}/like', [TrainerCommunityController::class, 'likeComment'])->name('comments.like');
            Route::post('/comments/{comment}/unlike', [TrainerCommunityController::class, 'unlikeComment'])->name('comments.unlike');
        });
    });

// ==========================
// 🧍 USER ROUTES
// ==========================
Route::middleware(['auth', 'role:user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

        // Resources
        Route::resources([
            'progress' => UserProgressController::class,
            'protein' => UserProteinController::class,
            'workouts' => UserWorkoutController::class,
            'nutrition' => UserNutritionController::class,
            'weekly-summary' => UserSummaryController::class,
        ]);

        // Workout Actions
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

        // Training & Trainer Management
        Route::prefix('training')->name('training.')->group(function () {
            Route::get('/', [UserTrainingController::class, 'index'])->name('index');
            Route::get('/trainer/{trainerId}', [UserTrainingController::class, 'show'])->name('show');
            Route::post('/order/{trainerId}', [UserTrainingController::class, 'order'])->name('order');
            Route::get('/payment/{paymentId}', [UserTrainingController::class, 'payment'])->name('payment');
            Route::get('/invoice/{paymentId}', [UserTrainingController::class, 'invoice'])->name('invoice');
            Route::get('/refresh-status/{paymentId}', [UserTrainingController::class, 'refreshPaymentStatus'])->name('refresh-status');
            Route::get('/confirm-payment/{paymentId}', [UserTrainingController::class, 'confirmPayment'])->name('confirm-payment');
            Route::post('/cancel-order/{paymentId}', [UserTrainingController::class, 'cancelOrder'])->name('cancel-order');

            // Trainer Management
            Route::get('/my-trainer', [UserTrainingController::class, 'myTrainer'])->name('my-trainer');
            Route::get('/switch-trainer', [UserTrainingController::class, 'showSwitchTrainer'])->name('switch-trainer');
            Route::post('/switch-trainer/{newTrainerId}', [UserTrainingController::class, 'switchTrainer'])->name('switch-trainer.process');

            // Ratings & Reviews
            Route::get('/rate/{trainerId}', [UserTrainingController::class, 'createRating'])->name('rate');
            Route::post('/rate/{trainerId}', [UserTrainingController::class, 'storeRating'])->name('rate.store');
            Route::put('/rating/{feedbackId}', [UserTrainingController::class, 'updateRating'])->name('rating.update');
            Route::get('/history', [UserTrainingController::class, 'trainerHistory'])->name('history');
            Route::get('/my-ratings', [UserTrainingController::class, 'myRatings'])->name('my-ratings');

            // AI Chat
            Route::post('/ai-chat', [UserTrainingController::class, 'chatAI'])->name('ai.chat');
            Route::post('/reset-ai-chat', [UserTrainingController::class, 'resetAIChatCount'])->name('reset-ai-chat');
        });

        // Profile Management
        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/', [UserProfileController::class, 'index'])->name('index');
            Route::get('/edit', [UserProfileController::class, 'edit'])->name('edit');
            Route::patch('/update', [UserProfileController::class, 'update'])->name('update');
            Route::put('/avatar', [UserProfileController::class, 'updateAvatar'])->name('avatar.update');
            Route::get('/password', [UserProfileController::class, 'editPassword'])->name('password.edit');
            Route::patch('/password', [UserProfileController::class, 'updatePassword'])->name('password.update');
        });

        // Articles
        Route::get('/articles', [UserArticleController::class, 'index'])->name('articles.index');
        Route::get('/articles/{article}', [UserArticleController::class, 'show'])->name('articles.show');

        // Notifications
        Route::prefix('notifications')->name('notifications.')->group(function () {
            Route::get('/', [UserNotificationController::class, 'index'])->name('index');
            Route::post('/mark-all-read', [UserNotificationController::class, 'markAllRead'])->name('markAllRead');
            Route::delete('/clear-all', [UserNotificationController::class, 'clearAll'])->name('clearAll');
            Route::post('/{id}/read', [UserNotificationController::class, 'markAsRead'])->name('read');
            Route::delete('/{id}', [UserNotificationController::class, 'destroy'])->name('destroy');

            // AJAX Endpoints
            Route::get('/unread-count', [UserNotificationController::class, 'getUnreadCount'])->name('unreadCount');
            Route::post('/{id}/read-ajax', [UserNotificationController::class, 'markAsReadAjax'])->name('readAjax');
            Route::get('/filter', [UserNotificationController::class, 'filter'])->name('filter');

            // Preferences
            Route::post('/reminder-preferences', [UserNotificationController::class, 'saveReminderPreferences'])->name('reminder-preferences');
            Route::post('/toggle-reminder', [UserNotificationController::class, 'toggleQuickReminder'])->name('toggle-reminder');
            Route::post('/test-reminder', [UserNotificationController::class, 'testReminder'])->name('test-reminder');

            // Push Notifications
            Route::post('/test-push', [UserNotificationController::class, 'testPushNotification'])->name('testPush');
            Route::post('/fcm-token', [UserNotificationController::class, 'storeFCMToken'])->name('storeFCMToken');
            Route::delete('/fcm-token', [UserNotificationController::class, 'removeFCMToken'])->name('removeFCMToken');
            Route::get('/devices', [UserNotificationController::class, 'getUserDevices'])->name('devices');
            Route::post('/push-preferences', [UserNotificationController::class, 'savePushPreferences'])->name('push-preferences');
        });

        // ==========================
        // 🧍 USER COMMUNITY ROUTES
        // ==========================
        Route::prefix('communities')->name('communities.')->group(function () {
            Route::get('/', [UserCommunityController::class, 'index'])->name('index');
            Route::get('/create', [UserCommunityController::class, 'create'])->name('create');
            Route::post('/', [UserCommunityController::class, 'store'])->name('store');
            Route::get('/{community:slug}', [UserCommunityController::class, 'show'])->name('show');
            Route::get('/{community:slug}/edit', [UserCommunityController::class, 'edit'])->name('edit');
            Route::put('/{community:slug}', [UserCommunityController::class, 'update'])->name('update');
            Route::delete('/{community:slug}', [UserCommunityController::class, 'destroy'])->name('destroy');

            // Membership
            Route::post('/{community:slug}/join', [UserCommunityController::class, 'join'])->name('join');
            Route::post('/{community:slug}/leave', [UserCommunityController::class, 'leave'])->name('leave');

            // Posts
            Route::post('/{community:slug}/posts', [UserCommunityPostController::class, 'store'])->name('posts.store');
            Route::put('/posts/{post}', [UserCommunityPostController::class, 'update'])->name('posts.update');
            Route::delete('/posts/{post}', [UserCommunityPostController::class, 'destroy'])->name('posts.destroy');

            // Comments
            Route::post('/posts/{post}/comments', [UserCommunityCommentController::class, 'store'])->name('comments.store');
            Route::put('/comments/{comment}', [UserCommunityCommentController::class, 'update'])->name('comments.update');
            Route::delete('/comments/{comment}', [UserCommunityCommentController::class, 'destroy'])->name('comments.destroy');

            // Likes
            Route::post('/posts/{post}/like', [UserCommunityLikeController::class, 'likePost'])->name('posts.like');
            Route::post('/posts/{post}/unlike', [UserCommunityLikeController::class, 'unlikePost'])->name('posts.unlike');
            Route::post('/comments/{comment}/like', [UserCommunityLikeController::class, 'likeComment'])->name('comments.like');
            Route::post('/comments/{comment}/unlike', [UserCommunityLikeController::class, 'unlikeComment'])->name('comments.unlike');

            // Members Management Routes
            Route::get('/{community:slug}/members', [UserCommunityController::class, 'members'])->name('members');
            Route::post('/{community:slug}/members/{user}/promote', [UserCommunityController::class, 'promoteToModerator'])->name('members.promote');
            Route::post('/{community:slug}/members/{user}/demote', [UserCommunityController::class, 'demoteToMember'])->name('members.demote');
            Route::delete('/{community:slug}/members/{user}', [UserCommunityController::class, 'removeMember'])->name('members.remove');

            // Membership Approval Routes (for private communities)
            Route::post('/{community:slug}/members/{user}/approve', [UserCommunityController::class, 'approveMember'])->name('members.approve');
            Route::post('/{community:slug}/members/{user}/reject', [UserCommunityController::class, 'rejectMember'])->name('members.reject');

            // Ownership Transfer
            Route::post('/{community:slug}/transfer-ownership/{user}', [UserCommunityController::class, 'transferOwnership'])->name('transfer-ownership');
        });
    });



// 404 Fallback
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});

// ==========================
// ⚙️ LARAVEL DEFAULT AUTH
// ==========================
require __DIR__ . '/auth.php';
