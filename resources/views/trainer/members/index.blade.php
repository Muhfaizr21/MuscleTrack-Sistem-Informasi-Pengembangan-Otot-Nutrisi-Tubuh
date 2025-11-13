@extends('layouts.trainer')

@section('title', 'Daftar Member')

@section('content')
<div class="relative max-w-5xl mx-auto p-6 md:p-8 rounded-2xl border border-gray-800
    bg-gradient-to-br from-gray-950 via-gray-900 to-gray-900
    backdrop-blur-sm shadow-inner shadow-black/30">

    {{-- 👥 Header: Deep Dark --}}
    <div class="flex items-center mb-6">
        <div class="w-2 h-10 bg-emerald-600/60 rounded-full mr-3"></div>
        <h1 class="text-3xl font-semibold text-gray-100 tracking-wide">
            👥 Daftar <span class="text-emerald-500/80">Member</span>
        </h1>
    </div>

    {{-- 🌐 Logika --}}
    @if($members->isEmpty())
        <div class="p-8 text-center border border-gray-800 rounded-xl bg-gray-950/70">
            <p class="text-gray-500 italic mb-3">Belum ada member di bawah bimbinganmu.</p>
            <p class="text-gray-400">Tetap siaga, mungkin besok ada yang mendaftar 💪</p>
        </div>
    @else
        <div class="overflow-hidden rounded-xl border border-gray-800 bg-gray-950/60">

            <table class="min-w-full divide-y divide-gray-800">
                <thead class="bg-gray-900/80">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Nama
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Jumlah Log
                        </th>
                        <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-800">
                    @foreach ($members as $member)
                        <tr class="hover:bg-gray-800/40 transition-all duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-200">{{ $member->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-400">{{ $member->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-emerald-400/70">
                                {{ $member->progress_logs_count }} log
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('trainer.members.show', $member->id) }}"
                                   class="text-emerald-500/80 hover:text-emerald-400/70 underline-offset-2 hover:underline transition-all duration-200">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
