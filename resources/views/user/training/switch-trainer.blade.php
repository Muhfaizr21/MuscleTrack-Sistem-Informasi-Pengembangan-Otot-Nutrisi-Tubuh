@extends('layouts.user')
@section('title', 'Ganti Trainer')

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="glass-dark rounded-3xl p-8 border border-emerald-500/20 shadow-2xl shadow-emerald-500/10 mb-8">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl flex items-center justify-center">
                    <span class="text-2xl">🔄</span>
                </div>
                <div>
                    <h1 class="text-3xl font-black text-white">Ganti Trainer</h1>
                    <p class="text-emerald-400/80">Pilih trainer baru untuk perjalanan fitness Anda</p>
                </div>
            </div>

            <!-- Current Trainer Info -->
            <div class="glass rounded-2xl p-6 border border-emerald-500/20 mb-6">
                <h2 class="text-xl font-black text-white mb-4 flex items-center gap-2">
                    <span class="text-gradient">Trainer Saat Ini</span>
                </h2>
                <div class="flex items-center gap-4">
                    @if($currentTrainer->avatar)
                        <img src="{{ asset('storage/' . $currentTrainer->avatar) }}" alt="{{ $currentTrainer->name }}"
                            class="w-16 h-16 rounded-2xl object-cover border-2 border-emerald-500/30">
                    @else
                        <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl flex items-center justify-center text-white text-xl font-bold">
                            {{ strtoupper(substr($currentTrainer->name, 0, 1)) }}
                        </div>
                    @endif
                    <div class="flex-1">
                        <h3 class="text-white font-bold text-lg">{{ $currentTrainer->name }}</h3>
                        <p class="text-emerald-400 text-sm">
                            {{ $currentTrainer->trainerProfile->specialization ?? 'Personal Trainer' }}
                        </p>
                        @if($currentTrainer->trainerProfile && $currentTrainer->trainerProfile->rating > 0)
                            <div class="flex items-center gap-1 mt-1">
                                <div class="flex">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="text-{{ $i <= $currentTrainer->trainerProfile->rating ? 'yellow' : 'gray' }}-400 text-sm">★</span>
                                    @endfor
                                </div>
                                <span class="text-gray-400 text-xs">({{ number_format($currentTrainer->trainerProfile->rating, 1) }})</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Warning Message -->
            <div class="bg-amber-500/20 border border-amber-500/30 rounded-2xl p-4">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-amber-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    <div>
                        <p class="text-amber-400 font-semibold">Perhatian</p>
                        <p class="text-amber-400/80 text-sm">Mengganti trainer memerlukan pembayaran baru. Akses ke trainer sebelumnya akan tetap aktif hingga masa berakhir.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Available Trainers -->
        <div class="glass-dark rounded-3xl border border-emerald-500/20 shadow-2xl shadow-emerald-500/10 p-8">
            <h2 class="text-2xl font-black text-white mb-6 flex items-center gap-2">
                <span class="text-gradient">Pilih Trainer Baru</span>
                <span class="bg-emerald-500/20 text-emerald-400 text-sm font-medium px-3 py-1 rounded-full border border-emerald-500/30">
                    {{ $trainers->count() }} trainer tersedia
                </span>
            </h2>

            @if($trainers->isEmpty())
                <div class="text-center py-12">
                    <div class="w-24 h-24 bg-emerald-500/10 rounded-3xl flex items-center justify-center mx-auto mb-6 border border-emerald-500/20">
                        <span class="text-4xl">🏋️</span>
                    </div>
                    <h3 class="text-xl font-black text-white mb-3">Tidak Ada Trainer Lain</h3>
                    <p class="text-emerald-400/80 mb-6">Saat ini tidak ada trainer lain yang tersedia.</p>
                    <a href="{{ route('user.training.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold rounded-xl transition-all duration-300 hover-glow">
                        Cari Trainer Lain
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($trainers as $trainer)
                        <div class="glass rounded-2xl p-6 border border-emerald-500/10 hover:border-emerald-500/30 transition-all duration-300 group hover-glow">
                            <!-- Trainer Header -->
                            <div class="flex items-center gap-4 mb-4">
                                @if($trainer->avatar)
                                    <img src="{{ asset('storage/' . $trainer->avatar) }}" alt="{{ $trainer->name }}"
                                        class="w-16 h-16 rounded-2xl object-cover border-2 border-emerald-500/30 group-hover:border-emerald-500/50 transition-all duration-300">
                                @else
                                    <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl flex items-center justify-center text-white text-xl font-bold">
                                        {{ strtoupper(substr($trainer->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-white font-bold text-lg truncate">{{ $trainer->name }}</h3>
                                    <p class="text-emerald-400 text-sm font-medium">
                                        {{ $trainer->trainerProfile->specialization ?? 'Professional Trainer' }}
                                    </p>
                                    <!-- Rating -->
                                    @if($trainer->trainerProfile && $trainer->trainerProfile->rating > 0)
                                        <div class="flex items-center gap-1 mt-1">
                                            <div class="flex">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <span class="text-{{ $i <= $trainer->trainerProfile->rating ? 'yellow' : 'gray' }}-400 text-sm">★</span>
                                                @endfor
                                            </div>
                                            <span class="text-gray-400 text-xs">({{ number_format($trainer->trainerProfile->rating, 1) }})</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Experience & Specialization -->
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center gap-2 text-sm text-gray-300">
                                    <span>🕐</span>
                                    <span>{{ $trainer->trainerProfile->experience_years ?? 0 }}+ years experience</span>
                                </div>
                                @if($trainer->trainerProfile && $trainer->trainerProfile->certifications)
                                <div class="flex items-center gap-2 text-sm text-gray-300">
                                    <span>📜</span>
                                    <span class="truncate">{{ $trainer->trainerProfile->certifications }}</span>
                                </div>
                                @endif
                            </div>

                            <!-- Bio -->
                            <p class="text-emerald-400/80 text-sm mb-6 line-clamp-2 leading-relaxed">
                                {{ $trainer->trainerProfile->bio ?? 'Certified professional trainer ready to help you achieve your fitness goals.' }}
                            </p>

                            <!-- Action Button -->
                            <form action="{{ route('user.training.switch-trainer.process', $trainer->id) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="w-full bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-semibold py-3 px-4 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-emerald-500/25 border border-emerald-400/30">
                                    Pilih Trainer Ini - Rp150.000
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>

                <!-- Back Button -->
                <div class="mt-8 text-center">
                    <a href="{{ route('user.training.my-trainer') }}" 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white font-semibold rounded-xl border border-gray-600 transition-all duration-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Profil Trainer
                    </a>
                </div>
            @endif
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

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection