<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MuscleTrack</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
        }

        .bg-cover {
            background-image: url('{{ asset('aset/muscletrack-bg.jpg') }}');
            background-size: cover;
            background-position: center;
            height: 100vh;
            position: relative;
            color: white;
        }

        .overlay {
            background-color: rgba(0, 0, 0, 0.5);
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

        .login-form {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 2rem;
            backdrop-filter: blur(10px);
            color: white;
        }

        .form-control {
            background-color: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
        }

        .form-control::placeholder {
            color: #ddd;
        }

        .form-control.is-invalid {
            border: 1px solid #dc3545;
        }

        .btn-login {
            background-color: #ff5c8a;
            border: none;
            padding: 0.75rem;
            width: 100%;
            font-weight: bold;
        }

        .top-nav {
            position: absolute;
            top: 20px;
            right: 30px;
        }

        .top-nav a {
            color: #fff;
            margin-left: 20px;
            text-decoration: none;
            font-size: 14px;
        }

        .bottom-links {
            font-size: 13px;
        }

        .btn-google {
            background-color: white;
            color: #444;
            border: 1px solid #ddd;
            width: 100%;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 0.6rem;
            transition: all 0.3s;
        }

        .btn-google:hover {
            background-color: #f1f1f1;
        }

        .btn-google img {
            width: 20px;
            height: 20px;
        }
    </style>
</head>

<body>
    <div class="bg-cover">
        <div class="overlay d-flex align-items-center justify-content-center flex-column">

            <!-- Top Nav -->
            <div class="top-nav">
                <a href="{{ route('login') }}">Login</a>
                <a href="/">Beranda</a>
                <a href="{{ route('register') }}">Daftar</a>
            </div>

            <!-- Login Form -->
            <div class="login-form text-center" style="width: 100%; max-width: 400px;">
                <img src="{{ asset('aset/logo-muscletrack.png') }}" alt="Logo" style="width: 80px;">

                {{-- Notifikasi Error dari Session --}}
                @if(session('error'))
                    <div class="alert alert-danger mt-3">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Validasi Error --}}
                @if ($errors->any())
                    <div class="alert alert-danger mt-2">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3 text-start">
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               name="email" placeholder="Masukkan Email" value="{{ old('email') }}" required autofocus>
                    </div>

                    <div class="mb-3 text-start">
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               name="password" placeholder="Masukkan Password" required>
                    </div>

                    <button type="submit" class="btn btn-login text-white">MASUK</button>

                    <!-- LOGIN GOOGLE -->
                    <div class="mt-3">
                        <a href="{{ route('login.google') }}" class="btn btn-google">
                            <img src="{{ asset('aset/google.png') }}" alt="Google Logo">
                            <span>Masuk dengan Google</span>
                        </a>
                    </div>
                    <!-- END LOGIN GOOGLE -->

                    <div class="d-flex justify-content-between mt-2 bottom-links">
                        <div>
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">Tetap Masuk</label>
                        </div>
                        <a href="{{ route('password.request') }}" class="text-white text-decoration-none">Lupa Kata Sandi?</a>
                    </div>

                    <div class="d-flex justify-content-between mt-3 bottom-links">
                        <a href="{{ route('register') }}" class="text-white text-decoration-none">BELUM PUNYA AKUN? DAFTAR</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
