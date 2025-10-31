@extends('layouts.user')

@section('content')
<div class="bg-white shadow-md rounded-2xl p-6 max-w-xl mx-auto">
    <h2 class="text-xl font-semibold mb-4 text-indigo-700">Edit Progress</h2>

    <form action="{{ route('user.progress.update', 1) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Berat (kg)</label>
            <input type="number" step="0.1" name="weight" value="70" class="w-full border p-2 rounded-lg">
        </div>
        <div class="mb-3">
            <label>Massa Otot (kg)</label>
            <input type="number" step="0.1" name="muscle_mass" value="30" class="w-full border p-2 rounded-lg">
        </div>
        <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg">Perbarui</button>
    </form>
</div>
@endsection
