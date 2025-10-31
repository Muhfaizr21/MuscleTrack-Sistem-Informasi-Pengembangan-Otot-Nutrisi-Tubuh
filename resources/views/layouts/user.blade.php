<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MuscleTrack - User Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800 min-h-screen flex flex-col">

    <!-- ✅ Navbar -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <!-- Logo -->
            <a href="{{ route('user.dashboard') }}" class="font-bold text-lg text-indigo-600 flex items-center gap-1">
                🏋️ <span>MuscleTrack</span>
            </a>

            <!-- ✅ Desktop Menu -->
            <div class="hidden md:flex flex-wrap gap-5 font-medium items-center">

                <!-- My Progress -->
                <a href="{{ route('user.progress.index') }}" 
                   class="relative hover:text-indigo-600 {{ request()->is('user/progress*') ? 'text-indigo-600 font-semibold' : '' }}">
                    My Progress
                    @if($notifications['progress'] ?? false)
                        <span class="absolute -top-1 -right-2 bg-red-500 text-white text-xs rounded-full px-1.5">!</span>
                    @endif
                </a>

                <!-- Workout Plans -->
                <a href="{{ route('user.workouts.index') }}" 
                   class="relative hover:text-indigo-600 {{ request()->is('user/workouts*') ? 'text-indigo-600 font-semibold' : '' }}">
                    Workout Plans
                    @if($notifications['workout'] ?? false)
                        <span class="absolute -top-1 -right-2 bg-red-500 text-white text-xs rounded-full px-1.5">!</span>
                    @endif
                </a>

                <!-- Nutrition & Protein Tracker -->
                <a href="{{ route('user.nutrition.index') }}" 
                   class="relative hover:text-indigo-600 {{ request()->is('user/nutrition*') ? 'text-indigo-600 font-semibold' : '' }}">
                    Nutrition Tracker
                    @if($notifications['nutrition'] ?? false)
                        <span class="absolute -top-1 -right-2 bg-red-500 text-white text-xs rounded-full px-1.5">!</span>
                    @endif
                </a>

                <!-- Weekly Summary -->
                <a href="{{ route('user.weekly-summary.index') }}" 
                   class="relative hover:text-indigo-600 {{ request()->is('user/weekly-summary*') ? 'text-indigo-600 font-semibold' : '' }}">
                    Weekly Summary
                    @if($notifications['summary'] ?? false)
                        <span class="absolute -top-1 -right-2 bg-red-500 text-white text-xs rounded-full px-1.5">!</span>
                    @endif
                </a>

                <!-- Tips & Articles -->
                <a href="{{ route('user.articles.index') }}" 
                   class="relative hover:text-indigo-600 {{ request()->is('user/articles*') ? 'text-indigo-600 font-semibold' : '' }}">
                    Tips & Articles
                    @if($notifications['articles'] ?? false)
                        <span class="absolute -top-1 -right-2 bg-red-500 text-white text-xs rounded-full px-1.5">!</span>
                    @endif
                </a>

                <!-- Chat with Trainer -->
                <a href="{{ route('user.chat.index') }}" 
                   class="relative hover:text-indigo-600 {{ request()->is('user/chat*') ? 'text-indigo-600 font-semibold' : '' }}">
                    Chat Trainer
                    @if($notifications['chat'] ?? false)
                        <span class="absolute -top-1 -right-2 bg-green-500 text-white text-xs rounded-full px-1.5">!</span>
                    @endif
                </a>

                <!-- My Profile -->
                <a href="{{ route('user.profile.index') }}" 
                   class="relative hover:text-indigo-600 {{ request()->is('user/profile*') ? 'text-indigo-600 font-semibold' : '' }}">
                    My Profile
                    @if($notifications['profile'] ?? false)
                        <span class="absolute -top-1 -right-2 bg-yellow-500 text-white text-xs rounded-full px-1.5">!</span>
                    @endif
                </a>

                <!-- Logout -->
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="hover:text-red-500">Logout</button>
                </form>
            </div>

            <!-- Burger Menu (mobile) -->
            <button id="menu-toggle" class="md:hidden text-2xl focus:outline-none">☰</button>
        </div>

        <!-- ✅ Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-200">
            <div class="flex flex-col p-4 space-y-3 font-medium">
                <a href="{{ route('user.progress.index') }}">My Progress</a>
                <a href="{{ route('user.workouts.index') }}">Workout Plans</a>
                <a href="{{ route('user.nutrition.index') }}">Nutrition Tracker</a>
                <a href="{{ route('user.weekly-summary.index') }}">Weekly Summary</a>
                <a href="{{ route('user.articles.index') }}">Tips & Articles</a>
                <a href="{{ route('user.chat.index') }}">Chat Trainer</a>
                <a href="{{ route('user.profile.index') }}">My Profile</a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-red-600 hover:underline">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- ✅ Main Content -->
    <main class="container mx-auto flex-grow py-6 px-4">
        @yield('content')
    </main>

    <!-- ✅ Footer -->
    <footer class="bg-white shadow-inner mt-auto py-4">
        <div class="container mx-auto text-center text-gray-500 text-sm">
            © {{ date('Y') }} <span class="text-indigo-600 font-semibold">MuscleTrack</span> | Built with ❤️ using Laravel 10
        </div>
    </footer>

    <!-- ✅ Script: Toggle Mobile Menu -->
    <script>
        const toggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        toggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>
</html>
