@extends('layouts.user')

@section('content')
<div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 shadow-sm sm:rounded-lg p-6 transition-all duration-300">

    {{-- ✅ Flash Message (Style "Dark Premium") --}}
    @if(session('success'))
        <div class="bg-green-500/20 border border-green-500/50 text-green-300 px-4 py-3 rounded-lg mb-4">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- 🗓️ Header (Style "Dark Premium") --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <h2 class="font-serif text-2xl font-bold text-white flex items-center gap-2">
            📊 Weekly <span class="text-amber-400">Summary</span>
        </h2>
        <span class="text-gray-400 text-sm">
            Periode: <strong class="text-gray-200">{{ $weeklySummary['range'] ?? '-' }}</strong>
        </span>
    </div>

    {{-- 🔥 Motivational Card (Style "Dark Premium" Emas) --}}
    <div class="bg-amber-900/50 border-l-4 border-amber-400 p-4 mb-6 rounded-lg">
        <div class="flex items-center gap-3 text-amber-200">
            💬 <strong class="text-amber-300">Motivation:</strong>
            <span>{{ $motivationalMessage ?? 'Ayo mulai minggu ini dengan semangat baru!' }}</span>
        </div>
    </div>

    {{-- 🧾 Summary Cards (Style "Dark Premium" Editorial) --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
        <div class="relative bg-gray-900/50 border border-gray-700/50 rounded-lg p-4 text-center overflow-hidden">
            <div class="absolute -left-2 -bottom-2 font-serif text-6xl font-bold text-gray-800/50 z-0 opacity-50">🏋️</div>
            <div class="relative z-10">
                <p class="text-gray-400 text-sm">Workout</p>
                <p class="text-3xl font-bold text-amber-400">{{ $weeklySummary['completed_workouts'] ?? 0 }}</p>
            </div>
        </div>
        <div class="relative bg-gray-900/50 border border-gray-700/50 rounded-lg p-4 text-center overflow-hidden">
            <div class="absolute -left-2 -bottom-2 font-serif text-6xl font-bold text-gray-800/50 z-0 opacity-50">🔥</div>
            <div class="relative z-10">
                <p class="text-gray-400 text-sm">Kalori</p>
                <p class="text-3xl font-bold text-green-400">{{ $weeklySummary['total_calories'] ?? 0 }} kcal</p>
            </div>
        </div>
        <div class="relative bg-gray-900/50 border border-gray-700/50 rounded-lg p-4 text-center overflow-hidden">
            <div class="absolute -left-2 -bottom-2 font-serif text-6xl font-bold text-gray-800/50 z-0 opacity-50">💪</div>
            <div class="relative z-10">
                <p class="text-gray-400 text-sm">Protein</p>
                <p class="text-3xl font-bold text-yellow-400">{{ $weeklySummary['total_protein'] ?? 0 }} g</p>
            </div>
        </div>
        <div class="relative bg-gray-900/50 border border-gray-700/50 rounded-lg p-4 text-center overflow-hidden">
            <div class="absolute -left-2 -bottom-2 font-serif text-6xl font-bold text-gray-800/50 z-0 opacity-50">🥑</div>
            <div class="relative z-10">
                <p class="text-gray-400 text-sm">Lemak</p>
                <p class="text-3xl font-bold text-red-400">{{ $weeklySummary['total_fat'] ?? 0 }} g</p>
            </div>
        </div>
    </div>

    {{-- 📈 Body Progress (Style "Dark Premium") --}}
    <div class="bg-gray-900/50 rounded-2xl border border-gray-700/50 p-6 mb-8">
        <h3 class="font-serif text-lg font-bold text-white mb-3 flex items-center gap-2">
            🧍 Progress <span class="text-amber-400">Tubuh Minggu Ini</span>
        </h3>
        @if(!empty($weeklySummary['latest_weight']) && $weeklySummary['latest_weight'] !== '-')
            <div class="grid grid-cols-1 sm:grid-cols-3 text-center gap-4">
                <div class="p-3 bg-gray-800/60 rounded-lg">
                    <p class="text-gray-400 text-sm">Berat Badan</p>
                    <p class="text-xl font-semibold text-amber-400">{{ $weeklySummary['latest_weight'] }} kg</p>
                </div>
                <div class="p-3 bg-gray-800/60 rounded-lg">
                    <p class="text-gray-400 text-sm">Massa Otot</p>
                    <p class="text-xl font-semibold text-green-400">{{ $weeklySummary['latest_muscle'] ?? '-' }} kg</p>
                </div>
                <div class="p-3 bg-gray-800/60 rounded-lg">
                    <p class="text-gray-400 text-sm">Lemak Tubuh</p>
                    <p class="text-xl font-semibold text-red-400">{{ $weeklySummary['latest_body_fat'] ?? '-' }} %</p>
                </div>
            </div>
        @else
            <p class="text-gray-400 italic">Belum ada data progres minggu ini.</p>
        @endif
    </div>

    {{-- 🏋️ Workout List (Style "Dark Premium") --}}
    <div class="bg-gray-900/50 rounded-2xl border border-gray-700/50 p-6 mb-8">
        <h3 class="font-serif text-lg font-bold text-white mb-4 flex items-center gap-2">
            🏋️ Jadwal Latihan <span class="text-amber-400">Minggu Ini</span>
        </h3>
        @if($workouts->isEmpty())
            <p class="text-gray-400 italic">Belum ada jadwal latihan minggu ini.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full border-separate border-spacing-0 text-sm">
                    <thead class="bg-gray-800 text-gray-300">
                        <tr>
                            <th class="p-2 text-left rounded-tl-lg">Tanggal</th>
                            <th class="p-2 text-left">Workout</th>
                            <th class="p-2 text-center">Waktu</th>
                            <th class="p-2 text-center rounded-tr-lg">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-300">
                        @foreach ($workouts as $w)
                            <tr class="hover:bg-gray-800/50 transition-colors">
                                <td class="p-2 border-t border-gray-700/50">{{ \Carbon\Carbon::parse($w->scheduled_date)->format('d M Y') }}</td>
                                <td class="p-2 border-t border-gray-700/50 text-white font-medium">{{ $w->workout_name }}</td>
                                <td class="p-2 text-center border-t border-gray-700/50">{{ $w->scheduled_time ?? '-' }}</td>
                                <td class="p-2 text-center border-t border-gray-700/50">
                                    @if($w->status === 'completed')
                                        <span class="bg-green-500/20 text-green-300 px-2 py-1 rounded text-xs font-medium">Selesai</span>
                                    @elseif($w->status === 'missed')
                                        <span class="bg-red-500/20 text-red-300 px-2 py-1 rounded text-xs font-medium">Terlewat</span>
                                    @else
                                        <span class="bg-yellow-500/20 text-yellow-300 px-2 py-1 rounded text-xs font-medium">Pending</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- 📅 Chart (Style "Dark Premium") --}}
    <div class="bg-gray-900/50 rounded-2xl border border-gray-700/50 p-6 mb-8">
        <h3 class="font-serif text-lg font-bold text-white mb-3 flex items-center gap-2">
            📈 Tren <span class="text-amber-400">Kalori Mingguan</span>
        </h3>
        <canvas id="weeklyChart" height="120"></canvas>
    </div>

    {{-- 🔔 Weekly Summary Notification (Style "Dark Premium" Kuning) --}}
    <div class="bg-yellow-900/50 border-l-4 border-yellow-400 text-yellow-200 p-4 rounded-lg">
        <div class="flex items-center gap-2">
            📬 <strong class="text-yellow-300">Weekly Recap:</strong>
            <span>Evaluasi minggu ini dan tetap semangat untuk minggu berikutnya 💪</span>
        </div>
    </div>
</div>

{{-- ✅ Chart.js (LOGIKA TIDAK BERUBAH, HANYA WARNA) --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    // Opsi Tema "Dark Premium" untuk Chart
    Chart.defaults.color = 'rgba(229, 231, 235, 0.7)'; // Teks abu-abu
    Chart.defaults.borderColor = 'rgba(156, 163, 175, 0.1)'; // Garis grid transparan

    const ctx = document.getElementById('weeklyChart');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
            datasets: [{
                label: 'Kalori (kcal)',
                data: [{{ implode(',', array_fill(0, 7, ($weeklySummary['total_calories'] ?? 0) / 7)) }}], // Logika Anda aman
                borderColor: '#FBBF24', // WARNA EMAS (Amber-400)
                backgroundColor: 'rgba(251, 191, 36, 0.1)', // Emas transparan
                borderWidth: 2,
                fill: true,
                tension: 0.3,
                pointBackgroundColor: '#FBBF24' // Emas
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom', labels: { color: '#D1D5DB' } },
                tooltip: {
                    backgroundColor: '#030712', // Hitam
                    titleColor: '#FBBF24', // Emas
                    bodyColor: '#E5E7EB', // Putih
                    borderColor: '#FBBF24', // Emas
                    borderWidth: 1
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'Kalori (kcal)', color: '#9CA3AF' },
                    ticks: { color: '#9CA3AF' }
                },
                x: {
                    ticks: { color: '#9CA3AF' }
                }
            },
            animation: { duration: 1000, easing: 'easeOutQuart' }
        }
    });
});
</script>
@endsection
