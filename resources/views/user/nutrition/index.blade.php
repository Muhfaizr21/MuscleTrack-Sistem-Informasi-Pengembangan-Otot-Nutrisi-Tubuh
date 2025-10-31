@extends('layouts.user')

@section('content')
<div class="bg-white shadow-md rounded-2xl p-6">
    <h2 class="text-xl font-semibold text-indigo-700 mb-4">🥗 Nutrition Plans</h2>
    <a href="{{ route('user.nutrition.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg">+ Tambah Menu</a>

    <ul class="mt-4">
        @forelse($nutritions as $n)
            <li class="border-b py-2">{{ $n->title ?? 'Diet Sehat Harian' }} - {{ $n->calories ?? 0 }} kcal</li>
        @empty
            <p class="text-gray-500">Belum ada menu nutrisi.</p>
        @endforelse
    </ul>
</div>
@endsection
