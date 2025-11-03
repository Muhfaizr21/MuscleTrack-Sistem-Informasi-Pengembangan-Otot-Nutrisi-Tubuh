<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TrainerChat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $chats = collect();
        if ($trainer) {
            $chats = TrainerChat::where('trainer_id', $trainer->id)
                ->where('user_id', $user->id)
                ->orderBy('timestamp', 'asc')
                ->get();
        }

        // 🔹 Hitung jumlah pesan belum dibaca per trainer
        $unreadCount = [];
        foreach ($trainers as $t) {
            $unreadCount[$t->id] = TrainerChat::where('trainer_id', $t->id)
                ->where('user_id', $user->id)
                ->where('read_status', false)
                ->where('sender_type', 'trainer') // hanya pesan dari trainer
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

        return view('user.chat.index', compact(
            'user',
            'trainers',
            'trainer',
            'chats',
            'unreadCount',
            'recommendedTrainers'
        ));
    }

    /**
     * 💬 Kirim pesan ke trainer
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

        // 🔹 Simpan pesan baru dengan sender_type = 'user'
        $chat = TrainerChat::create([
            'user_id'     => $user->id,
            'trainer_id'  => $request->trainer_id,
            'message'     => $request->message,
            'timestamp'   => now(),
            'read_status' => false,
            'sender_type' => 'user',
        ]);

        return response()->json([
            'success'   => true,
            'chat_id'   => $chat->id,
            'message'   => $chat->message,
            'timestamp' => $chat->timestamp->format('H:i'),
        ]);
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

        // 🔒 Hanya pesan milik user itu sendiri yang boleh dihapus
        if ($chat->user_id !== Auth::id() || $chat->sender_type !== 'user') {
            abort(403, 'Anda hanya dapat menghapus pesan yang Anda kirim.');
        }

        $chat->delete();

        return response()->json(['success' => true]);
    }
}
