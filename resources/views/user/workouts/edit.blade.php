@extends('layouts.user')

@section('content')
<div class="bg-white shadow-md rounded-2xl p-6 max-w-xl mx-auto">
    <h2 class="text-xl font-semibold text-indigo-700 mb-4 flex items-center gap-2">
        ✏️ Edit Jadwal Workout
    </h2>

    <form action="{{ route('user.workouts.update', $schedule->id) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')

        {{-- Workout --}}
        <div>
            <label class="block text-gray-700 font-medium mb-1">Pilih Workout</label>
            <select name="workout_id" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-indigo-500" required>
                @foreach($workouts as $w)
                    <option value="{{ $w->id }}" {{ $schedule->workout_id == $w->id ? 'selected' : '' }}>
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
                @foreach(['senin','selasa','rabu','kamis','jumat','sabtu','minggu'] as $day)
                    <option value="{{ $day }}" {{ $schedule->day_of_week == $day ? 'selected' : '' }}>
                        {{ ucfirst($day) }}
                    </option>
                @endforeach
            </select>
            @error('day_of_week') 
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
            @enderror
        </div>

        {{-- Waktu --}}
        <div>
            <label class="block text-gray-700 font-medium mb-1">Waktu Latihan</label>
            <input type="time" name="time" value="{{ \Carbon\Carbon::parse($schedule->time)->format('H:i') }}"
                   class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-indigo-500" required>
            @error('time') 
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
            @enderror
        </div>

        {{-- Tombol --}}
        <div class="flex justify-between items-center">
            <a href="{{ route('user.workouts.index') }}" 
               class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg text-gray-700">
               Kembali
            </a>

            <div class="flex gap-3">
                {{-- Form Hapus terpisah --}}
                <form action="{{ route('user.workouts.destroy', $schedule->id) }}" 
                      method="POST" 
                      onsubmit="return confirm('Hapus jadwal workout ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg">
                        Hapus
                    </button>
                </form>

                <button type="submit" 
                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg">
                    Update
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
