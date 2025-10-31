<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar MuscleTrack</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: url('{{ asset('aset/muscletrack-bg.jpg') }}') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            padding: 20px 0;
        }

        .form-control::placeholder { font-size: 14px; color: #ccc; }
        .login-page { min-height: 100vh; align-items: center; }
        .card {
            border-radius: 20px;
            width: 90%;
            max-width: 420px;
            background-color: rgba(255,255,255,0.95);
            backdrop-filter: blur(5px);
            margin: 20px auto;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            height: auto;
        }
        .role-option { transition: all 0.3s ease; border-color: #ddd !important; cursor: pointer; }
        .role-option:hover {
            background-color: #f0f8ff; transform: translateY(-2px); box-shadow: 0 4px 10px rgba(13,110,253,0.1);
        }
        .role-option.active {
            border: 2px solid #0d6efd !important; background-color: #e7f1ff;
            box-shadow: 0 0 15px rgba(13,110,253,0.2);
        }
        .btn-primary { background-color: #0d6efd; border: none; font-weight: 600; }
        .btn-google {
            border: 1px solid #ddd; background-color: #fff; color: #555; font-weight: 500; transition: all 0.3s;
        }
        .btn-google:hover { background-color: #f8f9fa; border-color: #bbb; }
    </style>
</head>

<body>
    <div class="login-page d-flex align-items-center justify-content-center">
        <div class="card shadow p-4 border-0">
            <div class="text-center mb-4">
                <h4 class="mb-1 fw-bold">Daftar MuscleTrack</h4>
                <p class="text-muted small">Isi formulir di bawah untuk membuat akun baru</p>
            </div>

            <!-- Pilihan Role -->
            <div class="d-flex justify-content-between mb-4">
                <div class="role-option text-center flex-fill me-2 p-3 border rounded {{ old('role') == 'user' ? 'active' : '' }}" data-role="user">
                    <img src="{{ asset('aset/icon-user.png') }}" alt="User" class="mb-2" style="height:50px;">
                    <p class="mt-2 mb-0 fw-semibold">User</p>
                </div>
                <div class="role-option text-center flex-fill ms-2 p-3 border rounded {{ old('role') == 'trainer' ? 'active' : '' }}" data-role="trainer">
                    <img src="{{ asset('aset/icon-trainer.jpg') }}" alt="Trainer" class="mb-2" style="height:50px;">
                    <p class="mt-2 mb-0 fw-semibold">Trainer</p>
                </div>
            </div>

            <!-- Form Registrasi -->
            <form method="POST" action="{{ session('google_name') ? route('register.role.store') : route('register') }}">
                @csrf
                <input type="hidden" name="role" id="roleInput" value="{{ old('role') }}">

                <!-- Nama -->
                <div class="mb-3">
                    <input id="name" class="form-control" type="text" name="name" placeholder="Nama Lengkap"
                        value="{{ session('google_name') ?? old('name') }}"
                        {{ session('google_name') ? 'readonly' : '' }} required autofocus>
                    <span class="text-danger small mt-1">@error('name') {{ $message }} @enderror</span>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <input id="email" class="form-control" type="email" name="email" placeholder="Email"
                        value="{{ session('google_email') ?? old('email') }}"
                        {{ session('google_email') ? 'readonly' : '' }} required>
                    <span class="text-danger small mt-1">@error('email') {{ $message }} @enderror</span>
                </div>

                <!-- Password & Konfirmasi -->
                <div class="mb-3">
                    <input id="password" class="form-control" type="password" name="password" placeholder="Password" required>
                    <span class="text-danger small mt-1">@error('password') {{ $message }} @enderror</span>
                </div>
                <div class="mb-3">
                    <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>
                    <span class="text-danger small mt-1">@error('password_confirmation') {{ $message }} @enderror</span>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3">Daftar & Lanjutkan</button>

                <div class="d-flex align-items-center my-3">
                    <hr class="flex-grow-1">
                    <span class="mx-2 text-muted small">atau</span>
                    <hr class="flex-grow-1">
                </div>

                <a href="{{ route('register.google') }}" class="btn btn-google w-100 mb-3 d-flex align-items-center justify-content-center">
                    <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" width="20" class="me-2" alt="Google Logo">
                    <span>Daftar / Login dengan Google</span>
                </a>

                <p class="text-center mt-2 small">
                    Sudah punya akun? <a href="{{ route('login') }}" class="text-decoration-none fw-semibold">Login</a>
                </p>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.role-option').forEach(btn => {
            btn.addEventListener('click', function () {
                const role = this.getAttribute('data-role');
                const roleInput = document.getElementById('roleInput');
                const roleOptions = document.querySelectorAll('.role-option');

                roleInput.value = role;
                roleOptions.forEach(el => el.classList.remove('active'));
                this.classList.add('active');
            });
        });

        document.addEventListener('DOMContentLoaded', () => {
            const initialRole = document.getElementById('roleInput').value;
            if (initialRole) {
                const activeRoleBtn = document.querySelector(`.role-option[data-role="${initialRole}"]`);
                if (activeRoleBtn) activeRoleBtn.classList.add('active');
            }
        });
    </script>
</body>
</html>
