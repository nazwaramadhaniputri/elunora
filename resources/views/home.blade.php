@extends('layouts.app')

@section('title', 'Beranda')

@section('hero')
<!-- Modern Hero Section -->
<div class="hero-section position-relative">
    <div class="container">
        <div class="row align-items-center">
            <!-- Left: text -->
            <div class="col-lg-6" data-reveal>
                <h1 class="hero-title mb-4">Selamat Datang di Elunora School</h1>
                <p class="hero-subtitle mb-4">School of Art yang melahirkan lulusan kreatif, berbakat, dan siap bersaing di dunia seni nasional maupun internasional.</p>
                <div class="hero-actions d-flex justify-content-center flex-wrap gap-3">
                    <button type="button" class="btn btn-hero-glow" onclick="scrollToSection('galeri-section')">
                        <i class="fas fa-images me-2"></i>Lihat Galeri
                    </button>
                    <button type="button" class="btn btn-hero-glow" onclick="scrollToSection('berita-section')">
                        <i class="fas fa-newspaper me-2"></i>Baca Berita
                    </button>
                    <button type="button" class="btn btn-hero-glow" onclick="scrollToSection('agenda-section')">
                        <i class="fas fa-calendar me-2"></i>Lihat Agenda
                    </button>
                </div>
            </div>
            <!-- Right: image -->
            <div class="col-lg-6 d-none d-lg-block" data-reveal>
                <div class="hero-image-wrap ms-lg-4 position-relative">
                    <img src="{{ isset($profile) && ($profile->foto ?? null) ? asset($profile->foto) : asset('img/hero-school.jpg') }}" onerror="this.src='{{ asset('img/no-image.jpg') }}'" alt="Elunora School" class="img-fluid rounded-4 shadow-lg hero-image">
                    <div class="hero-image-overlay"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
/* Modern Hero Section (use global gradient from layout) */
.hero-section {
    /* do not set background here to allow layout gradient */
    padding: 6rem 0 4rem 0;
    position: relative;
    overflow: hidden;
    min-height: 80vh;
    display: flex;
    align-items: center;
    margin-top: 0;
    padding-top: 96px; /* align with navbar height */
}

/* Hero image */
.hero-image-wrap { position: relative; }
.hero-image { width: 100%; max-height: 350px; object-fit: cover; border-radius: 16px; box-shadow: 0 12px 30px rgba(0,0,0,.25); transition: none !important; transform: none !important; }
.hero-image-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 15%;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0));
    border-bottom-left-radius: 16px;
    border-bottom-right-radius: 16px;
    z-index: 1;
}

/* Ensure no unintended zoom on hover and overlay stays aligned */
.hero-image-wrap:hover .hero-image { transform: none !important; }
.hero-image-overlay { pointer-events: none; }

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1;
}

.hero-content {
    position: relative;
    z-index: 2;
}

.hero-title {
    font-size: 3.2rem;
    font-weight: 700;
    color: white;
    line-height: 1.2;
    margin-bottom: 1.5rem;
    text-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.hero-subtitle {
    font-size: 1.25rem;
    color: rgba(255, 255, 255, 0.9);
    line-height: 1.6;
    max-width: 620px;
    margin: 0;
}

/* Profil Sekolah Section */
.video-container {
    position: relative;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.video-container:hover {
    transform: translateY(-5px);
}

.play-button {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.play-button i {
    color: var(--elunora-primary);
    font-size: 2rem;
    margin-left: 5px;
}

.play-button:hover {
    background: white;
    transform: translate(-50%, -50%) scale(1.1);
}

/* Responsive Adjustments */
@media (max-width: 991.98px) {
    .hero-section {
        padding: 5rem 0;
        min-height: auto;
    }
    
    .hero-content h1, .hero-title {
        font-size: 2.5rem;
        margin-right: 2rem;
    }
    
    .hero-content .lead, .hero-subtitle {
        font-size: 1.1rem;
        margin-right: 2rem;
    }
    
    .hero-image-wrap {
        animation: float 3s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }
}

@media (max-width: 767.98px) {
    .hero-content h1, .hero-title {
        font-size: 2rem;
    }
    
    .hero-actions .btn {
        width: 100%;
        margin-bottom: 10px;
    }
    
    .hero-actions {
        flex-direction: column;
    }
}

/* Utility Classes */
.min-vh-80 {
    min-height: 80vh;
}

.rounded-4 {
    border-radius: 1rem !important;
}

.shadow {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
/* Grain overlay for hero background */
/* Remove per-page grain overlay to avoid any visible panel */
.hero-section::before { content: none !important; }

.hero-badge {
    display: inline-flex;
    align-items: center;
    background: rgba(255, 255, 255, 0.25) !important;
    color: white !important;
    padding: 0.7rem 1.5rem;
    border-radius: 50px;
    font-weight: 600;
    backdrop-filter: blur(15px);
    border: 2px solid rgba(255, 255, 255, 0.4) !important;
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
    text-decoration: none !important;
    font-size: 1rem;
    margin-bottom: 2rem;
}

.hero-badge:hover {
    background: rgba(255, 255, 255, 0.35) !important;
    color: white !important;
    text-decoration: none !important;
    transform: translateY(-2px);
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.2) !important;
}

.hero-icon {
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

.btn-hero-glow {
    background: white !important;
    color: #2563eb !important;
    border: none !important;
    padding: 0.75rem 1.5rem !important;
    border-radius: 50px !important;
    font-weight: 600 !important;
    transition: all 0.3s ease !important;
    box-shadow: 0 8px 25px rgba(255, 255, 255, 0.3), 0 0 20px rgba(255, 255, 255, 0.2) !important;
    position: relative;
    overflow: hidden;
}

.btn-hero-glow::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
    transition: left 0.5s;
}

.btn-hero-glow:hover::before {
    left: 100%;
}

.btn-hero-glow:hover {
    background: white !important;
    color: #2563eb !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 12px 35px rgba(255, 255, 255, 0.4), 0 0 30px rgba(255, 255, 255, 0.3) !important;
}

@media (max-width: 768px) {
    .hero-section {
        padding: 3rem 0;
    }
    
    .hero-actions {
        flex-direction: column !important;
        align-items: center !important;
    }
    
    .btn-hero {
        width: 200px !important;
    }
}

/* Hero Actions Layout - Single Row */
.hero-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

@media (max-width: 768px) {
    .hero-actions {
        flex-direction: column;
        align-items: center;
        gap: 0.75rem;
    }
    
    .btn-hero {
        width: 100%;
        max-width: 280px;
    }
}

/* Profile Section Styles */
.profile-image-container {
    position: relative;
    overflow: hidden;
    border-radius: 1rem;
}

.profile-image-container img {
    transition: transform 0.3s ease;
}

.profile-image-container:hover img {
    transform: scale(1.05);
}

.profile-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1e3a8a;
    line-height: 1.2;
}

.profile-excerpt {
    font-size: 1.1rem;
    line-height: 1.7;
    color: #64748b;
}

@media (max-width: 768px) {
    .profile-title {
        font-size: 2rem;
    }
    
    .profile-excerpt {
        font-size: 1rem;
    }
}
</style>
@endsection

@section('content')

<!-- Profil Sekolah -->
@if($profile)
<section id="profil-section" class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3" style="color: #1e3a8a;">
                <i class="fas fa-school me-3"></i>Profil Sekolah
            </h2>
            <p class="lead text-muted">Tentang Elunora School</p>
        </div>
        
        <div class="row align-items-center">
            <div class="col-md-6 mb-4">
                <div class="profile-image-container">
                    <img src="{{ $profile->foto ? asset($profile->foto) : asset('img/school-profile.jpg') }}" alt="Profil Sekolah" class="img-fluid rounded-4 shadow-lg">
                </div>
            </div>
            <div class="col-md-6">
                <div class="profile-content">
                    <h2 class="profile-title mb-4">{{ $profile->nama_sekolah }}</h2>
                    <div class="profile-excerpt mb-4">
                        {{ Str::limit(strip_tags($profile->deskripsi ?? 'Elunora School merupakan lembaga pendidikan yang berlandaskan pada filosofi Art of School, yakni perpaduan antara ilmu pengetahuan, seni, dan pembentukan karakter. Dengan komitmen mencetak generasi unggul, Elunora School menghadirkan suasana belajar yang tidak hanya berfokus pada aspek akademik, tetapi juga pada pengembangan kreativitas, kepribadian, dan nilai-nilai kemanusiaan. Didukung oleh tenaga pendidik profesional serta lingkungan yang inspiratif, Elunora School menjadi wadah bagi siswa untuk menemukan dan mengasah potensi terbaiknya.'), 300) }}
                    </div>
                    <a href="{{ route('profil') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-arrow-right me-2"></i>Baca Selengkapnya
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Upcoming Agendas Section -->
<section id="agenda-section" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3" style="color: #1e3a8a;">
                <i class="fas fa-calendar-alt me-3"></i>Agenda Mendatang
            </h2>
            <p class="lead text-muted">Jadwal kegiatan dan acara terbaru di Elunora School</p>
        </div>
        
        <div class="row g-4">
            @forelse(($upcomingAgendas ?? collect()) as $agenda)
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="card-title mb-0">{{ $agenda->judul }}</h5>
                            @if($agenda->kategori)
                            <span class="badge bg-primary">{{ $agenda->kategori }}</span>
                            @endif
                        </div>
                        
                        <div class="agenda-date mb-3">
                            <span class="text-muted d-block mb-1">
                                <i class="far fa-calendar-alt me-2"></i>
                                {{ \Carbon\Carbon::parse($agenda->tanggal)->translatedFormat('l, d F Y') }}
                            </span>
                            <span class="text-muted d-block">
                                <i class="far fa-clock me-2"></i>
                                {{ \Carbon\Carbon::parse($agenda->waktu_mulai)->format('H:i') }}{{ $agenda->waktu_selesai ? ' - ' . \Carbon\Carbon::parse($agenda->waktu_selesai)->format('H:i') : '' }}
                            </span>
                        </div>
                        
                        <div class="d-flex align-items-center text-muted mb-3">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            <span>{{ $agenda->lokasi }}</span>
                        </div>
                        
                        <p class="card-text text-muted small">
                            {{ Str::limit(strip_tags($agenda->deskripsi), 100) }}
                        </p>
                        
                        <a href="{{ route('agenda.show', $agenda->id) }}" class="btn btn-sm btn-primary mt-auto">
                            Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p>Belum ada agenda mendatang.</p>
            </div>
            @endforelse
        </div>
        
        <div class="text-center mt-5">
            <a href="{{ route('agenda') }}" class="btn btn-primary">
                <i class="fas fa-calendar-alt me-2"></i>Lihat Semua Agenda
            </a>
        </div>
    </div>
</section>

<!-- Berita Terbaru -->
<section id="berita-section" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3" style="color: #1e3a8a;">
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
<section id="galeri-section" class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3" style="color: #1e3a8a;">
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
    return false; // Prevent default link behavior
}

// Add event listeners when document is ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, setting up button handlers');
    
    // Add click handlers to all hero buttons
    const heroButtons = document.querySelectorAll('.btn-hero');
    console.log('Found hero buttons:', heroButtons.length);
    
    heroButtons.forEach(function(button, index) {
        console.log('Setting up button', index, button);
        button.addEventListener('click', function(e) {
            console.log('Button clicked:', this);
            e.preventDefault();
            e.stopPropagation();
            
            // Get the onclick attribute value
            const onclickAttr = this.getAttribute('onclick');
            console.log('Onclick attribute:', onclickAttr);
            
            if (onclickAttr) {
                // Extract section name from onclick="scrollToSection('section-name')"
                const match = onclickAttr.match(/scrollToSection\('([^']+)'\)/);
                if (match) {
                    const sectionId = match[1];
                    console.log('Scrolling to section:', sectionId);
                    scrollToSection(sectionId);
                }
            }
        });
    });
    
    // Add click handler to hero badge
    const heroBadge = document.querySelector('.hero-badge');
    if (heroBadge) {
        heroBadge.addEventListener('click', function(e) {
            e.preventDefault();
            scrollToSection('profil-section');
        });
    }
});

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