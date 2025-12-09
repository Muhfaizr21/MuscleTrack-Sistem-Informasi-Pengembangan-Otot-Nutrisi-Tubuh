@extends('layouts.trainer')

@section('title', '💬 Chat Member - MuscleXpert')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="min-h-[80vh] max-w-7xl mx-auto px-2 sm:px-4 lg:px-6 py-4">
        <div class="mb-6">
            <a href="{{ url('/') }}"
                class="inline-flex items-center gap-2 text-slate-400 hover:text-emerald-400 transition-colors group">
                <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span class="text-sm font-medium">Kembali ke Home</span>
            </a>
        </div>

        <div
            class="flex flex-col lg:flex-row h-[calc(100vh-12rem)] bg-black/60 backdrop-blur-xl border border-gray-800/60 rounded-2xl shadow-2xl overflow-hidden">

            {{-- SIDEBAR MEMBER LIST --}}
            <div
                class="w-full lg:w-1/3 xl:w-1/4 border-b lg:border-b-0 lg:border-r border-gray-800/60 flex flex-col bg-gray-900/40 backdrop-blur-md">
                {{-- Sidebar Header --}}
                <div class="p-4 border-b border-gray-800/50 bg-gradient-to-r from-emerald-900/30 to-gray-900/40">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-bold text-emerald-400 tracking-wide flex items-center gap-2">
                                <span class="text-xl">💬</span>
                                <span>Chat Member</span>
                            </h2>
                            <p class="text-xs text-gray-400 mt-1">Kirim pesan kepada member Anda</p>
                        </div>
                        <div class="text-xs bg-emerald-500/20 text-emerald-400 px-2 py-1 rounded-full">
                            {{ count($members) }} Member
                        </div>
                    </div>
                </div>

                {{-- Search Bar --}}
                <div class="p-3 border-b border-gray-800/40">
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-500" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input id="member-search" type="text" placeholder="Cari nama member..." class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-gray-800/60 border border-gray-700/50
                                       text-gray-300 text-sm focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400
                                       outline-none transition placeholder:text-gray-500">
                    </div>
                </div>

                {{-- Member List --}}
                <div id="member-list" class="flex-1 overflow-y-auto transition-all duration-300">
                    @forelse($members as $m)
                        <a href="{{ route('trainer.communication.chat.index', ['user' => $m->id]) }}"
                            class="member-item flex items-center gap-3 px-4 py-3 border-b border-gray-800/20
                                           transition-all duration-200 hover:bg-gradient-to-r hover:from-emerald-900/20 hover:to-gray-800/40
                                           {{ isset($user) && $user->id == $m->id ? 'bg-gradient-to-r from-emerald-900/30 to-gray-800/40 shadow-inner border-l-2 border-emerald-500' : '' }}"
                            data-name="{{ strtolower($m->name) }}">
                            <div class="relative flex-shrink-0">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-emerald-500/20 to-cyan-500/20
                                                    flex items-center justify-center text-emerald-400 font-bold text-lg
                                                    border border-emerald-500/30">
                                    {{ strtoupper(substr($m->name, 0, 1)) }}
                                </div>
                                <span
                                    class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 border-2 border-gray-900 rounded-full"></span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <p class="text-white font-semibold text-sm truncate">{{ $m->name }}</p>
                                    @if(($m->trainer_chats_as_user_count ?? 0) > 0)
                                        <span
                                            class="flex-shrink-0 text-xs bg-pink-600 text-white rounded-full px-2 py-0.5 shadow animate-pulse">
                                            {{ $m->trainer_chats_as_user_count }} new
                                        </span>
                                    @endif
                                </div>
                                <p class="text-gray-400 text-xs truncate mt-1">Klik untuk membuka chat</p>
                            </div>
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    @empty
                        <div class="text-center py-8 px-4">
                            <div class="w-16 h-16 bg-emerald-500/10 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                            </div>
                            <p class="text-gray-400 text-sm mb-2">Belum ada member yang terhubung</p>
                            <p class="text-gray-500 text-xs">Member akan muncul setelah bergabung dengan program Anda</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- MAIN CHAT AREA --}}
            <div class="flex-1 flex flex-col bg-gradient-to-b from-gray-950/70 to-black/70 backdrop-blur-xl">
                @if(isset($user))
                    {{-- Chat Header --}}
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between px-4 sm:px-6 py-4
                                        border-b border-gray-800/60 bg-gradient-to-r from-gray-900/60 to-black/60">
                        <div class="flex items-center gap-3 mb-3 sm:mb-0">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-emerald-500/20 to-cyan-500/20
                                                flex items-center justify-center text-emerald-400 font-bold text-lg
                                                border border-emerald-500/30">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-white font-semibold text-lg flex items-center gap-2">
                                    {{ $user->name }}
                                    <span
                                        class="text-xs bg-emerald-500/20 text-emerald-400 px-2 py-0.5 rounded-full">Online</span>
                                </h3>
                                <p class="text-xs text-gray-400 mt-1">Member aktif • Trainer Anda</p>
                            </div>
                        </div>

                        {{-- Date Filter --}}
                        @if(isset($availableDates) && $availableDates->count())
                            <div class="relative">
                                <form method="GET" class="flex items-center gap-2">
                                    <input type="hidden" name="user" value="{{ $user->id }}">
                                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-500"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <select name="date" onchange="this.form.submit()" class="pl-10 pr-8 bg-gray-800/60 text-gray-300 border border-gray-700
                                                           rounded-xl text-sm px-4 py-2.5 focus:ring-2 focus:ring-emerald-400
                                                           focus:border-emerald-400 cursor-pointer appearance-none">
                                        <option value="">Semua Percakapan</option>
                                        @foreach($availableDates as $date)
                                            <option value="{{ $date }}" {{ ($dateFilter ?? '') === $date ? 'selected' : '' }}>
                                                {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-500"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </form>
                            </div>
                        @endif
                    </div>

                    {{-- Chat Messages --}}
                    <div id="chat-box"
                        class="flex-1 overflow-y-auto px-4 sm:px-6 py-4 space-y-4 bg-gradient-to-b from-black/20 to-transparent">
                        @php $currentDate = null; @endphp

                        @forelse($chats as $chat)
                            @if($currentDate !== $chat->timestamp->toDateString())
                                @php $currentDate = $chat->timestamp->toDateString(); @endphp
                                <div class="flex items-center justify-center my-6">
                                    <div class="text-center text-gray-500 text-xs px-3 py-1.5
                                                                bg-gray-800/40 rounded-full border border-gray-700/50">
                                        {{ \Carbon\Carbon::parse($currentDate)->translatedFormat('l, d F Y') }}
                                    </div>
                                </div>
                            @endif

                            @if($chat->sender_type === 'trainer')
                                {{-- Trainer Message --}}
                                <div class="flex justify-end relative chat-message group" id="chat-{{ $chat->id }}">
                                    <div class="text-right max-w-[85%] sm:max-w-[75%]">
                                        <div class="relative">
                                            <div class="bg-gradient-to-r from-emerald-500 to-cyan-500 text-white font-medium
                                                                        px-4 py-3 rounded-2xl rounded-br-none inline-block shadow-lg
                                                                        shadow-emerald-500/30 break-words">
                                                {!! nl2br(e($chat->message)) !!}
                                            </div>
                                            <div
                                                class="flex items-center justify-end gap-2 mt-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                <p class="text-[11px] text-gray-400">{{ $chat->timestamp->format('H:i') }}</p>
                                                <button data-id="{{ $chat->id }}"
                                                    class="delete-chat text-xs text-gray-500 hover:text-red-500 transition
                                                                           transform hover:scale-110 p-1 rounded-full hover:bg-red-500/10">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @elseif($chat->sender_type === 'user')
                                {{-- User Message --}}
                                <div class="flex items-start gap-3 chat-message group" id="chat-{{ $chat->id }}">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-gray-800 to-gray-900
                                                                flex items-center justify-center text-gray-300 text-sm font-bold
                                                                flex-shrink-0 border border-gray-700">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div class="max-w-[85%] sm:max-w-[75%]">
                                        <div
                                            class="bg-gray-800/80 border border-gray-700/50 text-white
                                                                    px-4 py-3 rounded-2xl rounded-bl-none inline-block break-words shadow-lg">
                                            {!! nl2br(e($chat->message)) !!}
                                        </div>
                                        <div class="flex items-center gap-2 mt-2">
                                            <p class="text-[11px] text-gray-500">{{ $chat->timestamp->format('H:i') }}</p>
                                            <span class="text-[10px] text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded-full">
                                                Member
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <div id="empty-state" class="flex flex-col items-center justify-center h-full text-gray-400 py-12 px-4">
                                <div class="text-center max-w-md">
                                    <div
                                        class="w-20 h-20 bg-gradient-to-br from-emerald-500/10 to-cyan-500/10
                                                            rounded-full flex items-center justify-center text-emerald-400 text-3xl mb-6 mx-auto">
                                        💬
                                    </div>
                                    <p class="text-xl font-semibold text-white mb-3">Mulai Percakapan dengan {{ $user->name }}</p>
                                    <p class="text-sm text-gray-400 mb-6">Belum ada percakapan dengan member ini.</p>
                                    <div class="bg-gray-800/50 rounded-xl p-4 border border-gray-700/50">
                                        <p class="text-xs text-gray-400 mb-2">Tips memulai percakapan:</p>
                                        <ul class="text-xs text-gray-500 space-y-1">
                                            <li class="flex items-center gap-2">✓ Tanyakan progress latihan mereka</li>
                                            <li class="flex items-center gap-2">✓ Beri motivasi dan dukungan</li>
                                            <li class="flex items-center gap-2">✓ Jawab pertanyaan tentang program</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    {{-- Typing Indicator --}}
                    <div id="typing-indicator" class="hidden px-6 py-2">
                        <div class="flex items-center gap-2 text-emerald-400 text-sm animate-pulse">
                            <div class="flex space-x-1">
                                <div class="w-2 h-2 bg-emerald-400 rounded-full animate-bounce"></div>
                                <div class="w-2 h-2 bg-emerald-400 rounded-full animate-bounce" style="animation-delay: 0.1s">
                                </div>
                                <div class="w-2 h-2 bg-emerald-400 rounded-full animate-bounce" style="animation-delay: 0.2s">
                                </div>
                            </div>
                            <span>{{ $user->name }} sedang mengetik...</span>
                        </div>
                    </div>

                    {{-- Message Input --}}
                    <form id="chat-form" class="px-4 sm:px-6 py-4 bg-gradient-to-t from-gray-900/80 to-transparent
                                                        border-t border-gray-800/60 backdrop-blur-md">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <div class="flex items-center gap-3">
                            <div class="flex-1 relative">
                                <input type="text" name="message" id="chat-message" class="w-full bg-gray-800/70 border border-gray-700 rounded-2xl px-4 py-3
                                                   text-white placeholder-gray-400 focus:ring-2 focus:ring-emerald-400
                                                   focus:border-emerald-400 outline-none text-sm placeholder:text-sm
                                                   shadow-lg" placeholder="Tulis pesan untuk {{ $user->name }}..." required
                                    autocomplete="off" autofocus>
                            </div>
                            <button type="submit" class="w-12 h-12 flex items-center justify-center rounded-full
                                               bg-gradient-to-r from-emerald-500 to-cyan-400 hover:from-emerald-600
                                               hover:to-cyan-500 transition-all shadow-lg shadow-emerald-500/30
                                               transform hover:scale-105 active:scale-95">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                            </button>
                        </div>
                        <div class="flex items-center justify-end mt-3 text-xs text-gray-500">
                            <span class="text-gray-600">Tekan Enter untuk mengirim</span>
                        </div>
                    </form>
                @else
                    {{-- Empty State --}}
                    <div class="flex-1 flex flex-col items-center justify-center bg-gradient-to-b from-gray-950/70
                                        to-black/70 text-gray-400 p-6">
                        <div class="text-center max-w-md px-4">
                            <div
                                class="w-24 h-24 bg-gradient-to-br from-emerald-500/10 to-cyan-500/10
                                                rounded-full flex items-center justify-center text-emerald-400 text-4xl mb-6 mx-auto">
                                💬
                            </div>
                            <p class="text-2xl font-bold text-white mb-3 bg-gradient-to-r from-emerald-400 to-cyan-400
                                              bg-clip-text text-transparent">
                                Chat Member MuscleXpert
                            </p>
                            <p class="text-sm text-gray-400 mb-4">
                                Pilih member dari daftar di samping untuk memulai percakapan.
                                <br>Berikan bimbingan dan dukungan kepada member Anda.
                            </p>
                            <div class="bg-gray-800/40 rounded-2xl p-5 border border-gray-700/50 mt-4">
                                <p class="text-sm text-emerald-400 font-semibold mb-3">📊 Statistik Chat Anda:</p>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-white">{{ count($members) }}</div>
                                        <div class="text-xs text-gray-400">Total Member</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-emerald-400">
                                            {{ $members->sum('trainer_chats_as_user_count') }}</div>
                                        <div class="text-xs text-gray-400">Pesan Belum Dibaca</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- SCRIPTS --}}
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    @if(isset($user))
        (function () {
            // Setup axios CSRF header
            axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
            const tokenMeta = document.querySelector('meta[name="csrf-token"]');
            if (tokenMeta) {
                axios.defaults.headers.common['X-CSRF-TOKEN'] = tokenMeta.getAttribute('content');
            }

            const memberList = document.getElementById('member-list');
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

            // Auto focus chat input
            if (chatInput) {
                chatInput.focus();
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

                    // Show no results message
                    const visibleItems = Array.from(document.querySelectorAll('.member-item'))
                        .filter(el => el.style.display !== 'none');

                    if (visibleItems.length === 0 && q !== '') {
                        if (!document.getElementById('no-results')) {
                            const noResults = document.createElement('div');
                            noResults.id = 'no-results';
                            noResults.className = 'text-center py-8 px-4 text-gray-500 text-sm';
                            noResults.innerHTML = `
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p>Tidak ditemukan member dengan nama "${q}"</p>
                                <p class="text-xs text-gray-600 mt-1">Coba kata kunci lain</p>
                            `;
                            memberList.appendChild(noResults);
                        }
                    } else {
                        const noResults = document.getElementById('no-results');
                        if (noResults) noResults.remove();
                    }
                });
            }

            // Initialize scroll after a short delay
            setTimeout(() => scrollToBottom(false), 200);

            // FUNGSI UNTUK MENGHAPUS CHAT
            async function deleteChat(chatId) {
                try {
                    // PERBAIKAN URL: Sesuai dengan routes yang sudah diperbaiki
                    const response = await axios.delete(`/trainer/communication/chat/${chatId}`);

                    if (response.data.success) {
                        // Hapus elemen dari DOM
                        const chatElement = document.getElementById(`chat-${chatId}`);
                        if (chatElement) {
                            chatElement.style.opacity = '0';
                            chatElement.style.transform = 'translateY(20px) scale(0.9)';
                            setTimeout(() => chatElement.remove(), 300);
                        }

                        // Tampilkan notifikasi
                        showNotification('Pesan berhasil dihapus', 'success');
                        return true;
                    } else {
                        showNotification(response.data.error || 'Gagal menghapus pesan', 'error');
                        return false;
                    }
                } catch (error) {
                    console.error('Error deleting chat:', error);

                    if (error.response) {
                        // Server responded with error
                        showNotification(error.response.data.error || 'Terjadi kesalahan saat menghapus pesan', 'error');
                    } else if (error.request) {
                        // No response received
                        showNotification('Tidak ada respons dari server. Periksa koneksi internet.', 'error');
                    } else {
                        // Something else happened
                        showNotification('Terjadi kesalahan: ' + error.message, 'error');
                    }
                    return false;
                }
            }

            // Event listener untuk tombol delete
            document.addEventListener('click', async (e) => {
                const deleteButton = e.target.closest('.delete-chat');
                if (!deleteButton) return;

                e.preventDefault();

                const chatId = deleteButton.dataset.id;
                const chatElement = document.getElementById(`chat-${chatId}`);

                if (!chatElement) return;

                // Konfirmasi sebelum menghapus
                if (!confirm('Apakah Anda yakin ingin menghapus pesan ini? Tindakan ini tidak dapat dibatalkan.')) {
                    return;
                }

                // Tambah efek visual saat menghapus
                chatElement.style.transition = 'all 0.3s ease';
                chatElement.style.opacity = '0.5';
                chatElement.style.transform = 'scale(0.95)';

                // Panggil fungsi delete
                await deleteChat(chatId);
            });

            // Untuk pesan yang baru dikirim, kita perlu menambahkan event listener
            function attachDeleteListener(element) {
                element.addEventListener('click', async function(e) {
                    e.preventDefault();

                    const chatId = this.dataset.id;
                    const chatElement = document.getElementById(`chat-${chatId}`);

                    if (!chatElement) return;

                    if (!confirm('Apakah Anda yakin ingin menghapus pesan ini? Tindakan ini tidak dapat dibatalkan.')) {
                        return;
                    }

                    chatElement.style.transition = 'all 0.3s ease';
                    chatElement.style.opacity = '0.5';
                    chatElement.style.transform = 'scale(0.95)';

                    await deleteChat(chatId);
                });
            }

            // Attach listener ke tombol delete yang sudah ada saat halaman dimuat
            document.querySelectorAll('.delete-chat').forEach(button => {
                attachDeleteListener(button);
            });

            // Submit message
            chatForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const message = chatInput.value.trim();
                if (!message) return;

                // Disable input while sending
                chatInput.disabled = true;
                const submitBtn = chatForm.querySelector('button[type="submit"]');
                const originalHtml = submitBtn.innerHTML;
                submitBtn.innerHTML = `
                    <svg class="w-5 h-5 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                `;

                try {
                    const payload = {
                        message,
                        user_id: {{ $user->id }}
                    };

                    const res = await axios.post("{{ route('trainer.communication.chat.store') }}", payload);

                    if (res?.data?.success) {
                        removeEmptyStateIfPresent();

                        // Buat elemen chat baru
                        const chatHtml = `
                            <div class="flex justify-end relative chat-message group" id="chat-${res.data.chat_id}">
                                <div class="text-right max-w-[85%] sm:max-w-[75%]">
                                    <div class="relative">
                                        <div class="bg-gradient-to-r from-emerald-500 to-cyan-500 text-white font-medium
                                                    px-4 py-3 rounded-2xl rounded-br-none inline-block shadow-lg
                                                    shadow-emerald-500/30 break-words animate-pulse-once">
                                            ${escapeHtml(message).replace(/\n/g, '<br>')}
                                        </div>
                                        <div class="flex items-center justify-end gap-2 mt-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <p class="text-[11px] text-gray-400">${res.data.timestamp}</p>
                                            <button data-id="${res.data.chat_id}"
                                                class="delete-chat text-xs text-gray-500 hover:text-red-500 transition
                                                       transform hover:scale-110 p-1 rounded-full hover:bg-red-500/10">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;

                        chatBox.insertAdjacentHTML('beforeend', chatHtml);

                        // Tambahkan event listener ke tombol delete baru
                        const newDeleteButton = document.querySelector(`[data-id="${res.data.chat_id}"]`);
                        if (newDeleteButton) {
                            attachDeleteListener(newDeleteButton);
                        }

                        chatInput.value = '';
                        scrollToBottom();

                        // Add animation class
                        setTimeout(() => {
                            const newMessage = document.querySelector('.animate-pulse-once');
                            if (newMessage) {
                                newMessage.classList.remove('animate-pulse-once');
                            }
                        }, 500);
                    }
                } catch (err) {
                    console.error('Error sending message:', err);
                    showNotification('Gagal mengirim pesan! Silakan coba lagi.', 'error');
                } finally {
                    chatInput.disabled = false;
                    submitBtn.innerHTML = originalHtml;
                    chatInput.focus();
                }
            });

            // Enter to send (but allow Shift+Enter for new line)
            chatInput.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    chatForm.dispatchEvent(new Event('submit'));
                }
            });

            // Mark messages as read
            async function markAllRead() {
                try {
                    await axios.post("{{ route('trainer.communication.chat.markAllRead') }}", {
                        user_id: {{ $user->id }}
                    });
                    // Update unread badges
                    document.querySelectorAll('.unread-badge').forEach(badge => {
                        badge.style.opacity = '0.5';
                        setTimeout(() => badge.remove(), 300);
                    });
                } catch (err) {
                    console.error('Error marking messages as read:', err);
                }
            }

            window.addEventListener('load', () => {
                markAllRead();
                scrollToBottom();
            });

            // Typing indicator simulation
            chatInput.addEventListener('input', () => {
                typingIndicator.classList.remove('hidden');
                clearTimeout(typingTimeout);
                typingTimeout = setTimeout(() => typingIndicator.classList.add('hidden'), 2000);
            });

            // Helper functions
            function escapeHtml(unsafe) {
                return unsafe
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;");
            }

            function showNotification(message, type = 'info') {
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg
                                         animate-slideInRight ${type === 'success' ? 'bg-emerald-500/90' : 'bg-red-500/90'}
                                         text-white text-sm backdrop-blur-sm`;
                notification.textContent = message;
                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.style.opacity = '0';
                    notification.style.transform = 'translateX(100%)';
                    setTimeout(() => notification.remove(), 300);
                }, 3000);
            }

            // Debug: Log untuk memastikan script berjalan
            console.log('Chat script loaded successfully');
            console.log('User ID:', {{ $user->id }});
            console.log('Delete URL pattern:', '/trainer/communication/chat/{id}');

        })();
    @endif
</script>

<style>
    /* Custom Scrollbar */
    #chat-box::-webkit-scrollbar,
    #member-list::-webkit-scrollbar {
        width: 6px;
    }

    #chat-box::-webkit-scrollbar-track,
    #member-list::-webkit-scrollbar-track {
        background: rgba(75, 85, 99, 0.1);
        border-radius: 10px;
    }

    #chat-box::-webkit-scrollbar-thumb,
    #member-list::-webkit-scrollbar-thumb {
        background: linear-gradient(to bottom, #10b981, #06b6d4);
        border-radius: 10px;
    }

    #chat-box::-webkit-scrollbar-thumb:hover,
    #member-list::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(to bottom, #059669, #0891b2);
    }

    /* Animations */
    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(100%);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .animate-slideInRight {
        animation: slideInRight 0.3s ease-out;
    }

    .animate-pulse-once {
        animation: pulse 0.5s ease-in-out;
    }

    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.8;
        }
    }

    /* Smooth transitions */
    .chat-message {
        transition: all 0.3s ease;
    }

    .member-item {
        transition: all 0.2s ease;
    }

    .member-item:hover {
        transform: translateX(2px);
    }

    /* Message bubble animation */
    .chat-message:last-child {
        animation: fadeInUp 0.3s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive improvements */
    @media (max-width: 640px) {
        .break-words {
            word-break: break-word;
            overflow-wrap: break-word;
        }

        #chat-form {
            padding: 12px;
        }

        #chat-message {
            padding: 10px;
            font-size: 14px;
        }
    }

    /* Gradient text */
    .gradient-text {
        background: linear-gradient(135deg, #10b981 0%, #06b6d4 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
</style>
@endsection
