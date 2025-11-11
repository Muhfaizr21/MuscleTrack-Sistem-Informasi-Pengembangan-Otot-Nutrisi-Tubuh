@extends('layouts.user')

@php
    use Carbon\Carbon;
@endphp

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
                {{-- 🧠 AI TRAINER --}}
                <a href="{{ route('user.chat.index', ['trainer' => 0]) }}"
                    class="flex items-center gap-3 px-4 py-3 hover:bg-gray-800/60 transition-all {{ isset($trainer) && $trainer->id == 0 ? 'bg-gray-800/80' : '' }}">
                    <div class="w-10 h-10 rounded-full overflow-hidden">
                        <img src="{{ asset('images/ai-trainer.png') }}" class="w-10 h-10 object-cover" alt="AI">
                    </div>
                    <div class="flex-1">
                        <p class="text-white font-semibold text-sm">AI Trainer</p>
                        <p class="text-amber-400 text-xs">🤖 Siap membantu latihanmu</p>
                    </div>
                </a>

                {{-- 🔹 Daftar Trainer --}}
                @forelse($trainers as $t)
                    @if($t->id !== 0)
                        <a href="{{ route('user.chat.index', ['trainer' => $t->id]) }}"
                            class="flex items-center gap-3 px-4 py-3 hover:bg-gray-800/60 transition-all {{ isset($trainer) && $trainer->id == $t->id ? 'bg-gray-800/80' : '' }}">
                            <div class="relative">
                                <div
                                    class="w-10 h-10 rounded-full bg-amber-400/20 flex items-center justify-center text-amber-400 font-bold overflow-hidden">
                                    {{ strtoupper(substr($t->name, 0, 1)) }}
                                </div>
                                <span
                                    class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-400 border border-gray-900 rounded-full"></span>
                            </div>
                            <div class="flex-1">
                                <p class="text-white font-semibold text-sm">{{ $t->name }}</p>
                                <p class="text-gray-400 text-xs truncate">
                                    {{ $t->trainerProfile->speciality ?? 'Trainer Profesional' }}
                                </p>
                            </div>
                            @if(isset($unreadCount[$t->id]) && $unreadCount[$t->id] > 0)
                                <span id="unread-badge-{{ $t->id }}" class="text-xs bg-red-600 text-white rounded-full px-2 py-0.5">
                                    {{ $unreadCount[$t->id] }}
                                </span>
                            @endif
                        </a>
                    @endif
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
                            class="w-10 h-10 rounded-full bg-amber-400/20 flex items-center justify-center text-amber-400 font-bold overflow-hidden">
                            @if($trainer->id === 0)
                                <img src="{{ asset('images/ai-trainer.png') }}" class="w-10 h-10 rounded-full object-cover"
                                    alt="AI">
                            @else
                                {{ strtoupper(substr($trainer->name, 0, 1)) }}
                            @endif
                        </div>
                        <div>
                            <h3 class="text-white font-semibold text-sm">{{ $trainer->name }}</h3>
                            @if($trainer->id === 0)
                                <p class="text-xs text-amber-400">🤖 Online (AI Trainer)</p>
                            @else
                                <p class="text-xs {{ $isTrainerTyping ? 'text-amber-400 animate-pulse' : 'text-green-400' }}">
                                    {{ $isTrainerTyping ? '✍️ Sedang mengetik...' : '🟢 Online' }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- CHAT BOX --}}
                <div id="chat-box"
                    class="flex-1 overflow-y-auto px-4 py-4 space-y-3 bg-[url('/images/chat-bg-dark.png')] bg-cover bg-center">
                    @forelse($groupedChats as $dateLabel => $chats)
                        <div class="text-center text-gray-400 text-xs font-semibold my-2">{{ $dateLabel }}</div>
                        @foreach($chats as $chat)
                            @if($chat->sender_type === 'user')
                                <div class="flex justify-end relative chat-message" id="chat-{{ $chat->id }}">
                                    <div class="text-right max-w-[80%]">
                                        <div
                                            class="bg-amber-400 text-black font-semibold px-4 py-2 rounded-2xl rounded-br-none inline-block shadow-md">
                                            {{ $chat->message }}
                                        </div>
                                        <div class="flex justify-end items-center gap-2 mt-1">
                                            <p class="text-[10px] text-gray-500">
                                                {{ Carbon::parse($chat->timestamp)->timezone('Asia/Jakarta')->format('H:i') }}
                                            </p>
                                            <button data-id="{{ $chat->id }}"
                                                class="delete-chat text-xs text-gray-500 hover:text-red-500 transition">🗑️</button>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="flex items-start gap-2 chat-message">
                                    <div
                                        class="w-8 h-8 bg-amber-400/20 rounded-full flex items-center justify-center text-amber-400 text-sm font-bold">
                                        {{ $trainer->id === 0 ? 'AI' : 'T' }}
                                    </div>
                                    <div>
                                        <div
                                            class="bg-gray-800 text-gray-100 px-4 py-2 rounded-2xl rounded-bl-none inline-block max-w-[80%]">
                                            {{ $chat->message }}
                                        </div>
                                        <p class="text-[10px] text-gray-500 mt-1">
                                            {{ Carbon::parse($chat->timestamp)->timezone('Asia/Jakarta')->format('H:i') }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @empty
                        <p class="text-gray-400 italic text-center mt-10">
                            Belum ada percakapan dengan {{ $trainer->name ?? 'trainer ini' }}.
                        </p>
                    @endforelse
                </div>

                {{-- INPUT BAR --}}
                <form id="chat-form" class="flex items-center gap-3 p-4 bg-gray-900/70 border-t border-gray-800">
                    @csrf
                    <input type="hidden" name="trainer_id" value="{{ $trainer->id }}">
                    <input type="text" name="message" id="chat-message"
                        class="flex-grow bg-gray-800/80 border border-gray-700 rounded-full px-4 py-2 text-white placeholder-gray-400 focus:border-amber-400 focus:ring focus:ring-amber-400/40"
                        placeholder="Ketik pesan..." required autocomplete="off">

                    {{-- 📨 Tombol Kirim (ikon panah mirip WhatsApp) --}}
                    <button type="submit"
                        class="flex items-center justify-center w-10 h-10 bg-amber-400 hover:bg-amber-300 rounded-full shadow-lg transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                            class="w-5 h-5 text-black transform rotate-45">
                            <path d="M3.4 20.6L21 12 3.4 3.4 4.8 10 13 12l-8.2 2z" />
                        </svg>
                    </button>
                </form>
            @endif
        </div>
    </div>

    {{-- 🔔 SCRIPT --}}
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        @if(isset($trainer))
            document.addEventListener('DOMContentLoaded', async () => {
                const chatBox = document.getElementById('chat-box');
                if (chatBox) chatBox.scrollTop = chatBox.scrollHeight;

                try {
                    await axios.post("{{ route('user.chat.markAllRead') }}", {
                        trainer_id: {{ $trainer->id }},
                        _token: "{{ csrf_token() }}"
                    });
                    const badge = document.getElementById('unread-badge-{{ $trainer->id }}');
                    if (badge) badge.remove();
                } catch (err) {
                    console.warn('Gagal menandai pesan terbaca:', err);
                }
            });

            const chatForm = document.getElementById('chat-form');
            const chatInput = document.getElementById('chat-message');
            const chatBox = document.getElementById('chat-box');
            const currentTrainerId = {{ $trainer->id }};
            const isAiMode = (currentTrainerId === 0);

            chatForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const message = chatInput.value.trim();
                if (!message) return;

                const localTime = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
                let loadingId = null;

                if (isAiMode) {
                    chatBox.insertAdjacentHTML('beforeend', `
                        <div class="flex justify-end relative chat-message">
                            <div class="text-right max-w-[80%]">
                                <div class="bg-amber-400 text-black font-semibold px-4 py-2 rounded-2xl rounded-br-none inline-block shadow-md">${message}</div>
                                <p class="text-[10px] text-gray-500 mt-1">${localTime}</p>
                            </div>
                        </div>
                    `);
                    loadingId = `ai-loading-${Date.now()}`;
                    chatBox.insertAdjacentHTML('beforeend', `
                        <div class="flex items-start gap-2 chat-message" id="${loadingId}">
                            <div class="w-8 h-8 bg-amber-400/20 rounded-full flex items-center justify-center text-amber-400 text-sm font-bold">AI</div>
                            <div class="bg-gray-800 text-gray-400 px-4 py-2 rounded-2xl rounded-bl-none inline-block max-w-[80%]">
                                <span class="animate-pulse">Sedang mengetik...</span>
                            </div>
                        </div>
                    `);
                }

                chatInput.value = '';
                chatBox.scrollTop = chatBox.scrollHeight;

                try {
                    const res = await axios.post("{{ route('user.chat.store') }}", { message, trainer_id: currentTrainerId });

                    if (isAiMode) {
                        document.getElementById(loadingId)?.remove();
                        chatBox.insertAdjacentHTML('beforeend', `
                            <div class="flex items-start gap-2 chat-message">
                                <div class="w-8 h-8 bg-amber-400/20 rounded-full flex items-center justify-center text-amber-400 text-sm font-bold">AI</div>
                                <div class="bg-gray-800 text-gray-100 px-4 py-2 rounded-2xl rounded-bl-none inline-block max-w-[80%]">${res.data.ai_message}</div>
                            </div>
                        `);
                    } else {
                        chatBox.insertAdjacentHTML('beforeend', `
                            <div class="flex justify-end relative chat-message" id="chat-${res.data.chat_id}">
                                <div class="text-right max-w-[80%]">
                                    <div class="bg-amber-400 text-black font-semibold px-4 py-2 rounded-2xl rounded-br-none inline-block shadow-md">${res.data.message}</div>
                                    <div class="flex justify-end items-center gap-2 mt-1">
                                        <p class="text-[10px] text-gray-500">${res.data.local_time}</p>
                                        <button data-id="${res.data.chat_id}" class="delete-chat text-xs text-gray-500 hover:text-red-500 transition">🗑️</button>
                                    </div>
                                </div>
                            </div>
                        `);
                    }
                    chatBox.scrollTop = chatBox.scrollHeight;
                } catch (err) {
                    console.error(err);
                    alert('Gagal mengirim pesan!');
                    if (loadingId) document.getElementById(loadingId)?.remove();
                }
            });

            // 🗑️ Hapus Pesan
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