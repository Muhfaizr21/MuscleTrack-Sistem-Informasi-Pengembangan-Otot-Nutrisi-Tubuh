@extends('layouts.trainer')

@section('title', 'Dashboard Nutrisi')

@section('content')
<div class="min-h-screen py-6 md:py-8">
    <div class="max-w-7xl mx-auto px-4 md:px-8">

        {{-- Header Section --}}
        <div class="glass-card rounded-2xl p-6 md:p-8 mb-6 md:mb-8">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 md:gap-6">
                <div class="flex items-center gap-3 md:gap-4">
                    <div class="w-12 h-12 md:w-14 md:h-14 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl md:rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-500/20">
                        <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white leading-tight">
                            Dashboard <span class="text-gradient">Nutrisi</span>
                        </h1>
                        <p class="text-emerald-400/80 text-sm md:text-base mt-1 md:mt-2">Kelola dan pantau rencana nutrisi semua member Anda</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 bg-emerald-500/10 border border-emerald-500/20 rounded-xl px-4 py-3">
                    <div class="w-8 h-8 bg-emerald-500/20 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-emerald-400 font-semibold text-sm">{{ $members->count() }}</div>
                        <div class="text-emerald-400/70 text-xs">Active Members</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats Overview --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6 md:mb-8">
            <div class="glass-card rounded-xl p-4 md:p-6 text-center glow-button">
                <div class="w-12 h-12 bg-emerald-500/10 rounded-xl flex items-center justify-center mx-auto mb-3 border border-emerald-500/20">
                    <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <div class="text-2xl md:text-3xl font-bold text-white mb-1">{{ $members->count() }}</div>
                <div class="text-emerald-400 text-sm font-medium">Total Member</div>
            </div>

            <div class="glass-card rounded-xl p-4 md:p-6 text-center glow-button">
                <div class="w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center mx-auto mb-3 border border-blue-500/20">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="text-2xl md:text-3xl font-bold text-white mb-1">
                    {{ $totalPlans }}
                </div>
                <div class="text-blue-400 text-sm font-medium">Rencana Nutrisi</div>
            </div>

            <div class="glass-card rounded-xl p-4 md:p-6 text-center glow-button">
                <div class="w-12 h-12 bg-green-500/10 rounded-xl flex items-center justify-center mx-auto mb-3 border border-green-500/20">
                    <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="text-2xl md:text-3xl font-bold text-white mb-1">
                    {{ $totalSupplements }}
                </div>
                <div class="text-green-400 text-sm font-medium">Suplemen</div>
            </div>

            <div class="glass-card rounded-xl p-4 md:p-6 text-center glow-button">
                <div class="w-12 h-12 bg-purple-500/10 rounded-xl flex items-center justify-center mx-auto mb-3 border border-purple-500/20">
                    <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <div class="text-2xl md:text-3xl font-bold text-white mb-1">
                    {{ number_format($totalCaloriesAll) }}
                </div>
                <div class="text-purple-400 text-sm font-medium">Total Kalori</div>
            </div>
        </div>

        {{-- Success Notification --}}
        @if(session('success'))
            <div class="glass-card rounded-xl p-4 md:p-6 mb-6 md:mb-8 border border-emerald-500/30 bg-emerald-500/10">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-emerald-500/20 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <p class="text-emerald-400 font-medium text-sm md:text-base">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        {{-- Members Grid --}}
        @if($members->count())
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-4 md:gap-6 mb-6 md:mb-8">
                @foreach($members as $member)
                    <div class="glass-card rounded-xl p-4 md:p-6 border border-emerald-500/10 hover:border-emerald-500/30 transition-all duration-300 group hover:transform hover:-translate-y-1">

                        {{-- Member Header --}}
                        <div class="flex items-center gap-3 md:gap-4 mb-4">
                            @if($member->avatar)
                                <img src="{{ asset($member->avatar) }}" alt="{{ $member->name }}"
                                    class="w-12 h-12 md:w-14 md:h-14 rounded-xl object-cover border-2 border-emerald-500/30 group-hover:border-emerald-500/50 transition-all duration-300 flex-shrink-0">
                            @else
                                <div class="w-12 h-12 md:w-14 md:h-14 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center text-white font-bold text-lg flex-shrink-0 border border-emerald-500/30">
                                    {{ strtoupper(substr($member->name, 0, 1)) }}
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <h3 class="text-white font-semibold text-base md:text-lg truncate">{{ $member->name }}</h3>
                                <p class="text-gray-400 text-xs md:text-sm truncate mt-1">{{ $member->email }}</p>
                                <div class="flex items-center gap-2 mt-2">
                                    <span class="text-emerald-400 text-xs">🍽️</span>
                                    <span class="text-gray-400 text-xs">{{ $member->nutritionPlans->count() }} plans</span>
                                </div>
                            </div>
                        </div>

                        {{-- Nutrition Summary --}}
                        <div class="bg-black/30 rounded-lg p-3 md:p-4 border border-emerald-500/10 mb-4">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-sm md:text-base font-semibold text-white">Rencana Nutrisi</h4>
                                @if($member->nutritionPlans->count() > 0)
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-500/20 text-green-400 border border-green-500/30">
                                        {{ $member->nutritionPlans->count() }} Plans
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                        Belum Ada
                                    </span>
                                @endif
                            </div>

                            @if($member->nutritionPlans->count() > 0)
                                @php
                                    $totalCalories = $member->nutritionPlans->sum('calories');
                                    $totalProtein = $member->nutritionPlans->sum('protein');
                                    $supplementCount = $member->nutritionPlans->sum(function($plan) {
                                        return $plan->supplements->count();
                                    });
                                @endphp
                                <div class="space-y-2">
                                    <div class="flex justify-between text-xs">
                                        <span class="text-gray-400">Kalori/hari:</span>
                                        <span class="text-emerald-400 font-semibold">{{ number_format($totalCalories) }} cal</span>
                                    </div>
                                    <div class="flex justify-between text-xs">
                                        <span class="text-gray-400">Protein:</span>
                                        <span class="text-blue-400 font-semibold">{{ $totalProtein }}g</span>
                                    </div>
                                    <div class="flex justify-between text-xs">
                                        <span class="text-gray-400">Suplemen:</span>
                                        <span class="text-purple-400 font-semibold">{{ $supplementCount }}</span>
                                    </div>
                                </div>
                            @else
                                <p class="text-gray-400 text-sm italic">Belum ada rencana nutrisi</p>
                            @endif
                        </div>

                        {{-- Nutrition Stats --}}
                        <div class="grid grid-cols-2 gap-3 md:gap-4 mb-4">
                            <div class="text-center">
                                <div class="text-lg md:text-xl font-bold text-white">{{ $member->nutritionPlans->count() }}</div>
                                <div class="text-emerald-400 text-xs">Meal Plans</div>
                            </div>
                            <div class="text-center">
                                <div class="text-lg md:text-xl font-bold text-white">
                                    @php
                                        $supplementCount = $member->nutritionPlans->sum(function($plan) {
                                            return $plan->supplements->count();
                                        });
                                    @endphp
                                    {{ $supplementCount }}
                                </div>
                                <div class="text-blue-400 text-xs">Suplemen</div>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex flex-col gap-2">
                            <a href="{{ route('trainer.nutrition.create', $member->id) }}"
                               class="flex items-center justify-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white text-center py-2 px-4 rounded-lg font-semibold transition-all duration-300 glow-button text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                {{ $member->nutritionPlans->count() ? 'Tambah Plan' : 'Buat Plan' }}
                            </a>

                            <div class="flex gap-2">
                                <a href="{{ route('trainer.nutrition.index', $member->id) }}"
                                   class="flex-1 flex items-center justify-center gap-1 bg-blue-500/10 hover:bg-blue-500/20 text-blue-400 hover:text-blue-300 py-2 px-3 rounded-lg font-medium transition-all duration-300 border border-blue-500/20 hover:border-blue-500/30 text-xs">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Lihat
                                </a>
                                <a href="{{ route('trainer.nutrition.analysis', $member->id) }}"
                                   class="flex-1 flex items-center justify-center gap-1 bg-purple-500/10 hover:bg-purple-500/20 text-purple-400 hover:text-purple-300 py-2 px-3 rounded-lg font-medium transition-all duration-300 border border-purple-500/20 hover:border-purple-500/30 text-xs">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    Analisis
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Empty State --}}
            <div class="glass-card rounded-2xl p-8 md:p-12 text-center border border-emerald-500/20">
                <div class="w-16 h-16 md:w-20 md:h-20 bg-emerald-500/10 rounded-2xl flex items-center justify-center mx-auto mb-4 md:mb-6 border border-emerald-500/20">
                    <svg class="w-8 h-8 md:w-10 md:h-10 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl md:text-2xl font-bold text-white mb-2 md:mb-3">Belum Ada Member</h3>
                <p class="text-emerald-400/80 text-sm md:text-base mb-6 max-w-md mx-auto leading-relaxed">
                    Anda belum memiliki member yang aktif. Member akan muncul di sini setelah mereka berlangganan program Anda.
                </p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('trainer.profile.edit') }}"
                       class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold rounded-lg transition-all duration-300 glow-button text-sm md:text-base">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Improve Your Profile
                    </a>
                </div>
            </div>
        @endif

        {{-- Quick Actions --}}
        <div class="glass-card rounded-xl p-6 border border-emerald-500/20">
            <h3 class="text-lg md:text-xl font-bold text-white mb-4">Aksi Cepat</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('trainer.members.index') }}"
                   class="glass-card rounded-xl p-4 border border-emerald-500/20 hover:border-emerald-500/40 transition-all duration-300 glow-button text-center group">
                    <div class="w-10 h-10 bg-emerald-500/10 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform duration-300 border border-emerald-500/20">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <div class="text-white font-semibold text-sm md:text-base mb-1">Semua Member</div>
                    <div class="text-emerald-400 text-xs">Kelola Member</div>
                </a>

                <a href="{{ route('trainer.communication.chat.index') }}"
                   class="glass-card rounded-xl p-4 border border-blue-500/20 hover:border-blue-500/40 transition-all duration-300 glow-button text-center group">
                    <div class="w-10 h-10 bg-blue-500/10 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform duration-300 border border-blue-500/20">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <div class="text-white font-semibold text-sm md:text-base mb-1">Pesan</div>
                    <div class="text-blue-400 text-xs">Chat dengan Member</div>
                </a>

                <a href="{{ route('trainer.quality.feedback.index') }}"
                   class="glass-card rounded-xl p-4 border border-purple-500/20 hover:border-purple-500/40 transition-all duration-300 glow-button text-center group">
                    <div class="w-10 h-10 bg-purple-500/10 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform duration-300 border border-purple-500/20">
                        <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                        </svg>
                    </div>
                    <div class="text-white font-semibold text-sm md:text-base mb-1">Feedback</div>
                    <div class="text-purple-400 text-xs">Lihat Rating</div>
                </a>

                <a href="{{ route('trainer.quality.verification.status') }}"
                   class="glass-card rounded-xl p-4 border border-amber-500/20 hover:border-amber-500/40 transition-all duration-300 glow-button text-center group">
                    <div class="w-10 h-10 bg-amber-500/10 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform duration-300 border border-amber-500/20">
                        <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <div class="text-white font-semibold text-sm md:text-base mb-1">Verifikasi</div>
                    <div class="text-amber-400 text-xs">Status & Dokumen</div>
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

    .glass-card {
        background: rgba(17, 25, 21, 0.7);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(16, 185, 129, 0.2);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
    }

    .glow-button {
        position: relative;
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .glow-button::after {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: inherit;
        opacity: 0;
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.3), rgba(52, 211, 153, 0.3));
        transition: opacity 0.3s ease;
        z-index: -1;
    }

    .glow-button:hover::after {
        opacity: 1;
    }

    .glow-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.15);
    }
</style>
@endsection
