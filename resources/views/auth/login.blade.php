<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - NeoFit AI</title>

    <script src="https://cdn.tailwindcss.com"></script>
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
            top: 0; left: 0; right: 0; bottom: 0;
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

        .floating-element {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
    </style>
</head>
<body class="text-slate-200">

    <!-- Background Elements -->
    <div class="parallax-bg"></div>
    <div class="absolute inset-0 bg-gradient-to-br from-slate-900/90 via-slate-900/80 to-slate-900/90 z-0"></div>

    <!-- Floating Background Elements -->
    <div class="absolute top-1/4 right-1/4 w-72 h-72 bg-green-500/10 rounded-full blur-3xl animate-pulse-slow z-0"></div>
    <div class="absolute bottom-1/3 left-1/4 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl animate-pulse-slow z-0" style="animation-delay: 2s;"></div>

    <div class="min-h-screen flex items-center justify-center px-4 relative z-10">
        <div class="w-full sm:max-w-md animate-fade-in-up">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center gap-3 px-5 py-3 rounded-2xl bg-green-500/15 backdrop-blur-sm border border-green-500/20 mb-6">
                    <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                    <span class="text-sm font-semibold text-green-400 uppercase tracking-wider">AI-Powered Fitness</span>
                </div>

                <h1 class="font-bold text-4xl sm:text-5xl text-white mb-3">
                    <span class="bg-gradient-to-r from-green-400 via-emerald-400 to-teal-400 bg-clip-text text-transparent">
                        NeoFit
                    </span>
                    <span class="text-white">AI</span>
                </h1>
                <p class="text-lg text-slate-400">Selamat Datang Kembali!</p>
            </div>

            <!-- Login Card -->
            <div class="glass-effect rounded-3xl p-8 shadow-2xl shadow-black/30">
                <!-- Notifikasi Error -->
                @if(session('error'))
                    <div class="mb-6 bg-red-500/15 backdrop-blur-sm text-red-400 border border-red-500/20 p-4 rounded-xl text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Validasi Error -->
                @if ($errors->any())
                    <div class="mb-6 bg-red-500/15 backdrop-blur-sm text-red-400 border border-red-500/20 p-4 rounded-xl">
                        <ul class="list-disc list-inside text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Field -->
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium text-slate-300 mb-2">Email</label>
                        <div class="relative">
                            <input type="email" id="email" name="email"
                                class="input-field w-full rounded-xl py-3 px-4 text-slate-200 placeholder-slate-500
                                       @error('email') border-red-500 @enderror"
                                placeholder="Masukkan Email" value="{{ old('email') }}" required autofocus>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div class="mb-6">
                        <label for="password" class="block text-sm font-medium text-slate-300 mb-2">Password</label>
                        <div class="relative">
                            <input type="password" id="password" name="password"
                                class="input-field w-full rounded-xl py-3 px-4 text-slate-200 placeholder-slate-500
                                       @error('password') border-red-500 @enderror"
                                placeholder="Masukkan Password" required>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Login Button -->
                    <button type="submit"
                        class="btn-primary w-full py-3 rounded-xl text-base font-bold text-white mb-6 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        MASUK KE AKUN
                    </button>

                    <!-- Divider -->
                    <div class="relative w-full flex items-center justify-center my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-slate-700/50"></div>
                        </div>
                        <div class="relative px-4 text-slate-500 text-sm bg-slate-900/70 backdrop-blur-sm rounded-lg">ATAU</div>
                    </div>

                    <!-- Google Login -->
                    <a href="{{ route('login.google') }}"
                       class="btn-secondary w-full flex items-center justify-center px-4 py-3 rounded-xl text-sm font-medium text-slate-300 mb-6">
                        <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                            <path fill="#FFC107" d="M43.611 20.083H42V20H24v8h11.303c-1.649 4.657-6.08 8-11.303 8-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4 12.955 4 4 12.955 4 24s8.955 20 20 20 20-8.955 20-20c0-1.341-.138-2.65-.389-3.917z"/>
                            <path fill="#FF3D00" d="m6.306 14.691 6.571 4.819C14.655 15.108 18.961 12 24 12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4 16.318 4 9.656 8.337 6.306 14.691z"/>
                            <path fill="#4CAF50" d="M24 44c5.166 0 9.86-1.977 13.409-5.192l-6.19-5.238A11.91 11.91 0 0 1 24 36c-5.202 0-9.619-3.317-11.283-7.946l-6.522 5.025C9.505 39.556 16.227 44 24 44z"/>
                            <path fill="#1976D2" d="M43.611 20.083H42V20H24v8h11.303a12.04 12.04 0 0 1-4.087 5.571l.003-.002 6.19 5.238C36.971 39.205 44 34 44 24c0-1.341-.138-2.65-.389-3.917z"/>
                        </svg>
                        <span>Masuk dengan Google</span>
                    </a>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between text-sm">
                        <label for="remember" class="flex items-center text-slate-400 cursor-pointer">
                            <input id="remember" type="checkbox"
                                class="rounded border-slate-600 bg-slate-700/60 text-green-500 focus:ring-green-400 focus:ring-offset-slate-900"
                                name="remember">
                            <span class="ml-2">Tetap Masuk</span>
                        </label>

                        <a href="{{ route('password.request') }}" class="text-slate-400 hover:text-green-400 transition-colors duration-300">
                            Lupa Kata Sandi?
                        </a>
                    </div>
                </form>
            </div>

            <!-- Register Link -->
            <div class="text-center mt-8 text-sm">
                <p class="text-slate-500">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-green-400 hover:text-green-300 font-semibold transition-colors duration-300 ml-1">
                        DAFTAR SEKARANG
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
