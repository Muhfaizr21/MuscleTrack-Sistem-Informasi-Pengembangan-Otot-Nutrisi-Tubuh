@extends('layouts.trainer')

@section('title', 'Detail Member')

@section('content')
<h1 class="text-2xl font-bold mb-4">📈 Aktivitas Member: {{ $member->name }}</h1>

{{-- Tambah Log --}}
<div class="bg-white p-5 rounded-lg shadow mb-6">
    <h2 class="text-lg font-semibold mb-3">Tambah Log Aktivitas</h2>
    <form method="POST" action="{{ route('trainer.members.updateProgress', $member->id) }}">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <input type="date" name="log_date" class="p-2 border rounded" required>
            <input type="number" step="0.1" name="calories_consumed" placeholder="Kalori (kkal)" class="p-2 border rounded">
            <input type="number" step="0.1" name="protein_consumed" placeholder="Protein (g)" class="p-2 border rounded">
            <input type="number" step="0.1" name="carbs_consumed" placeholder="Karbohidrat (g)" class="p-2 border rounded">
            <input type="number" step="0.1" name="fat_consumed" placeholder="Lemak (g)" class="p-2 border rounded">
        </div>
        <textarea name="notes" rows="3" class="w-full mt-3 border rounded p-2" placeholder="Catatan tambahan..."></textarea>
        <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Simpan Log
        </button>
    </form>
</div>

{{-- Daftar Log Aktivitas --}}
<div class="bg-white p-5 rounded-lg shadow">
    <h2 class="text-lg font-semibold mb-3">Log Aktivitas Terbaru</h2>
    @forelse($progressLogs as $log)
        <div class="border-b py-2">
            <p class="font-medium text-gray-800">{{ $log->log_date->format('d M Y') }}</p>
            <p class="text-gray-700 text-sm">
                Kalori: {{ $log->calories_consumed ?? '-' }} | 
                Protein: {{ $log->protein_consumed ?? '-' }} | 
                Karbo: {{ $log->carbs_consumed ?? '-' }} | 
                Lemak: {{ $log->fat_consumed ?? '-' }}
            </p>
            @if($log->notes)
                <p class="text-gray-600 italic mt-1">📝 {{ $log->notes }}</p>
            @endif
        </div>
    @empty
        <p class="text-gray-500">Belum ada log aktivitas.</p>
    @endforelse
</div>
@endsection
