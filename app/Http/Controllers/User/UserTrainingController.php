<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use App\Models\TrainerProfile;
use App\Models\Payment;
use App\Models\PremiumAccessLog;
use App\Models\TrainerChat;
use App\Models\TrainerMembership;
use App\Models\ProgramRequest;
use App\Models\Feedback;
use App\Services\GeminiService;
use Carbon\Carbon;

class UserTrainingController extends Controller
{
    /**
     * Menampilkan daftar trainer yang sudah disetujui.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = User::query()
            ->where('role', 'trainer')
            ->where('verification_status', 'approved')
            ->with(['trainerProfile', 'trainerVerification']);

        // Filter pencarian
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('trainerProfile', function ($q2) use ($search) {
                        $q2->where('specialization', 'like', "%{$search}%")
                            ->orWhere('bio', 'like', "%{$search}%");
                    });
            });
        }

        // Filter spesialisasi
        if ($specialization = $request->input('specialization')) {
            $query->whereHas('trainerProfile', function ($q) use ($specialization) {
                $q->where('specialization', 'like', "%{$specialization}%");
            });
        }

        // Filter pengalaman
        if ($experience = $request->input('experience')) {
            $query->whereHas('trainerProfile', function ($q) use ($experience) {
                match ($experience) {
                    '1-3' => $q->whereBetween('experience_years', [1, 3]),
                    '3-5' => $q->whereBetween('experience_years', [3, 5]),
                    '5+' => $q->where('experience_years', '>=', 5),
                    default => null,
                };
            });
        }

        $trainers = $query->paginate(8);

        return view('user.training.index', compact('trainers', 'user'));
    }

    /**
     * Menampilkan detail trainer.
     */
    public function show($trainerId)
    {
        $trainer = User::with(['trainerProfile', 'trainerVerification'])
            ->where('id', $trainerId)
            ->where('role', 'trainer')
            ->first();

        if (!$trainer) {
            return redirect()->route('user.training.index')
                ->with('error', 'Trainer tidak ditemukan.');
        }

        $currentUser = Auth::user();
        $hasActiveTrainer = !empty($currentUser->trainer_id);
        $hasRated = false;

        if ($currentUser->trainer_id === $trainerId) {
            $hasRated = Feedback::where('user_id', $currentUser->id)
                ->where('trainer_id', $trainerId)
                ->exists();
        }

        $averageRating = Feedback::where('trainer_id', $trainerId)->avg('rating') ?? 0;
        $ratingCount = Feedback::where('trainer_id', $trainerId)->count();

        return view('user.training.show', compact(
            'trainer',
            'hasActiveTrainer',
            'hasRated',
            'averageRating',
            'ratingCount'
        ));
    }

    /**
     * Membuat pesanan / pembayaran ke trainer.
     */
    public function order(Request $request, $trainerId)
    {
        $user = Auth::user();

        if (!empty($user->trainer_id)) {
            return back()->with('error', 'Anda sudah memiliki trainer aktif.');
        }

        $trainer = User::where('id', $trainerId)
            ->where('role', 'trainer')
            ->where('verification_status', 'approved')
            ->first();

        if (!$trainer) {
            return back()->with('error', 'Trainer tidak ditemukan atau belum disetujui.');
        }

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
            'note' => 'Permintaan program training dari user ' . e($user->name),
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
            ->first();

        if (!$payment) {
            return redirect()->route('user.training.index')
                ->with('error', 'Data pembayaran tidak ditemukan.');
        }

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
            ->first();

        if (!$payment) {
            return back()->with('error', 'Pembayaran tidak valid atau sudah dikonfirmasi.');
        }

        $payment->update(['status' => 'paid']);

        $user = Auth::user();
        $user->update(['trainer_id' => $payment->trainer_id]);

        PremiumAccessLog::create([
            'user_id' => $user->id,
            'trainer_id' => $payment->trainer_id,
            'start_date' => now(),
            'end_date' => now()->addDays(30),
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

        TrainerChat::create([
            'trainer_id' => $payment->trainer_id,
            'user_id' => $user->id,
            'message' => 'Halo! Selamat bergabung di program training saya. Mari kita mulai perjalanan fitness Anda!',
            'sender_type' => 'trainer',
            'timestamp' => now(),
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
            ->first();

        if (!$payment) {
            return back()->with('error', 'Pesanan tidak ditemukan atau sudah diproses.');
        }

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

        if (empty($user->trainer_id)) {
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

        $hasRated = Feedback::where('user_id', $user->id)
            ->where('trainer_id', $user->trainer_id)
            ->exists();

        return view('user.training.my-trainer', compact('trainer', 'premiumAccess', 'hasRated'));
    }

    /**
     * Halaman untuk mengganti trainer
     */
    public function showSwitchTrainer()
    {
        $user = Auth::user();

        if (empty($user->trainer_id)) {
            return redirect()->route('user.training.index')
                ->with('info', 'Anda belum memiliki trainer.');
        }

        $currentTrainer = User::with(['trainerProfile'])->find($user->trainer_id);

        $trainers = User::where('role', 'trainer')
            ->where('verification_status', 'approved')
            ->where('id', '!=', $user->trainer_id)
            ->with(['trainerProfile'])
            ->get();

        return view('user.training.switch-trainer', compact('currentTrainer', 'trainers'));
    }

    /**
     * Proses mengganti trainer
     */
    public function switchTrainer(Request $request, $newTrainerId)
    {
        $user = Auth::user();

        if (empty($user->trainer_id)) {
            return redirect()->route('user.training.index')
                ->with('error', 'Anda belum memiliki trainer.');
        }

        $newTrainer = User::where('id', $newTrainerId)
            ->where('role', 'trainer')
            ->where('verification_status', 'approved')
            ->first();

        if (!$newTrainer) {
            return back()->with('error', 'Trainer tidak ditemukan atau belum disetujui.');
        }

        // Buat pembayaran untuk trainer baru
        $payment = Payment::create([
            'user_id' => $user->id,
            'trainer_id' => $newTrainer->id,
            'amount' => 150000,
            'method' => $request->input('method', 'transfer'),
            'status' => 'pending',
            'transaction_id' => 'SWITCH-' . strtoupper(uniqid()),
        ]);

        return redirect()->route('user.training.payment', $payment->id)
            ->with('success', 'Silakan lanjutkan pembayaran untuk trainer baru.');
    }

    /**
     * Menampilkan form untuk memberikan rating
     */
    public function createRating($trainerId)
    {
        $user = Auth::user();

        // Cek apakah user memiliki trainer ini
        if ($user->trainer_id != $trainerId) {
            return redirect()->route('user.training.my-trainer')
                ->with('error', 'Anda hanya dapat memberikan rating untuk trainer yang sedang melatih Anda.');
        }

        $trainer = User::where('id', $trainerId)
            ->where('role', 'trainer')
            ->first();

        if (!$trainer) {
            return redirect()->route('user.training.my-trainer')
                ->with('error', 'Trainer tidak ditemukan.');
        }

        // Cek apakah sudah memberikan rating untuk trainer ini
        $existingFeedback = Feedback::where('user_id', $user->id)
            ->where('trainer_id', $trainerId)
            ->first();

        return view('user.training.rating', compact('trainer', 'existingFeedback'));
    }

    /**
     * Menyimpan rating trainer
     */
    public function storeRating(Request $request, $trainerId)
    {
        $user = Auth::user();

        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000'
        ]);

        // Cek apakah user memiliki trainer ini
        if ($user->trainer_id != $trainerId) {
            return back()->with('error', 'Anda hanya dapat memberikan rating untuk trainer yang sedang melatih Anda.');
        }

        // Cek apakah sudah memberikan rating untuk trainer ini
        $existingFeedback = Feedback::where('user_id', $user->id)
            ->where('trainer_id', $trainerId)
            ->first();

        if ($existingFeedback) {
            return back()->with('error', 'Anda sudah memberikan rating untuk trainer ini.');
        }

        try {
            // Simpan feedback
            Feedback::create([
                'user_id' => $user->id,
                'trainer_id' => $trainerId,
                'rating' => $request->rating,
                'comment' => $request->comment
            ]);

            // Update rating rata-rata trainer
            $this->updateTrainerAverageRating($trainerId);

            return redirect()->route('user.training.my-trainer')
                ->with('success', 'Terima kasih! Rating Anda telah berhasil disimpan.');
        } catch (\Exception $e) {
            Log::error('Error storing rating: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyimpan rating. Silakan coba lagi.');
        }
    }

    /**
     * Update rating trainer
     */
    public function updateRating(Request $request, $feedbackId)
    {
        $feedback = Feedback::where('id', $feedbackId)
            ->where('user_id', Auth::id())
            ->first();

        if (!$feedback) {
            return back()->with('error', 'Rating tidak ditemukan.');
        }

        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000'
        ]);

        $feedback->update([
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        // Update rating rata-rata trainer
        $this->updateTrainerAverageRating($feedback->trainer_id);

        return back()->with('success', 'Rating berhasil diperbarui.');
    }

    /**
     * Menghitung dan memperbarui rating rata-rata trainer
     */
    private function updateTrainerAverageRating($trainerId)
    {
        $averageRating = Feedback::where('trainer_id', $trainerId)->avg('rating');

        // Update di trainer_profile
        $trainerProfile = TrainerProfile::where('user_id', $trainerId)->first();
        if ($trainerProfile) {
            $trainerProfile->update([
                'rating' => round($averageRating, 2)
            ]);
        }
    }

    /**
     * Menampilkan riwayat trainer
     */
    public function trainerHistory()
    {
        $user = Auth::user();

        $premiumAccessLogs = PremiumAccessLog::with(['trainer', 'trainer.trainerProfile'])
            ->where('user_id', $user->id)
            ->where('payment_status', 'paid')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.training.history', compact('premiumAccessLogs'));
    }

    /**
     * Menampilkan semua rating yang diberikan user
     */
    public function myRatings()
    {
        $user = Auth::user();

        $feedbacks = Feedback::with(['trainer', 'trainer.trainerProfile'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.training.my-ratings', compact('feedbacks'));
    }

    /**
     * Chat dengan AI trainer (maksimal 5 pesan per jam).
     */
    public function chatAI(Request $request, GeminiService $gemini)
    {
        $user = Auth::user();
        $cacheKey = "ai_chat_count_user_{$user->id}";
        $chatCount = Cache::get($cacheKey, 0);

        if ($chatCount >= 5) {
            return response()->json([
                'success' => false,
                'reply' => '🚫 Batas 5 pesan AI telah tercapai. Silakan upgrade untuk akses tanpa batas.',
            ]);
        }

        $request->validate(['message' => 'required|string|max:500']);
        $userMessage = trim($request->message);

        TrainerChat::create([
            'user_id' => $user->id,
            'trainer_id' => null,
            'message' => e($userMessage),
            'sender_type' => 'user',
            'timestamp' => now(),
            'read_status' => true,
        ]);

        try {
            $prompt = "Kamu adalah Muscle AI Trainer, pelatih fitness dan nutrisi profesional. 
            Jawab dengan bahasa Indonesia yang singkat, ramah, dan akurat.
            Topik: fitness, nutrisi, latihan, dan kesehatan.
            Pesan pengguna: {$userMessage}";

            $reply = $gemini->generateText($prompt) ?? 'Saya tidak bisa menjawab pertanyaan itu saat ini.';

            TrainerChat::create([
                'user_id' => $user->id,
                'trainer_id' => null,
                'message' => $reply,
                'sender_type' => 'ai',
                'timestamp' => now(),
                'read_status' => true,
            ]);

            Cache::put($cacheKey, $chatCount + 1, now()->addHour());

            return response()->json([
                'success' => true,
                'reply' => $reply,
                'remaining_messages' => max(0, 5 - ($chatCount + 1)),
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
        Cache::forget("ai_chat_count_user_{$user->id}");

        return response()->json([
            'success' => true,
            'message' => 'Counter chat AI telah direset.',
        ]);
    }
}
