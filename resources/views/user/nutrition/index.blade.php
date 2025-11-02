@extends('layouts.user')

@section('content')
    <div
        class="bg-black/70 backdrop-blur-lg border border-gray-700/50 shadow-sm sm:rounded-lg p-6 transition-all duration-300">

        {{-- ✅ Flash Message --}}
        @if(session('success'))
            <div class="bg-green-500/20 border border-green-500/50 text-green-300 px-4 py-3 rounded-lg mb-4">
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

        {{-- ✅ Info Kalori & Makronutrien --}}
        @php
            $totalCalories = $nutritions->sum('calories');
            $totalProtein = $nutritions->sum('protein');
            $totalCarbs = $nutritions->sum('carbs');
            $totalFat = $nutritions->sum('fat');

            $adminTargets = $adminTargets ?? [
                'calories' => 2000,
                'protein' => 150,
                'carbs' => 250,
                'fat' => 60
            ];

            $compare = fn($actual, $target) =>
                $actual > $target ? 'text-green-400' :
                ($actual == $target ? 'text-amber-400' : 'text-red-400');
        @endphp

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
            <x-nutri-card icon="🔥" label="Kalori Harian" value="{{ $totalCalories }}" unit="kcal"
                target="{{ $adminTargets['calories'] }}"
                color="{{ $compare($totalCalories, $adminTargets['calories']) }}" />
            <x-nutri-card icon="💪" label="Protein" value="{{ $totalProtein }}" unit="g"
                target="{{ $adminTargets['protein'] }}" color="{{ $compare($totalProtein, $adminTargets['protein']) }}" />
            <x-nutri-card icon="🍚" label="Karbohidrat" value="{{ $totalCarbs }}" unit="g"
                target="{{ $adminTargets['carbs'] }}" color="{{ $compare($totalCarbs, $adminTargets['carbs']) }}" />
            <x-nutri-card icon="🥑" label="Lemak" value="{{ $totalFat }}" unit="g" target="{{ $adminTargets['fat'] }}"
                color="{{ $compare($totalFat, $adminTargets['fat']) }}" />
        </div>

        {{-- ✅ Grafik Nutrisi --}}
        @php
            $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
            $chartData = $chartData ?? [
                'calories' => array_fill(0, 7, 0),
                'protein' => array_fill(0, 7, 0),
                'carbs' => array_fill(0, 7, 0),
                'fat' => array_fill(0, 7, 0),
            ];
        @endphp

        <div class="bg-gray-900/50 rounded-2xl border border-gray-700/50 p-6 mb-8">
            <h3 class="font-serif text-lg font-bold text-white mb-3 flex items-center gap-2">
                📊 Grafik Perbandingan <span class="text-amber-400">Asupan vs Target Admin</span>
            </h3>
            <div class="w-full overflow-x-auto">
                <canvas id="nutritionChart" height="120"></canvas>
            </div>
        </div>

        {{-- ✅ Tabel Nutrisi + Rekomendasi --}}
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

                    <div x-show="openDay === '{{ $day }}'" x-collapse class="p-4 bg-gray-900/30 space-y-3">
                        @if($dayMeals->isEmpty())
                            <p class="text-gray-400 italic">Belum ada menu untuk hari ini.</p>
                        @else
                            <div class="overflow-x-auto">
                                <table class="w-full border-separate border-spacing-0 text-sm">
                                    <thead class="bg-gray-800 text-gray-300">
                                        <tr>
                                            <th class="p-2 text-left">🍽️ Menu</th>
                                            <th class="p-2 text-center">🔥 Kalori</th>
                                            <th class="p-2 text-center">💪 Protein</th>
                                            <th class="p-2 text-center">🍚 Karbo</th>
                                            <th class="p-2 text-center">🥑 Lemak</th>
                                            <th class="p-2 text-center">⚙️ Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-300">
                                        @foreach ($dayMeals as $meal)
                                            <tr class="border-t border-gray-800/40 hover:bg-gray-800/30">
                                                {{-- ✅ Ubah name -> meal_name --}}
                                                <td class="p-2">{{ $meal->meal_name }}</td>
                                                <td class="p-2 text-center">{{ $meal->calories }}</td>
                                                <td class="p-2 text-center">{{ $meal->protein }}</td>
                                                <td class="p-2 text-center">{{ $meal->carbs }}</td>
                                                <td class="p-2 text-center">{{ $meal->fat }}</td>
                                                <td class="p-2 text-center">
                                                    <a href="{{ route('user.nutrition.edit', $meal->id) }}"
                                                        class="inline-flex items-center gap-1 px-3 py-1 text-xs font-bold rounded-md bg-blue-500/20 border border-blue-500/50 text-blue-300 hover:bg-blue-500/40 transition">
                                                        ✏️ Edit
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach

                                        @php
                                            $dayTotal = [
                                                'calories' => $dayMeals->sum('calories'),
                                                'protein' => $dayMeals->sum('protein'),
                                                'carbs' => $dayMeals->sum('carbs'),
                                                'fat' => $dayMeals->sum('fat'),
                                            ];

                                            $deficit = [
                                                'calories' => max(0, $adminTargets['calories'] - $dayTotal['calories']),
                                                'protein' => max(0, $adminTargets['protein'] - $dayTotal['protein']),
                                                'carbs' => max(0, $adminTargets['carbs'] - $dayTotal['carbs']),
                                                'fat' => max(0, $adminTargets['fat'] - $dayTotal['fat']),
                                            ];
                                        @endphp

                                        <tr>
                                            <td colspan="6" class="text-center p-3 bg-gray-800/30 text-sm">
                                                <strong>Perbandingan Target Admin:</strong><br>
                                                Kalori:
                                                <span class="{{ $compare($dayTotal['calories'], $adminTargets['calories']) }}">
                                                    {{ $dayTotal['calories'] }} / {{ $adminTargets['calories'] }}
                                                </span> • Protein:
                                                <span class="{{ $compare($dayTotal['protein'], $adminTargets['protein']) }}">
                                                    {{ $dayTotal['protein'] }} / {{ $adminTargets['protein'] }}
                                                </span> • Karbo:
                                                <span class="{{ $compare($dayTotal['carbs'], $adminTargets['carbs']) }}">
                                                    {{ $dayTotal['carbs'] }} / {{ $adminTargets['carbs'] }}
                                                </span> • Lemak:
                                                <span class="{{ $compare($dayTotal['fat'], $adminTargets['fat']) }}">
                                                    {{ $dayTotal['fat'] }} / {{ $adminTargets['fat'] }}
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            {{-- ✅ Rekomendasi Admin --}}
                            @if($deficit['calories'] > 0)
                                <div class="mt-4 bg-amber-500/10 border border-amber-400/40 text-amber-200 p-4 rounded-lg">
                                    <h4 class="font-bold mb-2">🍱 Rekomendasi Makanan Tambahan</h4>
                                    <ul class="list-disc list-inside space-y-1 text-sm">
                                        @if($deficit['protein'] > 0)
                                            <li>💪 Tambah protein: ayam dada, telur rebus, tahu/tempe, atau whey protein.</li>
                                        @endif
                                        @if($deficit['carbs'] > 0)
                                            <li>🍚 Tambah karbo: nasi merah, oats, kentang rebus, atau roti gandum.</li>
                                        @endif
                                        @if($deficit['fat'] > 0)
                                            <li>🥑 Tambah lemak sehat: alpukat, kacang almond, minyak zaitun, atau ikan salmon.</li>
                                        @endif
                                        <li>🔥 Kalorimu defisit {{ $deficit['calories'] }} kcal — bisa tambah porsi makan siang atau
                                            camilan sehat.</li>
                                    </ul>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- ✅ Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const ctx = document.getElementById('nutritionChart');
            if (!ctx) return;

            Chart.defaults.color = 'rgba(229, 231, 235, 0.7)';
            Chart.defaults.borderColor = 'rgba(156, 163, 175, 0.1)';

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($days),
                    datasets: [
                        { label: 'Protein (User)', data: @json($chartData['protein']), backgroundColor: '#22C55E' },
                        { label: 'Karbo (User)', data: @json($chartData['carbs']), backgroundColor: '#EAB308' },
                        { label: 'Lemak (User)', data: @json($chartData['fat']), backgroundColor: '#EF4444' },
                        {
                            type: 'line',
                            label: 'Kalori (User)',
                            data: @json($chartData['calories']),
                            borderColor: '#FBBF24',
                            borderWidth: 2,
                            fill: false,
                            tension: 0.3,
                            yAxisID: 'y1',
                        },
                        {
                            type: 'line',
                            label: 'Target Admin (Kalori)',
                            data: Array(@json($days).length).fill({{ $adminTargets['calories'] }}),
                            borderColor: '#3B82F6',
                            borderDash: [5, 5],
                            borderWidth: 2,
                            fill: false,
                            tension: 0,
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
                    plugins: { legend: { position: 'bottom' } },
                }
            });
        });
    </script>
@endsection