@extends('layouts.user')

@section('content')
    <div
        class="flex h-[80vh] max-w-6xl mx-auto bg-gray-950/80 border border-gray-800 rounded-2xl shadow-2xl overflow-hidden">

        {{-- 🔹 SIDEBAR TRAINER LIST --}}
        <div class="w-1/3 border-r border-gray-800 flex flex-col bg-gray-900/70">
            <div class="p-4 border-b border-gray-800">
                <h2 class="font-serif text-lg text-white font-bold">💬 Chat Trainer</h2>
            </div>

            <div class="p-3">
                <input type="text" placeholder="Cari trainer..."
                    class="w-full rounded-full bg-gray-800 border border-gray-700 text-gray-300 text-sm px-4 py-2 focus:ring-amber-400 focus:border-amber-400">
            </div>

            <div class="flex-1 overflow-y-auto">
                @forelse($trainers as $t)
                    <a href="{{ route('user.chat.index', ['trainer' => $t->id]) }}"
                        class="flex items-center gap-3 px-4 py-3 hover:bg-gray-800/60 transition-all {{ isset($trainer) && $trainer->id == $t->id ? 'bg-gray-800/80' : '' }}">
                        <div class="relative">
                            <div
                                class="w-10 h-10 rounded-full bg-amber-400/20 flex items-center justify-center text-amber-400 font-bold">
                                {{ strtoupper(substr($t->name, 0, 1)) }}
                            </div>
                            <span
                                class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-400 border border-gray-900 rounded-full"></span>
                        </div>
                        <div class="flex-1">
                            <p class="text-white font-semibold text-sm">{{ $t->name }}</p>
                            <p class="text-gray-400 text-xs truncate">
                                {{ $t->trainerProfile->specialization ?? 'Trainer Profesional' }}</p>
                        </div>
                        @if(isset($unreadCount[$t->id]) && $unreadCount[$t->id] > 0)
                            <span class="text-xs bg-red-600 text-white rounded-full px-2 py-0.5">
                                {{ $unreadCount[$t->id] }}
                            </span>
                        @endif
                    </a>
                @empty
                    <p class="text-gray-400 text-center mt-6">Belum ada chat aktif.</p>
                @endforelse
            </div>
        </div>

        {{-- 🔹 MAIN CHAT AREA --}}
        <div class="flex-1 flex flex-col">
            @if(isset($trainer))
                {{-- HEADER --}}
                <div class="flex items-center justify-between px-4 py-3 border-b border-gray-800 bg-gray-900/70">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-full bg-amber-400/20 flex items-center justify-center text-amber-400 font-bold">
                            {{ strtoupper(substr($trainer->name, 0, 1)) }}
                        </div>
                        <div>
                            <h3 class="text-white font-semibold text-sm">{{ $trainer->name }}</h3>
                            <p class="text-xs text-green-400">🟢 Online</p>
                        </div>
                    </div>
                </div>

                {{-- CHAT BOX --}}
                <div id="chat-box"
                    class="flex-1 overflow-y-auto px-4 py-4 space-y-3 bg-[url('/images/chat-bg-dark.png')] bg-cover bg-center">
                    @forelse($chats as $chat)
                        @if($chat->sender_type === 'user')
                            {{-- 💬 USER MESSAGE (KANAN) --}}
                            <div class="flex justify-end relative chat-message" id="chat-{{ $chat->id }}">
                                <div class="text-right max-w-[80%]">
                                    <div
                                        class="bg-amber-400 text-black font-semibold px-4 py-2 rounded-2xl rounded-br-none inline-block shadow-md">
                                        {{ $chat->message }}
                                    </div>
                                    <div class="flex justify-end items-center gap-2 mt-1">
                                        <p class="text-[10px] text-gray-500">{{ $chat->timestamp->format('H:i') }}</p>
                                        {{-- Tombol hapus hanya untuk pesan milik user --}}
                                        <button data-id="{{ $chat->id }}"
                                            class="delete-chat text-xs text-gray-500 hover:text-red-500 transition">🗑️</button>
                                    </div>
                                </div>
                            </div>
                        @elseif($chat->sender_type === 'trainer')
                            {{-- 🧑‍🏫 TRAINER MESSAGE (KIRI) --}}
                            <div class="flex items-start gap-2 chat-message">
                                <div
                                    class="w-8 h-8 bg-amber-400/20 rounded-full flex items-center justify-center text-amber-400 text-sm font-bold">
                                    T
                                </div>
                                <div>
                                    <div
                                        class="bg-gray-800 text-gray-100 px-4 py-2 rounded-2xl rounded-bl-none inline-block max-w-[80%]">
                                        {{ $chat->message }}
                                    </div>
                                    <p class="text-[10px] text-gray-500 mt-1">{{ $chat->timestamp->format('H:i') }}</p>
                                </div>
                            </div>
                        @endif
                    @empty
                        <p class="text-gray-400 italic text-center mt-10">Belum ada percakapan dengan {{ $trainer->name }}.</p>
                    @endforelse
                </div>

                {{-- INPUT BAR --}}
                <form id="chat-form" class="flex items-center gap-3 p-4 bg-gray-900/70 border-t border-gray-800">
                    @csrf
                    <input type="hidden" name="trainer_id" value="{{ $trainer->id }}">
                    <input type="text" name="message" id="chat-message"
                        class="flex-grow bg-gray-800/80 border border-gray-700 rounded-full px-4 py-2 text-white placeholder-gray-400 focus:border-amber-400 focus:ring focus:ring-amber-400/40"
                        placeholder="Ketik pesan..." required autocomplete="off">
                    <button type="submit"
                        class="flex items-center justify-center w-10 h-10 bg-amber-400 hover:bg-amber-300 rounded-full shadow-lg transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-black" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path d="M2.94 2.94a.75.75 0 011.06 0L17.5 16.44a.75.75 0 11-1.06 1.06L2.94 4a.75.75 0 010-1.06z" />
                        </svg>
                    </button>
                </form>
            @endif
        </div>
    </div>

    {{-- 🔔 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        @if(isset($trainer))
            // Kirim pesan
            document.getElementById('chat-form').addEventListener('submit', async (e) => {
                e.preventDefault();
                const input = document.getElementById('chat-message');
                const message = input.value.trim();
                if (!message) return;

                try {
                    const res = await axios.post("{{ route('user.chat.store') }}", {
                        message: message,
                        trainer_id: {{ $trainer->id }}
                    });

                    const box = document.getElementById('chat-box');
                    box.insertAdjacentHTML('beforeend', `
                        <div class="flex justify-end relative chat-message" id="chat-${res.data.chat_id}">
                            <div class="text-right max-w-[80%]">
                                <div class="bg-amber-400 text-black font-semibold px-4 py-2 rounded-2xl rounded-br-none inline-block shadow-md">
                                    ${message}
                                </div>
                                <div class="flex justify-end items-center gap-2 mt-1">
                                    <p class="text-[10px] text-gray-500">Baru saja</p>
                                    <button data-id="${res.data.chat_id}" 
                                            class="delete-chat text-xs text-gray-500 hover:text-red-500 transition">🗑️</button>
                                </div>
                            </div>
                        </div>
                    `);
                    box.scrollTop = box.scrollHeight;
                    input.value = '';
                } catch {
                    alert('Gagal mengirim pesan!');
                }
            });

            // Hapus pesan user
            document.addEventListener('click', async (e) => {
                if (e.target.classList.contains('delete-chat')) {
                    const chatId = e.target.dataset.id;
                    const chatEl = document.getElementById(`chat-${chatId}`);
                    if (confirm('Hapus pesan ini?')) {
                        chatEl.classList.add('opacity-0', 'translate-y-2', 'transition', 'duration-300');
                        setTimeout(async () => {
                            await axios.delete(`/user/chat/${chatId}`);
                            chatEl.remove();
                        }, 300);
                    }
                }
            });
        @endif
    </script>
@endsection