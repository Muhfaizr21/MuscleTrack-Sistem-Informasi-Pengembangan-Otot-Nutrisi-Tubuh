@extends('layouts.user')

@section('content')
<div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 shadow-sm sm:rounded-lg p-6">

    <h3 class="font-serif text-2xl font-bold text-white mb-4">
        Welcome, <span class="text-amber-400">{{ $user->name }}</span> 👋
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">

        <div class="bg-gray-900/50 border border-gray-700/50 rounded-xl p-4">
            <h5 class="font-serif text-lg font-bold text-white mb-2">My Progress</h5>
            <canvas id="progressChart"></canvas>
        </div>

        <div class="bg-gray-900/50 border border-gray-700/50 rounded-xl p-4">
            <h5 class="font-serif text-lg font-bold text-white mb-2">Protein Tracker</h5>
            <p class="text-gray-300">Kebutuhan harian:</p>
            <p class="text-amber-400 text-3xl font-bold">{{ $proteinNeed }} <span class="text-xl text-gray-400 font-medium">gram</span></p>
        </div>
    </div>

    <div class="mt-6 bg-gray-900/50 border border-gray-700/50 rounded-xl p-4">
        <h5 class="font-serif text-lg font-bold text-white mb-2">Workout Plans</h5>
        <ul class="list-disc ml-5 space-y-1">
            @forelse($workouts as $w)
                <li class="text-gray-300">{{ $w->title }} - <span class="text-sm text-gray-400">Level: {{ $w->level }}</span></li>
            @empty
                <p class="text-gray-400 italic">Belum ada workout plan.</p>
            @endforelse
        </ul>
    </div>

    <div class="mt-6 bg-gray-900/50 border border-gray-700/50 rounded-xl p-4">
        <h5 class="font-serif text-lg font-bold text-white mb-2">Nutrition Plans</h5>
        <ul class="list-disc ml-5 space-y-1">
            @forelse($nutritions as $n)
                <li class="text-gray-300">{{ $n->title }} ({{ $n->calories }} kcal)</li>
            @empty
                <p class="text-gray-400 italic">Belum ada nutrition plan.</p>
            @endforelse
        </ul>
    </div>

    <div class="mt-6 bg-gray-900/50 border border-gray-700/50 rounded-xl p-4">
        <h5 class="font-serif text-lg font-bold text-white mb-2">Tips & Articles</h5>
        <ul class="list-disc ml-5 space-y-1">
            @forelse($articles as $a)
                <li><a href="{{ route('user.articles.show', $a->id) }}" class="text-amber-400 hover:text-amber-300 hover:underline">{{ $a->title }}</a></li>
            @empty
                <p class="text-gray-400 italic">Belum ada artikel.</p>
            @endforelse
        </ul>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Opsi Tema "Dark Premium" untuk Chart
    Chart.defaults.color = 'rgba(229, 231, 235, 0.7)'; // Teks abu-abu
    Chart.defaults.borderColor = 'rgba(156, 163, 175, 0.1)'; // Garis grid transparan

    const ctx = document.getElementById('progressChart');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($progress->pluck('recorded_at')->map(fn($d)=>date('d M', strtotime($d)))),
            datasets: [
                {
                    label: 'Berat Badan (kg)',
                    data: @json($progress->pluck('weight')),
                    borderColor: '#FBBF24', // WARNA EMAS (Amber-400)
                    borderWidth: 2,
                    tension: 0.3,
                    pointBackgroundColor: '#FBBF24'
                },
                {
                    label: 'Massa Otot (kg)',
                    data: @json($progress->pluck('muscle_mass')),
                    borderColor: '#A78BFA', // WARNA UNGU (Kontras)
                    borderWidth: 2,
                    tension: 0.3,
                    pointBackgroundColor: '#A78BFA'
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom', labels: { color: '#D1D5DB' } }
            },
            scales: {
                y: {
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
@endsection
