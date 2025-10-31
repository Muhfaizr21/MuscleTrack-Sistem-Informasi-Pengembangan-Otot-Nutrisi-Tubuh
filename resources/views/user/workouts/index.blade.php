@extends('layouts.user')

@section('content')
<div class="bg-white shadow-md rounded-2xl p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-indigo-700 flex items-center gap-2">
            🏋️ Workout Plans
        </h2>
        <a href="{{ route('user.workouts.create') }}" 
           class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
            + Tambah Workout
        </a>
    </div>

    {{-- Jika ada notifikasi sukses --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Workout Plans --}}
    @if($workouts->count() > 0)
        <div class="grid md:grid-cols-2 gap-5">
            @foreach($workouts as $workout)
                <div class="border rounded-xl p-4 shadow-sm hover:shadow-md transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-semibold text-lg text-gray-800">{{ $workout->title }}</h3>
                            <p class="text-sm text-gray-500 italic">
                                {{ ucfirst($workout->difficulty_level ?? 'beginner') }} • 
                                {{ $workout->duration_minutes ?? 30 }} menit
                            </p>
                        </div>
                        @if($workout->target_fitness)
                            <span class="bg-indigo-100 text-indigo-700 text-xs font-semibold px-2 py-1 rounded">
                                🎯 {{ ucfirst(str_replace('_',' ', $workout->target_fitness)) }}
                            </span>
                        @endif
                    </div>

                    <p class="mt-3 text-gray-700 text-sm">{{ $workout->description ?? 'Panduan latihan dari trainer.' }}</p>

                    {{-- Jadwal latihan user --}}
                    @php
                        $userSchedule = $schedules->firstWhere('workout_id', $workout->id);
                    @endphp

                    <div class="mt-4 bg-gray-50 rounded-lg p-3 border">
                        @if($userSchedule)
                            <p class="text-sm text-gray-700">
                                📅 <strong>{{ ucfirst($userSchedule->day_of_week) }}</strong> • 
                                ⏰ {{ \Carbon\Carbon::parse($userSchedule->time)->format('H:i') }}
                            </p>
                            <p class="text-xs text-gray-500 mt-1">
                                Reminder aktif setiap minggu.
                            </p>

                            <div class="flex gap-3 mt-3">
                                <a href="{{ route('user.workouts.edit', $userSchedule->id) }}" 
                                   class="text-indigo-600 text-sm hover:underline">Edit Jadwal</a>
                                <form action="{{ route('user.workouts.destroy', $userSchedule->id) }}" 
                                      method="POST" onsubmit="return confirm('Hapus jadwal latihan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 text-sm hover:underline">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        @else
                            <p class="text-sm text-gray-500 italic">Belum ada jadwal latihan untuk workout ini.</p>
                            <a href="{{ route('user.workouts.create', ['workout_id' => $workout->id]) }}"
                               class="mt-2 inline-block bg-indigo-600 text-white px-3 py-1.5 rounded-lg text-sm hover:bg-indigo-700">
                                + Atur Jadwal
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center text-gray-500 py-10">
            Belum ada workout plan yang tersedia.  
            <p class="text-sm">Trainer akan menambahkan workout sesuai target kamu.</p>
        </div>
    @endif
</div>
@endsection
