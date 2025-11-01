<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MuscleXpert - User Dashboard</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'sans-serif'],
                        'serif': ['"Playfair Display"', 'serif']
                    },
                    colors: {
                        'amber': tailwind.colors.amber,
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #000;
        }
        .parallax-bg {
            background-image: url('https://images.unsplash.com/photo-1549060279-7e168f983401?q=80&w=2832&auto:format&fit=crop');
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            z-index: -1;
            opacity: 0.15;
        }
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="bg-black text-gray-200 min-h-screen flex flex-col">

    <div class="parallax-bg"></div>

    <nav class="bg-black/80 backdrop-blur-lg border-b border-gray-700/50 sticky top-0 z-50"
         x-data="{ isMobileMenuOpen: false, isProfileOpen: false }">

        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">

                <div class="flex items-center gap-6">
                    <a href="#" class="font-serif text-3xl font-bold text-white">
                        Muscle<span class="text-amber-400">Xpert</span>
                    </a>

                    <div class="hidden md:flex flex-wrap gap-5 font-medium items-center">
                        <a href="{{ route('user.progress.index') }}"
                           class="relative text-gray-300 hover:text-white transition {{ request()->is('user/progress*') ? 'text-amber-400 font-semibold' : '' }}">
                            My Progress
                            @if($notifications['progress'] ?? false)
                                <span class="absolute -top-1 -right-2 bg-red-500 text-white text-[10px] rounded-full px-1.5 leading-tight">!</span>
                            @endif
                        </a>
                        <a href="{{ route('user.workouts.index') }}"
                           class="relative text-gray-300 hover:text-white transition {{ request()->is('user/workouts*') ? 'text-amber-400 font-semibold' : '' }}">
                            Workout Plans
                            @if($notifications['workout'] ?? false)
                                <span class="absolute -top-1 -right-2 bg-red-500 text-white text-[10px] rounded-full px-1.5 leading-tight">!</span>
                            @endif
                        </a>
                        <a href="{{ route('user.nutrition.index') }}"
                           class="relative text-gray-300 hover:text-white transition {{ request()->is('user/nutrition*') ? 'text-amber-400 font-semibold' : '' }}">
                            Nutrition Tracker
                            @if($notifications['nutrition'] ?? false)
                                <span class="absolute -top-1 -right-2 bg-red-500 text-white text-[10px] rounded-full px-1.5 leading-tight">!</span>
                            @endif
                        </a>
                        <a href="{{ route('user.articles.index') }}"
                           class="relative text-gray-300 hover:text-white transition {{ request()->is('user/articles*') ? 'text-amber-400 font-semibold' : '' }}">
                            Tips & Articles
                            @if($notifications['articles'] ?? false)
                                <span class="absolute -top-1 -right-2 bg-red-500 text-white text-[10px] rounded-full px-1.5 leading-tight">!</span>
                            @endif
                        </a>

                    </div>
                </div>

                <div class="flex items-center gap-4">

                    <div class="hidden md:block relative">
                        <button @click="isProfileOpen = !isProfileOpen"
                                class="flex items-center gap-1 text-gray-300 hover:text-white transition">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <div x-show="isProfileOpen"
                             @click.away="isProfileOpen = false"
                             x-transition
                             x-cloak
                             class="absolute right-0 mt-2 w-48 bg-black/90 backdrop-blur-lg border border-gray-700/50 rounded-lg shadow-lg py-1 z-50">

                            <a href="{{ route('user.weekly-summary.index') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white">Weekly Summary</a>

                            <a href="{{ route('user.chat.index') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white">Chat Trainer</a>
                            <a href="{{ route('user.profile.index') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white">My Profile</a>

                            <div class="border-t border-gray-700/50 my-1"></div>

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-gray-800 hover:text-red-300">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>

                    <button @click="isMobileMenuOpen = !isMobileMenuOpen" class="md:hidden text-gray-300 hover:text-white text-2xl focus:outline-none">
                        <svg x-show="!isMobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                        <svg x-show="isMobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

            </div>
        </div>

        <div x-show="isMobileMenuOpen" class="md:hidden bg-black/90 backdrop-blur-lg border-t border-gray-700/50" x-cloak>
            <div class="flex flex-col p-4 space-y-3 font-medium">
                <h3 class="text-amber-400 text-xs uppercase font-bold tracking-wider px-2 pt-2">Menu Utama</h3>
                <a href="{{ route('user.progress.index') }}" class="block p-2 text-gray-300 rounded-md hover:bg-gray-800 hover:text-white">My Progress</a>
                <a href="{{ route('user.workouts.index') }}" class="block p-2 text-gray-300 rounded-md hover:bg-gray-800 hover:text-white">Workout Plans</a>
                <a href="{{ route('user.nutrition.index') }}" class="block p-2 text-gray-300 rounded-md hover:bg-gray-800 hover:text-white">Nutrition Tracker</a>

                <h3 class="text-amber-400 text-xs uppercase font-bold tracking-wider px-2 pt-2">Lainnya</h3>
                <a href="{{ route('user.weekly-summary.index') }}" class="block p-2 text-gray-300 rounded-md hover:bg-gray-800 hover:text-white">Weekly Summary</a>
                <a href="{{ route('user.articles.index') }}" class="block p-2 text-gray-300 rounded-md hover:bg-gray-800 hover:text-white">Tips & Articles</a>
                <a href="{{ route('user.chat.index') }}" class="block p-2 text-gray-300 rounded-md hover:bg-gray-800 hover:text-white">Chat Trainer</a>
                <a href="{{ route('user.profile.index') }}" class="block p-2 text-gray-300 rounded-md hover:bg-gray-800 hover:text-white">My Profile</a>

                <form action="{{ route('logout') }}" method="POST" class="border-t border-gray-700/50 pt-3 mt-2">
                    @csrf
                    <button type="submit" class="w-full text-left p-2 text-red-500 rounded-md hover:bg-red-900/50 hover:text-red-400">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="w-full flex-grow py-6 px-4">
        @yield('content')
    </main>

    <footer class="bg-black border-t border-gray-700/50 mt-auto py-4">
        <div class="container mx-auto text-center text-gray-500 text-sm">
            © {{ date('Y') }} <span class="text-amber-400 font-semibold">MuscleXpert</span> | Dibuat dengan &hearts; oleh Tim Anda
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
