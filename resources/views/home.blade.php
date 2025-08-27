@extends('layouts.app')

@section('title', 'Beranda')

@section('hero')
<div class="hero-modern text-center">
    <div class="hero-badge">
        <i class="fas fa-graduation-cap me-2"></i>
        <span>SMK Unggulan</span>
    </div>
    <h1 class="hero-title">Selamat Datang di Elunora School</h1>
    <p class="hero-subtitle">Sekolah Menengah Kejuruan unggulan yang melahirkan lulusan profesional, kreatif, dan siap bersaing di dunia kerja nasional maupun internasional.</p>
    <div class="hero-actions">
        <a href="javascript:void(0);" onclick="scrollToSection('galeri-section')" class="btn-hero primary">
            <i class="fas fa-images me-2"></i>Lihat Galeri
        </a>
        <a href="javascript:void(0);" onclick="scrollToSection('berita-section')" class="btn-hero secondary">
            <i class="fas fa-newspaper me-2"></i>Baca Berita
        </a>
    </div>
</div>

<style>
.hero-modern {
    padding: 4rem 2rem;
    position: relative;
}

.hero-badge {
    display: inline-flex;
    align-items: center;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 50px;
    font-weight: 600;
    margin-bottom: 2rem;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.hero-title {
    font-size: 3.5rem;
    font-weight: 800;
    color: white;
    margin-bottom: 1.5rem;
    text-shadow: 0 2px 20px rgba(0,0,0,0.3);
    line-height: 1.2;
}

.hero-subtitle {
    font-size: 1.25rem;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 3rem;
    max-width: 800px;
    margin-left: auto;
    margin-right: auto;
    line-height: 1.6;
}

.hero-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-hero {
    display: inline-flex;
    align-items: center;
    padding: 1rem 2rem;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 1.1rem;
    border: 2px solid transparent;
}

.btn-hero.primary {
    background: white;
    color: #007bff;
    box-shadow: 0 10px 30px rgba(255,255,255,0.3);
}

.btn-hero.primary:hover {
    background: #f8f9fa;
    color: #0056b3;
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(255,255,255,0.4);
}

.btn-hero.secondary {
    background: white;
    color: #007bff;
    border-color: white;
    box-shadow: 0 10px 30px rgba(255,255,255,0.3);
}

.btn-hero.secondary:hover {
    background: #f8f9fa;
    color: #0056b3;
    border-color: #f8f9fa;
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(255,255,255,0.4);
}

@media (max-width: 768px) {
    .hero-modern {
        padding: 3rem 1rem;
    }
    
    .hero-title {
        font-size: 2.5rem;
    }
    
    .hero-subtitle {
        font-size: 1.1rem;
        margin-bottom: 2rem;
    }
    
    .hero-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .btn-hero {
        padding: 0.875rem 1.5rem;
        font-size: 1rem;
        width: 100%;
        max-width: 280px;
    }
}

@media (max-width: 576px) {
    .hero-title {
        font-size: 2rem;
    }
    
    .hero-subtitle {
        font-size: 1rem;
    }
}
</style>
@endsection

@section('content')
<!-- Berita Terbaru -->
<section id="berita-section" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold text-primary mb-3">
                <i class="fas fa-newspaper me-3"></i>Berita Terbaru
            </h2>
            <p class="lead text-muted">Informasi dan kegiatan terbaru dari sekolah kami</p>
        </div>
        
        <div class="row">
            @forelse($posts as $berita)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    @if($berita->gambar)
                    <img src="{{ asset($berita->gambar) }}" class="card-img-top" alt="{{ $berita->judul }}" style="height: 200px; object-fit: cover;">
                    @else
                    <img src="{{ asset('img/no-image.jpg') }}" class="card-img-top" alt="No Image" style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body">
                        <div class="badge bg-secondary mb-2">
                            <i class="fas fa-tag me-1"></i>{{ $berita->kategori->nama_kategori }}
                        </div>
                        <h5 class="card-title fw-bold">{{ $berita->judul }}</h5>
                        <p class="card-text text-muted">{{ Str::limit(strip_tags($berita->isi), 100) }}</p>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="fas fa-calendar-alt me-1"></i>{{ \Carbon\Carbon::parse($berita->created_at)->format('d M Y') }}
                            </small>
                            <a href="{{ route('berita.detail', $berita->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-arrow-right me-1"></i>Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p>Belum ada berita yang dipublikasikan.</p>
            </div>
            @endforelse
        </div>
        
        <div class="text-center mt-4">
            <a href="{{ route('berita') }}" class="btn btn-primary">Lihat Semua Berita</a>
        </div>
    </div>
</section>

<!-- Galeri Foto -->
<section id="galeri-section" class="py-5" style="background: #f8f9fa;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold text-primary mb-3">
                <i class="fas fa-images me-3"></i>Galeri Foto
            </h2>
            <p class="lead text-muted">Koleksi foto kegiatan dan acara sekolah</p>
        </div>
        
        <div class="row">
            @forelse($galeris as $galeri)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    @if($galeri->fotos->isNotEmpty())
                    <img src="/{{ $galeri->fotos->first()->file }}" class="card-img-top" alt="{{ $galeri->fotos->first()->judul }}" style="height: 200px; object-fit: cover;">
                    @else
                    <img src="/img/no-image.jpg" class="card-img-top" alt="No Image" style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title fw-bold">{{ $galeri->judul ?? ($galeri->post ? $galeri->post->judul : 'Galeri Tanpa Judul') }}</h5>
                        <p class="card-text text-muted">
                            <i class="fas fa-camera me-1"></i>{{ $galeri->fotos->count() }} foto
                        </p>
                    </div>
                    <div class="card-footer bg-transparent border-0 text-end">
                        <a href="{{ route('galeri.detail', $galeri->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-eye me-1"></i>Lihat Galeri
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p>Belum ada galeri yang dipublikasikan.</p>
            </div>
            @endforelse
        </div>
        
        <div class="text-center mt-4">
            <a href="{{ route('galeri') }}" class="btn btn-primary">Lihat Semua Galeri</a>
        </div>
    </div>
</section>

<!-- Profil Sekolah -->
@if($profile)
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <img src="/img/school-profile.jpg" alt="Profil Sekolah" class="img-fluid rounded shadow">
            </div>
            <div class="col-md-6">
                <div class="section-title">
                    <h2>{{ $profile->nama_sekolah }}</h2>
                </div>
                <div class="profile-excerpt">
                    {{ Str::limit(strip_tags($profile->deskripsi), 300) }}
                </div>
                <div class="mt-4">
                    <a href="{{ route('profil') }}" class="btn btn-primary">Baca Selengkapnya</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
@endsection

@section('scripts')
<script>
function scrollToSection(sectionId) {
    console.log('Scrolling to:', sectionId);
    var target = document.getElementById(sectionId);
    if (target) {
        target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    } else {
        console.log('Target not found:', sectionId);
    }
}

// Alternative jQuery version as backup
$(document).ready(function() {
    console.log('jQuery loaded and ready');
    
    // Smooth scrolling for anchor links
    $('a[href^="#"]').on('click', function(e) {
        e.preventDefault();
        
        var target = $(this.getAttribute('href'));
        if (target.length) {
            $('html, body').animate({
                scrollTop: target.offset().top - 80
            }, 800);
        }
    });
    
    // Test button clicks
    $('.btn-light').on('click', function() {
        console.log('Button clicked:', this);
    });
});
</script>
@endsection