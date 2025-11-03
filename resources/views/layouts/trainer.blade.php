<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainer Panel - @yield('title', 'Dashboard')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Kita tetap pakai Alpine (via CDN Hack) untuk tombol hamburger mobile --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Font "Ciamik" --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
</head>

{{-- "Sulap" body menjadi Dark Premium --}}
<body class="bg-black text-gray-200">

    <div class="parallax-bg"></div>

    <div x-data="{ isSidebarOpen: false }">

        {{-- 🌟 TOP NAVBAR (Versi "Dark Premium") --}}
        <nav class="bg-black/70 backdrop-blur-lg border-b border-gray-700/50 fixed top-0 left-0 w-full z-20 h-16 flex justify-between items-center px-4 md:px-8">
            <div class="flex items-center space-x-4">
                <a href="{{ route('trainer.dashboard') }}"
                    class="font-serif text-3xl font-bold text-white">
                    Muscle<span class="text-amber-400">Xpert</span>
                </a>
            </div>

            {{-- Tombol Hamburger (HANYA MUNCUL DI MOBILE) --}}
            <button @click="isSidebarOpen = !isSidebarOpen" class="text-gray-300 hover:text-white md:hidden">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
            </button>

            {{-- 👤 Profile Trainer (HANYA MUNCUL DI DESKTOP) --}}
            <div class="hidden md:flex items-center space-x-4">
                <span class="text-gray-300 font-medium">{{ auth()->user()->name ?? 'Trainer' }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="text-red-500 hover:text-red-400 text-sm font-medium transition duration-150">
                        Logout
                    </button>
                </form>
            </div>
        </nav>

        {{-- 🧱 CONTAINER UTAMA --}}
        <div class="flex pt-16 h-screen">

            {{-- 🧭 SIDEBAR (Versi "Dark Premium") --}}
            @php
                use App\Models\User;
                $trainer = auth()->user();
                $firstMember = $trainer ? User::where('trainer_id', $trainer->id)->first() : null;
            @endphp

            {{-- Overlay Mobile --}}
            <div x-show="isSidebarOpen" @click="isSidebarOpen = false" class="fixed inset-0 bg-black/50 z-30 md:hidden" x-cloak></div>

            {{-- Konten Sidebar --}}
            <aside
                class="w-64 bg-black/80 backdrop-blur-lg border-r border-gray-700/50 text-white flex-shrink-0 shadow-xl overflow-y-auto fixed top-0 left-0 h-full z-40
                       transform transition-transform duration-300
                       md:translate-x-0 md:sticky md:top-16 md:h-[calc(100vh-64px)]"
                :class="isSidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            >
                <div class="p-4 space-y-2 pt-20 md:pt-4"> {{-- Padding top untuk mobile --}}

                    <h3 class="text-xs font-semibold uppercase text-gray-500 mt-2 mb-2 px-4">Manajemen Klien</h3>

                    <a href="{{ route('trainer.dashboard') }}"
                        class="flex items-center px-4 py-3 rounded-md font-medium transition-all
                            {{ Route::is('trainer.dashboard') ? 'text-black bg-amber-400 shadow-lg shadow-amber-500/20' : 'text-gray-400 hover:text-white hover:bg-gray-800/50' }}">
                        <span class="w-6 h-6 mr-3"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg></span>
                        <span class="font-medium">Dashboard</span>
                    </a>
                    <a href="{{ route('trainer.members.index') }}"
                        class="flex items-center px-4 py-3 rounded-md font-medium transition-all
                            {{ Route::is('trainer.members.*') ? 'text-black bg-amber-400 shadow-lg shadow-amber-500/20' : 'text-gray-400 hover:text-white hover:bg-gray-800/50' }}">
                        <span class="w-6 h-6 mr-3"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg></span>
                        <span class="font-medium">Manajemen Member</span>
                    </a>

                    <h3 class="text-xs font-semibold uppercase text-gray-400 mt-6 mb-3">Program & Nutrisi</h3>
                    @if ($firstMember)
                        <a href="{{ route('trainer.programs.index') }}"
                            class="flex items-center px-4 py-3 rounded-md font-medium transition-all
                                {{ Route::is('trainer.programs.*') && !Route::is('trainer.programs.nutrition.*')
                                    ? 'text-black bg-amber-400 shadow-lg shadow-amber-500/20' : 'text-gray-400 hover:text-white hover:bg-gray-800/50' }}">
                            <span class="w-6 h-6 mr-3"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg></span>
                            <span class="font-medium">Program Latihan</span>
                        </a>
                        <a href="{{ route('trainer.programs.nutrition.index', ['memberId' => $firstMember->id]) }}"
                            class="flex items-center px-4 py-3 rounded-md font-medium transition-all
                                {{ Route::is('trainer.programs.nutrition.*')
                                    ? 'text-black bg-amber-400 shadow-lg shadow-amber-500/20' : 'text-gray-400 hover:text-white hover:bg-gray-800/50' }}">
                            <span class="w-6 h-6 mr-3"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.363-.44A2 2 0 0115 13.029V11.5a2 2 0 00-2-2h-2a2 2 0 00-2 2v1.53a2 2 0 01-1.043 1.843l-2.363.44a2 2 0 00-1.022.547l-1.84 2.148A2 2 0 004.16 19.92a2 2 0 001.84 1.08h12a2 2 0 001.84-1.08l-1.84-2.148zM12 18V9.5m0 8.5v-8.5m-4 4h8"></path></svg></span>
                            <span class="font-medium">Nutrisi & Suplemen</span>
                        </a>
                    @else
                        <div class="text-gray-500 text-sm italic px-3">Belum ada member.</div>
                    @endif

                    <h3 class="text-xs font-semibold uppercase text-gray-400 mt-6 mb-3">Komunikasi & Kualitas</h3>
                    <a href="{{ route('trainer.communication.chat.index') }}"
                        class="flex items-center px-4 py-3 rounded-md font-medium transition-all
                            {{ Route::is('trainer.communication.chat.*') ? 'text-black bg-amber-400 shadow-lg shadow-amber-500/20' : 'text-gray-400 hover:text-white hover:bg-gray-800/50' }}">
                        <span class="w-6 h-6 mr-3"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 21l1.255-3.765A9.863 9.863 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg></span>
                        <span class="font-medium">Pesan Klien</span>
                    </a>
                    <a href="{{ route('trainer.communication.notifications.index') }}"
                        class="flex items-center px-4 py-3 rounded-md font-medium transition-all
                            {{ Route::is('trainer.communication.notifications.*') ? 'text-black bg-amber-400 shadow-lg shadow-amber-500/20' : 'text-gray-400 hover:text-white hover:bg-gray-800/50' }}">
                        <span class="w-6 h-6 mr-3"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg></span>
                        <span class="font-medium">Notifikasi</span>
                    </a>
                    <a href="{{ route('trainer.quality.verification.status') }}"
                        class="flex items-center px-4 py-3 rounded-md font-medium transition-all
                            {{ Route::is('trainer.quality.*') ? 'text-black bg-amber-400 shadow-lg shadow-amber-500/20' : 'text-gray-400 hover:text-white hover:bg-gray-800/50' }}">
                        <span class="w-6 h-6 mr-3"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg></span>
                        <span class="font-medium">Kualitas Trainer</span>
                    </a>

                    {{-- Logout (di Bawah untuk Mobile) --}}
                    <div class="!mt-6 border-t border-gray-700 pt-4 md:hidden">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex w-full items-center space-x-3 p-3 rounded-lg text-red-500 hover:bg-red-900/50 hover:text-red-400">
                                <span class="w-6 h-6 mr-3"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg></span>
                                <span class="font-medium">Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </aside>

            {{-- 🧩 MAIN CONTENT (Versi "Dark Premium") --}}
            <main class="flex-grow bg-transparent overflow-y-auto"> {{-- (Ganti bg-gray-100) --}}
                <div class="p-6 md:p-8">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    {{-- Font Awesome SUDAH DIHAPUS karena kita pakai SVG --}}

    @yield('scripts')
</body>
</html>
