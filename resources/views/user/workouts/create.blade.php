@extends('layouts.user')

@section('content')
    <div class="bg-white shadow-md rounded-2xl p-6 max-w-xl mx-auto">
        <h2 class="text-xl font-semibold text-indigo-700 mb-4 flex items-center gap-2">
            🕒 Atur Jadwal Workout
        </h2>

        <form action="{{ route('user.workouts.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Workout --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1">Pilih Workout</label>
                <select name="workout_id" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-indigo-500" required>
                    <option value="">-- Pilih Workout --</option>
                    @foreach($workouts as $w)
                        <option value="{{ $w->id }}"
                            {{ isset($selectedWorkout) && $selectedWorkout->id == $w->id ? 'selected' : '' }}>
                            {{ $w->title }} ({{ ucfirst($w->difficulty_level ?? 'Beginner') }})
                        </option>
                    @endforeach
                </select>
                @error('workout_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Hari --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1">Hari Latihan</label>
                <select name="day_of_week" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-indigo-500" required>
                    <option value="">-- Pilih Hari --</option>
                    @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                        <option value="{{ strtolower($day) }}">{{ $day }}</option>
                    @endforeach
                </select>
                @error('day_of_week')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Waktu --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1">Waktu Latihan</label>
                <input type="time" name="time" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-indigo-500"
                    required>
                @error('time')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol --}}
            <div class="flex justify-end gap-3">
                <a href="{{ route('user.workouts.index') }}"
                    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg text-gray-700">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg">
                    Simpan Jadwal
                </button>
            </div>
        </form>
    </div>
@endsection