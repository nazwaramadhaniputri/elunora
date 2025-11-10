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
    <!-- Animations CSS -->
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
    <!-- Background Pattern CSS -->
    <link rel="stylesheet" href="{{ asset('css/background-pattern.css') }}">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--elunora-dark);
            background: var(--elunora-light);
            min-height: 100vh;
        }
        /* Global hero icon float animation (applies site-wide) */
        .hero-icon { animation: heroFloat 3.2s ease-in-out infinite; will-change: transform; }
        @keyframes heroFloat { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-14px); } }
        /* Make hero larger on non-home pages */
        .not-home .hero-section { min-height: 58vh; padding-top: 120px; padding-bottom: 70px; }

        /* Navbar CTA pill */
        .nav-cta {
            background: rgba(30,58,138,0.08) !important; /* light brand tint */
            border: 1px solid rgba(30,58,138,0.22) !important;
            color: var(--elunora-primary) !important;
            border-radius: 999px !important;
            box-shadow: 0 1px 2px rgba(2, 6, 23, 0.04);
        }
        .nav-cta:hover { background: rgba(30,58,138,0.12) !important; }
        
        .navbar {
            background: #ffffff !important;
            box-shadow: 0 2px 10px rgba(15, 23, 42, 0.06);
            padding: 0.8rem 0;
            transition: all 0.3s ease;
            border-bottom: none !important; /* remove bottom line */
        }
        
        .navbar.scrolled {
            padding: 0.6rem 0;
            background: #ffffff !important;
            box-shadow: 0 4px 16px rgba(15, 23, 42, 0.08);
        }
        
        .navbar-brand,
        nav.navbar.elunora-navbar .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--elunora-primary) !important; /* navy/brand blue */
            display: flex;
            align-items: center;
        }
        .navbar-brand .brand-text { color: var(--elunora-primary) !important; font-weight: 800; }
        
        .navbar-brand img {
            height: 35px;
            width: auto;
            margin-right: 10px;
        }
        
        /* Stronger specificity to beat any theme overrides */
        .elunora-navbar .navbar-nav .nav-link,
        .navbar.navbar-light .navbar-nav .nav-link,
        .navbar .nav-link {
            color: var(--elunora-primary) !important; /* navy text */
            font-weight: 700;
            padding: 0.5rem 1.0rem !important;
            margin: 0 0.2rem;
            border-radius: 999px;
            transition: background-color 0.2s ease, color 0.2s ease;
            position: relative;
            overflow: hidden;
        }
        
        /* Removed ::after pseudo-elements that created underlines */
        
        .elunora-navbar .navbar-nav .nav-link:hover,
        .navbar.navbar-light .navbar-nav .nav-link:hover,
        .navbar .nav-link:hover {
            color: var(--elunora-primary) !important;
            background-color: rgba(30,58,138,0.08) !important; /* light brand tint */
            border: none !important;
            text-decoration: none !important;
        }
        
        .elunora-navbar .navbar-nav .nav-link.active,
        .navbar.navbar-light .navbar-nav .nav-link.active,
        .navbar .nav-link.active {
            color: var(--elunora-primary) !important;
            background-color: rgba(30,58,138,0.14) !important; /* brand chip */
            font-weight: 800;
            border: none !important;
            text-decoration: none !important;
        }

        /* Dropdown menu readability on light navbar */
        .navbar .dropdown-menu { border-radius: 12px; border: 1px solid #e5e7eb; }
        .navbar .dropdown-item { color: #0f172a; }
        .navbar .dropdown-item:hover { background-color: #f1f5f9; color: #0f172a; }
        
        .hero-section {
            /* Stronger two-stop gradient with subtle highlights for clear contrast */
            background-image:
                radial-gradient(900px 420px at 80% 30%, rgba(255,255,255,0.05), rgba(255,255,255,0) 60%),
                linear-gradient(110deg, #0a1f4a 0%, #183e8a 55%, #103885 100%) !important;
            background-color: #0a1f4a !important;
            background-repeat: no-repeat !important;
            background-size: cover !important;
            color: white;
            padding: 6rem 0 4rem;
            text-align: center; /* center by default */
            position: relative;
            overflow: hidden;
            margin-top: 0; /* no overlap to avoid seam */
            padding-top: 96px; /* compensate for navbar height */
        }
        /* Ensure inner nodes have no background that creates a visible rectangle */
        .hero-section > .container,
        .hero-section .container,
        .hero-section .row,
        .hero-section [class^="col-"] {
            background: transparent !important;
            box-shadow: none !important;
        }
        .hero-section .card,
        .hero-section .content-box,
        .hero-section .text-box,
        .hero-section .news-card {
            background: transparent !important;
            border-color: transparent !important;
            box-shadow: none !important;
        }

        /* Outline primary tuned to brand navy */
        .btn-outline-primary { color: var(--elunora-primary) !important; border-color: var(--elunora-primary) !important; }
        .btn-outline-primary:hover { background: var(--elunora-primary) !important; color: #fff !important; }
        .btn-outline-primary i { color: inherit !important; }

        /* Translucent pill textbox for hero copy */
        .hero-textbox {
            display: inline-block;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.14);
            border-radius: 20px;
            padding: 0.75rem 1.0rem;
            backdrop-filter: blur(2px);
        }
        
        /* Overlay pola hero dikelola oleh background-pattern.css */
        
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
        /* Ensure Bootstrap close button looks and works correctly */
        .alert .btn-close {
            float: right;
            margin-left: 1rem;
            box-shadow: none !important;
            outline: none !important;
            border: 0 !important;
            width: 1em;
            height: 1em;
            opacity: 0.7;
            cursor: pointer;
        }
        .alert .btn-close:hover { opacity: 1; }
        .alert { position: relative; }
        
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

        /* Global reveal-on-scroll animation (slower & smoother) */
        [data-reveal] { opacity: 0; transform: translateY(26px); transition: opacity 1.1s cubic-bezier(.22,.61,.36,1), transform 1.1s cubic-bezier(.22,.61,.36,1); will-change: opacity, transform; }
        [data-reveal].is-visible { opacity: 1; transform: none; }

        /* Hero specific slide-in animations */
        .slide-in-left-start { opacity: 0; transform: translateX(-48px); }
        .slide-in-left-animate { opacity: 1 !important; transform: translateX(0) !important; transition: all 1.2s cubic-bezier(.22,.61,.36,1); will-change: opacity, transform; }
        .slide-in-right-start { opacity: 0; transform: translateX(48px); }
        .slide-in-right-animate { opacity: 1 !important; transform: translateX(0) !important; transition: all 1.2s cubic-bezier(.22,.61,.36,1); will-change: opacity, transform; }
        /* Blue shadow glow under images in hero */
        .hero-img-shadow { filter: drop-shadow(0 14px 24px rgba(30,58,138,0.35)); }
    </style>
    @yield('styles')
    <script>
        window.csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    </script>
</head>
<body class="{{ request()->routeIs('home') ? 'home' : 'not-home' }}">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top elunora-navbar">
        <div class="container-fluid px-3 px-lg-4">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('img/logo.png') }}" alt="Elunora School"> <span class="brand-text">Elunora School</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link text-dark {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark {{ request()->routeIs('berita*') ? 'active' : '' }}" href="{{ route('berita') }}">Berita</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark {{ request()->routeIs('galeri*') ? 'active' : '' }}" href="{{ route('galeri') }}">Galeri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark {{ request()->routeIs('agenda*') ? 'active' : '' }}" href="{{ route('agenda') }}">Agenda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark {{ request()->routeIs('profil') ? 'active' : '' }}" href="{{ route('profil') }}">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark {{ request()->routeIs('kontak') ? 'active' : '' }}" href="{{ route('kontak') }}">Kontak</a>
                    </li>
                    @guest
                        <li class="nav-item ms-lg-2">
                            <a class="btn btn-outline-primary btn-sm nav-cta" href="{{ route('login', ['redirect' => request()->fullUrl()]) }}">
                                <i class="fas fa-sign-in-alt me-1"></i> Masuk
                            </a>
                        </li>
                        <li class="nav-item ms-1 mt-2 mt-lg-0">
                            <a class="btn btn-outline-primary btn-sm nav-cta" href="{{ route('register', ['redirect' => request()->fullUrl()]) }}">
                                <i class="fas fa-user-plus me-1"></i> Daftar
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown ms-lg-3">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="avatar rounded-circle bg-light text-primary d-inline-flex align-items-center justify-content-center" style="width:32px;height:32px;"><i class="fas fa-user"></i></span>
                                <span class="text-dark">{{ auth()->user()->name }}</span>
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
        @yield('hero')
    @else
        <div class="hero-section hero-default">
            <div class="container">
                <h1 class="display-5 fw-bold mb-2">@yield('title', 'Elunora School')</h1>
                <p class="mb-0 text-white-50">Selamat datang di Elunora School</p>
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

            // Global reveal on scroll: auto-tag common blocks
            const candidates = document.querySelectorAll('.card, .news-card, .modern-card, section, .gallery-item, .content-box, .text-box');
            candidates.forEach(el => { el.setAttribute('data-reveal', ''); });
            const io = new IntersectionObserver((entries) => {
                entries.forEach(en => {
                    if (en.isIntersecting) { en.target.classList.add('is-visible'); io.unobserve(en.target); }
                });
            }, { threshold: 0.15, rootMargin: '0px 0px -10% 0px' });
            document.querySelectorAll('[data-reveal]').forEach(el => io.observe(el));

            // Make hero content visible on first load (entrance animation)
            const hero = document.querySelector('.hero-section');
            if (hero) {
                hero.setAttribute('data-reveal', '');
                // Keep subtle image shadow only
                const imgInHero = hero.querySelector('img');
                if (imgInHero) imgInHero.classList.add('hero-img-shadow');
                // Slight delay to allow paint before transition
                setTimeout(() => hero.classList.add('is-visible'), 50);
            }

            // Global search filter: any input.js-page-search will filter items matching data-target selector
            document.querySelectorAll('input.js-page-search').forEach(inp => {
                const targetSel = inp.getAttribute('data-target') || '';
                const container = inp.closest('[data-search-scope]') || document;
                const doFilter = () => {
                    const q = (inp.value || '').toLowerCase();
                    const items = container.querySelectorAll(targetSel);
                    items.forEach(it => {
                        const text = it.textContent.toLowerCase();
                        it.style.display = (text.indexOf(q) !== -1) ? '' : 'none';
                    });
                };
                inp.addEventListener('input', doFilter);
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @yield('scripts')

    
</body>
</html>