<x-layouts.admin>

    <x-slot name="title">Admin <span class="text-amber-400">Dashboard</span></x-slot>

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

    <div class="mt-10 grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 rounded-lg shadow-sm p-6">
            <h3 class="font-serif text-2xl font-bold text-white mb-4">
                Pertumbuhan <span class="text-amber-400">User Baru</span> (30 Hari)
            </h3>
            <div>
                <canvas id="userGrowthChart"></canvas>
            </div>
        </div>

        <div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 rounded-lg shadow-sm p-6">
            <h3 class="font-serif text-2xl font-bold text-white mb-4">
                Rata-Rata <span class="text-amber-400">Progres User</span>
            </h3>
            <div>
                <canvas id="userProgressChart"></canvas>
            </div>
        </div>
    </div>

    <div class="mt-10 bg-black/70 backdrop-blur-lg border border-gray-700/50 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 border-b border-gray-700/50">
             <h3 class="font-serif text-2xl font-bold text-white">
                Aktivitas <span class="text-amber-400">Terbaru</span>
            </h3>
        </div>
        <table class="min-w-full divide-y divide-gray-700">
            <tbody class="divide-y divide-gray-800">
                <tr>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-white">User Baru Mendaftar</div>
                        <div class="text-sm text-gray-400">user@example.com</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">2 menit lalu</td>
                </tr>
                <tr>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-white">Pembayaran Premium</div>
                        <div class="text-sm text-gray-400">Dari: Siska Putri (Status: LUNAS)</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">2 jam lalu</td>
                </tr>
            </tbody>
        </table>
    </div>


    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            Chart.defaults.color = 'rgba(229, 231, 235, 0.7)';
            Chart.defaults.borderColor = 'rgba(156, 163, 175, 0.1)';

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
                        borderColor: '#FBBF24', // Emas (amber-400)
                        backgroundColor: 'rgba(251, 191, 36, 0.1)',
                        tension: 0.3,
                        pointBackgroundColor: '#FBBF24'
                    }]
                },
                options: { /* ... opsi chart ... */ }
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
                            'rgba(251, 191, 36, 0.2)', // Emas
                            'rgba(200, 200, 200, 0.2)',
                            'rgba(200, 200, 200, 0.2)',
                        ],
                        borderColor: ['#FBBF24', '#9CA3AF', '#9CA3AF'],
                        borderWidth: 1
                    }]
                },
                options: { indexAxis: 'y', /* ... opsi chart ... */ }
            });
        });
    </script>
    @endpush

</x-layouts.admin>
