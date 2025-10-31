<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MuscleXpert</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">

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
            background-image: url('https://images.unsplash.com/photo-1549060279-7e168f983401?q=80&w=2832&auto:format&fit=crop');
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            z-index: -1;
            opacity: 0.15;
        }
    </style>
</head>
<body class="bg-black text-gray-200">

    <div class="parallax-bg"></div>

    <div class="min-h-screen flex items-center justify-center px-4">

        <div class="w-full sm:max-w-md">

            <div class="text-left mb-6">
                <a href="/" class="font-serif text-5xl font-bold text-white">
                    Muscle<span class="text-amber-400">Xpert</span>
                </a>
                <p class="mt-2 text-lg text-gray-400">Selamat Datang Kembali.</p>
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

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                        <input type="email" id="email"
                               class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white
                                      focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50
                                      @error('email') border-red-500 @enderror"
                               name="email" placeholder="Masukkan Email" value="{{ old('email') }}" required autofocus>
                    </div>

                    <div class="mt-4">
                        <label for="password" class="block text-sm font-medium text-gray-300">Password</label>
                        <input type="password" id="password"
                               class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white
                                      focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50
                                      @error('password') border-red-500 @enderror"
                               name="password" placeholder="Masukkan Password" required>
                    </div>

                    <button type="submit"
                            class="w-full px-8 py-3 mt-6 rounded-md text-base font-bold text-black bg-amber-400 hover:bg-amber-300 transition-all shadow-lg shadow-amber-500/20">
                        MASUK
                    </button>

                    <div class="relative w-full flex items-center justify-center my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-700"></div>
                        </div>
                        <div class="relative px-4 text-gray-400 text-sm" style="background-color: rgba(26, 26, 26, 0.8);"> ATAU
                        </div>
                    </div>

                    <div>
                        <a href="{{ route('login.google') }}"
                           class="w-full flex items-center justify-center px-4 py-2 border border-gray-600 rounded-md text-sm font-medium text-gray-300 hover:bg-gray-800 transition-colors">
                            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                                <path fill="#FFC107" d="M43.611 20.083H42V20H24v8h11.303c-1.649 4.657-6.08 8-11.303 8c-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4C12.955 4 4 12.955 4 24s8.955 20 20 20s20-8.955 20-20c0-1.341-.138-2.65-.389-3.917z"/>
                                <path fill="#FF3D00" d="m6.306 14.691l6.571 4.819C14.655 15.108 18.961 12 24 12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4C16.318 4 9.656 8.337 6.306 14.691z"/>
                                <path fill="#4CAF50" d="M24 44c5.166 0 9.86-1.977 13.409-5.192l-6.19-5.238C29.211 35.091 26.715 36 24 36c-5.202 0-9.619-3.119-11.383-7.572l-6.571 4.819C9.656 40.663 16.318 44 24 44z"/>
                                <path fill="#1976D2" d="M43.611 20.083H42V20H24v8h11.303c-0.792 2.237-2.231 4.166-4.087 5.571l6.19 5.238C39.756 34.631 44 27.925 44 20c0-1.341-.138-2.65-.389-3.917z"/>
                            </svg>
                            <span>Masuk dengan Google</span>
                        </a>
                    </div>

                    <div class="flex items-center justify-between mt-4 text-sm">
                        <label for="remember" class="flex items-center">
                            <input id="remember" type="checkbox" class="rounded bg-gray-700 border-gray-600 text-amber-400 shadow-sm focus:ring-amber-500" name="remember">
                            <span class="ml-2 text-gray-400">Tetap Masuk</span>
                        </label>

                        <a href="{{ route('password.request') }}" class="underline text-gray-400 hover:text-amber-400">
                            Lupa Kata Sandi?
                        </a>
                    </div>
                </form>
            </div>

            <div class="text-center mt-8 text-sm">
                <a href="{{ route('register') }}" class="underline text-gray-400 hover:text-amber-400">
                    BELUM PUNYA AKUN? DAFTAR
                </a>
            </div>

        </div>
    </div>
</body>
</html>
