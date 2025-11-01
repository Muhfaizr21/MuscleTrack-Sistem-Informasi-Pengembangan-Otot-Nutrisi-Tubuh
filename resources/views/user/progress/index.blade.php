@extends('layouts.user')

@section('content')

    <div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 shadow-sm sm:rounded-lg p-6 space-y-6">

        <div class="flex justify-between items-center">
            <h2 class="font-serif text-2xl font-bold text-white flex items-center gap-2">
                📊 My <span class="text-amber-400">Progress</span>
            </h2>
            <a href="{{ route('user.progress.create') }}"
                class="px-5 py-2.5 rounded-md text-sm font-bold text-black bg-amber-400 hover:bg-amber-300 transition-all shadow-lg shadow-amber-500/20">
                + Tambah Progress
            </a>
        </div>

        <div class="bg-gray-900/50 p-4 rounded-xl border border-gray-700/50">
            <h3 class="font-serif text-lg font-bold text-white mb-3">Grafik Perkembangan</h3>
            @if($progress->count() > 0)
                <canvas id="progressChart" class="w-full h-64"></canvas>
            @else
                <p class="text-gray-400 text-center py-6">Belum ada data untuk ditampilkan di grafik.</p>
            @endif
        </div>

        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-gray-700 text-sm">
                <thead class="bg-gray-900/50">
                    <tr>
                        <th class="p-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Tanggal</th>
                        <th class="p-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Berat (kg)</th>
                        <th class="p-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Massa Otot (kg)</th>
                        <th class="p-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Lemak Tubuh (%)</th>
                        <th class="p-3 text-center text-xs font-medium text-gray-400 uppercase tracking-wider w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse ($progress as $p)
                        <tr class="hover:bg-gray-800/50 transition">
                            <td class="p-3 text-gray-300">{{ \Carbon\Carbon::parse($p->recorded_at)->format('d M Y') }}</td>
                            <td class="p-3 text-white font-medium">{{ number_format($p->weight, 1) }}</td>
                            <td class="p-3 text-white font-medium">{{ number_format($p->muscle_mass, 1) }}</td>
                            <td class="p-3 text-white font-medium">{{ $p->body_fat ? number_format($p->body_fat, 1) : '-' }}</td>
                            <td class="p-3 text-center">
                                <a href="{{ route('user.progress.edit', $p->id) }}"
                                    class="text-amber-400 hover:text-amber-300 font-medium">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-gray-400 p-6">
                                Belum ada data progres.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($progress->count() > 0)
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Data dari controller (Sistem Tidak Berubah)
            const progress = @json($progress);
            const labels = progress.map(p => new Date(p.recorded_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short' }));
            const weightData = progress.map(p => p.weight);
            const muscleData = progress.map(p => p.muscle_mass);
            const fatData = progress.map(p => p.body_fat);

            // Opsi Tema "Dark Premium" untuk Chart
            Chart.defaults.color = 'rgba(229, 231, 235, 0.7)'; // Teks abu-abu
            Chart.defaults.borderColor = 'rgba(156, 163, 175, 0.1)'; // Garis grid transparan

            const ctx = document.getElementById('progressChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Berat Badan (kg)',
                            data: weightData,
                            borderColor: '#FBBF24', // WARNA EMAS (Amber-400)
                            tension: 0.3,
                            fill: false,
                            pointBackgroundColor: '#FBBF24',
                        },
                        {
                            label: 'Massa Otot (kg)',
                            data: muscleData,
                            borderColor: '#A78BFA', // WARNA UNGU (Kontras)
                            tension: 0.3,
                            fill: false,
                            pointBackgroundColor: '#A78BFA',
                        },
                        {
                            label: 'Lemak Tubuh (%)',
                            data: fatData,
                            borderColor: '#F87171', // WARNA MERAH (Kontras)
                            tension: 0.3,
                            fill: false,
                            pointBackgroundColor: '#F87171',
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { color: '#D1D5DB' } // Teks legenda putih
                        },
                        title: {
                            display: true,
                            text: 'Perkembangan Tubuh dari Waktu ke Waktu',
                            font: { size: 16, family: 'Inter' },
                            color: '#FFFFFF' // Teks judul putih
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            title: {
                                display: true,
                                text: 'Nilai',
                                color: '#9CA3AF'
                            },
                            ticks: { color: '#9CA3AF' },
                            grid: { color: 'rgba(156, 163, 175, 0.1)' }
                        },
                        x: {
                            ticks: { color: '#9CA3AF' },
                            grid: { display: false }
                        }
                    }
                }
            });
        </script>
    @endif
@endsection
