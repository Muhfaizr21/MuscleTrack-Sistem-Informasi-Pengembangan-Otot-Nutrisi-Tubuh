@extends('layouts.user')

@section('content')
<div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 shadow-sm sm:rounded-lg p-6">

    <div class="flex justify-between items-center mb-6">
        <h2 class="font-serif text-2xl font-bold text-white flex items-center gap-2">
            🏋️ Workout <span class="text-amber-400">Plans</span>
        </h2>
        <a href="{{ route('user.workouts.create') }}"
           class="px-5 py-2.5 rounded-md text-sm font-bold text-black bg-amber-400 hover:bg-amber-300 transition-all shadow-lg shadow-amber-500/20">
            + Tambah Workout
        </a>
    </div>

    {{-- ✅ Notifikasi Sukses (Style "Dark Premium") --}}
    @if(session('success'))
        <div class="bg-green-500/20 border border-green-500/50 text-green-300 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Workout Plans --}}
    @if($workouts->count() > 0)
        <div class="grid md:grid-cols-2 gap-5">

            @foreach($workouts as $workout)
                <div class="bg-gray-900/50 border border-gray-700/50 rounded-xl p-4 transition-all hover:border-amber-400/50">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-serif text-xl font-bold text-white">{{ $workout->title }}</h3>
                            <p class="text-sm text-gray-400 italic">
                                {{ ucfirst($workout->difficulty_level ?? 'beginner') }} •
                                {{ $workout->duration_minutes ?? 30 }} menit
                            </p>
                        </div>
                        @if($workout->target_fitness)
                            <span class="bg-amber-400/20 text-amber-300 text-xs font-semibold px-2 py-1 rounded">
                                🎯 {{ ucfirst(str_replace('_',' ', $workout->target_fitness)) }}
                            </span>
                        @endif
                    </div>

                    <p class="mt-3 text-gray-300 text-sm">{{ $workout->description ?? 'Panduan latihan dari trainer.' }}</p>

                    {{-- Jadwal latihan user --}}
                    @php
                        $userSchedule = $schedules->firstWhere('workout_id', $workout->id);
                    @endphp

                    <div class="mt-4 bg-gray-800/50 rounded-lg p-3 border border-gray-700/50">
                        @if($userSchedule)
                            <p class="text-sm text-gray-300">
                                📅 <strong class="text-white">{{ ucfirst($userSchedule->day_of_week) }}</strong> •
                                ⏰ {{ \Carbon\Carbon::parse($userSchedule->time)->format('H:i') }}
                            </p>
                            <p class="text-xs text-gray-500 mt-1">
                                Reminder aktif setiap minggu.
                            </p>

                            <div class="flex gap-4 mt-3">
                                <a href="{{ route('user.workouts.edit', $userSchedule->id) }}"
                                   class="text-amber-400 text-sm font-medium hover:underline">Edit Jadwal</a>

                                <form action="{{ route('user.workouts.destroy', $userSchedule->id) }}"
                                      method="POST" onsubmit="return confirm('Hapus jadwal latihan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 text-sm font-medium hover:underline">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        @else
                            <p class="text-sm text-gray-400 italic">Belum ada jadwal latihan.</p>
                            <a href="{{ route('user.workouts.create', ['workout_id' => $workout->id]) }}"
                               class="mt-2 inline-block bg-amber-400 text-black px-3 py-1.5 rounded-lg text-sm font-bold hover:bg-amber-300 transition-all">
                                + Atur Jadwal
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center text-gray-400 py-10">
            Belum ada workout plan yang tersedia.
            <p class="text-sm text-gray-500">Trainer akan menambahkan workout sesuai target kamu.</p>
        </div>
    @endif
</div>
@endsection
