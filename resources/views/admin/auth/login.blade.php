<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Admin Elunora School</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Elunora Theme CSS -->
    <link rel="stylesheet" href="{{ asset('css/elunora-theme.css') }}">
    <style>
        :root {
            --admin-primary: #1e3a8a;
            --admin-secondary: #64748b;
            --admin-accent: #2563eb;
            --admin-success: #059669;
            --admin-warning: #f59e0b;
            --admin-danger: #dc2626;
            --admin-info: #0ea5e9;
            --admin-light: #f8fafc;
            --admin-dark: #1e293b;
        }
        
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('{{ asset("img/login.jpg") }}') center/cover no-repeat;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            width: 100%;
            max-width: 450px;
            min-height: 500px;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }
        
        .login-header {
            background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-accent) 100%);
            color: white;
            text-align: center;
            padding: 2rem;
            margin: -2rem -2rem 2rem -2rem;
            border-radius: 15px 15px 0 0;
        }
        
        .login-header h1 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: white !important;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-header p {
            color: rgba(255, 255, 255, 0.9) !important;
            font-size: 1rem;
        }
        
        
        .form-control {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 12px;
            padding: 1rem;
            font-size: 1rem;
            color: #495057;
            transition: all 0.3s ease;
        }
        
        .form-control::placeholder {
            color: #6c757d;
        }
        
        .form-control:focus {
            border-color: var(--admin-primary);
            box-shadow: 0 0 0 0.2rem rgba(30, 58, 138, 0.25);
            color: #495057;
        }
        
        .btn-login {
            background: linear-gradient(135deg, var(--admin-primary), var(--admin-accent));
            border: none;
            border-radius: 12px;
            padding: 1rem 2rem;
            font-size: 1.1rem;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 15px rgba(30, 58, 138, 0.3);
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(30, 58, 138, 0.4);
            background: linear-gradient(135deg, var(--admin-accent), var(--admin-primary));
        }
        
        .form-label {
            color: #495057;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .alert {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            border-radius: 12px;
        }
        
        .login-footer a:hover {
            color: var(--admin-accent);
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-card elunora-login-card">
        <div class="login-header">
            <h1><img src="{{ asset('img/logo.png') }}" alt="Elunora School" style="height: 55px; width: auto; margin-right: 10px;">Elunora School</h1>
            <p class="mb-0">Panel Administrasi</p>
        </div>

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label fw-bold"><i class="fas fa-envelope me-2"></i>Email</label>
                <input type="email" class="form-control elunora-form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Masukkan email Anda">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label fw-bold"><i class="fas fa-lock me-2"></i>Password</label>
                <input type="password" class="form-control elunora-form-control @error('password') is-invalid @enderror" id="password" name="password" required placeholder="Masukkan password Anda">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">
                    <i class="fas fa-remember me-1"></i>Ingat Saya
                </label>
            </div>
            <div class="d-grid gap-2 mb-3">
                <button type="submit" class="btn btn-primary elunora-btn-primary">
                    <i class="fas fa-sign-in-alt me-2"></i>Masuk ke Admin Panel
                </button>
            </div>
        </form>
        <div class="login-footer">
            <a href="{{ route('admin.password.request') }}">
                <i class="fas fa-question-circle me-1"></i>Lupa Password?
            </a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>