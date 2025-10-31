@extends('layouts.user')

@section('content')
    <div class="bg-white shadow-md rounded-2xl p-6 space-y-6">
        <!-- ✅ Header -->
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-indigo-700 flex items-center gap-2">
                📊 My Progress
            </h2>
            <a href="{{ route('user.progress.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition">
                + Tambah Progress
            </a>
        </div>

        <!-- ✅ Grafik Perkembangan -->
        <div class="bg-gray-50 p-4 rounded-xl border">
            <h3 class="text-lg font-semibold text-gray-700 mb-3">Grafik Perkembangan</h3>
            @if($progress->count() > 0)
                <canvas id="progressChart" class="w-full h-64"></canvas>
            @else
                <p class="text-gray-500 text-center py-6">Belum ada data untuk ditampilkan di grafik.</p>
            @endif
        </div>

        <!-- ✅ Tabel Data -->
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-200 text-sm">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="p-3 text-left border">Tanggal</th>
                        <th class="p-3 text-left border">Berat (kg)</th>
                        <th class="p-3 text-left border">Massa Otot (kg)</th>
                        <th class="p-3 text-left border">Lemak Tubuh (%)</th>
                        <th class="p-3 text-center border w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($progress as $p)
                        <tr class="border-t hover:bg-gray-50 transition">
                            <td class="p-3 border">{{ \Carbon\Carbon::parse($p->recorded_at)->format('d M Y') }}</td>
                            <td class="p-3 border">{{ number_format($p->weight, 1) }}</td>
                            <td class="p-3 border">{{ number_format($p->muscle_mass, 1) }}</td>
                            <td class="p-3 border">{{ $p->body_fat ? number_format($p->body_fat, 1) : '-' }}</td>
                            <td class="p-3 border text-center">
                                <a href="{{ route('user.progress.edit', $p->id) }}"
                                    class="text-indigo-600 hover:underline">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-gray-500 p-4">
                                Belum ada data progres.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- ✅ Grafik Script -->
    @if($progress->count() > 0)
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const progress = @json($progress);
            const labels = progress.map(p => p.recorded_at);
            const weightData = progress.map(p => p.weight);
            const muscleData = progress.map(p => p.muscle_mass);
            const fatData = progress.map(p => p.body_fat);

            const ctx = document.getElementById('progressChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Berat Badan (kg)',
                            data: weightData,
                            borderColor: '#6366F1',
                            tension: 0.3,
                            fill: false,
                            pointBackgroundColor: '#6366F1',
                        },
                        {
                            label: 'Massa Otot (kg)',
                            data: muscleData,
                            borderColor: '#10B981',
                            tension: 0.3,
                            fill: false,
                            pointBackgroundColor: '#10B981',
                        },
                        {
                            label: 'Lemak Tubuh (%)',
                            data: fatData,
                            borderColor: '#EF4444',
                            tension: 0.3,
                            fill: false,
                            pointBackgroundColor: '#EF4444',
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'bottom' },
                        title: {
                            display: true,
                            text: 'Perkembangan Tubuh dari Waktu ke Waktu',
                            font: { size: 14 }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            title: {
                                display: true,
                                text: 'Nilai'
                            }
                        }
                    }
                }
            });
        </script>
    @endif
@endsection