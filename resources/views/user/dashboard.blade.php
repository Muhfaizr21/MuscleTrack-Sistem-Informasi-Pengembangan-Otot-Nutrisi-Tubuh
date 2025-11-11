@extends('layouts.user')

@section('content')
    <div class="min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Welcome Header --}}
            <div class="glass-dark rounded-3xl p-8 border border-emerald-500/20 shadow-2xl shadow-emerald-500/10 mb-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl flex items-center justify-center animate-glow">
                            <span class="text-2xl font-bold text-white">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        </div>
                        <div>
                            <h1 class="text-3xl sm:text-4xl font-black text-white mb-2">
                                Welcome back, <span class="text-gradient">{{ $user->name }}</span> 👋
                            </h1>
                            <p class="text-emerald-400/80 text-lg">Here's your fitness overview for today</p>
                        </div>
                    </div>
                    <div class="hidden sm:flex items-center gap-2 text-emerald-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm font-bold">{{ now()->format('l, F j, Y') }}</span>
                    </div>
                </div>
            </div>

            {{-- Stats Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                {{-- Protein Tracker --}}
                <div
                    class="glass rounded-2xl p-6 border border-emerald-500/10 hover:border-emerald-500/30 transition-all duration-300 group hover-glow">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-emerald-400">Protein Target</h3>
                        <div
                            class="w-10 h-10 bg-emerald-500/10 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                    </div>
                    <div class="text-center">
                        <p class="text-4xl font-black text-emerald-400 mb-2">{{ $proteinNeed }}</p>
                        <p class="text-emerald-400/80 text-sm">grams per day</p>
                    </div>
                </div>

                {{-- Workout Plans Count --}}
                <div
                    class="glass rounded-2xl p-6 border border-blue-500/10 hover:border-blue-500/30 transition-all duration-300 group hover-glow">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-blue-400">Workout Plans</h3>
                        <div
                            class="w-10 h-10 bg-blue-500/10 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                    </div>
                    <div class="text-center">
                        <p class="text-4xl font-black text-blue-400 mb-2">{{ $workouts->count() }}</p>
                        <p class="text-blue-400/80 text-sm">active plans</p>
                    </div>
                </div>

                {{-- Nutrition Plans Count --}}
                <div
                    class="glass rounded-2xl p-6 border border-emerald-500/10 hover:border-emerald-500/30 transition-all duration-300 group hover-glow">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-emerald-400">Nutrition Plans</h3>
                        <div
                            class="w-10 h-10 bg-emerald-500/10 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="text-center">
                        <p class="text-4xl font-black text-emerald-400 mb-2">{{ $nutritions->count() }}</p>
                        <p class="text-emerald-400/80 text-sm">meal plans</p>
                    </div>
                </div>
            </div>

            {{-- Main Content Grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- Left Column --}}
                <div class="space-y-8">
                    {{-- Progress Chart --}}
                    <div class="glass-dark rounded-3xl p-6 border border-emerald-500/20 shadow-xl shadow-emerald-500/10">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-2xl font-black text-white">
                                <span class="text-gradient">Progress Tracking</span>
                            </h3>
                            <div class="flex items-center gap-4 text-sm">
                                <div
                                    class="flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20">
                                    <div class="w-2 h-2 bg-emerald-400 rounded-full"></div>
                                    <span class="text-emerald-400 font-bold">Weight</span>
                                </div>
                                <div
                                    class="flex items-center gap-2 px-3 py-1 rounded-full bg-purple-500/10 border border-purple-500/20">
                                    <div class="w-2 h-2 bg-purple-400 rounded-full"></div>
                                    <span class="text-purple-400 font-bold">Muscle Mass</span>
                                </div>
                            </div>
                        </div>
                        <div class="h-80">
                            <canvas id="progressChart"></canvas>
                        </div>
                    </div>

                    {{-- Workout Plans --}}
                    <div class="glass-dark rounded-3xl p-6 border border-emerald-500/20 shadow-xl shadow-emerald-500/10">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-2xl font-black text-white">
                                <span class="text-gradient">Workout Plans</span>
                            </h3>
                            <div
                                class="w-10 h-10 bg-blue-500/10 rounded-xl flex items-center justify-center border border-blue-500/20">
                                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                        </div>
                        <div class="space-y-4">
                            @forelse($workouts as $workout)
                                <a href="{{ route('user.workouts.show', $workout->id) }}" class="block group">
                                    <div
                                        class="flex items-center justify-between p-4 glass rounded-xl border border-emerald-500/10 hover:border-blue-500/30 transition-all duration-300 group-hover:bg-blue-500/5">
                                        <div class="flex-1">
                                            <h4 class="font-bold text-white group-hover:text-blue-400 transition-colors mb-1">
                                                {{ $workout->title }}
                                            </h4>
                                            <div class="flex items-center gap-3">
                                                <span
                                                    class="text-xs font-bold text-blue-400 bg-blue-500/10 px-2 py-1 rounded-full border border-blue-500/20">
                                                    {{ $workout->level ?? 'Beginner' }}
                                                </span>
                                                <span class="text-xs text-emerald-400/80 flex items-center gap-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20"
                                                        fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    {{ $workout->duration_minutes ?? 30 }} min
                                                </span>
                                            </div>
                                        </div>
                                        <svg class="w-5 h-5 text-emerald-400/60 transform group-hover:translate-x-1 transition-transform"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </div>
                                </a>
                            @empty
                                <div class="text-center py-8">
                                    <div
                                        class="w-16 h-16 bg-emerald-500/10 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-emerald-500/20">
                                        <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                    </div>
                                    <h4 class="text-lg font-bold text-white mb-2">No Workout Plans</h4>
                                    <p class="text-emerald-400/80 text-sm">Start your fitness journey with a workout plan</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Right Column --}}
                <div class="space-y-8">
                    {{-- Nutrition Plans --}}
                    <div class="glass-dark rounded-3xl p-6 border border-emerald-500/20 shadow-xl shadow-emerald-500/10">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-2xl font-black text-white">
                                <span class="text-gradient">Nutrition Plans</span>
                            </h3>
                            <div
                                class="w-10 h-10 bg-emerald-500/10 rounded-xl flex items-center justify-center border border-emerald-500/20">
                                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="space-y-4">
                            @forelse($nutritions as $nutrition)
                                <a href="{{ route('user.nutrition.index') }}" class="block group">
                                    <div
                                        class="flex items-center justify-between p-4 glass rounded-xl border border-emerald-500/10 hover:border-emerald-500/30 transition-all duration-300 group-hover:bg-emerald-500/5">
                                        <div class="flex-1">
                                            <h4
                                                class="font-bold text-white group-hover:text-emerald-400 transition-colors mb-1">
                                                {{ $nutrition->title ?? 'Daily Nutrition' }}
                                            </h4>
                                            <div class="flex items-center gap-3">
                                                <span
                                                    class="text-xs font-bold text-emerald-400 bg-emerald-500/10 px-2 py-1 rounded-full border border-emerald-500/20">
                                                    {{ $nutrition->calories ?? 0 }} kcal
                                                </span>
                                                <span class="text-xs text-emerald-400/80 flex items-center gap-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20"
                                                        fill="currentColor">
                                                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                                        <path fill-rule="evenodd"
                                                            d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    Meal Plan
                                                </span>
                                            </div>
                                        </div>
                                        <svg class="w-5 h-5 text-emerald-400/60 transform group-hover:translate-x-1 transition-transform"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </div>
                                </a>
                            @empty
                                <div class="text-center py-8">
                                    <div
                                        class="w-16 h-16 bg-emerald-500/10 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-emerald-500/20">
                                        <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <h4 class="text-lg font-bold text-white mb-2">No Nutrition Plans</h4>
                                    <p class="text-emerald-400/80 text-sm">Add your nutrition plan to track your meals</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Tips & Articles --}}
                    <div class="glass-dark rounded-3xl p-6 border border-emerald-500/20 shadow-xl shadow-emerald-500/10">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-2xl font-black text-white">
                                <span class="text-gradient">Tips & Articles</span>
                            </h3>
                            <div
                                class="w-10 h-10 bg-emerald-500/10 rounded-xl flex items-center justify-center border border-emerald-500/20">
                                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>
                            </div>
                        </div>
                        <div class="space-y-4">
                            @forelse($articles as $article)
                                <a href="{{ route('user.articles.show', $article->id) }}" class="block group">
                                    <div
                                        class="flex items-start justify-between p-4 glass rounded-xl border border-emerald-500/10 hover:border-emerald-500/30 transition-all duration-300 group-hover:bg-emerald-500/5">
                                        <div class="flex-1">
                                            <h4
                                                class="font-bold text-white group-hover:text-emerald-400 transition-colors mb-2 line-clamp-2">
                                                {{ $article->title }}
                                            </h4>
                                            <p class="text-emerald-400/80 text-sm line-clamp-2 mb-3">
                                                {{ Str::limit(strip_tags($article->content), 100) }}
                                            </p>
                                            <div class="flex items-center justify-between">
                                                <span
                                                    class="text-xs font-bold text-emerald-400 bg-emerald-500/10 px-2 py-1 rounded-full border border-emerald-500/20">
                                                    {{ $article->category ?? 'Fitness' }}
                                                </span>
                                                <span class="text-xs text-emerald-400/60">
                                                    {{ $article->created_at->format('M d') }}
                                                </span>
                                            </div>
                                        </div>
                                        <svg class="w-5 h-5 text-emerald-400/60 transform group-hover:translate-x-1 transition-transform mt-1 flex-shrink-0"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </div>
                                </a>
                            @empty
                                <div class="text-center py-8">
                                    <div
                                        class="w-16 h-16 bg-emerald-500/10 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-emerald-500/20">
                                        <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                        </svg>
                                    </div>
                                    <h4 class="text-lg font-bold text-white mb-2">No Articles Available</h4>
                                    <p class="text-emerald-400/80 text-sm">Check back later for new fitness tips</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Dark theme configuration for Chart.js
        Chart.defaults.color = '#94a3b8';
        Chart.defaults.borderColor = 'rgba(16, 185, 129, 0.1)';
        Chart.defaults.font.family = 'Inter, sans-serif';

        const ctx = document.getElementById('progressChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($progress->pluck('recorded_at')->map(fn($d) => date('d M', strtotime($d)))),
                    datasets: [
                        {
                            label: 'Weight (kg)',
                            data: @json($progress->pluck('weight')),
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
                        },
                        {
                            label: 'Muscle Mass (kg)',
                            data: @json($progress->pluck('muscle_mass')),
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
                        }
                    ]
                },
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
        }
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
            box-shadow: 0 0 25px rgba(16, 185, 129, 0.4);
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

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endsection