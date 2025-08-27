<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Admin Elunora Gallery</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --admin-primary: #007bff;
            --admin-secondary: #6c757d;
            --admin-accent: #0056b3;
        }
        
        body {
            background: #f8f9fa;
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
            max-width: 450px;
            width: 100%;
            padding: 3rem;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
            background: #ffffff;
            border: 1px solid #e9ecef;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }
        
        .login-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--admin-primary);
            margin-bottom: 0.5rem;
        }
        
        .login-header p {
            color: #6c757d;
            font-size: 1.1rem;
            font-weight: 500;
        }
        
        .form-control {
            border: 2px solid #e9ecef;
            padding: 1rem 1.5rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #ffffff;
        }
        
        .form-control:focus {
            border-color: var(--admin-primary);
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            background: white;
        }
        
        .btn-primary {
            background: var(--admin-primary);
            border: 1px solid var(--admin-primary);
            border-radius: 15px;
            padding: 1rem 2rem;
            font-size: 1.1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(0, 123, 255, 0.3);
        }
        
        .btn-primary:hover {
            background: var(--admin-accent);
            border-color: var(--admin-accent);
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(0, 86, 179, 0.4);
        }
        
        .form-check-input:checked {
            background-color: var(--admin-primary);
            border-color: var(--admin-primary);
        }
        
        .login-footer {
            text-align: center;
            margin-top: 2rem;
        }
        
        .login-footer a {
            color: var(--admin-primary);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .login-footer a:hover {
            color: var(--admin-accent);
            text-decoration: underline;
        }
        
        .alert {
            border-radius: 15px;
            border: none;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <h1><i class="fas fa-graduation-cap me-2"></i>Elunora Gallery</h1>
            <p class="mb-3">Panel Administrasi</p>
            <div class="alert alert-info border-0 mb-4" style="background: #e3f2fd; border: 1px solid #bbdefb;">
                <i class="fas fa-hand-wave me-2"></i><strong>Selamat Datang!</strong><br>
                <small>Silakan masuk untuk mengakses panel admin</small>
            </div>
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
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Masukkan email Anda">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label fw-bold"><i class="fas fa-lock me-2"></i>Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required placeholder="Masukkan password Anda">
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
                <button type="submit" class="btn btn-primary">
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