@extends('layouts.user')

@section('content')
<div class="bg-white shadow-md rounded-2xl p-6">
    <h2 class="text-xl font-semibold text-indigo-700 mb-4">📅 Weekly Summary</h2>

    <p>Total Minggu Ini:</p>
    <ul class="list-disc ml-5">
        <li>Kalori: <b>{{ $totalCalories }}</b></li>
        <li>Protein: <b>{{ $totalProtein }} g</b></li>
        <li>Karbo: <b>{{ $totalCarbs }} g</b></li>
        <li>Lemak: <b>{{ $totalFat }} g</b></li>
    </ul>

    <table class="w-full border mt-4">
        <thead class="bg-gray-100">
            <tr><th>Tanggal</th><th>Kalori</th><th>Protein</th><th>Karbo</th><th>Lemak</th></tr>
        </thead>
        <tbody>
            @forelse($weekLogs as $log)
                <tr class="border-t"><td class="p-2">{{ $log->log_date }}</td></tr>
            @empty
                <tr><td colspan="5" class="text-center text-gray-500 p-3">Belum ada data minggu ini.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
