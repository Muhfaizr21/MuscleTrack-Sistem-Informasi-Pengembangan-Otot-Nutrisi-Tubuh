<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// 🔥 Wajib TANPA middleware auth / sanctum
Route::post('/midtrans/callback', [PaymentController::class, 'callback'])
    ->name('midtrans.callback');

// Jika kamu butuh test
Route::get('/midtrans/test', function () {
    return 'API OK';
});
