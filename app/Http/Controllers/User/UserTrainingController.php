<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\TrainerProfile;
use App\Models\Payment;
use App\Models\PremiumAccessLog;
use App\Models\TrainerChat;
use App\Models\TrainerMembership;
use App\Models\ProgramRequest;
use App\Services\GeminiService;
use Carbon\Carbon;

class UserTrainingController extends Controller
{
    /**
     * Menampilkan daftar trainer yang sudah disetujui.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'trainer')
            ->where('verification_status', 'approved')
            ->with(['trainerProfile', 'trainerVerification']);

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($specialization = $request->input('specialization')) {
            $query->whereHas('trainerProfile', function ($q) use ($specialization) {
                $q->where('specialization', 'like', "%{$specialization}%");
            });
        }

        $trainers = $query->paginate(8);

        return view('user.training.index', compact('trainers'));
    }

    /**
     * Menampilkan detail trainer.
     */
    public function show($trainerId)
    {
        $trainer = User::with(['trainerProfile', 'trainerVerification'])
            ->where('id', $trainerId)
            ->where('role', 'trainer')
            ->firstOrFail();

        $currentUser = Auth::user();
        $hasActiveTrainer = $currentUser->trainer_id !== null;

        return view('user.training.show', compact('trainer', 'hasActiveTrainer'));
    }

    /**
     * Membuat pesanan / pembayaran ke trainer.
     */
    public function order(Request $request, $trainerId)
    {
        $user = Auth::user();

        if ($user->trainer_id !== null) {
            return back()->with('error', 'Anda sudah memiliki trainer aktif.');
        }

        $trainer = User::where('id', $trainerId)
            ->where('role', 'trainer')
            ->where('verification_status', 'approved')
            ->firstOrFail();

        $payment = Payment::create([
            'user_id' => $user->id,
            'trainer_id' => $trainer->id,
            'amount' => 150000,
            'method' => $request->input('method', 'transfer'),
            'status' => 'pending',
            'transaction_id' => 'TRX-' . strtoupper(uniqid()),
        ]);

        ProgramRequest::create([
            'trainer_id' => $trainer->id,
            'user_id' => $user->id,
            'status' => 'pending',
            'note' => 'Permintaan program training dari user ' . $user->name,
        ]);

        return redirect()->route('user.training.payment', $payment->id)
            ->with('success', 'Pesanan berhasil dibuat. Silakan lanjutkan pembayaran.');
    }

    /**
     * Halaman detail pembayaran.
     */
    public function payment($paymentId)
    {
        $payment = Payment::with(['trainer', 'trainer.trainerProfile'])
            ->where('id', $paymentId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('user.training.payment', compact('payment'));
    }

    /**
     * Konfirmasi pembayaran sukses.
     */
    public function confirmPayment($paymentId)
    {
        $payment = Payment::where('id', $paymentId)
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->firstOrFail();

        $payment->update(['status' => 'paid']);

        $user = Auth::user();
        $user->update(['trainer_id' => $payment->trainer_id]);

        PremiumAccessLog::create([
            'user_id' => $user->id,
            'trainer_id' => $payment->trainer_id,
            'start_date' => Carbon::today(),
            'end_date' => Carbon::today()->addDays(30),
            'payment_status' => 'paid',
        ]);

        TrainerMembership::create([
            'trainer_id' => $payment->trainer_id,
            'user_id' => $user->id,
        ]);

        ProgramRequest::where('trainer_id', $payment->trainer_id)
            ->where('user_id', $user->id)
            ->where('status', 'pending')
            ->update(['status' => 'approved']);

        // Chat pertama dari trainer (terenkripsi otomatis)
        TrainerChat::create([
            'trainer_id' => $payment->trainer_id,
            'user_id' => $user->id,
            'message' => 'Halo! Selamat bergabung di program training saya. Mari kita mulai perjalanan fitness Anda!',
            'sender_type' => 'trainer',
            'timestamp' => now('Asia/Jakarta'),
            'read_status' => false,
        ]);

        return redirect()->route('user.dashboard')
            ->with('success', 'Pembayaran berhasil! Anda memiliki akses ke trainer selama 30 hari.');
    }

    /**
     * Batalkan pesanan.
     */
    public function cancelOrder($paymentId)
    {
        $payment = Payment::where('id', $paymentId)
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->firstOrFail();

        ProgramRequest::where('trainer_id', $payment->trainer_id)
            ->where('user_id', Auth::id())
            ->delete();

        $payment->delete();

        return redirect()->route('user.training.index')
            ->with('success', 'Pesanan berhasil dibatalkan.');
    }

    /**
     * Trainer yang sedang diikuti user.
     */
    public function myTrainer()
    {
        $user = Auth::user();

        if (!$user->trainer_id) {
            return redirect()->route('user.training.index')
                ->with('info', 'Anda belum memiliki trainer.');
        }

        $trainer = User::with(['trainerProfile', 'trainerVerification'])
            ->find($user->trainer_id);

        $premiumAccess = PremiumAccessLog::where('user_id', $user->id)
            ->where('trainer_id', $user->trainer_id)
            ->where('payment_status', 'paid')
            ->latest()
            ->first();

        return view('user.training.my-trainer', compact('trainer', 'premiumAccess'));
    }

    /**
     * Ganti trainer.
     */
    public function switchTrainer()
    {
        $user = Auth::user();
        $user->update(['trainer_id' => null]);

        return redirect()->route('user.training.index')
            ->with('success', 'Anda dapat memilih trainer baru sekarang.');
    }

    /**
     * Chat dengan AI trainer (maksimal 5 pesan per jam).
     */
    public function chatAI(Request $request, GeminiService $gemini)
    {
        $user = Auth::user();
        $cacheKey = "ai_chat_count_user_{$user->id}";
        $chatCount = cache()->get($cacheKey, 0);

        if ($chatCount >= 5) {
            return response()->json([
                'success' => false,
                'reply' => '🚫 Batas 5 pesan AI telah tercapai. Silakan upgrade untuk akses tanpa batas.',
            ]);
        }

        $request->validate(['message' => 'required|string|max:500']);
        $userMessage = trim($request->message);

        // Simpan pesan user (terenkripsi otomatis)
        TrainerChat::create([
            'user_id' => $user->id,
            'trainer_id' => null,
            'message' => $userMessage,
            'sender_type' => 'user',
            'timestamp' => now('Asia/Jakarta'),
            'read_status' => true,
        ]);

        try {
            $prompt = "Kamu adalah Muscle AI Trainer, pelatih fitness dan nutrisi profesional. 
            Jawab dengan bahasa Indonesia yang singkat, ramah, dan akurat.
            Topik: fitness, nutrisi, latihan, dan kesehatan.
            Pesan pengguna: {$userMessage}";

            $reply = $gemini->generateText($prompt);

            // Simpan balasan AI (terenkripsi otomatis)
            TrainerChat::create([
                'user_id' => $user->id,
                'trainer_id' => null,
                'message' => $reply,
                'sender_type' => 'ai',
                'timestamp' => now('Asia/Jakarta'),
                'read_status' => true,
            ]);

            cache()->put($cacheKey, $chatCount + 1, now()->addHours(1));

            return response()->json([
                'success' => true,
                'reply' => $reply,
                'remaining_messages' => 5 - ($chatCount + 1),
            ]);
        } catch (\Throwable $e) {
            Log::error('AI Chat Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'reply' => '⚠️ Maaf, sistem AI sedang mengalami gangguan. Coba lagi nanti.',
            ], 500);
        }
    }

    /**
     * Reset counter chat AI (khusus testing).
     */
    public function resetAIChatCount()
    {
        $user = Auth::user();
        cache()->forget("ai_chat_count_user_{$user->id}");

        return response()->json([
            'success' => true,
            'message' => 'Counter chat AI telah direset.',
        ]);
    }
}
