<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Server Error | MuscleXpert</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0f172a;
            color: #f8fafc;
        }

        .gradient-text {
            background: linear-gradient(135deg, #22c55e 0%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full text-center">
        <!-- Animated Error Icon -->
        <div class="relative mb-8">
            <div
                class="absolute inset-0 bg-gradient-to-r from-red-500/20 to-orange-500/20 rounded-full blur-xl animate-pulse">
            </div>
            <div
                class="relative bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700 rounded-2xl p-8 shadow-2xl">
                <div class="w-24 h-24 mx-auto mb-6 relative">
                    <div class="absolute inset-0 bg-red-500/10 rounded-full animate-ping"></div>
                    <svg class="w-full h-full text-red-500 relative" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.698-.833-2.464 0L4.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                </div>

                <h1 class="text-6xl font-bold gradient-text mb-2">500</h1>
                <h2 class="text-2xl font-semibold text-white mb-4">Server Error</h2>
                <p class="text-slate-400 mb-6">
                    Maaf, terjadi kesalahan pada server kami. Tim kami telah diberitahu dan sedang memperbaikinya.
                </p>

                <div class="bg-red-500/10 border border-red-500/20 rounded-xl p-4 mb-6 text-sm text-red-400">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-medium">Error Detail:</span>
                    </div>
                    <code class="text-xs break-all">{{ $exception->getMessage() ?? 'Internal Server Error' }}</code>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-3">
                    <a href="{{ url()->previous() }}"
                        class="block w-full py-3 bg-gradient-to-r from-slate-700 to-slate-800 border border-slate-600 rounded-xl text-white font-medium hover:from-slate-600 hover:to-slate-700 transition-all">
                        <div class="flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali ke Halaman Sebelumnya
                        </div>
                    </a>

                    <a href="{{ route('landing') }}"
                        class="block w-full py-3 bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl text-white font-medium hover:from-green-600 hover:to-emerald-700 transition-all shadow-lg shadow-green-500/25">
                        <div class="flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Kembali ke Beranda
                        </div>
                    </a>
                </div>

                <!-- Contact Support -->
                <div class="mt-6 pt-6 border-t border-slate-700">
                    <p class="text-slate-500 text-sm mb-2">Masih mengalami masalah?</p>
                    <a href="mailto:support@musclexpert.com"
                        class="inline-flex items-center gap-2 text-green-400 hover:text-green-300 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Hubungi Support
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center text-slate-600 text-sm">
            <p>&copy; {{ date('Y') }} MuscleXpert. All rights reserved.</p>
            <p class="text-xs mt-1">Error ID: {{ uniqid() }}</p>
        </div>
    </div>
</body>

</html>