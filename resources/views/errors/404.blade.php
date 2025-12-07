<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #f1f5f9;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
        }

        .container {
            max-width: 500px;
            width: 90%;
            text-align: center;
            animation: fadeIn 0.8s ease-out;
        }

        .error-card {
            background: rgba(30, 41, 59, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 3rem 2rem;
            border: 1px solid rgba(220, 38, 38, 0.3);
            box-shadow:
                0 20px 40px rgba(0, 0, 0, 0.3),
                0 0 0 1px rgba(220, 38, 38, 0.1);
        }

        .error-icon {
            font-size: 4rem;
            color: #ef4444;
            margin-bottom: 1rem;
        }

        .error-code {
            font-size: 6rem;
            font-weight: 800;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1;
            margin-bottom: 0.5rem;
        }

        .error-title {
            font-size: 2rem;
            font-weight: 700;
            color: #f8fafc;
            margin-bottom: 1rem;
        }

        .error-message {
            color: #cbd5e1;
            line-height: 1.6;
            margin-bottom: 2rem;
            font-size: 1.1rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.875rem 2rem;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            margin: 0.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(220, 38, 38, 0.4);
        }

        .btn-secondary {
            background: rgba(71, 85, 105, 0.5);
            color: #e2e8f0;
            border: 1px solid rgba(100, 116, 139, 0.3);
        }

        .btn-secondary:hover {
            background: rgba(100, 116, 139, 0.5);
            transform: translateY(-2px);
        }

        /* Floating elements */
        .float-1 {
            position: fixed;
            top: 20%;
            right: 10%;
            width: 200px;
            height: 200px;
            background: linear-gradient(45deg, rgba(239, 68, 68, 0.1), rgba(220, 38, 38, 0.05));
            border-radius: 50%;
            filter: blur(40px);
            animation: float 15s infinite ease-in-out;
        }

        .float-2 {
            position: fixed;
            bottom: 20%;
            left: 10%;
            width: 300px;
            height: 300px;
            background: linear-gradient(45deg, rgba(153, 27, 27, 0.1), rgba(127, 29, 29, 0.05));
            border-radius: 50%;
            filter: blur(60px);
            animation: float 20s infinite ease-in-out reverse;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(20px, -20px) scale(1.1); }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive */
        @media (max-width: 640px) {
            .error-code {
                font-size: 5rem;
            }

            .error-title {
                font-size: 1.75rem;
            }

            .error-card {
                padding: 2rem 1.5rem;
            }

            .btn {
                padding: 0.75rem 1.5rem;
                width: 100%;
                justify-content: center;
                margin: 0.25rem 0;
            }

            .float-1, .float-2 {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Background elements -->
    <div class="float-1"></div>
    <div class="float-2"></div>

    <!-- Main content -->
    <div class="container">
        <div class="error-card">
            <!-- Icon -->
            <div class="error-icon">
                <i class="fas fa-lock"></i>
            </div>

            <!-- Error code -->
            <h1 class="error-code">403</h1>

            <!-- Title -->
            <h2 class="error-title">Akses Ditolak</h2>

            <!-- Message -->
            <p class="error-message">
                Anda tidak memiliki izin untuk mengakses halaman ini.
                Jika Anda merasa ini kesalahan, silakan hubungi administrator.
            </p>

            <!-- Buttons -->
            <div>
                <a href="{{ url('/') }}" class="btn btn-primary">
                    <i class="fas fa-home"></i>
                    Kembali ke Beranda
                </a>

                <a href="javascript:history.back()" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </a>
            </div>
        </div>
    </div>
</body>
</html>
