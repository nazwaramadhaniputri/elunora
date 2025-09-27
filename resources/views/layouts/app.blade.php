<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Elunora School</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Global Spacing CSS -->
    <link rel="stylesheet" href="{{ asset('css/global-spacing.css') }}">
    <!-- Elunora Theme CSS -->
    <link rel="stylesheet" href="{{ asset('css/elunora-theme.css') }}">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--elunora-dark);
            background: var(--elunora-light);
            min-height: 100vh;
        }
        
        .navbar {
            background: var(--elunora-primary) !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 0.8rem 0;
            transition: all 0.3s ease;
        }
        
        .navbar.scrolled {
            padding: 0.5rem 0;
            background: rgba(30, 58, 138, 0.98) !important;
            backdrop-filter: blur(10px);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
            display: flex;
            align-items: center;
        }
        
        .navbar-brand img {
            height: 35px;
            width: auto;
            margin-right: 10px;
        }
        
        .navbar .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            padding: 0.5rem 1.2rem !important;
            margin: 0 0.2rem;
            border-radius: 25px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        /* Removed ::after pseudo-elements that created underlines */
        
        .navbar .nav-link:hover {
            color: white !important;
            background-color: rgba(255, 255, 255, 0.15) !important;
            border: none !important;
            text-decoration: none !important;
        }
        
        .navbar .nav-link.active {
            color: white !important;
            background-color: rgba(255, 255, 255, 0.25) !important;
            font-weight: 600;
            border: none !important;
            text-decoration: none !important;
        }
        
        .hero-section {
            background: var(--elunora-primary);
            color: white;
            padding: 6rem 0 4rem;
            text-align: center;
            position: relative;
            overflow: hidden;
            margin-top: -76px;
            padding-top: 120px;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="%23000" opacity="0.02"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>') repeat;
        }
        
        .card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
            border: none;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.1);
        }
        
        .card-header {
            background: #f8f9fa;
            color: #495057;
            border-bottom: 1px solid #dee2e6;
            padding: 1.5rem;
            font-weight: 600;
        }
        
        .btn {
            border-radius: 25px;
            padding: 0.6rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
        }
        
        .btn-primary {
            background: var(--elunora-primary);
            border: 1px solid var(--elunora-primary);
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2);
        }
        
        .btn-primary:hover {
            background: var(--elunora-primary-dark);
            border-color: var(--elunora-primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(29, 78, 216, 0.3);
        }
        
        .btn-success {
            background: var(--elunora-success);
            border: 1px solid var(--elunora-success);
            box-shadow: 0 2px 4px rgba(5, 150, 105, 0.2);
            color: #fff;
        }
        
        .btn-info {
            background: var(--elunora-info);
            border: 1px solid var(--elunora-info);
            box-shadow: 0 2px 4px rgba(14, 165, 233, 0.2);
            color: #fff;
        }
        
        .btn-warning {
            background: var(--elunora-warning);
            border: 1px solid var(--elunora-warning);
            box-shadow: 0 2px 4px rgba(245, 158, 11, 0.2);
            color: #fff;
        }
        
        .btn-danger {
            background: var(--elunora-danger);
            border: 1px solid var(--elunora-danger);
            box-shadow: 0 2px 4px rgba(220, 53, 69, 0.3);
            color: #fff;
        }
        
        .alert {
            border: none;
            border-radius: 10px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .table {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 15px rgba(0,0,0,0.05);
        }
        
        .table thead th {
            background: var(--success-color);
            color: white;
            border: none;
            font-weight: 600;
            padding: 1rem;
        }
        
        .table tbody tr {
            transition: all 0.2s ease;
        }
        
        .table tbody tr:hover {
            background-color: var(--light-bg);
            transform: scale(1.01);
        }
        
        footer {
            background: #343a40;
            color: white;
            padding: 3rem 0 2rem;
            margin-top: 4rem;
            border-top: 3px solid var(--elunora-primary);
        }
        
        footer h5 {
            color: #ffffff;
            margin-bottom: 1rem;
            font-weight: 600;
        }
        
        footer a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        footer a:hover {
            color: #ffffff;
            text-decoration: underline;
        }
        
        .fade-in {
            animation: fadeIn 0.6s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 15px;
            margin-bottom: 2rem;
        }
        
        .gallery-item img {
            transition: transform 0.3s ease;
        }
        
        .gallery-item:hover img {
            transform: scale(1.05);
        }
        
        .news-card {
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 2rem;
            transition: all 0.3s ease;
        }
        
        .news-card:hover {
            transform: translateY(-5px);
        }
        
        .badge {
            border-radius: 20px;
            padding: 0.5rem 1rem;
            font-weight: 500;
        }
        
        /* Text Box Styling */
        .text-box, .description-card, .card, .content-box {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .text-box p, .description-card p, .card p, .content-box p {
            margin-bottom: 1.5rem;
            line-height: 1.8;
        }
        
        .text-box img, .description-card img, .card img, .content-box img {
            margin: 2rem 0;
            border-radius: 10px;
        }
        
        /* Gallery Photo Grid Spacing */
        .gallery-photos .col-md-4, .gallery-photos .col-lg-3 {
            margin-bottom: 2rem;
        }
        
        .gallery-photos img {
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        
        .gallery-photos img:hover {
            transform: scale(1.05);
        }
    </style>
    @yield('styles')
    <script>
        window.csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    </script>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top elunora-navbar">
        <div class="container-fluid px-3 px-lg-4">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('img/logo.png') }}" alt="Elunora School"> Elunora School
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('berita*') ? 'active' : '' }}" href="{{ route('berita') }}">Berita</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('galeri*') ? 'active' : '' }}" href="{{ route('galeri') }}">Galeri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('agenda*') ? 'active' : '' }}" href="{{ route('agenda') }}">Agenda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('profil') ? 'active' : '' }}" href="{{ route('profil') }}">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('kontak') ? 'active' : '' }}" href="{{ route('kontak') }}">Kontak</a>
                    </li>
                    @guest
                        <li class="nav-item ms-lg-2">
                            <a class="btn btn-light btn-sm" href="{{ route('login', ['redirect' => request()->fullUrl()]) }}">
                                <i class="fas fa-sign-in-alt me-1"></i> Masuk
                            </a>
                        </li>
                        <li class="nav-item ms-1 mt-2 mt-lg-0">
                            <a class="btn btn-light btn-sm" href="{{ route('register', ['redirect' => request()->fullUrl()]) }}">
                                <i class="fas fa-user-plus me-1"></i> Daftar
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown ms-lg-3">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="avatar rounded-circle bg-light text-primary d-inline-flex align-items-center justify-content-center" style="width:32px;height:32px;"><i class="fas fa-user"></i></span>
                                <span class="text-white">{{ auth()->user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li class="dropdown-header small text-muted px-3">Masuk sebagai<br><strong>{{ auth()->user()->email }}</strong></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="px-3 py-1">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger w-100 btn-sm">
                                            <i class="fas fa-sign-out-alt me-1"></i> Keluar
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section (optional) -->
    @hasSection('hero')
        <div class="hero-section">
            <div class="container">
                @yield('hero')
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <div class="container my-4">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Elunora School</h5>
                    <p>School of Art yang melahirkan lulusan kreatif dan berbakat.</p>
                </div>
                <div class="col-md-4">
                    <h5>Link Cepat</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}" class="text-white">Beranda</a></li>
                        <li><a href="{{ route('berita') }}" class="text-white">Berita</a></li>
                        <li><a href="{{ route('galeri') }}" class="text-white">Galeri</a></li>
                        <li><a href="{{ route('agenda') }}" class="text-white">Agenda</a></li>
                        <li><a href="{{ route('profil') }}" class="text-white">Profile</a></li>
                        <li><a href="{{ route('kontak') }}" class="text-white">Kontak</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Kontak</h5>
                    <address>
                        <p><i class="fas fa-map-marker-alt me-2"></i> Jl. Magnolia No. 17, The Aurora Residence, Kota Lavendra</p>
                        <p><i class="fas fa-phone me-2"></i> (021) 7788-9900</p>
                        <p><i class="fas fa-envelope me-2"></i> info@elunoraschool.sch.id</p>
                    </address>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12 text-center">
                    <p class="mb-0">&copy; {{ date('Y') }} Elunora School. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Add smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @yield('scripts')

    @if(!request()->routeIs('ai'))
    <!-- Floating AI Button -->
    <a href="{{ route('ai') }}" class="ai-fab" title="Tanya Asisten AI" aria-label="Tanya Asisten AI">
        <i class="fas fa-robot"></i>
    </a>
    <style>
        .ai-fab {
            position: fixed;
            right: 20px;
            bottom: 20px;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--elunora-primary), var(--elunora-primary-dark));
            color: #fff !important;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 25px rgba(0,0,0,0.25);
            z-index: 1050;
            transition: transform .15s ease, box-shadow .2s ease, opacity .2s ease;
            text-decoration: none;
        }
        .ai-fab i { font-size: 1.25rem; }
        .ai-fab:hover { transform: translateY(-2px); box-shadow: 0 14px 32px rgba(0,0,0,0.3); }
        @media (max-width: 576px) { .ai-fab { right: 14px; bottom: 14px; width: 52px; height: 52px; } }
    </style>
    @endif
</body>
</html>