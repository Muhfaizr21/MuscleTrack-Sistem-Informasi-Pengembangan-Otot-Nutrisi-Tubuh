<x-layouts.admin>
    <x-slot name="title">Admin <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Dashboard</span></x-slot>

    <!-- Stats Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <x-admin.stat-card
            title="Total User"
            value="{{ number_format($totalUsers) }}"
            trend="+12% dari bulan lalu"
            ghostNumber="01" />

        <x-admin.stat-card
            title="Total Artikel"
            value="{{ number_format($totalArticles) }}"
            trend="+3 baru minggu ini"
            ghostNumber="02" />

        <x-admin.stat-card
            title="Pesan Baru"
            value="{{ number_format($unreadMessages) }}"
            trend="Belum dibaca"
            ghostNumber="03" />

        <x-admin.stat-card
            title="Riwayat Premium"
            value="{{ number_format($premiumTransactions) }}"
            trend="Total Transaksi"
            ghostNumber="04" />
    </div>

    <!-- Trainer Stats Cards -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <x-admin.stat-card
            title="Total Trainer"
            value="{{ number_format($totalTrainers) }}"
            trend="Semua Trainer"
            ghostNumber="05"
            color="orange" />

        <x-admin.stat-card
            title="Trainer Terverifikasi"
            value="{{ number_format($verifiedTrainers) }}"
            trend="Sudah Diverifikasi"
            ghostNumber="06"
            color="green" />

        <x-admin.stat-card
            title="Trainer Pending"
            value="{{ number_format($pendingTrainers) }}"
            trend="Menunggu Verifikasi"
            ghostNumber="07"
            color="yellow" />

        <x-admin.stat-card
            title="Member Premium"
            value="{{ number_format($activeTrainerMemberships) }}"
            trend="Aktif dengan Trainer"
            ghostNumber="08"
            color="blue" />
    </div>

    <!-- Charts Section -->
    <div class="mt-10 grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- User Growth Chart -->
        <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl shadow-2xl shadow-black/30 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-white">
                    Pertumbuhan <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">User Baru</span>
                </h3>
                <span class="text-xs font-semibold text-green-400 bg-green-500/10 px-3 py-1 rounded-full border border-green-500/20">
                    30 Hari
                </span>
            </div>
            <div class="h-64">
                <canvas id="userGrowthChart"></canvas>
            </div>
        </div>

        <!-- Trainer Growth Chart -->
        <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl shadow-2xl shadow-black/30 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-white">
                    Pertumbuhan <span class="bg-gradient-to-r from-orange-400 to-amber-500 bg-clip-text text-transparent">Trainer Baru</span>
                </h3>
                <span class="text-xs font-semibold text-orange-400 bg-orange-500/10 px-3 py-1 rounded-full border border-orange-500/20">
                    30 Hari
                </span>
            </div>
            <div class="h-64">
                <canvas id="trainerGrowthChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Performance Section -->
    <div class="mt-10 grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top Trainers -->
        <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl shadow-2xl shadow-black/30 overflow-hidden">
            <div class="p-6 border-b border-slate-700/50">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white">
                        Top <span class="bg-gradient-to-r from-orange-400 to-amber-500 bg-clip-text text-transparent">Trainer</span>
                    </h3>
                    <span class="text-xs font-semibold text-orange-400 bg-orange-500/10 px-3 py-1 rounded-full border border-orange-500/20">
                        Berdasarkan Member
                    </span>
                </div>
            </div>
            <div class="divide-y divide-slate-700/50">
                @forelse($topTrainers as $index => $trainer)
                <div class="p-4 hover:bg-slate-700/20 transition-colors duration-300">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-orange-400 bg-orange-500/10 px-2 py-1 rounded-full">
                                    #{{ $index + 1 }}
                                </span>
                                <div class="w-8 h-8 bg-gradient-to-br from-orange-500/20 to-amber-600/20 rounded-xl flex items-center justify-center">
                                    <span class="text-sm font-semibold text-orange-400">
                                        {{ strtoupper(substr($trainer['name'], 0, 1)) }}
                                    </span>
                                </div>
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-white">{{ $trainer['name'] }}</div>
                                <div class="text-xs text-slate-400">{{ $trainer['specialization'] }}</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-semibold text-white">{{ $trainer['member_count'] }} Member</div>
                            <div class="flex items-center gap-1 text-xs text-amber-400">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span>{{ $trainer['rating'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center text-slate-500">
                    <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-1.657-.672-3.157-1.757-4.243M17 20h-2m2-2v-2a3 3 0 00-3-3h-2a3 3 0 00-3 3v2m2 4v-4m4 4v-4m-4 4H7m0 0v-2a3 3 0 013-3h2a3 3 0 013 3v2m0 4v-4m-4 4H7m0 0H3v-2a3 3 0 015.356-1.857M3 20v-2c0-1.657.672-3.157 1.757-4.243M3 20h2M3 18v-2a3 3 0 013-3h2a3 3 0 013 3v2m-4 4v-4"/>
                    </svg>
                    <p>Belum ada data trainer</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Trainer Performance Chart -->
        <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl shadow-2xl shadow-black/30 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-white">
                    Performance <span class="bg-gradient-to-r from-orange-400 to-amber-500 bg-clip-text text-transparent">Trainer</span>
                </h3>
                <span class="text-xs font-semibold text-orange-400 bg-orange-500/10 px-3 py-1 rounded-full border border-orange-500/20">
                    Member & Rating
                </span>
            </div>
            <div class="h-64">
                <canvas id="trainerPerformanceChart"></canvas>
            </div>
        </div>
    </div>

    <!-- User Progress Chart -->
    <div class="mt-10">
        <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl shadow-2xl shadow-black/30 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-white">
                    Rata-Rata <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Progres User</span>
                </h3>
                <span class="text-xs font-semibold text-blue-400 bg-blue-500/10 px-3 py-1 rounded-full border border-blue-500/20">
                    Berdasarkan Goal
                </span>
            </div>
            <div class="h-64">
                <canvas id="userProgressChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Activity Table -->
    <div class="mt-10 bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl shadow-2xl shadow-black/30 overflow-hidden">
        <div class="p-6 border-b border-slate-700/50">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-white">
                    Aktivitas <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Terbaru</span>
                </h3>
                <span class="text-sm text-slate-400">Updated just now</span>
            </div>
        </div>
        <div class="divide-y divide-slate-700/50">
            @foreach($recentActivities as $activity)
            <div class="p-6 hover:bg-slate-700/20 transition-colors duration-300">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-{{ $activity['color'] }}-500/10 rounded-xl flex items-center justify-center">
                            @if($activity['icon'] === 'user')
                            <svg class="w-5 h-5 text-{{ $activity['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            @elseif($activity['icon'] === 'trainer')
                            <svg class="w-5 h-5 text-{{ $activity['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-1.657-.672-3.157-1.757-4.243M17 20h-2m2-2v-2a3 3 0 00-3-3h-2a3 3 0 00-3 3v2m2 4v-4m4 4v-4m-4 4H7m0 0v-2a3 3 0 013-3h2a3 3 0 013 3v2m0 4v-4m-4 4H7m0 0H3v-2a3 3 0 015.356-1.857M3 20v-2c0-1.657.672-3.157 1.757-4.243M3 20h2M3 18v-2a3 3 0 013-3h2a3 3 0 013 3v2m-4 4v-4"/>
                            </svg>
                            @elseif($activity['icon'] === 'payment')
                            <svg class="w-5 h-5 text-{{ $activity['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v1m0 6v1m0-1v1m6-13a2 2 0 11-4 0 2 2 0 014 0zM6 15a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            @elseif($activity['icon'] === 'assignment')
                            <svg class="w-5 h-5 text-{{ $activity['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                            @elseif($activity['icon'] === 'article')
                            <svg class="w-5 h-5 text-{{ $activity['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            @endif
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-white">{{ $activity['title'] }}</div>
                            <div class="text-sm text-slate-400">{{ $activity['description'] }}</div>
                        </div>
                    </div>
                    <div class="text-sm text-slate-500">{{ $activity['time'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Chart.defaults.color = 'rgba(148, 163, 184, 0.8)';
            Chart.defaults.borderColor = 'rgba(71, 85, 105, 0.3)';

            // Chart 1: User Growth
            const ctxGrowth = document.getElementById('userGrowthChart').getContext('2d');
            new Chart(ctxGrowth, {
                type: 'line',
                data: {
                    labels: @json($userGrowthData['labels']),
                    datasets: [{
                        label: 'User Baru',
                        data: @json($userGrowthData['data']),
                        fill: true,
                        borderColor: '#22c55e',
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        tension: 0.4,
                        pointBackgroundColor: '#22c55e',
                        pointBorderColor: '#0f172a',
                        pointBorderWidth: 2,
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(71, 85, 105, 0.2)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            // Chart 2: Trainer Growth
            const ctxTrainerGrowth = document.getElementById('trainerGrowthChart').getContext('2d');
            new Chart(ctxTrainerGrowth, {
                type: 'line',
                data: {
                    labels: @json($trainerGrowthData['labels']),
                    datasets: [{
                        label: 'Trainer Baru',
                        data: @json($trainerGrowthData['data']),
                        fill: true,
                        borderColor: '#f97316',
                        backgroundColor: 'rgba(249, 115, 22, 0.1)',
                        tension: 0.4,
                        pointBackgroundColor: '#f97316',
                        pointBorderColor: '#0f172a',
                        pointBorderWidth: 2,
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(71, 85, 105, 0.2)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            // Chart 3: Trainer Performance
            const ctxPerformance = document.getElementById('trainerPerformanceChart').getContext('2d');
            new Chart(ctxPerformance, {
                type: 'bar',
                data: {
                    labels: @json($trainerPerformance['labels']),
                    datasets: [
                        {
                            label: 'Total Member',
                            data: @json($trainerPerformance['members']),
                            backgroundColor: 'rgba(249, 115, 22, 0.3)',
                            borderColor: '#f97316',
                            borderWidth: 1,
                            borderRadius: 8,
                            yAxisID: 'y',
                        },
                        {
                            label: 'Rating',
                            data: @json($trainerPerformance['ratings']),
                            type: 'line',
                            borderColor: '#eab308',
                            backgroundColor: 'rgba(234, 179, 8, 0.1)',
                            borderWidth: 2,
                            pointBackgroundColor: '#eab308',
                            pointBorderColor: '#0f172a',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            tension: 0.4,
                            yAxisID: 'y1',
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    scales: {
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(71, 85, 105, 0.2)'
                            }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            beginAtZero: true,
                            max: 5,
                            grid: {
                                drawOnChartArea: false,
                            },
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            // Chart 4: User Progress
            const ctxProgress = document.getElementById('userProgressChart').getContext('2d');
            new Chart(ctxProgress, {
                type: 'bar',
                data: {
                    labels: @json($userProgressData['labels']),
                    datasets: [{
                        label: 'Rata-Rata Massa Otot (kg)',
                        data: @json($userProgressData['data']),
                        backgroundColor: [
                            'rgba(34, 197, 94, 0.3)',
                            'rgba(148, 163, 184, 0.3)',
                            'rgba(148, 163, 184, 0.3)',
                        ],
                        borderColor: ['#22c55e', '#94a3b8', '#94a3b8'],
                        borderWidth: 1,
                        borderRadius: 8,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    indexAxis: 'y',
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(71, 85, 105, 0.2)'
                            }
                        },
                        y: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-layouts.admin>
