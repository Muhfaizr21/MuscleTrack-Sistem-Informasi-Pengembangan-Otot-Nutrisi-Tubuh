<!-- resources/views/components/admin/header.blade.php -->
<header
    class="sticky top-0 z-20 bg-slate-900/80 backdrop-blur-lg border-b border-slate-700/50"
    x-data="{
        isUserMenuOpen: false,
        isNotificationOpen: false
    }"
    @click.outside="isUserMenuOpen = false; isNotificationOpen = false"
    @keydown.escape.window="isUserMenuOpen = false; isNotificationOpen = false">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">

            <!-- Page Title -->
            <div class="font-bold text-2xl text-white leading-tight">
                <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">
                    {{ $slot }}
                </span>
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <button @click="window.isSidebarOpen = !window.isSidebarOpen"
                        class="p-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800/50 transition-all duration-300">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>

            <!-- Desktop User Menu -->
            <div class="hidden md:flex items-center gap-3">
                <!-- Notifications -->
                <div class="relative">
                    <button @click="isNotificationOpen = !isNotificationOpen"
                            class="p-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800/50 transition-all duration-300 relative">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM10.5 3.75a6 6 0 0 0-6 6v2.25l-2.47 2.47a.75.75 0 0 0 .53 1.28h15.88a.75.75 0 0 0 .53-1.28L16.5 12V9.75a6 6 0 0 0-6-6z"/>
                        </svg>
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full animate-pulse"></span>
                    </button>

                    <!-- Notification Dropdown -->
                    <div x-show="isNotificationOpen"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute top-full right-0 mt-2 w-80 bg-slate-800/90 backdrop-blur-lg border border-slate-700/50 rounded-xl shadow-2xl shadow-black/30 z-30"
                         x-cloak>
                        <div class="p-4 border-b border-slate-700/50">
                            <h3 class="font-semibold text-white">Notifikasi</h3>
                        </div>
                        <div class="p-4 text-center text-slate-400 text-sm">
                            Tidak ada notifikasi baru
                        </div>
                    </div>
                </div>

                <!-- User Profile Dropdown -->
                <div class="relative">
                    <button @click="isUserMenuOpen = !isUserMenuOpen"
                            class="flex items-center gap-3 p-2 rounded-lg hover:bg-slate-800/50 transition-all duration-300 cursor-pointer">
                        <div class="w-9 h-9 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center shadow-lg shadow-green-500/20">
                            <span class="text-white text-sm font-bold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>
                        </div>
                        <div class="hidden lg:block text-left">
                            <p class="text-sm font-semibold text-white">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-400 capitalize">
                                @if(auth()->user()->role === 'admin')
                                    Administrator
                                @elseif(auth()->user()->role === 'trainer')
                                    Pelatih
                                @else
                                    Pengguna
                                @endif
                            </p>
                        </div>
                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-300"
                             :class="isUserMenuOpen ? 'rotate-180' : ''"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="isUserMenuOpen"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute top-full right-0 mt-2 w-56 bg-slate-800/90 backdrop-blur-lg border border-slate-700/50 rounded-xl shadow-2xl shadow-black/30 z-30"
                         x-cloak>
                        <!-- User Info -->
                        <div class="p-4 border-b border-slate-700/50">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center shadow-lg shadow-green-500/20">
                                    <span class="text-white text-sm font-bold">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-white">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-slate-400">{{ auth()->user()->email }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Menu Items -->
                        <div class="p-2 space-y-1">
                            @if(Route::has('admin.profile.edit'))
                            <a href="{{ route('admin.profile.edit') }}"
                               class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-700/50 transition-all duration-300 group">
                                <div class="w-8 h-8 rounded-lg bg-slate-700/50 flex items-center justify-center group-hover:bg-slate-600/50 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <span class="font-medium">Profil Saya</span>
                            </a>
                            @endif

                            @if(Route::has('admin.settings.edit'))
                            <a href="{{ route('admin.settings.edit') }}"
                               class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-700/50 transition-all duration-300 group">
                                <div class="w-8 h-8 rounded-lg bg-slate-700/50 flex items-center justify-center group-hover:bg-slate-600/50 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <span class="font-medium">Pengaturan</span>
                            </a>
                            @endif

                            @if(Route::has('admin.help-support.index'))
                            <a href="{{ route('admin.help-support.index') }}"
                               class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-700/50 transition-all duration-300 group">
                                <div class="w-8 h-8 rounded-lg bg-slate-700/50 flex items-center justify-center group-hover:bg-slate-600/50 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="font-medium">Bantuan & Support</span>
                            </a>
                            @endif
                        </div>

                        <!-- Logout Button -->
                        <div class="p-2 border-t border-slate-700/50">
                            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                @csrf
                                <button type="button"
                                        onclick="confirmLogout()"
                                        class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-red-400 hover:text-white hover:bg-red-500/10 transition-all duration-300 group border border-transparent hover:border-red-500/20">
                                    <div class="w-8 h-8 rounded-lg bg-red-500/10 flex items-center justify-center group-hover:bg-red-500/20 transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                    </div>
                                    <span class="font-medium">Keluar</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
// Fungsi untuk logout confirmation
function confirmLogout() {
    if (confirm('Apakah Anda yakin ingin logout?')) {
        document.getElementById('logout-form').submit();
    }
}
</script>

<style>
[x-cloak] { display: none !important; }
</style>
