@extends('layouts.user')

@section('content')
    <div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 shadow-sm sm:rounded-lg p-6 transition-all duration-300">

        {{-- ✅ Flash Message (Style "Dark Premium") --}}
        @if(session('success'))
            <div
                class="bg-green-500/20 border border-green-500/50 text-green-300 px-4 py-3 rounded-lg mb-4">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-5 gap-3">
            <h2 class="font-serif text-2xl font-bold text-white flex items-center gap-2">
                🥗 Nutrition & <span class="text-amber-400">Protein Tracker</span>
            </h2>
            <a href="{{ route('user.nutrition.create') }}"
                class="px-5 py-2.5 rounded-md text-sm font-bold text-black bg-amber-400 hover:bg-amber-300 transition-all shadow-lg shadow-amber-500/20">
                + Tambah Menu
            </a>
        </div>

        {{-- ✅ Info Kalori & Makronutrien (Style "Dark Premium" Editorial) --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
            <div class="relative bg-gray-900/50 border border-gray-700/50 rounded-lg p-4 text-center overflow-hidden">
                <div class="absolute -left-2 -bottom-2 font-serif text-6xl font-bold text-gray-800/50 z-0 opacity-50">🔥</div>
                <div class="relative z-10">
                    <p class="text-gray-400 text-sm">Kalori Harian</p>
                    <p class="text-2xl font-bold text-amber-400">{{ $calorieNeeds ?? 0 }} kcal</p>
                </div>
            </div>
            <div class="relative bg-gray-900/50 border border-gray-700/50 rounded-lg p-4 text-center overflow-hidden">
                <div class="absolute -left-2 -bottom-2 font-serif text-6xl font-bold text-gray-800/50 z-0 opacity-50">💪</div>
                <div class="relative z-10">
                    <p class="text-gray-400 text-sm">Protein</p>
                    <p class="text-2xl font-bold text-green-400">{{ $macroNeeds['protein'] ?? 0 }} g</p>
                </div>
            </div>
            <div class="relative bg-gray-900/50 border border-gray-700/50 rounded-lg p-4 text-center overflow-hidden">
                <div class="absolute -left-2 -bottom-2 font-serif text-6xl font-bold text-gray-800/50 z-0 opacity-50">🍚</div>
                <div class="relative z-10">
                    <p class="text-gray-400 text-sm">Karbohidrat</p>
                    <p class="text-2xl font-bold text-yellow-400">{{ $macroNeeds['carbs'] ?? 0 }} g</p>
                </div>
            </div>
            <div class="relative bg-gray-900/50 border border-gray-700/50 rounded-lg p-4 text-center overflow-hidden">
                <div class="absolute -left-2 -bottom-2 font-serif text-6xl font-bold text-gray-800/50 z-0 opacity-50">🥑</div>
                <div class="relative z-10">
                    <p class="text-gray-400 text-sm">Lemak</p>
                    <p class="text-2xl font-bold text-red-400">{{ $macroNeeds['fat'] ?? 0 }} g</p>
                </div>
            </div>
        </div>

        {{-- ✅ Grafik Nutrisi Mingguan (Style "Dark Premium") --}}
        <div class="bg-gray-900/50 rounded-2xl border border-gray-700/50 p-6 mb-8">
            <h3 class="font-serif text-lg font-bold text-white mb-3 flex items-center gap-2">
                📊 Grafik Asupan <span class="text-amber-400">Nutrisi Mingguan</span>
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
            <div class="mt-5 text-sm text-gray-400 text-center">
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

                <div class="border border-gray-700/50 rounded-lg overflow-hidden">
                    <button
                        class="w-full flex justify-between items-center bg-gray-900/50 px-4 py-3 text-left text-amber-400 font-semibold transition-all hover:bg-gray-800"
                        @click="openDay === '{{ $day }}' ? openDay = null : openDay = '{{ $day }}'">
                        <span>📅 {{ $day }}</span>
                        <span x-show="openDay !== '{{ $day }}'" class="transform transition-transform">▼</span>
                        <span x-show="openDay === '{{ $day }}'" class="transform transition-transform rotate-180">▲</span>
                    </button>

                    <div x-show="openDay === '{{ $day }}'" x-collapse class="p-4 bg-gray-900/30">
                        @if($dayMeals->isEmpty())
                            <p class="text-gray-400 italic">Belum ada menu untuk hari ini.</p>
                        @else
                            <div class="overflow-x-auto">
                                <table class="w-full border-separate border-spacing-0 text-sm">
                                    <thead class="bg-gray-800 text-gray-300">
                                        <tr>
                                            <th class="p-2 text-left rounded-tl-lg">🍽️ Menu</th>
                                            <th class="p-2 text-center">🔥 Kalori</th>
                                            <th class="p-2 text-center">💪 Protein</th>
                                            <th class="p-2 text-center">🍚 Karbo</th>
                                            <th class="p-2 text-center">🥑 Lemak</th>
                                            <th class="p-2 text-center">🕒 Jenis</th>
                                            <th class="p-2 text-center rounded-tr-lg">⚙️ Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-300">
                                        @foreach ($dayMeals as $meal)
                                            <tr
                                                class="hover:bg-gray-800/50 transition-colors">
                                                <td class="p-2 font-medium border-t border-gray-700/50 text-white">{{ $meal->meal_name }}</td>
                                                <td class="p-2 text-center font-semibold text-amber-400 border-t border-gray-700/50">
                                                    {{ $meal->calories }} kcal</td>
                                                <td class="p-2 text-center font-semibold text-green-400 border-t border-gray-700/50">
                                                    {{ $meal->protein }} g</td>
                                                <td class="p-2 text-center font-semibold text-yellow-400 border-t border-gray-700/50">
                                                    {{ $meal->carbs }} g</td>
                                                <td class="p-2 text-center font-semibold text-red-400 border-t border-gray-700/50">
                                                    {{ $meal->fat }} g</td>
                                                <td class="p-2 text-center capitalize text-purple-400 border-t border-gray-700/50">
                                                    {{ $meal->type ?? '-' }}</td>
                                                <td class="p-2 text-center border-t border-gray-700/50">
                                                    <a href="{{ route('user.nutrition.edit', $meal->id) }}"
                                                        class="inline-block text-amber-400 font-semibold hover:underline">
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

    {{-- ✅ Reminder Card (Style "Dark Premium") --}}
    <div
        class="bg-amber-900/50 border-l-4 border-amber-400 text-amber-200 p-4 mt-6 rounded-lg">
        <div class="flex items-center gap-2">
            🍽️ <strong class="text-amber-300">Nutrition Reminder:</strong>
            <span>Pastikan kamu sudah penuhi target protein & kalori harianmu 💪</span>
        </div>
    </div>

    {{-- ✅ Scripts (HANYA MENGUBAH WARNA CHART) --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Opsi Tema "Dark Premium" untuk Chart
            Chart.defaults.color = 'rgba(229, 231, 235, 0.7)'; // Teks abu-abu
            Chart.defaults.borderColor = 'rgba(156, 163, 175, 0.1)'; // Garis grid transparan

            const ctx = document.getElementById('nutritionChart');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($days),
                    datasets: [
                        // WARNA DISESUAIKAN
                        { label: 'Protein (g)', data: @json($chartData['protein']), backgroundColor: '#22C55E' }, // Hijau
                        { label: 'Karbo (g)', data: @json($chartData['carbs']), backgroundColor: '#EAB308' }, // Kuning
                        { label: 'Lemak (g)', data: @json($chartData['fat']), backgroundColor: '#EF4444' }, // Merah
                        {
                            type: 'line',
                            label: 'Kalori (kcal)',
                            data: @json($days ? collect($days)->map(fn($d) => $nutritions->where('day_of_week', $d)->sum('calories')) : []),
                            borderColor: '#FBBF24', // EMAS (Amber-400)
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
                        y: {
                            beginAtZero: true,
                            title: { display: true, text: 'Makronutrien (g)', color: '#9CA3AF' },
                            ticks: { color: '#9CA3AF' }
                        },
                        y1: {
                            beginAtZero: true,
                            position: 'right',
                            grid: { drawOnChartArea: false },
                            title: { display: true, text: 'Kalori (kcal)', color: '#FBBF24' },
                            ticks: { color: '#FBBF24' }
                        }
                    },
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
                    animation: { duration: 1000, easing: 'easeOutQuart' }
                }
            });
        });
    </script>
@endsection
