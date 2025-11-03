@extends('layouts.trainer')

@section('title', 'Daftar Member')

@section('content')
    {{-- 🏋️ Header (Style "Dark Premium") --}}
    <h1 class="font-serif text-3xl font-bold text-white mb-6">
        👥 Daftar <span class="text-amber-400">Member</span>
    </h1>

    {{-- Logika @if Anda aman --}}
    @if($members->isEmpty())
        {{-- Empty State (Style "Dark Premium") --}}
        <div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 shadow-sm sm:rounded-lg p-6">
            <p class="text-gray-400 italic text-center">Belum ada member di bawah bimbinganmu.</p>
        </div>
    @else
        <div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 overflow-hidden shadow-sm sm:rounded-lg">

            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-900/50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Nama</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Email</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Jumlah Log</th>
                        <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">

                    {{-- Logika @foreach Anda aman --}}
                    @foreach ($members as $member)
                    <tr class="hover:bg-gray-800/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-white">{{ $member->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-400">{{ $member->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                            {{ $member->progress_logs_count }} log
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            {{-- Link (Style "Dark Premium") --}}
                            <a href="{{ route('trainer.members.show', $member->id) }}"
                               class="text-amber-400 hover:text-amber-300">Lihat Detail</a>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    @endif
@endsection
