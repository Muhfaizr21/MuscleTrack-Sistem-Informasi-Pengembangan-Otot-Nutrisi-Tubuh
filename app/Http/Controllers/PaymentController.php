<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function createPayment(Request $request)
    {
        try {
            $request->validate([
                'payment_id' => 'required|exists:payments,id',
            ]);

            $payment = Payment::where('id', $request->payment_id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            // Jika payment sudah paid, tidak perlu buat token lagi
            if ($payment->status === 'paid') {
                return response()->json([
                    'success' => false,
                    'message' => 'Pembayaran sudah berhasil. Tidak perlu bayar lagi.',
                ], 400);
            }

            // GENERATE ORDER ID BARU jika masih pending dan order_id sudah pernah digunakan
            if ($payment->status === 'pending' && !empty($payment->order_id)) {
                $newOrderId = 'ORD-' . time() . '-' . rand(1000, 9999);
                $payment->update(['order_id' => $newOrderId]);

                Log::info('🆕 Order ID updated for retry', [
                    'payment_id' => $payment->id,
                    'old_order_id' => $payment->order_id,
                    'new_order_id' => $newOrderId
                ]);
            }

            // Pastikan order_id ada
            if (empty($payment->order_id)) {
                $newOrderId = 'ORD-' . time() . '-' . rand(1000, 9999);
                $payment->update(['order_id' => $newOrderId]);
            }

            // DEBUG: Log konfigurasi
            Log::info('🎯 Midtrans Config in PaymentController', [
                'server_key' => config('midtrans.server_key'),
                'client_key' => config('midtrans.client_key'),
                'is_production' => config('midtrans.is_production'),
                'payment_id' => $payment->id,
                'order_id' => $payment->order_id,
                'amount' => $payment->amount
            ]);

            // Setup Midtrans dengan verification
            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$clientKey = config('midtrans.client_key');
            \Midtrans\Config::$isProduction = config('midtrans.is_production');
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            // Verify server key is set
            if (empty(\Midtrans\Config::$serverKey)) {
                throw new \Exception('Midtrans server key is empty! Check your config.');
            }

            $transaction = [
                'transaction_details' => [
                    'order_id' => $payment->order_id,
                    'gross_amount' => (float) $payment->amount,
                ],
                'customer_details' => [
                    'first_name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                ],
            ];

            Log::info('📦 Transaction details for Midtrans', $transaction);

            // Generate Snap Token
            $snapToken = \Midtrans\Snap::getSnapToken($transaction);

            Log::info('✅ Snap Token generated successfully', [
                'order_id' => $payment->order_id,
                'snap_token_received' => !empty($snapToken)
            ]);

            $payment->update(['snap_token' => $snapToken]);

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'order_id' => $payment->order_id,
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Payment Creation Failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'payment_id' => $request->payment_id ?? 'unknown',
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat pembayaran: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Callback dari Midtrans
     */
    public function callback(Request $request)
    {
        Log::info('🔄 Midtrans Callback Received', $request->all());

        $serverKey = config('midtrans.server_key');

        // Verifikasi signature
        $hashed = hash(
            'sha512',
            $request->order_id .
                $request->status_code .
                $request->gross_amount .
                $serverKey
        );

        if ($hashed !== $request->signature_key) {
            Log::warning('🚫 INVALID SIGNATURE MIDTRANS', [
                'received_signature' => $request->signature_key,
                'calculated_signature' => $hashed,
                'order_id' => $request->order_id
            ]);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // Cari payment berdasarkan order_id
        $payment = Payment::where('order_id', $request->order_id)->first();

        if (!$payment) {
            Log::warning('🚫 Payment not found for order: ' . $request->order_id);
            return response()->json(['message' => 'Payment not found'], 404);
        }

        // Update status sesuai callback
        $oldStatus = $payment->status;

        switch ($request->transaction_status) {
            case 'capture':
                if ($request->fraud_status == 'accept') {
                    $payment->update(['status' => 'paid']);
                    Log::info('💰 Payment CAPTURED and ACCEPTED', ['order_id' => $request->order_id]);
                }
                break;

            case 'settlement':
                $payment->update(['status' => 'paid']);
                Log::info('💰 Payment SETTLEMENT/PAID', ['order_id' => $request->order_id]);

                // Trigger aksi setelah pembayaran berhasil
                $this->handleSuccessfulPayment($payment);
                break;

            case 'pending':
                $payment->update(['status' => 'pending']);
                Log::info('⏳ Payment PENDING', ['order_id' => $request->order_id]);
                break;

            case 'deny':
            case 'expire':
            case 'cancel':
                $payment->update(['status' => 'failed']);
                Log::info('❌ Payment FAILED', [
                    'order_id' => $request->order_id,
                    'status' => $request->transaction_status
                ]);
                break;
        }

        return response()->json(['message' => 'Callback processed successfully']);
    }

    /**
     * Handle aksi setelah pembayaran berhasil
     */
    private function handleSuccessfulPayment(Payment $payment)
    {
        try {
            $user = $payment->user;
            $trainer = $payment->trainer;

            // Update user's trainer
            $user->update(['trainer_id' => $payment->trainer_id]);

            // Create premium access log
            \App\Models\PremiumAccessLog::create([
                'user_id' => $user->id,
                'trainer_id' => $payment->trainer_id,
                'start_date' => now(),
                'end_date' => now()->addDays(30),
                'payment_status' => 'paid',
            ]);

            // Create trainer membership
            \App\Models\TrainerMembership::create([
                'trainer_id' => $payment->trainer_id,
                'user_id' => $user->id,
            ]);

            // Update program request
            \App\Models\ProgramRequest::where('trainer_id', $payment->trainer_id)
                ->where('user_id', $user->id)
                ->where('status', 'pending')
                ->update(['status' => 'approved']);

            // Send welcome message from trainer
            \App\Models\TrainerChat::create([
                'trainer_id' => $payment->trainer_id,
                'user_id' => $user->id,
                'message' => 'Halo! Selamat bergabung di program training saya. Mari kita mulai perjalanan fitness Anda!',
                'sender_type' => 'trainer',
                'timestamp' => now(),
                'read_status' => false,
            ]);

            Log::info('🎉 Successfully processed payment completion', [
                'user_id' => $user->id,
                'trainer_id' => $payment->trainer_id,
                'order_id' => $payment->order_id
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Error in handleSuccessfulPayment', [
                'error' => $e->getMessage(),
                'payment_id' => $payment->id
            ]);
        }
    }
}
