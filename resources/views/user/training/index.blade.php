@extends('layouts.user')
@section('title', 'Find Trainer')

@section('content')
<div class="min-h-screen py-4 md:py-8">
    <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8">

        {{-- Header Section --}}
        <div class="glass-dark rounded-2xl md:rounded-3xl p-4 md:p-8 border border-emerald-500/20 shadow-lg md:shadow-2xl shadow-emerald-500/10 mb-6 md:mb-8">
            <div class="flex flex-col lg:flex-row justify-between items-start gap-4 md:gap-6">
                <div class="flex items-center gap-3 md:gap-4">
                    <div class="w-10 h-10 md:w-14 md:h-14 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-xl md:rounded-2xl flex items-center justify-center animate-glow">
                        <span class="text-xl md:text-2xl">🏋️</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-white leading-tight">
                            Find <span class="text-gradient">Professional Trainers</span>
                        </h1>
                        <p class="text-emerald-400/80 text-sm md:text-lg mt-1 md:mt-2">Connect with certified fitness experts for personalized training</p>
                    </div>
                </div>
                <div class="text-left lg:text-right w-full lg:w-auto mt-4 lg:mt-0">
                    <div class="text-emerald-400 font-bold text-xs md:text-sm uppercase tracking-wider mb-1 md:mb-2">Available Now</div>
                    <p class="text-white font-semibold text-sm md:text-base">{{ $trainers->total() }} certified trainers</p>
                </div>
            </div>
        </div>

        {{-- Current Trainer Status --}}
        @if($user->trainer_id)
        <div class="glass rounded-xl md:rounded-2xl p-4 md:p-6 border border-emerald-500/30 bg-gradient-to-r from-emerald-500/10 to-emerald-600/5 mb-6 md:mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3 md:gap-4">
                    <div class="w-12 h-12 md:w-16 md:h-16 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-xl md:rounded-2xl flex items-center justify-center flex-shrink-0">
                        <span class="text-white text-lg md:text-xl">👨‍🏫</span>
                    </div>
                    <div class="min-w-0">
                        <h3 class="text-lg md:text-xl font-black text-white truncate">You have an active trainer!</h3>
                        <p class="text-emerald-400 text-sm md:text-base">Continue your journey with personalized guidance</p>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-2 md:gap-3 w-full sm:w-auto">
                    <a href="{{ route('user.training.my-trainer') }}" 
                       class="px-4 md:px-6 py-2 md:py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold rounded-lg md:rounded-xl transition-all duration-300 hover-glow text-sm md:text-base text-center">
                        View My Trainer
                    </a>
                    <a href="{{ route('user.training.switch-trainer') }}" 
                       class="px-4 md:px-6 py-2 md:py-3 bg-dark-700 hover:bg-dark-600 text-white font-semibold rounded-lg md:rounded-xl border border-emerald-500/30 hover:border-emerald-400 transition-all duration-300 text-sm md:text-base text-center">
                        Switch Trainer
                    </a>
                </div>
            </div>
        </div>
        @endif

        {{-- Search and Filter Section --}}
        <div class="glass-dark rounded-xl md:rounded-2xl p-4 md:p-6 border border-emerald-500/20 shadow-lg md:shadow-xl shadow-emerald-500/10 mb-6 md:mb-8">
            <div class="flex items-center gap-2 md:gap-3 mb-3 md:mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5 text-emerald-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                </svg>
                <h2 class="text-base md:text-lg font-bold text-white">Search & Filter Trainers</h2>
            </div>
            
            <form method="GET" class="space-y-3 md:space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 md:gap-4">
                    {{-- Search Input --}}
                    <div class="relative">
                        <input type="text" name="search" placeholder="Search by name, specialty..." value="{{ request('search') }}"
                            class="w-full glass border border-emerald-500/20 rounded-xl md:rounded-2xl px-4 md:px-6 py-3 md:py-4 text-white placeholder-emerald-400/60 text-sm md:text-base
                                   focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20 transition-all duration-300">
                        <div class="absolute right-3 top-3 text-emerald-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    
                    {{-- Specialization Filter --}}
                    <select name="specialization" class="w-full glass border border-emerald-500/20 rounded-xl md:rounded-2xl px-3 md:px-4 py-3 md:py-4 text-white focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20 transition-all duration-300 text-sm md:text-base">
                        <option value="">All Specializations</option>
                        <option value="weight_loss" {{ request('specialization') == 'weight_loss' ? 'selected' : '' }}>Weight Loss</option>
                        <option value="muscle_gain" {{ request('specialization') == 'muscle_gain' ? 'selected' : '' }}>Muscle Gain</option>
                        <option value="bodybuilding" {{ request('specialization') == 'bodybuilding' ? 'selected' : '' }}>Bodybuilding</option>
                        <option value="functional_training" {{ request('specialization') == 'functional_training' ? 'selected' : '' }}>Functional Training</option>
                        <option value="rehabilitation" {{ request('specialization') == 'rehabilitation' ? 'selected' : '' }}>Rehabilitation</option>
                    </select>
                    
                    {{-- Experience Filter --}}
                    <select name="experience" class="w-full glass border border-emerald-500/20 rounded-xl md:rounded-2xl px-3 md:px-4 py-3 md:py-4 text-white focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20 transition-all duration-300 text-sm md:text-base">
                        <option value="">All Experience Levels</option>
                        <option value="1-3" {{ request('experience') == '1-3' ? 'selected' : '' }}>1-3 Years</option>
                        <option value="3-5" {{ request('experience') == '3-5' ? 'selected' : '' }}>3-5 Years</option>
                        <option value="5+" {{ request('experience') == '5+' ? 'selected' : '' }}>5+ Years</option>
                    </select>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-2 md:gap-3">
                    <button type="submit" 
                            class="px-4 md:px-6 py-2 md:py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold rounded-lg md:rounded-xl transition-all duration-300 hover-glow text-sm md:text-base text-center">
                        Apply Filters
                    </button>
                    <a href="{{ route('user.training.index') }}" 
                       class="px-4 md:px-6 py-2 md:py-3 bg-dark-700 hover:bg-dark-600 text-white font-semibold rounded-lg md:rounded-xl border border-emerald-500/30 hover:border-emerald-400 transition-all duration-300 text-sm md:text-base text-center">
                        Clear Filters
                    </a>
                </div>
            </form>
        </div>

        {{-- Trainers Grid --}}
        @if($trainers->isEmpty())
            <div class="glass-dark rounded-2xl md:rounded-3xl p-6 md:p-12 text-center border border-emerald-500/20">
                <div class="w-16 h-16 md:w-24 md:h-24 bg-emerald-500/10 rounded-2xl md:rounded-3xl flex items-center justify-center mx-auto mb-4 md:mb-6 border border-emerald-500/20">
                    <span class="text-2xl md:text-4xl">🏋️</span>
                </div>
                <h3 class="text-xl md:text-2xl font-black text-white mb-2 md:mb-3">No Trainers Found</h3>
                <p class="text-emerald-400/80 text-sm md:text-lg mb-4 md:mb-6 max-w-md mx-auto">
                    No trainers match your search criteria. Try adjusting your filters or search terms.
                </p>
                <a href="{{ route('user.training.index') }}" 
                   class="inline-flex items-center justify-center gap-2 px-4 md:px-6 py-2 md:py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold rounded-lg md:rounded-xl transition-all duration-300 hover-glow text-sm md:text-base">
                    Show All Trainers
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6 mb-6 md:mb-8">
                @foreach($trainers as $trainer)
                    <div class="glass rounded-xl md:rounded-2xl p-4 md:p-6 border border-emerald-500/10 hover:border-emerald-500/30 transition-all duration-300 group hover-glow">
                        {{-- Trainer Header --}}
                        <div class="flex items-center gap-3 md:gap-4 mb-3 md:mb-4">
                            @if($trainer->avatar)
                                <img src="{{ asset($trainer->avatar) }}" alt="{{ $trainer->name }}"
                                    class="w-12 h-12 md:w-16 md:h-16 rounded-xl md:rounded-2xl object-cover border-2 border-emerald-500/30 group-hover:border-emerald-500/50 transition-all duration-300 flex-shrink-0">
                            @else
                                <div class="w-12 h-12 md:w-16 md:h-16 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-xl md:rounded-2xl flex items-center justify-center text-white text-lg md:text-xl font-bold flex-shrink-0">
                                    {{ strtoupper(substr($trainer->name, 0, 1)) }}
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <h3 class="text-white font-bold text-base md:text-lg truncate">{{ $trainer->name }}</h3>
                                <p class="text-emerald-400 text-xs md:text-sm font-medium truncate">
                                    {{ $trainer->trainerProfile->specialization ?? 'Professional Trainer' }}
                                </p>
                                {{-- Rating --}}
                                @if($trainer->trainerProfile && $trainer->trainerProfile->rating > 0)
                                <div class="flex items-center gap-1 mt-1">
                                    <div class="flex">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="text-{{ $i <= $trainer->trainerProfile->rating ? 'yellow' : 'gray' }}-400 text-xs">★</span>
                                        @endfor
                                    </div>
                                    <span class="text-gray-400 text-xs">({{ number_format($trainer->trainerProfile->rating, 1) }})</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        {{-- Experience & Specialization --}}
                        <div class="space-y-1 md:space-y-2 mb-3 md:mb-4">
                            <div class="flex items-center gap-2 text-xs md:text-sm text-gray-300">
                                <span class="text-xs">🕐</span>
                                <span>{{ $trainer->trainerProfile->experience_years ?? 0 }}+ years experience</span>
                            </div>
                            @if($trainer->trainerProfile && $trainer->trainerProfile->certifications)
                            <div class="flex items-center gap-2 text-xs md:text-sm text-gray-300">
                                <span class="text-xs">📜</span>
                                <span class="truncate">{{ $trainer->trainerProfile->certifications }}</span>
                            </div>
                            @endif
                        </div>

                        {{-- Bio --}}
                        <p class="text-emerald-400/80 text-xs md:text-sm mb-4 md:mb-6 line-clamp-3 leading-relaxed">
                            {{ $trainer->trainerProfile->bio ?? 'Certified professional trainer ready to help you achieve your fitness goals.' }}
                        </p>

                        {{-- Action Buttons --}}
                        <div class="flex flex-col sm:flex-row gap-2">
                            <a href="{{ route('user.training.show', $trainer->id) }}" 
                               class="flex-1 bg-emerald-500 hover:bg-emerald-600 text-white text-center py-2 px-3 md:px-4 rounded-lg md:rounded-xl font-semibold transition-all duration-300 hover-glow text-xs md:text-sm">
                                View Profile
                            </a>
                            @if(!$user->trainer_id)
                            <form action="{{ route('user.training.order', $trainer->id) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" 
                                        class="w-full bg-dark-700 hover:bg-dark-600 border border-emerald-500/30 hover:border-emerald-400 text-white py-2 px-3 md:px-4 rounded-lg md:rounded-xl font-semibold transition-all duration-300 text-xs md:text-sm">
                                    Hire
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($trainers->hasPages())
                <div class="glass-dark rounded-xl md:rounded-2xl p-4 md:p-6 border border-emerald-500/20">
                    {{ $trainers->links() }}
                </div>
            @endif
        @endif

        {{-- Features Section --}}
        <div class="glass-dark rounded-xl md:rounded-2xl p-6 md:p-8 border border-emerald-500/20 mt-8 md:mt-12">
            <h2 class="text-2xl md:text-3xl font-black text-white text-center mb-6 md:mb-8">Why Choose Our Trainers?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
                <div class="text-center">
                    <div class="w-12 h-12 md:w-16 md:h-16 bg-emerald-500/10 rounded-xl md:rounded-2xl flex items-center justify-center mx-auto mb-3 md:mb-4 border border-emerald-500/20">
                        <span class="text-xl md:text-2xl">🎯</span>
                    </div>
                    <h3 class="text-lg md:text-xl font-black text-white mb-1 md:mb-2">Personalized Programs</h3>
                    <p class="text-gray-400 text-sm md:text-base">Custom workout and nutrition plans tailored to your specific goals and needs.</p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 md:w-16 md:h-16 bg-emerald-500/10 rounded-xl md:rounded-2xl flex items-center justify-center mx-auto mb-3 md:mb-4 border border-emerald-500/20">
                        <span class="text-xl md:text-2xl">💬</span>
                    </div>
                    <h3 class="text-lg md:text-xl font-black text-white mb-1 md:mb-2">24/7 Support</h3>
                    <p class="text-gray-400 text-sm md:text-base">Get instant answers to your questions and continuous motivation from your trainer.</p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 md:w-16 md:h-16 bg-emerald-500/10 rounded-xl md:rounded-2xl flex items-center justify-center mx-auto mb-3 md:mb-4 border border-emerald-500/20">
                        <span class="text-xl md:text-2xl">📊</span>
                    </div>
                    <h3 class="text-lg md:text-xl font-black text-white mb-1 md:mb-2">Progress Tracking</h3>
                    <p class="text-gray-400 text-sm md:text-base">Monitor your improvements with detailed analytics and regular progress assessments.</p>
                </div>
            </div>
        </div>

        {{-- AI Chat Assistant --}}
        <div class="glass-dark rounded-2xl md:rounded-3xl border border-emerald-500/20 shadow-lg md:shadow-2xl shadow-emerald-500/10 overflow-hidden mt-6 md:mt-8">
            <div class="px-4 md:px-8 py-4 md:py-6 border-b border-emerald-500/20 bg-gray-900/50">
                <h2 class="text-xl md:text-2xl font-black text-white flex flex-col sm:flex-row sm:items-center gap-2 md:gap-3">
                    <span class="text-gradient">AI Trainer Assistant</span>
                    <span class="text-xs font-bold bg-emerald-500/20 text-emerald-400 px-2 py-1 rounded-full border border-emerald-500/30 w-fit">Max 5 Messages</span>
                </h2>
            </div>

            <div class="p-4 md:p-6">
                <div class="mb-3 md:mb-4">
                    <p class="text-emerald-400/80 text-xs md:text-sm">Get instant help from our AI trainer to find the perfect match for your fitness goals</p>
                </div>

                {{-- Chat Box --}}
                <div id="chat-box" class="h-48 md:h-64 overflow-y-auto glass rounded-xl md:rounded-2xl border border-emerald-500/20 p-3 md:p-4 mb-3 md:mb-4">
                    <div class="flex items-start gap-2 md:gap-3">
                        <div class="w-6 h-6 md:w-8 md:h-8 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-lg md:rounded-xl flex items-center justify-center text-white text-xs md:text-sm font-bold flex-shrink-0">
                            AI
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-white font-medium text-sm md:text-base mb-1">AI Trainer</p>
                            <p class="text-emerald-400/80 text-xs md:text-sm">Hello! I'm here to help you find the perfect trainer. What are your fitness goals? 💪</p>
                        </div>
                    </div>
                </div>

                {{-- Chat Input --}}
                <div class="flex gap-2 md:gap-3">
                    <input id="chat-input" type="text" placeholder="Type your fitness goals or questions..." 
                        class="flex-1 glass border border-emerald-500/20 rounded-xl md:rounded-2xl px-3 md:px-4 py-2 md:py-3 text-white placeholder-emerald-400/60 text-sm md:text-base
                               focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20 transition-all duration-300">
                    <button id="chat-send" 
                        class="flex items-center justify-center w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-emerald-500 to-emerald-700 hover:from-emerald-600 hover:to-emerald-800 rounded-xl md:rounded-2xl text-white font-bold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-emerald-500/25 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5 transform rotate-45" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                        </svg>
                    </button>
                </div>

                {{-- Message Counter --}}
                <div class="mt-2 md:mt-3 flex flex-col sm:flex-row sm:items-center justify-between gap-1 md:gap-2">
                    <p class="text-emerald-400/60 text-xs md:text-sm">Free AI assistance - limited to 5 messages</p>
                    <p id="message-counter" class="text-emerald-400 text-xs md:text-sm font-bold">0/5 messages used</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Chat AI Script --}}
<script>
    let messageCount = 0;
    const maxMessages = 5;
    const chatBox = document.getElementById('chat-box');
    const input = document.getElementById('chat-input');
    const sendBtn = document.getElementById('chat-send');
    const messageCounter = document.getElementById('message-counter');

    function updateMessageCounter() {
        messageCounter.textContent = `${messageCount}/${maxMessages} messages used`;
    }

    async function sendMessage() {
        const text = input.value.trim();
        if (!text) return;

        if (messageCount >= maxMessages) {
            chatBox.innerHTML += `
                <div class="flex items-start gap-2 md:gap-3 mt-3 md:mt-4">
                    <div class="w-6 h-6 md:w-8 md:h-8 bg-red-500/20 rounded-lg md:rounded-xl flex items-center justify-center text-red-400 text-xs md:text-sm font-bold flex-shrink-0">
                        ⚠️
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-red-400 font-medium text-sm md:text-base mb-1">System</p>
                        <p class="text-red-400/80 text-xs md:text-sm">Message limit reached (5 messages). Please contact a trainer directly for further assistance.</p>
                    </div>
                </div>
            `;
            input.value = '';
            chatBox.scrollTop = chatBox.scrollHeight;
            return;
        }

        // Add user message
        chatBox.innerHTML += `
            <div class="flex justify-end mt-3 md:mt-4">
                <div class="max-w-[85%] md:max-w-[80%]">
                    <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 text-white font-medium px-3 md:px-4 py-2 md:py-3 rounded-xl md:rounded-2xl rounded-br-none shadow-lg text-sm md:text-base">
                        ${text}
                    </div>
                    <p class="text-emerald-400/60 text-xs mt-1 md:mt-2 text-right">You</p>
                </div>
            </div>
        `;
        
        input.value = '';
        messageCount++;
        updateMessageCounter();
        chatBox.scrollTop = chatBox.scrollHeight;

        // Add loading indicator
        const loadingId = `loading-${Date.now()}`;
        chatBox.innerHTML += `
            <div class="flex items-start gap-2 md:gap-3 mt-3 md:mt-4" id="${loadingId}">
                <div class="w-6 h-6 md:w-8 md:h-8 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-lg md:rounded-xl flex items-center justify-center text-white text-xs md:text-sm font-bold flex-shrink-0">
                    AI
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-white font-medium text-sm md:text-base mb-1">AI Trainer</p>
                    <div class="flex items-center gap-2 text-emerald-400/80 text-xs md:text-sm">
                        <div class="flex space-x-1">
                            <div class="w-1.5 h-1.5 md:w-2 md:h-2 bg-emerald-400 rounded-full animate-bounce"></div>
                            <div class="w-1.5 h-1.5 md:w-2 md:h-2 bg-emerald-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                            <div class="w-1.5 h-1.5 md:w-2 md:h-2 bg-emerald-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                        </div>
                        Thinking...
                    </div>
                </div>
            </div>
        `;
        chatBox.scrollTop = chatBox.scrollHeight;

        try {
            const response = await fetch("{{ route('user.training.ai.chat') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ message: text })
            });

            const data = await response.json();
            
            document.getElementById(loadingId).remove();
            
            if (data.success) {
                chatBox.innerHTML += `
                    <div class="flex items-start gap-2 md:gap-3 mt-3 md:mt-4">
                        <div class="w-6 h-6 md:w-8 md:h-8 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-lg md:rounded-xl flex items-center justify-center text-white text-xs md:text-sm font-bold flex-shrink-0">
                            AI
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-white font-medium text-sm md:text-base mb-1">AI Trainer</p>
                            <p class="text-emerald-400/80 text-xs md:text-sm">${data.reply}</p>
                        </div>
                    </div>
                `;
                messageCounter.textContent = `${messageCount}/${maxMessages} messages used (${data.remaining_messages} remaining)`;
            } else {
                chatBox.innerHTML += `
                    <div class="flex items-start gap-2 md:gap-3 mt-3 md:mt-4">
                        <div class="w-6 h-6 md:w-8 md:h-8 bg-red-500/20 rounded-lg md:rounded-xl flex items-center justify-center text-red-400 text-xs md:text-sm font-bold flex-shrink-0">
                            ⚠️
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-red-400 font-medium text-sm md:text-base mb-1">AI Trainer</p>
                            <p class="text-red-400/80 text-xs md:text-sm">${data.reply}</p>
                        </div>
                    </div>
                `;
            }
            chatBox.scrollTop = chatBox.scrollHeight;
        } catch (err) {
            document.getElementById(loadingId).remove();
            chatBox.innerHTML += `
                <div class="flex items-start gap-2 md:gap-3 mt-3 md:mt-4">
                    <div class="w-6 h-6 md:w-8 md:h-8 bg-red-500/20 rounded-lg md:rounded-xl flex items-center justify-center text-red-400 text-xs md:text-sm font-bold flex-shrink-0">
                        ⚠️
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-red-400 font-medium text-sm md:text-base mb-1">Error</p>
                        <p class="text-red-400/80 text-xs md:text-sm">Sorry, I'm having trouble responding right now. Please try again later.</p>
                    </div>
                </div>
            `;
            chatBox.scrollTop = chatBox.scrollHeight;
        }
    }

    sendBtn.addEventListener('click', sendMessage);
    input.addEventListener('keypress', e => {
        if (e.key === 'Enter') sendMessage();
    });

    // Initialize message counter
    updateMessageCounter();
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

    .hover-glow:hover {
        box-shadow: 0 0 25px rgba(16, 185, 129, 0.3);
        transform: translateY(-2px);
        transition: all 0.3s ease;
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

    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
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

    /* Responsive improvements for very small screens */
    @media (max-width: 360px) {
        .grid-cols-1 {
            grid-template-columns: 1fr;
        }
        
        #chat-box {
            height: 120px;
        }
    }
</style>
@endsection