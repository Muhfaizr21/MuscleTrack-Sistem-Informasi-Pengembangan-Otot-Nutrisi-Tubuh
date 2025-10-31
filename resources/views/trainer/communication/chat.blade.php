@extends('layouts.trainer')

@section('title', 'Chat dengan Member')

@section('content')
    <div class="bg-white shadow rounded-2xl p-6">
        <h1 class="text-2xl font-bold mb-4">💬 Chat dengan Member</h1>

        @if ($members->isEmpty())
            <p class="text-gray-500">Belum ada member yang terhubung dengan Anda.</p>
        @else
            <ul class="divide-y divide-gray-200">
                @foreach ($members as $member)
                    <li class="py-3 flex justify-between items-center">
                        <div>
                            <span class="font-medium text-gray-800">{{ $member->name }}</span>
                            <p class="text-sm text-gray-500">Klik untuk membuka percakapan</p>
                        </div>
                        <a href="{{ route('trainer.communication.chat.show', $member->id) }}"
                            class="bg-blue-600 text-white px-3 py-1 rounded-lg hover:bg-blue-700">
                            Buka Chat
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection