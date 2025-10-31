{{-- resources/views/layouts/trainer.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainer Panel - @yield('title', 'Dashboard')</title>

    {{-- Tailwind CSS & JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* CSS Tambahan untuk Ketinggian Penuh (Full Height) */
        /* Pastikan elemen-elemen ini mengisi tinggi layar yang tersisa */
        .h-screen-minus-nav {
            /* Tinggi layar penuh dikurangi tinggi Navbar (64px = h-16) */
            height: calc(100vh - 64px); 
        }

        /* Kelas untuk menampung konten utama yang dapat di-scroll */
        .main-content-scroll {
            /* Pastikan overflow-y: auto diterapkan pada elemen ini */
            overflow-y: auto; 
            padding-bottom: 4rem; /* Padding bawah untuk ruang footer/akhir konten */
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">

    {{-- 1. 🌟 TOP NAVBAR (Fixed) --}}
    <nav class="bg-white shadow-md fixed top-0 left-0 w-full z-50 h-16">
        <div class="max-w-full mx-auto px-8 h-full flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <a href="{{ route('trainer.dashboard') }}" class="font-bold text-xl text-blue-600 hover:text-blue-800 tracking-wide">
                    🏋️‍♂️ MuscleTrack Trainer
                </a>
                <span class="text-sm text-gray-500 hidden sm:inline">Panel Kontrol</span>
            </div>

            {{-- 👤 Trainer Profile / Logout --}}
            <div class="flex items-center space-x-4">
                <span class="text-gray-600 font-medium hidden md:inline">{{ auth()->user()->name ?? 'Trainer' }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium transition duration-150">
                        <i class="fas fa-sign-out-alt mr-1"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    {{-- 2. 🧱 CONTAINER UTAMA (SIDEBAR + CONTENT) --}}
    <div class="flex pt-16 h-screen-minus-nav"> {{-- pt-16 (64px) untuk jarak dari fixed navbar --}}
        
        {{-- 2a. 🧭 SIDEBAR (Scrollable) --}}
        <aside class="w-64 bg-gray-800 text-white flex-shrink-0 shadow-xl overflow-y-auto">
            <div class="p-4 space-y-2">
                
                <h3 class="text-xs font-semibold uppercase text-gray-400 mt-2 mb-3">Manajemen Klien</h3>
                
                {{-- 🔗 Navigasi Utama --}}
                <a href="{{ route('trainer.dashboard') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700 transition duration-150 {{ Route::is('trainer.dashboard') ? 'bg-blue-600' : 'text-gray-300' }}">
                    <i class="fas fa-chart-line w-5"></i>
                    <span class="font-medium">Dashboard</span>
                </a>
                
                <a href="{{ route('trainer.members.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700 transition duration-150 {{ Route::is('trainer.members.*') ? 'bg-blue-600' : 'text-gray-300' }}">
                    <i class="fas fa-users w-5"></i>
                    <span class="font-medium">Manajemen Member</span>
                </a>

                <h3 class="text-xs font-semibold uppercase text-gray-400 mt-6 mb-3">Program & Nutrisi</h3>

                <a href="{{ route('trainer.programs.edit', ['member' => 1]) }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700 transition duration-150 {{ Route::is('trainer.programs.edit') ? 'bg-blue-600' : 'text-gray-300' }}">
                    <i class="fas fa-dumbbell w-5"></i>
                    <span class="font-medium">Program Latihan</span>
                </a>

                <a href="{{ route('trainer.programs.supplements.index', ['member' => 1]) }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700 transition duration-150 {{ Route::is('trainer.programs.supplements.index') ? 'bg-blue-600' : 'text-gray-300' }}">
                    <i class="fas fa-prescription-bottle-alt w-5"></i>
                    <span class="font-medium">Nutrisi & Suplemen</span>
                </a>
                
                <h3 class="text-xs font-semibold uppercase text-gray-400 mt-6 mb-3">Komunikasi & Kualitas</h3>

                <a href="{{ route('trainer.communication.chat.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700 transition duration-150 {{ Route::is('trainer.communication.chat.*') ? 'bg-blue-600' : 'text-gray-300' }}">
                    <i class="fas fa-comments w-5"></i>
                    <span class="font-medium">Pesan Klien</span>
                </a>

                <a href="{{ route('trainer.communication.notifications.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700 transition duration-150 {{ Route::is('trainer.communication.notifications.*') ? 'bg-blue-600' : 'text-gray-300' }}">
                    <i class="fas fa-bell w-5"></i>
                    <span class="font-medium">Notifikasi</span>
                </a>

                <a href="{{ route('trainer.quality.verification.status') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700 transition duration-150 {{ Route::is('trainer.quality.verification.status') ? 'bg-blue-600' : 'text-gray-300' }}">
                    <i class="fas fa-medal w-5"></i>
                    <span class="font-medium">Kualitas Trainer</span>
                </a>

            </div>
        </aside>

        {{-- 2b. 🧩 MAIN CONTENT (Scrollable) --}}
        <main class="flex-grow bg-gray-100 main-content-scroll">
            <div class="p-8 space-y-8 max-w-7xl mx-auto">
                {{-- Judul Halaman --}}
                <header class="pb-4 border-b border-gray-200">
                    <h1 class="text-3xl font-extrabold text-gray-900">@yield('title', 'Dashboard')</h1>
                </header>

                {{-- Konten Dinamis --}}
                @yield('content')
            </div>
        </main>
    </div>

    {{-- Tambahkan Font Awesome untuk ikon yang lebih keren --}}
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous" defer></script>
</body>
</html>