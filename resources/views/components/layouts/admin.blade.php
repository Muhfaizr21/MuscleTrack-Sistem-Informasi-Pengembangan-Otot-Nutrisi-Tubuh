<!-- resources/views/layouts/admin.blade.php -->
<!DOCTYPE html>
<html lang="id" x-data="{ isSidebarOpen: window.innerWidth >= 768 }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@hasSection('title') @yield('title') | @endif Admin MuscleXpert</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles & Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        'primary': {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            min-height: 100vh;
        }

        .glass-effect {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .gradient-text {
            background: linear-gradient(90deg, #10b981 0%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>

    @stack('styles')
</head>
<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-gray-200 min-h-screen">
    <!-- Sidebar -->
    <aside class="fixed inset-y-0 left-0 z-30 w-64 transform transition-all duration-300 ease-in-out"
           :class="isSidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           x-show="isSidebarOpen"
           x-transition:enter="transition ease-out duration-300"
           x-transition:enter-start="-translate-x-full"
           x-transition:enter-end="translate-x-0"
           x-transition:leave="transition ease-in duration-200"
           x-transition:leave-start="translate-x-0"
           x-transition:leave-end="-translate-x-full"
           x-cloak>
        <x-admin.sidebar />
    </aside>

    <!-- Mobile Sidebar Overlay -->
    <div x-show="isSidebarOpen && window.innerWidth < 768"
         @click="isSidebarOpen = false"
         class="fixed inset-0 bg-black/50 backdrop-blur-sm z-20 transition-opacity duration-300"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         x-cloak></div>

    <!-- Main Content -->
    <main class="min-h-screen transition-all duration-300"
          :class="isSidebarOpen ? 'md:ml-64' : ''">

        <!-- Header -->
        <x-admin.header>
            @hasSection('title')
                @yield('title')
            @else
                Dashboard
            @endif
        </x-admin.header>

        <!-- Content -->
        <div class="p-4 md:p-6">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="mb-6 bg-green-500/20 border border-green-500/30 rounded-xl p-4">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div class="text-green-300">{{ session('success') }}</div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-500/20 border border-red-500/30 rounded-xl p-4">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div class="text-red-300">{{ session('error') }}</div>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 bg-amber-500/20 border border-amber-500/30 rounded-xl p-4">
                    <div class="flex items-center gap-3 mb-2">
                        <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                        <div class="font-semibold text-amber-300">Perhatian!</div>
                    </div>
                    <ul class="text-amber-300/80 text-sm space-y-1 ml-8">
                        @foreach($errors->all() as $error)
                            <li class="list-disc">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Main Content Slot -->
            <div class="glass-effect rounded-2xl p-6 md:p-8">
                {{ $slot }}
            </div>
        </div>
    </main>

    <!-- Global JavaScript -->
    <script>
        // CSRF Token untuk AJAX
        window.csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Initialize sidebar state based on screen size
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-close sidebar on mobile when clicking links
            document.querySelectorAll('a[href]').forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 768) {
                        Alpine.$data(document.documentElement).isSidebarOpen = false;
                    }
                });
            });

            // Escape key to close sidebar
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    Alpine.$data(document.documentElement).isSidebarOpen = false;
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
