<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\TrainerChat;
use App\Models\User;
use App\Events\NewTrainerChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $trainer = Auth::user();
        $members = User::where('trainer_id', $trainer->id)->where('role', 'user')->get();

        return view('trainer.communication.chat', compact('members'));
    }

    public function show($userId)
    {
        $trainer = Auth::user();
        $user = User::findOrFail($userId);

        if ($user->trainer_id !== $trainer->id) {
            abort(403, 'Anda tidak memiliki akses ke chat ini.');
        }

        $chats = TrainerChat::between($trainer->id, $user->id)->get();

        return view('trainer.communication.chat-show', compact('user', 'chats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000',
        ]);

        $chat = TrainerChat::create([
            'trainer_id' => Auth::id(),
            'user_id' => $request->user_id,
            'message' => $request->message,
            'timestamp' => now(),
            'read_status' => false,
        ]);

        // Broadcast pesan realtime
        broadcast(new NewTrainerChatMessage($chat))->toOthers();

        return response()->json(['success' => true, 'data' => $chat]);
    }
}
