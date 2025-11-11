@extends('layouts.user')
@section('title', 'Find Trainer')

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header Section --}}
        <div class="glass-dark rounded-3xl p-8 border border-emerald-500/20 shadow-2xl shadow-emerald-500/10 mb-8">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl flex items-center justify-center animate-glow">
                        <span class="text-2xl">🏋️</span>
                    </div>
                    <div>
                        <h1 class="text-3xl sm:text-4xl font-black text-white">
                            Find <span class="text-gradient">Professional Trainers</span>
                        </h1>
                        <p class="text-emerald-400/80 text-lg mt-2">Connect with certified fitness experts for personalized training</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-emerald-400 font-bold text-sm uppercase tracking-wider mb-2">Available Now</div>
                    <p class="text-white font-semibold">{{ $trainers->count() }} certified trainers</p>
                </div>
            </div>
        </div>

        {{-- Search Form --}}
        <div class="glass-dark rounded-2xl p-6 border border-emerald-500/20 shadow-xl shadow-emerald-500/10 mb-8">
            <div class="flex items-center gap-3 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                </svg>
                <h2 class="text-lg font-bold text-white">Search Trainers</h2>
            </div>
            <form method="GET" class="relative">
                <input type="text" name="search" placeholder="Search by trainer name, specialty..." value="{{ request('search') }}"
                    class="w-full glass border border-emerald-500/20 rounded-2xl px-6 py-4 text-white placeholder-emerald-400/60
                           focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20 transition-all duration-300">
            </form>
        </div>

        {{-- Trainers Grid --}}
        @if($trainers->isEmpty())
            <div class="glass-dark rounded-3xl p-12 text-center border border-emerald-500/20">
                <div class="w-24 h-24 bg-emerald-500/10 rounded-3xl flex items-center justify-center mx-auto mb-6 border border-emerald-500/20">
                    <span class="text-4xl">🏋️</span>
                </div>
                <h3 class="text-2xl font-black text-white mb-3">No Trainers Available</h3>
                <p class="text-emerald-400/80 text-lg mb-6 max-w-md mx-auto">
                    We're working on bringing more certified trainers to our platform. Check back soon!
                </p>
                <div class="flex items-center justify-center gap-2 text-emerald-400/60">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-sm font-medium">New trainers coming soon</span>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($trainers as $trainer)
                    <div class="glass rounded-2xl p-6 border border-emerald-500/10 hover:border-emerald-500/30 transition-all duration-300 group hover-glow">
                        {{-- Trainer Header --}}
                        <div class="flex items-center gap-4 mb-4">
                            @if($trainer->avatar)
                                <img src="{{ asset($trainer->avatar) }}" alt="{{ $trainer->name }}"
                                    class="w-16 h-16 rounded-2xl object-cover border-2 border-emerald-500/30 group-hover:border-emerald-500/50 transition-all duration-300">
                            @else
                                <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl flex items-center justify-center text-white text-xl font-bold">
                                    {{ strtoupper(substr($trainer->name, 0, 1)) }}
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <h3 class="text-white font-bold text-lg truncate">{{ $trainer->name }}</h3>
                                <p class="text-emerald-400 text-sm font-medium">
                                    {{ $trainer->trainerProfile->speciality ?? 'Professional Trainer' }}
                                </p>
                            </div>
                        </div>

                        {{-- Bio --}}
                        <p class="text-emerald-400/80 text-sm mb-6 line-clamp-3 leading-relaxed">
                            {{ $trainer->trainerProfile->bio ?? 'No description available.' }}
                        </p>

                        {{-- Action Button --}}
                        <a href="{{ route('user.training.show', $trainer->id) }}"
                            class="group flex items-center justify-center gap-2 w-full bg-gradient-to-r from-emerald-500 to-emerald-700 hover:from-emerald-600 hover:to-emerald-800 text-white font-bold py-3 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-emerald-500/25">
                            View Profile
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform group-hover:translate-x-1 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($trainers->hasPages())
                <div class="glass-dark rounded-2xl p-6 border border-emerald-500/20">
                    {{ $trainers->links('pagination::tailwind') }}
                </div>
            @endif
        @endif

        {{-- AI Chat Assistant --}}
        <div class="glass-dark rounded-3xl border border-emerald-500/20 shadow-2xl shadow-emerald-500/10 overflow-hidden mt-8">
            <div class="px-8 py-6 border-b border-emerald-500/20 bg-gray-900/50">
                <h2 class="text-2xl font-black text-white flex items-center gap-3">
                    <span class="text-gradient">AI Trainer Assistant</span>
                    <span class="text-xs font-bold bg-emerald-500/20 text-emerald-400 px-2 py-1 rounded-full border border-emerald-500/30">Max 5 Messages</span>
                </h2>
            </div>

            <div class="p-6">
                <div class="mb-4">
                    <p class="text-emerald-400/80 text-sm">Get instant help from our AI trainer to find the perfect match for your fitness goals</p>
                </div>

                {{-- Chat Box --}}
                <div id="chat-box" class="h-64 overflow-y-auto glass rounded-2xl border border-emerald-500/20 p-4 mb-4">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-xl flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                            AI
                        </div>
                        <div class="flex-1">
                            <p class="text-white font-medium mb-1">AI Trainer</p>
                            <p class="text-emerald-400/80 text-sm">Hello! I'm here to help you find the perfect trainer. What are your fitness goals? 💪</p>
                        </div>
                    </div>
                </div>

                {{-- Chat Input --}}
                <div class="flex gap-3">
                    <input id="chat-input" type="text" placeholder="Type your fitness goals or questions..." 
                        class="flex-1 glass border border-emerald-500/20 rounded-2xl px-4 py-3 text-white placeholder-emerald-400/60
                               focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20 transition-all duration-300">
                    <button id="chat-send" 
                        class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-700 hover:from-emerald-600 hover:to-emerald-800 rounded-2xl text-white font-bold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-emerald-500/25">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform rotate-45" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                        </svg>
                    </button>
                </div>

                {{-- Message Counter --}}
                <div class="mt-3 flex items-center justify-between">
                    <p class="text-emerald-400/60 text-sm">Free AI assistance - limited to 5 messages</p>
                    <p id="message-counter" class="text-emerald-400 text-sm font-bold">0/5 messages used</p>
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
                <div class="flex items-start gap-3 mt-4">
                    <div class="w-8 h-8 bg-red-500/20 rounded-xl flex items-center justify-center text-red-400 text-sm font-bold flex-shrink-0">
                        ⚠️
                    </div>
                    <div class="flex-1">
                        <p class="text-red-400 font-medium mb-1">System</p>
                        <p class="text-red-400/80 text-sm">Message limit reached (5 messages). Please contact a trainer directly for further assistance.</p>
                    </div>
                </div>
            `;
            input.value = '';
            chatBox.scrollTop = chatBox.scrollHeight;
            return;
        }

        // Add user message
        chatBox.innerHTML += `
            <div class="flex justify-end mt-4">
                <div class="max-w-[80%]">
                    <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 text-white font-medium px-4 py-3 rounded-2xl rounded-br-none shadow-lg">
                        ${text}
                    </div>
                    <p class="text-emerald-400/60 text-xs mt-2 text-right">You</p>
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
            <div class="flex items-start gap-3 mt-4" id="${loadingId}">
                <div class="w-8 h-8 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-xl flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                    AI
                </div>
                <div class="flex-1">
                    <p class="text-white font-medium mb-1">AI Trainer</p>
                    <div class="flex items-center gap-2 text-emerald-400/80 text-sm">
                        <div class="flex space-x-1">
                            <div class="w-2 h-2 bg-emerald-400 rounded-full animate-bounce"></div>
                            <div class="w-2 h-2 bg-emerald-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                            <div class="w-2 h-2 bg-emerald-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
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
            
            chatBox.innerHTML += `
                <div class="flex items-start gap-3 mt-4">
                    <div class="w-8 h-8 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-xl flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                        AI
                    </div>
                    <div class="flex-1">
                        <p class="text-white font-medium mb-1">AI Trainer</p>
                        <p class="text-emerald-400/80 text-sm">${data.reply}</p>
                    </div>
                </div>
            `;
            chatBox.scrollTop = chatBox.scrollHeight;
        } catch (err) {
            document.getElementById(loadingId).remove();
            chatBox.innerHTML += `
                <div class="flex items-start gap-3 mt-4">
                    <div class="w-8 h-8 bg-red-500/20 rounded-xl flex items-center justify-center text-red-400 text-sm font-bold flex-shrink-0">
                        ⚠️
                    </div>
                    <div class="flex-1">
                        <p class="text-red-400 font-medium mb-1">Error</p>
                        <p class="text-red-400/80 text-sm">Sorry, I'm having trouble responding right now. Please try again later.</p>
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
        width: 6px;
    }

    #chat-box::-webkit-scrollbar-track {
        background: rgba(16, 185, 129, 0.1);
        border-radius: 3px;
    }

    #chat-box::-webkit-scrollbar-thumb {
        background: rgba(16, 185, 129, 0.3);
        border-radius: 3px;
    }

    #chat-box::-webkit-scrollbar-thumb:hover {
        background: rgba(16, 185, 129, 0.5);
    }
</style>
@endsection