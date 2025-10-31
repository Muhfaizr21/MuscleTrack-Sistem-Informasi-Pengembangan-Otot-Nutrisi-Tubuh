@extends('layouts.user')

@section('content')
<div class="bg-white dark:bg-gray-900 shadow-md rounded-2xl p-6 max-w-2xl mx-auto relative">

    {{-- 🔹 Header --}}
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-indigo-700 dark:text-indigo-300 flex items-center gap-2">
            💬 Chat with Trainer
        </h2>
        <span id="unread-badge"
              class="text-sm px-2 py-1 rounded-full bg-red-600 text-white {{ $unreadCount == 0 ? 'hidden' : '' }}">
            🔴 {{ $unreadCount }} baru
        </span>
    </div>

    {{-- 💭 Chat Box --}}
    <div id="chat-box"
         class="border rounded-lg p-4 h-96 overflow-y-auto bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 transition">
        @forelse($chats as $chat)
            <div class="my-2 {{ $chat->trainer_id ? 'text-left' : 'text-right' }}">
                <div class="inline-block px-3 py-2 rounded-xl max-w-[75%] break-words
                    {{ $chat->trainer_id 
                        ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' 
                        : 'bg-indigo-600 text-white' }}">
                    {{ $chat->message }}
                </div>
                <p class="text-xs text-gray-400 mt-1">{{ \Carbon\Carbon::parse($chat->timestamp)->format('H:i') }}</p>
            </div>
        @empty
            <p class="text-gray-500 dark:text-gray-400 italic text-center mt-10">Belum ada percakapan dengan trainer.</p>
        @endforelse
    </div>

    {{-- 📝 Form Kirim --}}
    <form id="chat-form" class="mt-4 flex gap-2">
        @csrf
        <input type="text" name="message" id="chat-message"
               class="flex-grow border rounded-lg p-2 dark:bg-gray-700 dark:text-white"
               placeholder="Ketik pesan..." required autocomplete="off">
        <button type="submit"
                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition">
            Kirim
        </button>
    </form>

    {{-- 🔔 Notifikasi Popup --}}
    <div id="notification"
         class="hidden fixed bottom-5 right-5 bg-indigo-600 text-white p-4 rounded-xl shadow-lg animate-bounce">
        🔔 Pesan baru dari trainer!
    </div>

    {{-- 🎵 Suara Notifikasi --}}
    <audio id="notif-sound" src="{{ asset('sounds/notification.mp3') }}"></audio>
</div>

{{-- ✅ Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo/dist/echo.iife.js"></script>

<script>
const userId = {{ Auth::id() }};

// 🔹 Inisialisasi Echo (Pusher)
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: "{{ config('broadcasting.connections.pusher.key') }}",
    cluster: "{{ config('broadcasting.connections.pusher.options.cluster') }}",
    forceTLS: true
});

// 🔹 Listener Pesan Baru
window.Echo.private(`chat.${userId}`)
    .listen('.new-trainer-chat-message', (e) => {
        const box = document.getElementById('chat-box');
        const notif = document.getElementById('notification');
        const sound = document.getElementById('notif-sound');
        const badge = document.getElementById('unread-badge');

        // Tambahkan pesan baru
        const msgHTML = `
            <div class="my-2 text-left">
                <div class="inline-block px-3 py-2 rounded-xl max-w-[75%] break-words 
                    bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white">
                    ${e.message}
                </div>
                <p class="text-xs text-gray-400 mt-1">${e.timestamp}</p>
            </div>
        `;
        box.insertAdjacentHTML('beforeend', msgHTML);
        box.scrollTop = box.scrollHeight;

        // Tampilkan notifikasi visual + suara
        notif.classList.remove('hidden');
        sound.play();
        setTimeout(() => notif.classList.add('hidden'), 4000);

        // Update badge 🔴
        badge.classList.remove('hidden');
        badge.textContent = '🔴 Pesan baru';
    });

// 🔹 Kirim Pesan
document.getElementById('chat-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const input = document.getElementById('chat-message');
    const message = input.value.trim();
    if (!message) return;

    try {
        await axios.post("{{ route('user.chat.store') }}", { message });
        input.value = '';
    } catch (err) {
        alert('Gagal mengirim pesan!');
    }
});

// 🔹 Tandai semua pesan dibaca otomatis
setTimeout(() => axios.post("{{ route('user.chat.markAllRead') }}"), 3000);
</script>
@endsection
