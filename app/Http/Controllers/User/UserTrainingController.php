<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\TrainerProfile;
use App\Models\Payment;
use App\Models\PremiumAccessLog;
use App\Models\TrainerChat;
use App\Services\GeminiService;
use Carbon\Carbon;

class UserTrainingController extends Controller
{
    /**
     * 🏋️ Menampilkan daftar trainer yang sudah disetujui (approved)
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'trainer')
            ->where('verification_status', 'approved')
            ->with('trainerProfile');

        // 🔍 Pencarian nama trainer
        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        $trainers = $query->paginate(8);

        return view('user.training.index', compact('trainers'));
    }

    /**
     * 🔍 Menampilkan detail trainer
     */
    public function show($trainerId)
    {
        $trainer = User::with('trainerProfile')
            ->where('id', $trainerId)
            ->where('role', 'trainer')
            ->where('verification_status', 'approved')
            ->firstOrFail();

        return view('user.training.show', compact('trainer'));
    }

    /**
     * 🧾 Membuat pesanan / pembayaran ke trainer
     */
    public function order(Request $request, $trainerId)
    {
        $user = Auth::user();

        $trainer = User::where('id', $trainerId)
            ->where('role', 'trainer')
            ->where('verification_status', 'approved')
            ->firstOrFail();

        $amount = 150000;
        $method = $request->input('method', 'transfer');

        $payment = Payment::create([
            'user_id' => $user->id,
            'trainer_id' => $trainer->id,
            'amount' => $amount,
            'method' => $method,
            'status' => 'pending',
            'transaction_id' => 'TRX-' . strtoupper(uniqid()),
        ]);

        return redirect()->route('user.training.payment', $payment->id)
            ->with('success', 'Pesanan berhasil dibuat. Silakan lanjutkan ke pembayaran.');
    }

    /**
     * 💳 Halaman detail pembayaran
     */
    public function payment($paymentId)
    {
        $payment = Payment::with('trainer')
            ->where('id', $paymentId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('user.training.payment', compact('payment'));
    }

    /**
     * ✅ Konfirmasi setelah pembayaran sukses
     */
    public function confirmPayment($paymentId)
    {
        $payment = Payment::where('id', $paymentId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $payment->update(['status' => 'paid']);

        PremiumAccessLog::create([
            'user_id' => Auth::id(),
            'trainer_id' => $payment->trainer_id,
            'start_date' => Carbon::today(),
            'end_date' => Carbon::today()->addDays(30),
            'payment_status' => 'paid',
        ]);

        return redirect()->route('user.training.index')
            ->with('success', 'Pembayaran berhasil! Kamu punya akses ke trainer selama 30 hari.');
    }

    /**
     * 🤖 Chat AI Trainer (dibatasi 5 pesan)
     */
    public function chatAI(Request $request, GeminiService $gemini)
    {
        $user = Auth::user();

        // Cek jumlah pesan AI terakhir dalam 1 sesi
        $cacheKey = "ai_chat_count_user_{$user->id}";
        $chatCount = cache()->get($cacheKey, 0);

        if ($chatCount >= 5) {
            return response()->json([
                'success' => false,
                'reply' => '🚫 Batas 5 pesan AI telah tercapai. Silakan pesan trainer untuk melanjutkan.',
            ]);
        }

        $request->validate(['message' => 'required|string|max:500']);
        $userMessage = trim($request->message);

        // Simpan pesan user
        TrainerChat::create([
            'user_id' => $user->id,
            'trainer_id' => null,
            'message' => $userMessage,
            'sender_type' => 'user',
            'timestamp' => now('Asia/Jakarta'),
            'read_status' => true,
        ]);

        try {
            // Prompt AI yang ramah & relevan dengan fitness
            $prompt = "Kamu adalah Muscle AI Trainer, pelatih kebugaran dan nutrisi tubuh profesional.
            Jawablah dengan gaya ramah, singkat, dan informatif.
            Pesan pengguna: {$userMessage}";

            $reply = $gemini->generateText($prompt);

            // Simpan balasan AI
            TrainerChat::create([
                'user_id' => $user->id,
                'trainer_id' => null,
                'message' => $reply,
                'sender_type' => 'trainer',
                'timestamp' => now('Asia/Jakarta'),
                'read_status' => true,
            ]);

            // Naikkan counter
            cache()->put($cacheKey, $chatCount + 1, now()->addHours(1));

            return response()->json([
                'success' => true,
                'reply' => $reply,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'reply' => '⚠️ Gagal merespons AI. Coba lagi nanti ya.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
