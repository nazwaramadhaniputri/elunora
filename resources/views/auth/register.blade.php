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
        body { background: linear-gradient(rgba(0,0,0,.35), rgba(0,0,0,.35)), url('{{ asset('img/login.jpg') }}') center/cover no-repeat; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .card-reg { background: rgba(255,255,255,.95); border-radius: 15px; box-shadow: 0 15px 35px rgba(0,0,0,.1); width: 100%; max-width: 520px; overflow: hidden; }
        .card-header { background: linear-gradient(135deg, var(--elunora-primary), var(--elunora-primary-dark)); color: #fff; padding: 1.75rem; text-align: center; }
        .card-header h1 { font-size: 1.5rem; font-weight: 800; margin: 0; display: flex; align-items: center; justify-content: center; gap: .5rem; }
        .card-body { padding: 1.5rem; }
        .form-control { background: #fff; border: 1px solid #dee2e6; border-radius: 12px; padding: .9rem 1rem; }
        .form-control:focus { border-color: var(--elunora-primary); box-shadow: 0 0 0 .2rem rgba(30, 58, 138, 0.25); }
        .btn-register { background: linear-gradient(135deg, var(--elunora-primary), var(--elunora-primary-dark)); border: none; border-radius: 12px; padding: .9rem 1rem; font-weight: 700; letter-spacing: .3px; }
        .btn-register:hover { opacity: .95; }
    </style>
</head>
<body>
    <div class="card-reg">
        <div class="card-header">
            <h1><img src="{{ asset('img/logo.png') }}" alt="Elunora" style="height:40px;"> Daftar</h1>
            <div class="small mt-1">Buat akun untuk berkomentar</div>
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
                    <a href="{{ route('login', ['redirect' => request('redirect')]) }}" class="btn btn-outline-primary">
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
