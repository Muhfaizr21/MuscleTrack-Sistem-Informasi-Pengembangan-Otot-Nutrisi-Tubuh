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
        /* Reset dan Base Styles */
        * {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            background: #000 !important;
            color-scheme: dark;
            overflow-x: hidden;
            min-height: 100vh;
            scroll-behavior: smooth;
        }

        body::-webkit-scrollbar-track {
            background: #000 !important;
        }

        html {
            background-color: #000 !important;
        }

        .font-display {
            font-family: 'Outfit', sans-serif;
        }

        /* Enhanced Dark Theme with Emerald Glow */
        body {
            background:
                radial-gradient(ellipse 80% 50% at 50% -20%, rgba(0, 255, 170, 0.25), transparent),
                radial-gradient(ellipse 50% 50% at 100% 0%, rgba(0, 255, 204, 0.2), transparent),
                radial-gradient(ellipse 50% 50% at 0% 100%, rgba(0, 255, 157, 0.2), transparent),
                linear-gradient(135deg, #0a0f0d 0%, #0d1410 50%, #0a0f0d 100%);
            background-attachment: fixed;
            position: relative;
        }

        /* Animated Grid Background */
        .grid-pattern {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image:
                linear-gradient(rgba(0, 255, 170, 0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 255, 170, 0.1) 1px, transparent 1px);
            background-size: 50px 50px;
            background-position: center center;
            animation: gridMove 20s linear infinite;
            opacity: 0.1;
            z-index: -1;
        }

        @keyframes gridMove {
            0% {
                background-position: 0 0;
            }

            100% {
                background-position: 50px 50px;
            }
        }

        /* Floating Elements */
        .floating-element {
            position: fixed;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.15;
            z-index: -1;
            animation: float 8s ease-in-out infinite;
        }

        .floating-1 {
            top: 20%;
            left: 10%;
            width: 300px;
            height: 300px;
            background: rgba(0, 255, 170, 0.3);
            animation-delay: 0s;
        }

        .floating-2 {
            top: 60%;
            right: 10%;
            width: 250px;
            height: 250px;
            background: rgba(0, 255, 204, 0.25);
            animation-delay: 2s;
        }

        .floating-3 {
            bottom: 20%;
            left: 20%;
            width: 200px;
            height: 200px;
            background: rgba(0, 255, 157, 0.2);
            animation-delay: 4s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        /* Enhanced Text Gradients */
        .text-gradient {
            background: linear-gradient(135deg, #00ff9d 0%, #00ffcc 50%, #6ee7b7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: textGlow 3s ease-in-out infinite alternate;
        }

        @keyframes textGlow {
            0% {
                filter: drop-shadow(0 0 5px rgba(0, 255, 170, 0.5));
            }

            100% {
                filter: drop-shadow(0 0 15px rgba(0, 255, 170, 0.8));
            }
        }

        /* Premium Glass Effects */
        .glass-nav {
            background: rgba(13, 20, 16, 0.95);
            backdrop-filter: blur(20px) saturate(180%);
            border-bottom: 1px solid rgba(0, 255, 170, 0.3);
            box-shadow:
                0 4px 30px rgba(0, 0, 0, 0.3),
                0 0 20px rgba(0, 255, 170, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            height: 80px;
        }

        .glass-card {
            background: rgba(17, 25, 21, 0.8);
            backdrop-filter: blur(15px) saturate(180%);
            border: 1px solid rgba(0, 255, 170, 0.25);
            box-shadow:
                0 8px 32px rgba(0, 0, 0, 0.3),
                0 0 20px rgba(0, 255, 170, 0.1);
            transition: all 0.3s ease;
        }

        .glass-card:hover {
            border-color: rgba(0, 255, 170, 0.4);
            box-shadow:
                0 12px 40px rgba(0, 0, 0, 0.4),
                0 0 30px rgba(0, 255, 170, 0.2);
            transform: translateY(-2px);
        }

        .glass-footer {
            background: rgba(13, 20, 16, 0.95);
            backdrop-filter: blur(20px) saturate(180%);
            border-top: 1px solid rgba(0, 255, 170, 0.2);
            box-shadow: 0 -4px 30px rgba(0, 0, 0, 0.3);
        }

        /* Enhanced Navigation Items */
        .nav-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            color: #9CA3AF;
            font-weight: 500;
            font-size: 14px;
            position: relative;
            overflow: hidden;
            border: 1px solid transparent;
        }

        .nav-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(0, 255, 170, 0.1), transparent);
            transition: left 0.6s ease;
        }

        .nav-item:hover::before {
            left: 100%;
        }

        .nav-item:hover {
            background: rgba(0, 255, 170, 0.15);
            color: #00ffcc;
            border-color: rgba(0, 255, 170, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 255, 170, 0.15);
        }

        .nav-item.active {
            background: rgba(0, 255, 170, 0.2);
            color: #00ffcc;
            border-color: rgba(0, 255, 170, 0.4);
            box-shadow:
                0 8px 25px rgba(0, 255, 170, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
        }

        .nav-icon {
            width: 20px;
            height: 20px;
            margin-right: 12px;
            transition: all 0.3s ease;
        }

        .nav-item:hover .nav-icon,
        .nav-item.active .nav-icon {
            transform: scale(1.1);
            filter: drop-shadow(0 0 8px rgba(0, 255, 170, 0.6));
        }

        /* Enhanced Profile Avatar */
        .profile-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #00ff9d, #00ffcc);
            border-radius: 30%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #000;
            font-weight: bold;
            font-size: 16px;
            border: 2px solid rgba(0, 255, 170, 0.4);
            box-shadow:
                0 4px 15px rgba(0, 255, 170, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            margin-left: 20px;
        }

        .profile-avatar:hover {
            transform: scale(1.05);
            box-shadow:
                0 6px 20px rgba(0, 255, 170, 0.4),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }

        /* Premium Profile Dropdown */
        .profile-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 12px;
            width: 280px;
            background: rgba(17, 25, 21, 0.98);
            backdrop-filter: blur(25px) saturate(180%);
            border: 1px solid rgba(0, 255, 170, 0.3);
            border-radius: 16px;
            box-shadow:
                0 25px 80px rgba(0, 0, 0, 0.5),
                0 0 30px rgba(0, 255, 170, 0.2);
            overflow: hidden;
            z-index: 1000;
        }

        .profile-header {
            padding: 20px;
            border-bottom: 1px solid rgba(0, 255, 170, 0.2);
            background: linear-gradient(135deg, rgba(0, 255, 170, 0.1), transparent);
        }

        .profile-item {
            display: flex;
            align-items: center;
            padding: 14px 20px;
            color: #e5e7eb;
            transition: all 0.3s ease;
            cursor: pointer;
            font-size: 14px;
            border-bottom: 1px solid rgba(0, 255, 170, 0.05);
        }

        .profile-item:last-child {
            border-bottom: none;
        }

        .profile-item:hover {
            background: rgba(0, 255, 170, 0.15);
            color: #00ffcc;
            padding-left: 24px;
        }

        .profile-item svg {
            width: 18px;
            height: 18px;
            margin-right: 12px;
            transition: all 0.3s ease;
        }

        .profile-item:hover svg {
            transform: scale(1.1);
            filter: drop-shadow(0 0 6px rgba(0, 255, 170, 0.6));
        }

        /* Enhanced Notification Badge */
        .notification-dot {
            position: absolute;
            top: -2px;
            right: -2px;
            width: 10px;
            height: 10px;
            background: linear-gradient(135deg, #ff4444, #ff6b6b);
            border-radius: 50%;
            border: 2px solid rgba(13, 20, 16, 0.95);
            box-shadow: 0 0 10px rgba(255, 68, 68, 0.6);
            animation: pulse-glow 2s ease-in-out infinite;
        }

        @keyframes pulse-glow {

            0%,
            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(255, 68, 68, 0.7);
            }

            50% {
                transform: scale(1.1);
                box-shadow: 0 0 0 6px rgba(255, 68, 68, 0);
            }
        }

        /* Enhanced Mobile Menu Background */
        .mobile-menu-background {
            background: rgba(13, 20, 16, 0.98);
            backdrop-filter: blur(30px) saturate(200%);
            border-bottom: 1px solid rgba(0, 255, 170, 0.4);
            border-top: 1px solid rgba(0, 255, 170, 0.2);
            box-shadow:
                0 15px 50px rgba(0, 0, 0, 0.5),
                0 0 30px rgba(0, 255, 170, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            position: relative;
            z-index: 999;
        }

        .mobile-menu-background::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg,
                    rgba(0, 255, 170, 0.05) 0%,
                    transparent 50%,
                    rgba(0, 255, 204, 0.03) 100%);
            pointer-events: none;
            z-index: -1;
        }

        /* Enhanced Mobile Styles */
        .mobile-nav-item {
            display: flex;
            align-items: center;
            padding: 16px 20px;
            border-radius: 12px;
            transition: all 0.3s ease;
            color: #9CA3AF;
            font-weight: 500;
            font-size: 15px;
            margin-bottom: 6px;
            border: 1px solid transparent;
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(10px);
        }

        .mobile-nav-item:hover {
            background: rgba(0, 255, 170, 0.15);
            color: #00ffcc;
            border-color: rgba(0, 255, 170, 0.3);
            transform: translateX(5px);
            box-shadow: 0 4px 15px rgba(0, 255, 170, 0.1);
        }

        .mobile-nav-item.active {
            background: rgba(0, 255, 170, 0.2);
            color: #00ffcc;
            border-color: rgba(0, 255, 170, 0.4);
            box-shadow:
                0 4px 15px rgba(0, 255, 170, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
        }

        /* Enhanced Logo */
        .logo-container {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #00ff9d, #00ffcc);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow:
                0 6px 20px rgba(0, 255, 170, 0.4),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            margin-right: 20px;
        }

        .logo-icon:hover {
            transform: rotate(10deg) scale(1.05);
            box-shadow:
                0 8px 25px rgba(0, 255, 170, 0.6),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }

        /* Enhanced Mobile Menu Button */
        .mobile-menu-btn {
            padding: 10px;
            border-radius: 10px;
            transition: all 0.3s ease;
            color: #9CA3AF;
            border: 1px solid transparent;
        }

        .mobile-menu-btn:hover {
            background: rgba(0, 255, 170, 0.15);
            color: #00ffcc;
            border-color: rgba(0, 255, 170, 0.3);
            transform: scale(1.05);
        }

        /* Enhanced Footer */
        .footer-links {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-bottom: 30px;
        }

        /* FIXED: Main Content Spacing to Prevent Navbar Overlap */
        .main-content-wrapper {
            min-height: 100vh;
            padding-top: 80px;
            margin-top: 30px;
            display: flex;
            flex-direction: column;
        }

        .main-content {
            flex: 1;
            width: 100%;
        }

        /* Enhanced responsive padding for main content */
        .content-container {
            width: 100%;
            max-width: 100%;
            padding-left: 1rem;
            padding-right: 1rem;
        }

        @media (min-width: 640px) {
            .content-container {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }
        }

        @media (min-width: 1024px) {
            .content-container {
                padding-left: 2rem;
                padding-right: 2rem;
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .nav-item {
                padding: 10px 16px;
                font-size: 13px;
            }

            .nav-icon {
                width: 18px;
                height: 18px;
                margin-right: 10px;
            }

            .profile-avatar {
                width: 36px;
                height: 36px;
                font-size: 14px;
            }

            .logo-icon {
                width: 36px;
                height: 36px;
            }

            .footer-links {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .glass-card {
                margin: 0 10px;
            }

            /* Adjust main content padding for mobile */
            .main-content-wrapper {
                padding-top: 70px;
            }
        }

        @media (max-width: 480px) {
            .nav-item {
                padding: 8px 12px;
                font-size: 12px;
            }

            .mobile-nav-item {
                padding: 14px 16px;
                font-size: 14px;
            }

            .profile-dropdown {
                width: 260px;
                right: -20px;
            }

            .logo-container span {
                font-size: 18px;
            }

            /* Further adjustment for very small screens */
            .main-content-wrapper {
                padding-top: 65px;
            }
        }

        /* Smooth Transitions */
        .smooth-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        [x-cloak] {
            display: none !important;
        }

        /* Enhanced Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(16, 185, 129, 0.05);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #00ff9d, #00ffcc);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 255, 170, 0.5);
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #00ffcc, #00ff9d);
            box-shadow: 0 0 15px rgba(0, 255, 170, 0.7);
        }

        /* Loading States */
        .loading {
            opacity: 0.7;
            pointer-events: none;
        }

        /* Focus States for Accessibility */
        button:focus,
        a:focus {
            outline: 2px solid rgba(0, 255, 170, 0.5);
            outline-offset: 2px;
        }

        /* Print Styles */
        @media print {

            .glass-nav,
            .glass-footer {
                display: none;
            }

            body {
                background: white !important;
                color: black !important;
            }

            .main-content-wrapper {
                padding-top: 0 !important;
            }
        }

        /* Additional safety measures to prevent overlap */
        body {
            padding-top: 0 !important;
        }

        /* Ensure content starts below navbar */
        .safe-area-top {
            padding-top: env(safe-area-inset-top);
        }
    </style>
</head>

<body class="text-gray-100 min-h-screen flex flex-col">
    <!-- Background Elements -->
    <div class="grid-pattern"></div>
    <div class="floating-element floating-1"></div>
    <div class="floating-element floating-2"></div>
    <div class="floating-element floating-3"></div>

    <div x-data="{ isMobileMenuOpen: false, profileDropdownOpen: false }" class="flex flex-col min-h-screen">
        {{-- 🌟 ENHANCED TOP NAVBAR --}}
        <nav class="glass-nav">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    {{-- Enhanced Logo --}}
                    <div class="logo-container">
                        <a href="{{ route('trainer.dashboard') }}" class="flex items-center gap-3">
                            <div class="logo-icon">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                        </a>
                    </div>

                    {{-- Enhanced Desktop Navigation --}}
                    @php
                        use App\Models\User;
                        $trainer = auth()->user();
                        $firstMember = $trainer ? User::where('trainer_id', $trainer->id)->first() : null;
                    @endphp
                    <div class="hidden lg:flex items-center space-x-2">
                        <a href="{{ route('trainer.dashboard') }}"
                            class="nav-item {{ Route::is('trainer.dashboard') ? 'active' : '' }}">
                            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                            Dashboard
                        </a>
                        <a href="{{ route('trainer.members.index') }}"
                            class="nav-item {{ Route::is('trainer.members.*') ? 'active' : '' }}">
                            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                </path>
                            </svg>
                            Member
                        </a>
                        @if ($firstMember)
                            <a href="{{ route('trainer.programs.index') }}"
                                class="nav-item {{ Route::is('trainer.programs.*') && !Route::is('trainer.programs.nutrition.*') ? 'active' : '' }}">
                                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                    </path>
                                </svg>
                                Program
                            </a>
                            {{-- ✅ PERBAIKAN: Gunakan route nutrition dashboard yang baru --}}
                            <a href="{{ route('trainer.nutrition.dashboard') }}"
                                class="nav-item {{ Route::is('trainer.nutrition.*') ? 'active' : '' }}">
                                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Nutrisi
                            </a>
                        @endif
                        <a href="{{ route('trainer.communication.chat.index') }}"
                            class="nav-item {{ Route::is('trainer.communication.chat.*') ? 'active' : '' }}">
                            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                </path>
                            </svg>
                            Pesan
                        </a>
                        <a href="{{ route('trainer.communication.notifications.index') }}"
                            class="nav-item relative {{ Route::is('trainer.communication.notifications.*') ? 'active' : '' }}">
                            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-5 5v-5zM10.24 8.56a5.97 5.97 0 01-4.66-7.11 1 1 0 00-.68-1.16A1 1 0 004 1a7.97 7.97 0 007.33 7.91 1 1 0 00.91-.91 1 1 0 00-.68-1.16 5.99 5.99 0 01-1.32-.28z">
                                </path>
                            </svg>
                            Notifikasi
                            @php
                                $unreadNotificationsCount = auth()->user()->unreadNotifications->count();
                            @endphp
                            @if($unreadNotificationsCount > 0)
                                <span class="notification-dot"></span>
                            @endif
                        </a>
                        <a href="{{ route('trainer.quality.verification.status') }}"
                            class="nav-item {{ Route::is('trainer.quality.*') ? 'active' : '' }}">
                            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg>
                            Kualitas
                        </a>

                        <a href="{{ route('trainer.communities.index') }}"
                            class="nav-item {{ Route::is('trainer.communities.*') ? 'active' : '' }}">
                            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                            Communities
                        </a>
                    </div>

                    {{-- Enhanced Right Side: Profile & Mobile Menu --}}
                    <div class="flex items-center space-x-4">
                        <!-- Enhanced Desktop Profile Dropdown -->
                        <div class="hidden lg:block relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="flex items-center gap-3 px-4 py-2 rounded-xl hover:bg-emerald-500/10 transition-all duration-300 border border-transparent hover:border-emerald-500/30">
                                <div class="profile-avatar">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <span class="text-gray-200 font-semibold text-sm">{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4 text-emerald-400 transition-transform duration-300"
                                    :class="{ 'rotate-180': open }" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <!-- Enhanced Dropdown Menu -->
                            <div x-show="open" @click.away="open = false" x-cloak
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95" class="profile-dropdown">
                                <!-- Enhanced Profile Header -->
                                <div class="profile-header">
                                    <div class="flex items-center space-x-3">
                                        <div class="profile-avatar w-12 h-12">
                                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="text-white font-bold text-base">{{ auth()->user()->name }}</p>
                                            <p class="text-gradient text-sm font-semibold">Professional Trainer</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Enhanced Profile Menu Items -->
                                <a href="{{ route('trainer.profile.index') }}" class="profile-item">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                    Profil Saya
                                </a>
                                <a href="{{ route('trainer.profile.edit') }}" class="profile-item">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Edit Profil
                                </a>
                                <div class="border-t border-emerald-500/20 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="profile-item text-red-400 hover:text-red-300 w-full text-left">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                            </path>
                                        </svg>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- Enhanced Mobile Menu Button --}}
                        <button @click="isMobileMenuOpen = !isMobileMenuOpen" class="lg:hidden mobile-menu-btn">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path x-show="!isMobileMenuOpen" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                                <path x-show="isMobileMenuOpen" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Enhanced Mobile Menu Dropdown with Background --}}
                <div x-show="isMobileMenuOpen" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 -translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-4" class="lg:hidden pb-6 mt-4 mobile-menu-background"
                    x-cloak>

                    <div class="space-y-3 px-4 sm:px-6 lg:px-8 pt-4">
                        {{-- Enhanced User Info Mobile --}}
                        <div class="glass-card rounded-2xl p-5 mb-4">
                            <div class="flex items-center gap-4">
                                <div class="profile-avatar">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-white font-bold text-base">{{ auth()->user()->name }}</p>
                                    <p class="text-gradient text-sm font-semibold">Professional Trainer</p>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('trainer.dashboard') }}"
                            class="mobile-nav-item {{ Route::is('trainer.dashboard') ? 'active' : '' }}">
                            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                            Dashboard
                        </a>
                        <a href="{{ route('trainer.members.index') }}"
                            class="mobile-nav-item {{ Route::is('trainer.members.*') ? 'active' : '' }}">
                            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                </path>
                            </svg>
                            Member
                        </a>
                        @if ($firstMember)
                            <a href="{{ route('trainer.programs.index') }}"
                                class="mobile-nav-item {{ Route::is('trainer.programs.*') && !Route::is('trainer.programs.nutrition.*') ? 'active' : '' }}">
                                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                    </path>
                                </svg>
                                Program
                            </a>
                            {{-- ✅ PERBAIKAN: Gunakan route nutrition dashboard yang baru --}}
                            <a href="{{ route('trainer.nutrition.dashboard') }}"
                                class="mobile-nav-item {{ Route::is('trainer.nutrition.*') ? 'active' : '' }}">
                                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Nutrisi
                            </a>
                        @endif
                        <a href="{{ route('trainer.communication.chat.index') }}"
                            class="mobile-nav-item {{ Route::is('trainer.communication.chat.*') ? 'active' : '' }}">
                            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                </path>
                            </svg>
                            Pesan
                        </a>
                        <a href="{{ route('trainer.communication.notifications.index') }}"
                            class="mobile-nav-item relative {{ Route::is('trainer.communication.notifications.*') ? 'active' : '' }}">
                            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-5 5v-5zM10.24 8.56a5.97 5.97 0 01-4.66-7.11 1 1 0 00-.68-1.16A1 1 0 004 1a7.97 7.97 0 007.33 7.91 1 1 0 00.91-.91 1 1 0 00-.68-1.16 5.99 5.99 0 01-1.32-.28z">
                                </path>
                            </svg>
                            Notifikasi
                            @if($unreadNotificationsCount > 0)
                                <span class="notification-dot"></span>
                            @endif
                        </a>
                        <a href="{{ route('trainer.quality.verification.status') }}"
                            class="mobile-nav-item {{ Route::is('trainer.quality.*') ? 'active' : '' }}">
                            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg>
                            Kualitas
                        </a>

                        {{-- Enhanced Profile Menu Items for Mobile --}}
                        <div class="border-t border-emerald-500/20 pt-4 mt-4"></div>

                        <a href="{{ route('trainer.profile.index') }}" class="mobile-nav-item">
                            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Profil Saya
                        </a>

                        <div class="border-t border-emerald-500/20 pt-4 mt-4"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left mobile-nav-item text-red-400 hover:text-red-300">
                                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        {{-- 🧩 FIXED MAIN CONTENT AREA --}}
        <div class="main-content-wrapper">
            <main class="main-content">
                <div class="content-container">
                    @yield('content')
                </div>
            </main>

            {{-- 🦶 ENHANCED FOOTER --}}
            <footer class="glass-footer mt-auto">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    <div class="footer-links">
                        {{-- Enhanced About Section --}}
                        <div>
                            <h3 class="font-display text-2xl font-bold text-white mb-4 flex items-center gap-3">
                                <div class="logo-icon">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                Muscle<span class="text-gradient">Xpert</span>
                            </h3>
                            <p class="text-gray-400 text-sm leading-relaxed">
                                Platform terbaik untuk trainer profesional dalam mengelola member dan program fitness
                                secara
                                efektif dengan teknologi terkini.
                            </p>
                        </div>

                        {{-- Enhanced Quick Links --}}
                        <div>
                            <h4 class="font-semibold text-white mb-4 text-sm uppercase tracking-wider">Quick Links</h4>
                            <ul class="space-y-3">
                                <li>
                                    <a href="{{ route('trainer.dashboard') }}"
                                        class="text-gray-400 hover:text-emerald-400 text-sm smooth-transition flex items-center gap-2">
                                        <span class="w-1 h-1 bg-emerald-400 rounded-full"></span>
                                        Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('trainer.members.index') }}"
                                        class="text-gray-400 hover:text-emerald-400 text-sm smooth-transition flex items-center gap-2">
                                        <span class="w-1 h-1 bg-emerald-400 rounded-full"></span>
                                        Manajemen Member
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('trainer.communication.chat.index') }}"
                                        class="text-gray-400 hover:text-emerald-400 text-sm smooth-transition flex items-center gap-2">
                                        <span class="w-1 h-1 bg-emerald-400 rounded-full"></span>
                                        Komunikasi
                                    </a>
                                </li>
                            </ul>
                        </div>

                        {{-- Enhanced Contact Info --}}
                        <div>
                            <h4 class="font-semibold text-white mb-4 text-sm uppercase tracking-wider">Support</h4>
                            <ul class="space-y-3">
                                <li class="flex items-center gap-3 text-gray-400 text-sm">
                                    <div class="w-8 h-8 bg-emerald-500/10 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    support@musclexpert.com
                                </li>
                                <li class="flex items-center gap-3 text-gray-400 text-sm">
                                    <div class="w-8 h-8 bg-emerald-500/10 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                            </path>
                                        </svg>
                                    </div>
                                    +62 123 4567 890
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Enhanced Bottom Bar --}}
                    <div
                        class="border-t border-emerald-500/20 pt-8 flex flex-col md:flex-row justify-between items-center gap-6">
                        <p class="text-gray-400 text-sm text-center md:text-left">
                            © {{ date('Y') }} MuscleXpert. All rights reserved.
                        </p>
                        <div class="flex items-center gap-6">
                            <a href="#"
                                class="text-gray-400 hover:text-emerald-400 smooth-transition transform hover:scale-110">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                </svg>
                            </a>
                            <a href="#"
                                class="text-gray-400 hover:text-emerald-400 smooth-transition transform hover:scale-110">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                </svg>
                            </a>
                            <a href="#"
                                class="text-gray-400 hover:text-emerald-400 smooth-transition transform hover:scale-110">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.894 8.221l-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.446 1.394c-.14.18-.357.223-.548.223l.188-2.85 5.18-4.68c.223-.198-.054-.308-.346-.11l-6.4 4.03-2.76-.918c-.6-.187-.612-.6.125-.89l10.782-4.156c.5-.18.943.11.78.89z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    @yield('scripts')
</body>

</html>