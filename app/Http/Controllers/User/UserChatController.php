<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TrainerChat;
use App\Events\NewTrainerChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserChatController extends Controller
{
    /**
     * 📨 Menampilkan halaman chat user dengan trainer
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil seluruh riwayat chat antara user & trainer
        $chats = TrainerChat::where('user_id', $user->id)
            ->orderBy('timestamp', 'asc')
            ->get();

        // Hitung jumlah pesan dari trainer yang belum dibaca user
        $unreadCount = TrainerChat::where('user_id', $user->id)
            ->whereNotNull('trainer_id')
            ->where('read_status', 0)
            ->count();

        return view('user.chat.index', compact('user', 'chats', 'unreadCount'));
    }

    /**
     * 💬 Menyimpan pesan baru user & broadcast real-time
     */
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $user = Auth::user();

        // Simpan pesan user (tanpa trainer_id → berarti pesan dari user)
        $chat = TrainerChat::create([
            'user_id' => $user->id,
            'trainer_id' => null,
            'message' => $request->message,
            'read_status' => 0,
        ]);

        // Broadcast pesan baru via Pusher (real-time)
        event(new NewTrainerChatMessage($chat));

        return response()->json([
            'success' => true,
            'chat_id' => $chat->id,
            'message' => $chat->message,
            'timestamp' => $chat->timestamp->format('H:i'),
        ]);
    }

    /**
     * ✅ Menandai semua pesan dari trainer sebagai sudah dibaca
     */
    public function markAllRead()
    {
        TrainerChat::where('user_id', Auth::id())
            ->whereNotNull('trainer_id')
            ->update(['read_status' => 1]);

        return response()->json(['success' => true]);
    }

    /**
     * 🚮 (Optional) Menghapus pesan tertentu (kalau mau ditambah fitur delete chat)
     */
    public function destroy($id)
    {
        $chat = TrainerChat::findOrFail($id);

        if ($chat->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak');
        }

        $chat->delete();

        return response()->json(['success' => true]);
    }
}
