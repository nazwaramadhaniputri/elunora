<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Elunora School - Gallery Management System</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="{{ asset('css/elunora-theme.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="welcome-container">
            <div class="hero-section welcome-hero">
                <div class="container">
                    <div class="row min-vh-100 align-items-center">
                        <div class="col-12">
                            <div class="text-center">
                                <div class="welcome-brand mb-5">
                                    <img src="{{ asset('img/logo.png') }}" alt="Elunora School" class="welcome-logo mb-3" style="height: 80px; width: auto;">
                                    <h1 class="welcome-title">ELUNORA SCHOOL</h1>
                                    <p class="welcome-subtitle">Gallery Management System</p>
                                </div>
                                
                                <div class="welcome-description mb-5">
                                    <p class="lead text-white">Sistem manajemen galeri foto untuk dokumentasi kegiatan sekolah</p>
                                </div>

                                <div class="welcome-actions">
                                    @if (Route::has('login'))
                                        @auth
                                            <a href="{{ url('/admin/dashboard') }}" class="btn-modern primary me-3">
                                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard Admin
                                            </a>
                                            <a href="{{ url('/') }}" class="btn-modern secondary">
                                                <i class="fas fa-home me-2"></i>Beranda
                                            </a>
                                        @else
                                            <a href="{{ route('admin.login') }}" class="btn-modern primary me-3">
                                                <i class="fas fa-sign-in-alt me-2"></i>Login Admin
                                            </a>
                                            <a href="{{ url('/') }}" class="btn-modern secondary">
                                                <i class="fas fa-images me-2"></i>Lihat Galeri
                                            </a>
                                    @endif
                                </div>
                                
                                <div class="welcome-features mt-5">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="feature-item">
                                                <i class="fas fa-images feature-icon"></i>
                                                <h6 class="text-white">Galeri Foto</h6>
                                                <p class="text-white-50 small">Dokumentasi kegiatan sekolah</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="feature-item">
                                                <i class="fas fa-newspaper feature-icon"></i>
                                                <h6 class="text-white">Berita Sekolah</h6>
                                                <p class="text-white-50 small">Informasi terkini sekolah</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="feature-item">
                                                <i class="fas fa-building feature-icon"></i>
                                                <h6 class="text-white">Fasilitas</h6>
                                                <p class="text-white-50 small">Sarana prasarana sekolah</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
