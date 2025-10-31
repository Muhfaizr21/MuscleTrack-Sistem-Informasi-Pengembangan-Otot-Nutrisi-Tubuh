<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - MuscleXpert</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&family=Playfair+Display:wght@700;800&display=swap"
        rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'sans-serif'],
                        'serif': ['"Playfair Display"', 'serif']
                    },
                    colors: {
                        'amber': tailwind.colors.amber,
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #000;
        }

        .parallax-bg {
            background-image: url('https://images.unsplash.com/photo-1549060279-7e168f983401?q=80&w=2832&auto=format&fit=crop');
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: -1;
            opacity: 0.15;
        }
    </style>
</head>

<body class="bg-black text-gray-200">

    <div class="parallax-bg"></div>

    <div class="min-h-screen flex items-center justify-center px-4 py-12">

        <div class="w-full sm:max-w-md">

            <div class="text-left mb-6">
                <a href="/" class="font-serif text-5xl font-bold text-white">
                    Muscle<span class="text-amber-400">Xpert</span>
                </a>
                <p class="mt-2 text-lg text-gray-400">Buat Akun Baru Anda.</p>
            </div>

            <div class="p-8 bg-black/70 backdrop-blur-lg border border-gray-700/50 shadow-md sm:rounded-lg">

                {{-- Notifikasi Error dari Session --}}
                @if(session('error'))
                    <div class="mb-4 bg-red-900/50 text-red-300 border border-red-700 p-4 rounded-md text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Validasi Error --}}
                @if ($errors->any())
                    <div class="mb-4 bg-red-900/50 text-red-300 border border-red-700 p-4 rounded-md">
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST"
                    action="{{ session('google_name') ? route('register.role.store') : route('register') }}"
                    x-data="{ role: '{{ old('role', 'user') }}' }">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-amber-400 mb-2">Saya ingin mendaftar
                            sebagai:</label>
                        <input type="hidden" name="role" x-model="role">

                        <div class="grid grid-cols-2 gap-4">
                            <button type="button" @click="role = 'user'" :class="{
                                    'border-amber-400 bg-gray-800 text-amber-400': role === 'user',
                                    'border-gray-700 text-gray-400 hover:bg-gray-800': role !== 'user'
                                }" class="flex flex-col items-center p-4 border-2 rounded-lg transition-all">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="mt-2 font-semibold">USER</span>
                            </button>

                            <button type="button" @click="role = 'trainer'" :class="{
                                    'border-amber-400 bg-gray-800 text-amber-400': role === 'trainer',
                                    'border-gray-700 text-gray-400 hover:bg-gray-800': role !== 'trainer'
                                }" class="flex flex-col items-center p-4 border-2 rounded-lg transition-all">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                    </path>
                                </svg>
                                <span class="mt-2 font-semibold">TRAINER</span>
                            </button>
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="name" class="block text-sm font-medium text-gray-300">Nama Lengkap</label>
                        <input type="text" id="name" name="name" value="{{ session('google_name') ?? old('name') }}"
                            {{ session('google_name') ? 'readonly' : '' }} class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white
                                  focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50
                                  @if(session('google_name')) bg-gray-900 text-gray-500 @endif
                                  @error('name') border-red-500 @enderror" placeholder="Masukkan Nama" required
                            autofocus>
                    </div>

                    <div class="mt-4">
                        <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                        <input type="email" id="email" name="email"
                            value="{{ session('google_email') ?? old('email') }}"
                            {{ session('google_email') ? 'readonly' : '' }} class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white
                                  focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50
                                  @if(session('google_email')) bg-gray-900 text-gray-500 @endif
                                  @error('email') border-red-500 @enderror" placeholder="Masukkan Email" required>
                    </div>

                    {{-- Password tetap muncul meski daftar lewat Google --}}
                    <div class="mt-4">
                        <label for="password" class="block text-sm font-medium text-gray-300">Password</label>
                        <input type="password" id="password" name="password" class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white
                                  focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50
                                  @error('password') border-red-500 @enderror" placeholder="Minimal 8 karakter"
                            required>
                    </div>

                    <div class="mt-4">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-300">Konfirmasi
                            Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white
                                  focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50"
                            placeholder="Ulangi password" required>
                    </div>

                    <button type="submit"
                        class="w-full px-8 py-3 mt-6 rounded-md text-base font-bold text-black bg-amber-400 hover:bg-amber-300 transition-all shadow-lg shadow-amber-500/20">
                        {{ session('google_name') ? 'Selesaikan Pendaftaran' : 'Daftar & Lanjutkan' }}
                    </button>

                    <div class="relative w-full flex items-center justify-center my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-700"></div>
                        </div>
                        <div class="relative px-4 text-gray-400 text-sm"
                            style="background-color: rgba(26, 26, 26, 0.8);">
                            ATAU
                        </div>
                    </div>

                    <div>
                        <a href="{{ route('register.google') }}"
                            class="w-full flex items-center justify-center px-4 py-2 border border-gray-600 rounded-md text-sm font-medium text-gray-300 hover:bg-gray-800 transition-colors">
                            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                                <path fill="#FFC107"
                                    d="M43.611 20.083H42V20H24v8h11.303c-1.649 4.657-6.08 8-11.303 8c-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4C12.955 4 4 12.955 4 24s8.955 20 20 20s20-8.955 20-20c0-1.341-.138-2.65-.389-3.917z" />
                                <path fill="#FF3D00"
                                    d="m6.306 14.691l6.571 4.819C14.655 15.108 18.961 12 24 12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4C16.318 4 9.656 8.337 6.306 14.691z" />
                                <path fill="#4CAF50"
                                    d="M24 44c5.166 0 9.86-1.977 13.409-5.192l-6.19-5.238C29.211 35.091 26.715 36 24 36c-5.202 0-9.619-3.119-11.383-7.572l-6.571 4.819C9.656 40.663 16.318 44 24 44z" />
                                <path fill="#1976D2"
                                    d="M43.611 20.083H42V20H24v8h11.303c-0.792 2.237-2.231 4.166-4.087 5.571l6.19 5.238C39.756 34.631 44 27.925 44 20c0-1.341-.138-2.65-.389-3.917z" />
                            </svg>
                            <span>Daftar / Login dengan Google</span>
                        </a>
                    </div>
                </form>
            </div>

            <div class="text-center mt-8 text-sm">
                <a href="{{ route('login') }}" class="underline text-gray-400 hover:text-amber-400">
                    Sudah punya akun? Login
                </a>
            </div>

        </div>
    </div>
</body>

</html>