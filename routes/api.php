<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Trainer\MemberController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
// routes/web.php atau routes/api.php
Route::get('/trainer/members/{id}/real-time-status', [MemberController::class, 'getRealTimeStatus'])
    ->name('trainer.members.real-time-status')
    ->middleware(['auth', 'role:trainer']);

// 🔥 Wajib TANPA middleware auth / sanctum
Route::post('/midtrans/callback', [PaymentController::class, 'callback'])
    ->name('midtrans.callback');

// Jika kamu butuh test
Route::get('/midtrans/test', function () {
    return 'API OK';
});
