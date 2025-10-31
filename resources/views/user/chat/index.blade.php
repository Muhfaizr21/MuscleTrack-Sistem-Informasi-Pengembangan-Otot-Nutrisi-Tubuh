@extends('layouts.user')

@section('content')
<div class="bg-white rounded-xl shadow p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold text-indigo-700">💬 Chat with Trainer</h2>
        <a href="{{ route('user.chat.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
            + New Chat
        </a>
    </div>

    @if($chats->count())
        <ul>
            @foreach($chats as $chat)
                <li class="border-b py-2 flex justify-between">
                    <span>{{ $chat->message }}</span>
                    <a href="{{ route('user.chat.edit', $chat->id) }}" class="text-indigo-600 hover:underline">Edit</a>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-gray-500">Belum ada pesan.</p>
    @endif
</div>
@endsection
