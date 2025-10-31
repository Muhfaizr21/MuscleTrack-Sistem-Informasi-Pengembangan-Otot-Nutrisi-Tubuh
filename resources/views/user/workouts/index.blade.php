@extends('layouts.user')

@section('content')
<div class="bg-white shadow-md rounded-2xl p-6">
    <h2 class="text-xl font-semibold text-indigo-700 mb-4">🏋️ Workout Plans</h2>
    <a href="{{ route('user.workouts.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg">+ Tambah Workout</a>

    <ul class="mt-4">
        @forelse($workouts as $w)
            <li class="border-b py-2">{{ $w->title ?? 'Push-up Beginner' }}</li>
        @empty
            <p class="text-gray-500">Belum ada workout plan.</p>
        @endforelse
    </ul>
</div>
@endsection
