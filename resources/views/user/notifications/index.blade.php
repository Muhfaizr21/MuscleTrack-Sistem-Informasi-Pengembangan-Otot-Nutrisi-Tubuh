@extends('layouts.user')

@section('title', 'Notifikasi')

@section('content')
<div class="max-w-5xl mx-auto">

    {{-- 🎨 Header Futuristik --}}
    <div class="flex justify-between items-center mb-8">
        <h1 class="font-serif text-3xl font-bold text-white drop-shadow-md">
            🔔 Notifi<span class="text-emerald-400">kasi</span>
        </h1>

        <div class="flex gap-2">
            <form action="{{ route('user.notifications.markAllRead') }}" method="POST">
                @csrf
                <button type="submit"
                    class="px-4 py-2 bg-emerald-500/20 border border-emerald-400/50 text-emerald-300 rounded-xl hover:bg-emerald-500/40 hover:text-white transition-all duration-200 backdrop-blur-md font-medium text-sm shadow-inner">
                    📭 Tandai Semua Dibaca
                </button>
            </form>

            <form action="{{ route('user.notifications.clearAll') }}" method="POST"
                  onsubmit="return confirm('Yakin hapus semua notifikasi?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="px-4 py-2 bg-red-500/20 border border-red-400/50 text-red-300 rounded-xl hover:bg-red-500/40 hover:text-white transition-all duration-200 backdrop-blur-md font-medium text-sm shadow-inner">
                    🗑️ Hapus Semua
                </button>
            </form>
        </div>
    </div>

    {{-- 📊 Statistik Notifikasi --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        @php
            $cards = [
                ['title'=>'Total','count'=>$notifications->total(),'color'=>'blue','desc'=>'Notifikasi'],
                ['title'=>'Belum Dibaca','count'=>$unreadCount,'color'=>'amber','desc'=>'Pesan Baru'],
                ['title'=>'Hari Ini','count'=>$todayCount,'color'=>'emerald','desc'=>'Notifikasi'],
                ['title'=>'Minggu Ini','count'=>$weeklyCount,'color'=>'purple','desc'=>'Notifikasi'],
            ];
        @endphp

        @foreach($cards as $c)
            <div class="bg-gradient-to-br from-{{ $c['color'] }}-600/20 to-{{ $c['color'] }}-800/30 border border-{{ $c['color'] }}-400/40 rounded-2xl p-4 backdrop-blur-md hover:shadow-lg hover:shadow-{{ $c['color'] }}-500/20 transition-all duration-300">
                <div class="text-{{ $c['color'] }}-300 text-sm mb-1">{{ $c['title'] }}</div>
                <div class="text-white text-2xl font-bold">{{ $c['count'] }}</div>
                <div class="text-{{ $c['color'] }}-400 text-xs">{{ $c['desc'] }}</div>
            </div>
        @endforeach
    </div>

    {{-- 🧩 Filter --}}
    <div class="bg-black/60 backdrop-blur-xl border border-gray-700/60 rounded-2xl p-4 mb-6 flex flex-wrap gap-2 justify-start">
        @php
            $filters = [
                ['key'=>'all','label'=>'Semua','color'=>'amber'],
                ['key'=>'unread','label'=>"Belum Dibaca ($unreadCount)",'color'=>'gray'],
                ['key'=>'trainer','label'=>'🧑‍🏫 Trainer','color'=>'blue'],
                ['key'=>'system','label'=>'⚙️ Sistem','color'=>'purple'],
                ['key'=>'nutrition_tip','label'=>'🥗 Tips Nutrisi','color'=>'green'],
                ['key'=>'reminder','label'=>'⏰ Pengingat','color'=>'orange'],
            ];
        @endphp

        @foreach($filters as $f)
            <button data-filter="{{ $f['key'] }}"
                class="filter-btn px-3 py-1.5 rounded-lg text-sm font-medium bg-{{ $f['color'] }}-700/40 border border-{{ $f['color'] }}-500/40 text-white hover:bg-{{ $f['color'] }}-600/50 transition-all duration-200 shadow-inner">
                {{ $f['label'] }}
            </button>
        @endforeach
    </div>

    {{-- 🔔 Panel Notifikasi --}}
    <div class="bg-black/70 backdrop-blur-2xl border border-gray-700/50 rounded-2xl overflow-hidden shadow-xl">
        <div class="divide-y divide-gray-700/50 max-h-[600px] overflow-y-auto" id="notificationsList">
            @forelse($notifications as $notification)
                <div class="notification-item group p-5 hover:bg-gray-800/60 transition-all duration-300
                            {{ !$notification->read_status ? 'bg-emerald-900/20 border-l-4 border-emerald-400' : '' }}"
                     data-type="{{ $notification->type }}"
                     data-read="{{ $notification->read_status ? 'true' : 'false' }}">

                    <div class="flex justify-between items-start gap-4">
                        <div class="flex-1 space-y-1">
                            <div class="flex items-center gap-3">
                                @switch($notification->type)
                                    @case('trainer') <span class="text-blue-400 text-lg">🧑‍🏫</span> @break
                                    @case('system') <span class="text-purple-400 text-lg">⚙️</span> @break
                                    @case('nutrition_tip') <span class="text-green-400 text-lg">🥗</span> @break
                                    @case('reminder') <span class="text-orange-400 text-lg">⏰</span> @break
                                    @case('achievement') <span class="text-yellow-400 text-lg">🏆</span> @break
                                    @case('alert') <span class="text-red-400 text-lg">🚨</span> @break
                                    @default <span class="text-gray-400 text-lg">💬</span>
                                @endswitch

                                <h3 class="text-lg font-semibold
                                    {{ !$notification->read_status ? 'text-white' : 'text-gray-300' }}">
                                    {{ $notification->title }}
                                </h3>

                                @if(!$notification->read_status)
                                    <span class="px-2 py-0.5 bg-emerald-500/30 border border-emerald-400/40 text-emerald-200 text-xs rounded-full animate-pulse">
                                        BARU
                                    </span>
                                @endif
                            </div>

                            <p class="text-gray-300 text-sm leading-relaxed">{{ $notification->message }}</p>

                            <div class="flex items-center justify-between mt-2">
                                <span class="text-xs {{ !$notification->read_status ? 'text-emerald-400' : 'text-gray-500' }}">
                                    {{ $notification->formatted_time ?? $notification->created_at->diffForHumans() }}
                                </span>
                                <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-gray-700/70 text-gray-300">
                                    {{ ucfirst(str_replace('_', ' ', $notification->type)) }}
                                </span>
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            @if(!$notification->read_status)
                                <form action="{{ route('user.notifications.read', $notification->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="p-2 bg-emerald-600/30 border border-emerald-500/40 rounded-lg hover:bg-emerald-600/60 text-white text-xs transition-all"
                                        title="Tandai Sudah Dibaca">✓</button>
                                </form>
                            @endif

                            <form action="{{ route('user.notifications.destroy', $notification->id) }}" method="POST"
                                  onsubmit="return confirm('Hapus notifikasi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="p-2 bg-red-600/30 border border-red-500/40 rounded-lg hover:bg-red-600/60 text-white text-xs transition-all"
                                        title="Hapus">🗑️</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center p-10 text-gray-400">
                    <div class="text-6xl mb-3">📭</div>
                    <p class="text-lg">Belum ada notifikasi</p>
                    <p class="text-sm text-gray-500">Pesan dari trainer, sistem, dan nutrisi akan muncul di sini.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($notifications->hasPages())
            <div class="p-6 border-t border-gray-700/50">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>

    {{-- ⚡ Quick Access --}}
    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
        @php
            $shortcuts = [
                ['route'=>'user.chat.index','icon'=>'💬','color'=>'blue','title'=>'Chat Trainer','desc'=>'Kirim pesan ke trainer'],
                ['route'=>'user.workouts.index','icon'=>'🏋️','color'=>'emerald','title'=>'Workout Saya','desc'=>'Lihat jadwal latihan'],
                ['route'=>'user.nutrition.index','icon'=>'🥗','color'=>'purple','title'=>'Plan Nutrisi','desc'=>'Cek menu makanan'],
            ];
        @endphp
        @foreach($shortcuts as $s)
            <a href="{{ route($s['route']) }}"
               class="p-5 text-center rounded-2xl border border-{{ $s['color'] }}-500/40 bg-{{ $s['color'] }}-600/20 hover:bg-{{ $s['color'] }}-600/30 text-white transition-all duration-300 backdrop-blur-md shadow-inner hover:shadow-{{ $s['color'] }}-500/30">
                <div class="text-2xl mb-2">{{ $s['icon'] }}</div>
                <div class="font-semibold">{{ $s['title'] }}</div>
                <div class="text-{{ $s['color'] }}-300 text-sm">{{ $s['desc'] }}</div>
            </a>
        @endforeach
    </div>
</div>

{{-- 🎛️ Script Filter --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const items = document.querySelectorAll('.notification-item');
    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const filter = btn.getAttribute('data-filter');
            filterBtns.forEach(b => b.classList.remove('ring-2', 'ring-amber-400'));
            btn.classList.add('ring-2', 'ring-amber-400');
            items.forEach(item => {
                const type = item.getAttribute('data-type');
                const read = item.getAttribute('data-read');
                item.style.display = (
                    filter === 'all' ||
                    (filter === 'unread' && read === 'false') ||
                    (filter === type)
                ) ? 'block' : 'none';
            });
        });
    });
});
</script>

<style>
#notificationsList::-webkit-scrollbar {
    width: 6px;
}
#notificationsList::-webkit-scrollbar-thumb {
    background: linear-gradient(180deg, #10B981, #3B82F6);
    border-radius: 3px;
}
.notification-item {
    transition: all 0.35s ease;
}
.notification-item:hover {
    transform: translateX(5px);
}
</style>
@endsection
