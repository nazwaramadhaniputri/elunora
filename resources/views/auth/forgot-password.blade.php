<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Elunora School</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --guest-primary:#1e3a8a; --guest-accent:#2563eb; }
        body{
            background: linear-gradient(rgba(0,0,0,.35), rgba(0,0,0,.35)), url('{{ asset('img/login.jpg') }}') center/cover no-repeat;
            min-height:100vh; display:flex; align-items:center; justify-content:center; padding:20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card-wrap{ background:rgba(255,255,255,.95); border-radius:15px; box-shadow:0 15px 35px rgba(0,0,0,.1); width:100%; max-width:460px; overflow:hidden; backdrop-filter: blur(8px); }
        .card-header-grad{ background:linear-gradient(135deg, var(--guest-primary), var(--guest-accent)); color:#fff; padding:2rem; text-align:center; }
        .card-header-grad h1{ font-size:1.6rem; font-weight:800; margin:0; display:flex; gap:.5rem; align-items:center; justify-content:center; }
        .card-body-wrap{ padding:1.5rem; }
        .form-control{ background:#fff; border:1px solid #dee2e6; border-radius:12px; padding:1rem; font-size:1rem; color:#495057; transition:all .2s ease; }
        .form-control:focus{ border-color:var(--guest-primary); box-shadow:0 0 0 .2rem rgba(30,58,138,.25); }
        .btn-submit{ background:linear-gradient(135deg, var(--guest-primary), var(--guest-accent)); border:none; border-radius:12px; padding:1rem; font-weight:700; color:#fff; width:100%; box-shadow:0 4px 15px rgba(30,58,138,.3); }
        .btn-submit:hover{ filter:brightness(.97); }
        .small a{ text-decoration:none; }
        .small a:hover{ text-decoration:underline; }
    </style>
</head>
<body>
    <div class="card-wrap">
        <div class="card-header-grad">
            <h1><img src="{{ asset('img/logo.png') }}" alt="Elunora" style="height:40px;"> Elunora School</h1>
        </div>
        <div class="card-body-wrap">
            <h5 class="mb-3 fw-bold">Lupa Password</h5>
            <p class="text-muted mb-3">Masukkan username Anda untuk menerima link reset password.</p>

            @if(session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') }}" required autofocus>
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-submit">Kirim Link Reset Password</button>
            </form>
            <div class="mt-3 small d-flex justify-content-between">
                <a href="{{ route('login') }}">Kembali ke Login</a>
                <a href="{{ route('home') }}">Beranda</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
