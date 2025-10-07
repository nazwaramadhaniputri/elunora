<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Elunora School</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/elunora-theme.css') }}">
    <style>
        :root {
            --guest-primary: #1e3a8a; /* deep blue */
            --guest-accent: #0f172a;  /* very dark blue */
        }
        body {
            background: linear-gradient(rgba(0,0,0,.35), rgba(0,0,0,.35)), url('{{ asset('img/login.jpg') }}') center/cover no-repeat;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card-reg {
            background: rgba(255,255,255,.95);
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,.1);
            width: 100%;
            max-width: 450px; /* match admin */
            min-height: 500px; /* match admin */
            overflow: hidden;
            backdrop-filter: blur(8px);
        }
        .card-header {
            background: var(--guest-primary);
            color: #fff;
            padding: 2.5rem;
            text-align: center;
        }
        .card-header h1 {
            font-size: 1.8rem; /* match admin heading size */
            font-weight: 800;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
        }
        .card-body { padding: 1.5rem; }
        .form-control {
            background: #fff;
            border: 1px solid #dee2e6;
            border-radius: 12px;
            padding: 1rem;
            font-size: 1rem;
            color: #495057;
            transition: all .2s ease;
        }
        .form-control:focus {
            border-color: var(--guest-primary);
            box-shadow: 0 0 0 .2rem rgba(30, 58, 138, 0.25);
        }
        .btn-register {
            background-color: var(--guest-primary);
            border: none;
            border-radius: 12px;
            padding: .875rem 1.25rem; /* not too tall */
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: .3px;
            color: #fff;
            width: 100%;
            box-shadow: 0 4px 15px rgba(30, 58, 138, 0.3);
        }
        /* ensure inside this page, primary buttons are solid guest blue */
        .card-reg .btn-primary { background-color: var(--guest-primary) !important; border-color: var(--guest-primary) !important; }
        .btn-register:hover { filter: brightness(0.97); }
    </style>
</head>
<body>
    <div class="card-reg">
        <div class="card-header">
            <h1><img src="{{ asset('img/logo.png') }}" alt="Elunora" style="height:55px;"> Elunora School </h1>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif
            <form method="POST" action="{{ route('register.submit') }}">
                @csrf
                <input type="hidden" name="redirect" value="{{ request('redirect') }}" />
                <div class="mb-3">
                    <label class="form-label fw-semibold"><i class="fas fa-user me-2"></i>Nama</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus placeholder="Nama lengkap">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold"><i class="fas fa-envelope me-2"></i>Email</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="email@domain.com">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold"><i class="fas fa-lock me-2"></i>Password</label>
                    <input type="password" class="form-control" name="password" required placeholder="Minimal 6 karakter">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold"><i class="fas fa-lock me-2"></i>Konfirmasi Password</label>
                    <input type="password" class="form-control" name="password_confirmation" required placeholder="Ulangi password">
                </div>
                <button type="submit" class="btn btn-primary w-100 btn-register">Daftar</button>
            </form>
            <div class="mt-3">
                <div class="d-flex flex-column flex-sm-row gap-2 justify-content-center">
                    <a href="{{ route('login') }}" class="btn btn-outline-primary">
                        <i class="fas fa-sign-in-alt me-1"></i> Masuk
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-home me-1"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
