@extends('layouts.trainer')

@section('title', 'Chat dengan ' . $user->name)

@section('content')
<div class="bg-white shadow rounded-2xl p-6">
    <h1 class="text-2xl font-semibold mb-4">💬 Chat dengan {{ $user->name }}</h1>

    <div id="chat-box" class="border rounded-lg p-4 h-96 overflow-y-auto bg-gray-50 mb-4">
        @foreach ($chats as $msg)
            <div class="mb-3 {{ $msg->trainer_id === Auth::id() ? 'text-right' : 'text-left' }}">
                <div class="inline-block px-3 py-2 rounded-lg
                    {{ $msg->trainer_id === Auth::id() ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-800' }}">
                    {{ $msg->message }}
                </div>
                <div class="text-xs text-gray-500 mt-1">
                    {{ $msg->timestamp->format('H:i') }}
                </div>
            </div>
        @endforeach
    </div>

    <form id="chat-form" class="flex gap-3">
        @csrf
        <input type="hidden" name="user_id" value="{{ $user->id }}">
        <input type="text" name="message" placeholder="Tulis pesan..." class="flex-1 border rounded-lg p-2 focus:ring focus:ring-blue-200">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Kirim</button>
    </form>
</div>

{{-- Realtime JS --}}
<script>
window.userId = {{ Auth::id() }};
const chatBox = document.getElementById('chat-box');
const form = document.getElementById('chat-form');

form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(form);
    const res = await fetch('{{ route('trainer.communication.chat.store') }}', {
        method: 'POST',
        headers: {'X-CSRF-TOKEN': formData.get('_token')},
        body: formData
    });
    const data = await res.json();
    if (data.success) {
        appendMessage(data.data.message, true);
        form.reset();
    }
});

function appendMessage(message, isOwn) {
    const div = document.createElement('div');
    div.className = 'mb-3 ' + (isOwn ? 'text-right' : 'text-left');
    div.innerHTML = `
        <div class="inline-block px-3 py-2 rounded-lg ${isOwn ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-800'}">
            ${message}
        </div>
    `;
    chatBox.appendChild(div);
    chatBox.scrollTop = chatBox.scrollHeight;
}

// Listen for broadcast
window.Echo.private('chat.{{ $user->id }}')
    .listen('.new-trainer-chat-message', (e) => {
        if (e.trainer_id !== window.userId) {
            appendMessage(e.message, false);
        }
    });
</script>
@endsection
