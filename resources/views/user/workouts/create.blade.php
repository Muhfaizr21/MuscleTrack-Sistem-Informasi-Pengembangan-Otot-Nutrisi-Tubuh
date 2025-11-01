@extends('layouts.user')

@section('content')
    <div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 shadow-sm sm:rounded-lg p-6 max-w-xl mx-auto">

        <h2 class="font-serif text-2xl font-bold text-white mb-6 flex items-center gap-2">
            🕒 Atur <span class="text-amber-400">Jadwal Workout</span>
        </h2>

        <form action="{{ route('user.workouts.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Workout (Style "Dark Premium") --}}
            <div>
                <label class="block text-sm font-medium text-amber-400 mb-1">Pilih Workout</label>
                <select name="workout_id"
                        class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white
                               focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50" required>
                    <option value="">-- Pilih Workout --</option>

                    @foreach($workouts as $w)
                        <option value="{{ $w->id }}"
                            {{ isset($selectedWorkout) && $selectedWorkout->id == $w->id ? 'selected' : '' }}>
                            {{ $w->title }} ({{ ucfirst($w->difficulty_level ?? 'Beginner') }})
                        </option>
                    @endforeach
                </select>
                @error('workout_id')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Hari (Style "Dark Premium") --}}
            <div>
                <label class="block text-sm font-medium text-amber-400 mb-1">Hari Latihan</label>
                <select name="day_of_week"
                        class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white
                               focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50" required>
                    <option value="">-- Pilih Hari --</option>

                    @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                        <option value="{{ strtolower($day) }}">{{ $day }}</option>
                    @endforeach
                </select>
                @error('day_of_week')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Waktu (Style "Dark Premium") --}}
            <div>
                <label class="block text-sm font-medium text-amber-400 mb-1">Waktu Latihan</label>
                <input type="time" name="time"
                       class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white
                              focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50" required>
                @error('time')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol (Style "Dark Premium") --}}
            <div class="flex justify-end gap-3 pt-3">
                <a href="{{ route('user.workouts.index') }}"
                    class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg text-white font-medium text-sm transition-all">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-md text-sm font-bold text-black bg-amber-400 hover:bg-amber-300 transition-all shadow-lg shadow-amber-500/20">
                    Simpan Jadwal
                </button>
            </div>
        </form>
    </div>
@endsection
