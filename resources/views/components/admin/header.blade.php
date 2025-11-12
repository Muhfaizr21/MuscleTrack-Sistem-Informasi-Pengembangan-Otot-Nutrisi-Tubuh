<header class="sticky top-0 z-20 bg-slate-900/80 backdrop-blur-lg border-b border-slate-700/50">
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
                <button @click="isSidebarOpen = !isSidebarOpen"
                        class="p-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800/50 transition-all duration-300">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>

            <!-- Desktop User Menu (Optional) -->
            <div class="hidden md:flex items-center gap-4">
                <!-- Notifications -->
                <button class="p-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800/50 transition-all duration-300 relative">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM10.5 3.75a6 6 0 0 0-6 6v2.25l-2.47 2.47a.75.75 0 0 0 .53 1.28h15.88a.75.75 0 0 0 .53-1.28L16.5 12V9.75a6 6 0 0 0-6-6z"/>
                    </svg>
                    <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full"></span>
                </button>

                <!-- User Profile -->
                <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-slate-800/50 transition-all duration-300 cursor-pointer">
                    <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center">
                        <span class="text-white text-sm font-bold">A</span>
                    </div>
                    <div class="hidden lg:block">
                        <p class="text-sm font-medium text-white">Admin</p>
                        <p class="text-xs text-slate-400">Administrator</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</header>
