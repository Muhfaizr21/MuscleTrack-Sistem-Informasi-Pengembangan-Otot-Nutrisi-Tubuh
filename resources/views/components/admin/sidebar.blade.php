   <nav
            class="bg-black/80 backdrop-blur-lg border-r border-gray-700/50 w-64 min-h-screen py-8 px-4 fixed top-0 left-0 z-30
                   transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out"
            :class="{ 'translate-x-0': isSidebarOpen }">

            <div class="px-4 mb-8">
                <a href="/" class="font-serif text-3xl font-bold text-white">
                    Muscle<span class="text-amber-400">Xpert</span>
                </a>
                <span class="block text-xs font-medium text-amber-400 uppercase tracking-widest">Admin Panel</span>
            </div>

            <nav class="flex-grow">
                <ul class="space-y-2">
                    <<li>
    <a href="{{ route('admin.dashboard') }}"
       class="flex items-center px-4 py-3 rounded-md font-medium transition-all
              {{ request()->routeIs('admin.dashboard')
                 ? 'text-black bg-amber-400 shadow-lg shadow-amber-500/20'
                 : 'text-gray-400 hover:text-white hover:bg-gray-800/50' }}">
        <span class="w-6 h-6 mr-3"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg></span>
        <span>Dashboard</span>
    </a>
</li>

<li>
    <a href="{{ route('admin.users.index') }}"
       class="flex items-center px-4 py-3 rounded-md font-medium transition-all
              {{ request()->routeIs('admin.users.*')
                 ? 'text-black bg-amber-400 shadow-lg shadow-amber-500/20'
                 : 'text-gray-400 hover:text-white hover:bg-gray-800/50' }}">
        <span class="w-6 h-6 mr-3"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg></span>
        <span>Manajemen User</span>
    </a>
</li>
                    <li>
                        <a href="#"
                           class="flex items-center px-4 py-3 rounded-md font-medium text-gray-400 hover:text-white hover:bg-gray-800/50 transition-all">
                            <span class="w-6 h-6 mr-3"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0c-1.657 0-3-.895-3-2s1.343-2 3-2 3-.895 3-2 1.343-2 3-2m0 8c1.11 0 2.08-.402 2.599-1M12 16V7m0 9v1m0-1c-1.11 0-2.08.402-2.599 1M12 16c1.657 0 3 .895 3 2s-1.343 2-3 2-3-.895-3-2 1.343-2 3-2z"></path></svg></span>
                            <span>Riwayat Premium</span>
                        </a>
                    </li>

                   </li>

<li>
    <a href="{{ route('admin.articles.index') }}"
       class="flex items-center px-4 py-3 rounded-md font-medium transition-all
              {{ request()->routeIs('admin.articles.*')
                 ? 'text-black bg-amber-400 shadow-lg shadow-amber-500/20'
                 : 'text-gray-400 hover:text-white hover:bg-gray-800/50' }}">
        <span class="w-6 h-6 mr-3"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 12h6M7 8h6"></path></svg></span>
        <span>Manajemen Artikel</span>
    </a>
</li>

                    <li>
                        <a href="#"
                           class="flex items-center px-4 py-3 rounded-md font-medium text-gray-400 hover:text-white hover:bg-gray-800/50 transition-all">
                            <span class="w-6 h-6 mr-3"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg></span>
                            <span>Workout Plans</span>
                        </a>
                    </li>

                    <li>
                        <a href="#"
                           class="flex items-center px-4 py-3 rounded-md font-medium text-gray-400 hover:text-white hover:bg-gray-800/50 transition-all">
                            <span class="w-6 h-6 mr-3"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></span>
                            <span>Nutrition Plans</span>
                        </a>
                    </li>

                    <li>
                        <a href="#"
                           class="flex items-center px-4 py-3 rounded-md font-medium text-gray-400 hover:text-white hover:bg-gray-800/50 transition-all">
                            <span class="w-6 h-6 mr-3"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg></span>
                            <span>Supplements</span>
                        </a>
                    </li>

                    <li>
                        <a href="#"
                           class="flex items-center px-4 py-3 rounded-md font-medium text-gray-400 hover:text-white hover:bg-gray-800/50 transition-all">
                            <span class="w-6 h-6 mr-3"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path></svg></span>
                            <span>Goals (Tujuan)</span>
                        </a>
                    </li>

                    <li>
                        <a href="#"
                           class="flex items-center px-4 py-3 rounded-md font-medium text-gray-400 hover:text-white hover:bg-gray-800/50 transition-all">
                            <span class="w-6 h-6 mr-3"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg></span>
                            <span>Pesan Kontak</span>
                        </a>
                    </li>

                    <li class="border-t border-gray-700/50 pt-2">
                         <a href="#"
                           class="flex items-center px-4 py-3 rounded-md font-medium text-gray-400 hover:text-white hover:bg-gray-800/50 transition-all">
                            <span class="w-6 h-6 mr-3"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg></span>
                            <span>Profil Anda</span>
                        </a>
                    </li>
                    <li>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); this.closest('form').submit();"
           class="flex items-center px-4 py-3 rounded-md font-medium text-gray-400 hover:text-white hover:bg-gray-800/50 transition-all">
            <span class="w-6 h-6 mr-3"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg></span>
            <span>Log Out</span>
        </a>
    </form>
</li>
                </ul>
            </nav>
        </nav>
