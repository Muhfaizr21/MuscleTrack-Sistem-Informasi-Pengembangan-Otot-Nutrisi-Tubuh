@extends('layouts.trainer')

@section('title', '💬 Chat Member')

@section('content')
<div class="flex h-[80vh] max-w-6xl mx-auto bg-gray-950/80 border border-gray-800 rounded-2xl shadow-2xl overflow-hidden">

    {{-- 🔹 SIDEBAR MEMBER LIST --}}
    <div class="w-1/3 border-r border-gray-800 flex flex-col bg-gray-900/70">
        <div class="p-4 border-b border-gray-800">
            <h2 class="font-serif text-lg text-white font-bold">💬 Chat Member</h2>
        </div>

        {{-- 🔍 Search --}}
        <div class="p-3">
            <input type="text" placeholder="Cari member..." 
                class="w-full rounded-full bg-gray-800 border border-gray-700 text-gray-300 text-sm px-4 py-2 
                       focus:ring-amber-400 focus:border-amber-400">
        </div>

        {{-- 👥 Member List --}}
        <div class="flex-1 overflow-y-auto">
            @forelse($members as $m)
                <a href="{{ route('trainer.communication.chat.show', $m->id) }}" 
                   class="flex items-center gap-3 px-4 py-3 hover:bg-gray-800/60 transition-all">
                    <div class="relative">
                        <div class="w-10 h-10 rounded-full bg-amber-400/20 flex items-center justify-center 
                                    text-amber-400 font-bold">
                            {{ strtoupper(substr($m->name, 0, 1)) }}
                        </div>
                        <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-400 border border-gray-900 rounded-full"></span>
                    </div>
                    <div class="flex-1">
                        <p class="text-white font-semibold text-sm">{{ $m->name }}</p>
                        <p class="text-gray-400 text-xs truncate">Klik untuk membuka chat</p>
                    </div>
                    @if($m->trainer_chats_as_user_count ?? 0 > 0)
                        <span class="text-xs bg-red-600 text-white rounded-full px-2 py-0.5">
                            {{ $m->trainer_chats_as_user_count }}
                        </span>
                    @endif
                </a>
            @empty
                <p class="text-gray-400 text-center mt-6">Belum ada member yang terhubung.</p>
            @endforelse
        </div>
    </div>

    {{-- 🔹 MAIN CHAT AREA (EMPTY STATE) --}}
    <div class="flex-1 flex flex-col items-center justify-center bg-gray-950/80 text-gray-400">
        <div class="text-center p-6">
            <p class="text-lg font-semibold text-white mb-3">💬 Pilih Member untuk Mulai Chat</p>
            <p class="text-sm text-gray-400">Pesan akan tampil di sini setelah kamu memilih salah satu member di sebelah kiri.</p>
        </div>
    </div>

</div>
@endsection
