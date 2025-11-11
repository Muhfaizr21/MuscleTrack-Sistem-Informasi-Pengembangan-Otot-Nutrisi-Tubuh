<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TrainerChat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Services\GeminiService;
use Carbon\Carbon;
use App\Events\NewTrainerChatMessage;

class UserChatController extends Controller
{
    /**
     * 📋 Halaman daftar chat dan rekomendasi trainer
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // 🔹 Ambil semua trainer yang terhubung dengan user
        $trainers = User::where('role', 'trainer')
            ->where(function ($q) use ($user) {
                $q->where('id', $user->trainer_id)
                    ->orWhereHas('trainerMembershipsAsUser', function ($sub) use ($user) {
                        $sub->where('user_id', $user->id);
                    });
            })
            ->with('trainerProfile')
            ->get();

        // ==============================================================
        // 🚫 Jika user belum punya training / belum terhubung dengan trainer
        // ==============================================================
        if ($trainers->isEmpty()) {
            // Simpan notifikasi sementara
            session()->flash('warning', '⚠️ Anda belum memiliki training aktif. Silakan pilih program terlebih dahulu.');

            // Arahkan ke halaman daftar training
            return redirect()->route('user.training.index');
        }

        // 🔹 Tambah AI Trainer virtual (selalu bisa diakses)
        $aiTrainer = (object)[
            'id' => 0,
            'name' => 'Muscle AI Trainer',
            'role' => 'ai',
            'trainerProfile' => (object)[
                'speciality' => 'AI Fitness & Nutrition Advisor',
                'photo' => asset('images/ai-trainer.png'),
            ],
        ];
        $trainers->push($aiTrainer);

        // 🔹 Tentukan trainer aktif
        $trainer = null;
        if ($request->has('trainer')) {
            $trainer = $trainers->firstWhere('id', (int)$request->trainer);
        } elseif ($trainers->count() === 1) {
            $trainer = $trainers->first();
        }

        // 🔹 Ambil chat
        $groupedChats = collect();
        if ($trainer) {
            $trainerIdForQuery = ($trainer->id === 0) ? null : $trainer->id;

            $chats = TrainerChat::where('user_id', $user->id)
                ->where('trainer_id', $trainerIdForQuery)
                ->orderBy('timestamp', 'asc')
                ->get();

            $groupedChats = $chats->groupBy(function ($chat) {
                $date = Carbon::parse($chat->timestamp)->startOfDay();
                $today = Carbon::now('Asia/Jakarta')->startOfDay();
                $yesterday = Carbon::yesterday('Asia/Jakarta')->startOfDay();

                if ($date->equalTo($today)) {
                    return 'Hari Ini (' . Carbon::now('Asia/Jakarta')->translatedFormat('l, d F Y') . ')';
                } elseif ($date->equalTo($yesterday)) {
                    return 'Kemarin (' . Carbon::yesterday('Asia/Jakarta')->translatedFormat('l, d F Y') . ')';
                } elseif ($date->greaterThanOrEqualTo(Carbon::now('Asia/Jakarta')->subDays(7)->startOfDay())) {
                    return 'Minggu Ini (' . $date->translatedFormat('l, d F Y') . ')';
                } else {
                    return $date->translatedFormat('l, d F Y');
                }
            });
        }

        // 🔹 Hitung jumlah pesan belum dibaca
        $unreadCount = [];
        foreach ($trainers as $t) {
            if ($t->id === 0) {
                $unreadCount[$t->id] = 0;
                continue;
            }

            $unreadCount[$t->id] = TrainerChat::where('trainer_id', $t->id)
                ->where('user_id', $user->id)
                ->where('read_status', false)
                ->where('sender_type', 'trainer')
                ->count();
        }

        // 🔹 Status typing trainer
        $isTrainerTyping = false;
        if ($trainer && $trainer->id !== 0) {
            $isTrainerTyping = Cache::has("typing_trainer_{$trainer->id}_to_user_{$user->id}");
        }

        return view('user.chat.index', compact(
            'user',
            'trainers',
            'trainer',
            'groupedChats',
            'unreadCount',
            'isTrainerTyping'
        ));
    }

    /**
     * 💬 Kirim pesan ke trainer / AI Trainer
     */
    public function store(Request $request, GeminiService $gemini)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'trainer_id' => 'required',
        ]);

        $user = Auth::user();
        $trainerId = (int)$request->trainer_id;

        // ================================
        // 🤖 CHAT DENGAN AI TRAINER
        // ================================
        if ($trainerId === 0) {
            $chatUser = TrainerChat::create([
                'user_id' => $user->id,
                'trainer_id' => null,
                'message' => $request->message,
                'timestamp' => now('Asia/Jakarta'),
                'read_status' => true,
                'sender_type' => 'user',
            ]);

            try {
                $prompt = "Kamu adalah pelatih kebugaran dan nutrisi profesional. 
                Jawablah dengan gaya ramah, natural, dan berbobot seolah kamu adalah trainer manusia.
                Pertanyaan pengguna: {$request->message}";

                $aiResponse = $gemini->generateText($prompt);

                $chatAI = TrainerChat::create([
                    'user_id' => $user->id,
                    'trainer_id' => null,
                    'message' => $aiResponse,
                    'timestamp' => now('Asia/Jakarta'),
                    'read_status' => true,
                    'sender_type' => 'trainer',
                ]);

                return response()->json([
                    'success' => true,
                    'ai_mode' => true,
                    'user_message' => $chatUser->message,
                    'ai_message' => $chatAI->message,
                    'local_time' => Carbon::now('Asia/Jakarta')->format('H:i:s'),
                ]);
            } catch (\Throwable $e) {
                return response()->json([
                    'success' => false,
                    'ai_mode' => true,
                    'error' => 'Gagal memproses pesan AI: ' . $e->getMessage(),
                ], 500);
            }
        }

        // ================================
        // 💬 CHAT DENGAN TRAINER MANUSIA
        // ================================
        $isConnected = User::where('id', $trainerId)
            ->where(function ($q) use ($user) {
                $q->where('id', $user->trainer_id)
                    ->orWhereHas('trainerMembershipsAsUser', function ($sub) use ($user) {
                        $sub->where('user_id', $user->id);
                    });
            })
            ->exists();

        if (!$isConnected) {
            return response()->json(['error' => 'Anda belum terhubung dengan trainer ini.'], 403);
        }

        $chat = TrainerChat::create([
            'user_id' => $user->id,
            'trainer_id' => $trainerId,
            'message' => $request->message,
            'timestamp' => now('Asia/Jakarta'),
            'read_status' => false,
            'sender_type' => 'user',
        ]);

        // ✅ Broadcast realtime ke trainer
        event(new NewTrainerChatMessage($chat));

        return response()->json([
            'success' => true,
            'ai_mode' => false,
            'chat_id' => $chat->id,
            'message' => $chat->message,
            'local_time' => Carbon::now('Asia/Jakarta')->format('H:i:s'),
        ]);
    }

    /**
     * ✍️ Status mengetik
     */
    public function typing(Request $request)
    {
        $user = Auth::user();
        $trainerId = $request->input('trainer_id');
        $isTyping = filter_var($request->input('typing'), FILTER_VALIDATE_BOOLEAN);

        if (!$trainerId) {
            return response()->json(['error' => 'Trainer ID tidak ditemukan'], 400);
        }

        if ($trainerId == 0) {
            return response()->json(['success' => true]);
        }

        $key = "typing_user_{$user->id}_to_trainer_{$trainerId}";
        if ($isTyping) {
            Cache::put($key, true, now()->addSeconds(5));
        } else {
            Cache::forget($key);
        }

        return response()->json(['success' => true]);
    }

    /**
     * 🔕 Tandai semua pesan dari trainer sudah dibaca
     */
    public function markAllRead(Request $request)
    {
        $user = Auth::user();
        $trainerId = $request->input('trainer_id');

        $trainerIdForQuery = ($trainerId == 0) ? null : $trainerId;

        TrainerChat::where('user_id', $user->id)
            ->where('trainer_id', $trainerIdForQuery)
            ->where('sender_type', 'trainer')
            ->update(['read_status' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * ❌ Hapus pesan user
     */
    public function destroy($id)
    {
        $chat = TrainerChat::findOrFail($id);

        if ($chat->user_id !== Auth::id() || $chat->sender_type !== 'user') {
            abort(403, 'Anda hanya dapat menghapus pesan yang Anda kirim.');
        }

        $chat->delete();
        return response()->json(['success' => true]);
    }

    /**
     * 🧠 Helper: cek user typing
     */
    public static function isUserTyping($userId, $trainerId)
    {
        return Cache::has("typing_user_{$userId}_to_trainer_{$trainerId}");
    }
}
