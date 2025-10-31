@extends('layouts.user')

@section('content')
<div class="bg-white shadow-md rounded-xl p-6">
    <h3 class="text-xl font-semibold mb-4">Welcome, {{ $user->name }} 👋</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
        <div class="bg-gray-50 border rounded-xl p-4">
            <h5 class="font-semibold mb-2">My Progress</h5>
            <canvas id="progressChart"></canvas>
        </div>
        <div class="bg-gray-50 border rounded-xl p-4">
            <h5 class="font-semibold mb-2">Protein Tracker</h5>
            <p>Kebutuhan harian: <b>{{ $proteinNeed }} gram</b></p>
        </div>
    </div>

    <div class="mt-6 bg-gray-50 border rounded-xl p-4">
        <h5 class="font-semibold mb-2">Workout Plans</h5>
        <ul class="list-disc ml-5">
            @forelse($workouts as $w)
                <li>{{ $w->title }} - <span class="text-sm text-gray-500">Level: {{ $w->level }}</span></li>
            @empty
                <p class="text-gray-500">Belum ada workout plan.</p>
            @endforelse
        </ul>
    </div>

    <div class="mt-6 bg-gray-50 border rounded-xl p-4">
        <h5 class="font-semibold mb-2">Nutrition Plans</h5>
        <ul class="list-disc ml-5">
            @forelse($nutritions as $n)
                <li>{{ $n->title }} ({{ $n->calories }} kcal)</li>
            @empty
                <p class="text-gray-500">Belum ada nutrition plan.</p>
            @endforelse
        </ul>
    </div>

    <div class="mt-6 bg-gray-50 border rounded-xl p-4">
        <h5 class="font-semibold mb-2">Tips & Articles</h5>
        <ul class="list-disc ml-5">
            @forelse($articles as $a)
                <li><a href="{{ route('user.articles.show', $a->id) }}" class="text-indigo-600 hover:underline">{{ $a->title }}</a></li>
            @empty
                <p class="text-gray-500">Belum ada artikel.</p>
            @endforelse
        </ul>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('progressChart');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: @json($progress->pluck('recorded_at')->map(fn($d)=>date('d M', strtotime($d)))),
        datasets: [
            { label: 'Berat Badan (kg)', data: @json($progress->pluck('weight')), borderColor: 'rgb(99,102,241)', borderWidth: 2 },
            { label: 'Massa Otot (kg)', data: @json($progress->pluck('muscle_mass')), borderColor: 'rgb(34,197,94)', borderWidth: 2 }
        ]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
});
</script>
@endsection
