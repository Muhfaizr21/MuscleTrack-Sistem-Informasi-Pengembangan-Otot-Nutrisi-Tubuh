<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lengkapi Pendaftaran - MuscleTrack</title>

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
                            400: '#4ade80',
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
                        'float': 'float 6s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeInUp: {
                            'from': { opacity: '0', transform: 'translateY(30px)' },
                            'to': { opacity: '1', transform: 'translateY(0)' },
                        },
                        'pulse-slow': {
                            '0%, 100%': { opacity: '0.1' },
                            '50%': { opacity: '0.2' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-10px)' },
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
        }

        .parallax-bg {
            background-image:
                radial-gradient(circle at 20% 50%, rgba(34, 197, 94, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(59, 130, 246, 0.08) 0%, transparent 50%),
                url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=2670&auto=format&fit=crop');
            background-attachment: fixed;
            background-position: center;
            background-size: cover;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: -1;
        }

        .glass-effect {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(71, 85, 105, 0.3);
        }

        .input-field {
            background: rgba(30, 41, 59, 0.6);
            border: 1px solid rgba(71, 85, 105, 0.4);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .input-field:focus {
            border-color: #22c55e;
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.2);
        }

        .btn-primary {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            box-shadow: 0 4px 15px rgba(34, 197, 94, 0.3);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(34, 197, 94, 0.4);
        }

        .btn-secondary {
            background: rgba(30, 41, 59, 0.6);
            border: 1px solid rgba(71, 85, 105, 0.4);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-secondary:hover {
            background: rgba(30, 41, 59, 0.8);
            border-color: rgba(100, 116, 139, 0.6);
            transform: translateY(-1px);
        }

        .role-btn {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid transparent;
            cursor: pointer;
        }

        .role-btn.active {
            border-color: #22c55e;
            background: rgba(34, 197, 94, 0.1);
        }

        .role-btn:not(.active) {
            border-color: rgba(71, 85, 105, 0.4);
            background: rgba(30, 41, 59, 0.4);
        }

        .role-btn:not(.active):hover {
            border-color: rgba(100, 116, 139, 0.6);
            background: rgba(30, 41, 59, 0.6);
        }

        .floating-element {
            animation: float 6s ease-in-out infinite;
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
    </style>
</head>

<body class="text-slate-200 min-h-screen overflow-x-hidden">

    <!-- Background Elements -->
    <div class="parallax-bg"></div>
    <div class="absolute inset-0 bg-gradient-to-br from-slate-900/90 via-slate-900/80 to-slate-900/90 z-0"></div>

    <!-- Floating Background Elements -->
    <div class="absolute top-1/4 right-1/4 w-72 h-72 bg-green-500/10 rounded-full blur-3xl animate-pulse-slow z-0">
    </div>
    <div class="absolute bottom-1/3 left-1/4 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl animate-pulse-slow z-0"
        style="animation-delay: 2s;"></div>
    <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl animate-pulse-slow z-0"
        style="animation-delay: 4s;"></div>

    <!-- Main Content -->
    <div class="relative z-10 min-h-screen flex items-center justify-center px-4 py-8">
        <div class="w-full max-w-md animate-fade-in-up">

            <!-- Header Section -->
            <div class="text-center mb-8 floating-element">
                <div
                    class="inline-flex items-center gap-3 px-5 py-3 rounded-2xl bg-green-500/15 backdrop-blur-sm border border-green-500/20 mb-6">
                    <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                    <span class="text-sm font-semibold text-green-400 uppercase tracking-wider">Google
                        Registration</span>
                </div>

                <h1 class="font-bold text-4xl sm:text-5xl text-white mb-3">
                    <span
                        class="bg-gradient-to-r from-green-400 via-emerald-400 to-teal-400 bg-clip-text text-transparent">
                        MuscleTrack
                    </span>
                </h1>
                <p class="text-lg text-slate-400">Lengkapi Pendaftaran Anda</p>
            </div>

            <!-- User Info Card -->
            <div class="user-info-card rounded-2xl p-6 mb-6">
                <div class="flex items-center gap-4">
                    @if($avatar)
                        <img src="{{ $avatar }}" alt="Profile" class="w-12 h-12 rounded-full border-2 border-green-500/50">
                    @else
                        <div
                            class="w-12 h-12 rounded-full bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center border-2 border-green-500/50">
                            <span class="text-white font-bold text-lg">{{ strtoupper(substr($name, 0, 1)) }}</span>
                        </div>
                    @endif
                    <div class="flex-1">
                        <h3 class="font-semibold text-white text-lg">{{ $name }}</h3>
                        <p class="text-slate-400 text-sm">{{ $email }}</p>
                    </div>
                    <div class="px-3 py-1 bg-green-500/20 rounded-full border border-green-500/30">
                        <span class="text-green-400 text-sm font-medium">Google</span>
                    </div>
                </div>
            </div>

            <!-- Registration Card -->
            <div class="glass-effect rounded-3xl p-6 sm:p-8 shadow-2xl shadow-black/30 mb-8">

                <!-- Success Message -->
                @if(session('success'))
                    <div class="mb-6 p-4 rounded-xl bg-green-500/20 border border-green-500/30">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <span class="text-green-400 text-sm">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                <!-- Error Messages -->
                @if($errors->any())
                    <div class="mb-6 p-4 rounded-xl bg-red-500/20 border border-red-500/30">
                        <div class="flex items-center gap-3 mb-2">
                            <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-red-400 text-sm font-medium">Terdapat kesalahan dalam pengisian form</span>
                        </div>
                        <ul class="text-red-400 text-sm list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Registration Form -->
                <form method="POST" action="{{ route('register.google.complete.store') }}"
                    x-data="{ selectedRole: '{{ old('role', 'user') }}' }">
                    @csrf

                    <!-- Hidden Role Input -->
                    <input type="hidden" name="role" x-model="selectedRole">

                    <!-- Role Selection Section -->
                    <div class="mb-8">
                        <label class="block text-sm font-medium text-green-400 mb-4 text-center">Pilih Peran
                            Anda:</label>

                        <div class="grid grid-cols-2 gap-4">
                            <!-- User Role -->
                            <div class="relative">
                                <button type="button" @click="selectedRole = 'user'" :class="selectedRole === 'user' ? 
                                        'border-green-400 bg-green-500/10 text-green-400 active' : 
                                        'border-slate-600 bg-slate-800/40 text-slate-400'"
                                    class="role-btn w-full flex flex-col items-center p-4 rounded-xl transition-all duration-300 group">

                                    <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300"
                                        :class="selectedRole === 'user' ? 
                                            'bg-gradient-to-br from-green-500/20 to-emerald-600/20' : 
                                            'bg-slate-700/60'">
                                        <svg class="w-6 h-6"
                                            :class="selectedRole === 'user' ? 'text-green-400' : 'text-slate-500'"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                    </div>
                                    <span class="font-semibold text-sm mb-1">USER</span>
                                    <span class="text-xs"
                                        :class="selectedRole === 'user' ? 'text-green-400' : 'text-slate-500'">Fitness
                                        Enthusiast</span>

                                    <template x-if="selectedRole === 'user'">
                                        <div class="role-indicator">
                                            <svg class="text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                    </template>
                                </button>
                            </div>

                            <!-- Trainer Role -->
                            <div class="relative">
                                <button type="button" @click="selectedRole = 'trainer'" :class="selectedRole === 'trainer' ? 
                                        'border-blue-400 bg-blue-500/10 text-blue-400 active' : 
                                        'border-slate-600 bg-slate-800/40 text-slate-400'"
                                    class="role-btn w-full flex flex-col items-center p-4 rounded-xl transition-all duration-300 group">

                                    <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300"
                                        :class="selectedRole === 'trainer' ? 
                                            'bg-gradient-to-br from-blue-500/20 to-cyan-600/20' : 
                                            'bg-slate-700/60'">
                                        <svg class="w-6 h-6"
                                            :class="selectedRole === 'trainer' ? 'text-blue-400' : 'text-slate-500'"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                            </path>
                                        </svg>
                                    </div>
                                    <span class="font-semibold text-sm mb-1">TRAINER</span>
                                    <span class="text-xs"
                                        :class="selectedRole === 'trainer' ? 'text-blue-400' : 'text-slate-500'">Fitness
                                        Professional</span>

                                    <template x-if="selectedRole === 'trainer'">
                                        <div class="role-indicator">
                                            <svg class="text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                    </template>
                                </button>
                            </div>
                        </div>

                        <!-- Role Selection Error -->
                        @error('role')
                            <p class="mt-2 text-sm text-red-400 text-center">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-slate-300 mb-2">Password</label>
                        <div class="relative">
                            <input type="password" id="password" name="password" value="{{ old('password') }}" class="input-field w-full rounded-xl py-3 px-4 pr-10 text-slate-200 placeholder-slate-500
                                    @error('password') border-red-500 @enderror" placeholder="Minimal 6 karakter"
                                required>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="mb-6">
                        <label for="password_confirmation"
                            class="block text-sm font-medium text-slate-300 mb-2">Konfirmasi Password</label>
                        <div class="relative">
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="input-field w-full rounded-xl py-3 px-4 pr-10 text-slate-200 placeholder-slate-500"
                                placeholder="Ulangi password" required>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Terms & Conditions -->
                    <div class="mb-6">
                        <div class="flex items-start gap-3">
                            <input type="checkbox" id="terms" name="terms" value="1" {{ old('terms') ? 'checked' : '' }}
                                class="mt-1 w-4 h-4 text-green-500 bg-slate-800 border-slate-600 rounded focus:ring-green-500 focus:ring-2">
                            <label for="terms" class="text-sm text-slate-400">
                                Saya menyetujui
                                <a href="#" class="text-green-400 hover:text-green-300 underline">Syarat & Ketentuan</a>
                                dan
                                <a href="#" class="text-green-400 hover:text-green-300 underline">Kebijakan Privasi</a>
                                MuscleTrack
                            </label>
                        </div>
                        @error('terms')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="btn-primary w-full py-3 rounded-xl text-base font-bold text-white mb-4 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Lengkapi Pendaftaran
                    </button>

                    <p class="text-center text-xs text-slate-500">
                        Dengan melanjutkan, Anda setuju bahwa informasi dari Google akan digunakan untuk membuat akun
                        MuscleTrack
                    </p>
                </form>
            </div>

            <!-- Back Link -->
            <div class="text-center">
                <a href="{{ route('login') }}"
                    class="inline-flex items-center gap-2 text-slate-500 hover:text-slate-400 text-sm transition-colors duration-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Login
                </a>
            </div>
        </div>
    </div>

    <script>
        // Debug: Log role changes
        document.addEventListener('alpine:initialized', () => {
            console.log('Alpine.js initialized');
        });

        // Add click handlers for role buttons to ensure they work
        document.addEventListener('DOMContentLoaded', function () {
            const roleButtons = document.querySelectorAll('[x-click^="selectedRole"]');

            roleButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const role = this.getAttribute('x-click').includes('user') ? 'user' : 'trainer';
                    console.log('Role selected:', role);

                    // Update hidden input manually as backup
                    const hiddenInput = document.querySelector('input[name="role"]');
                    if (hiddenInput) {
                        hiddenInput.value = role;
                        console.log('Hidden input updated to:', hiddenInput.value);
                    }
                });
            });

            // Log form submission
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function (e) {
                    const formData = new FormData(this);
                    console.log('Form submitted with role:', formData.get('role'));
                    console.log('Form submitted with terms:', formData.get('terms'));
                });
            }
        });
    </script>
</body>

</html>