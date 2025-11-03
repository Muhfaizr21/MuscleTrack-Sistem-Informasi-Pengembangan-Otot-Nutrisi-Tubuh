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
     * 📋 Daftar member yang bisa diajak chat
     */
    public function index()
    {
        $trainer = Auth::user();

        // Ambil semua member yang dimiliki oleh trainer ini
        $members = User::where('trainer_id', $trainer->id)
            ->where('role', 'user')
            ->withCount([
                'trainerChatsAsUser' => function ($query) use ($trainer) {
                    // Hitung pesan yang dikirim oleh user (member) dan belum dibaca trainer
                    $query->where('trainer_id', $trainer->id)
                        ->where('read_status', false)
                        ->where('sender_type', 'user');
                }
            ])
            ->get();

        return view('trainer.communication.chat', compact('trainer', 'members'));
    }

    /**
     * 💬 Menampilkan riwayat chat dengan member tertentu
     */
    public function show($userId)
    {
        $trainer = Auth::user();
        $user = User::findOrFail($userId);

        // Cegah akses ke user yang bukan member trainer
        if ($user->trainer_id !== $trainer->id) {
            abort(403, 'Anda tidak memiliki akses ke chat ini.');
        }

        // Ambil semua chat antara trainer dan user ini
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

        return view('trainer.communication.chat-show', compact('trainer', 'user', 'chats'));
    }

    /**
     * 📨 Kirim pesan ke member
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000',
        ]);

        $trainer = Auth::user();
        $user = User::findOrFail($request->user_id);

        // Pastikan user ini memang member trainer
        if ($user->trainer_id !== $trainer->id) {
            abort(403, 'Tidak dapat mengirim pesan ke user yang bukan member Anda.');
        }

        // Simpan pesan baru dengan sender_type otomatis 'trainer'
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
            'sender'    => $chat->sender_type,
            'timestamp' => $chat->timestamp->format('H:i'),
        ]);
    }

    /**
     * ❌ Hapus chat milik trainer
     */
    public function destroy($id)
    {
        $trainer = Auth::user();
        $chat = TrainerChat::findOrFail($id);

        // Trainer hanya dapat menghapus pesan yang dia kirim
        if ($chat->trainer_id !== $trainer->id || $chat->sender_type !== 'trainer') {
            abort(403, 'Anda tidak dapat menghapus pesan milik member.');
        }

        $chat->delete();

        return response()->json(['success' => true]);
    }
}
