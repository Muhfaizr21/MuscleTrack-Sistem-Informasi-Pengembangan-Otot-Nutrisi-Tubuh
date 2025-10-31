<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserChatController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $chats = []; // nanti ambil dari tabel chat_user
        return view('user.chat.index', compact('user', 'chats'));
    }

    public function create() { return view('user.chat.create'); }
    public function store(Request $request)
    {
        $request->validate(['message' => 'required|string|max:500']);
        // Chat::create([...]);
        return redirect()->route('user.chat.index')->with('success', 'Pesan berhasil dikirim!');
    }
    public function edit($id)
    {
        $chat = [];
        return view('user.chat.edit', compact('chat'));
    }
    public function update(Request $request, $id)
    {
        $request->validate(['message' => 'required']);
        return redirect()->route('user.chat.index')->with('success', 'Pesan diperbarui!');
    }
    public function destroy($id)
    {
        return redirect()->route('user.chat.index')->with('success', 'Pesan dihapus!');
    }
}
