    @extends('layouts.trainer')

    @section('title', '💬 Chat Member')

    @section('content')
        <div class="flex h-[80vh] max-w-6xl mx-auto bg-gray-950 border border-gray-800 rounded-2xl shadow-2xl overflow-hidden">

            {{-- 🔹 SIDEBAR MEMBER LIST --}}
            <div class="w-1/3 border-r border-gray-800 flex flex-col bg-gray-900/80">
                <div class="p-4 border-b border-gray-800 flex items-center justify-between">
                    <h2 class="font-serif text-lg text-white font-bold">💬 Chat Member</h2>
                </div>

                {{-- 🔍 Search --}}
                <div class="p-3">
                    <input type="text" placeholder="Cari member..." class="w-full rounded-full bg-gray-800 border border-gray-700 text-gray-300 text-sm px-4 py-2
                            focus:ring-amber-400 focus:border-amber-400 outline-none">
                </div>

                {{-- 👥 Member List --}}
                <div class="flex-1 overflow-y-auto">
                    @forelse($members as $m)
                        <a href="{{ route('trainer.communication.chat.index', ['user' => $m->id]) }}"
                            class="flex items-center gap-3 px-4 py-3 hover:bg-gray-800/60 transition-all {{ isset($user) && $user->id == $m->id ? 'bg-gray-800/80' : '' }}">
                            <div class="relative">
                                <div class="w-10 h-10 rounded-full bg-amber-400/20 flex items-center justify-center
                                                text-amber-400 font-bold">
                                    {{ strtoupper(substr($m->name, 0, 1)) }}
                                </div>
                                <span
                                    class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-400 border border-gray-900 rounded-full"></span>
                            </div>
                            <div class="flex-1">
                                <p class="text-white font-semibold text-sm">{{ $m->name }}</p>
                                <p class="text-gray-400 text-xs truncate">Klik untuk membuka chat</p>
                            </div>
                            @if(($m->trainer_chats_as_user_count ?? 0) > 0)
                                <span class="text-xs bg-red-600 text-white rounded-full px-2 py-0.5">
                                    {{ $m->trainer_chats_as_user_count }}
                                </span>
                            @endif
                        </a>
                    @empty
                        <p class="text-gray-400 text-center mt-6">Belum ada member yang terhubung.</p>
                    @endforelse
                </div>
            </div>

            {{-- 🔹 MAIN CHAT AREA --}}
            <div class="flex-1 flex flex-col bg-gray-950">
                @if(isset($user))
                    {{-- HEADER --}}
                    <div class="flex items-center justify-between px-4 py-3 border-b border-gray-800 bg-gray-900/70">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-400 font-bold">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <h3 class="text-white font-semibold text-sm">{{ $user->name }}</h3>
                                <p class="text-xs text-green-400">🟢 Online</p>
                            </div>
                        </div>

                        {{-- 🗓️ Filter tanggal --}}
                        @if(isset($availableDates) && $availableDates->count())
                            <form method="GET" class="flex items-center gap-2">
                                <input type="hidden" name="user" value="{{ $user->id }}">
                                <select name="date" onchange="this.form.submit()"
                                    class="bg-gray-800 text-gray-300 border border-gray-700 text-sm rounded-lg px-2 py-1 focus:border-blue-500 focus:ring focus:ring-blue-500/30">
                                    <option value="">Semua Tanggal</option>
                                    @foreach($availableDates as $date)
                                        <option value="{{ $date }}" {{ ($dateFilter ?? '') === $date ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        @endif
                    </div>

                    {{-- CHAT BOX --}}
                    <div id="chat-box"
                        class="flex-1 overflow-y-auto px-5 py-4 space-y-4 bg-[url('/images/chat-bg-dark.png')] bg-cover bg-center">

                        @php $currentDate = null; @endphp

                        @forelse($chats as $chat)
                            {{-- 🗓️ Tanggal Chat --}}
                            @if($currentDate !== $chat->timestamp->toDateString())
                                @php $currentDate = $chat->timestamp->toDateString(); @endphp
                                <div class="text-center text-gray-400 text-xs my-3">
                                    {{ \Carbon\Carbon::parse($currentDate)->translatedFormat('d F Y') }}
                                </div>
                            @endif

                            {{-- 💬 TRAINER MESSAGE (RIGHT) --}}
                            @if($chat->sender_type === 'trainer')
                                <div class="flex justify-end relative chat-message" id="chat-{{ $chat->id }}">
                                    <div class="text-right max-w-[75%]">
                                        <div class="bg-blue-600 text-white px-4 py-2 rounded-2xl rounded-br-none inline-block shadow-md">
                                            {{ $chat->message }}
                                        </div>
                                        <div class="flex justify-end items-center gap-2 mt-1">
                                            <p class="text-[10px] text-gray-400">{{ $chat->timestamp->format('H:i') }}</p>
                                            <button data-id="{{ $chat->id }}"
                                                class="delete-chat text-xs text-gray-500 hover:text-red-500 transition">🗑️</button>
                                        </div>
                                    </div>
                                </div>

                                {{-- 🧑‍💼 USER MESSAGE (LEFT) --}}
                            @elseif($chat->sender_type === 'user')
                                <div class="flex items-start gap-2 chat-message">
                                    <div
                                        class="w-8 h-8 bg-gray-700/50 rounded-full flex items-center justify-center text-gray-300 text-sm font-bold">
                                        U
                                    </div>
                                    <div>
                                        <div
                                            class="bg-black/90 text-white px-4 py-2 rounded-2xl rounded-bl-none inline-block max-w-[75%] shadow-md border border-gray-700">
                                            {{ $chat->message }}
                                        </div>
                                        <p class="text-[10px] text-gray-500 mt-1">{{ $chat->timestamp->format('H:i') }}</p>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <p class="text-gray-400 italic text-center mt-10">Belum ada percakapan dengan {{ $user->name }}.</p>
                        @endforelse

                        {{-- 💭 Typing indicator --}}
                        <div id="typing-indicator" class="hidden text-gray-400 text-xs italic mt-2 text-left animate-pulse">
                            Trainer sedang mengetik...
                        </div>
                    </div>

                    {{-- INPUT BAR --}}
                    <form id="chat-form" class="flex items-center gap-3 p-4 bg-gray-900/80 border-t border-gray-800">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <input type="text" name="message" id="chat-message"
                            class="flex-grow bg-gray-800 border border-gray-700 rounded-full px-4 py-2 text-white placeholder-gray-400 focus:border-blue-400 focus:ring focus:ring-blue-400/30 outline-none"
                            placeholder="Ketik pesan..." required autocomplete="off">
                        <button type="submit"
                            class="flex items-center justify-center w-10 h-10 bg-blue-600 hover:bg-blue-500 rounded-full shadow-md transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path d="M2.94 2.94a.75.75 0 011.06 0L17.5 16.44a.75.75 0 11-1.06 1.06L2.94 4a.75.75 0 010-1.06z" />
                            </svg>
                        </button>
                    </form>
                @else
                    {{-- STATE: BELUM MEMILIH MEMBER --}}
                    <div class="flex-1 flex flex-col items-center justify-center bg-gray-950/80 text-gray-400">
                        <div class="text-center p-6">
                            <p class="text-lg font-semibold text-white mb-3">💬 Pilih Member untuk Mulai Chat</p>
                            <p class="text-sm text-gray-400">Pesan akan tampil di sini setelah kamu memilih salah satu member di
                                sebelah kiri.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- 🔔 JS --}}
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script>
            @if(isset($user))
                const chatForm = document.getElementById('chat-form');
                const chatInput = document.getElementById('chat-message');
                const chatBox = document.getElementById('chat-box');
                const typingIndicator = document.getElementById('typing-indicator');
                let typingTimeout;

                // 💬 Kirim pesan (real-time)
                chatForm.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    const message = chatInput.value.trim();
                    if (!message) return;

                    try {
                        const res = await axios.post("{{ route('trainer.communication.chat.store') }}", {
                            message: message,
                            user_id: {{ $user->id }}
                        });

                        chatBox.insertAdjacentHTML('beforeend', `
                            <div class="flex justify-end relative chat-message" id="chat-${res.data.chat_id}">
                                <div class="text-right max-w-[75%]">
                                    <div class="bg-blue-600 text-white px-4 py-2 rounded-2xl rounded-br-none inline-block shadow-md">
                                        ${message}
                                    </div>
                                    <div class="flex justify-end items-center gap-2 mt-1">
                                        <p class="text-[10px] text-gray-400">${res.data.timestamp}</p>
                                        <button data-id="${res.data.chat_id}"
                                                class="delete-chat text-xs text-gray-500 hover:text-red-500 transition">🗑️</button>
                                    </div>
                                </div>
                            </div>
                        `);
                        chatBox.scrollTop = chatBox.scrollHeight;
                        chatInput.value = '';
                    } catch {
                        alert('Gagal mengirim pesan!');
                    }
                });

                // 🧹 Hapus pesan trainer
                document.addEventListener('click', async (e) => {
                    if (e.target.classList.contains('delete-chat')) {
                        const chatId = e.target.dataset.id;
                        const chatEl = document.getElementById(`chat-${chatId}`);
                        if (confirm('Hapus pesan ini?')) {
                            chatEl.classList.add('opacity-0', 'translate-y-2', 'transition', 'duration-300');
                            setTimeout(async () => {
                                await axios.delete(`/trainer/chat/${chatId}`);
                                chatEl.remove();
                            }, 300);
                        }
                    }
                });

                // 👀 Tandai semua pesan user sebagai dibaca
                window.addEventListener('load', async () => {
                    await axios.post("{{ route('trainer.communication.chat.markAllRead') }}", {
                        user_id: {{ $user->id }}
                    });
                    chatBox.scrollTop = chatBox.scrollHeight;
                });

                // ✍️ Typing indicator
                chatInput.addEventListener('input', () => {
                    typingIndicator.classList.remove('hidden');
                    clearTimeout(typingTimeout);
                    typingTimeout = setTimeout(() => typingIndicator.classList.add('hidden'), 2000);
                });
            @endif
        </script>
    @endsection
