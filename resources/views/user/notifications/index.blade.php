@extends('layouts.user')

@section('title', 'Notifikasi')

@section('content')
<div class="max-w-6xl mx-auto px-3 sm:px-4 lg:px-6">

    {{-- 🎨 Header Futuristik --}}
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-6 lg:mb-8">
        <h1 class="font-serif text-2xl sm:text-3xl lg:text-4xl font-bold text-white drop-shadow-md">
            🔔 Notifi<span class="text-emerald-400">kasi</span>
        </h1>

        <div class="flex flex-wrap gap-2 w-full lg:w-auto justify-start lg:justify-end">
            <form action="{{ route('user.notifications.markAllRead') }}" method="POST" class="flex-1 lg:flex-none min-w-[140px]">
                @csrf
                <button type="submit"
                    class="w-full px-3 py-2 bg-emerald-500/20 border border-emerald-400/50 text-emerald-300 rounded-xl hover:bg-emerald-500/40 hover:text-white transition-all duration-200 backdrop-blur-md font-medium text-xs sm:text-sm shadow-inner">
                    📭 Tandai Semua Dibaca
                </button>
            </form>

            <form action="{{ route('user.notifications.clearAll') }}" method="POST"
                  onsubmit="return confirm('Yakin hapus semua notifikasi?')" class="flex-1 lg:flex-none min-w-[120px]">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="w-full px-3 py-2 bg-red-500/20 border border-red-400/50 text-red-300 rounded-xl hover:bg-red-500/40 hover:text-white transition-all duration-200 backdrop-blur-md font-medium text-xs sm:text-sm shadow-inner">
                    🗑️ Hapus Semua
                </button>
            </form>

            {{-- Tombol Test Push Notification --}}
            <button onclick="testPushNotification()"
                class="flex-1 lg:flex-none min-w-[100px] px-3 py-2 bg-blue-500/20 border border-blue-400/50 text-blue-300 rounded-xl hover:bg-blue-500/40 hover:text-white transition-all duration-200 backdrop-blur-md font-medium text-xs sm:text-sm shadow-inner">
                🔔 Test Push
            </button>

            {{-- Tombol Preferensi Notifikasi --}}
            <button onclick="openPushPreferences()"
                class="flex-1 lg:flex-none min-w-[110px] px-3 py-2 bg-purple-500/20 border border-purple-400/50 text-purple-300 rounded-xl hover:bg-purple-500/40 hover:text-white transition-all duration-200 backdrop-blur-md font-medium text-xs sm:text-sm shadow-inner">
                ⚙️ Preferensi
            </button>
        </div>
    </div>

    {{-- 🚀 Quick Reminder Toggles --}}
    <div class="bg-black/60 backdrop-blur-xl border border-gray-700/60 rounded-2xl p-4 sm:p-6 mb-6">
        <h3 class="text-white font-semibold text-base sm:text-lg mb-4 flex items-center gap-2 flex-wrap">
            ⏰ Pengingat Cepat 
            <span class="text-xs bg-orange-500/30 text-orange-300 px-2 py-1 rounded-full">Aktifkan sesuai kebutuhan</span>
        </h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-2 sm:gap-3">
            @php
                $quickReminders = [
                    ['type'=>'daily','icon'=>'🌅','label'=>'Motivasi Harian','color'=>'blue','desc'=>'Pengingat pagi'],
                    ['type'=>'workout','icon'=>'🏋️‍♂️','label'=>'Workout','color'=>'emerald','desc'=>'Pengingat latihan'],
                    ['type'=>'water','icon'=>'🚰','label'=>'Minum Air','color'=>'cyan','desc'=>'Pengingat hidrasi'],
                    ['type'=>'nutrition','icon'=>'🥗','label'=>'Makan','color'=>'green','desc'=>'Pengingat makan'],
                    ['type'=>'progress','icon'=>'📊','label'=>'Progress','color'=>'purple','desc'=>'Pengingat progress'],
                ];
            @endphp
            
            @foreach($quickReminders as $qr)
                <div class="text-center">
                    <button onclick="toggleQuickReminder('{{ $qr['type'] }}')" 
                            class="quick-reminder-btn w-full p-2 sm:p-3 rounded-xl border border-{{ $qr['color'] }}-500/40 bg-gray-600/20 hover:bg-{{ $qr['color'] }}-600/20 text-white transition-all duration-300 backdrop-blur-md group"
                            data-type="{{ $qr['type'] }}"
                            id="reminder-btn-{{ $qr['type'] }}">
                        <div class="text-xl sm:text-2xl mb-1 group-hover:scale-110 transition-transform">{{ $qr['icon'] }}</div>
                        <div class="text-xs font-medium leading-tight">{{ $qr['label'] }}</div>
                        <div class="text-gray-500 text-xs mt-1 reminder-status" id="reminder-status-{{ $qr['type'] }}">❌ Nonaktif</div>
                    </button>
                    <button onclick="testReminder('{{ $qr['type'] }}')" 
                            class="mt-1 sm:mt-2 w-full px-2 py-1 text-xs bg-gray-600/50 border border-gray-500 text-gray-300 rounded-lg hover:bg-gray-600 transition-all">
                        Test
                    </button>
                </div>
            @endforeach
        </div>
        
        <div class="mt-4 text-center">
            <button onclick="openReminderPreferences()"
                class="w-full sm:w-auto px-4 py-2 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-xl hover:from-orange-600 hover:to-red-600 transition-all duration-300 font-medium text-sm">
                ⚙️ Atur Detail Pengingat
            </button>
        </div>
    </div>

    {{-- 📊 Statistik Notifikasi --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4 mb-6">
        @php
            $cards = [
                ['title'=>'Total','count'=>$notifications->total(),'color'=>'blue','desc'=>'Notifikasi'],
                ['title'=>'Belum Dibaca','count'=>$unreadCount,'color'=>'amber','desc'=>'Pesan Baru'],
                ['title'=>'Hari Ini','count'=>$todayCount,'color'=>'emerald','desc'=>'Notifikasi'],
                ['title'=>'Minggu Ini','count'=>$weeklyCount,'color'=>'purple','desc'=>'Notifikasi'],
            ];
        @endphp

        @foreach($cards as $c)
            <div class="bg-gradient-to-br from-{{ $c['color'] }}-600/20 to-{{ $c['color'] }}-800/30 border border-{{ $c['color'] }}-400/40 rounded-2xl p-3 sm:p-4 backdrop-blur-md hover:shadow-lg hover:shadow-{{ $c['color'] }}-500/20 transition-all duration-300">
                <div class="text-{{ $c['color'] }}-300 text-xs sm:text-sm mb-1">{{ $c['title'] }}</div>
                <div class="text-white text-xl sm:text-2xl font-bold">{{ $c['count'] }}</div>
                <div class="text-{{ $c['color'] }}-400 text-xs">{{ $c['desc'] }}</div>
            </div>
        @endforeach
    </div>

    {{-- 🧩 Filter --}}
    <div class="bg-black/60 backdrop-blur-xl border border-gray-700/60 rounded-2xl p-3 sm:p-4 mb-6">
        <div class="flex flex-wrap gap-2 justify-start">
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
                    class="filter-btn px-3 py-1.5 rounded-lg text-xs sm:text-sm font-medium bg-{{ $f['color'] }}-700/40 border border-{{ $f['color'] }}-500/40 text-white hover:bg-{{ $f['color'] }}-600/50 transition-all duration-200 shadow-inner">
                    {{ $f['label'] }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- 🔔 Panel Notifikasi --}}
    <div class="bg-black/70 backdrop-blur-2xl border border-gray-700/50 rounded-2xl overflow-hidden shadow-xl">
        <div class="divide-y divide-gray-700/50 max-h-[500px] sm:max-h-[600px] overflow-y-auto" id="notificationsList">
            @forelse($notifications as $notification)
                <div class="notification-item group p-4 sm:p-5 hover:bg-gray-800/60 transition-all duration-300
                            {{ !$notification->read_status ? 'bg-emerald-900/20 border-l-4 border-emerald-400' : '' }}"
                     data-type="{{ $notification->type }}"
                     data-read="{{ $notification->read_status ? 'true' : 'false' }}">

                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-3">
                        <div class="flex-1 space-y-2 sm:space-y-1">
                            <div class="flex items-center gap-2 sm:gap-3 flex-wrap">
                                @switch($notification->type)
                                    @case('trainer') <span class="text-blue-400 text-base sm:text-lg">🧑‍🏫</span> @break
                                    @case('system') <span class="text-purple-400 text-base sm:text-lg">⚙️</span> @break
                                    @case('nutrition_tip') <span class="text-green-400 text-base sm:text-lg">🥗</span> @break
                                    @case('reminder') <span class="text-orange-400 text-base sm:text-lg">⏰</span> @break
                                    @case('achievement') <span class="text-yellow-400 text-base sm:text-lg">🏆</span> @break
                                    @case('alert') <span class="text-red-400 text-base sm:text-lg">🚨</span> @break
                                    @default <span class="text-gray-400 text-base sm:text-lg">💬</span>
                                @endswitch

                                <h3 class="text-base sm:text-lg font-semibold
                                    {{ !$notification->read_status ? 'text-white' : 'text-gray-300' }}">
                                    {{ $notification->title }}
                                </h3>

                                @if(!$notification->read_status)
                                    <span class="px-2 py-0.5 bg-emerald-500/30 border border-emerald-400/40 text-emerald-200 text-xs rounded-full animate-pulse">
                                        BARU
                                    </span>
                                @endif
                            </div>

                            <p class="text-gray-300 text-sm sm:text-base leading-relaxed">{{ $notification->message }}</p>

                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mt-2">
                                <span class="text-xs {{ !$notification->read_status ? 'text-emerald-400' : 'text-gray-500' }}">
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>
                                <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-gray-700/70 text-gray-300 self-start sm:self-auto">
                                    {{ ucfirst(str_replace('_', ' ', $notification->type)) }}
                                </span>
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="flex gap-2 opacity-100 sm:opacity-0 group-hover:opacity-100 transition-opacity duration-300 self-end sm:self-auto">
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
                <div class="text-center p-6 sm:p-10 text-gray-400">
                    <div class="text-4xl sm:text-6xl mb-3">📭</div>
                    <p class="text-base sm:text-lg">Belum ada notifikasi</p>
                    <p class="text-xs sm:text-sm text-gray-500">Pesan dari trainer, sistem, dan nutrisi akan muncul di sini.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($notifications->hasPages())
            <div class="p-4 sm:p-6 border-t border-gray-700/50">
                <div class="flex justify-center">
                    {{ $notifications->links() }}
                </div>
            </div>
        @endif
    </div>

    {{-- ⚡ Quick Access --}}
    <div class="mt-6 sm:mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
        @php
            $shortcuts = [
                ['route'=>'user.chat.index','icon'=>'💬','color'=>'blue','title'=>'Chat Trainer','desc'=>'Kirim pesan ke trainer'],
                ['route'=>'user.workouts.index','icon'=>'🏋️','color'=>'emerald','title'=>'Workout Saya','desc'=>'Lihat jadwal latihan'],
                ['route'=>'user.nutrition.index','icon'=>'🥗','color'=>'purple','title'=>'Plan Nutrisi','desc'=>'Cek menu makanan'],
            ];
        @endphp
        @foreach($shortcuts as $s)
            <a href="{{ route($s['route']) }}"
               class="p-4 sm:p-5 text-center rounded-2xl border border-{{ $s['color'] }}-500/40 bg-{{ $s['color'] }}-600/20 hover:bg-{{ $s['color'] }}-600/30 text-white transition-all duration-300 backdrop-blur-md shadow-inner hover:shadow-{{ $s['color'] }}-500/30">
                <div class="text-xl sm:text-2xl mb-2">{{ $s['icon'] }}</div>
                <div class="font-semibold text-sm sm:text-base">{{ $s['title'] }}</div>
                <div class="text-{{ $s['color'] }}-300 text-xs sm:text-sm">{{ $s['desc'] }}</div>
            </a>
        @endforeach
    </div>
</div>

{{-- Modal Push Preferences --}}
<div id="pushPreferencesModal" class="fixed inset-0 bg-black/70 backdrop-blur-md z-50 hidden items-center justify-center p-3 sm:p-4">
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-600 rounded-2xl p-4 sm:p-6 w-full max-w-md max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg sm:text-xl font-bold text-white">🔔 Preferensi Notifikasi</h3>
            <button onclick="closePushPreferences()" class="text-gray-400 hover:text-white text-2xl">&times;</button>
        </div>
        
        <form id="pushPreferencesForm" class="space-y-4">
            @csrf
            <div class="flex items-center justify-between">
                <label class="text-white text-sm sm:text-base">Push Notification</label>
                <input type="checkbox" name="push_enabled" class="toggle-checkbox" checked>
            </div>
            
            <div class="space-y-3 border-t border-gray-600 pt-3">
                <div class="flex items-center justify-between">
                    <label class="text-gray-300 text-sm sm:text-base">⏰ Pengingat Workout</label>
                    <input type="checkbox" name="workout_reminders" class="toggle-checkbox" checked>
                </div>
                
                <div class="flex items-center justify-between">
                    <label class="text-gray-300 text-sm sm:text-base">🥗 Tips Nutrisi</label>
                    <input type="checkbox" name="nutrition_tips" class="toggle-checkbox" checked>
                </div>
                
                <div class="flex items-center justify-between">
                    <label class="text-gray-300 text-sm sm:text-base">🧑‍🏫 Pesan Trainer</label>
                    <input type="checkbox" name="trainer_messages" class="toggle-checkbox" checked>
                </div>
                
                <div class="flex items-center justify-between">
                    <label class="text-gray-300 text-sm sm:text-base">⚙️ Update Sistem</label>
                    <input type="checkbox" name="system_updates" class="toggle-checkbox" checked>
                </div>
            </div>
            
            <div class="flex gap-2 mt-6">
                <button type="button" onclick="closePushPreferences()" 
                    class="flex-1 px-3 sm:px-4 py-2 bg-gray-600/50 border border-gray-500 text-gray-300 rounded-xl hover:bg-gray-600 transition-all text-sm sm:text-base">
                    Batal
                </button>
                <button type="submit" 
                    class="flex-1 px-3 sm:px-4 py-2 bg-blue-600/50 border border-blue-500 text-white rounded-xl hover:bg-blue-600 transition-all text-sm sm:text-base">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Reminder Preferences --}}
<div id="reminderPreferencesModal" class="fixed inset-0 bg-black/70 backdrop-blur-md z-50 hidden items-center justify-center p-3 sm:p-4">
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-600 rounded-2xl p-4 sm:p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg sm:text-xl font-bold text-white">⏰ Pengaturan Pengingat</h3>
            <button onclick="closeReminderPreferences()" class="text-gray-400 hover:text-white text-2xl">&times;</button>
        </div>
        
        <form id="reminderPreferencesForm" class="space-y-4 sm:space-y-6">
            @csrf
            
            {{-- Daily Motivation Reminder --}}
            <div class="bg-gray-700/30 rounded-xl p-3 sm:p-4 border border-gray-600/50">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-3">
                    <div class="flex items-center gap-3">
                        <span class="text-xl sm:text-2xl">🌅</span>
                        <div>
                            <h4 class="text-white font-semibold text-sm sm:text-base">Pengingat Motivasi Harian</h4>
                            <p class="text-gray-400 text-xs sm:text-sm">Dapatkan motivasi setiap pagi untuk memulai hari</p>
                        </div>
                    </div>
                    <input type="checkbox" name="daily_reminder_enabled" class="toggle-checkbox">
                </div>
                <div class="mt-3 pl-0 sm:pl-11">
                    <label class="text-gray-300 text-xs sm:text-sm mb-2 block">Waktu Pengingat</label>
                    <input type="time" name="daily_reminder_time" value="09:00" 
                           class="bg-gray-600/50 border border-gray-500 rounded-lg px-3 py-2 text-white w-32 text-sm sm:text-base">
                </div>
            </div>

            {{-- Workout Reminder --}}
            <div class="bg-gray-700/30 rounded-xl p-3 sm:p-4 border border-gray-600/50">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-3">
                    <div class="flex items-center gap-3">
                        <span class="text-xl sm:text-2xl">🏋️‍♂️</span>
                        <div>
                            <h4 class="text-white font-semibold text-sm sm:text-base">Pengingat Workout</h4>
                            <p class="text-gray-400 text-xs sm:text-sm">Ingatkan jadwal workout harian</p>
                        </div>
                    </div>
                    <input type="checkbox" name="workout_reminder_enabled" class="toggle-checkbox">
                </div>
                <div class="mt-3 pl-0 sm:pl-11">
                    <label class="text-gray-300 text-xs sm:text-sm mb-2 block">Waktu Pengingat</label>
                    <input type="time" name="workout_reminder_time" value="07:00" 
                           class="bg-gray-600/50 border border-gray-500 rounded-lg px-3 py-2 text-white w-32 text-sm sm:text-base">
                </div>
            </div>

            {{-- Water Reminder --}}
            <div class="bg-gray-700/30 rounded-xl p-3 sm:p-4 border border-gray-600/50">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-3">
                    <div class="flex items-center gap-3">
                        <span class="text-xl sm:text-2xl">🚰</span>
                        <div>
                            <h4 class="text-white font-semibold text-sm sm:text-base">Pengingat Minum Air</h4>
                            <p class="text-gray-400 text-xs sm:text-sm">Ingatkan untuk minum air secara teratur</p>
                        </div>
                    </div>
                    <input type="checkbox" name="water_reminder_enabled" class="toggle-checkbox">
                </div>
                <div class="mt-3 pl-0 sm:pl-11">
                    <label class="text-gray-300 text-xs sm:text-sm mb-2 block">Interval (jam)</label>
                    <select name="water_reminder_interval" class="bg-gray-600/50 border border-gray-500 rounded-lg px-3 py-2 text-white w-32 text-sm sm:text-base">
                        <option value="1">1 jam</option>
                        <option value="2" selected>2 jam</option>
                        <option value="3">3 jam</option>
                        <option value="4">4 jam</option>
                    </select>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-2 mt-6">
                <button type="button" onclick="closeReminderPreferences()" 
                    class="flex-1 px-3 sm:px-4 py-2 bg-gray-600/50 border border-gray-500 text-gray-300 rounded-xl hover:bg-gray-600 transition-all text-sm sm:text-base">
                    Batal
                </button>
                <button type="submit" 
                    class="flex-1 px-3 sm:px-4 py-2 bg-green-600/50 border border-green-500 text-white rounded-xl hover:bg-green-600 transition-all text-sm sm:text-base">
                    💾 Simpan Pengingat
                </button>
            </div>
        </form>
    </div>
</div>

{{-- 🎛️ Script Filter, Push Notification & Reminders --}}
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

    // Initialize Service Worker untuk Push Notification (jika di web)
    initializePushNotifications();
    
    // Load current reminder settings
    loadCurrentReminderSettings();
});

// Function untuk test push notification
async function testPushNotification() {
    try {
        const response = await fetch('{{ route("user.notifications.testPush") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        const result = await response.json();
        
        if (result.success) {
            showNotification('Test notifikasi berhasil dikirim!', 'success');
        } else {
            showNotification('Gagal mengirim test notifikasi: ' + result.message, 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('Terjadi kesalahan saat test notifikasi', 'error');
    }
}

// Function untuk push preferences
function openPushPreferences() {
    document.getElementById('pushPreferencesModal').classList.remove('hidden');
    document.getElementById('pushPreferencesModal').classList.add('flex');
}

function closePushPreferences() {
    document.getElementById('pushPreferencesModal').classList.add('hidden');
    document.getElementById('pushPreferencesModal').classList.remove('flex');
}

// Function untuk reminder preferences
function openReminderPreferences() {
    document.getElementById('reminderPreferencesModal').classList.remove('hidden');
    document.getElementById('reminderPreferencesModal').classList.add('flex');
}

function closeReminderPreferences() {
    document.getElementById('reminderPreferencesModal').classList.add('hidden');
    document.getElementById('reminderPreferencesModal').classList.remove('flex');
}

// Function untuk menampilkan notifikasi sementara
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 p-3 sm:p-4 rounded-lg border backdrop-blur-md z-50 transition-all duration-300 max-w-xs sm:max-w-sm ${
        type === 'success' ? 'bg-green-600/20 border-green-500/50 text-green-300' :
        type === 'error' ? 'bg-red-600/20 border-red-500/50 text-red-300' :
        'bg-blue-600/20 border-blue-500/50 text-blue-300'
    }`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Handle form submission untuk push preferences
document.getElementById('pushPreferencesForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
    // Convert checkbox values to boolean
    Object.keys(data).forEach(key => {
        data[key] = data[key] === 'on';
    });
    
    try {
        const response = await fetch('{{ route("user.notifications.push-preferences") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        
        if (result.success) {
            showNotification('Preferensi berhasil disimpan!', 'success');
            closePushPreferences();
        } else {
            showNotification('Gagal menyimpan preferensi', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('Terjadi kesalahan', 'error');
    }
});

// Handle form submission untuk reminder preferences
document.getElementById('reminderPreferencesForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
    // Process nutrition times
    data.nutrition_reminder_times = Array.from(formData.getAll('nutrition_reminder_times[]'));
    
    // Convert checkbox values to boolean
    data.daily_reminder_enabled = data.daily_reminder_enabled === 'on';
    data.workout_reminder_enabled = data.workout_reminder_enabled === 'on';
    data.water_reminder_enabled = data.water_reminder_enabled === 'on';
    data.nutrition_reminder_enabled = data.nutrition_reminder_enabled === 'on';
    data.progress_reminder_enabled = data.progress_reminder_enabled === 'on';
    
    try {
        const response = await fetch('{{ route("user.notifications.reminder-preferences") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        
        if (result.success) {
            showNotification('Pengaturan pengingat berhasil disimpan!', 'success');
            closeReminderPreferences();
            updateQuickReminderButtons(result.reminders);
        } else {
            showNotification('Gagal menyimpan pengaturan pengingat', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('Terjadi kesalahan', 'error');
    }
});

// Toggle quick reminder
async function toggleQuickReminder(type) {
    try {
        const button = document.querySelector(`.quick-reminder-btn[data-type="${type}"]`);
        const statusElement = document.getElementById(`reminder-status-${type}`);
        const isCurrentlyActive = statusElement.textContent.includes('Aktif');
        const enabled = !isCurrentlyActive;

        const response = await fetch('{{ route("user.notifications.toggle-reminder") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                type: type,
                enabled: enabled
            })
        });

        const result = await response.json();
        
        if (result.success) {
            // Update button appearance
            if (enabled) {
                button.classList.remove('bg-gray-600/20');
                button.classList.add('bg-green-600/30', 'border-green-500');
                statusElement.textContent = '⏰ Aktif';
                statusElement.classList.remove('text-gray-500');
                statusElement.classList.add('text-green-300');
            } else {
                button.classList.remove('bg-green-600/30', 'border-green-500');
                button.classList.add('bg-gray-600/20');
                statusElement.textContent = '❌ Nonaktif';
                statusElement.classList.remove('text-green-300');
                statusElement.classList.add('text-gray-500');
            }
            
            showNotification(result.message, 'success');
        } else {
            showNotification('Gagal mengubah pengingat', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('Terjadi kesalahan', 'error');
    }
}

// Test reminder
async function testReminder(type) {
    try {
        const response = await fetch('{{ route("user.notifications.test-reminder") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ type: type })
        });

        const result = await response.json();
        
        if (result.success) {
            showNotification(`Test pengingat ${type} berhasil dikirim!`, 'success');
        } else {
            showNotification(`Gagal mengirim test pengingat ${type}`, 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('Terjadi kesalahan saat test pengingat', 'error');
    }
}

// Load current reminder settings
async function loadCurrentReminderSettings() {
    try {
        // For now, we'll assume all reminders are disabled by default
        // In a real app, you would fetch the current settings from the server
        console.log('Loading current reminder settings...');
    } catch (error) {
        console.error('Error loading reminder settings:', error);
    }
}

// Update quick reminder buttons based on settings
function updateQuickReminderButtons(reminders) {
    Object.keys(reminders).forEach(type => {
        const button = document.querySelector(`.quick-reminder-btn[data-type="${type}"]`);
        const statusElement = document.getElementById(`reminder-status-${type}`);
        
        if (button && statusElement && reminders[type].enabled) {
            button.classList.remove('bg-gray-600/20');
            button.classList.add('bg-green-600/30', 'border-green-500');
            statusElement.textContent = '⏰ Aktif';
            statusElement.classList.remove('text-gray-500');
            statusElement.classList.add('text-green-300');
        }
    });
}

// Initialize Push Notifications untuk Web
async function initializePushNotifications() {
    if ('serviceWorker' in navigator && 'PushManager' in window) {
        try {
            // Register service worker
            const registration = await navigator.serviceWorker.register('/sw.js');
            console.log('Service Worker registered:', registration);

            // Request permission
            const permission = await Notification.requestPermission();
            if (permission === 'granted') {
                // Get subscription
                const subscription = await registration.pushManager.subscribe({
                    userVisibleOnly: true,
                    applicationServerKey: '{{ env("VAPID_PUBLIC_KEY") }}'
                });

                // Send subscription to server
                await sendSubscriptionToServer(subscription);
            }
        } catch (error) {
            console.log('Push notification error:', error);
        }
    }
}

// Send subscription to server
async function sendSubscriptionToServer(subscription) {
    try {
        const response = await fetch('{{ route("user.notifications.storeFCMToken") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                fcm_token: JSON.stringify(subscription),
                device_name: 'Web Browser'
            })
        });

        const result = await response.json();
        if (result.success) {
            console.log('FCM token stored successfully');
        }
    } catch (error) {
        console.error('Error storing FCM token:', error);
    }
}

// Toggle switch styling
document.querySelectorAll('.toggle-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        if (this.checked) {
            this.parentElement.classList.add('bg-green-500');
        } else {
            this.parentElement.classList.remove('bg-green-500');
        }
    });
});
</script>

<style>
/* Responsive Font Sizes */
html {
    font-size: 14px;
}

@media (min-width: 640px) {
    html {
        font-size: 15px;
    }
}

@media (min-width: 768px) {
    html {
        font-size: 16px;
    }
}

/* Responsive Scrollbar */
#notificationsList::-webkit-scrollbar {
    width: 4px;
}

@media (min-width: 640px) {
    #notificationsList::-webkit-scrollbar {
        width: 6px;
    }
}

#notificationsList::-webkit-scrollbar-thumb {
    background: linear-gradient(180deg, #10B981, #3B82F6);
    border-radius: 3px;
}

.notification-item {
    transition: all 0.35s ease;
}

.notification-item:hover {
    transform: translateX(3px);
}

@media (min-width: 640px) {
    .notification-item:hover {
        transform: translateX(5px);
    }
}

/* Responsive Toggle Switch */
.toggle-checkbox {
    appearance: none;
    width: 40px;
    height: 22px;
    background: #4B5563;
    border-radius: 11px;
    position: relative;
    cursor: pointer;
    transition: all 0.3s;
}

@media (min-width: 640px) {
    .toggle-checkbox {
        width: 44px;
        height: 24px;
        border-radius: 12px;
    }
}

.toggle-checkbox:checked {
    background: #10B981;
}

.toggle-checkbox::before {
    content: '';
    position: absolute;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background: white;
    top: 2px;
    left: 2px;
    transition: all 0.3s;
}

@media (min-width: 640px) {
    .toggle-checkbox::before {
        width: 20px;
        height: 20px;
    }
}

.toggle-checkbox:checked::before {
    transform: translateX(18px);
}

@media (min-width: 640px) {
    .toggle-checkbox:checked::before {
        transform: translateX(20px);
    }
}

/* Responsive Button Hover Effects */
.quick-reminder-btn {
    transition: all 0.3s ease;
}

.quick-reminder-btn:hover {
    transform: translateY(-1px);
}

@media (min-width: 640px) {
    .quick-reminder-btn:hover {
        transform: translateY(-2px);
    }
}

/* Responsive Modal */
@media (max-width: 640px) {
    #pushPreferencesModal,
    #reminderPreferencesModal {
        padding: 1rem;
    }
    
    #reminderPreferencesModal .bg-gradient-to-br {
        margin: 1rem;
    }
}

/* Touch-friendly improvements */
@media (max-width: 768px) {
    .filter-btn,
    .quick-reminder-btn {
        min-height: 44px; /* Minimum touch target size */
    }
    
    .notification-item {
        padding: 1rem;
    }
}

/* Improved text readability on small screens */
@media (max-width: 640px) {
    .text-xs {
        font-size: 0.7rem;
    }
    
    .text-sm {
        font-size: 0.8rem;
    }
    
    .text-base {
        font-size: 0.9rem;
    }
}

/* Ensure proper spacing on very small screens */
@media (max-width: 360px) {
    .px-3 {
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }
    
    .gap-2 {
        gap: 0.5rem;
    }
    
    .p-4 {
        padding: 0.75rem;
    }
}
</style>
@endsection