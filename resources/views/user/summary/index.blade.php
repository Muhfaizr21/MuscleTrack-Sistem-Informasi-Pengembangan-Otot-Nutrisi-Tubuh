@extends('layouts.user')

@section('content')
<div class="bg-white dark:bg-gray-900 shadow-md rounded-2xl p-6 transition-all duration-300">

    {{-- ✅ Flash Message --}}
    @if(session('success'))
        <div class="bg-green-100 dark:bg-green-900 border border-green-400 text-green-800 dark:text-green-100 px-4 py-3 rounded-lg mb-4">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- 🗓️ Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <h2 class="text-2xl font-bold text-indigo-700 dark:text-indigo-300 flex items-center gap-2">
            📊 Weekly Summary
        </h2>
        <span class="text-gray-600 dark:text-gray-400 text-sm">
            Periode: <strong>{{ $weeklySummary['range'] ?? '-' }}</strong>
        </span>
    </div>

    {{-- 🔥 Motivational Card --}}
    <div class="bg-indigo-50 dark:bg-indigo-900/30 border-l-4 border-indigo-500 p-4 mb-6 rounded-lg">
        <div class="flex items-center gap-3 text-indigo-700 dark:text-indigo-200">
            💬 <strong>Motivation:</strong>
            <span>{{ $motivationalMessage ?? 'Ayo mulai minggu ini dengan semangat baru!' }}</span>
        </div>
    </div>

    {{-- 🧾 Summary Cards --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
        <div class="bg-indigo-100 dark:bg-indigo-900/30 p-4 rounded-lg text-center">
            <p class="text-gray-600 dark:text-gray-400 text-sm">Workout</p>
            <p class="text-3xl font-bold text-indigo-700 dark:text-indigo-300">{{ $weeklySummary['completed_workouts'] ?? 0 }}</p>
        </div>
        <div class="bg-green-100 dark:bg-green-900/30 p-4 rounded-lg text-center">
            <p class="text-gray-600 dark:text-gray-400 text-sm">Kalori</p>
            <p class="text-3xl font-bold text-green-700 dark:text-green-300">{{ $weeklySummary['total_calories'] ?? 0 }} kcal</p>
        </div>
        <div class="bg-yellow-100 dark:bg-yellow-900/30 p-4 rounded-lg text-center">
            <p class="text-gray-600 dark:text-gray-400 text-sm">Protein</p>
            <p class="text-3xl font-bold text-yellow-700 dark:text-yellow-300">{{ $weeklySummary['total_protein'] ?? 0 }} g</p>
        </div>
        <div class="bg-red-100 dark:bg-red-900/30 p-4 rounded-lg text-center">
            <p class="text-gray-600 dark:text-gray-400 text-sm">Lemak</p>
            <p class="text-3xl font-bold text-red-700 dark:text-red-300">{{ $weeklySummary['total_fat'] ?? 0 }} g</p>
        </div>
    </div>

    {{-- 📈 Body Progress --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 mb-8">
        <h3 class="text-lg font-semibold text-indigo-700 dark:text-indigo-300 mb-3 flex items-center gap-2">
            🧍 Progress Tubuh Minggu Ini
        </h3>
        @if(!empty($weeklySummary['latest_weight']) && $weeklySummary['latest_weight'] !== '-')
            <div class="grid grid-cols-1 sm:grid-cols-3 text-center gap-4">
                <div class="p-3 bg-gray-50 dark:bg-gray-900/40 rounded-lg">
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Berat Badan</p>
                    <p class="text-xl font-semibold text-indigo-600 dark:text-indigo-300">{{ $weeklySummary['latest_weight'] }} kg</p>
                </div>
                <div class="p-3 bg-gray-50 dark:bg-gray-900/40 rounded-lg">
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Massa Otot</p>
                    <p class="text-xl font-semibold text-green-600 dark:text-green-300">{{ $weeklySummary['latest_muscle'] ?? '-' }} kg</p>
                </div>
                <div class="p-3 bg-gray-50 dark:bg-gray-900/40 rounded-lg">
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Lemak Tubuh</p>
                    <p class="text-xl font-semibold text-red-600 dark:text-red-300">{{ $weeklySummary['latest_body_fat'] ?? '-' }} %</p>
                </div>
            </div>
        @else
            <p class="text-gray-500 dark:text-gray-400 italic">Belum ada data progres minggu ini.</p>
        @endif
    </div>

    {{-- 🏋️ Workout List --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 mb-8">
        <h3 class="text-lg font-semibold text-indigo-700 dark:text-indigo-300 mb-4 flex items-center gap-2">
            🏋️ Jadwal Latihan Minggu Ini
        </h3>
        @if($workouts->isEmpty())
            <p class="text-gray-500 dark:text-gray-400 italic">Belum ada jadwal latihan minggu ini.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full border text-sm text-gray-900 dark:text-gray-100">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                        <tr>
                            <th class="p-2 text-left">Tanggal</th>
                            <th class="p-2 text-left">Workout</th>
                            <th class="p-2 text-center">Waktu</th>
                            <th class="p-2 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($workouts as $w)
                            <tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900 transition">
                                <td class="p-2">{{ \Carbon\Carbon::parse($w->scheduled_date)->format('d M Y') }}</td>
                                <td class="p-2">{{ $w->workout_name }}</td>
                                <td class="p-2 text-center">{{ $w->scheduled_time ?? '-' }}</td>
                                <td class="p-2 text-center">
                                    @if($w->status === 'completed')
                                        <span class="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 px-2 py-1 rounded text-xs">Selesai</span>
                                    @elseif($w->status === 'missed')
                                        <span class="bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 px-2 py-1 rounded text-xs">Terlewat</span>
                                    @else
                                        <span class="bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 px-2 py-1 rounded text-xs">Pending</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- 📅 Chart --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 mb-8">
        <h3 class="text-lg font-semibold text-indigo-700 dark:text-indigo-300 mb-3 flex items-center gap-2">
            📈 Tren Kalori Mingguan
        </h3>
        <canvas id="weeklyChart" height="120"></canvas>
    </div>

    {{-- 🔔 Weekly Summary Notification --}}
    <div class="bg-yellow-50 dark:bg-yellow-900 border-l-4 border-yellow-400 text-yellow-800 dark:text-yellow-200 p-4 rounded-lg">
        <div class="flex items-center gap-2">
            📬 <strong>Weekly Recap:</strong>
            <span>Evaluasi minggu ini dan tetap semangat untuk minggu berikutnya 💪</span>
        </div>
    </div>
</div>

{{-- ✅ Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const ctx = document.getElementById('weeklyChart');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
            datasets: [{
                label: 'Kalori (kcal)',
                data: [{{ implode(',', array_fill(0, 7, ($weeklySummary['total_calories'] ?? 0) / 7)) }}],
                borderColor: 'rgba(99,102,241,1)',
                backgroundColor: 'rgba(99,102,241,0.2)',
                borderWidth: 2,
                fill: true,
                tension: 0.3,
                pointBackgroundColor: 'rgba(99,102,241,1)'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            },
            scales: {
                y: { beginAtZero: true, title: { display: true, text: 'Kalori (kcal)' } }
            },
            animation: { duration: 1000, easing: 'easeOutQuart' }
        }
    });
});
</script>
@endsection
