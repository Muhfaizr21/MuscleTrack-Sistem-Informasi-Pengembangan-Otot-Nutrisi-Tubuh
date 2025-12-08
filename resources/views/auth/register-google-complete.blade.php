<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lengkapi Pendaftaran - MuscleXpert</title>

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

        .user-info-card {
            background: rgba(30, 41, 59, 0.6);
            border: 1px solid rgba(71, 85, 105, 0.4);
            border-left: 4px solid #22c55e;
        }

        .role-indicator {
            position: absolute;
            top: -8px;
            right: -8px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #22c55e;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .role-indicator svg {
            width: 12px;
            height: 12px;
        }

        .back-btn {
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            transform: translateX(-3px);
        }

        .google-badge {
            background: linear-gradient(135deg, #4285f4 0%, #34a853 25%, #fbbc05 50%, #ea4335 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
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

                <!-- Header -->
                <div class="text-center mb-8">
                    <div
                        class="inline-flex items-center gap-3 px-5 py-3 rounded-2xl bg-gradient-to-r from-blue-500/15 to-green-500/15 backdrop-blur-sm border border-blue-500/20 mb-6 animate-bounce-slow">
                        <div class="w-2 h-2 bg-blue-400 rounded-full animate-pulse"></div>
                        <span class="text-sm font-semibold google-badge uppercase tracking-wider">
                            <span class="font-bold">G</span><span class="text-red-500">o</span><span
                                class="text-yellow-500">o</span><span class="text-blue-500">g</span><span
                                class="text-green-500">l</span><span class="text-red-500">e</span> Registration
                        </span>
                    </div>

                    <h1 class="font-bold text-4xl sm:text-5xl text-white mb-3">
                        <span
                            class="bg-gradient-to-r from-green-400 via-emerald-400 to-teal-400 bg-clip-text text-transparent">
                            MuscleXpert
                        </span>
                    </h1>
                    <p class="text-lg text-slate-400">Lengkapi Pendaftaran Anda</p>
                    <p class="text-sm text-slate-500 mt-2">Hanya satu langkah lagi untuk bergabung dengan komunitas
                        fitness terbesar!</p>
                </div>

                <!-- CTA Info Bergabung - DIATAS User Info Card -->
                <div class="glass-effect rounded-3xl p-6 mb-6 shadow-xl shadow-black/30 border border-green-500/20">
                    <div class="text-center">
                        <div class="inline-flex items-center gap-2 text-green-400 mb-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            <span class="font-semibold">HANYA SATU LANGKAH LAGI!</span>
                        </div>
                        <p class="text-sm text-slate-400 mb-4">
                            Lengkapi informasi di bawah ini untuk segera bergabung dengan <span
                                class="text-green-400 font-semibold">5,000+</span> anggota MuscleXpert
                        </p>

                        <div class="grid grid-cols-3 gap-2">
                            <div class="text-center p-2 rounded-lg bg-slate-800/30">
                                <div class="text-xs text-green-400 font-semibold">✓</div>
                                <div class="text-xs text-slate-400">Google Connect</div>
                            </div>
                            <div
                                class="text-center p-2 rounded-lg bg-gradient-to-br from-green-500/20 to-emerald-600/20 border border-green-500/30">
                                <div class="text-xs text-green-400 font-semibold animate-pulse">●</div>
                                <div class="text-xs text-green-400 font-semibold">Lengkapi Data</div>
                            </div>
                            <div class="text-center p-2 rounded-lg bg-slate-800/30">
                                <div class="text-xs text-slate-400 font-semibold">→</div>
                                <div class="text-xs text-slate-400">Selesai</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Info Card -->
                <div class="user-info-card rounded-2xl p-6 mb-6">
                    <div class="flex items-center gap-4">
                        @if($avatar)
                            <div class="relative">
                                <img src="{{ $avatar }}" alt="Profile"
                                    class="w-12 h-12 rounded-full border-2 border-green-500/50">
                                <div
                                    class="absolute -top-1 -right-1 w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center border-2 border-slate-900">
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z" />
                                    </svg>
                                </div>
                            </div>
                        @else
                            <div class="relative">
                                <div
                                    class="w-12 h-12 rounded-full bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center border-2 border-green-500/50">
                                    <span class="text-white font-bold text-lg">{{ strtoupper(substr($name, 0, 1)) }}</span>
                                </div>
                                <div
                                    class="absolute -top-1 -right-1 w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center border-2 border-slate-900">
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z" />
                                    </svg>
                                </div>
                            </div>
                        @endif
                        <div class="flex-1">
                            <h3 class="font-semibold text-white text-lg">{{ $name }}</h3>
                            <p class="text-slate-400 text-sm">{{ $email }}</p>
                            <div class="flex items-center gap-2 mt-1">
                                <div class="px-2 py-0.5 bg-blue-500/20 rounded-full border border-blue-500/30">
                                    <span class="text-blue-400 text-xs font-medium">Google Connected</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Registration Card -->
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

                    @if(session('success'))
                        <div
                            class="mb-6 bg-green-500/15 backdrop-blur-sm text-green-400 border border-green-500/20 p-4 rounded-xl text-sm">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ session('success') }}</span>
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

                    <!-- Registration Form -->
                    <form method="POST" action="{{ route('register.google.complete.store') }}"
                        x-data="{ selectedRole: '{{ old('role', 'user') }}', showPassword: false, showConfirmPassword: false }">
                        @csrf

                        <!-- Hidden Role Input -->
                        <input type="hidden" name="role" x-model="selectedRole">

                        <!-- Role Selection Section -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-slate-300 mb-3 text-center">Pilih Peran
                                Anda:</label>

                            <div class="grid grid-cols-2 gap-3">
                                <!-- User Role -->
                                <div class="relative">
                                    <button type="button" @click="selectedRole = 'user'"
                                        :class="selectedRole === 'user' ? 'active' : ''"
                                        class="role-btn w-full flex flex-col items-center p-3 rounded-xl">
                                        <div class="w-10 h-10 rounded-lg flex items-center justify-center mb-2" :class="selectedRole === 'user' ? 
                                                'bg-gradient-to-br from-green-500/20 to-emerald-600/20' : 
                                                'bg-slate-700/60'">
                                            <svg class="w-5 h-5"
                                                :class="selectedRole === 'user' ? 'text-green-400' : 'text-slate-500'"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                </path>
                                            </svg>
                                        </div>
                                        <span class="font-semibold text-xs">USER</span>
                                        <span class="text-xs mt-1"
                                            :class="selectedRole === 'user' ? 'text-green-400' : 'text-slate-500'">Fitness
                                            Enthusiast</span>

                                        <template x-if="selectedRole === 'user'">
                                            <div class="role-indicator">
                                                <svg class="text-white" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </div>
                                        </template>
                                    </button>
                                </div>

                                <!-- Trainer Role -->
                                <div class="relative">
                                    <button type="button" @click="selectedRole = 'trainer'"
                                        :class="selectedRole === 'trainer' ? 'active' : ''"
                                        class="role-btn w-full flex flex-col items-center p-3 rounded-xl">
                                        <div class="w-10 h-10 rounded-lg flex items-center justify-center mb-2" :class="selectedRole === 'trainer' ? 
                                                'bg-gradient-to-br from-green-500/20 to-emerald-600/20' : 
                                                'bg-slate-700/60'">
                                            <svg class="w-5 h-5"
                                                :class="selectedRole === 'trainer' ? 'text-green-400' : 'text-slate-500'"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                                </path>
                                            </svg>
                                        </div>
                                        <span class="font-semibold text-xs">TRAINER</span>
                                        <span class="text-xs mt-1"
                                            :class="selectedRole === 'trainer' ? 'text-green-400' : 'text-slate-500'">Fitness
                                            Professional</span>

                                        <template x-if="selectedRole === 'trainer'">
                                            <div class="role-indicator">
                                                <svg class="text-white" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </div>
                                        </template>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-slate-300 mb-2">Password</label>
                            <div class="relative">
                                <input :type="showPassword ? 'text' : 'password'" name="password" required
                                    class="input-field w-full rounded-xl py-3 px-4 text-slate-200 placeholder-slate-500"
                                    placeholder="Minimal 6 karakter" value="{{ old('password') }}">
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

                        <!-- Terms & Conditions -->
                        <div class="mb-6">
                            <div class="flex items-start gap-3">
                                <input type="checkbox" name="terms" value="1" {{ old('terms') ? 'checked' : '' }}
                                    class="mt-1 rounded border-slate-600 bg-slate-700/60 text-green-500 focus:ring-green-400"
                                    required>
                                <label class="text-sm text-slate-400">
                                    Saya menyetujui
                                    <a href="#" class="text-green-400 hover:text-green-300">Syarat & Ketentuan</a>
                                    dan
                                    <a href="#" class="text-green-400 hover:text-green-300">Kebijakan Privasi</a>
                                    MuscleXpert
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="btn-primary w-full py-3 rounded-xl text-base font-bold text-white mb-6 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            LENGKAPI PENDAFTARAN
                        </button>

                        <div class="text-center text-xs text-slate-500 space-y-2">
                            <p>
                                Dengan melanjutkan, Anda setuju bahwa informasi dari Google akan digunakan untuk membuat
                                akun MuscleXpert
                            </p>
                            <div class="flex items-center justify-center gap-4 mt-4 pt-4 border-t border-slate-700/50">
                                <div class="text-center">
                                    <div class="text-green-400 font-bold">5,000+</div>
                                    <div class="text-xs text-slate-500">Anggota</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-blue-400 font-bold">50+</div>
                                    <div class="text-xs text-slate-500">Trainer</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-purple-400 font-bold">100%</div>
                                    <div class="text-xs text-slate-500">Verified</div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Back Link -->
                <div class="text-center mt-6 text-sm">
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center gap-2 text-slate-500 hover:text-green-400 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Login
                    </a>
                </div>

            </div>
        </div>

    </div> <!-- END WRAPPER -->
</body>

</html>