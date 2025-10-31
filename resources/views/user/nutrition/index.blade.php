@extends('layouts.user')

@section('content')
    <div class="bg-white dark:bg-gray-900 shadow-md rounded-2xl p-6 transition-all duration-300">

        {{-- ✅ Flash Message --}}
        @if(session('success'))
            <div
                class="bg-green-100 dark:bg-green-900 border border-green-400 text-green-800 dark:text-green-100 px-4 py-3 rounded-lg mb-4">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-5 gap-3">
            <h2 class="text-2xl font-semibold text-indigo-700 dark:text-indigo-400 flex items-center gap-2">
                🥗 Nutrition & Protein Tracker
            </h2>
            <a href="{{ route('user.nutrition.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition">
                + Tambah Menu
            </a>
        </div>

        {{-- ✅ Info Kalori & Makronutrien --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
            <div class="bg-indigo-50 dark:bg-indigo-900/30 p-4 rounded-lg text-center">
                <p class="text-gray-500 dark:text-gray-400 text-sm">Kalori Harian</p>
                <p class="text-2xl font-semibold text-indigo-700 dark:text-indigo-300">{{ $calorieNeeds ?? 0 }} kcal</p>
            </div>
            <div class="bg-green-50 dark:bg-green-900/30 p-4 rounded-lg text-center">
                <p class="text-gray-500 dark:text-gray-400 text-sm">Protein</p>
                <p class="text-2xl font-semibold text-green-700 dark:text-green-300">{{ $macroNeeds['protein'] ?? 0 }} g</p>
            </div>
            <div class="bg-yellow-50 dark:bg-yellow-900/30 p-4 rounded-lg text-center">
                <p class="text-gray-500 dark:text-gray-400 text-sm">Karbohidrat</p>
                <p class="text-2xl font-semibold text-yellow-700 dark:text-yellow-300">{{ $macroNeeds['carbs'] ?? 0 }} g</p>
            </div>
            <div class="bg-red-50 dark:bg-red-900/30 p-4 rounded-lg text-center">
                <p class="text-gray-500 dark:text-gray-400 text-sm">Lemak</p>
                <p class="text-2xl font-semibold text-red-700 dark:text-red-300">{{ $macroNeeds['fat'] ?? 0 }} g</p>
            </div>
        </div>

        {{-- ✅ Grafik Nutrisi Mingguan --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 mb-8">
            <h3 class="text-lg font-semibold text-indigo-700 dark:text-indigo-300 mb-3 flex items-center gap-2">
                📊 Grafik Asupan Nutrisi Mingguan
            </h3>
            <div class="w-full overflow-x-auto">
                <canvas id="nutritionChart" height="120"></canvas>
            </div>

            @php
                $totalCalories = $nutritions->sum('calories');
                $totalProtein = $nutritions->sum('protein');
                $totalCarbs = $nutritions->sum('carbs');
                $totalFat = $nutritions->sum('fat');
            @endphp
            <div class="mt-5 text-sm text-gray-600 dark:text-gray-300 text-center">
                <strong>📆 Total Mingguan:</strong>
                {{ $totalCalories }} kcal • Protein: {{ $totalProtein }} g • Karbo: {{ $totalCarbs }} g • Lemak:
                {{ $totalFat }} g
            </div>
        </div>

        {{-- ✅ Tabel Nutrisi Harian --}}
        @php $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']; @endphp

        <div x-data="{ openDay: null }" class="space-y-4">
            @foreach ($days as $day)
                @php $dayMeals = $nutritions->where('day_of_week', $day); @endphp

                <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                    <button
                        class="w-full flex justify-between items-center bg-gray-50 dark:bg-gray-800 px-4 py-3 text-left text-indigo-700 dark:text-indigo-300 font-semibold"
                        @click="openDay === '{{ $day }}' ? openDay = null : openDay = '{{ $day }}'">
                        <span>📅 {{ $day }}</span>
                        <span x-show="openDay !== '{{ $day }}'">▼</span>
                        <span x-show="openDay === '{{ $day }}'">▲</span>
                    </button>

                    <div x-show="openDay === '{{ $day }}'" x-collapse class="p-4 bg-white dark:bg-gray-900">
                        @if($dayMeals->isEmpty())
                            <p class="text-gray-500 dark:text-gray-400 italic">Belum ada menu untuk hari ini.</p>
                        @else
                            <div class="overflow-x-auto">
                                <table class="w-full border text-sm">
                                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                                        <tr>
                                            <th class="p-2 text-left">🍽️ Menu</th>
                                            <th class="p-2 text-center">🔥 Kalori</th>
                                            <th class="p-2 text-center">💪 Protein</th>
                                            <th class="p-2 text-center">🍚 Karbo</th>
                                            <th class="p-2 text-center">🥑 Lemak</th>
                                            <th class="p-2 text-center">🕒 Jenis</th>
                                            <th class="p-2 text-center">⚙️ Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="dark:bg-gray-800 dark:text-gray-100 text-gray-700">
                                        @foreach ($dayMeals as $meal)
                                            <tr
                                                class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                                <td class="p-2 font-medium">{{ $meal->meal_name }}</td>
                                                <td class="p-2 text-center font-semibold text-orange-600 dark:text-orange-400">
                                                    {{ $meal->calories }} kcal</td>
                                                <td class="p-2 text-center font-semibold text-green-600 dark:text-green-400">
                                                    {{ $meal->protein }} g</td>
                                                <td class="p-2 text-center font-semibold text-yellow-600 dark:text-yellow-400">
                                                    {{ $meal->carbs }} g</td>
                                                <td class="p-2 text-center font-semibold text-pink-600 dark:text-pink-400">
                                                    {{ $meal->fat }} g</td>
                                                <td class="p-2 text-center capitalize text-indigo-700 dark:text-indigo-300">
                                                    {{ $meal->type ?? '-' }}</td>
                                                <td class="p-2 text-center">
                                                    <a href="{{ route('user.nutrition.edit', $meal->id) }}"
                                                        class="inline-block text-indigo-600 dark:text-indigo-400 font-semibold hover:underline">
                                                        ✏️ Edit
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- ✅ Reminder Card --}}
    <div
        class="bg-yellow-50 dark:bg-yellow-900 border-l-4 border-yellow-400 text-yellow-800 dark:text-yellow-200 p-4 mt-6 rounded-lg">
        <div class="flex items-center gap-2">
            🍽️ <strong>Nutrition Reminder:</strong>
            <span>Pastikan kamu sudah penuhi target protein & kalori harianmu 💪</span>
        </div>
    </div>

    {{-- ✅ Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const ctx = document.getElementById('nutritionChart');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($days),
                    datasets: [
                        { label: 'Protein (g)', data: @json($chartData['protein']), backgroundColor: 'rgba(34,197,94,0.8)' },
                        { label: 'Karbo (g)', data: @json($chartData['carbs']), backgroundColor: 'rgba(250,204,21,0.8)' },
                        { label: 'Lemak (g)', data: @json($chartData['fat']), backgroundColor: 'rgba(239,68,68,0.8)' },
                        {
                            type: 'line',
                            label: 'Kalori (kcal)',
                            data: @json($days ? collect($days)->map(fn($d) => $nutritions->where('day_of_week', $d)->sum('calories')) : []),
                            borderColor: 'rgba(99,102,241,1)',
                            borderWidth: 2,
                            fill: false,
                            tension: 0.3,
                            yAxisID: 'y1',
                        }
                    ]
                },
                options: {
                    responsive: true,
                    interaction: { mode: 'index', intersect: false },
                    scales: {
                        y: { beginAtZero: true, title: { display: true, text: 'Makronutrien (g)' } },
                        y1: { beginAtZero: true, position: 'right', grid: { drawOnChartArea: false }, title: { display: true, text: 'Kalori (kcal)' } }
                    },
                    plugins: {
                        legend: { position: 'bottom' },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: '#6366f1',
                            borderWidth: 1
                        }
                    },
                    animation: { duration: 1000, easing: 'easeOutQuart' }
                }
            });
        });
    </script>
@endsection