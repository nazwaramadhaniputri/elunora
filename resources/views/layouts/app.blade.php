<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Elunora Gallery</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Global Spacing CSS -->
    <link rel="stylesheet" href="{{ asset('css/global-spacing.css') }}">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #007bff;
            --secondary-color: #6c757d;
            --accent-color: #dc3545;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --light-bg: #f8f9fa;
            --dark-text: #495057;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--dark-text);
            background: #f8f9fa;
            min-height: 100vh;
            scroll-behavior: smooth;
        }
        
        .navbar {
            background: #007bff !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
            backdrop-filter: blur(10px);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
        }
        
        .navbar-dark .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
            padding: 0.5rem 1rem;
            margin: 0 0.2rem;
            border-radius: 25px;
            transition: all 0.3s ease;
        }
        
        .navbar-dark .navbar-nav .nav-link:hover {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }
        
        .navbar-dark .navbar-nav .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.2);
            font-weight: 600;
        }
        
        .hero-section {
            background: #007bff;
            color: white;
            padding: 4rem 0;
            text-align: center;
            position: relative;
            overflow: hidden;
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
            background: #007bff;
            border: 1px solid #007bff;
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 123, 255, 0.2);
        }
        
        .btn-primary:hover {
            background: #0056b3;
            border-color: #0056b3;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 86, 179, 0.3);
        }
        
        .btn-success {
            background: #28a745;
            border: 1px solid #28a745;
            box-shadow: 0 2px 4px rgba(40, 167, 69, 0.2);
        }
        
        .btn-info {
            background: #17a2b8;
            border: 1px solid #17a2b8;
            box-shadow: 0 2px 4px rgba(23, 162, 184, 0.2);
        }
        
        .btn-warning {
            background: #ffc107;
            border: 1px solid #ffc107;
            box-shadow: 0 2px 4px rgba(255, 193, 7, 0.2);
        }
        
        .btn-danger {
            background: var(--accent-color);
            border: 1px solid var(--accent-color);
            box-shadow: 0 2px 4px rgba(220, 53, 69, 0.3);
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
            background: #28a745;
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
            border-top: 3px solid #007bff;
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
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">Elunora Gallery</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
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
                        <a class="nav-link {{ request()->routeIs('profil') ? 'active' : '' }}" href="{{ route('profil') }}">Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('kontak') ? 'active' : '' }}" href="{{ route('kontak') }}">Kontak</a>
                    </li>
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
                    <p>Sekolah Menengah Kejuruan unggulan yang melahirkan lulusan profesional dan kreatif.</p>
                </div>
                <div class="col-md-4">
                    <h5>Link Cepat</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}" class="text-white">Beranda</a></li>
                        <li><a href="{{ route('berita') }}" class="text-white">Berita</a></li>
                        <li><a href="{{ route('galeri') }}" class="text-white">Galeri</a></li>
                        <li><a href="{{ route('profil') }}" class="text-white">Profil</a></li>
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
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @yield('scripts')
</body>
</html>