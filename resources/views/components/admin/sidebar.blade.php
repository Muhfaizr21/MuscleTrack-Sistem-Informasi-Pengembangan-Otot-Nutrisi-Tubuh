<nav
    class="bg-slate-900/80 backdrop-blur-lg border-r border-slate-700/50 w-64 min-h-screen py-8 px-4 fixed top-0 left-0 z-30
           transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out"
    :class="{ 'translate-x-0': isSidebarOpen }">

    <!-- Header dengan Glass Effect -->
    <div class="px-4 mb-8">
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

    <!-- Navigation Menu dengan Glass Cards -->
    <nav class="flex-grow">
        <ul class="space-y-2">
            <!-- Dashboard -->
            <li>
                <a href="{{ route('admin.dashboard') }}"
                   class="group flex items-center px-4 py-3 rounded-xl font-medium transition-all duration-300
                          {{ request()->routeIs('admin.dashboard')
                             ? 'text-white bg-gradient-to-r from-green-500 to-emerald-600 shadow-lg shadow-green-500/20 transform scale-105'
                             : 'text-slate-400 hover:text-white hover:bg-slate-800/50 hover:shadow-lg hover:scale-105' }}">
                    <div class="w-8 h-8 mr-3 rounded-lg bg-gradient-to-br from-green-500/20 to-emerald-600/20 flex items-center justify-center group-hover:from-green-500/30 group-hover:to-emerald-600/30 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <span class="font-semibold">Dashboard</span>
                </a>
            </li>

            <!-- Manajemen User -->
            <li>
                <a href="{{ route('admin.users.index') }}"
                   class="group flex items-center px-4 py-3 rounded-xl font-medium transition-all duration-300
                          {{ request()->routeIs('admin.users.*')
                             ? 'text-white bg-gradient-to-r from-blue-500 to-cyan-600 shadow-lg shadow-blue-500/20 transform scale-105'
                             : 'text-slate-400 hover:text-white hover:bg-slate-800/50 hover:shadow-lg hover:scale-105' }}">
                    <div class="w-8 h-8 mr-3 rounded-lg bg-gradient-to-br from-blue-500/20 to-cyan-600/20 flex items-center justify-center group-hover:from-blue-500/30 group-hover:to-cyan-600/30 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <span class="font-semibold">Manajemen User</span>
                </a>
            </li>

            <!-- Member Premium -->
            <li>
                <a href="{{ route('admin.trainer-memberships.index') }}"
                   class="group flex items-center px-4 py-3 rounded-xl font-medium transition-all duration-300
                          {{ request()->routeIs('admin.trainer-memberships.*')
                             ? 'text-white bg-gradient-to-r from-amber-500 to-yellow-600 shadow-lg shadow-amber-500/20 transform scale-105'
                             : 'text-slate-400 hover:text-white hover:bg-slate-800/50 hover:shadow-lg hover:scale-105' }}">
                    <div class="w-8 h-8 mr-3 rounded-lg bg-gradient-to-br from-amber-500/20 to-yellow-600/20 flex items-center justify-center group-hover:from-amber-500/30 group-hover:to-yellow-600/30 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                        </svg>
                    </div>
                    <span class="font-semibold">Member Premium</span>
                </a>
            </li>

            <!-- Manajemen Artikel -->
            <li>
                <a href="{{ route('admin.articles.index') }}"
                   class="group flex items-center px-4 py-3 rounded-xl font-medium transition-all duration-300
                          {{ request()->routeIs('admin.articles.*')
                             ? 'text-white bg-gradient-to-r from-purple-500 to-pink-600 shadow-lg shadow-purple-500/20 transform scale-105'
                             : 'text-slate-400 hover:text-white hover:bg-slate-800/50 hover:shadow-lg hover:scale-105' }}">
                    <div class="w-8 h-8 mr-3 rounded-lg bg-gradient-to-br from-purple-500/20 to-pink-600/20 flex items-center justify-center group-hover:from-purple-500/30 group-hover:to-pink-600/30 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 12h6M7 8h6"/>
                        </svg>
                    </div>
                    <span class="font-semibold">Manajemen Artikel</span>
                </a>
            </li>

            <!-- Program Latihan -->
            <li>
                <a href="{{ route('admin.workout-plans.index') }}"
                   class="group flex items-center px-4 py-3 rounded-xl font-medium transition-all duration-300
                          {{ request()->routeIs('admin.workout-plans.*')
                             ? 'text-white bg-gradient-to-r from-orange-500 to-red-600 shadow-lg shadow-orange-500/20 transform scale-105'
                             : 'text-slate-400 hover:text-white hover:bg-slate-800/50 hover:shadow-lg hover:scale-105' }}">
                    <div class="w-8 h-8 mr-3 rounded-lg bg-gradient-to-br from-orange-500/20 to-red-600/20 flex items-center justify-center group-hover:from-orange-500/30 group-hover:to-red-600/30 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                    <span class="font-semibold">Program Latihan</span>
                </a>
            </li>

            <!-- Program Nutrisi -->
            <li>
                <a href="{{ route('admin.nutrition-programs.index') }}"
                   class="group flex items-center px-4 py-3 rounded-xl font-medium transition-all duration-300
                          {{ request()->routeIs('admin.nutrition-programs.*')
                             ? 'text-white bg-gradient-to-r from-emerald-500 to-teal-600 shadow-lg shadow-emerald-500/20 transform scale-105'
                             : 'text-slate-400 hover:text-white hover:bg-slate-800/50 hover:shadow-lg hover:scale-105' }}">
                    <div class="w-8 h-8 mr-3 rounded-lg bg-gradient-to-br from-emerald-500/20 to-teal-600/20 flex items-center justify-center group-hover:from-emerald-500/30 group-hover:to-teal-600/30 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="font-semibold">Program Nutrisi</span>
                </a>
            </li>

            <!-- Log Body Metrics -->
            <li>
                <a href="{{ route('admin.body-metrics.index') }}"
                   class="group flex items-center px-4 py-3 rounded-xl font-medium transition-all duration-300
                          {{ request()->routeIs('admin.body-metrics.*')
                             ? 'text-white bg-gradient-to-r from-cyan-500 to-blue-600 shadow-lg shadow-cyan-500/20 transform scale-105'
                             : 'text-slate-400 hover:text-white hover:bg-slate-800/50 hover:shadow-lg hover:scale-105' }}">
                    <div class="w-8 h-8 mr-3 rounded-lg bg-gradient-to-br from-cyan-500/20 to-blue-600/20 flex items-center justify-center group-hover:from-cyan-500/30 group-hover:to-blue-600/30 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <span class="font-semibold">Log Body Metrics</span>
                </a>
            </li>

            <!-- Manajemen Goals -->
            <li>
                <a href="{{ route('admin.goals.index') }}"
                   class="group flex items-center px-4 py-3 rounded-xl font-medium transition-all duration-300
                          {{ request()->routeIs('admin.goals.*')
                             ? 'text-white bg-gradient-to-r from-violet-500 to-purple-600 shadow-lg shadow-violet-500/20 transform scale-105'
                             : 'text-slate-400 hover:text-white hover:bg-slate-800/50 hover:shadow-lg hover:scale-105' }}">
                    <div class="w-8 h-8 mr-3 rounded-lg bg-gradient-to-br from-violet-500/20 to-purple-600/20 flex items-center justify-center group-hover:from-violet-500/30 group-hover:to-purple-600/30 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                    <span class="font-semibold">Manajemen Goals</span>
                </a>
            </li>

            <!-- Broadcast Notifikasi -->
            <li>
                <a href="{{ route('admin.broadcast.index') }}"
                   class="group flex items-center px-4 py-3 rounded-xl font-medium transition-all duration-300
                          {{ request()->routeIs('admin.broadcast.*')
                             ? 'text-white bg-gradient-to-r from-pink-500 to-rose-600 shadow-lg shadow-pink-500/20 transform scale-105'
                             : 'text-slate-400 hover:text-white hover:bg-slate-800/50 hover:shadow-lg hover:scale-105' }}">
                    <div class="w-8 h-8 mr-3 rounded-lg bg-gradient-to-br from-pink-500/20 to-rose-600/20 flex items-center justify-center group-hover:from-pink-500/30 group-hover:to-rose-600/30 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </div>
                    <span class="font-semibold">Broadcast Notifikasi</span>
                </a>
            </li>

            <!-- Pesan Kontak -->
            <li>
                <a href="{{ route('admin.contact.index') }}"
                   class="group flex items-center justify-between px-4 py-3 rounded-xl font-medium transition-all duration-300
                          {{ request()->routeIs('admin.contact.*')
                             ? 'text-white bg-gradient-to-r from-indigo-500 to-blue-600 shadow-lg shadow-indigo-500/20 transform scale-105'
                             : 'text-slate-400 hover:text-white hover:bg-slate-800/50 hover:shadow-lg hover:scale-105' }}">
                    <div class="flex items-center">
                        <div class="w-8 h-8 mr-3 rounded-lg bg-gradient-to-br from-indigo-500/20 to-blue-600/20 flex items-center justify-center group-hover:from-indigo-500/30 group-hover:to-blue-600/30 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <span class="font-semibold">Pesan Kontak</span>
                    </div>
                    @if(isset($unreadContactCount) && $unreadContactCount > 0)
                    <span class="text-xs bg-gradient-to-r from-red-500 to-pink-600 text-white font-bold rounded-full px-2 py-1 min-w-6 h-6 flex items-center justify-center shadow-lg shadow-red-500/20 animate-pulse">
                        {{ $unreadContactCount }}
                    </span>
                    @endif
                </a>
            </li>

            <!-- Divider dengan Glass Effect -->

        </ul>
    </nav>

    <!-- Footer dengan Version -->
    <div class="px-4 mt-8 pt-4 border-t border-slate-700/50">
        <div class="text-xs text-slate-500 text-center">
            <div class="font-semibold text-slate-400 mb-1">MuscleXpert v2.0</div>
            <div>Admin Panel</div>
        </div>
    </div>
</nav>
