@extends('layouts.user')
@section('title', 'Cari Trainer')

@section('content')
<div class="max-w-6xl mx-auto mt-8 p-6 bg-gray-900/80 border border-gray-800 rounded-2xl shadow-xl">
    <h1 class="text-2xl font-bold text-white mb-6">🏋️ Cari Trainer Profesional</h1>

    {{-- 🔍 Form Pencarian Trainer --}}
    <form method="GET" class="mb-6">
        <input type="text" name="search" placeholder="Cari nama trainer..." value="{{ request('search') }}"
            class="w-full bg-gray-800 text-gray-200 rounded-full px-4 py-2 border border-gray-700 focus:ring-amber-400">
    </form>

    {{-- 🔹 Daftar Trainer --}}
    @if($trainers->isEmpty())
        <p class="text-gray-400 text-center py-10">Belum ada trainer yang tersedia saat ini.</p>
    @else
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
            @foreach($trainers as $trainer)
                <div class="bg-gray-800 p-4 rounded-2xl border border-gray-700 hover:border-amber-400 transition">
                    <div class="flex items-center gap-3 mb-3">
                        @if($trainer->avatar)
                            <img src="{{ asset($trainer->avatar) }}" alt="{{ $trainer->name }}"
                                class="w-12 h-12 rounded-full object-cover border border-amber-400/30">
                        @else
                            <div class="w-12 h-12 bg-amber-400/20 text-amber-400 rounded-full flex items-center justify-center text-xl font-bold">
                                {{ strtoupper(substr($trainer->name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <h3 class="text-white font-semibold">{{ $trainer->name }}</h3>
                            <p class="text-gray-400 text-sm">
                                {{ $trainer->trainerProfile->speciality ?? 'Trainer Profesional' }}
                            </p>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm mb-4 line-clamp-3">
                        {{ $trainer->trainerProfile->bio ?? 'Belum ada deskripsi.' }}
                    </p>
                    <a href="{{ route('user.training.show', $trainer->id) }}"
                        class="block text-center bg-amber-400 text-black py-2 rounded-full font-semibold hover:bg-amber-300 transition">
                        Lihat Detail
                    </a>
                </div>
            @endforeach
        </div>
        <div class="mt-6">{{ $trainers->links() }}</div>
    @endif

    {{-- 💬 Chat AI Mini --}}
    <div id="ai-chat" class="mt-10 p-6 bg-gray-800 rounded-2xl border border-gray-700">
        <h2 class="text-xl font-semibold text-white mb-4">💬 Chat AI Trainer (Maks. 5 Pesan)</h2>
        <div id="chat-box" class="h-64 overflow-y-auto bg-gray-900 border border-gray-700 rounded-lg p-4 text-gray-300 mb-4">
            <p class="text-gray-500">AI Trainer siap membantu kamu memilih pelatih terbaik 💪</p>
        </div>

        <div class="flex gap-3">
            <input id="chat-input" type="text" placeholder="Ketik pesan..." 
                class="flex-1 bg-gray-700 text-white px-4 py-2 rounded-full focus:outline-none focus:ring focus:ring-amber-400">
            <button id="chat-send" 
                class="bg-amber-400 text-black font-semibold px-4 py-2 rounded-full hover:bg-amber-300 transition">
                ➤
            </button>
        </div>
    </div>
</div>

{{-- ⚙️ Script Chat AI --}}
<script>
    let messageCount = 0;
    const maxMessages = 5;
    const chatBox = document.getElementById('chat-box');
    const input = document.getElementById('chat-input');
    const sendBtn = document.getElementById('chat-send');

    async function sendMessage() {
        const text = input.value.trim();
        if (!text) return;

        if (messageCount >= maxMessages) {
            chatBox.innerHTML += `<p class='text-red-400 mt-2'>🚫 Batas 5 pesan telah tercapai. Silakan order trainer untuk melanjutkan.</p>`;
            return;
        }

        // 🗣️ Tampilkan pesan user
        chatBox.innerHTML += `<p class="text-amber-300 mt-2"><b>Kamu:</b> ${text}</p>`;
        input.value = '';
        messageCount++;
        chatBox.scrollTop = chatBox.scrollHeight;

        // 💬 Loading sementara
        chatBox.innerHTML += `<p id="loading" class="text-gray-500 italic">AI Trainer sedang mengetik...</p>`;
        chatBox.scrollTop = chatBox.scrollHeight;

        try {
            // 🔗 Kirim ke backend (route dari web.php)
            const response = await fetch("{{ route('user.training.ai.chat') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ message: text })
            });

            const data = await response.json();

            document.getElementById('loading').remove();
            chatBox.innerHTML += `<p class="text-gray-300 mt-2"><b>AI:</b> ${data.reply}</p>`;
            chatBox.scrollTop = chatBox.scrollHeight;
        } catch (err) {
            document.getElementById('loading').remove();
            chatBox.innerHTML += `<p class="text-red-400 mt-2">❌ Terjadi kesalahan, coba lagi nanti.</p>`;
        }
    }

    sendBtn.addEventListener('click', sendMessage);
    input.addEventListener('keypress', e => {
        if (e.key === 'Enter') sendMessage();
    });
</script>
@endsection
