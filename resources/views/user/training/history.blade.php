@extends('layouts.user')
@section('title', 'Trainer History')

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="glass-dark rounded-3xl p-8 border border-emerald-500/20 shadow-2xl shadow-emerald-500/10 mb-8">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-6">
                <div>
                    <h1 class="text-3xl font-black text-white mb-2">Riwayat Trainer</h1>
                    <p class="text-emerald-400/80 text-lg">Semua trainer yang pernah melatih Anda</p>
                </div>
                <div class="flex gap-4">
                    <a href="{{ route('user.training.my-trainer') }}" 
                       class="bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-3 px-6 rounded-2xl transition-all duration-300 hover-glow">
                        Trainer Aktif
                    </a>
                    <a href="{{ route('user.training.my-ratings') }}" 
                       class="bg-gray-700 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded-2xl border border-gray-600 transition-all duration-300">
                        Rating Saya
                    </a>
                </div>
            </div>
        </div>

        <!-- History List -->
        <div class="space-y-6">
            @if($premiumAccessLogs->count() > 0)
                @foreach($premiumAccessLogs as $access)
                    <div class="glass-dark rounded-3xl border border-emerald-500/20 shadow-2xl shadow-emerald-500/10 p-6">
                        <div class="flex flex-col lg:flex-row lg:items-start gap-6">
                            <!-- Trainer Info -->
                            <div class="flex items-start gap-4 flex-1">
                                @if($access->trainer->avatar)
                                    <img src="{{ asset('storage/' . $access->trainer->avatar) }}" 
                                         alt="{{ $access->trainer->name }}"
                                         class="w-16 h-16 rounded-2xl object-cover border-2 border-emerald-400/20">
                                @else
                                    <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl flex items-center justify-center text-xl font-bold text-white border-2 border-emerald-400/20">
                                        {{ strtoupper(substr($access->trainer->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 mb-3">
                                        <h3 class="text-xl font-bold text-white">{{ $access->trainer->name }}</h3>
                                        <span class="bg-blue-500/20 text-blue-400 px-3 py-1 rounded-full text-sm font-medium border border-blue-500/30">
                                            {{ $access->trainer->trainerProfile->specialization ?? 'Personal Trainer' }}
                                        </span>
                                        @if($access->trainer->id === Auth::user()->trainer_id)
                                            <span class="bg-emerald-500/20 text-emerald-400 px-3 py-1 rounded-full text-sm font-medium border border-emerald-500/30">
                                                Trainer Aktif
                                            </span>
                                        @else
                                            <span class="bg-gray-500/20 text-gray-400 px-3 py-1 rounded-full text-sm font-medium border border-gray-500/30">
                                                Masa Aktif Berakhir
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <!-- Access Period -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div class="space-y-2">
                                            <p class="text-emerald-400/80 text-sm font-semibold">Periode Akses:</p>
                                            <div class="flex items-center gap-2 text-white">
                                                <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                                </svg>
                                                {{ \Carbon\Carbon::parse($access->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($access->end_date)->format('d M Y') }}
                                            </div>
                                        </div>
                                        <div class="space-y-2">
                                            <p class="text-emerald-400/80 text-sm font-semibold">Durasi:</p>
                                            <div class="flex items-center gap-2 text-white">
                                                <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                </svg>
                                                {{ \Carbon\Carbon::parse($access->start_date)->diffInDays($access->end_date) }} hari
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Trainer Details -->
                                    @if($access->trainer->trainerProfile)
                                        <div class="bg-gray-800/50 border border-gray-700/50 rounded-2xl p-4">
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                                <div>
                                                    <p class="text-emerald-400/80 font-semibold">Pengalaman</p>
                                                    <p class="text-white">{{ $access->trainer->trainerProfile->experience_years ?? '0' }} tahun</p>
                                                </div>
                                                <div>
                                                    <p class="text-emerald-400/80 font-semibold">Rating</p>
                                                    <p class="text-white">
                                                        @php
                                                            $avgRating = \App\Models\Feedback::where('trainer_id', $access->trainer->id)->avg('rating');
                                                        @endphp
                                                        {{ number_format($avgRating, 1) }}/5
                                                    </p>
                                                </div>
                                                <div>
                                                    <p class="text-emerald-400/80 font-semibold">Status</p>
                                                    <p class="text-white">{{ $access->trainer->verification_status === 'approved' ? 'Terverifikasi' : 'Pending' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex flex-col gap-3 lg:items-end">
                                @php
                                    $hasRated = \App\Models\Feedback::where('user_id', Auth::id())
                                        ->where('trainer_id', $access->trainer->id)
                                        ->exists();
                                @endphp
                                
                                @if(!$hasRated && $access->trainer->id !== Auth::user()->trainer_id)
                                    <a href="{{ route('user.training.rate', $access->trainer->id) }}" 
                                       class="bg-amber-500 hover:bg-amber-600 text-white font-semibold py-2 px-4 rounded-xl transition-all duration-300 text-sm text-center">
                                        Beri Rating
                                    </a>
                                @elseif($hasRated)
                                    <span class="bg-green-500/20 text-green-400 px-3 py-2 rounded-xl text-sm font-medium border border-green-500/30 text-center">
                                        ✅ Sudah Dinilai
                                    </span>
                                @endif

                                @if($access->trainer->id !== Auth::user()->trainer_id)
                                    <a href="{{ route('user.training.order', $access->trainer->id) }}" 
                                       class="bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-2 px-4 rounded-xl transition-all duration-300 text-sm text-center">
                                        Latih Lagi
                                    </a>
                                @endif

                                <div class="text-xs text-emerald-400/70 text-center lg:text-right">
                                    Bergabung {{ $access->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $premiumAccessLogs->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="glass-dark rounded-3xl border border-emerald-500/20 shadow-2xl shadow-emerald-500/10 p-12 text-center">
                    <div class="max-w-md mx-auto">
                        <div class="w-24 h-24 bg-emerald-500/20 rounded-3xl flex items-center justify-center mx-auto mb-6 border border-emerald-500/30">
                            <svg class="w-12 h-12 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-black text-white mb-3">Belum Ada Riwayat Trainer</h3>
                        <p class="text-emerald-400/80 mb-6 leading-relaxed">
                            Anda belum pernah memiliki trainer sebelumnya. 
                            Temukan trainer profesional untuk memulai perjalanan fitness Anda.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('user.training.index') }}" 
                               class="bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-3 px-6 rounded-2xl transition-all duration-300 hover-glow">
                                Cari Trainer
                            </a>
                            <a href="{{ route('user.training.my-trainer') }}" 
                               class="bg-gray-700 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded-2xl border border-gray-600 transition-all duration-300">
                                Lihat Trainer Aktif
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Statistics -->
        @if($premiumAccessLogs->count() > 0)
            <div class="mt-12 glass-dark rounded-3xl border border-emerald-500/20 shadow-2xl shadow-emerald-500/10 p-6">
                <h3 class="text-xl font-black text-white mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                    </svg>
                    Statistik Riwayat
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="text-center">
                        <p class="text-3xl font-black text-emerald-400 mb-1">{{ $premiumAccessLogs->count() }}</p>
                        <p class="text-emerald-400/80 text-sm">Total Trainer</p>
                    </div>
                    <div class="text-center">
                        <p class="text-3xl font-black text-blue-400 mb-1">
                            {{ \App\Models\Feedback::where('user_id', Auth::id())->count() }}
                        </p>
                        <p class="text-blue-400/80 text-sm">Rating Diberikan</p>
                    </div>
                    <div class="text-center">
                        <p class="text-3xl font-black text-purple-400 mb-1">
                            @php
                                $totalDays = $premiumAccessLogs->sum(function($access) {
                                    return \Carbon\Carbon::parse($access->start_date)->diffInDays($access->end_date);
                                });
                            @endphp
                            {{ $totalDays }}
                        </p>
                        <p class="text-purple-400/80 text-sm">Total Hari</p>
                    </div>
                    <div class="text-center">
                        <p class="text-3xl font-black text-amber-400 mb-1">
                            {{ $premiumAccessLogs->where('trainer_id', Auth::user()->trainer_id)->count() > 0 ? '1' : '0' }}
                        </p>
                        <p class="text-amber-400/80 text-sm">Trainer Aktif</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
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

    /* Custom Pagination Styles */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
    }

    .pagination .page-item .page-link {
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.2);
        color: #10b981;
        padding: 0.5rem 1rem;
        border-radius: 0.75rem;
        transition: all 0.3s ease;
    }

    .pagination .page-item.active .page-link {
        background: #10b981;
        border-color: #10b981;
        color: white;
    }

    .pagination .page-item .page-link:hover {
        background: rgba(16, 185, 129, 0.2);
        transform: translateY(-1px);
    }
</style>
@endsection