@extends('layouts.user')

@section('title', 'Notifikasi')

@section('content')
    <div class="max-w-4xl mx-auto">
        {{-- 🏋️ Header --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="font-serif text-3xl font-bold text-white">
                🔔 Notifi<span class="text-amber-400">kasi</span>
            </h1>
            
            {{-- Tombol Aksi --}}
            <div class="flex gap-2">
                <form action="{{ route('user.notifications.markAllRead') }}" method="POST">
                    @csrf
                    <button type="submit" 
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-500 rounded-lg text-white text-sm font-medium transition-all duration-150 flex items-center gap-2">
                        📭 Tandai Semua Dibaca
                    </button>
                </form>
                
                <form action="{{ route('user.notifications.clearAll') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus semua notifikasi?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                        class="px-4 py-2 bg-red-600 hover:bg-red-500 rounded-lg text-white text-sm font-medium transition-all duration-150 flex items-center gap-2">
                        🗑️ Hapus Semua
                    </button>
                </form>
            </div>
        </div>

        {{-- 📊 Statistik Notifikasi --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-gradient-to-r from-blue-600/30 to-blue-800/30 border border-blue-500/50 rounded-lg p-4">
                <div class="text-blue-300 text-sm">Total</div>
                <div class="text-white text-2xl font-bold">{{ $notifications->total() }}</div>
                <div class="text-blue-400 text-xs">Notifikasi</div>
            </div>
            <div class="bg-gradient-to-r from-amber-600/30 to-amber-800/30 border border-amber-500/50 rounded-lg p-4">
                <div class="text-amber-300 text-sm">Belum Dibaca</div>
                <div class="text-white text-2xl font-bold">{{ $unreadCount }}</div>
                <div class="text-amber-400 text-xs">Pesan Baru</div>
            </div>
            <div class="bg-gradient-to-r from-green-600/30 to-green-800/30 border border-green-500/50 rounded-lg p-4">
                <div class="text-green-300 text-sm">Hari Ini</div>
                <div class="text-white text-2xl font-bold">{{ $todayCount }}</div>
                <div class="text-green-400 text-xs">Notifikasi</div>
            </div>
            <div class="bg-gradient-to-r from-purple-600/30 to-purple-800/30 border border-purple-500/50 rounded-lg p-4">
                <div class="text-purple-300 text-sm">Minggu Ini</div>
                <div class="text-white text-2xl font-bold">{{ $weeklyCount }}</div>
                <div class="text-purple-400 text-xs">Notifikasi</div>
            </div>
        </div>

        {{-- ✅ Panel Notifikasi --}}
        <div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 shadow-sm sm:rounded-lg">

            {{-- Filter Notifikasi --}}
            <div class="p-4 border-b border-gray-700/50">
                <div class="flex flex-wrap gap-2">
                    <button data-filter="all" class="filter-btn px-3 py-1 bg-amber-600 text-white text-sm rounded-lg transition-all">
                        Semua
                    </button>
                    <button data-filter="unread" class="filter-btn px-3 py-1 bg-gray-700 hover:bg-gray-600 text-white text-sm rounded-lg transition-all">
                        Belum Dibaca ({{ $unreadCount }})
                    </button>
                    <button data-filter="trainer" class="filter-btn px-3 py-1 bg-blue-700 hover:bg-blue-600 text-white text-sm rounded-lg transition-all">
                        🧑‍🏫 Trainer
                    </button>
                    <button data-filter="system" class="filter-btn px-3 py-1 bg-purple-700 hover:bg-purple-600 text-white text-sm rounded-lg transition-all">
                        ⚙️ Sistem
                    </button>
                    <button data-filter="nutrition_tip" class="filter-btn px-3 py-1 bg-green-700 hover:bg-green-600 text-white text-sm rounded-lg transition-all">
                        🥗 Tips Nutrisi
                    </button>
                    <button data-filter="reminder" class="filter-btn px-3 py-1 bg-orange-700 hover:bg-orange-600 text-white text-sm rounded-lg transition-all">
                        ⏰ Pengingat
                    </button>
                </div>
            </div>

            {{-- Daftar Notifikasi --}}
            <div class="divide-y divide-gray-700/50 max-h-[600px] overflow-y-auto" id="notificationsList">
                @forelse($notifications as $notification)
                    <div class="notification-item p-4 md:p-6 hover:bg-gray-800/50 transition-all duration-200 
                                {{ !$notification->read_status ? 'bg-blue-900/20 border-l-4 border-blue-400' : '' }}"
                         data-type="{{ $notification->type }}"
                         data-read="{{ $notification->read_status ? 'true' : 'false' }}">
                        
                        <div class="flex justify-between items-start gap-4">
                            {{-- Konten Notifikasi --}}
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    {{-- Icon berdasarkan type --}}
                                    @switch($notification->type)
                                        @case('trainer')
                                            <span class="text-blue-400 text-lg">🧑‍🏫</span>
                                            @break
                                        @case('system')
                                            <span class="text-purple-400 text-lg">⚙️</span>
                                            @break
                                        @case('nutrition_tip')
                                            <span class="text-green-400 text-lg">🥗</span>
                                            @break
                                        @case('reminder')
                                            <span class="text-orange-400 text-lg">⏰</span>
                                            @break
                                        @case('achievement')
                                            <span class="text-yellow-400 text-lg">🏆</span>
                                            @break
                                        @case('alert')
                                            <span class="text-red-400 text-lg">🚨</span>
                                            @break
                                        @default
                                            <span class="text-gray-400 text-lg">💬</span>
                                    @endswitch

                                    <h3 class="font-semibold text-lg
                                        {{ !$notification->read_status ? 'text-white font-bold' : 'text-gray-300' }}">
                                        {{ $notification->title }}
                                    </h3>

                                    {{-- Badge Status --}}
                                    @if(!$notification->read_status)
                                        <span class="px-2 py-1 bg-blue-600 text-white text-xs rounded-full animate-pulse">
                                            BARU
                                        </span>
                                    @endif
                                </div>

                                <p class="text-gray-300 text-sm leading-relaxed mb-2">
                                    {{ $notification->message }}
                                </p>

                                <div class="flex items-center justify-between">
                                    <span class="text-xs 
                                        {{ !$notification->read_status ? 'text-amber-400 font-medium' : 'text-gray-500' }}">
                                        {{ $notification->formatted_time ?? $notification->created_at->diffForHumans() }}
                                    </span>

                                    {{-- Badge Tipe --}}
                                    <span class="text-xs font-medium px-2 py-1 rounded-full 
                                        {{ $notification->type_color ?? 'bg-gray-700 text-gray-300' }}">
                                        {{ ucfirst(str_replace('_', ' ', $notification->type)) }}
                                    </span>
                                </div>
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                @if(!$notification->read_status)
                                    <form action="{{ route('user.notifications.read', $notification->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" 
                                            class="p-2 bg-green-600 hover:bg-green-500 rounded-lg text-white text-xs transition-all"
                                            title="Tandai Sudah Dibaca">
                                            ✓
                                        </button>
                                    </form>
                                @endif
                                
                                <form action="{{ route('user.notifications.destroy', $notification->id) }}" method="POST" 
                                      onsubmit="return confirm('Hapus notifikasi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="p-2 bg-red-600 hover:bg-red-500 rounded-lg text-white text-xs transition-all"
                                            title="Hapus Notifikasi">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- Progress Bar untuk notifikasi baru --}}
                        @if(!$notification->read_status)
                            <div class="mt-2 w-full bg-gray-700 rounded-full h-1">
                                <div class="bg-blue-500 h-1 rounded-full animate-pulse"></div>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="text-center p-8">
                        <div class="text-gray-400 text-6xl mb-4">📭</div>
                        <p class="text-gray-400 text-lg mb-2">Belum ada notifikasi</p>
                        <p class="text-gray-500 text-sm">Notifikasi dari trainer, sistem, dan tips nutrisi akan muncul di sini</p>
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

        {{-- Quick Actions --}}
        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('user.chat.index') }}" 
               class="p-4 bg-blue-600/30 border border-blue-500/50 rounded-lg text-white hover:bg-blue-600/40 transition-all duration-150 text-center">
                <div class="text-2xl mb-2">💬</div>
                <div class="font-semibold">Chat Trainer</div>
                <div class="text-blue-300 text-sm">Kirim pesan ke trainer</div>
            </a>
            
            <a href="{{ route('user.workouts.index') }}" 
               class="p-4 bg-green-600/30 border border-green-500/50 rounded-lg text-white hover:bg-green-600/40 transition-all duration-150 text-center">
                <div class="text-2xl mb-2">🏋️</div>
                <div class="font-semibold">Workout Saya</div>
                <div class="text-green-300 text-sm">Lihat jadwal latihan</div>
            </a>
            
            <a href="{{ route('user.nutrition.index') }}" 
               class="p-4 bg-purple-600/30 border border-purple-500/50 rounded-lg text-white hover:bg-purple-600/40 transition-all duration-150 text-center">
                <div class="text-2xl mb-2">🥗</div>
                <div class="font-semibold">Plan Nutrisi</div>
                <div class="text-purple-300 text-sm">Cek menu makanan</div>
            </a>
        </div>
    </div>

    {{-- JavaScript untuk Filter --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.filter-btn');
            const notificationItems = document.querySelectorAll('.notification-item');
            
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const filter = this.getAttribute('data-filter');
                    
                    // Update active button
                    filterButtons.forEach(btn => {
                        if(btn === this) {
                            btn.classList.add('bg-amber-600');
                            btn.classList.remove('bg-gray-700', 'bg-blue-700', 'bg-purple-700', 'bg-green-700', 'bg-orange-700');
                        } else {
                            btn.classList.remove('bg-amber-600');
                            // Reset to original colors
                            if(btn.getAttribute('data-filter') === 'unread') {
                                btn.classList.add('bg-gray-700');
                            } else if(btn.getAttribute('data-filter') === 'trainer') {
                                btn.classList.add('bg-blue-700');
                            } else if(btn.getAttribute('data-filter') === 'system') {
                                btn.classList.add('bg-purple-700');
                            } else if(btn.getAttribute('data-filter') === 'nutrition_tip') {
                                btn.classList.add('bg-green-700');
                            } else if(btn.getAttribute('data-filter') === 'reminder') {
                                btn.classList.add('bg-orange-700');
                            }
                        }
                    });
                    
                    // Filter notifications
                    notificationItems.forEach(item => {
                        if (filter === 'all') {
                            item.style.display = 'block';
                        } else if (filter === 'unread') {
                            if (item.getAttribute('data-read') === 'false') {
                                item.style.display = 'block';
                            } else {
                                item.style.display = 'none';
                            }
                        } else {
                            if (item.getAttribute('data-type') === filter) {
                                item.style.display = 'block';
                            } else {
                                item.style.display = 'none';
                            }
                        }
                    });
                });
            });

            // Add hover effects for notification items
            notificationItems.forEach(item => {
                item.addEventListener('mouseenter', function() {
                    const actionButtons = this.querySelector('.opacity-0');
                    if (actionButtons) {
                        actionButtons.classList.remove('opacity-0');
                        actionButtons.classList.add('opacity-100');
                    }
                });
                
                item.addEventListener('mouseleave', function() {
                    const actionButtons = this.querySelector('.opacity-100');
                    if (actionButtons) {
                        actionButtons.classList.remove('opacity-100');
                        actionButtons.classList.add('opacity-0');
                    }
                });
            });

            // Auto-refresh notifications every 30 seconds
            setInterval(() => {
                // You can implement live refresh here if needed
                console.log('Checking for new notifications...');
            }, 30000);
        });
    </script>

    <style>
        .notification-item {
            transition: all 0.3s ease;
        }
        
        .notification-item:hover {
            transform: translateX(4px);
        }
        
        #notificationsList::-webkit-scrollbar {
            width: 6px;
        }
        
        #notificationsList::-webkit-scrollbar-track {
            background: #1f2937;
            border-radius: 3px;
        }
        
        #notificationsList::-webkit-scrollbar-thumb {
            background: #4b5563;
            border-radius: 3px;
        }
        
        #notificationsList::-webkit-scrollbar-thumb:hover {
            background: #6b7280;
        }
        
        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
    </style>
@endsection