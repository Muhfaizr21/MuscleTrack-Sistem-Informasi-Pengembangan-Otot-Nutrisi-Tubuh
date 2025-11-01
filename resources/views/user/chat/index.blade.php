@extends('layouts.user')

@section('content')
<div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 shadow-sm sm:rounded-lg p-6 max-w-2xl mx-auto relative transition-all duration-300">

    {{-- 🔹 Header (Style "Dark Premium") --}}
    <div class="flex justify-between items-center mb-4">
        <h2 class="font-serif text-2xl font-bold text-white flex items-center gap-2">
            💬 Chat with <span class="text-amber-400">Trainer</span>
        </h2>
        <span id="unread-badge"
              class="text-sm px-2 py-1 rounded-full bg-red-600 text-white {{ $unreadCount == 0 ? 'hidden' : '' }}">
            🔴 {{ $unreadCount }} baru
        </span>
    </div>

    {{-- 💭 Chat Box (Style "Dark Premium") --}}
    <div id="chat-box"
         class="border border-gray-700/50 rounded-lg p-4 h-96 overflow-y-auto bg-gray-900/50 text-white transition">

        @forelse($chats as $chat)
            <div class="my-2 {{ $chat->trainer_id ? 'text-left' : 'text-right' }}">
                <div class="inline-block px-3 py-2 rounded-xl max-w-[75%] break-words
                    {{ $chat->trainer_id
                        ? 'bg-gray-800 text-white'  /* <- Style Trainer */
                        : 'bg-amber-400 text-black font-medium' /* <- Style User (Premium) */
                    }}">
                    {{ $chat->message }}
                </div>
                <p class="text-xs text-gray-400 mt-1">{{ \Carbon\Carbon::parse($chat->timestamp)->format('H:i') }}</p>
            </div>
        @empty
            <p class="text-gray-400 italic text-center mt-10">Belum ada percakapan dengan trainer.</p>
        @endforelse
        </div>

    {{-- 📝 Form Kirim (Style "Dark Premium") --}}
    <form id="chat-form" class="mt-4 flex gap-2">
        @csrf
        <input type="text" name="message" id="chat-message"
               class="flex-grow bg-gray-800 border-gray-700 rounded-lg p-2 text-white
                      focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50"
               placeholder="Ketik pesan..." required autocomplete="off">

        <button type="submit"
                class="px-5 py-2.5 rounded-md text-sm font-bold text-black bg-amber-400 hover:bg-amber-300 transition-all shadow-lg shadow-amber-500/20">
            Kirim
        </button>
    </form>

    {{-- 🔔 Notifikasi Popup (Style "Dark Premium" Emas) --}}
    <div id="notification"
         class="hidden fixed bottom-5 right-5 bg-amber-400 text-black p-4 rounded-xl shadow-lg font-bold animate-bounce">
        🔔 Pesan baru dari trainer!
    </div>

    {{-- 🎵 Suara Notifikasi (Sistem Anda aman) --}}
    <audio id="notif-sound" src="{{ asset('sounds/notification.mp3') }}"></audio>
</div>

{{-- ✅ Scripts (HANYA MENGUBAH STYLE HTML DI DALAM JS) --}}
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo/dist/echo.iife.js"></script>

<script>
const userId = {{ Auth::id() }};

// 🔹 Inisialisasi Echo (Sistem Anda aman)
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

        // Style bubble trainer (bg-gray-800)
        const msgHTML = `
            <div class="my-2 text-left">
                <div class="inline-block px-3 py-2 rounded-xl max-w-[75%] break-words
                    bg-gray-800 text-white">
                    ${e.message}
                </div>
                <p class="text-xs text-gray-400 mt-1">${e.timestamp}</p>
            </div>
        `;

        box.insertAdjacentHTML('beforeend', msgHTML);
        box.scrollTop = box.scrollHeight;

        notif.classList.remove('hidden');
        sound.play();
        setTimeout(() => notif.classList.add('hidden'), 4000);

        badge.classList.remove('hidden');
        badge.textContent = '🔴 Pesan baru';
    });

// 🔹 Kirim Pesan (Sistem Anda aman)
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

// 🔹 Tandai semua pesan dibaca otomatis (Sistem Anda aman)
setTimeout(() => axios.post("{{ route('user.chat.markAllRead') }}"), 3000);
</script>
@endsection
