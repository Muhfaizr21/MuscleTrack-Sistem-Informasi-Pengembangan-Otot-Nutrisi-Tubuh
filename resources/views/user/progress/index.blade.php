@extends('layouts.user')

@section('content')
    <div class="min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header Section --}}
            <div class="glass-dark rounded-3xl p-8 border border-emerald-500/20 shadow-2xl shadow-emerald-500/10 mb-8">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl flex items-center justify-center animate-glow">
                            <span class="text-2xl">📊</span>
                        </div>
                        <div>
                            <h1 class="text-3xl sm:text-4xl font-black text-white">
                                My <span class="text-gradient">Progress</span>
                            </h1>
                            <p class="text-emerald-400/80 text-lg mt-2">Track your fitness journey with detailed analytics
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('user.progress.create') }}"
                        class="group relative px-8 py-4 rounded-2xl text-base font-black text-white bg-gradient-to-r from-emerald-500 to-emerald-700 hover:from-emerald-600 hover:to-emerald-800 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-emerald-500/25 flex items-center gap-3">
                        <span class="text-xl">+</span>
                        Add New Progress
                        <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Stats Overview --}}
            @if($progress->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    @php
                        $latest = $progress->first();
                        $previous = $progress->skip(1)->first();
                    @endphp

                    {{-- Weight Stat --}}
                    <div
                        class="glass rounded-2xl p-6 border border-emerald-500/10 hover:border-emerald-500/30 transition-all duration-300 group hover-glow">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-emerald-400">Current Weight</h3>
                            <div
                                class="w-10 h-10 bg-emerald-500/10 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <span class="text-emerald-400 text-lg">⚖️</span>
                            </div>
                        </div>
                        <div class="text-center">
                            <p class="text-4xl font-black text-white mb-2">{{ number_format($latest->weight, 1) }}<span
                                    class="text-2xl text-emerald-400">kg</span></p>
                            @if($previous)
                                @php
                                    $weightDiff = $latest->weight - $previous->weight;
                                    $weightIcon = $weightDiff > 0 ? '↗️' : ($weightDiff < 0 ? '↘️' : '➡️');
                                    $weightColor = $weightDiff > 0 ? 'text-red-400' : ($weightDiff < 0 ? 'text-emerald-400' : 'text-gray-400');
                                @endphp
                                <p class="text-sm {{ $weightColor }} flex items-center justify-center gap-1">
                                    <span>{{ $weightIcon }}</span>
                                    <span>{{ $weightDiff > 0 ? '+' : '' }}{{ number_format($weightDiff, 1) }}kg</span>
                                    <span class="text-gray-500">from last</span>
                                </p>
                            @endif
                        </div>
                    </div>

                    {{-- Muscle Mass Stat --}}
                    <div
                        class="glass rounded-2xl p-6 border border-emerald-500/10 hover:border-emerald-500/30 transition-all duration-300 group hover-glow">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-blue-400">Muscle Mass</h3>
                            <div
                                class="w-10 h-10 bg-blue-500/10 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <span class="text-blue-400 text-lg">💪</span>
                            </div>
                        </div>
                        <div class="text-center">
                            <p class="text-4xl font-black text-white mb-2">
                                {{ $latest->muscle_mass ? number_format($latest->muscle_mass, 1) : '--' }}<span
                                    class="text-2xl text-blue-400">kg</span>
                            </p>
                            @if($previous && $latest->muscle_mass && $previous->muscle_mass)
                                @php
                                    $muscleDiff = $latest->muscle_mass - $previous->muscle_mass;
                                    $muscleIcon = $muscleDiff > 0 ? '📈' : ($muscleDiff < 0 ? '📉' : '➡️');
                                    $muscleColor = $muscleDiff > 0 ? 'text-emerald-400' : ($muscleDiff < 0 ? 'text-red-400' : 'text-gray-400');
                                @endphp
                                <p class="text-sm {{ $muscleColor }} flex items-center justify-center gap-1">
                                    <span>{{ $muscleIcon }}</span>
                                    <span>{{ $muscleDiff > 0 ? '+' : '' }}{{ number_format($muscleDiff, 1) }}kg</span>
                                </p>
                            @endif
                        </div>
                    </div>

                    {{-- Body Fat Stat --}}
                    <div
                        class="glass rounded-2xl p-6 border border-emerald-500/10 hover:border-emerald-500/30 transition-all duration-300 group hover-glow">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-purple-400">Body Fat</h3>
                            <div
                                class="w-10 h-10 bg-purple-500/10 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <span class="text-purple-400 text-lg">🔥</span>
                            </div>
                        </div>
                        <div class="text-center">
                            <p class="text-4xl font-black text-white mb-2">
                                {{ $latest->body_fat ? number_format($latest->body_fat, 1) : '--' }}<span
                                    class="text-2xl text-purple-400">%</span>
                            </p>
                            @if($previous && $latest->body_fat && $previous->body_fat)
                                @php
                                    $fatDiff = $latest->body_fat - $previous->body_fat;
                                    $fatIcon = $fatDiff < 0 ? '📈' : ($fatDiff > 0 ? '📉' : '➡️');
                                    $fatColor = $fatDiff < 0 ? 'text-emerald-400' : ($fatDiff > 0 ? 'text-red-400' : 'text-gray-400');
                                @endphp
                                <p class="text-sm {{ $fatColor }} flex items-center justify-center gap-1">
                                    <span>{{ $fatIcon }}</span>
                                    <span>{{ $fatDiff > 0 ? '+' : '' }}{{ number_format($fatDiff, 1) }}%</span>
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            {{-- Progress Chart --}}
            <div class="glass-dark rounded-3xl p-8 border border-emerald-500/20 shadow-2xl shadow-emerald-500/10 mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-black text-white flex items-center gap-3">
                        <span class="text-gradient">Progress Analytics</span>
                    </h2>
                    <div class="flex items-center gap-2 text-sm text-emerald-400">
                        @if($progress->whereNotNull('muscle_mass')->count() > 0)
                            <div
                                class="flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20">
                                <div class="w-2 h-2 bg-emerald-400 rounded-full"></div>
                                <span>Muscle Mass</span>
                            </div>
                        @endif
                        @if($progress->whereNotNull('body_fat')->count() > 0)
                            <div
                                class="flex items-center gap-2 px-3 py-1 rounded-full bg-purple-500/10 border border-purple-500/20">
                                <div class="w-2 h-2 bg-purple-400 rounded-full"></div>
                                <span>Body Fat</span>
                            </div>
                        @endif
                    </div>
                </div>

                @if($progress->count() > 0)
                    <div class="h-96">
                        <canvas id="progressChart"></canvas>
                    </div>
                @else
                    <div class="text-center py-16">
                        <div
                            class="w-24 h-24 bg-emerald-500/10 rounded-3xl flex items-center justify-center mx-auto mb-4 border border-emerald-500/20">
                            <span class="text-4xl">📊</span>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-2">No Progress Data Yet</h3>
                        <p class="text-emerald-400/80 mb-6">Start tracking your fitness journey to see beautiful charts here</p>
                        <a href="{{ route('user.progress.create') }}"
                            class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-emerald-500 to-emerald-700 hover:from-emerald-600 hover:to-emerald-800 transition-all duration-300">
                            <span>Add Your First Progress</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </a>
                    </div>
                @endif
            </div>

            {{-- Progress Table --}}
            <div
                class="glass-dark rounded-3xl border border-emerald-500/20 shadow-2xl shadow-emerald-500/10 overflow-hidden">
                <div class="px-8 py-6 border-b border-emerald-500/20">
                    <h2 class="text-2xl font-black text-white flex items-center gap-3">
                        <span class="text-gradient">Progress History</span>
                    </h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-emerald-500/20">
                                <th
                                    class="px-8 py-4 text-left text-sm font-semibold text-emerald-400 uppercase tracking-wider">
                                    Date</th>
                                <th
                                    class="px-8 py-4 text-left text-sm font-semibold text-emerald-400 uppercase tracking-wider">
                                    Weight</th>
                                @if($progress->whereNotNull('muscle_mass')->count() > 0)
                                    <th
                                        class="px-8 py-4 text-left text-sm font-semibold text-emerald-400 uppercase tracking-wider">
                                        Muscle Mass</th>
                                @endif
                                @if($progress->whereNotNull('body_fat')->count() > 0)
                                    <th
                                        class="px-8 py-4 text-left text-sm font-semibold text-emerald-400 uppercase tracking-wider">
                                        Body Fat</th>
                                @endif
                                <th
                                    class="px-8 py-4 text-right text-sm font-semibold text-emerald-400 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-emerald-500/10">
                            @forelse ($progress as $p)
                                <tr class="group hover:bg-emerald-500/5 transition-all duration-300">
                                    <td class="px-8 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 bg-emerald-500/10 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                                <span
                                                    class="text-emerald-400 text-sm font-bold">{{ \Carbon\Carbon::parse($p->recorded_at)->format('d') }}</span>
                                            </div>
                                            <div>
                                                <p class="text-white font-semibold">
                                                    {{ \Carbon\Carbon::parse($p->recorded_at)->format('M Y') }}</p>
                                                <p class="text-emerald-400/60 text-sm">
                                                    {{ \Carbon\Carbon::parse($p->recorded_at)->format('D') }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-4">
                                        <p class="text-2xl font-black text-white">{{ number_format($p->weight, 1) }}<span
                                                class="text-lg text-emerald-400">kg</span></p>
                                    </td>
                                    @if($progress->whereNotNull('muscle_mass')->count() > 0)
                                        <td class="px-8 py-4">
                                            <p class="text-xl font-semibold text-white">
                                                {{ $p->muscle_mass ? number_format($p->muscle_mass, 1) : '--' }}<span
                                                    class="text-sm text-blue-400">kg</span>
                                            </p>
                                        </td>
                                    @endif
                                    @if($progress->whereNotNull('body_fat')->count() > 0)
                                        <td class="px-8 py-4">
                                            <p class="text-xl font-semibold text-white">
                                                {{ $p->body_fat ? number_format($p->body_fat, 1) : '--' }}<span
                                                    class="text-sm text-purple-400">%</span>
                                            </p>
                                        </td>
                                    @endif
                                    <td class="px-8 py-4 text-right">
                                        <a href="{{ route('user.progress.edit', $p->id) }}"
                                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-emerald-400 hover:text-white hover:bg-emerald-500/10 transition-all duration-300 border border-transparent hover:border-emerald-500/30 group/edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-16 text-center">
                                        <div
                                            class="w-20 h-20 bg-emerald-500/10 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-emerald-500/20">
                                            <span class="text-2xl">📝</span>
                                        </div>
                                        <h3 class="text-lg font-semibold text-white mb-2">No Progress Records</h3>
                                        <p class="text-emerald-400/80 mb-4">Start tracking your fitness progress to see your
                                            journey</p>
                                        <a href="{{ route('user.progress.create') }}"
                                            class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-emerald-500 to-emerald-700 hover:from-emerald-600 hover:to-emerald-800 transition-all duration-300">
                                            Add First Progress
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart Script --}}
    @if($progress->count() > 0)
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Dark theme configuration
            Chart.defaults.color = '#94a3b8';
            Chart.defaults.borderColor = 'rgba(16, 185, 129, 0.1)';
            Chart.defaults.font.family = 'Inter, sans-serif';

            const progress = @json($progress);
            const labels = progress.map(p =>
                new Date(p.recorded_at).toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'short',
                    year: progress.length > 6 ? '2-digit' : undefined
                })
            );

            const datasets = [
                {
                    label: 'Weight (kg)',
                    data: progress.map(p => p.weight),
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderWidth: 3,
                    tension: 0.4,
                    pointBackgroundColor: '#10b981',
                    pointBorderColor: '#000',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    fill: true
                }
            ];

            if (progress.some(p => p.muscle_mass !== null)) {
                datasets.push({
                    label: 'Muscle Mass (kg)',
                    data: progress.map(p => p.muscle_mass),
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 3,
                    tension: 0.4,
                    pointBackgroundColor: '#3b82f6',
                    pointBorderColor: '#000',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    fill: true
                });
            }

            if (progress.some(p => p.body_fat !== null)) {
                datasets.push({
                    label: 'Body Fat (%)',
                    data: progress.map(p => p.body_fat),
                    borderColor: '#8b5cf6',
                    backgroundColor: 'rgba(139, 92, 246, 0.1)',
                    borderWidth: 3,
                    tension: 0.4,
                    pointBackgroundColor: '#8b5cf6',
                    pointBorderColor: '#000',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    fill: true
                });
            }

            const ctx = document.getElementById('progressChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: { labels, datasets },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                color: '#e2e8f0',
                                font: {
                                    size: 12,
                                    weight: '600'
                                },
                                padding: 20,
                                usePointStyle: true
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#e2e8f0',
                            bodyColor: '#cbd5e1',
                            borderColor: 'rgba(16, 185, 129, 0.3)',
                            borderWidth: 1,
                            cornerRadius: 8,
                            displayColors: true
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            grid: {
                                color: 'rgba(16, 185, 129, 0.1)',
                                drawBorder: false
                            },
                            ticks: {
                                color: '#94a3b8',
                                font: {
                                    size: 11
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                color: '#94a3b8',
                                font: {
                                    size: 11
                                }
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    animations: {
                        tension: {
                            duration: 1000,
                            easing: 'linear'
                        }
                    }
                }
            });
        </script>
    @endif

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
            box-shadow: 0 0 25px rgba(16, 185, 129, 0.4);
            transition: all 0.3s ease;
        }
    </style>
@endsection