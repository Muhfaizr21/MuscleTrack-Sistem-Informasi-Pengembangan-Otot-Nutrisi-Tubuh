<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - MuscleXpert</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#f0fdf4',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                        },
                        slate: {
                            800: '#1e293b',
                            900: '#0f172a',
                            950: '#020617',
                        }
                    },
                    animation: {
                        'fade-in-up': 'fadeInUp 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards',
                        'pulse-slow': 'pulse-slow 6s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'bounce-slow': 'bounce 2s infinite',
                    },
                    keyframes: {
                        fadeInUp: {
                            'from': { opacity: '0', transform: 'translateY(30px)' },
                            'to': { opacity: '1', transform: 'translateY(0)' },
                        },
                        'pulse-slow': {
                            '0%, 100%': { opacity: '0.1' },
                            '50%': { opacity: '0.2' },
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0f172a;
            color: #f8fafc;
            overflow-x: hidden;
        }

        .parallax-bg {
            background-image:
                radial-gradient(circle at 20% 50%, rgba(34, 197, 94, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(59, 130, 246, 0.08) 0%, transparent 50%),
                url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=2670&auto=format&fit=crop');
            background-attachment: fixed;
            background-position: center;
            background-size: cover;
        }

        .glass-effect {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(71, 85, 105, 0.3);
        }

        .input-field {
            background: rgba(30, 41, 59, 0.6);
            border: 1px solid rgba(71, 85, 105, 0.4);
            transition: all 0.3s;
        }

        .input-field:focus {
            border-color: #22c55e;
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.2);
        }

        .btn-primary {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            box-shadow: 0 4px 15px rgba(34, 197, 94, 0.3);
            transition: all 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(34, 197, 94, 0.4);
        }

        .btn-secondary {
            background: rgba(30, 41, 59, 0.6);
            border: 1px solid rgba(71, 85, 105, 0.4);
            transition: all 0.3s;
        }

        .btn-secondary:hover {
            background: rgba(30, 41, 59, 0.8);
            border-color: rgba(100, 116, 139, 0.6);
        }

        .role-btn {
            transition: all 0.3s;
            border: 2px solid transparent;
        }

        .role-btn.active {
            border-color: #22c55e;
            background: rgba(34, 197, 94, 0.1);
            color: #22c55e;
        }

        .role-btn:not(.active) {
            border-color: rgba(71, 85, 105, 0.4);
            color: #94a3b8;
            background: rgba(30, 41, 59, 0.4);
        }

        .role-btn:not(.active):hover {
            border-color: rgba(100, 116, 139, 0.6);
            background: rgba(30, 41, 59, 0.6);
        }

        .back-btn {
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            transform: translateX(-3px);
        }
    </style>
</head>

<body class="text-slate-200">

    <!-- FULL SCREEN WRAPPER -->
    <div class="relative w-full min-h-screen overflow-hidden">

        <!-- Background -->
        <div class="parallax-bg absolute inset-0 z-0"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900/90 via-slate-900/85 to-slate-900/90 z-0"></div>

        <!-- Floating Elements -->
        <div class="absolute top-1/4 right-1/4 w-72 h-72 bg-green-500/10 rounded-full blur-3xl animate-pulse-slow z-0">
        </div>
        <div class="absolute bottom-1/3 left-1/4 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl animate-pulse-slow z-0"
            style="animation-delay: 2s;"></div>

        <!-- Main Content -->
        <div class="relative z-10 min-h-screen flex items-center justify-center px-4 py-8">
            <div class="w-full sm:max-w-md animate-fade-in-up">

                <!-- Tombol Kembali ke Home -->
                <div class="mb-6">
                    <a href="{{ url('/') }}"
                        class="inline-flex items-center gap-2 text-slate-400 hover:text-green-400 transition-colors back-btn group">
                        <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span class="text-sm font-medium">Kembali ke Home</span>
                    </a>
                </div>

                <!-- Header dengan CTA yang Lebih Menarik -->
                <div class="text-center mb-8">
                    <div
                        class="inline-flex items-center gap-3 px-5 py-3 rounded-2xl bg-green-500/15 backdrop-blur-sm border border-green-500/20 mb-6 animate-bounce-slow">
                        <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                        <span class="text-sm font-semibold text-green-400 uppercase tracking-wider">Bergabung dengan
                            5,000+ Anggota</span>
                    </div>

                    <h1 class="font-bold text-4xl sm:text-5xl text-white mb-3">
                        <span
                            class="bg-gradient-to-r from-green-400 via-emerald-400 to-teal-400 bg-clip-text text-transparent">
                            MuscleXpert
                        </span>
                    </h1>
                    <p class="text-lg text-slate-400">Mulai Perjalanan Fitness Anda!</p>
                    <p class="text-sm text-slate-500 mt-2">Daftar sekarang dan dapatkan akses ke semua fitur premium</p>
                </div>

                <!-- CTA Login - DIATAS Register Card -->
                <div class="glass-effect rounded-3xl p-6 mb-6 shadow-xl shadow-black/30 border border-green-500/20">
                    <div class="text-center">
                        <div class="inline-flex items-center gap-2 text-green-400 mb-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            <span class="font-semibold">SUDAH PUNYA AKUN?</span>
                        </div>
                        <p class="text-sm text-slate-400 mb-4">
                            Masuk untuk melanjutkan perjalanan fitness-mu dan akses semua fitur!
                        </p>

                        <a href="{{ route('login') }}"
                            class="block w-full py-3 bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl text-white font-bold hover:from-green-600 hover:to-emerald-700 transition-all shadow-lg shadow-green-500/25 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                </svg>
                                <span>MASUK KE AKUN</span>
                            </div>
                        </a>

                        <div class="grid grid-cols-2 gap-3 mt-4">
                            <div class="text-center p-2 rounded-lg bg-slate-800/30">
                                <div class="text-lg font-bold text-green-400">5,000+</div>
                                <div class="text-xs text-slate-400">Anggota Aktif</div>
                            </div>
                            <div class="text-center p-2 rounded-lg bg-slate-800/30">
                                <div class="text-lg font-bold text-blue-400">50+</div>
                                <div class="text-xs text-slate-400">Trainer Profesional</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Register Card -->
                <div class="glass-effect rounded-3xl p-8 shadow-2xl shadow-black/30">

                    @if(session('error'))
                        <div
                            class="mb-6 bg-red-500/15 backdrop-blur-sm text-red-400 border border-red-500/20 p-4 rounded-xl text-sm">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ session('error') }}</span>
                            </div>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div
                            class="mb-6 bg-red-500/15 backdrop-blur-sm text-red-400 border border-red-500/20 p-4 rounded-xl">
                            <ul class="list-disc list-inside text-sm space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Role Selection Section -->
                    <div class="mb-6" x-data="{ role: 'user' }">
                        <label class="block text-sm font-medium text-slate-300 mb-3 text-center">Pilih Peran
                            Anda:</label>

                        <div class="grid grid-cols-2 gap-3">
                            <!-- User Role -->
                            <button type="button" @click="role = 'user'" :class="role === 'user' ? 'active' : ''"
                                class="role-btn flex flex-col items-center p-3 rounded-xl">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center mb-2" :class="role === 'user' ? 
                                        'bg-gradient-to-br from-green-500/20 to-emerald-600/20' : 
                                        'bg-slate-700/60'">
                                    <svg class="w-5 h-5" :class="role === 'user' ? 'text-green-400' : 'text-slate-500'"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                </div>
                                <span class="font-semibold text-xs">USER</span>
                                <span class="text-xs mt-1"
                                    :class="role === 'user' ? 'text-green-400' : 'text-slate-500'">Fitness
                                    Enthusiast</span>
                            </button>

                            <!-- Trainer Role -->
                            <button type="button" @click="role = 'trainer'" :class="role === 'trainer' ? 'active' : ''"
                                class="role-btn flex flex-col items-center p-3 rounded-xl">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center mb-2" :class="role === 'trainer' ? 
                                        'bg-gradient-to-br from-green-500/20 to-emerald-600/20' : 
                                        'bg-slate-700/60'">
                                    <svg class="w-5 h-5"
                                        :class="role === 'trainer' ? 'text-green-400' : 'text-slate-500'" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                        </path>
                                    </svg>
                                </div>
                                <span class="font-semibold text-xs">TRAINER</span>
                                <span class="text-xs mt-1"
                                    :class="role === 'trainer' ? 'text-green-400' : 'text-slate-500'">Fitness
                                    Professional</span>
                            </button>
                        </div>
                    </div>

                    <!-- Registration Form -->
                    <form method="POST" action="{{ route('register') }}"
                        x-data="{ role: 'user', showPassword: false, showConfirmPassword: false }">
                        @csrf
                        <input type="hidden" name="role" x-model="role">

                        <!-- Name Field -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-slate-300 mb-2">Nama Lengkap</label>
                            <div class="relative">
                                <input type="text" name="name" required autofocus
                                    class="input-field w-full rounded-xl py-3 px-4 text-slate-200 placeholder-slate-500"
                                    placeholder="Masukkan Nama" value="{{ old('name') }}">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Email Field -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-slate-300 mb-2">Email</label>
                            <div class="relative">
                                <input type="email" name="email" required
                                    class="input-field w-full rounded-xl py-3 px-4 text-slate-200 placeholder-slate-500"
                                    placeholder="Masukkan Email" value="{{ old('email') }}">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-slate-300 mb-2">Password</label>
                            <div class="relative">
                                <input :type="showPassword ? 'text' : 'password'" name="password" required
                                    class="input-field w-full rounded-xl py-3 px-4 text-slate-200 placeholder-slate-500"
                                    placeholder="Minimal 8 karakter" id="password">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <button type="button" @click="showPassword = !showPassword"
                                        class="text-slate-500 hover:text-slate-300">
                                        <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-slate-300 mb-2">Konfirmasi Password</label>
                            <div class="relative">
                                <input :type="showConfirmPassword ? 'text' : 'password'" name="password_confirmation"
                                    required
                                    class="input-field w-full rounded-xl py-3 px-4 text-slate-200 placeholder-slate-500"
                                    placeholder="Ulangi password">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <button type="button" @click="showConfirmPassword = !showConfirmPassword"
                                        class="text-slate-500 hover:text-slate-300">
                                        <svg x-show="!showConfirmPassword" class="w-5 h-5" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg x-show="showConfirmPassword" class="w-5 h-5" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="flex items-start text-sm text-slate-400 mb-6">
                            <input type="checkbox" name="terms" required
                                class="rounded border-slate-600 bg-slate-700/60 text-green-500 focus:ring-green-400 mt-1">
                            <span class="ml-2">
                                Saya setuju dengan
                                <a href="#" class="text-green-400 hover:text-green-300 transition-colors">Syarat &
                                    Ketentuan</a>
                                dan
                                <a href="#" class="text-green-400 hover:text-green-300 transition-colors">Kebijakan
                                    Privasi</a>
                                MuscleXpert
                            </span>
                        </div>

                        <!-- Register Button -->
                        <button type="submit"
                            class="btn-primary w-full py-3 rounded-xl text-base font-bold text-white mb-6 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            DAFTAR AKUN
                        </button>

                        <!-- Divider -->
                        <div class="relative w-full flex items-center justify-center my-6">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-slate-700/50"></div>
                            </div>
                            <div
                                class="relative px-4 text-slate-500 text-sm bg-slate-900/70 backdrop-blur-sm rounded-lg">
                                atau daftar dengan
                            </div>
                        </div>

                        <!-- Google Register -->
                        <a href="{{ route('register.google') }}"
                            class="btn-secondary w-full flex items-center justify-center px-4 py-3 rounded-xl text-sm font-medium text-slate-300 mb-6 hover:border-slate-500 transition-all">
                            <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                                <path fill="#FFC107"
                                    d="M43.611 20.083H42V20H24v8h11.303c-1.649 4.657-6.08 8-11.303 8-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4 12.955 4 4 12.955 4 24s8.955 20 20 20 20-8.955 20-20c0-1.341-.138-2.65-.389-3.917z" />
                                <path fill="#FF3D00"
                                    d="m6.306 14.691l6.571 4.819C14.655 15.108 18.961 12 24 12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4C16.318 4 9.656 8.337 6.306 14.691z" />
                                <path fill="#4CAF50"
                                    d="M24 44c5.166 0 9.86-1.977 13.409-5.192l-6.19-5.238C29.211 35.091 26.715 36 24 36c-5.202 0-9.619-3.317-11.383-7.946l-6.571 4.819C9.505 39.556 16.318 44 24 44z" />
                                <path fill="#1976D2"
                                    d="M43.611 20.083H42V20H24v8h11.303a12.04 12.04 0 0 1-4.087 5.571l.003-.002 6.19 5.238C36.971 39.205 44 34 44 24c0-1.341-.138-2.65-.389-3.917z" />
                            </svg>
                            <span>Daftar dengan Google</span>
                        </a>
                    </form>
                </div>

                <!-- Login Link -->
                <div class="text-center mt-6 text-sm">
                    <p class="text-slate-500">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-green-400 hover:text-green-300 font-semibold">
                            Masuk di sini
                        </a>
                    </p>
                </div>

            </div>
        </div>

    </div> <!-- END WRAPPER -->
</body>

</html>