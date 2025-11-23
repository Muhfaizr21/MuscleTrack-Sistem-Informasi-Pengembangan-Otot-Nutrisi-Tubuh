@extends('layouts.trainer')

@section('title', 'Progress Member - ' . $member->name)

@section('content')
<div class="min-h-screen py-4 md:py-8">
    <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8">

        {{-- Header Section --}}
        <div class="glass-dark rounded-2xl md:rounded-3xl p-4 md:p-8 border border-emerald-500/20 shadow-lg md:shadow-2xl shadow-emerald-500/10 mb-6 md:mb-8">
            <div class="flex flex-col lg:flex-row justify-between items-start gap-4 md:gap-6">
                <div class="flex items-center gap-3 md:gap-4">
                    <div class="w-10 h-10 md:w-14 md:h-14 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-xl md:rounded-2xl flex items-center justify-center animate-glow">
                        <span class="text-xl md:text-2xl">📊</span>
                    </div>
                    <div>
                        <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-white leading-tight">
                            Progress <span class="text-gradient">{{ $member->name }}</span>
                        </h1>
                        <p class="text-emerald-400/80 text-sm md:text-lg mt-1 md:mt-2">Pantau perkembangan dan konsistensi latihan member</p>
                    </div>
                </div>
                <div class="flex gap-3 w-full lg:w-auto mt-4 lg:mt-0">
                    <a href="{{ route('trainer.programs.show', $member->id) }}"
                       class="flex-1 lg:flex-none glass rounded-xl md:rounded-2xl px-4 md:px-6 py-2 md:py-3 border border-gray-500/20 hover:border-gray-500/40 text-white font-semibold transition-all duration-300 hover-glow text-center text-sm md:text-base">
                        <span class="flex items-center justify-center gap-2">
                            <span>⬅️</span> Kembali
                        </span>
                    </a>
                    <a href="{{ route('trainer.programs.edit', $member->id) }}"
                       class="flex-1 lg:flex-none glass rounded-xl md:rounded-2xl px-4 md:px-6 py-2 md:py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold transition-all duration-300 hover-glow text-center text-sm md:text-base">
                        <span class="flex items-center justify-center gap-2">
                            <span>✏️</span> Edit Program
                        </span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Stats Overview --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 mb-6 md:mb-8">
            {{-- Completion Rate --}}
            <div class="glass rounded-xl md:rounded-2xl p-4 md:p-6 border border-emerald-500/20 hover:border-emerald-500/40 transition-all duration-300 hover-glow">
                <div class="flex items-center justify-between mb-3">
                    <div class="text-emerald-400 text-sm font-semibold uppercase tracking-wider">Completion Rate</div>
                    <div class="w-8 h-8 bg-emerald-500/20 rounded-lg flex items-center justify-center">
                        <span class="text-emerald-400">✅</span>
                    </div>
                </div>
                <div class="text-2xl md:text-3xl font-black text-white mb-1">{{ $stats['completion_rate'] }}%</div>
                <div class="text-emerald-400/80 text-xs md:text-sm">
                    {{ $stats['completed_workouts'] }} dari {{ $stats['total_workouts'] }} workout
                </div>
            </div>

            {{-- Total Workouts --}}
            <div class="glass rounded-xl md:rounded-2xl p-4 md:p-6 border border-blue-500/20 hover:border-blue-500/40 transition-all duration-300 hover-glow">
                <div class="flex items-center justify-between mb-3">
                    <div class="text-blue-400 text-sm font-semibold uppercase tracking-wider">Total Workouts</div>
                    <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center">
                        <span class="text-blue-400">🏋️</span>
                    </div>
                </div>
                <div class="text-2xl md:text-3xl font-black text-white mb-1">{{ $stats['completed_workouts'] }}</div>
                <div class="text-blue-400/80 text-xs md:text-sm">Workout diselesaikan</div>
            </div>

            {{-- Weekly Frequency --}}
            <div class="glass rounded-xl md:rounded-2xl p-4 md:p-6 border border-purple-500/20 hover:border-purple-500/40 transition-all duration-300 hover-glow">
                <div class="flex items-center justify-between mb-3">
                    <div class="text-purple-400 text-sm font-semibold uppercase tracking-wider">Frekuensi/Minggu</div>
                    <div class="w-8 h-8 bg-purple-500/20 rounded-lg flex items-center justify-center">
                        <span class="text-purple-400">📅</span>
                    </div>
                </div>
                <div class="text-2xl md:text-3xl font-black text-white mb-1">{{ $stats['workouts_per_week'] }} sesi</div>
                <div class="text-purple-400/80 text-xs md:text-sm">30 hari terakhir</div>
            </div>

            {{-- Current Streak --}}
            <div class="glass rounded-xl md:rounded-2xl p-4 md:p-6 border border-amber-500/20 hover:border-amber-500/40 transition-all duration-300 hover-glow">
                <div class="flex items-center justify-between mb-3">
                    <div class="text-amber-400 text-sm font-semibold uppercase tracking-wider">Current Streak</div>
                    <div class="w-8 h-8 bg-amber-500/20 rounded-lg flex items-center justify-center">
                        <span class="text-amber-400">🔥</span>
                    </div>
                </div>
                <div class="text-2xl md:text-3xl font-black text-white mb-1">{{ $stats['current_streak'] }} hari</div>
                <div class="text-amber-400/80 text-xs md:text-sm">Konsistensi latihan</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-6">
            {{-- Workout History --}}
            <div class="lg:col-span-2">
                <div class="glass-dark rounded-xl md:rounded-2xl p-4 md:p-6 border border-emerald-500/20 mb-4 md:mb-6">
                    <div class="flex items-center justify-between mb-4 md:mb-6">
                        <h3 class="text-lg md:text-xl font-black text-white flex items-center gap-2">
                            <span class="text-emerald-400">📋</span> Riwayat Workout Terbaru
                        </h3>
                        <span class="glass rounded-full px-3 py-1 text-xs font-semibold text-emerald-400 border border-emerald-500/20">
                            Total: {{ $member->workoutSchedules->count() }}
                        </span>
                    </div>

                    @if($member->workoutSchedules->count() > 0)
                        <div class="space-y-3">
                            @foreach($member->workoutSchedules->take(8) as $schedule)
                                <div class="glass rounded-xl p-3 md:p-4 border border-gray-500/20 hover:border-emerald-500/30 transition-all duration-300 group">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-3 mb-2">
                                                <div class="text-white font-semibold text-sm md:text-base truncate">
                                                    {{ $schedule->workoutPlan->title ?? 'Program Lama' }}
                                                </div>
                                                @if($schedule->status == 'completed')
                                                    <span class="glass rounded-full px-2 py-1 text-xs font-semibold text-green-400 border border-green-500/30">
                                                        ✅ Selesai
                                                    </span>
                                                @elseif($schedule->status == 'in_progress')
                                                    <span class="glass rounded-full px-2 py-1 text-xs font-semibold text-amber-400 border border-amber-500/30">
                                                        ⏳ Berjalan
                                                    </span>
                                                @elseif($schedule->status == 'missed')
                                                    <span class="glass rounded-full px-2 py-1 text-xs font-semibold text-red-400 border border-red-500/30">
                                                        ❌ Terlewat
                                                    </span>
                                                @else
                                                    <span class="glass rounded-full px-2 py-1 text-xs font-semibold text-gray-400 border border-gray-500/30">
                                                        ⏰ Terjadwal
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="flex items-center gap-4 text-xs text-gray-400">
                                                <span class="flex items-center gap-1">
                                                    <span>📅</span>
                                                    {{ $schedule->scheduled_date->format('d M Y') }}
                                                </span>
                                                @if($schedule->scheduled_time)
                                                    <span class="flex items-center gap-1">
                                                        <span>🕒</span>
                                                        {{ \Carbon\Carbon::parse($schedule->scheduled_time)->format('H:i') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if($member->workoutSchedules->count() > 8)
                            <div class="text-center mt-4 md:mt-6">
                                <button class="glass rounded-xl px-4 md:px-6 py-2 md:py-3 border border-emerald-500/20 hover:border-emerald-500/40 text-emerald-400 font-semibold transition-all duration-300 hover-glow text-sm md:text-base">
                                    Lihat Semua Riwayat
                                </button>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-8 md:py-12">
                            <div class="w-16 h-16 md:w-20 md:h-20 bg-gray-500/10 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-gray-500/20">
                                <span class="text-2xl md:text-3xl text-gray-400">📝</span>
                            </div>
                            <h4 class="text-lg md:text-xl font-black text-white mb-2">Belum ada riwayat workout</h4>
                            <p class="text-gray-400 text-sm md:text-base">Member belum memulai program latihan.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-4 md:space-y-6">
                {{-- Body Metrics --}}
                <div class="glass-dark rounded-xl md:rounded-2xl p-4 md:p-6 border border-emerald-500/20">
                    <h3 class="text-lg md:text-xl font-black text-white mb-4 md:mb-6 flex items-center gap-2">
                        <span class="text-emerald-400">⚖️</span> Metrik Tubuh
                    </h3>

                    @if($member->bodyMetrics && $member->bodyMetrics->count() > 0)
                        @php $latestMetric = $member->bodyMetrics->first(); @endphp
                        <div class="grid grid-cols-2 gap-3 md:gap-4">
                            <div class="glass rounded-xl p-3 md:p-4 text-center border border-emerald-500/20">
                                <div class="text-emerald-400 text-xs font-semibold mb-2">Berat Badan</div>
                                <div class="text-xl md:text-2xl font-black text-white">{{ $latestMetric->weight ?? '0' }} kg</div>
                            </div>
                            <div class="glass rounded-xl p-3 md:p-4 text-center border border-blue-500/20">
                                <div class="text-blue-400 text-xs font-semibold mb-2">Tinggi Badan</div>
                                <div class="text-xl md:text-2xl font-black text-white">{{ $latestMetric->height ?? '0' }} cm</div>
                            </div>
                            <div class="glass rounded-xl p-3 md:p-4 text-center border border-purple-500/20">
                                <div class="text-purple-400 text-xs font-semibold mb-2">Body Fat</div>
                                <div class="text-xl md:text-2xl font-black text-white">{{ $latestMetric->body_fat ?? '0' }}%</div>
                            </div>
                            <div class="glass rounded-xl p-3 md:p-4 text-center border border-green-500/20">
                                <div class="text-green-400 text-xs font-semibold mb-2">Massa Otot</div>
                                <div class="text-xl md:text-2xl font-black text-white">{{ $latestMetric->muscle_mass ?? '0' }}%</div>
                            </div>
                        </div>
                        <div class="text-center mt-3 md:mt-4">
                            <div class="glass rounded-full px-3 py-1 inline-block border border-gray-500/20">
                                <small class="text-gray-400 text-xs">
                                    <span class="text-emerald-400">🕒</span>
                                    Update: {{ $latestMetric->created_at->format('d M Y') }}
                                </small>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-6 md:py-8">
                            <div class="w-12 h-12 md:w-16 md:h-16 bg-gray-500/10 rounded-2xl flex items-center justify-center mx-auto mb-3 border border-gray-500/20">
                                <span class="text-xl md:text-2xl text-gray-400">📏</span>
                            </div>
                            <p class="text-gray-400 text-sm md:text-base mb-2">Belum ada data metrik tubuh</p>
                            <small class="text-gray-500 text-xs">Arahkan member untuk mengisi data tubuh</small>
                        </div>
                    @endif
                </div>

                {{-- Quick Actions --}}
                <div class="glass-dark rounded-xl md:rounded-2xl p-4 md:p-6 border border-emerald-500/20">
                    <h3 class="text-lg md:text-xl font-black text-white mb-4 md:mb-6 flex items-center gap-2">
                        <span class="text-emerald-400">⚡</span> Quick Actions
                    </h3>
                    <div class="space-y-3">
                        <a href="{{ route('trainer.programs.edit', $member->id) }}"
                           class="glass rounded-xl p-3 md:p-4 border border-emerald-500/20 hover:border-emerald-500/40 transition-all duration-300 hover-glow block text-center group">
                            <div class="flex items-center justify-center gap-2 text-emerald-400 group-hover:text-emerald-300">
                                <span class="text-lg">✏️</span>
                                <span class="font-semibold text-sm md:text-base">Edit Program</span>
                            </div>
                        </a>
                        <a href="{{ route('trainer.programs.show', $member->id) }}"
                           class="glass rounded-xl p-3 md:p-4 border border-blue-500/20 hover:border-blue-500/40 transition-all duration-300 hover-glow block text-center group">
                            <div class="flex items-center justify-center gap-2 text-blue-400 group-hover:text-blue-300">
                                <span class="text-lg">👁️</span>
                                <span class="font-semibold text-sm md:text-base">Detail Program</span>
                            </div>
                        </a>
                        <button class="glass rounded-xl p-3 md:p-4 border border-green-500/20 hover:border-green-500/40 transition-all duration-300 hover-glow w-full text-center group"
                                onclick="showComingSoon()">
                            <div class="flex items-center justify-center gap-2 text-green-400 group-hover:text-green-300">
                                <span class="text-lg">📝</span>
                                <span class="font-semibold text-sm md:text-base">Tambah Catatan</span>
                            </div>
                        </button>
                    </div>
                </div>
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

<script>
function showComingSoon() {
    // Simple notification - bisa diganti dengan modal atau toast yang lebih fancy
    alert('Fitur catatan progress akan segera hadir dalam update berikutnya! 🚀');
}
</script>
@endsection
