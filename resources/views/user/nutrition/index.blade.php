@extends('layouts.user')

@section('content')
<div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 shadow-sm sm:rounded-lg p-6 transition-all duration-300">

    {{-- ✅ Flash Message --}}
    @if(session('success'))
        <div class="bg-green-500/20 border border-green-500/50 text-green-300 px-4 py-3 rounded-lg mb-4 animate-pulse">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- ✅ Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-5 gap-3">
        <h2 class="font-serif text-2xl font-bold text-white flex items-center gap-2">
            🥗 Nutrition & <span class="text-amber-400">Protein Tracker</span>
        </h2>
        <a href="{{ route('user.nutrition.create') }}"
           class="px-5 py-2.5 rounded-md text-sm font-bold text-black bg-amber-400 hover:bg-amber-300 transition-all shadow-lg shadow-amber-500/20">
            + Tambah Menu
        </a>
    </div>

    {{-- ✅ Pilih Hari --}}
    <div class="flex justify-center mb-6 flex-wrap gap-2">
        @foreach ($days as $day)
            <a href="{{ route('user.nutrition.index', ['day' => $day]) }}"
               class="px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-200
                      {{ $selectedDay == $day ? 'bg-blue-600 text-white' : 'bg-gray-800 text-gray-300 hover:bg-gray-700' }}">
                {{ $day }}
            </a>
        @endforeach
    </div>

    {{-- ✅ Info Kalori & Makronutrien --}}
    @php
        $compare = fn($actual, $target) =>
            $actual > $target ? 'text-green-400' :
            ($actual == $target ? 'text-amber-400' : 'text-red-400');
    @endphp

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
        <x-nutri-card icon="🔥" label="Kalori Harian"
            value="{{ $dailyTotals['calories'] ?? 0 }}" unit="kcal"
            target="{{ $adminTargets['calories'] ?? 0 }}"
            color="{{ $compare($dailyTotals['calories'] ?? 0, $adminTargets['calories'] ?? 0) }}" />

        <x-nutri-card icon="💪" label="Protein"
            value="{{ $dailyTotals['protein'] ?? 0 }}" unit="g"
            target="{{ $adminTargets['protein'] ?? 0 }}"
            color="{{ $compare($dailyTotals['protein'] ?? 0, $adminTargets['protein'] ?? 0) }}" />

        <x-nutri-card icon="🍚" label="Karbohidrat"
            value="{{ $dailyTotals['carbs'] ?? 0 }}" unit="g"
            target="{{ $adminTargets['carbs'] ?? 0 }}"
            color="{{ $compare($dailyTotals['carbs'] ?? 0, $adminTargets['carbs'] ?? 0) }}" />

        <x-nutri-card icon="🥑" label="Lemak"
            value="{{ $dailyTotals['fat'] ?? 0 }}" unit="g"
            target="{{ $adminTargets['fat'] ?? 0 }}"
            color="{{ $compare($dailyTotals['fat'] ?? 0, $adminTargets['fat'] ?? 0) }}" />
    </div>

    {{-- ✅ Info Progress Log --}}
    @if(!empty($latestProgress))
        <div class="bg-gray-900/50 border border-gray-700/50 rounded-xl p-4 mb-6">
            <p class="text-gray-300 text-sm leading-relaxed">
                📅 Log terakhir:
                <strong>{{ \Carbon\Carbon::parse($latestProgress->log_date)->translatedFormat('d F Y') }}</strong><br>
                Kalori dikonsumsi:
                <span class="text-amber-300">{{ $latestProgress->calories_consumed ?? 0 }} kcal</span>,
                Protein:
                <span class="text-amber-300">{{ $latestProgress->protein_consumed ?? 0 }} g</span>
            </p>
        </div>
    @endif

    {{-- ✅ Grafik Nutrisi --}}
    <div class="bg-gray-900/50 rounded-2xl border border-gray-700/50 p-6 mb-8">
        <h3 class="font-serif text-lg font-bold text-white mb-3 flex items-center gap-2">
            📊 Grafik Nutrisi Hari <span class="text-amber-400">{{ $selectedDay }}</span>
        </h3>
        <div class="w-full overflow-x-auto">
            <canvas id="nutritionChart" height="120"></canvas>
        </div>
    </div>

    {{-- ✅ Tabel Nutrisi --}}
    <div class="border border-gray-700/50 rounded-lg overflow-hidden">
        <div class="bg-gray-900/50 px-4 py-3 text-amber-400 font-semibold">
            📅 {{ $selectedDay }}
        </div>

        <div class="p-4 bg-gray-900/30 space-y-3">
            @if($nutritions->isEmpty())
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
                            @foreach ($nutritions as $meal)
                                <tr class="border-t border-gray-800/40 hover:bg-gray-800/30 transition-colors duration-200">
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
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    {{-- ✅ Rekomendasi Harian --}}
    @php
        $deficit = [
            'calories' => max(0, ($adminTargets['calories'] ?? 0) - ($dailyTotals['calories'] ?? 0)),
            'protein'  => max(0, ($adminTargets['protein']  ?? 0) - ($dailyTotals['protein']  ?? 0)),
            'carbs'    => max(0, ($adminTargets['carbs']    ?? 0) - ($dailyTotals['carbs']    ?? 0)),
            'fat'      => max(0, ($adminTargets['fat']      ?? 0) - ($dailyTotals['fat']      ?? 0)),
        ];
    @endphp

    @if($deficit['calories'] > 0)
        <div class="mt-6 bg-amber-500/10 border border-amber-400/40 text-amber-200 p-4 rounded-lg animate-fade-in">
            <h4 class="font-bold mb-2">🍱 Rekomendasi Makanan Tambahan</h4>
            <ul class="list-disc list-inside space-y-1 text-sm leading-relaxed">
                @if($deficit['protein'] > 0)
                    <li>💪 Tambah protein: ayam dada, telur rebus, tahu/tempe, atau whey protein.</li>
                @endif
                @if($deficit['carbs'] > 0)
                    <li>🍚 Tambah karbo: nasi merah, oats, kentang rebus, atau roti gandum.</li>
                @endif
                @if($deficit['fat'] > 0)
                    <li>🥑 Tambah lemak sehat: alpukat, kacang almond, minyak zaitun, atau ikan salmon.</li>
                @endif
                <li>🔥 Kalorimu defisit {{ $deficit['calories'] }} kcal — tambahkan porsi makan siang atau camilan sehat.</li>
            </ul>
        </div>
    @endif
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
            labels: @json($chartData['labels'] ?? []),
            datasets: [{
                label: 'Asupan Hari Ini',
                data: @json($chartData['values'] ?? []),
                backgroundColor: ['#FBBF24', '#22C55E', '#EAB308', '#EF4444'],
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true } },
            plugins: { legend: { display: false } }
        }
    });
});
</script>
@endsection
