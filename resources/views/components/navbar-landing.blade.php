<nav x-data="{ isNavOpen: false }" class="sticky top-0 z-50 w-full bg-black/70 backdrop-blur-lg border-b border-gray-700/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">

            <div class="flex-shrink-0">
                <a href="/" class="font-serif text-3xl font-bold text-white">
                    Muscle<span class="text-amber-400">Xpert</span>
                </a>
            </div>

            <div class="hidden md:flex items-center space-x-6">

                <div x-data="{ isOpen: false }" class="relative">
                    <button @click="isOpen = !isOpen" class="px-3 py-2 rounded-md text-sm font-medium text-gray-300 hover:text-white flex items-center">
                        My Dashboard
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="isOpen" @click.away="isOpen = false"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         class="absolute z-10 mt-2 w-56 origin-top-left rounded-md shadow-lg bg-black/90 backdrop-blur-lg border border-gray-700 ring-1 ring-black ring-opacity-5 focus:outline-none"
                         style="display: none;">
                        <div class="py-1">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-amber-400">Progres Harian</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-amber-400">My Progress</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-amber-400">Protein Tracker</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-amber-400">Workout Plans</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-amber-400">Nutrition Plans</a>
                        </div>
                    </div>
                </div>

                <a href="{{ route('public.articles.index') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-300 hover:text-white">Tips & Articles</a>
                <a href="{{ route('contact.index') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-300 hover:text-white">Contact Us</a>
            </div>

            <div class="hidden md:block">
                @auth
                    <div x-data="{ isOpen: false }" class="relative ml-4">
                        <button @click="isOpen = !isOpen" class="flex items-center text-sm font-medium text-gray-300 hover:text-white transition duration-150 ease-in-out">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ml-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </button>

                        <div x-show="isOpen" @click.away="isOpen = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             class="absolute z-10 mt-2 w-48 origin-top-right rounded-md shadow-lg bg-black/90 backdrop-blur-lg border border-gray-700 ring-1 ring-black ring-opacity-5 focus:outline-none"
                             style="display: none;">
                            <div class="py-1">
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-amber-400">
                                    Dashboard
                                </a>

                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-amber-400">
                                    Profile
                                </a>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); this.closest('form').submit();"
                                       class="block w-full px-4 py-2 text-left text-sm text-gray-300 hover:bg-gray-800 hover:text-amber-400">
                                        Log Out
                                    </a>
                                </form>
                            </div>
                        </div>
                    </div>

                @else
                    <a href="{{ route('login') }}" class="ml-4 px-4 py-2 rounded-md text-sm font-medium text-gray-300 hover:bg-gray-800">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="ml-2 px-5 py-2.5 rounded-md text-sm font-bold text-black bg-amber-400 hover:bg-amber-300 transition-all">
                        JOIN NOW
                    </a>
                @endauth
            </div>

            <div class="md:hidden flex items-center">
                <button @click="isNavOpen = !isNavOpen" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                </button>
            </div>
        </div>
    </div>

    <div x-show="isNavOpen" class="md:hidden" style="display: none;">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:bg-gray-700">My Dashboard</a>
            <a href="#articles" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:bg-gray-700">Tips & Articles</a>
            <a href="{{ route('contact.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:bg-gray-700">Contact Us</a>

            @auth
                <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:bg-gray-700">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); this.closest('form').submit();"
                       class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:bg-gray-700">
                        Log Out
                    </a>
                </form>
            @else
                <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:bg-gray-700">Login</a>
            @endauth
        </div>
    </div>
</nav>
