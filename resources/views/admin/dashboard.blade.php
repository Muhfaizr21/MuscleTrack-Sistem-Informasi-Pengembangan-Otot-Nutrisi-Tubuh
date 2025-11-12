<x-layouts.admin>

    <x-slot name="title">Admin <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Dashboard</span></x-slot>

    <!-- Stats Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <x-admin.stat-card
            title="Total User"
            value="1,204"
            trend="+12% dari bulan lalu"
            ghostNumber="01" />

        <x-admin.stat-card
            title="Total Artikel"
            value="88"
            trend="+3 baru minggu ini"
            ghostNumber="02" />

        <x-admin.stat-card
            title="Pesan Baru"
            value="14"
            trend="Belum dibaca"
            ghostNumber="03" />

        <x-admin.stat-card
            title="Riwayat Premium"
            value="72"
            trend="Total Transaksi"
            ghostNumber="04" />
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

        <!-- User Progress Chart -->
        <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl shadow-2xl shadow-black/30 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-white">
                    Rata-Rata <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Progres User</span>
                </h3>
                <span class="text-xs font-semibold text-blue-400 bg-blue-500/10 px-3 py-1 rounded-full border border-blue-500/20">
                    Progress
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
            <!-- Activity Item 1 -->
            <div class="p-6 hover:bg-slate-700/20 transition-colors duration-300">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-green-500/10 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-white">User Baru Mendaftar</div>
                            <div class="text-sm text-slate-400">user@example.com</div>
                        </div>
                    </div>
                    <div class="text-sm text-slate-500">2 menit lalu</div>
                </div>
            </div>

            <!-- Activity Item 2 -->
            <div class="p-6 hover:bg-slate-700/20 transition-colors duration-300">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-emerald-500/10 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v1m0 6v1m0-1v1m6-13a2 2 0 11-4 0 2 2 0 014 0zM6 15a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-white">Pembayaran Premium</div>
                            <div class="text-sm text-slate-400">Dari: Siska Putri (Status: LUNAS)</div>
                        </div>
                    </div>
                    <div class="text-sm text-slate-500">2 jam lalu</div>
                </div>
            </div>

            <!-- Activity Item 3 -->
            <div class="p-6 hover:bg-slate-700/20 transition-colors duration-300">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-blue-500/10 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-white">Artikel Baru Diposting</div>
                            <div class="text-sm text-slate-400">"5 Tips Fitness untuk Pemula"</div>
                        </div>
                    </div>
                    <div class="text-sm text-slate-500">5 jam lalu</div>
                </div>
            </div>
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
                    labels: ['Okt 1', 'Okt 5', 'Okt 10', 'Okt 15', 'Okt 20', 'Okt 25', 'Okt 30'],
                    datasets: [{
                        label: 'User Baru',
                        data: [12, 19, 25, 30, 45, 50, 65],
                        fill: true,
                        borderColor: '#22c55e', // Green-500
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

            // Chart 2: User Progress
            const ctxProgress = document.getElementById('userProgressChart').getContext('2d');
            new Chart(ctxProgress, {
                type: 'bar',
                data: {
                    labels: ['Bulking', 'Cutting', 'Maintenance'],
                    datasets: [{
                        label: 'Rata-Rata Massa Otot (kg)',
                        data: [65.2, 61.8, 63.5],
                        backgroundColor: [
                            'rgba(34, 197, 94, 0.3)', // Green
                            'rgba(148, 163, 184, 0.3)', // Slate
                            'rgba(148, 163, 184, 0.3)', // Slate
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
