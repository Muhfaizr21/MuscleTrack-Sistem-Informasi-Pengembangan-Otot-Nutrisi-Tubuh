@extends('layouts.user')

@php
    use Carbon\Carbon;
@endphp

@section('content')
    <div class="min-h-screen py-4 lg:py-8">
        <div class="max-w-6xl mx-auto px-3 sm:px-4 lg:px-8">

            {{-- Header Section --}}
            <div class="glass-dark rounded-2xl lg:rounded-3xl p-4 lg:p-8 border border-emerald-500/20 shadow-xl lg:shadow-2xl shadow-emerald-500/10 mb-6 lg:mb-8">
                <div class="flex flex-col lg:flex-row justify-between items-start gap-4 lg:gap-6">
                    <div class="flex items-center gap-3 lg:gap-4">
                        <div class="w-10 h-10 lg:w-14 lg:h-14 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-xl lg:rounded-2xl flex items-center justify-center animate-glow">
                            <span class="text-xl lg:text-2xl">💬</span>
                        </div>
                        <div>
                            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-white">
                                Chat <span class="text-gradient">Trainer</span>
                            </h1>
                            <p class="text-emerald-400/80 text-sm lg:text-lg mt-1 lg:mt-2">Get personalized guidance from our expert trainers</p>
                        </div>
                    </div>
                    <div class="text-left lg:text-right w-full lg:w-auto">
                        <div class="text-emerald-400 font-bold text-xs lg:text-sm uppercase tracking-wider mb-1 lg:mb-2">24/7 Support</div>
                        <p class="text-white/90 text-sm lg:text-base font-medium">AI Trainer always available • Human trainers during business hours</p>
                    </div>
                </div>
            </div>

            {{-- Main Chat Container --}}
            <div class="glass-dark rounded-2xl lg:rounded-3xl border border-emerald-500/20 shadow-xl lg:shadow-2xl shadow-emerald-500/10 overflow-hidden">
                <div class="flex flex-col lg:flex-row h-[80vh] lg:h-[70vh]">

                    {{-- 🔹 SIDEBAR TRAINER LIST - Mobile Toggle Button --}}
                    <div class="lg:hidden border-b border-emerald-500/20">
                        <button id="mobile-toggle" class="w-full flex items-center justify-between p-4 text-white font-semibold">
                            <span>Available Trainers</span>
                            <svg id="toggle-icon" class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </div>

                    {{-- 🔹 SIDEBAR TRAINER LIST - Content --}}
                    <div id="trainer-sidebar" class="lg:w-1/3 border-r border-emerald-500/20 flex flex-col bg-gray-900/50 transition-all duration-300 max-h-0 lg:max-h-none overflow-hidden lg:overflow-visible">
                        <div class="p-4 lg:p-6 border-b border-emerald-500/20">
                            <h2 class="font-serif text-lg lg:text-xl font-black text-white">Available Trainers</h2>
                            <p class="text-emerald-400/80 text-xs lg:text-sm mt-1">Choose a trainer to start conversation</p>
                        </div>

                        {{-- Search Box --}}
                        <div class="p-3 lg:p-4">
                            <div class="relative">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 lg:h-5 lg:w-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-emerald-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                                <input type="text" placeholder="Search trainers..." class="w-full rounded-xl glass border border-emerald-500/20 text-white text-xs lg:text-sm pl-9 lg:pl-10 pr-4 py-2 lg:py-3 focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 transition-all">
                            </div>
                        </div>

                        {{-- Trainer List --}}
                        <div class="flex-1 overflow-y-auto pb-4 lg:pb-0">
                            {{-- 🧠 AI TRAINER --}}
                            <a href="{{ route('user.chat.index', ['trainer' => 0]) }}" class="flex items-center gap-3 lg:gap-4 p-3 lg:p-4 hover:bg-emerald-500/10 transition-all duration-300 border-l-4 {{ isset($trainer) && $trainer->id == 0 ? 'bg-emerald-500/10 border-emerald-400' : 'border-transparent' }}">
                                <div class="relative">
                                    <div class="w-10 h-10 lg:w-12 lg:h-12 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-xl lg:rounded-2xl flex items-center justify-center text-white font-bold overflow-hidden">
                                        <span class="text-base lg:text-lg">🤖</span>
                                    </div>
                                    <span class="absolute bottom-0 right-0 w-2 h-2 lg:w-3 lg:h-3 bg-emerald-400 border-2 border-gray-900 rounded-full"></span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-white font-bold text-xs lg:text-sm truncate">AI Trainer</p>
                                    <p class="text-emerald-400 text-xs mt-0.5 lg:mt-1">Always available • Instant responses</p>
                                </div>
                                @if(isset($unreadCount[0]) && $unreadCount[0] > 0)
                                    <span id="unread-badge-0" class="bg-emerald-500 text-white text-xs font-bold rounded-full px-1.5 lg:px-2 py-0.5 lg:py-1 min-w-5 lg:min-w-6 text-center text-[10px] lg:text-xs">
                                        {{ $unreadCount[0] }}
                                    </span>
                                @endif
                            </a>

                            {{-- 🔹 Human Trainers --}}
                            @forelse($trainers as $t)
                                @if($t->id !== 0)
                                    <a href="{{ route('user.chat.index', ['trainer' => $t->id]) }}" class="flex items-center gap-3 lg:gap-4 p-3 lg:p-4 hover:bg-emerald-500/10 transition-all duration-300 border-l-4 {{ isset($trainer) && $trainer->id == $t->id ? 'bg-emerald-500/10 border-emerald-400' : 'border-transparent' }}">
                                        <div class="relative">
                                            <div class="w-10 h-10 lg:w-12 lg:h-12 bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl lg:rounded-2xl flex items-center justify-center text-white text-sm lg:text-base font-bold overflow-hidden">
                                                {{ strtoupper(substr($t->name, 0, 1)) }}
                                            </div>
                                            <span class="absolute bottom-0 right-0 w-2 h-2 lg:w-3 lg:h-3 bg-green-400 border-2 border-gray-900 rounded-full"></span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-white font-bold text-xs lg:text-sm truncate">{{ $t->name }}</p>
                                            <p class="text-emerald-400/80 text-xs mt-0.5 lg:mt-1 truncate">
                                                {{ $t->trainerProfile->speciality ?? 'Certified Fitness Trainer' }}
                                            </p>
                                        </div>
                                        @if(isset($unreadCount[$t->id]) && $unreadCount[$t->id] > 0)
                                            <span id="unread-badge-{{ $t->id }}" class="bg-emerald-500 text-white text-xs font-bold rounded-full px-1.5 lg:px-2 py-0.5 lg:py-1 min-w-5 lg:min-w-6 text-center text-[10px] lg:text-xs">
                                                {{ $unreadCount[$t->id] }}
                                            </span>
                                        @endif
                                    </a>
                                @endif
                            @empty
                                <div class="text-center py-6 lg:py-8">
                                    <div class="w-12 h-12 lg:w-16 lg:h-16 bg-emerald-500/10 rounded-xl lg:rounded-2xl flex items-center justify-center mx-auto mb-3 lg:mb-4 border border-emerald-500/20">
                                        <span class="text-xl lg:text-2xl">💬</span>
                                    </div>
                                    <p class="text-emerald-400/80 text-xs lg:text-sm">No trainers available at the moment</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- 🔹 MAIN CHAT AREA --}}
                    <div class="flex-1 flex flex-col">
                        @if(isset($trainer))
                            {{-- CHAT HEADER --}}
                            <div class="flex items-center justify-between px-4 lg:px-6 py-3 lg:py-4 border-b border-emerald-500/20 bg-gray-900/50">
                                <div class="flex items-center gap-3 lg:gap-4">
                                    {{-- Mobile Back Button --}}
                                    <a href="{{ route('user.chat.index') }}" class="lg:hidden flex items-center justify-center w-8 h-8 rounded-xl bg-emerald-500/10 border border-emerald-500/20 mr-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                    <div class="relative">
                                        @if($trainer->id === 0)
                                            <div class="w-10 h-10 lg:w-12 lg:h-12 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-xl lg:rounded-2xl flex items-center justify-center text-white font-bold">
                                                <span class="text-base lg:text-lg">🤖</span>
                                            </div>
                                        @else
                                            <div class="w-10 h-10 lg:w-12 lg:h-12 bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl lg:rounded-2xl flex items-center justify-center text-white font-bold">
                                                {{ strtoupper(substr($trainer->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <span class="absolute bottom-0 right-0 w-2 h-2 lg:w-3 lg:h-3 bg-emerald-400 border-2 border-gray-900 rounded-full"></span>
                                    </div>
                                    <div>
                                        <h3 class="text-white font-bold text-base lg:text-lg">{{ $trainer->name }}</h3>
                                        <p class="text-xs lg:text-sm {{ $isTrainerTyping ? 'text-emerald-400 animate-pulse' : 'text-emerald-400' }}">
                                            @if($trainer->id === 0)
                                                🤖 Online • AI Trainer
                                            @else
                                                {{ $isTrainerTyping ? '✍️ Typing...' : '🟢 Online' }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="text-emerald-400/80 text-xs lg:text-sm font-medium hidden sm:block">
                                    {{ now()->format('l, F j') }}
                                </div>
                            </div>

                            {{-- CHAT MESSAGES --}}
                            <div id="chat-box" class="flex-1 overflow-y-auto px-3 lg:px-6 py-4 lg:py-6 space-y-3 lg:space-y-4 bg-gradient-to-br from-gray-900 to-gray-950">
                                @forelse($groupedChats as $dateLabel => $chats)
                                    <div class="text-center">
                                        <span class="bg-emerald-500/10 text-emerald-400 text-xs font-bold px-2 lg:px-3 py-1 rounded-full border border-emerald-500/20">
                                            {{ $dateLabel }}
                                        </span>
                                    </div>
                                    @foreach($chats as $chat)
                                        @if($chat->sender_type === 'user')
                                            {{-- User Message --}}
                                            <div class="flex justify-end relative chat-message" id="chat-{{ $chat->id }}">
                                                <div class="max-w-[85%] lg:max-w-[80%]">
                                                    <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 text-white font-semibold px-3 lg:px-4 py-2 lg:py-3 rounded-xl lg:rounded-2xl rounded-br-none shadow-lg text-sm lg:text-base">
                                                        {{ $chat->message }}
                                                    </div>
                                                    <div class="flex justify-end items-center gap-2 mt-1 lg:mt-2">
                                                        <p class="text-xs text-emerald-400/60">
                                                            {{ Carbon::parse($chat->timestamp)->timezone('Asia/Jakarta')->format('H:i') }}
                                                        </p>
                                                        <button data-id="{{ $chat->id }}" class="delete-chat text-xs text-emerald-400/60 hover:text-red-400 transition-all duration-200">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 lg:h-4 lg:w-4" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            {{-- Trainer Message --}}
                                            <div class="flex items-start gap-2 lg:gap-3 chat-message">
                                                <div class="w-8 h-8 lg:w-10 lg:h-10 bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl lg:rounded-2xl flex items-center justify-center text-white text-xs lg:text-sm font-bold flex-shrink-0">
                                                    {{ $trainer->id === 0 ? 'AI' : 'T' }}
                                                </div>
                                                <div class="max-w-[85%] lg:max-w-[80%]">
                                                    <div class="glass border border-emerald-500/20 text-gray-100 px-3 lg:px-4 py-2 lg:py-3 rounded-xl lg:rounded-2xl rounded-bl-none text-sm lg:text-base">
                                                        {{ $chat->message }}
                                                    </div>
                                                    <p class="text-xs text-emerald-400/60 mt-1 lg:mt-2">
                                                        {{ Carbon::parse($chat->timestamp)->timezone('Asia/Jakarta')->format('H:i') }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @empty
                                    {{-- Empty State --}}
                                    <div class="text-center py-8 lg:py-12">
                                        <div class="w-16 h-16 lg:w-20 lg:h-20 bg-emerald-500/10 rounded-xl lg:rounded-2xl flex items-center justify-center mx-auto mb-3 lg:mb-4 border border-emerald-500/20">
                                            <span class="text-xl lg:text-2xl">💬</span>
                                        </div>
                                        <h4 class="text-base lg:text-lg font-bold text-white mb-1 lg:mb-2">Start a Conversation</h4>
                                        <p class="text-emerald-400/80 text-xs lg:text-sm px-4">
                                            Send your first message to {{ $trainer->name ?? 'this trainer' }} to begin your fitness journey together
                                        </p>
                                    </div>
                                @endforelse
                            </div>

                            {{-- MESSAGE INPUT --}}
                            <form id="chat-form" class="flex items-center gap-3 lg:gap-4 p-4 lg:p-6 bg-gray-900/50 border-t border-emerald-500/20">
                                @csrf
                                <input type="hidden" name="trainer_id" value="{{ $trainer->id }}">

                                <div class="flex-1 relative">
                                    <input type="text" name="message" id="chat-message" class="w-full glass border border-emerald-500/20 rounded-xl lg:rounded-2xl px-3 lg:px-4 py-2 lg:py-3 text-white placeholder-emerald-400/60 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20 transition-all text-sm lg:text-base" placeholder="Type your message..." required autocomplete="off">
                                </div>

                                {{-- Send Button --}}
                                <button type="submit" class="flex items-center justify-center w-10 h-10 lg:w-12 lg:h-12 bg-gradient-to-br from-emerald-500 to-emerald-700 hover:from-emerald-600 hover:to-emerald-800 rounded-xl lg:rounded-2xl shadow-lg transition-all duration-300 transform hover:scale-105 group">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 lg:w-5 lg:h-5 text-white transform rotate-45 group-hover:scale-110 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                                    </svg>
                                </button>
                            </form>
                        @else
                            {{-- No Trainer Selected State --}}
                            <div class="flex-1 flex items-center justify-center bg-gradient-to-br from-gray-900 to-gray-950">
                                <div class="text-center px-4">
                                    <div class="w-16 h-16 lg:w-24 lg:h-24 bg-emerald-500/10 rounded-2xl lg:rounded-3xl flex items-center justify-center mx-auto mb-4 lg:mb-6 border border-emerald-500/20">
                                        <span class="text-2xl lg:text-4xl">💬</span>
                                    </div>
                                    <h3 class="text-xl lg:text-2xl font-black text-white mb-2 lg:mb-3">Select a Trainer</h3>
                                    <p class="text-emerald-400/80 text-sm lg:text-lg mb-4 lg:mb-6 max-w-md">
                                        Choose a trainer from the list to start your conversation and get personalized fitness guidance
                                    </p>
                                    <div class="flex items-center justify-center gap-2 text-emerald-400/60">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 lg:h-5 lg:w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-xs lg:text-sm font-medium">AI Trainer available 24/7</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔔 SCRIPT --}}
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        // Mobile Toggle Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const mobileToggle = document.getElementById('mobile-toggle');
            const trainerSidebar = document.getElementById('trainer-sidebar');
            const toggleIcon = document.getElementById('toggle-icon');

            if (mobileToggle && trainerSidebar) {
                mobileToggle.addEventListener('click', function() {
                    const isOpen = trainerSidebar.classList.contains('max-h-0');
                    
                    if (isOpen) {
                        trainerSidebar.classList.remove('max-h-0');
                        trainerSidebar.classList.add('max-h-96');
                        toggleIcon.classList.add('rotate-180');
                    } else {
                        trainerSidebar.classList.remove('max-h-96');
                        trainerSidebar.classList.add('max-h-0');
                        toggleIcon.classList.remove('rotate-180');
                    }
                });
            }

            // Auto-close sidebar on mobile when a trainer is selected
            if (window.innerWidth < 1024 && {{ isset($trainer) ? 'true' : 'false' }}) {
                if (trainerSidebar) {
                    trainerSidebar.classList.add('max-h-0');
                    toggleIcon.classList.remove('rotate-180');
                }
            }
        });

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
                    console.warn('Failed to mark messages as read:', err);
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
                    // Add user message
                    chatBox.insertAdjacentHTML('beforeend', `
                            <div class="flex justify-end relative chat-message">
                                <div class="max-w-[85%] lg:max-w-[80%]">
                                    <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 text-white font-semibold px-3 lg:px-4 py-2 lg:py-3 rounded-xl lg:rounded-2xl rounded-br-none shadow-lg text-sm lg:text-base">${message}</div>
                                    <p class="text-xs text-emerald-400/60 mt-1 lg:mt-2 text-right">${localTime}</p>
                                </div>
                            </div>
                        `);

                    // Add AI typing indicator
                    loadingId = `ai-loading-${Date.now()}`;
                    chatBox.insertAdjacentHTML('beforeend', `
                            <div class="flex items-start gap-2 lg:gap-3 chat-message" id="${loadingId}">
                                <div class="w-8 h-8 lg:w-10 lg:h-10 bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl lg:rounded-2xl flex items-center justify-center text-white text-xs lg:text-sm font-bold">AI</div>
                                <div class="glass border border-emerald-500/20 text-emerald-400 px-3 lg:px-4 py-2 lg:py-3 rounded-xl lg:rounded-2xl rounded-bl-none max-w-[85%] lg:max-w-[80%] text-sm lg:text-base">
                                    <span class="animate-pulse">AI is thinking...</span>
                                </div>
                            </div>
                        `);
                }

                chatInput.value = '';
                chatBox.scrollTop = chatBox.scrollHeight;

                try {
                    const res = await axios.post("{{ route('user.training.ai-chat') }}", {
    message,
    trainer_id: currentTrainerId,
    _token: "{{ csrf_token() }}"
});

                    if (isAiMode) {
                        // Remove typing indicator and add AI response
                        document.getElementById(loadingId)?.remove();
                        chatBox.insertAdjacentHTML('beforeend', `
                                <div class="flex items-start gap-2 lg:gap-3 chat-message">
                                    <div class="w-8 h-8 lg:w-10 lg:h-10 bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl lg:rounded-2xl flex items-center justify-center text-white text-xs lg:text-sm font-bold">AI</div>
                                    <div class="glass border border-emerald-500/20 text-gray-100 px-3 lg:px-4 py-2 lg:py-3 rounded-xl lg:rounded-2xl rounded-bl-none max-w-[85%] lg:max-w-[80%] text-sm lg:text-base">${res.data.ai_message}</div>
                                </div>
                            `);
                    } else {
                        // Add user message with delete button for human trainers
                        chatBox.insertAdjacentHTML('beforeend', `
                                <div class="flex justify-end relative chat-message" id="chat-${res.data.chat_id}">
                                    <div class="max-w-[85%] lg:max-w-[80%]">
                                        <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 text-white font-semibold px-3 lg:px-4 py-2 lg:py-3 rounded-xl lg:rounded-2xl rounded-br-none shadow-lg text-sm lg:text-base">${res.data.message}</div>
                                        <div class="flex justify-end items-center gap-2 mt-1 lg:mt-2">
                                            <p class="text-xs text-emerald-400/60">${res.data.local_time}</p>
                                            <button data-id="${res.data.chat_id}" class="delete-chat text-xs text-emerald-400/60 hover:text-red-400 transition-all duration-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 lg:h-4 lg:w-4" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            `);
                    }
                    chatBox.scrollTop = chatBox.scrollHeight;
                } catch (err) {
                    console.error('Failed to send message:', err);
                    alert('Failed to send message! Please try again.');
                    if (loadingId) document.getElementById(loadingId)?.remove();
                }
            });

            // 🗑️ Delete Message
            document.addEventListener('click', async (e) => {
                if (e.target.classList.contains('delete-chat') || e.target.closest('.delete-chat')) {
                    const button = e.target.classList.contains('delete-chat') ? e.target : e.target.closest('.delete-chat');
                    const chatId = button.dataset.id;
                    const chatEl = document.getElementById(`chat-${chatId}`);

                    if (confirm('Delete this message?')) {
                        chatEl.style.opacity = '0';
                        chatEl.style.transform = 'translateY(20px)';
                        chatEl.style.transition = 'all 0.3s ease';

                        setTimeout(async () => {
                            try {
                                await axios.delete(`/user/chat/${chatId}`);
                                chatEl.remove();
                            } catch (err) {
                                console.error('Failed to delete message:', err);
                                alert('Failed to delete message!');
                                chatEl.style.opacity = '1';
                                chatEl.style.transform = 'translateY(0)';
                            }
                        }, 300);
                    }
                }
            });
        @endif
    </script>

    <style>
        .text-gradient {
            background: linear-gradient(135deg, #10b981 0%, #34d399 50%, #6ee7b7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .glass {
            background: rgba(10, 10, 10, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .glass-dark {
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .animate-glow {
            animation: glow 2s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from {
                box-shadow: 0 0 10px rgba(16, 185, 129, 0.4);
            }
            to {
                box-shadow: 0 0 20px rgba(16, 185, 129, 0.6), 0 0 30px rgba(16, 185, 129, 0.4);
            }
        }

        /* Custom scrollbar for chat */
        #chat-box::-webkit-scrollbar {
            width: 4px;
        }

        #chat-box::-webkit-scrollbar-track {
            background: rgba(16, 185, 129, 0.1);
            border-radius: 2px;
        }

        #chat-box::-webkit-scrollbar-thumb {
            background: rgba(16, 185, 129, 0.3);
            border-radius: 2px;
        }

        #chat-box::-webkit-scrollbar-thumb:hover {
            background: rgba(16, 185, 129, 0.5);
        }

        /* Mobile optimizations */
        @media (max-width: 1024px) {
            #trainer-sidebar {
                transition: max-height 0.3s ease-in-out;
            }
        }
    </style>
@endsection