@extends('layouts.user') {{-- ❗️ Pastikan ini layout User Anda --}}

@section('title', 'Notifikasi') {{-- (Sesuaikan @section Anda) --}}

@section('content') {{-- (Sesuaikan @section Anda) --}}

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
                      Kita gunakan form POST di sini (sesuai rute user)
                    --}}
                    <form action="{{ route('user.notifications.read', $notification->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="block w-full text-left group">
                            <div class="flex justify-between items-start">
                                <h3 class="font-serif text-lg
                                    @if(!$notification->read_status)
                                        text-amber-400 font-bold group-hover:text-amber-300
                                    @else
                                        text-gray-400 group-hover:text-gray-200
                                    @endif
                                ">
                                    {{ $notification->title }}
                                </h3>

                                {{-- Tampilkan Tipe Notifikasi (dari Model "ciamik" Anda) --}}
                                <span class="text-xs font-medium px-2 py-0.5 rounded-full {{ $notification->type_color }}">
                                    {{ $notification->type }}
                                </span>
                            </div>

                            <p class="text-sm mt-1
                                @if(!$notification->read_status)
                                    text-gray-200
                                @else
                                    text-gray-500
                                @endif
                            ">
                                {{ $notification->message }}
                            </p>

                            <span class="text-xs mt-2 inline-block
                                @if(!$notification->read_status)
                                    text-amber-400 font-medium
                                @else
                                    text-gray-500
                                @endif
                            ">
                                {{-- Gunakan accessor "ciamik" dari Model Anda --}}
                                {{ $notification->formatted_time }}
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
