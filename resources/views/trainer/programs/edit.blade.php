@extends('layouts.trainer')

@section('title', 'Program Latihan Member')

@section('content')
<div class="bg-white shadow rounded-lg p-8 space-y-10">

    {{-- ============================= --}}
    {{-- 🏋️ Workout Program Management --}}
    {{-- ============================= --}}
    <div>
        <h2 class="text-2xl font-bold mb-6 text-blue-700">
            ⚙️ Program Latihan untuk {{ $member->name }}
        </h2>

        {{-- Form Program --}}
        <form action="{{ route('trainer.programs.update', ['memberId' => $member->id]) }}" method="POST" class="space-y-6">
            @csrf
            @method('PATCH')

            {{-- Workout Plan --}}
            <div>
                <h3 class="text-lg font-semibold mb-2">🏋️ Rencana Latihan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="text" name="workout_title" 
                           value="{{ $workoutPlan->title ?? '' }}" 
                           placeholder="Judul Program (contoh: Upper Body Strength)"
                           class="border rounded p-2 w-full">

                    <input type="text" name="level" 
                           value="{{ $workoutPlan->level ?? '' }}" 
                           placeholder="Tingkat (Low/Medium/High)"
                           class="border rounded p-2 w-full">

                    <input type="number" name="duration_weeks" 
                           value="{{ $workoutPlan->duration_weeks ?? '' }}" 
                           placeholder="Durasi (minggu)"
                           class="border rounded p-2 w-full">

                    <textarea name="description" 
                              placeholder="Deskripsi latihan..."
                              class="border rounded p-2 w-full">{{ $workoutPlan->description ?? '' }}</textarea>
                </div>
            </div>

            <button type="submit" class="bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700 transition">
                💾 Simpan Program
            </button>
        </form>
    </div>

    {{-- ============================= --}}
    {{-- 🗒️ Progress Notes --}}
    {{-- ============================= --}}
    <div>
        <hr class="my-8">
        <h3 class="text-lg font-semibold mb-3 text-indigo-700">🗒️ Catatan Progress Member</h3>

        <form action="{{ route('trainer.programs.progress.note.store', ['memberId' => $member->id]) }}" method="POST" class="space-y-3">
            @csrf
            <textarea name="notes" rows="3" 
                      placeholder="Tulis evaluasi atau catatan perkembangan member..." 
                      class="border rounded p-3 w-full"></textarea>

            <button type="submit" class="bg-indigo-600 text-white py-2 px-6 rounded-lg hover:bg-indigo-700 transition">
                ➕ Simpan Catatan
            </button>
        </form>

        {{-- Daftar Catatan --}}
        @if(isset($member->progressLogs) && $member->progressLogs->count())
            <ul class="mt-5 space-y-3">
                @foreach($member->progressLogs->sortByDesc('created_at') as $log)
                    <li class="border rounded-lg p-4 bg-gray-50">
                        <p class="text-sm text-gray-700">{{ $log->notes }}</p>
                        <span class="text-xs text-gray-500">{{ $log->created_at->format('d M Y, H:i') }}</span>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500 mt-3">Belum ada catatan progress untuk member ini.</p>
        @endif
    </div>

</div>
@endsection
