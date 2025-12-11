<nav
    x-data="{
        isSidebarOpen: window.innerWidth >= 768,

        init() {
            // Listen untuk resize
            window.addEventListener('resize', () => {
                this.isSidebarOpen = window.innerWidth >= 768;
            });
        },

        closeMobileSidebar() {
            if (window.innerWidth < 768) {
                this.isSidebarOpen = false;
            }
        },

        toggleSidebar() {
            this.isSidebarOpen = !this.isSidebarOpen;
        }
    }"
    class="bg-slate-900/80 backdrop-blur-lg border-r border-slate-700/50 w-64 min-h-screen py-8 px-4 fixed top-0 left-0 z-30
           transform transition-transform duration-300 ease-in-out
           flex flex-col"
    :class="isSidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    @keydown.escape.window="isSidebarOpen = false">

    <!-- Mobile Toggle Button -->
    <button
        @click="toggleSidebar"
        class="md:hidden absolute -right-10 top-8 w-10 h-10 bg-slate-900/80 backdrop-blur-lg border border-slate-700/50 rounded-r-lg flex items-center justify-center z-40">
        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  x-show="!isSidebarOpen" x-cloak d="M4 6h16M4 12h16M4 18h16"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  x-show="isSidebarOpen" x-cloak d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>

    <!-- Header -->
    <div class="px-4 mb-8 flex-shrink-0">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg shadow-green-500/20">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <div>
                <div class="font-bold text-xl text-white">
                    Muscle<span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Xpert</span>
                </div>
                <span class="block text-xs font-semibold text-green-400 uppercase tracking-widest mt-0.5">Admin Panel</span>
            </div>
        </a>
    </div>

    <!-- Navigation -->
    <div class="flex-grow overflow-hidden">
        <nav class="h-full">
            <ul class="space-y-2 h-full overflow-y-auto scrollbar-thin scrollbar-thumb-slate-600 scrollbar-track-slate-800/50 hover:scrollbar-thumb-slate-500 pr-2">

                <!-- Dashboard -->
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                       @click="closeMobileSidebar()"
                       class="group flex items-center px-4 py-3 rounded-xl font-medium transition-all duration-300
                              {{ request()->routeIs('admin.dashboard')
                                 ? 'text-white bg-gradient-to-r from-green-500 to-emerald-600 shadow-lg shadow-green-500/20 transform scale-105'
                                 : 'text-slate-400 hover:text-white hover:bg-slate-800/50 hover:shadow-lg hover:scale-105' }}">
                        <div class="w-8 h-8 mr-3 rounded-lg bg-gradient-to-br from-green-500/20 to-emerald-600/20 flex items-center justify-center group-hover:from-green-500/30 group-hover:to-emerald-600/30 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8"/>
                            </svg>
                        </div>
                        <span class="font-semibold">Dashboard</span>
                    </a>
                </li>

                <!-- Manajemen User -->
                <li>
                    <a href="{{ route('admin.users.index') }}"
                       @click="closeMobileSidebar()"
                       class="group flex items-center px-4 py-3 rounded-xl font-medium transition-all duration-300
                              {{ request()->routeIs('admin.users.*')
                                 ? 'text-white bg-gradient-to-r from-blue-500 to-cyan-600 shadow-lg shadow-blue-500/20 transform scale-105'
                                 : 'text-slate-400 hover:text-white hover:bg-slate-800/50 hover:shadow-lg hover:scale-105' }}">
                        <div class="w-8 h-8 mr-3 rounded-lg bg-gradient-to-br from-blue-500/20 to-cyan-600/20 flex items-center justify-center group-hover:from-blue-500/30 group-hover:to-cyan-600/30 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1z"/>
                            </svg>
                        </div>
                        <span class="font-semibold">Manajemen User</span>
                    </a>
                </li>

                <!-- Member Premium -->
                <li>
                    <a href="{{ route('admin.trainer-memberships.index') }}"
                       @click="closeMobileSidebar()"
                       class="group flex items-center px-4 py-3 rounded-xl font-medium transition-all duration-300
                              {{ request()->routeIs('admin.trainer-memberships.*')
                                 ? 'text-white bg-gradient-to-r from-amber-500 to-yellow-600 shadow-lg shadow-amber-500/20 transform scale-105'
                                 : 'text-slate-400 hover:text-white hover:bg-slate-800/50 hover:shadow-lg hover:scale-105' }}">
                        <div class="w-8 h-8 mr-3 rounded-lg bg-gradient-to-br from-amber-500/20 to-yellow-600/20 flex items-center justify-center group-hover:from-amber-500/30 group-hover:to-yellow-600/30 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2"/>
                            </svg>
                        </div>
                        <span class="font-semibold">Member Premium</span>
                    </a>
                </li>

                <!-- Manajemen Trainer -->
                <li>
                    <a href="{{ route('admin.trainers.index') }}"
                       @click="closeMobileSidebar()"
                       class="group flex items-center px-4 py-3 rounded-xl font-medium transition-all duration-300
                              {{ request()->routeIs('admin.trainers.*')
                                 ? 'text-white bg-gradient-to-r from-orange-500 to-amber-600 shadow-lg shadow-orange-500/20 transform scale-105'
                                 : 'text-slate-400 hover:text-white hover:bg-slate-800/50 hover:shadow-lg hover:scale-105' }}">
                        <div class="w-8 h-8 mr-3 rounded-lg bg-gradient-to-br from-orange-500/20 to-amber-600/20 flex items-center justify-center group-hover:from-orange-500/30 group-hover:to-amber-600/30 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857"/>
                            </svg>
                        </div>
                        <span class="font-semibold">Manajemen Trainer</span>
                    </a>
                </li>

                <!-- Kelola Artikel -->
                <li>
                    <a href="{{ route('admin.articles.index') }}"
                       @click="closeMobileSidebar()"
                       class="group flex items-center px-4 py-3 rounded-xl font-medium transition-all duration-300
                              {{ request()->routeIs('admin.articles.*')
                                 ? 'text-white bg-gradient-to-r from-fuchsia-500 to-pink-600 shadow-lg shadow-fuchsia-500/20 transform scale-105'
                                 : 'text-slate-400 hover:text-white hover:bg-slate-800/50 hover:shadow-lg hover:scale-105' }}">
                        <div class="w-8 h-8 mr-3 rounded-lg bg-gradient-to-br from-fuchsia-500/20 to-pink-600/20 flex items-center justify-center group-hover:from-fuchsia-500/30 group-hover:to-pink-600/30 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                            </svg>
                        </div>
                        <span class="font-semibold">Kelola Artikel</span>
                    </a>
                </li>

                <!-- Program Latihan -->
                <li>
                    <a href="{{ route('admin.workout-plans.index') }}"
                       @click="closeMobileSidebar()"
                       class="group flex items-center px-4 py-3 rounded-xl font-medium transition-all duration-300
                              {{ request()->routeIs('admin.workout-plans.*')
                                 ? 'text-white bg-gradient-to-r from-orange-500 to-red-600 shadow-lg shadow-orange-500/20 transform scale-105'
                                 : 'text-slate-400 hover:text-white hover:bg-slate-800/50 hover:shadow-lg hover:scale-105' }}">
                        <div class="w-8 h-8 mr-3 rounded-lg bg-gradient-to-br from-orange-500/20 to-red-600/20 flex items-center justify-center group-hover:from-orange-500/30 group-hover:to-red-600/30 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12h14V7a2 2 0 00-2-2h-2"/>
                            </svg>
                        </div>
                        <span class="font-semibold">Program Latihan</span>
                    </a>
                </li>

                <!-- Program Nutrisi -->

                <!-- Community Management -->
                <li>
                    <a href="{{ route('admin.communities.index') }}"
                       @click="closeMobileSidebar()"
                       class="group flex items-center px-4 py-3 rounded-xl font-medium transition-all duration-300
                              {{ request()->routeIs('admin.communities.*')
                                 ? 'text-white bg-gradient-to-r from-purple-500 to-indigo-600 shadow-lg shadow-purple-500/20 transform scale-105'
                                 : 'text-slate-400 hover:text-white hover:bg-slate-800/50 hover:shadow-lg hover:scale-105' }}">
                        <div class="w-8 h-8 mr-3 rounded-lg bg-gradient-to-br from-purple-500/20 to-indigo-600/20 flex items-center justify-center group-hover:from-purple-500/30 group-hover:to-indigo-600/30 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <span class="font-semibold">Community Management</span>
                    </a>
                </li>

                <!-- Manajemen Goals -->
                <li>
                    <a href="{{ route('admin.goals.index') }}"
                       @click="closeMobileSidebar()"
                       class="group flex items-center px-4 py-3 rounded-xl font-medium transition-all duration-300
                              {{ request()->routeIs('admin.goals.*')
                                 ? 'text-white bg-gradient-to-r from-violet-500 to-purple-600 shadow-lg shadow-violet-500/20 transform scale-105'
                                 : 'text-slate-400 hover:text-white hover:bg-slate-800/50 hover:shadow-lg hover:scale-105' }}">
                        <div class="w-8 h-8 mr-3 rounded-lg bg-gradient-to-br from-violet-500/20 to-purple-600/20 flex items-center justify-center group-hover:from-violet-500/30 group-hover:to-purple-600/30 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8"/>
                            </svg>
                        </div>
                        <span class="font-semibold">Manajemen Goals</span>
                    </a>
                </li>

                <!-- Broadcast Notifikasi -->
                <li>
                    <a href="{{ route('admin.broadcast.index') }}"
                       @click="closeMobileSidebar()"
                       class="group flex items-center px-4 py-3 rounded-xl font-medium transition-all duration-300
                              {{ request()->routeIs('admin.broadcast.*')
                                 ? 'text-white bg-gradient-to-r from-pink-500 to-rose-600 shadow-lg shadow-pink-500/20 transform scale-105'
                                 : 'text-slate-400 hover:text-white hover:bg-slate-800/50 hover:shadow-lg hover:scale-105' }}">
                        <div class="w-8 h-8 mr-3 rounded-lg bg-gradient-to-br from-pink-500/20 to-rose-600/20 flex items-center justify-center group-hover:from-pink-500/30 group-hover:to-rose-600/30 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405"/>
                            </svg>
                        </div>
                        <span class="font-semibold">Broadcast Notifikasi</span>
                    </a>
                </li>

                <!-- Pesan Kontak -->
                <li>
                    <a href="{{ route('admin.contact.index') }}"
                       @click="closeMobileSidebar()"
                       class="group flex items-center justify-between px-4 py-3 rounded-xl font-medium transition-all duration-300
                              {{ request()->routeIs('admin.contact.*')
                                 ? 'text-white bg-gradient-to-r from-indigo-500 to-blue-600 shadow-lg shadow-indigo-500/20 transform scale-105'
                                 : 'text-slate-400 hover:text-white hover:bg-slate-800/50 hover:shadow-lg hover:scale-105' }}">
                        <div class="flex items-center">
                            <div class="w-8 h-8 mr-3 rounded-lg bg-gradient-to-br from-indigo-500/20 to-blue-600/20 flex items-center justify-center group-hover:from-indigo-500/30 group-hover:to-blue-600/30 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8"/>
                                </svg>
                            </div>
                            <span class="font-semibold">Pesan Kontak</span>
                        </div>
                        @if(isset($unreadContactCount) && $unreadContactCount > 0)
                        <span class="text-xs bg-gradient-to-r from-red-500 to-pink-600 text-white font-bold rounded-full px-2 py-1 min-w-6 h-6 flex items-center justify-center shadow-lg animate-pulse">
                            {{ $unreadContactCount }}
                        </span>
                        @endif
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Logout Button -->
    <div class="px-4 mt-4 flex-shrink-0">
        <form method="POST" action="{{ route('logout') }}" id="logout-form">
            @csrf
            <button type="button"
                    onclick="confirmLogout()"
                    class="group w-full flex items-center px-4 py-3 rounded-xl font-medium transition-all duration-300
                           text-red-400 hover:text-white hover:bg-gradient-to-r from-red-500/20 to-rose-600/20
                           hover:border hover:border-red-500/30 hover:shadow-lg hover:scale-105">
                <div class="w-8 h-8 mr-3 rounded-lg bg-gradient-to-br from-red-500/20 to-rose-600/20 flex items-center justify-center group-hover:from-red-500/30 group-hover:to-rose-600/30 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                </div>
                <span class="font-semibold">Logout</span>
            </button>
        </form>
    </div>

    <!-- Footer -->
    <div class="px-4 mt-4 pt-4 border-t border-slate-700/50 flex-shrink-0">
        <div class="text-xs text-slate-500 text-center">
            <div class="font-semibold text-slate-400 mb-1">MuscleXpert v2.0</div>
            <div>Admin Panel</div>
        </div>
    </div>
</nav>

<!-- Overlay untuk mobile -->
<div x-show="$store.sidebar.isOpen && window.innerWidth < 768"
     @click="$store.sidebar.isOpen = false"
     class="fixed inset-0 bg-black/50 backdrop-blur-sm z-20 transition-opacity duration-300"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     style="display: none;"
     x-cloak></div>

<style>
.scrollbar-thin::-webkit-scrollbar { width: 4px; }
.scrollbar-thin::-webkit-scrollbar-track { background: rgba(30,41,59,0.5); border-radius: 10px; }
.scrollbar-thin::-webkit-scrollbar-thumb { background: rgba(71,85,105,0.8); border-radius: 10px; }
.scrollbar-thin::-webkit-scrollbar-thumb:hover { background: rgba(100,116,139,0.8); }
.scrollbar-thin { scrollbar-width: thin; scrollbar-color: rgba(71,85,105,0.8) rgba(30,41,59,0.5); }
[x-cloak] { display: none !important; }
</style>

<script>
// Initialize Alpine store
document.addEventListener('alpine:init', () => {
    // Store untuk state sidebar global
    Alpine.store('sidebar', {
        isOpen: window.innerWidth >= 768,

        init() {
            // Update state berdasarkan screen size
            window.addEventListener('resize', () => {
                this.isOpen = window.innerWidth >= 768;
            });
        },

        toggle() {
            this.isOpen = !this.isOpen;
        },

        closeMobile() {
            if (window.innerWidth < 768) {
                this.isOpen = false;
            }
        }
    });

    // Store untuk user info
    Alpine.store('user', {
        name: '{{ Auth::user()->name ?? "Admin" }}',
        role: '{{ Auth::user()->role ?? "admin" }}',
        initials: function() {
            return this.name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);
        }
    });
});

// Fungsi untuk logout confirmation
function confirmLogout() {
    if (confirm('Apakah Anda yakin ingin logout?')) {
        document.getElementById('logout-form').submit();
    }
}

// Close sidebar when clicking links on mobile
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('a[href]').forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth < 768) {
                Alpine.store('sidebar').isOpen = false;
            }
        });
    });

    // Escape key to close sidebar
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && window.innerWidth < 768) {
            Alpine.store('sidebar').isOpen = false;
        }
    });
});
</script>
