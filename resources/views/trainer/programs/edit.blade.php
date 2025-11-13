@extends('layouts.trainer')

@section('title', 'Program Latihan Member')

@section('content')
<div class="bg-black/60 backdrop-blur-xl border border-gray-700/50 shadow-lg rounded-2xl p-8 space-y-10">

    {{-- ============================= --}}
    {{-- 🏋️ Workout Program Management --}}
    {{-- ============================= --}}
    <div>
        <h2 class="text-2xl font-bold mb-6 text-emerald-400">
            ⚙️ Program Latihan untuk {{ $member->name }}
        </h2>

        {{-- Form Program --}}
        <form action="{{ route('trainer.programs.update', ['memberId' => $member->id]) }}" method="POST" class="space-y-6">
            @csrf
            @method('PATCH')

            {{-- Workout Plan --}}
            <div>
                <h3 class="text-lg font-semibold mb-3 text-emerald-300">🏋️ Rencana Latihan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="text" name="workout_title"
                           value="{{ $workoutPlan->title ?? '' }}"
                           placeholder="Judul Program (contoh: Upper Body Strength)"
                           class="w-full px-3 py-2 bg-gray-900/60 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-400">

                    <input type="text" name="level"
                           value="{{ $workoutPlan->level ?? '' }}"
                           placeholder="Tingkat (Low/Medium/High)"
                           class="w-full px-3 py-2 bg-gray-900/60 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-400">

                    <input type="number" name="duration_weeks"
                           value="{{ $workoutPlan->duration_weeks ?? '' }}"
                           placeholder="Durasi (minggu)"
                           class="w-full px-3 py-2 bg-gray-900/60 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-400">

                    <textarea name="description"
                              placeholder="Deskripsi latihan..."
                              class="w-full px-3 py-2 bg-gray-900/60 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-400">{{ $workoutPlan->description ?? '' }}</textarea>
                </div>
            </div>

            <button type="submit"
                    class="bg-gradient-to-r from-emerald-500 to-green-400 text-black font-semibold py-2 px-6 rounded-lg shadow hover:opacity-90 transition">
                💾 Simpan Program
            </button>
        </form>
    </div>

    {{-- ============================= --}}
    {{-- 🗒️ Progress Notes --}}
    {{-- ============================= --}}
    <div>
        <hr class="my-8 border-gray-700">
        <h3 class="text-lg font-semibold mb-3 text-emerald-300">🗒️ Catatan Progress Member</h3>

        <form action="{{ route('trainer.programs.progress.note.store', ['memberId' => $member->id]) }}" method="POST" class="space-y-3">
            @csrf
            <textarea name="notes" rows="3"
                      placeholder="Tulis evaluasi atau catatan perkembangan member..."
                      class="w-full px-3 py-2 bg-gray-900/60 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-400"></textarea>

            <button type="submit"
                    class="bg-gradient-to-r from-emerald-500 to-green-400 text-black font-semibold py-2 px-6 rounded-lg shadow hover:opacity-90 transition">
                ➕ Simpan Catatan
            </button>
        </form>

        {{-- Daftar Catatan --}}
        @if(isset($member->progressLogs) && $member->progressLogs->count())
            <ul class="mt-5 space-y-3">
                @foreach($member->progressLogs->sortByDesc('created_at') as $log)
                    <li class="bg-gray-900/60 border border-gray-700 rounded-lg p-4 text-white">
                        <p class="text-sm text-gray-200">{{ $log->notes }}</p>
                        <span class="text-xs text-gray-500">{{ $log->created_at->format('d M Y, H:i') }}</span>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500 mt-3 italic text-center">Belum ada catatan progress untuk member ini.</p>
        @endif
    </div>

</div>
@endsection
