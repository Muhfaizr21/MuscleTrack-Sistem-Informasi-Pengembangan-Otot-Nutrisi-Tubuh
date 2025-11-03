<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TrainerChat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

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

        // 🔹 Tentukan trainer aktif
        $trainer = null;
        if ($request->has('trainer')) {
            $trainer = User::find($request->trainer);
        } elseif ($trainers->count() === 1) {
            $trainer = $trainers->first();
        }

        // 🔹 Ambil chat antara user & trainer aktif
        $groupedChats = collect();
        if ($trainer) {
            $chats = TrainerChat::where('trainer_id', $trainer->id)
                ->where('user_id', $user->id)
                ->orderBy('timestamp', 'asc')
                ->get();

            // 🔹 Group chat berdasarkan hari (hari ini, kemarin, minggu lalu, lainnya)
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

        // 🔹 Hitung jumlah pesan belum dibaca per trainer
        $unreadCount = [];
        foreach ($trainers as $t) {
            $unreadCount[$t->id] = TrainerChat::where('trainer_id', $t->id)
                ->where('user_id', $user->id)
                ->where('read_status', false)
                ->where('sender_type', 'trainer')
                ->count();
        }

        // 🔹 Jika belum punya trainer, tampilkan rekomendasi trainer yang verified
        $recommendedTrainers = [];
        if ($trainers->isEmpty()) {
            $recommendedTrainers = User::where('role', 'trainer')
                ->whereHas('trainerVerification', fn($q) => $q->where('status', 'approved'))
                ->with('trainerProfile')
                ->limit(6)
                ->get();
        }

        // 🔹 Cek apakah trainer sedang mengetik (cache)
        $isTrainerTyping = false;
        if ($trainer) {
            $isTrainerTyping = Cache::has("typing_trainer_{$trainer->id}_to_user_{$user->id}");
        }

        return view('user.chat.index', compact(
            'user',
            'trainers',
            'trainer',
            'groupedChats',
            'unreadCount',
            'recommendedTrainers',
            'isTrainerTyping'
        ));
    }

    /**
     * 💬 Kirim pesan ke trainer (real-time local time)
     */
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'trainer_id' => 'required|exists:users,id',
        ]);

        $user = Auth::user();

        // 🔒 Pastikan user terhubung dengan trainer
        $isConnected = User::where('id', $request->trainer_id)
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

        // 🔹 Simpan pesan baru di database
        $chat = TrainerChat::create([
            'user_id'     => $user->id,
            'trainer_id'  => $request->trainer_id,
            'message'     => $request->message,
            'timestamp'   => now('Asia/Jakarta'),
            'read_status' => false,
            'sender_type' => 'user',
        ]);

        // 🔹 Ambil waktu real-time (Asia/Jakarta)
        $nowLocal = Carbon::now('Asia/Jakarta')->format('H:i:s');

        return response()->json([
            'success'     => true,
            'chat_id'     => $chat->id,
            'message'     => $chat->message,
            'local_time'  => $nowLocal,
        ]);
    }

    /**
     * ✍️ Simpan status "user sedang mengetik"
     */
    public function typing(Request $request)
    {
        $user = Auth::user();
        $trainerId = $request->input('trainer_id');
        $isTyping = filter_var($request->input('typing'), FILTER_VALIDATE_BOOLEAN);

        if (!$trainerId) {
            return response()->json(['error' => 'Trainer ID tidak ditemukan'], 400);
        }

        // Simpan status typing di cache selama 5 detik
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

        TrainerChat::where('user_id', $user->id)
            ->where('trainer_id', $trainerId)
            ->where('sender_type', 'trainer')
            ->update(['read_status' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * ❌ Hapus pesan user (hanya miliknya sendiri)
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
     * 🧠 Helper: cek apakah user sedang mengetik (dipakai di sisi trainer)
     */
    public static function isUserTyping($userId, $trainerId)
    {
        return Cache::has("typing_user_{$userId}_to_trainer_{$trainerId}");
    }
}
