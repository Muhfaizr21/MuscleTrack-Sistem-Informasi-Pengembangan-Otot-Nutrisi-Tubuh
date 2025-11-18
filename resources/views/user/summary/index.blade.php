@extends('layouts.user')

@section('content')
    <div
        class="bg-gray-900/80 backdrop-blur-lg border border-gray-700/50 shadow-sm sm:rounded-lg p-6 transition-all duration-300">

        {{-- ✅ Flash Message (Style "Green Theme") --}}
        @if(session('success'))
            <div class="bg-green-500/20 border border-green-500/50 text-green-300 px-4 py-3 rounded-lg mb-4">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-500/20 border border-red-500/50 text-red-300 px-4 py-3 rounded-lg mb-4">
                ❌ {{ session('error') }}
            </div>
        @endif

        {{-- 🗓️ Header (Style "Green Theme") --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <h2 class="font-serif text-2xl font-bold text-white flex items-center gap-2">
                📊 Weekly <span class="text-green-400">Summary</span>
            </h2>
            <span class="text-gray-400 text-sm">
                Periode: <strong class="text-gray-200">{{ $weeklySummary['range'] ?? '-' }}</strong>
            </span>
        </div>

        {{-- 🔥 Motivational Card (Style "Green Theme") --}}
        <div class="bg-green-900/30 border-l-4 border-green-400 p-4 mb-6 rounded-lg">
            <div class="flex items-center gap-3 text-green-200">
                💬 <strong class="text-green-300">Motivation:</strong>
                <span>{{ $motivationalMessage ?? 'Ayo mulai minggu ini dengan semangat baru!' }}</span>
            </div>
        </div>

        {{-- 🧾 Summary Cards (Style "Green Theme") --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
            <div
                class="relative bg-gray-800/50 border border-gray-700/50 rounded-lg p-4 text-center overflow-hidden hover:border-green-400/50 transition-all duration-300">
                <div class="absolute -left-2 -bottom-2 font-serif text-6xl font-bold text-gray-700/50 z-0 opacity-30">🏋️
                </div>
                <div class="relative z-10">
                    <p class="text-gray-400 text-sm">Workout</p>
                    <p class="text-3xl font-bold text-green-400">
                        {{ $weeklySummary['completed_workouts'] ?? 0 }}/{{ $weeklySummary['total_workouts'] ?? 0 }}</p>
                    <p class="text-xs text-gray-500 mt-1">Selesai/Total</p>
                </div>
            </div>
            <div
                class="relative bg-gray-800/50 border border-gray-700/50 rounded-lg p-4 text-center overflow-hidden hover:border-green-400/50 transition-all duration-300">
                <div class="absolute -left-2 -bottom-2 font-serif text-6xl font-bold text-gray-700/50 z-0 opacity-30">🔥
                </div>
                <div class="relative z-10">
                    <p class="text-gray-400 text-sm">Kalori</p>
                    <p class="text-3xl font-bold text-green-400">{{ $weeklySummary['total_calories'] ?? 0 }} kcal</p>
                    <p class="text-xs text-gray-500 mt-1">Total Konsumsi</p>
                </div>
            </div>
            <div
                class="relative bg-gray-800/50 border border-gray-700/50 rounded-lg p-4 text-center overflow-hidden hover:border-green-400/50 transition-all duration-300">
                <div class="absolute -left-2 -bottom-2 font-serif text-6xl font-bold text-gray-700/50 z-0 opacity-30">💪
                </div>
                <div class="relative z-10">
                    <p class="text-gray-400 text-sm">Protein</p>
                    <p class="text-3xl font-bold text-green-400">{{ $weeklySummary['total_protein'] ?? 0 }} g</p>
                    <p class="text-xs text-gray-500 mt-1">Asupan Harian</p>
                </div>
            </div>
            <div
                class="relative bg-gray-800/50 border border-gray-700/50 rounded-lg p-4 text-center overflow-hidden hover:border-green-400/50 transition-all duration-300">
                <div class="absolute -left-2 -bottom-2 font-serif text-6xl font-bold text-gray-700/50 z-0 opacity-30">📈
                </div>
                <div class="relative z-10">
                    <p class="text-gray-400 text-sm">Progress</p>
                    <p class="text-3xl font-bold text-green-400">{{ $weeklySummary['latest_weight'] ?? '-' }} kg</p>
                    <p class="text-xs text-gray-500 mt-1">Berat Terakhir</p>
                </div>
            </div>
        </div>

        {{-- 📈 Body Progress (Style "Green Theme") --}}
        <div
            class="bg-gray-800/50 rounded-2xl border border-gray-700/50 p-6 mb-8 hover:border-green-400/30 transition-all duration-300">
            <h3 class="font-serif text-lg font-bold text-white mb-4 flex items-center gap-2">
                🧍 Progress <span class="text-green-400">Tubuh Minggu Ini</span>
            </h3>
            @if(!empty($weeklySummary['latest_weight']) && $weeklySummary['latest_weight'] !== '-')
                <div class="grid grid-cols-1 sm:grid-cols-3 text-center gap-4">
                    <div class="p-4 bg-gray-700/40 rounded-lg hover:bg-gray-700/60 transition-colors">
                        <p class="text-gray-400 text-sm">Berat Badan</p>
                        <p class="text-xl font-semibold text-green-400">{{ $weeklySummary['latest_weight'] }} kg</p>
                        <p class="text-xs text-gray-500 mt-1">Latest Record</p>
                    </div>
                    <div class="p-4 bg-gray-700/40 rounded-lg hover:bg-gray-700/60 transition-colors">
                        <p class="text-gray-400 text-sm">Massa Otot</p>
                        <p class="text-xl font-semibold text-green-400">{{ $weeklySummary['latest_muscle'] ?? '-' }} kg</p>
                        <p class="text-xs text-gray-500 mt-1">Muscle Mass</p>
                    </div>
                    <div class="p-4 bg-gray-700/40 rounded-lg hover:bg-gray-700/60 transition-colors">
                        <p class="text-gray-400 text-sm">Lemak Tubuh</p>
                        <p class="text-xl font-semibold text-green-400">{{ $weeklySummary['latest_body_fat'] ?? '-' }} %</p>
                        <p class="text-xs text-gray-500 mt-1">Body Fat</p>
                    </div>
                </div>
            @else
                <div class="text-center py-8">
                    <div class="text-4xl mb-2">📊</div>
                    <p class="text-gray-400 italic">Belum ada data progres minggu ini.</p>
                    <p class="text-gray-500 text-sm mt-2">Mulai tracking progress tubuhmu untuk melihat perkembangan!</p>
                </div>
            @endif
        </div>

        {{-- 🏋️ Workout Schedule List (Style "Green Theme") --}}
        <div
            class="bg-gray-800/50 rounded-2xl border border-gray-700/50 p-6 mb-8 hover:border-green-400/30 transition-all duration-300">
            <h3 class="font-serif text-lg font-bold text-white mb-4 flex items-center gap-2">
                🏋️ Jadwal Latihan <span class="text-green-400">Minggu Ini</span>
            </h3>

            {{-- Workout Statistics --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
                <div class="bg-gray-700/40 rounded-lg p-3 text-center">
                    <p class="text-gray-400 text-sm">Total</p>
                    <p class="text-2xl font-bold text-green-400">{{ $weeklySummary['total_workouts'] ?? 0 }}</p>
                </div>
                <div class="bg-gray-700/40 rounded-lg p-3 text-center">
                    <p class="text-gray-400 text-sm">Selesai</p>
                    <p class="text-2xl font-bold text-green-400">{{ $weeklySummary['completed_workouts'] ?? 0 }}</p>
                </div>
                <div class="bg-gray-700/40 rounded-lg p-3 text-center">
                    <p class="text-gray-400 text-sm">Progress</p>
                    <p class="text-2xl font-bold text-yellow-400">{{ $weeklySummary['in_progress_workouts'] ?? 0 }}</p>
                </div>
                <div class="bg-gray-700/40 rounded-lg p-3 text-center">
                    <p class="text-gray-400 text-sm">Completion</p>
                    <p class="text-2xl font-bold text-blue-400">{{ $weeklySummary['workout_completion_rate'] ?? 0 }}%</p>
                </div>
            </div>

            @if($workouts->isEmpty())
                <div class="text-center py-8">
                    <div class="text-4xl mb-2">💤</div>
                    <p class="text-gray-400 italic">Belum ada jadwal latihan minggu ini.</p>
                    <p class="text-gray-500 text-sm mt-2">
                        <a href="{{ route('user.workouts.index') }}" class="text-green-400 hover:text-green-300 underline">
                            Yuk buat jadwal workout
                        </a>
                        untuk memulai perjalanan fitness-mu!
                    </p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full border-separate border-spacing-0 text-sm">
                        <thead class="bg-gray-700/50 text-gray-300">
                            <tr>
                                <th class="p-3 text-left rounded-tl-lg">Tanggal & Waktu</th>
                                <th class="p-3 text-left">Workout Plan</th>
                                <th class="p-3 text-center">Status</th>
                                <th class="p-3 text-center rounded-tr-lg">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-300">
                            @foreach ($workouts as $w)
                                <tr class="hover:bg-gray-700/30 transition-colors">
                                    <td class="p-3 border-t border-gray-600/50">
                                        <div class="font-medium text-white">
                                            {{ \Carbon\Carbon::parse($w->scheduled_date)->format('d M Y') }}
                                        </div>
                                        <div class="text-sm text-gray-400">
                                            {{ $w->scheduled_time ? \Carbon\Carbon::parse($w->scheduled_time)->format('H:i') : '-' }}
                                        </div>
                                    </td>
                                    <td class="p-3 border-t border-gray-600/50">
                                        <div class="text-white font-medium">{{ $w->workout_name }}</div>
                                        @if($w->notes)
                                            <div class="text-xs text-gray-400 mt-1">
                                                📝 {{ Str::limit($w->notes, 50) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="p-3 text-center border-t border-gray-600/50">
                                        @if($w->status === 'completed')
                                            <span
                                                class="bg-green-500/20 text-green-300 px-3 py-1 rounded-full text-xs font-medium border border-green-500/30">
                                                ✅ Selesai
                                            </span>
                                            @if($w->completed_at)
                                                <div class="text-xs text-gray-400 mt-1">
                                                    {{ \Carbon\Carbon::parse($w->completed_at)->format('H:i') }}
                                                </div>
                                            @endif
                                        @elseif($w->status === 'missed')
                                            <span
                                                class="bg-red-500/20 text-red-300 px-3 py-1 rounded-full text-xs font-medium border border-red-500/30">
                                                ❌ Terlewat
                                            </span>
                                        @elseif($w->status === 'in_progress')
                                            <span
                                                class="bg-yellow-500/20 text-yellow-300 px-3 py-1 rounded-full text-xs font-medium border border-yellow-500/30">
                                                🔄 Progress
                                            </span>
                                        @else
                                                                @php
                                                                    $scheduledDateTime = \Carbon\Carbon::parse($w->scheduled_date . ' ' . $w->scheduled_time);
                                                                    $isOverdue = $scheduledDateTime->isPast();
                                                                @endphp
                                             <span
                                                                    class="bg-gray-500/20 text-gray-300 px-3 py-1 rounded-full text-xs font-medium border border-gray-500/30">
                                                                    {{ $isOverdue ? '⏰ Terlewat' : '⏳ Pending' }}
                                                                </span>
                                        @endif
                                    </td>
                                    <td class="p-3 text-center border-t border-gray-600/50">
                                        {{-- Arahkan ke edit workout schedule --}}
                                        <a href="{{ route('user.workouts.edit', $w->id) }}"
                                            class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs font-medium transition-colors">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Kelola
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Quick Actions --}}
                <div class="mt-6 flex flex-wrap gap-2 justify-center">
                    <a href="{{ route('user.workouts.index') }}"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                        📋 Lihat Semua Workout
                    </a>
                    <a href="{{ route('user.workouts.create') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                        ➕ Tambah Jadwal Baru
                    </a>
                </div>
            @endif
        </div>

        {{-- 📊 Charts Section (Style "Green Theme") --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            {{-- Kalori Chart --}}
            <div
                class="bg-gray-800/50 rounded-2xl border border-gray-700/50 p-6 hover:border-green-400/30 transition-all duration-300">
                <h3 class="font-serif text-lg font-bold text-white mb-4 flex items-center gap-2">
                    📈 Tren <span class="text-green-400">Kalori Mingguan</span>
                </h3>
                @if(array_sum($weeklySummary['chart_data'] ?? []) > 0)
                    <canvas id="weeklyCaloriesChart" height="200"></canvas>
                @else
                    <div class="text-center py-8">
                        <div class="text-4xl mb-2">📊</div>
                        <p class="text-gray-400 italic">Belum ada data kalori minggu ini.</p>
                        <p class="text-gray-500 text-sm mt-2">
                            <a href="{{ route('user.nutrition.index') }}" class="text-green-400 hover:text-green-300 underline">
                                Mulai tracking nutrisi
                            </a>
                            untuk melihat tren kalori harian!
                        </p>
                    </div>
                @endif
            </div>

            {{-- Weight Trend Chart --}}
            <div
                class="bg-gray-800/50 rounded-2xl border border-gray-700/50 p-6 hover:border-green-400/30 transition-all duration-300">
                <h3 class="font-serif text-lg font-bold text-white mb-4 flex items-center gap-2">
                    ⚖️ Tren <span class="text-green-400">Berat Badan</span>
                </h3>
                @if(!empty($weeklySummary['weight_data']) && count($weeklySummary['weight_data']) > 0)
                    <canvas id="weightTrendChart" height="200"></canvas>
                @else
                    <div class="text-center py-8">
                        <div class="text-4xl mb-2">⚖️</div>
                        <p class="text-gray-400 italic">Belum ada data berat badan minggu ini.</p>
                        <p class="text-gray-500 text-sm mt-2">
                            <a href="{{ route('user.progress.index') }}" class="text-green-400 hover:text-green-300 underline">
                                Catat perkembangan berat badanmu
                            </a>
                            untuk melihat tren!
                        </p>
                    </div>
                @endif
            </div>
        </div>

        {{-- 🔔 Weekly Summary Notification (Style "Green Theme") --}}
        <div class="bg-green-900/30 border-l-4 border-green-400 text-green-200 p-4 rounded-lg">
            <div class="flex items-center gap-2">
                📬 <strong class="text-green-300">Weekly Recap:</strong>
                <span>Evaluasi minggu ini dan tetap semangat untuk minggu berikutnya 🌱</span>
            </div>
            <div class="mt-2 text-sm text-green-300">
                @if($weeklySummary['workout_completion_rate'] >= 80)
                    🎉 Luar biasa! Konsistensi workout-mu mengagumkan!
                @elseif($weeklySummary['workout_completion_rate'] >= 50)
                    💪 Kerja bagus! Tingkatkan lagi minggu depan!
                @else
                    🌟 Setiap langkah kecil berarti. Mulai lagi minggu depan dengan semangat baru!
                @endif
            </div>
        </div>
    </div>

    {{-- ✅ Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Opsi Tema "Green Theme" untuk Chart
            Chart.defaults.color = 'rgba(229, 231, 235, 0.7)';
            Chart.defaults.borderColor = 'rgba(156, 163, 175, 0.1)';

            // Chart Kalori Mingguan
            const caloriesCtx = document.getElementById('weeklyCaloriesChart');
            if (caloriesCtx) {
                new Chart(caloriesCtx, {
                    type: 'line',
                    data: {
                        labels: @json($weeklySummary['chart_labels'] ?? []),
                        datasets: [{
                            label: 'Kalori (kcal)',
                            data: @json($weeklySummary['chart_data'] ?? []),
                            borderColor: '#10B981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#10B981',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: '#D1D5DB',
                                    font: { size: 12 }
                                }
                            },
                            tooltip: {
                                backgroundColor: '#1F2937',
                                titleColor: '#10B981',
                                bodyColor: '#E5E7EB',
                                borderColor: '#10B981',
                                borderWidth: 1,
                                padding: 12
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Kalori (kcal)',
                                    color: '#9CA3AF',
                                    font: { size: 12 }
                                },
                                ticks: { color: '#9CA3AF' },
                                grid: { color: 'rgba(156, 163, 175, 0.1)' }
                            },
                            x: {
                                ticks: { color: '#9CA3AF' },
                                grid: { color: 'rgba(156, 163, 175, 0.1)' }
                            }
                        },
                        animation: {
                            duration: 1000,
                            easing: 'easeOutQuart'
                        }
                    }
                });
            }

            // Chart Tren Berat Badan
            const weightCtx = document.getElementById('weightTrendChart');
            if (weightCtx && @json(!empty($weeklySummary['weight_data']) && count($weeklySummary['weight_data']) > 0)) {
                new Chart(weightCtx, {
                    type: 'line',
                    data: {
                        labels: @json($weeklySummary['weight_dates'] ?? []),
                        datasets: [{
                            label: 'Berat Badan (kg)',
                            data: @json($weeklySummary['weight_data'] ?? []),
                            borderColor: '#34D399',
                            backgroundColor: 'rgba(52, 211, 153, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#34D399',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: '#D1D5DB',
                                    font: { size: 12 }
                                }
                            },
                            tooltip: {
                                backgroundColor: '#1F2937',
                                titleColor: '#34D399',
                                bodyColor: '#E5E7EB',
                                borderColor: '#34D399',
                                borderWidth: 1,
                                padding: 12
                            }
                        },
                        scales: {
                            y: {
                                title: {
                                    display: true,
                                    text: 'Berat (kg)',
                                    color: '#9CA3AF',
                                    font: { size: 12 }
                                },
                                ticks: { color: '#9CA3AF' },
                                grid: { color: 'rgba(156, 163, 175, 0.1)' }
                            },
                            x: {
                                ticks: { color: '#9CA3AF' },
                                grid: { color: 'rgba(156, 163, 175, 0.1)' }
                            }
                        },
                        animation: {
                            duration: 1000,
                            easing: 'easeOutQuart'
                        }
                    }
                });
            }
        });
    </script>
@endsection