<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TrainerChat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserChatController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        /**
         * 🔹 Ambil semua trainer yang benar-benar punya hubungan membership
         * dengan user saat ini (bukan pending / belum terhubung)
         */
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
            $chats = TrainerChat::between($trainer->id, $user->id)->get();
        }

        // 🔹 Hitung pesan belum dibaca per trainer
        $unreadCount = [];
        foreach ($trainers as $t) {
            $unreadCount[$t->id] = TrainerChat::where('trainer_id', $t->id)
                ->where('user_id', $user->id)
                ->where('read_status', 0)
                ->count();
        }

        // 🔹 Jika belum punya trainer → tampilkan rekomendasi trainer yang verified
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

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'trainer_id' => 'required|exists:users,id',
        ]);

        $user = Auth::user();

        // 🔒 Pastikan user benar-benar punya hubungan dengan trainer ini
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

        // 🔹 Simpan pesan baru
        $chat = TrainerChat::create([
            'user_id' => $user->id,
            'trainer_id' => $request->trainer_id,
            'message' => $request->message,
            'timestamp' => now(),
            'read_status' => 0,
        ]);

        return response()->json([
            'success' => true,
            'chat_id' => $chat->id,
            'message' => $chat->message,
            'timestamp' => $chat->timestamp->format('H:i'),
        ]);
    }

    public function markAllRead(Request $request)
    {
        $user = Auth::user();
        $trainerId = $request->input('trainer_id');

        TrainerChat::where('user_id', $user->id)
            ->where('trainer_id', $trainerId)
            ->update(['read_status' => 1]);

        return response()->json(['success' => true]);
    }
    public function destroy($id)
    {
        $chat = TrainerChat::findOrFail($id);

        if ($chat->user_id !== Auth::id()) {
            abort(403, 'Tidak diizinkan');
        }

        $chat->delete();

        return response()->json(['success' => true]);
    }
}
