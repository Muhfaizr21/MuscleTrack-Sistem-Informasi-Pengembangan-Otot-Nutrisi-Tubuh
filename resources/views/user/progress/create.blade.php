@extends('layouts.user')

@section('content')
<div class="bg-white shadow-md rounded-2xl p-6 max-w-xl mx-auto">
    <h2 class="text-xl font-semibold mb-4 text-indigo-700">Tambah Progress</h2>

    <form action="{{ route('user.progress.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Berat (kg)</label>
            <input type="number" step="0.1" name="weight" class="w-full border p-2 rounded-lg" required>
        </div>
        <div class="mb-3">
            <label>Massa Otot (kg)</label>
            <input type="number" step="0.1" name="muscle_mass" class="w-full border p-2 rounded-lg" required>
        </div>
        <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="recorded_at" class="w-full border p-2 rounded-lg" required>
        </div>

        <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg">Simpan</button>
    </form>
</div>
@endsection
