@extends('layouts.trainer')

@section('title', 'Edit Program Member')

@section('content')
<div class="bg-white shadow rounded-2xl p-6">
    <h1 class="text-2xl font-bold mb-4">🏋️ Edit Program & Nutrition - {{ $member->name }}</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-2 rounded mb-4">
            ✅ {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('trainer.programs.update', $member->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PATCH')

        {{-- Workout Section --}}
        <div>
            <h2 class="text-xl font-semibold text-blue-700 mb-3">🏋️ Workout Plan</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input label="Nama Program" name="workout_name" value="{{ old('workout_name', $workoutPlan->name ?? '') }}" />
                <x-input label="Intensitas" name="intensity" value="{{ old('intensity', $workoutPlan->intensity ?? '') }}" />
                <x-input label="Durasi (menit)" type="number" name="duration" value="{{ old('duration', $workoutPlan->duration ?? '') }}" />
                <x-input label="Repetisi" type="number" name="repetitions" value="{{ old('repetitions', $workoutPlan->repetitions ?? '') }}" />
            </div>
        </div>

        {{-- Nutrition Section --}}
        <div>
            <h2 class="text-xl font-semibold text-green-700 mb-3">🥗 Nutrition Plan</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <x-input label="Kalori (kcal)" type="number" name="calories" value="{{ old('calories', $nutritionPlan->calories ?? '') }}" />
                <x-input label="Protein (gr)" type="number" name="protein" value="{{ old('protein', $nutritionPlan->protein ?? '') }}" />
                <x-input label="Karbohidrat (gr)" type="number" name="carbs" value="{{ old('carbs', $nutritionPlan->carbs ?? '') }}" />
                <x-input label="Lemak (gr)" type="number" name="fat" value="{{ old('fat', $nutritionPlan->fat ?? '') }}" />
            </div>
        </div>

        <div class="pt-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                💾 Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
