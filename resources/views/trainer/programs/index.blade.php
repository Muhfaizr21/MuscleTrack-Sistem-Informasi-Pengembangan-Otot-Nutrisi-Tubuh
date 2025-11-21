@extends('layouts.trainer')

@section('title', 'Program Latihan Member')

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
                    <div>
                        <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-white leading-tight">
                            Program <span class="text-gradient">Latihan Member</span>
                        </h1>
                        <p class="text-emerald-400/80 text-sm md:text-lg mt-1 md:mt-2">Kelola dan pantau program latihan semua member Anda</p>
                    </div>
                </div>
                <div class="text-left lg:text-right w-full lg:w-auto mt-4 lg:mt-0">
                    <div class="text-emerald-400 font-bold text-xs md:text-sm uppercase tracking-wider mb-1 md:mb-2">Total Member</div>
                    <p class="text-white font-semibold text-sm md:text-base">{{ $members->count() }} active members</p>
                </div>
            </div>
        </div>

        {{-- Stats Overview --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3 md:gap-4 mb-6 md:mb-8">
            <div class="glass rounded-xl md:rounded-2xl p-3 md:p-4 border border-emerald-500/20 text-center">
                <div class="text-2xl md:text-3xl font-black text-white mb-1">{{ $members->count() }}</div>
                <div class="text-emerald-400 text-xs md:text-sm font-medium">Total Member</div>
            </div>
            <div class="glass rounded-xl md:rounded-2xl p-3 md:p-4 border border-blue-500/20 text-center">
                <div class="text-2xl md:text-3xl font-black text-white mb-1">
                    {{ $members->where('current_plan', '!=', null)->count() }}
                </div>
                <div class="text-blue-400 text-xs md:text-sm font-medium">Active Programs</div>
            </div>
            <div class="glass rounded-xl md:rounded-2xl p-3 md:p-4 border border-green-500/20 text-center">
                <div class="text-2xl md:text-3xl font-black text-white mb-1">
                    {{ $members->sum('total_completed_workouts') }}
                </div>
                <div class="text-green-400 text-xs md:text-sm font-medium">Workouts Completed</div>
            </div>
            <div class="glass rounded-xl md:rounded-2xl p-3 md:p-4 border border-purple-500/20 text-center">
                <div class="text-2xl md:text-3xl font-black text-white mb-1">
                    {{ $members->where('latest_workout', '!=', null)->count() }}
                </div>
                <div class="text-purple-400 text-xs md:text-sm font-medium">Recently Active</div>
            </div>
        </div>

        {{-- ✅ Toast Notification --}}
        @if(session('success'))
            <div class="glass rounded-xl md:rounded-2xl p-4 md:p-6 mb-6 md:mb-8 border border-emerald-500/30 bg-emerald-500/10">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-emerald-500/20 rounded-lg flex items-center justify-center">
                        <span class="text-emerald-400 text-lg">✅</span>
                    </div>
                    <p class="text-emerald-400 font-medium text-sm md:text-base">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        {{-- Members Grid --}}
        @if($members->count())
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-4 md:gap-6 mb-6 md:mb-8">
                @foreach($members as $member)
                    <div class="glass rounded-xl md:rounded-2xl p-4 md:p-6 border border-emerald-500/10 hover:border-emerald-500/30 transition-all duration-300 group hover-glow">
                        
                        {{-- Member Header --}}
                        <div class="flex items-center gap-3 md:gap-4 mb-3 md:mb-4">
                            @if($member->avatar)
                                <img src="{{ asset($member->avatar) }}" alt="{{ $member->name }}"
                                    class="w-12 h-12 md:w-16 md:h-16 rounded-xl md:rounded-2xl object-cover border-2 border-emerald-500/30 group-hover:border-emerald-500/50 transition-all duration-300 flex-shrink-0">
                            @else
                                <div class="w-12 h-12 md:w-16 md:h-16 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-xl md:rounded-2xl flex items-center justify-center text-white text-lg md:text-xl font-bold flex-shrink-0">
                                    {{ strtoupper(substr($member->name, 0, 1)) }}
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <h3 class="text-white font-bold text-base md:text-lg truncate">{{ $member->name }}</h3>
                                <p class="text-gray-400 text-xs md:text-sm truncate">{{ $member->email }}</p>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-emerald-400 text-xs">📧</span>
                                    <span class="text-gray-400 text-xs">{{ $member->age ?? 'N/A' }} years</span>
                                </div>
                            </div>
                        </div>

                        {{-- Current Program --}}
                        <div class="glass-dark rounded-lg md:rounded-xl p-3 md:p-4 border border-emerald-500/20 mb-3 md:mb-4">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-sm md:text-base font-bold text-white">Current Program</h4>
                                @if($member->current_plan)
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-500/20 text-green-400 border border-green-500/30">
                                        Active
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                        No Program
                                    </span>
                                @endif
                            </div>
                            
                            @if($member->current_plan)
                                <div class="space-y-2">
                                    <p class="text-emerald-400 font-semibold text-sm truncate">
                                        {{ $member->current_plan->title }}
                                    </p>
                                    <div class="flex items-center gap-3 text-xs text-gray-400">
                                        <span>{{ $member->current_plan->duration_weeks }} weeks</span>
                                        <span>•</span>
                                        <span class="capitalize">{{ $member->current_plan->difficulty_level }}</span>
                                    </div>
                                </div>
                            @else
                                <p class="text-gray-400 text-sm italic">Belum ada program latihan</p>
                            @endif
                        </div>

                        {{-- Progress Stats --}}
                        <div class="grid grid-cols-2 gap-3 md:gap-4 mb-3 md:mb-4">
                            <div class="text-center">
                                <div class="text-lg md:text-xl font-black text-white">{{ $member->total_completed_workouts }}</div>
                                <div class="text-emerald-400 text-xs">Workouts Done</div>
                            </div>
                            <div class="text-center">
                                <div class="text-lg md:text-xl font-black text-white">
                                    @if($member->latest_workout)
                                        {{ \Carbon\Carbon::parse($member->latest_workout->completed_at)->diffForHumans() }}
                                    @else
                                        Never
                                    @endif
                                </div>
                                <div class="text-blue-400 text-xs">Last Workout</div>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex flex-col gap-2">
                            <a href="{{ route('trainer.programs.edit', ['memberId' => $member->id]) }}" 
                               class="flex items-center justify-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white text-center py-2 px-3 md:px-4 rounded-lg md:rounded-xl font-semibold transition-all duration-300 hover-glow text-xs md:text-sm">
                                <span>✏️</span>
                                {{ $member->current_plan ? 'Edit Program' : 'Create Program' }}
                            </a>
                            
                            <div class="flex gap-2">
                                <a href="{{ route('trainer.programs.show', $member->id) }}" 
                                   class="flex-1 text-center bg-blue-500/10 hover:bg-blue-500/20 text-blue-400 hover:text-blue-300 py-2 px-3 rounded-lg font-semibold transition-all duration-300 border border-blue-500/20 hover:border-blue-500/30 text-xs">
                                    👁️ View
                                </a>
                                <a href="{{ route('trainer.programs.progress', $member->id) }}" 
                                   class="flex-1 text-center bg-purple-500/10 hover:bg-purple-500/20 text-purple-400 hover:text-purple-300 py-2 px-3 rounded-lg font-semibold transition-all duration-300 border border-purple-500/20 hover:border-purple-500/30 text-xs">
                                    📊 Progress
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="glass-dark rounded-2xl md:rounded-3xl p-6 md:p-12 text-center border border-emerald-500/20">
                <div class="w-16 h-16 md:w-24 md:h-24 bg-emerald-500/10 rounded-2xl md:rounded-3xl flex items-center justify-center mx-auto mb-4 md:mb-6 border border-emerald-500/20">
                    <span class="text-2xl md:text-4xl">👥</span>
                </div>
                <h3 class="text-xl md:text-2xl font-black text-white mb-2 md:mb-3">No Members Yet</h3>
                <p class="text-emerald-400/80 text-sm md:text-lg mb-4 md:mb-6 max-w-md mx-auto">
                    Anda belum memiliki member yang aktif. Member akan muncul di sini setelah mereka berlangganan program Anda.
                </p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('trainer.profile.edit') }}" 
                       class="inline-flex items-center justify-center gap-2 px-4 md:px-6 py-2 md:py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold rounded-lg md:rounded-xl transition-all duration-300 hover-glow text-sm md:text-base">
                        ✨ Improve Your Profile
                    </a>
                </div>
            </div>
        @endif

        {{-- Quick Actions --}}
        <div class="glass-dark rounded-xl md:rounded-2xl p-4 md:p-6 border border-emerald-500/20">
            <h3 class="text-lg md:text-xl font-black text-white mb-3 md:mb-4">Quick Actions</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4">
                <a href="{{ route('trainer.members.index') }}" 
                   class="glass rounded-xl md:rounded-2xl p-3 md:p-4 border border-emerald-500/20 hover:border-emerald-500/40 transition-all duration-300 hover-glow text-center group">
                    <div class="w-8 h-8 md:w-10 md:h-10 bg-emerald-500/20 rounded-lg md:rounded-xl flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform duration-300">
                        <span class="text-emerald-400 text-lg">👥</span>
                    </div>
                    <div class="text-white font-semibold text-sm md:text-base">All Members</div>
                    <div class="text-emerald-400 text-xs">Manage Members</div>
                </a>
                
                <a href="{{ route('trainer.communication.chat.index') }}" 
                   class="glass rounded-xl md:rounded-2xl p-3 md:p-4 border border-blue-500/20 hover:border-blue-500/40 transition-all duration-300 hover-glow text-center group">
                    <div class="w-8 h-8 md:w-10 md:h-10 bg-blue-500/20 rounded-lg md:rounded-xl flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform duration-300">
                        <span class="text-blue-400 text-lg">💬</span>
                    </div>
                    <div class="text-white font-semibold text-sm md:text-base">Messages</div>
                    <div class="text-blue-400 text-xs">Chat with Members</div>
                </a>
                
                <a href="{{ route('trainer.quality.feedback.index') }}" 
                   class="glass rounded-xl md:rounded-2xl p-3 md:p-4 border border-purple-500/20 hover:border-purple-500/40 transition-all duration-300 hover-glow text-center group">
                    <div class="w-8 h-8 md:w-10 md:h-10 bg-purple-500/20 rounded-lg md:rounded-xl flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform duration-300">
                        <span class="text-purple-400 text-lg">⭐</span>
                    </div>
                    <div class="text-white font-semibold text-sm md:text-base">Feedback</div>
                    <div class="text-purple-400 text-xs">View Ratings</div>
                </a>
                
                <a href="{{ route('trainer.programs.daftar') }}" 
                   class="glass rounded-xl md:rounded-2xl p-3 md:p-4 border border-amber-500/20 hover:border-amber-500/40 transition-all duration-300 hover-glow text-center group">
                    <div class="w-8 h-8 md:w-10 md:h-10 bg-amber-500/20 rounded-lg md:rounded-xl flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform duration-300">
                        <span class="text-amber-400 text-lg">📋</span>
                    </div>
                    <div class="text-white font-semibold text-sm md:text-base">Verification</div>
                    <div class="text-amber-400 text-xs">Status & Docs</div>
                </a>
            </div>
        </div>
    </div>
</div>

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
</style>
@endsection