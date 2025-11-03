<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\TrainerChat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * 💬 Tampilkan daftar member dan area chat
     */
    public function index(Request $request)
    {
        $trainer = Auth::user();

        // Ambil semua member yang terhubung dengan trainer
        $members = User::where('trainer_id', $trainer->id)
            ->where('role', 'user')
            ->withCount([
                'trainerChatsAsUser' => function ($query) use ($trainer) {
                    $query->where('trainer_id', $trainer->id)
                        ->where('sender_type', 'user')
                        ->where('read_status', false);
                }
            ])
            ->get();

        // Tentukan member aktif
        $user = null;
        if ($request->has('user')) {
            $user = User::find($request->user);
        } elseif ($members->count() === 1) {
            $user = $members->first();
        }

        // Ambil riwayat chat jika ada member aktif
        $chats = collect();
        if ($user) {
            $chats = TrainerChat::where('trainer_id', $trainer->id)
                ->where('user_id', $user->id)
                ->orderBy('timestamp', 'asc')
                ->get();

            // Tandai semua pesan dari user sebagai sudah dibaca
            TrainerChat::where('trainer_id', $trainer->id)
                ->where('user_id', $user->id)
                ->where('sender_type', 'user')
                ->where('read_status', false)
                ->update(['read_status' => true]);
        }

        return view('trainer.communication.chat', compact('trainer', 'members', 'user', 'chats'));
    }

    /**
     * 📨 Kirim pesan
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000',
        ]);

        $trainer = Auth::user();
        $user = User::findOrFail($request->user_id);

        if ($user->trainer_id !== $trainer->id) {
            return response()->json(['error' => 'Tidak dapat mengirim pesan ke user lain.'], 403);
        }

        $chat = TrainerChat::create([
            'trainer_id'  => $trainer->id,
            'user_id'     => $user->id,
            'message'     => $request->message,
            'sender_type' => 'trainer',
            'timestamp'   => now(),
            'read_status' => false,
        ]);

        return response()->json([
            'success'   => true,
            'chat_id'   => $chat->id,
            'message'   => $chat->message,
            'timestamp' => $chat->timestamp->format('H:i'),
        ]);
    }

    /**
     * 🗑️ Hapus pesan milik trainer
     */
    public function destroy($id)
    {
        $trainer = Auth::user();
        $chat = TrainerChat::findOrFail($id);

        if ($chat->trainer_id !== $trainer->id || $chat->sender_type !== 'trainer') {
            abort(403, 'Anda tidak dapat menghapus pesan milik member.');
        }

        $chat->delete();

        return response()->json(['success' => true]);
    }

    /**
     * ✅ Tandai semua pesan dari user sebagai sudah dibaca
     */
    public function markAllRead(Request $request)
    {
        $trainer = Auth::user();
        $userId = $request->input('user_id');

        TrainerChat::where('trainer_id', $trainer->id)
            ->where('user_id', $userId)
            ->where('sender_type', 'user')
            ->update(['read_status' => true]);

        return response()->json(['success' => true]);
    }
}
