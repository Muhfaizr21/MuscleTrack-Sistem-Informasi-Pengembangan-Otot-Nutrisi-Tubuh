@extends('layouts.trainer')

@section('title', 'Notifikasi')

@section('content')
    {{-- 🏋️ Header (Style "Dark Premium") --}}
    <h1 class="font-serif text-3xl font-bold text-white mb-6">
        🔔 Notifi<span class="text-amber-400">kasi</span>
    </h1>

    {{-- ✅ Panel Kaca "Liar" --}}
    <div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 shadow-sm sm:rounded-lg max-w-3xl mx-auto">

        {{-- Daftar Notifikasi --}}
        <div class="divide-y divide-gray-700/50">

            @forelse($notifications as $notification)
                <div class="p-4 md:p-6">
                    {{--
                      Kita gunakan form POST di sini agar link "markAsRead"
                      terpanggil dengan benar (karena rute Anda adalah POST, bukan GET)
                    --}}
                    <form action="{{ route('trainer.communication.notifications.read', $notification->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="block w-full text-left group">
                            <p class="
                                @if(is_null($notification->read_at))
                                    text-white font-semibold group-hover:text-amber-400
                                @else
                                    text-gray-400 group-hover:text-gray-300
                                @endif
                            ">
                                {{ $notification->message }}
                            </p>
                            <span class="text-xs
                                @if(is_null($notification->read_at))
                                    text-amber-400 font-medium
                                @else
                                    text-gray-500
                                @endif
                            ">
                                {{ $notification->created_at->diffForHumans() }}
                            </span>
                        </button>
                    </form>
                </div>
            @empty
                <p class="text-gray-400 italic text-center p-8">Belum ada notifikasi.</p>
            @endforelse
        </div>

        {{-- Pagination (jika notif lebih dari 20) --}}
        @if($notifications->hasPages())
            <div class="p-6 border-t border-gray-700/50">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
@endsection
