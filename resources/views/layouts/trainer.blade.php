<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainer Panel - @yield('title', 'Dashboard')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- AlpineJS untuk interaktivitas --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Font Modern --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@700;800&display=swap"
        rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        .font-display {
            font-family: 'Outfit', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #0a0f0d 0%, #0d1410 50%, #0a0f0d 100%);
            background-attachment: fixed;
        }

        .text-gradient {
            background: linear-gradient(135deg, #10b981 0%, #34d399 50%, #6ee7b7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .glass-nav {
            background: rgba(13, 20, 16, 0.95);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(16, 185, 129, 0.2);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
        }

        .glass-card {
            background: rgba(17, 25, 21, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(16, 185, 129, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .glass-footer {
            background: rgba(13, 20, 16, 0.9);
            backdrop-filter: blur(20px);
            border-top: 1px solid rgba(16, 185, 129, 0.15);
        }

        .nav-link-top {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .nav-link-top::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 3px;
            background: linear-gradient(to right, #10b981, #34d399);
            transition: width 0.3s ease;
            border-radius: 3px 3px 0 0;
        }

        .nav-link-top.active::after {
            width: 80%;
        }

        .nav-link-top:hover::after {
            width: 60%;
        }

        .glow-button {
            position: relative;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .glow-button::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: inherit;
            opacity: 0;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.3), rgba(52, 211, 153, 0.3));
            transition: opacity 0.3s ease;
            z-index: -1;
        }

        .glow-button:hover::after {
            opacity: 1;
        }

        .notification-badge {
            animation: pulse-glow 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse-glow {

            0%,
            100% {
                opacity: 1;
                box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
            }

            50% {
                opacity: 0.8;
                box-shadow: 0 0 0 4px rgba(239, 68, 68, 0);
            }
        }

        .smooth-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        [x-cloak] {
            display: none !important;
        }

        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(16, 185, 129, 0.05);
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(16, 185, 129, 0.3);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(16, 185, 129, 0.5);
        }

        /* Mobile Menu Dropdown */
        .mobile-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-in-out;
        }

        .mobile-menu.open {
            max-height: 600px;
        }

        /* New Modern Styles */
        .nav-icon {
            width: 20px;
            height: 20px;
            margin-right: 8px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .nav-item:hover {
            background: rgba(16, 185, 129, 0.1);
        }

        .nav-item.active {
            background: rgba(16, 185, 129, 0.15);
            color: #10b981;
        }

        .profile-avatar {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #10b981, #34d399);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 14px;
        }

        .nav-divider {
            height: 1px;
            background: rgba(16, 185, 129, 0.1);
            margin: 8px 0;
        }

        /* Enhanced Card Styles */
        .enhanced-card {
            background: rgba(17, 25, 21, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(16, 185, 129, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            border-radius: 12px;
            overflow: hidden;
        }

        .card-header {
            padding: 16px 20px;
            border-bottom: 1px solid rgba(16, 185, 129, 0.1);
            background: rgba(16, 185, 129, 0.05);
        }

        .card-body {
            padding: 20px;
        }

        /* Modern Button Styles */
        .btn-primary {
            background: linear-gradient(135deg, #10b981, #34d399);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }

        /* Stats Cards */
        .stat-card {
            background: rgba(17, 25, 21, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: 12px;
            padding: 20px;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
        }

        /* Responsive Grid */
        .responsive-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }

        /* Enhanced Footer */
        .footer-links {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
        }

        /* Animation for page load */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.5s ease-out;
        }
    </style>
</head>

<body class="text-gray-100 min-h-screen flex flex-col">

    <div x-data="{ isMobileMenuOpen: false }" class="flex flex-col min-h-screen">

        {{-- 🌟 TOP NAVBAR --}}
        <nav class="glass-nav fixed top-0 left-0 w-full z-50">
            <div class="max-w-7xl mx-auto px-4 md:px-8">
                <div class="flex justify-between items-center h-16">
                    {{-- Logo --}}
                    <a href="{{ route('trainer.dashboard') }}"
                        class="font-display text-2xl md:text-3xl font-bold text-white tracking-tight flex items-center gap-2">
                        <div
                            class="w-8 h-8 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-lg flex items-center justify-center shadow-lg shadow-emerald-500/30">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <span class="hidden sm:inline">Muscle<span class="text-gradient">Xpert</span></span>
                    </a>

                    {{-- Desktop Navigation --}}
                    @php
                        use App\Models\User;
                        $trainer = auth()->user();
                        $firstMember = $trainer ? User::where('trainer_id', $trainer->id)->first() : null;
                    @endphp

                    <div class="hidden lg:flex items-center space-x-1">
                        <a href="{{ route('trainer.dashboard') }}"
                            class="nav-item {{ Route::is('trainer.dashboard') ? 'active text-emerald-400' : 'text-gray-300' }}">
                            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                            Dashboard
                        </a>

                        <a href="{{ route('trainer.members.index') }}"
                            class="nav-item {{ Route::is('trainer.members.*') ? 'active text-emerald-400' : 'text-gray-300' }}">
                            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                </path>
                            </svg>
                            Member
                        </a>

                        @if ($firstMember)
                            <a href="{{ route('trainer.programs.index') }}"
                                class="nav-item {{ Route::is('trainer.programs.*') && !Route::is('trainer.programs.nutrition.*') ? 'active text-emerald-400' : 'text-gray-300' }}">
                                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                    </path>
                                </svg>
                                Program
                            </a>

                            <a href="{{ route('trainer.programs.nutrition.index', ['memberId' => $firstMember->id]) }}"
                                class="nav-item {{ Route::is('trainer.programs.nutrition.*') ? 'active text-emerald-400' : 'text-gray-300' }}">
                                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Nutrisi
                            </a>
                        @endif

                        <a href="{{ route('trainer.communication.chat.index') }}"
                            class="nav-item {{ Route::is('trainer.communication.chat.*') ? 'active text-emerald-400' : 'text-gray-300' }}">
                            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                </path>
                            </svg>
                            Pesan
                        </a>

                        <a href="{{ route('trainer.communication.notifications.index') }}"
                            class="nav-item relative {{ Route::is('trainer.communication.notifications.*') ? 'active text-emerald-400' : 'text-gray-300' }}">
                            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-5 5v-5zM10.24 8.56a5.97 5.97 0 01-4.66-7.11 1 1 0 00-.68-1.16A1 1 0 004 1a7.97 7.97 0 007.33 7.91 1 1 0 00.91-.91 1 1 0 00-.68-1.16 5.99 5.99 0 01-1.32-.28z">
                                </path>
                            </svg>
                            Notifikasi
                            @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                                <span
                                    class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 rounded-full flex items-center justify-center text-white text-xs font-bold notification-badge">
                                    {{ $unreadNotificationsCount }}
                                </span>
                            @endif
                        </a>

                        <a href="{{ route('trainer.quality.verification.status') }}"
                            class="nav-item {{ Route::is('trainer.quality.*') ? 'active text-emerald-400' : 'text-gray-300' }}">
                            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg>
                            Kualitas
                        </a>
                    </div>

                    {{-- Right Side: Profile & Logout --}}
                    <div class="hidden lg:flex items-center space-x-3">
                        <div class="glass-card px-3 py-1.5 rounded-lg flex items-center gap-2">
                            <div class="profile-avatar">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="text-gray-200 font-medium text-sm">{{ auth()->user()->name }}</span>
                        </div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="glow-button text-red-400 hover:text-red-300 text-sm font-medium smooth-transition flex items-center gap-2 px-3 py-1.5 rounded-lg hover:bg-red-500/10 border border-red-500/20">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>

                    {{-- Mobile Menu Button --}}
                    <button @click="isMobileMenuOpen = !isMobileMenuOpen"
                        class="lg:hidden text-gray-300 hover:text-emerald-400 smooth-transition p-2 rounded-lg hover:bg-emerald-500/10">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!isMobileMenuOpen" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                            <path x-show="isMobileMenuOpen" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                {{-- Mobile Menu Dropdown --}}
                <div x-show="isMobileMenuOpen" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-2" class="lg:hidden pb-4" x-cloak>
                    <div class="space-y-1 mt-2">
                        {{-- User Info Mobile --}}
                        <div class="glass-card rounded-xl p-3 mb-3">
                            <div class="flex items-center gap-3">
                                <div class="profile-avatar">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-white font-semibold text-sm">{{ auth()->user()->name }}</p>
                                    <p class="text-emerald-400 text-xs">Professional Trainer</p>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('trainer.dashboard') }}"
                            class="nav-item {{ Route::is('trainer.dashboard') ? 'active text-emerald-400' : 'text-gray-300' }}">
                            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                            Dashboard
                        </a>

                        <a href="{{ route('trainer.members.index') }}"
                            class="nav-item {{ Route::is('trainer.members.*') ? 'active text-emerald-400' : 'text-gray-300' }}">
                            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                </path>
                            </svg>
                            Member
                        </a>

                        @if ($firstMember)
                            <a href="{{ route('trainer.programs.index') }}"
                                class="nav-item {{ Route::is('trainer.programs.*') && !Route::is('trainer.programs.nutrition.*') ? 'active text-emerald-400' : 'text-gray-300' }}">
                                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                    </path>
                                </svg>
                                Program Latihan
                            </a>

                            <a href="{{ route('trainer.programs.nutrition.index', ['memberId' => $firstMember->id]) }}"
                                class="nav-item {{ Route::is('trainer.programs.nutrition.*') ? 'active text-emerald-400' : 'text-gray-300' }}">
                                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Nutrisi & Suplemen
                            </a>
                        @endif

                        <a href="{{ route('trainer.communication.chat.index') }}"
                            class="nav-item {{ Route::is('trainer.communication.chat.*') ? 'active text-emerald-400' : 'text-gray-300' }}">
                            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                </path>
                            </svg>
                            Pesan
                        </a>

                        <a href="{{ route('trainer.communication.notifications.index') }}"
                            class="nav-item relative {{ Route::is('trainer.communication.notifications.*') ? 'active text-emerald-400' : 'text-gray-300' }}">
                            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-5 5v-5zM10.24 8.56a5.97 5.97 0 01-4.66-7.11 1 1 0 00-.68-1.16A1 1 0 004 1a7.97 7.97 0 007.33 7.91 1 1 0 00.91-.91 1 1 0 00-.68-1.16 5.99 5.99 0 01-1.32-.28z">
                                </path>
                            </svg>
                            Notifikasi
                            @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                                <span
                                    class="inline-block ml-2 px-2 py-0.5 bg-red-500 rounded-full text-white text-xs font-bold">
                                    {{ $unreadNotificationsCount }}
                                </span>
                            @endif
                        </a>

                        <a href="{{ route('trainer.quality.verification.status') }}"
                            class="nav-item {{ Route::is('trainer.quality.*') ? 'active text-emerald-400' : 'text-gray-300' }}">
                            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg>
                            Kualitas Trainer
                        </a>

                        <div class="nav-divider"></div>

                        <form method="POST" action="{{ route('logout') }}"
                            class="mt-3 pt-3 border-t border-emerald-500/10">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2.5 rounded-lg font-medium text-red-400 hover:text-red-300 hover:bg-red-500/10 smooth-transition flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        {{-- 🧩 MAIN CONTENT --}}
        <main class="flex-grow pt-16">
            <div class="max-w-7xl mx-auto px-4 md:px-8 py-6 md:py-8">
                @yield('content')
            </div>
        </main>

        {{-- 🦶 FOOTER --}}
        <footer class="glass-footer mt-auto">
            <div class="max-w-7xl mx-auto px-4 md:px-8 py-6">
                <div class="footer-links mb-6">
                    {{-- About Section --}}
                    <div>
                        <h3 class="font-display text-xl font-bold text-white mb-3 flex items-center gap-2">
                            <div
                                class="w-7 h-7 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            Muscle<span class="text-gradient">Xpert</span>
                        </h3>
                        <p class="text-gray-400 text-sm leading-relaxed">
                            Platform terbaik untuk trainer profesional dalam mengelola member dan program fitness secara
                            efektif.
                        </p>
                    </div>

                    {{-- Quick Links --}}
                    <div>
                        <h4 class="font-semibold text-white mb-3 text-sm uppercase tracking-wider">Quick Links</h4>
                        <ul class="space-y-2">
                            <li>
                                <a href="{{ route('trainer.dashboard') }}"
                                    class="text-gray-400 hover:text-emerald-400 text-sm smooth-transition">Dashboard</a>
                            </li>
                            <li>
                                <a href="{{ route('trainer.members.index') }}"
                                    class="text-gray-400 hover:text-emerald-400 text-sm smooth-transition">Manajemen
                                    Member</a>
                            </li>
                            <li>
                                <a href="{{ route('trainer.communication.chat.index') }}"
                                    class="text-gray-400 hover:text-emerald-400 text-sm smooth-transition">Komunikasi</a>
                            </li>
                        </ul>
                    </div>

                    {{-- Contact Info --}}
                    <div>
                        <h4 class="font-semibold text-white mb-3 text-sm uppercase tracking-wider">Support</h4>
                        <ul class="space-y-2">
                            <li class="flex items-center gap-2 text-gray-400 text-sm">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                                support@musclexpert.com
                            </li>
                            <li class="flex items-center gap-2 text-gray-400 text-sm">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                    </path>
                                </svg>
                                +62 123 4567 890
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Bottom Bar --}}
                <div
                    class="border-t border-emerald-500/10 pt-6 flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-gray-400 text-sm text-center md:text-left">
                        &copy; {{ date('Y') }} MuscleXpert. All rights reserved.
                    </p>

                    <div class="flex items-center gap-4">
                        <a href="#" class="text-gray-400 hover:text-emerald-400 smooth-transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-emerald-400 smooth-transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-emerald-400 smooth-transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.894 8.221l-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.446 1.394c-.14.18-.357.223-.548.223l.188-2.85 5.18-4.68c.223-.198-.054-.308-.346-.11l-6.4 4.03-2.76-.918c-.6-.187-.612-.6.125-.89l10.782-4.156c.5-.18.943.11.78.89z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    @yield('scripts')
</body>

</html>