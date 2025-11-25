@extends('layouts.trainer')

@section('title', '💬 Chat Member')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="min-h-[80vh] max-w-7xl mx-auto px-2 sm:px-4 lg:px-6 py-4">
        <div
            class="flex flex-col lg:flex-row h-[calc(100vh-12rem)] bg-black/60 backdrop-blur-xl border border-gray-800/60 rounded-2xl shadow-2xl overflow-hidden">

            {{-- SIDEBAR --}}
            <div
                class="w-full lg:w-1/3 xl:w-1/4 border-b lg:border-b-0 lg:border-r border-gray-800/60 flex flex-col bg-gray-900/40 backdrop-blur-md">
                <div class="lg:hidden p-3 border-b border-gray-800/50 flex items-center justify-between bg-gray-900/60">
                    <h2 class="text-base font-bold text-emerald-400 tracking-wide">💬 Chat Member</h2>
                    <button id="toggle-member-list" class="text-gray-400 hover:text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>

                <div class="hidden lg:block p-4 border-b border-gray-800/50">
                    <h2 class="text-lg font-bold text-emerald-400 tracking-wide">💬 Chat Member</h2>
                </div>

                <div class="p-3">
                    <input id="member-search" type="text" placeholder="Cari member..."
                        class="w-full rounded-full bg-gray-800/60 border border-gray-700/50 text-gray-300 text-sm px-4 py-2 focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 outline-none transition placeholder:text-gray-500">
                </div>

                <div id="member-list" class="flex-1 overflow-y-auto transition-all duration-300">
                    @forelse($members as $m)
                        <a href="{{ route('trainer.communication.chat.index', ['user' => $m->id]) }}"
                            class="member-item flex items-center gap-3 px-3 sm:px-4 py-3 transition-all {{ isset($user) && $user->id == $m->id ? 'bg-gradient-to-r from-emerald-700/40 to-cyan-600/30 shadow-md' : 'hover:bg-gray-800/50' }}"
                            data-name="{{ strtolower($m->name) }}">
                            <div class="relative flex-shrink-0">
                                <div
                                    class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-emerald-400/20 flex items-center justify-center text-emerald-400 font-bold text-xs sm:text-sm">
                                    {{ strtoupper(substr($m->name, 0, 1)) }}
                                </div>
                                <span
                                    class="absolute bottom-0 right-0 w-2 h-2 sm:w-2.5 sm:h-2.5 bg-green-400 border border-gray-900 rounded-full"></span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-white font-semibold text-sm truncate">{{ $m->name }}</p>
                                <p class="text-gray-400 text-xs truncate">Klik untuk membuka chat</p>
                            </div>
                            @if(($m->trainer_chats_as_user_count ?? 0) > 0)
                                <span
                                    class="flex-shrink-0 text-xs bg-pink-600 text-white rounded-full px-2 py-0.5 shadow ml-2 unread-badge">
                                    {{ $m->trainer_chats_as_user_count }}
                                </span>
                            @endif
                        </a>
                    @empty
                        <p class="text-gray-400 text-center mt-6 px-4 text-sm">Belum ada member yang terhubung.</p>
                    @endforelse
                </div>
            </div>

            {{-- MAIN CHAT --}}
            <div class="flex-1 flex flex-col bg-gray-950/70 backdrop-blur-xl">
                @if(isset($user))
                    <div
                        class="flex flex-col sm:flex-row sm:items-center justify-between px-3 sm:px-4 py-3 border-b border-gray-800/60 bg-gray-900/50">
                        <div class="flex items-center gap-3 mb-2 sm:mb-0">
                            <button id="back-to-members" class="lg:hidden text-gray-400 hover:text-white mr-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                                    </path>
                                </svg>
                            </button>
                            <div
                                class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-emerald-400/20 flex items-center justify-center text-emerald-400 font-bold text-sm">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-white font-semibold text-sm truncate">{{ $user->name }}</h3>
                                <p class="text-xs text-emerald-400">🟢 Online</p>
                            </div>
                        </div>

                        @if(isset($availableDates) && $availableDates->count())
                            <form method="GET" class="flex items-center gap-2">
                                <input type="hidden" name="user" value="{{ $user->id }}">
                                <select name="date" onchange="this.form.submit()"
                                    class="w-full sm:w-auto bg-gray-800/60 text-gray-300 border border-gray-700 rounded-lg text-sm px-2 py-1 focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400">
                                    <option value="">Semua Tanggal</option>
                                    @foreach($availableDates as $date)
                                        <option value="{{ $date }}" {{ ($dateFilter ?? '') === $date ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::parse($date)->translatedFormat('d M Y') }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        @endif
                    </div>

                    <div id="chat-box"
                        class="flex-1 overflow-y-auto px-3 sm:px-5 py-3 sm:py-4 space-y-3 sm:space-y-4 bg-black/40 backdrop-blur-xl">
                        @php $currentDate = null; @endphp

                        @forelse($chats as $chat)
                            @if($currentDate !== $chat->timestamp->toDateString())
                                @php $currentDate = $chat->timestamp->toDateString(); @endphp
                                <div class="text-center text-gray-500 text-xs my-2 sm:my-3">
                                    {{ \Carbon\Carbon::parse($currentDate)->translatedFormat('d F Y') }}
                                </div>
                            @endif

                            @if($chat->sender_type === 'trainer')
                                <div class="flex justify-end relative chat-message" id="chat-{{ $chat->id }}">
                                    <div class="text-right max-w-[85%] sm:max-w-[75%]">
                                        <div
                                            class="bg-gradient-to-r from-emerald-500 to-cyan-500 text-black font-medium px-3 py-2 sm:px-4 sm:py-2 rounded-2xl rounded-br-none inline-block shadow-lg shadow-emerald-500/30 break-words">
                                            {!! nl2br(e($chat->message)) !!}
                                        </div>
                                        <div class="flex justify-end items-center gap-2 mt-1">
                                            <p class="text-[10px] text-gray-400">{{ $chat->timestamp->format('H:i') }}</p>
                                            <button data-id="{{ $chat->id }}"
                                                class="delete-chat text-xs text-gray-500 hover:text-pink-500 transition">🗑️</button>
                                        </div>
                                    </div>
                                </div>
                            @elseif($chat->sender_type === 'user')
                                <div class="flex items-start gap-2 chat-message" id="chat-{{ $chat->id }}">
                                    <div
                                        class="w-6 h-6 sm:w-8 sm:h-8 bg-gray-800/70 rounded-full flex items-center justify-center text-gray-300 text-xs sm:text-sm font-bold flex-shrink-0">
                                        U
                                    </div>
                                    <div class="max-w-[85%] sm:max-w-[75%]">
                                        <div
                                            class="bg-gray-900/80 border border-gray-700 text-white px-3 py-2 sm:px-4 sm:py-2 rounded-2xl rounded-bl-none inline-block break-words shadow-md">
                                            {!! nl2br(e($chat->message)) !!}
                                        </div>
                                        <p class="text-[10px] text-gray-500 mt-1">{{ $chat->timestamp->format('H:i') }}</p>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <div id="empty-state" class="flex flex-col items-center justify-center h-full text-gray-400 py-8">
                                <div class="text-center px-4">
                                    <p class="text-base sm:text-lg font-semibold text-white mb-2">💬 Mulai Percakapan</p>
                                    <p class="text-xs sm:text-sm text-gray-500">Belum ada percakapan dengan {{ $user->name }}.</p>
                                    <p class="text-xs text-gray-600 mt-1">Kirim pesan pertama untuk memulai chat!</p>
                                </div>
                            </div>
                        @endforelse

                        <div id="typing-indicator" class="hidden text-emerald-300 text-xs italic mt-2 animate-pulse">
                            Trainer sedang mengetik...
                        </div>
                    </div>

                    <form id="chat-form"
                        class="flex items-center gap-2 sm:gap-3 p-3 sm:p-4 bg-gray-900/60 border-t border-gray-800/60 backdrop-blur-md">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <input type="text" name="message" id="chat-message"
                            class="flex-grow bg-gray-800/70 border border-gray-700 rounded-full px-3 sm:px-4 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 outline-none text-sm placeholder:text-sm"
                            placeholder="Ketik pesan..." required autocomplete="off">
                        <button type="submit"
                            class="w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center rounded-full bg-gradient-to-r from-emerald-500 to-cyan-400 hover:opacity-90 transition shadow-lg shadow-emerald-500/40 flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5 text-black" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path
                                    d="M2.94 2.94a.75.75 0 011.06 0L17.5 16.44a.75.75 0 11-1.06 1.06L2.94 4a.75.75 0 010-1.06z" />
                            </svg>
                        </button>
                    </form>
                @else
                    <div class="flex-1 flex flex-col items-center justify-center bg-gray-950/70 text-gray-400 p-6">
                        <div class="text-center max-w-md">
                            <div
                                class="w-16 h-16 bg-emerald-400/20 rounded-full flex items-center justify-center text-emerald-400 text-2xl mb-4 mx-auto">
                                💬
                            </div>
                            <p class="text-lg font-semibold text-white mb-2">Pilih Member untuk Mulai Chat</p>
                            <p class="text-sm text-gray-500 mb-4">Pesan akan tampil di sini setelah kamu memilih salah satu
                                member.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        // only run if user is defined
        @if(isset($user))
            (function () {
                // Setup axios CSRF header
                axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
                const tokenMeta = document.querySelector('meta[name="csrf-token"]');
                if (tokenMeta) {
                    axios.defaults.headers.common['X-CSRF-TOKEN'] = tokenMeta.getAttribute('content');
                }

                const memberList = document.getElementById('member-list');
                const toggleMemberList = document.getElementById('toggle-member-list');
                const backToMembers = document.getElementById('back-to-members');
                const chatBox = document.getElementById('chat-box');
                const chatForm = document.getElementById('chat-form');
                const chatInput = document.getElementById('chat-message');
                const typingIndicator = document.getElementById('typing-indicator');
                let typingTimeout = null;

                // Utils
                function scrollToBottom(smooth = true) {
                    if (!chatBox) return;
                    try {
                        if (smooth) {
                            chatBox.scrollTo({ top: chatBox.scrollHeight, behavior: 'smooth' });
                        } else {
                            chatBox.scrollTop = chatBox.scrollHeight;
                        }
                    } catch (e) {
                        chatBox.scrollTop = chatBox.scrollHeight;
                    }
                }

                function removeEmptyStateIfPresent() {
                    const empty = document.getElementById('empty-state');
                    if (empty) empty.remove();
                }

                // Mobile toggles
                if (toggleMemberList) {
                    toggleMemberList.addEventListener('click', () => {
                        memberList.classList.toggle('hidden');
                    });
                }
                if (backToMembers) {
                    backToMembers.addEventListener('click', () => {
                        memberList.classList.remove('hidden');
                    });
                }

                // Member search (client-side)
                const memberSearch = document.getElementById('member-search');
                if (memberSearch) {
                    memberSearch.addEventListener('input', (e) => {
                        const q = e.target.value.trim().toLowerCase();
                        document.querySelectorAll('.member-item').forEach(el => {
                            const name = el.getAttribute('data-name') || '';
                            el.style.display = name.includes(q) ? '' : 'none';
                        });
                    });
                }

                // Initialize scroll after a short delay (allow DOM paint)
                setTimeout(() => scrollToBottom(false), 120);

                // Submit message
                chatForm.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    const message = chatInput.value.trim();
                    if (!message) return;

                    try {
                        const payload = {
                            message,
                            user_id: {{ $user->id }}
                        };

                        const res = await axios.post("{{ route('trainer.communication.chat.store') }}", payload);

                        if (res?.data?.success) {
                            removeEmptyStateIfPresent();

                            const html = `
                                <div class="flex justify-end relative chat-message" id="chat-${res.data.chat_id}">
                                    <div class="text-right max-w-[85%] sm:max-w-[75%]">
                                        <div class="bg-gradient-to-r from-emerald-500 to-cyan-500 text-black font-medium px-3 py-2 sm:px-4 sm:py-2 rounded-2xl rounded-br-none inline-block shadow-lg shadow-emerald-500/30 break-words">
                                            ${escapeHtml(message).replace(/\n/g, '<br>')}
                                        </div>
                                        <div class="flex justify-end items-center gap-2 mt-1">
                                            <p class="text-[10px] text-gray-400">${res.data.timestamp}</p>
                                            <button data-id="${res.data.chat_id}" class="delete-chat text-xs text-gray-500 hover:text-pink-500 transition">🗑️</button>
                                        </div>
                                    </div>
                                </div>
                            `;
                            chatBox.insertAdjacentHTML('beforeend', html);
                            chatInput.value = '';
                            scrollToBottom();
                            if (window.innerWidth < 1024) memberList.classList.add('hidden');
                        }
                    } catch (err) {
                        console.error('Error sending message:', err);
                        alert('Gagal mengirim pesan! Silakan coba lagi.');
                    }
                });

                // Delete message (event delegation)
                document.addEventListener('click', async (e) => {
                    const el = e.target;
                    if (!el.classList.contains('delete-chat')) return;
                    const chatId = el.dataset.id;
                    const chatEl = document.getElementById(`chat-${chatId}`);
                    if (!chatEl) return;
                    if (!confirm('Hapus pesan ini?')) return;

                    // optimistic UI animation
                    chatEl.style.transition = 'all .25s ease';
                    chatEl.style.opacity = '0';
                    chatEl.style.transform = 'translateY(8px)';
                    setTimeout(async () => {
                        try {
                            await axios.delete("{{ url('/trainer/chat') }}/" + chatId);
                            chatEl.remove();
                        } catch (err) {
                            console.error('Failed to delete:', err);
                            alert('Gagal menghapus pesan!');
                            chatEl.style.opacity = '1';
                            chatEl.style.transform = '';
                        }
                    }, 200);
                });

                // Mark messages as read when page loads (API)
                async function markAllRead() {
                    try {
                        await axios.post("{{ route('trainer.communication.chat.markAllRead') }}", {
                            user_id: {{ $user->id }}
                        });
                    } catch (err) {
                        console.error('Error marking messages as read:', err);
                    }
                }

                window.addEventListener('load', () => {
                    markAllRead();
                    scrollToBottom();
                });

                // Typing indicator simple UX
                chatInput.addEventListener('input', () => {
                    typingIndicator.classList.remove('hidden');
                    clearTimeout(typingTimeout);
                    typingTimeout = setTimeout(() => typingIndicator.classList.add('hidden'), 1200);
                });

                // Simple escape for inserted HTML
                function escapeHtml(unsafe) {
                    return unsafe
                        .replace(/&/g, "&amp;")
                        .replace(/</g, "&lt;")
                        .replace(/>/g, "&gt;")
                        .replace(/"/g, "&quot;")
                        .replace(/'/g, "&#039;");
                }

                // Window resize: ensure member list visible on desktop
                window.addEventListener('resize', () => {
                    if (window.innerWidth >= 1024) {
                        memberList.classList.remove('hidden');
                    }
                });
            })();
        @endif
    </script>

    <style>
        /* scrollbars */
        #chat-box::-webkit-scrollbar,
        #member-list::-webkit-scrollbar {
            width: 4px;
        }

        #chat-box::-webkit-scrollbar-track,
        #member-list::-webkit-scrollbar-track {
            background: rgba(75, 85, 99, 0.2);
            border-radius: 10px;
        }

        #chat-box::-webkit-scrollbar-thumb,
        #member-list::-webkit-scrollbar-thumb {
            background: rgba(16, 185, 129, 0.4);
            border-radius: 10px;
        }

        #chat-box::-webkit-scrollbar-thumb:hover,
        #member-list::-webkit-scrollbar-thumb:hover {
            background: rgba(16, 185, 129, 0.6);
        }

        .chat-message {
            transition: all .25s ease;
        }

        @media (max-width: 640px) {
            .break-words {
                word-break: break-word;
                overflow-wrap: break-word;
            }
        }
    </style>
@endsection