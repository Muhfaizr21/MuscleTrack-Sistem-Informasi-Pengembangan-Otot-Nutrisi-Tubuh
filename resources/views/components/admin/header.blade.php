<header class="sticky top-0 z-10 bg-black/70 backdrop-blur-lg border-b border-gray-700/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">

            <div class="font-serif text-3xl font-bold text-white leading-tight">
                {{ $slot }}
            </div>

            <div class="md:hidden">
                <button @click="isSidebarOpen = !isSidebarOpen" class="text-gray-400 hover:text-white">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                </button>
            </div>
        </div>
    </div>
</header>
