@extends('layouts.trainer')

@section('title', 'Notifikasi')

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header Section --}}
        <div class="glass-dark rounded-3xl p-8 border border-emerald-500/20 shadow-2xl shadow-emerald-500/10 mb-8">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl flex items-center justify-center animate-glow">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM10.24 8.56a5.97 5.97 0 01-4.66-7.11 1 1 0 00-.68-1.16A1 1 0 004 1a7.97 7.97 0 007.33 7.91 1 1 0 00.91-.91 1 1 0 00-.68-1.16 5.99 5.99 0 01-1.32-.28z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl sm:text-4xl font-black text-white">
                            🔔 <span class="text-gradient">Notifikasi</span>
                        </h1>
                        <p class="text-emerald-400/80 text-lg mt-2">Kelola semua notifikasi dan pemberitahuan Anda</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    @if($notifications->count() > 0)
                    <form action="{{ route('trainer.communication.notifications.markAllRead') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="group flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-bold text-emerald-400 hover:text-white transition-all duration-300 border border-emerald-500/30 hover:bg-emerald-500/10">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Tandai Semua Dibaca
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>

        {{-- Quick Stats --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="glass-dark rounded-2xl p-6 border border-emerald-500/20 shadow-lg shadow-emerald-500/10">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-emerald-400/80 text-sm font-medium">Total Notifikasi</p>
                        <p class="text-3xl font-black text-white mt-2">{{ $notifications->total() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-emerald-500/20 rounded-xl flex items-center justify-center">
                        <span class="text-xl">📨</span>
                    </div>
                </div>
            </div>

            <div class="glass-dark rounded-2xl p-6 border border-blue-500/20 shadow-lg shadow-blue-500/10">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-400/80 text-sm font-medium">Belum Dibaca</p>
                        <p class="text-3xl font-black text-white mt-2">{{ $unreadCount }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center">
                        <span class="text-xl">👁️</span>
                    </div>
                </div>
            </div>

            <div class="glass-dark rounded-2xl p-6 border border-purple-500/20 shadow-lg shadow-purple-500/10">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-400/80 text-sm font-medium">Sudah Dibaca</p>
                        <p class="text-3xl font-black text-white mt-2">{{ $notifications->total() - $unreadCount }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-500/20 rounded-xl flex items-center justify-center">
                        <span class="text-xl">✅</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Notifications List --}}
        <div class="glass-dark rounded-3xl p-6 border border-emerald-500/20 shadow-xl shadow-emerald-500/10">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-black text-white flex items-center gap-3">
                    <span class="text-gradient">📋 Daftar Notifikasi</span>
                </h2>
                <div class="flex items-center gap-3">
                    @if($notifications->count() > 0)
                    <form action="{{ route('trainer.communication.notifications.markAllRead') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold text-emerald-400 hover:text-white transition-all duration-300 border border-emerald-500/30 hover:bg-emerald-500/10">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Tandai Semua Dibaca
                        </button>
                    </form>
                    @endif
                </div>
            </div>

            @if($notifications->count() > 0)
                <div class="space-y-4">
                    @foreach($notifications as $notification)
                        <div class="glass rounded-2xl p-6 border transition-all duration-300 group hover:transform hover:scale-[1.02]
                            {{ is_null($notification->read_at)
                                ? 'border-amber-500/30 bg-amber-500/5 hover:border-amber-500/50'
                                : 'border-emerald-500/10 hover:border-emerald-500/30' }}">

                            <form action="{{ route('trainer.communication.notifications.read', $notification->id) }}" method="POST" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-2">
                                                {{-- Notification Icon Based on Type --}}
                                                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0
                                                    {{ is_null($notification->read_at)
                                                        ? 'bg-amber-500/20 border border-amber-500/30'
                                                        : 'bg-emerald-500/20 border border-emerald-500/30' }}">
                                                    @if($notification->type === 'nutrition_tip')
                                                        <span class="text-lg">🍽️</span>
                                                    @elseif($notification->type === 'workout_reminder')
                                                        <span class="text-lg">💪</span>
                                                    @elseif($notification->type === 'system')
                                                        <span class="text-lg">⚙️</span>
                                                    @elseif($notification->type === 'message')
                                                        <span class="text-lg">💬</span>
                                                    @else
                                                        <span class="text-lg">🔔</span>
                                                    @endif
                                                </div>

                                                <div class="flex-1 min-w-0">
                                                    <h3 class="font-semibold text-white group-hover:text-emerald-400 transition-colors duration-300 text-sm leading-relaxed">
                                                        {{ $notification->message }}
                                                    </h3>
                                                    <p class="text-emerald-400/70 text-xs mt-1">
                                                        {{ $notification->created_at->diffForHumans() }}
                                                        @if($notification->type)
                                                            • <span class="capitalize">{{ str_replace('_', ' ', $notification->type) }}</span>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Read Status Indicator --}}
                                        <div class="flex items-center gap-2 flex-shrink-0">
                                            @if(is_null($notification->read_at))
                                                <span class="px-2 py-1 text-xs font-medium bg-amber-500/20 text-amber-400 rounded-full border border-amber-500/30">
                                                    Baru
                                                </span>
                                            @else
                                                <span class="px-2 py-1 text-xs font-medium bg-emerald-500/20 text-emerald-400 rounded-full border border-emerald-500/30">
                                                    Dibaca
                                                </span>
                                            @endif

                                            {{-- Mark as Read Icon --}}
                                            <div class="w-6 h-6 rounded-lg flex items-center justify-center
                                                {{ is_null($notification->read_at)
                                                    ? 'bg-amber-500/20 text-amber-400 group-hover:bg-amber-500/30'
                                                    : 'bg-emerald-500/20 text-emerald-400' }}">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if($notifications->hasPages())
                    <div class="mt-8 pt-6 border-t border-emerald-500/20">
                        <div class="flex justify-center">
                            {{ $notifications->links('vendor.pagination.simple-tailwind') }}
                        </div>
                    </div>
                @endif

            @else
                {{-- Empty State --}}
                <div class="text-center py-12">
                    <div class="w-20 h-20 bg-emerald-500/10 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-emerald-500/20">
                        <span class="text-3xl">🔕</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Tidak Ada Notifikasi</h3>
                    <p class="text-emerald-400/80 mb-6">Anda belum memiliki notifikasi saat ini.</p>
                    <p class="text-gray-400 text-sm">Notifikasi baru akan muncul di sini ketika ada aktivitas terkait member atau sistem.</p>
                </div>
            @endif
        </div>

        {{-- Quick Actions --}}
        @if($notifications->count() > 0)
        <div class="glass-dark rounded-3xl p-6 border border-blue-500/20 shadow-xl shadow-blue-500/10 mt-8">
            <h2 class="text-xl font-black text-white mb-4 flex items-center gap-3">
                <span class="text-blue-400">⚡ Aksi Cepat</span>
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <form action="{{ route('trainer.communication.notifications.markAllRead') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-sm font-bold text-blue-400 hover:text-white transition-all duration-300 border border-blue-500/30 hover:bg-blue-500/10 group">
                        <svg class="w-4 h-4 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Tandai Semua Dibaca
                    </button>
                </form>

                <a href="{{ route('trainer.dashboard') }}"
                   class="flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-sm font-bold text-emerald-400 hover:text-white transition-all duration-300 border border-emerald-500/30 hover:bg-emerald-500/10 group">
                    <svg class="w-4 h-4 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    .text-gradient {
        background: linear-gradient(135deg, #10b981 0%, #34d399 50%, #6ee7b7 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .glass-dark {
        background: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(16, 185, 129, 0.3);
    }

    .glass {
        background: rgba(17, 25, 21, 0.7);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .animate-glow {
        animation: glow 2s ease-in-out infinite alternate;
    }

    @keyframes glow {
        from {
            box-shadow: 0 0 10px rgba(16, 185, 129, 0.4);
        }
        to {
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.6), 0 0 30px rgba(16, 185, 129, 0.4);
        }
    }
</style>

{{-- Custom Pagination Styles --}}
<style>
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
    }

    .pagination .page-item {
        list-style: none;
    }

    .pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 0.75rem;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 1px solid rgba(16, 185, 129, 0.2);
        background: rgba(17, 25, 21, 0.7);
        color: #9CA3AF;
        text-decoration: none;
    }

    .pagination .page-link:hover {
        background: rgba(16, 185, 129, 0.1);
        color: #10B981;
        border-color: rgba(16, 185, 129, 0.3);
    }

    .pagination .page-item.active .page-link {
        background: rgba(16, 185, 129, 0.2);
        color: #10B981;
        border-color: rgba(16, 185, 129, 0.4);
    }

    .pagination .page-item.disabled .page-link {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>
@endsection
