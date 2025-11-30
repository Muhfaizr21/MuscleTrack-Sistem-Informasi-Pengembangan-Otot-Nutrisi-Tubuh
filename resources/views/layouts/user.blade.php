<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MuscleXpert - @yield('title', 'User Dashboard')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@700;800;900&display=swap"
        rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'sans-serif'],
                        'serif': ['"Playfair Display"', 'serif']
                    },
                    colors: {
                        dark: {
                            950: '#000000',
                            900: '#0a0a0a',
                            800: '#1a1a1a',
                            700: '#2a2a2a',
                            600: '#3a3a3a',
                            500: '#4a4a4a'
                        },
                        emerald: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            200: '#a7f3d0',
                            300: '#6ee7b7',
                            400: '#34d399',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                            // Premium Emerald Shades
                            neon: '#00ff9d',
                            electric: '#00ffcc',
                            deep: '#00b386',
                            glow: '#00ffaa'
                        }
                    },
                    animation: {
                        'gradient': 'gradient 8s ease infinite',
                        'float': 'float 6s ease-in-out infinite',
                        'glow': 'glow 2s ease-in-out infinite alternate',
                        'pulse-glow': 'pulse-glow 3s ease-in-out infinite',
                        'neon-flicker': 'neon-flicker 4s ease-in-out infinite'
                    },
                    keyframes: {
                        gradient: {
                            '0%, 100%': {
                                'background-position': '0% 50%'
                            },
                            '50%': {
                                'background-position': '100% 50%'
                            }
                        },
                        float: {
                            '0%, 100%': {
                                transform: 'translateY(0px)'
                            },
                            '50%': {
                                transform: 'translateY(-10px)'
                            }
                        },
                        glow: {
                            '0%': {
                                'box-shadow': '0 0 20px rgba(0, 255, 170, 0.4)'
                            },
                            '100%': {
                                'box-shadow': '0 0 40px rgba(0, 255, 170, 0.8)'
                            }
                        },
                        'pulse-glow': {
                            '0%, 100%': {
                                'box-shadow': '0 0 25px rgba(0, 255, 170, 0.5)',
                                'transform': 'scale(1)'
                            },
                            '50%': {
                                'box-shadow': '0 0 50px rgba(0, 255, 170, 0.9)',
                                'transform': 'scale(1.02)'
                            }
                        },
                        'neon-flicker': {
                            '0%, 18%, 22%, 25%, 53%, 57%, 100%': {
                                'text-shadow': '0 0 5px #00ff9d, 0 0 10px #00ff9d, 0 0 15px #00ff9d, 0 0 20px #00ff9d, 0 0 30px #00ff9d, 0 0 40px #00ff9d'
                            },
                            '20%, 24%, 55%': {
                                'text-shadow': 'none'
                            }
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #000000;
            color: #ffffff;
        }

        /* Premium Dark Background with Emerald Accents - Enhanced */
        .premium-dark-bg {
            background:
                radial-gradient(ellipse 80% 50% at 50% -20%, rgba(0, 255, 170, 0.25), transparent),
                radial-gradient(ellipse 50% 50% at 100% 0%, rgba(0, 255, 204, 0.2), transparent),
                radial-gradient(ellipse 50% 50% at 0% 100%, rgba(0, 255, 157, 0.2), transparent),
                linear-gradient(135deg, #000000 0%, #0a0a0a 50%, #000000 100%);
            background-attachment: fixed;
        }

        /* Animated Grid Pattern - Enhanced */
        .grid-pattern {
            background-image:
                linear-gradient(rgba(0, 255, 170, 0.15) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 255, 170, 0.15) 1px, transparent 1px);
            background-size: 50px 50px;
            background-position: center center;
            animation: gridMove 20s linear infinite;
        }

        @keyframes gridMove {
            0% {
                background-position: 0 0;
            }
            100% {
                background-position: 50px 50px;
            }
        }

        /* Glass Morphism Effect - Enhanced */
        .glass {
            background: rgba(10, 10, 10, 0.8);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(0, 255, 170, 0.3);
            box-shadow: 0 8px 32px rgba(0, 255, 170, 0.1);
        }

        .glass-dark {
            background: rgba(0, 0, 0, 0.85);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(0, 255, 170, 0.4);
            box-shadow: 0 8px 32px rgba(0, 255, 170, 0.15);
        }

        /* Custom Scrollbar - Enhanced */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #0a0a0a;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #00ff9d, #00b386);
            border-radius: 6px;
            box-shadow: 0 0 10px rgba(0, 255, 170, 0.5);
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #00ffcc, #00ff9d);
            box-shadow: 0 0 15px rgba(0, 255, 170, 0.8);
        }

        [x-cloak] {
            display: none !important;
        }

        /* Text Gradients - Enhanced */
        .text-gradient {
            background: linear-gradient(135deg, #00ff9d 0%, #00ffcc 50%, #6ee7b7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: neon-flicker 4s ease-in-out infinite;
        }

        /* Hover Glow Effect - Enhanced */
        .hover-glow:hover {
            box-shadow: 0 0 30px rgba(0, 255, 170, 0.6);
            transform: translateY(-2px);
            transition: all 0.3s ease;
        }

        /* Premium Button Styles */
        .btn-premium {
            background: linear-gradient(135deg, #00ff9d, #00ffcc);
            color: #000;
            font-weight: 700;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 255, 170, 0.4);
            transition: all 0.3s ease;
        }

        .btn-premium:hover {
            background: linear-gradient(135deg, #00ffcc, #00ff9d);
            box-shadow: 0 6px 20px rgba(0, 255, 170, 0.6);
            transform: translateY(-2px);
        }

        /* Neon Border Effect */
        .neon-border {
            position: relative;
            border: 1px solid rgba(0, 255, 170, 0.5);
            box-shadow: 0 0 10px rgba(0, 255, 170, 0.3), inset 0 0 10px rgba(0, 255, 170, 0.1);
        }

        .neon-border::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, #00ff9d, #00ffcc, #00ff9d);
            border-radius: inherit;
            z-index: -1;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .neon-border:hover::before {
            opacity: 1;
            animation: glow 2s ease-in-out infinite alternate;
        }

        html,
        body {
            background: #000 !important;
            color-scheme: dark;
            overflow-x: hidden;
        }

        * {
            background-color: transparent !important;
        }

        body::-webkit-scrollbar-track {
            background: #000000 !important;
        }

        html {
            background-color: #000 !important;
        }

        /* Enhanced Active State for Menu Items */
        .menu-item-active {
            background: rgba(0, 255, 170, 0.15) !important;
            color: #00ffcc !important;
            border: 1px solid rgba(0, 255, 170, 0.4) !important;
            box-shadow: 0 0 15px rgba(0, 255, 170, 0.3) !important;
        }
    </style>

    @yield('styles')
</head>

<body class="premium-dark-bg text-white min-h-screen flex flex-col relative overflow-x-hidden">
    <!-- Animated Background Elements - Enhanced -->
    <div class="fixed inset-0 grid-pattern opacity-15 z-0"></div>

    <!-- Floating Elements - Enhanced -->
    <div class="fixed top-1/4 left-1/4 w-96 h-96 bg-emerald-glow/10 rounded-full blur-3xl animate-float z-0"></div>
    <div class="fixed bottom-1/3 right-1/4 w-80 h-80 bg-emerald-electric/10 rounded-full blur-3xl animate-float z-0"
        style="animation-delay: 2s;"></div>
    <div class="fixed top-1/2 left-1/2 w-64 h-64 bg-emerald-neon/10 rounded-full blur-3xl animate-float z-0"
        style="animation-delay: 4s;"></div>
    <div class="fixed top-3/4 right-1/3 w-72 h-72 bg-emerald-deep/10 rounded-full blur-3xl animate-float z-0"
        style="animation-delay: 1s;"></div>

    <!-- Premium Navigation - Enhanced -->
    <nav x-data="{ isMobileMenuOpen: false, isProfileOpen: false }"
        class="sticky top-0 z-50 w-full glass-dark border-b border-emerald-500/30 shadow-2xl shadow-emerald-500/20">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">

                <!-- Premium Logo - Enhanced -->
                <div class="flex items-center gap-6">
                    <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 group">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-emerald-neon to-emerald-deep rounded-2xl flex items-center justify-center group-hover:scale-110 transition-all duration-500 animate-pulse-glow">
                            <span class="text-white font-black text-xl">M</span>
                        </div>
                        <span class="font-black text-3xl text-white tracking-tight">
                            Muscle<span class="text-gradient">Xpert</span>
                        </span>
                    </a>

                    <!-- Premium Desktop Menu - Enhanced -->
                    <div class="hidden md:flex items-center space-x-1">
                        @php
                            $menuItems = [
                                ['route' => 'user.progress.index', 'label' => 'My Progress', 'icon' => '📊'],
                                ['route' => 'user.workouts.index', 'label' => 'Workout Plans', 'icon' => '💪'],
                                ['route' => 'user.nutrition.index', 'label' => 'Nutrition', 'icon' => '🥗'],
                                ['route' => 'user.training.index', 'label' => 'Training', 'icon' => '🏋️'],
                                ['route' => 'user.articles.index', 'label' => 'Articles', 'icon' => '📚']
                            ];
                        @endphp

                        @foreach($menuItems as $item)
                            <a href="{{ route($item['route']) }}"
                                class="flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold text-gray-300 hover:text-white hover:bg-emerald-500/15 transition-all duration-300 border border-transparent hover:border-emerald-500/40 hover-glow neon-border {{ request()->is(str_replace('user.', '', $item['route']) . '*') ? 'menu-item-active' : '' }}">
                                <span class="text-lg">{{ $item['icon'] }}</span>
                                {{ $item['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Premium Right Section - Enhanced -->
                <div class="flex items-center gap-4">

                    <!-- Premium Notifications - Enhanced -->
                    <a href="{{ route('user.notifications.index') }}"
                        class="relative p-3 rounded-xl text-gray-400 hover:text-white hover:bg-emerald-500/15 transition-all duration-300 border border-transparent hover:border-emerald-500/40 hover-glow neon-border">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>

                        @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                            <span class="absolute -top-1 -right-1 flex h-6 w-6">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-500 opacity-75"></span>
                                <span
                                    class="relative inline-flex rounded-full h-6 w-6 bg-gradient-to-br from-red-500 to-red-600 text-white text-xs font-black items-center justify-center border border-red-400/50 shadow-lg shadow-red-500/30">
                                    {{ $unreadNotificationsCount }}
                                </span>
                            </span>
                        @endif
                    </a>

                    <!-- Premium User Profile Dropdown - Enhanced -->
                    <div class="hidden md:block relative">
                        <button @click="isProfileOpen = !isProfileOpen"
                            class="flex items-center gap-3 px-4 py-2 rounded-xl text-sm font-semibold text-gray-300 hover:text-white hover:bg-emerald-500/15 transition-all duration-300 border border-transparent hover:border-emerald-500/40 hover-glow neon-border">
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-emerald-neon to-emerald-deep rounded-xl flex items-center justify-center border border-emerald-400/40 shadow-lg shadow-emerald-500/20">
                                <span
                                    class="text-white font-black text-sm">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            </div>
                            <span class="max-w-32 truncate">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4 transition-transform duration-300 text-emerald-400"
                                :class="{ 'rotate-180': isProfileOpen }" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="isProfileOpen" @click.away="isProfileOpen = false"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-3 w-64 origin-top-right rounded-2xl glass-dark border border-emerald-500/40 shadow-2xl shadow-emerald-500/30 py-3"
                            x-cloak>

                            <div class="px-4 py-3 border-b border-emerald-500/30">
                                <p class="text-xs text-emerald-400 font-semibold uppercase tracking-wider">Signed in as
                                </p>
                                <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->email }}</p>
                            </div>

                            <div class="py-2 space-y-1">
                                @php
                                    $profileItems = [
                                        ['route' => 'user.weekly-summary.index', 'label' => 'Weekly Summary', 'icon' => '📈'],
                                        ['route' => 'user.chat.index', 'label' => 'Trainer Chat', 'icon' => '💬'],
                                        ['route' => 'user.training.my-trainer', 'label' => 'My Trainer', 'icon' => '👨‍🏫'],
                                        ['route' => 'user.profile.index', 'label' => 'My Profile', 'icon' => '👤']
                                    ];
                                @endphp

                                @foreach($profileItems as $item)
                                    <a href="{{ route($item['route']) }}"
                                        class="flex items-center gap-3 px-4 py-3 text-sm text-gray-300 hover:text-white hover:bg-emerald-500/15 transition-all duration-200 group neon-border rounded-lg mx-2">
                                        <span class="text-lg">{{ $item['icon'] }}</span>
                                        <span class="font-medium group-hover:text-emerald-400">{{ $item['label'] }}</span>
                                    </a>
                                @endforeach
                            </div>

                            <div class="pt-2 border-t border-emerald-500/30 mx-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center gap-3 w-full px-4 py-3 text-sm text-red-400 hover:text-red-300 hover:bg-red-500/15 transition-all duration-200 group rounded-lg neon-border">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        <span class="font-semibold">Log Out</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Premium Mobile Menu Button - Enhanced -->
                    <button @click="isMobileMenuOpen = !isMobileMenuOpen"
                        class="md:hidden inline-flex items-center justify-center p-3 rounded-xl text-gray-400 hover:text-white hover:bg-emerald-500/15 transition-all duration-300 border border-transparent hover:border-emerald-500/40 hover-glow neon-border">
                        <svg class="h-6 w-6" :class="{ 'hidden': isMobileMenuOpen, 'block': !isMobileMenuOpen }"
                            stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg class="h-6 w-6" :class="{ 'block': isMobileMenuOpen, 'hidden': !isMobileMenuOpen }"
                            stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Premium Mobile Menu - Enhanced -->
        <div x-show="isMobileMenuOpen" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95" class="md:hidden glass-dark border-t border-emerald-500/30"
            x-cloak>

            <div class="px-4 py-6 space-y-4">
                <!-- Main Menu -->
                <div class="space-y-2">
                    <h3 class="text-gradient text-sm font-black uppercase tracking-wider px-3 pb-2">Main Menu</h3>
                    @foreach($menuItems as $item)
                        <a href="{{ route($item['route']) }}"
                            class="flex items-center gap-3 px-4 py-4 rounded-xl text-base font-semibold text-gray-300 hover:text-white hover:bg-emerald-500/15 transition-all duration-300 border border-transparent hover:border-emerald-500/40 group neon-border">
                            <span class="text-xl">{{ $item['icon'] }}</span>
                            <span class="group-hover:text-emerald-400">{{ $item['label'] }}</span>
                        </a>
                    @endforeach
                </div>

                <!-- User Section -->
                <div class="pt-4 border-t border-emerald-500/30 space-y-2">
                    @foreach($profileItems as $item)
                        <a href="{{ route($item['route']) }}"
                            class="flex items-center gap-3 px-4 py-4 rounded-xl text-base font-semibold text-gray-300 hover:text-white hover:bg-emerald-500/15 transition-all duration-300 border border-transparent hover:border-emerald-500/40 group neon-border">
                            <span class="text-xl">{{ $item['icon'] }}</span>
                            <span class="group-hover:text-emerald-400">{{ $item['label'] }}</span>
                        </a>
                    @endforeach

                    <a href="{{ route('user.notifications.index') }}"
                        class="flex items-center justify-between px-4 py-4 rounded-xl text-base font-semibold text-gray-300 hover:text-white hover:bg-emerald-500/15 transition-all duration-300 border border-transparent hover:border-emerald-500/40 group neon-border">
                        <div class="flex items-center gap-3">
                            <span class="text-xl">🔔</span>
                            <span class="group-hover:text-emerald-400">Notifications</span>
                        </div>
                        @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                            <span
                                class="text-xs bg-gradient-to-br from-red-500 to-red-600 text-white font-black rounded-full px-2 py-1 min-w-6 text-center border border-red-400/50 shadow-lg shadow-red-500/30">
                                {{ $unreadNotificationsCount }}
                            </span>
                        @endif
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="pt-2">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-3 w-full px-4 py-4 rounded-xl text-base font-semibold text-red-400 hover:text-red-300 hover:bg-red-500/15 transition-all duration-300 border border-transparent hover:border-red-500/40 group neon-border">
                            <span class="text-xl">🚪</span>
                            <span>Log Out</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Premium Main Content -->
    <main class="flex-grow py-8 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>

    <!-- Premium Footer - Enhanced -->
    <footer class="glass-dark border-t border-emerald-500/30 py-8 mt-auto relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <div class="flex items-center justify-center gap-3 mb-4">
                    <div
                        class="w-8 h-8 bg-gradient-to-br from-emerald-neon to-emerald-deep rounded-lg flex items-center justify-center animate-pulse-glow">
                        <span class="text-white font-black text-sm">M</span>
                    </div>
                    <span class="font-black text-xl text-white">
                        Muscle<span class="text-gradient">Xpert</span>
                    </span>
                </div>
                <p class="text-emerald-400/80 text-sm font-semibold">
                    © {{ date('Y') }} Built with <span class="text-red-400">❤️</span> MuscleXpert Team
                </p>
            </div>
        </div>
    </footer>

    @yield('scripts')
</body>

</html>