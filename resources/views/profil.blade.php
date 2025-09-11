@extends('layouts.app')

@section('title', 'Profile Sekolah')

@section('hero')
<div class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-4 fw-bold text-white mb-3">
                    <i class="fas fa-school me-3"></i>Profile Sekolah
                </h1>
                <p class="lead mb-4 text-white">Mengenal lebih dekat tentang profile dan sejarah Elunora School</p>
                <div class="d-flex gap-3">
                    <span class="badge bg-light text-dark fs-6 px-3 py-2">
                        <i class="fas fa-graduation-cap me-2"></i>School of Art
                    </span>
                    <span class="badge bg-light text-dark fs-6 px-3 py-2">
                        <i class="fas fa-star me-2"></i>Sekolah Unggulan
                    </span>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="hero-icon">
                    <i class="fas fa-school" style="font-size: 8rem; color: rgba(255, 255, 255, 0.2);"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('content')
<!-- Profil Detail Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="modern-profile-card">
                    <div class="profile-header">
                        <div class="profile-header-content">
                            <div class="profile-icon">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <div class="profile-header-text">
                                <h3 class="profile-header-title">{{ $profile ? $profile->nama_sekolah : 'Elunora School' }}</h3>
                                <p class="profile-header-subtitle">Informasi Lengkap Sekolah</p>
                            </div>
                        </div>
                    </div>
                    <div class="profile-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="video-container mb-4">
                                    <iframe src="https://www.youtube.com/embed/hfKhYKXdFmM?autoplay=0&mute=0&loop=1&playlist=hfKhYKXdFmM&controls=1&showinfo=0&rel=0&iv_load_policy=3&modestbranding=1&vq=hd1080" 
                                            frameborder="0" 
                                            allow="autoplay; encrypted-media" 
                                            allowfullscreen>
                                    </iframe>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="school-info-grid">
                                    <div class="info-item-modern">
                                        <div class="info-icon-modern">
                                            <i class="fas fa-school"></i>
                                        </div>
                                        <div class="info-content-modern">
                                            <span class="info-label-modern">Nama Sekolah</span>
                                            <span class="info-value-modern">{{ $profile ? $profile->nama_sekolah : 'Elunora School' }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="info-item-modern">
                                        <div class="info-icon-modern">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                        <div class="info-content-modern">
                                            <span class="info-label-modern">Alamat</span>
                                            <span class="info-value-modern">{{ $profile ? $profile->alamat : 'Alamat belum diatur' }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="info-item-modern">
                                        <div class="info-icon-modern">
                                            <i class="fas fa-phone"></i>
                                        </div>
                                        <div class="info-content-modern">
                                            <span class="info-label-modern">Telepon</span>
                                            <span class="info-value-modern">{{ $profile ? $profile->telepon : 'Telepon belum diatur' }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="info-item-modern">
                                        <div class="info-icon-modern">
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                        <div class="info-content-modern">
                                            <span class="info-label-modern">Email</span>
                                            <span class="info-value-modern">{{ $profile ? $profile->email : 'Email belum diatur' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="description-section">
                                    <div class="description-header">
                                        <div class="description-icon">
                                            <i class="fas fa-file-alt"></i>
                                        </div>
                                        <h5 class="description-title">Deskripsi Sekolah</h5>
                                    </div>
                                    <div class="description-content">
                                        <p>{!! nl2br(e($profile->deskripsi ?? 'Elunora School merupakan lembaga pendidikan yang berlandaskan pada filosofi Art of School, yakni perpaduan antara ilmu pengetahuan, seni, dan pembentukan karakter. Dengan komitmen mencetak generasi unggul, Elunora School menghadirkan suasana belajar yang tidak hanya berfokus pada aspek akademik, tetapi juga pada pengembangan kreativitas, kepribadian, dan nilai-nilai kemanusiaan.

Didukung oleh tenaga pendidik profesional serta lingkungan yang inspiratif, Elunora School menjadi wadah bagi siswa untuk menemukan dan mengasah potensi terbaiknya. Melalui program pembelajaran yang inovatif, kegiatan seni dan budaya, serta pendidikan karakter yang kuat, Elunora School bertekad melahirkan generasi yang berwawasan luas, berjiwa kreatif, dan siap menghadapi tantangan global.')) !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Visi dan Kompetensi Keahlian -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="info-card h-100">
                    <div class="info-card-body">
                        <div class="info-icon mb-3">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <h3 class="info-title mb-4">Visi Sekolah</h3>
                        <p class="text-justify">"Menjadi School of Art yang melahirkan lulusan kreatif, berbakat, dan siap bersaing di dunia seni nasional maupun internasional."</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="info-card h-100">
                    <div class="info-card-body">
                        <div class="info-icon mb-3">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h3 class="info-title mb-4">Kategori</h3>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="fas fa-music text-success me-2"></i>Seni Musik
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-theater-masks text-success me-2"></i>Seni Teater
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-palette text-success me-2"></i>Seni Rupa
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-video text-success me-2"></i>Seni Media Digital
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-camera text-success me-2"></i>Fotografi & Sinematografi
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Fasilitas Sekolah -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2>Fasilitas Sekolah</h2>
            <p>Fasilitas modern untuk mendukung pendidikan kejuruan yang berkualitas</p>
        </div>
        
        <div class="row">
            @forelse($fasilitas as $item)
            <div class="col-md-4 mb-4">
                <div class="facility-card h-100">
                    <div class="facility-image-container">
                        @if($item->foto)
                            <img src="{{ asset($item->foto) }}" class="facility-image" alt="{{ $item->nama }}">
                        @else
                            <div class="facility-placeholder">
                                <i class="fas fa-building fa-3x text-muted"></i>
                            </div>
                        @endif
                        <div class="facility-overlay">
                            <i class="fas fa-building"></i>
                        </div>
                    </div>
                    <div class="facility-content">
                        <h5 class="facility-title">{{ $item->nama }}</h5>
                        <p class="card-text">{{ $item->deskripsi }}</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p class="text-muted">Belum ada data fasilitas.</p>
            </div>
            @endforelse
        </div>
        
        @if($fasilitas->count() > 0)
        <div class="text-center mt-4">
            <a href="{{ route('fasilitas.all') }}" class="btn-modern primary">
                <i class="fas fa-building me-2"></i>Lihat Semua Fasilitas
            </a>
        </div>
        @endif
    </div>
</section>

<!-- Guru & Staff -->
<section class="py-5">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2>Guru & Staff</h2>
            <p>Tim pendidik profesional yang berpengalaman dan berdedikasi</p>
        </div>
        
        <div class="row">
            @forelse($gurus as $guru)
            <div class="col-md-4 mb-4">
                <div class="teacher-card h-100">
                    <div class="teacher-image-container">
                        @if($guru->foto)
                            <img src="{{ asset($guru->foto) }}" class="teacher-image" alt="{{ $guru->nama }}">
                        @else
                            <div class="teacher-placeholder">
                                <i class="fas fa-user fa-3x text-muted"></i>
                            </div>
                        @endif
                    </div>
                    <div class="teacher-content">
                        <h5 class="teacher-name">{{ $guru->nama }}</h5>
                        <p class="teacher-position">{{ $guru->jabatan }}</p>
                        @if($guru->mata_pelajaran)
                            <p class="teacher-subject"><i class="fas fa-book me-2"></i>{{ $guru->mata_pelajaran }}</p>
                        @endif
                        @if($guru->nip)
                            <p class="teacher-nip"><i class="fas fa-id-card me-2"></i>NIP: {{ $guru->nip }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p class="text-muted">Belum ada data guru.</p>
            </div>
            @endforelse
        </div>
        
        @if($gurus->count() > 0)
        <div class="text-center mt-4">
            <a href="{{ route('guru.all') }}" class="btn-modern primary">
                <i class="fas fa-chalkboard-teacher me-2"></i>Lihat Semua Guru & Staff
            </a>
        </div>
        @endif
    </div>
</section>

@endsection

@section('styles')
<style>
.modern-profile-card {
    background: white;
    border-radius: 25px;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    border: none;
    margin-bottom: 2rem;
}

.profile-header {
    background: linear-gradient(135deg, var(--elunora-primary), #0056b3);
    padding: 2rem;
    position: relative;
    overflow: hidden;
}

.profile-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 200%;
    background: rgba(255, 255, 255, 0.05);
    transform: rotate(45deg);
}

.profile-header-content {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    position: relative;
    z-index: 2;
}

.profile-icon {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2.5rem;
    flex-shrink: 0;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.profile-header-title {
    color: white;
    font-weight: 700;
    font-size: 2rem;
    margin: 0;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
}

.profile-header-subtitle {
    color: rgba(255, 255, 255, 0.9);
    margin: 0.5rem 0 0 0;
    font-size: 1.1rem;
}

.profile-body {
    padding: 2.5rem;
}

.school-info-grid {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.info-item-modern {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.875rem;
    background: #f8fafc;
    border-radius: 12px;
    border-left: 3px solid var(--elunora-primary);
}


.info-icon-modern {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, var(--elunora-primary), #0056b3);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1rem;
    flex-shrink: 0;
    box-shadow: 0 3px 10px rgba(30, 58, 138, 0.2);
}

.info-content-modern {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
    flex: 1;
}

.info-label-modern {
    font-size: 0.8rem;
    color: var(--elunora-secondary);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-value-modern {
    font-size: 0.95rem;
    color: var(--elunora-dark);
    font-weight: 600;
    line-height: 1.3;
}

.description-section {
    background: #f8fafc;
    border-radius: 20px;
    padding: 2rem;
    border: 1px solid #e2e8f0;
}

.description-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

/* Page Header */
.page-header {
    padding: 6rem 0 8rem;
    position: relative;
    overflow: hidden;
    color: #fff;
}

.page-header h1 {
    position: relative;
    z-index: 2;
}

.page-header .breadcrumb {
    background: transparent;
    padding: 0;
    margin: 1rem 0 0;
    justify-content: center;
}

.page-header .breadcrumb-item a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    transition: all 0.3s ease;
}

.page-header .breadcrumb-item a:hover {
    color: #fff;
    text-decoration: underline;
}

.page-header .breadcrumb-item.active {
    color: rgba(255, 255, 255, 0.6);
}

.page-header .breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255, 255, 255, 0.6);
}

/* Icon Box */
.icon-box {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
    font-size: 1.75rem;
}

.bg-soft-primary {
    background-color: rgba(30, 58, 138, 0.1);
}

/* Divider */
.divider {
    width: 80px;
    height: 4px;
    border-radius: 2px;
    margin: 0 auto;
}

/* Card Hover Effect */
.card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: none;
    border-radius: 0.75rem;
    overflow: hidden;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
}

/* Video Play Button */
.btn-play {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: rgba(255, 255, 255, 0.9);
    color: var(--elunora-primary);
    border: none;
    font-size: 1.5rem;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.btn-play:hover {
    background: #fff;
    transform: translate(-50%, -50%) scale(1.1);
    color: var(--elunora-primary);
}

/* Responsive Adjustments */
@media (max-width: 991.98px) {
    .page-header {
        padding: 5rem 0 7rem;
    }
    
    .icon-box {
        width: 70px;
        height: 70px;
        font-size: 1.5rem;
    }
    
    .btn-play {
        width: 70px;
        height: 70px;
        font-size: 1.25rem;
    }
}

@media (max-width: 767.98px) {
    .page-header {
        padding: 4rem 0 6rem;
    }
    
    .page-header h1 {
        font-size: 2rem;
    }
    
    .icon-box {
        width: 60px;
        height: 60px;
        font-size: 1.25rem;
    }
    
    .btn-play {
        width: 60px;
        height: 60px;
        font-size: 1rem;
    }
}

/* Modern Profile Card */
/* Gallery Styles */
.gallery-item {
    position: relative;
    overflow: hidden;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
    height: 250px;
}

.gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.gallery-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(30, 58, 138, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.gallery-caption {
    text-align: center;
    color: #fff;
    transform: translateY(20px);
    transition: transform 0.3s ease;
}

.gallery-item:hover .gallery-overlay {
    opacity: 1;
}

.gallery-item:hover .gallery-caption {
    transform: translateY(0);
}

.gallery-item:hover img {
    transform: scale(1.05);
}

/* Modern Profile Card */
.modern-profile-card {
    background: #fff;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08);
    margin-bottom: 2rem;
}

.profile-header {
    background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
    padding: 2rem;
    color: #fff;
    position: relative;
}

.profile-header-content {
    display: flex;
    align-items: center;
    position: relative;
    z-index: 2;
}

.profile-icon {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    margin-right: 1.5rem;
}

.profile-header-text h3 {
    margin: 0;
    font-size: 1.75rem;
    font-weight: 700;
}

.profile-header-subtitle {
    opacity: 0.9;
    margin: 0.25rem 0 0;
}

.profile-body {
    padding: 2rem;
}

.description-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, var(--elunora-primary), #1e40af);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
}

.description-title {
    color: var(--elunora-dark);
    font-weight: 700;
    margin: 0;
    font-size: 1.3rem;
}

.description-content {
    color: var(--elunora-secondary);
    line-height: 1.7;
    font-size: 1rem;
}

.description-content p {
    margin: 0;
}

.video-container {
    position: relative;
    width: 100%;
    height: 0;
    padding-bottom: 56.25%; /* 16:9 aspect ratio */
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.video-container iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.hero-icon {
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

.profile-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    overflow: hidden;
    border: none;
}

.profile-card-body {
    padding: 2.5rem;
}

.profile-image-container {
    position: relative;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.profile-image {
    width: 100%;
    height: auto;
    transition: transform 0.3s ease;
}

.profile-image-container:hover .profile-image {
    transform: scale(1.05);
}

.profile-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    background: rgba(255,255,255,0.9);
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}

.profile-title {
    color: #2c3e50;
    font-weight: 700;
    font-size: 1.8rem;
}

.info-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    border: none;
    overflow: hidden;
}

.info-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 50px rgba(0,0,0,0.15);
}

.info-card-body {
    padding: 2.5rem;
    text-align: center;
}

.info-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #007bff, #0056b3);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    color: white;
    font-size: 2rem;
}

.info-title {
    color: #2c3e50;
    font-weight: 700;
    font-size: 1.5rem;
}

.facility-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: all 0.4s ease;
    border: none;
}

.facility-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 60px rgba(0,0,0,0.2);
}

.facility-image-container {
    position: relative;
    height: 250px;
    overflow: hidden;
}

.facility-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.facility-card:hover .facility-image {
    transform: scale(1.1);
}

.facility-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 123, 255, 0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.3s ease;
    color: white;
    font-size: 3rem;
}

.facility-card:hover .facility-overlay {
    opacity: 1;
}

.facility-content {
    padding: 2rem;
}

.facility-title {
    color: #2c3e50;
    font-weight: 700;
    margin-bottom: 1rem;
}

.achievement-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    overflow: hidden;
    border: none;
}

.achievement-card-body {
    padding: 2.5rem;
}

.achievement-table {
    width: 100%;
    margin-bottom: 0;
    background: transparent;
}

.achievement-table thead th {
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: white;
    border: none;
    font-weight: 600;
    padding: 1.2rem;
    text-align: center;
    font-size: 1rem;
}

.achievement-table tbody tr {
    transition: all 0.2s ease;
}

.achievement-table tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.05);
    transform: scale(1.01);
}

.achievement-table tbody td {
    padding: 1.2rem;
    vertical-align: middle;
    border-color: #e9ecef;
    text-align: center;
}

/* Teacher Cards */
.teacher-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: all 0.4s ease;
    border: none;
}

.teacher-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 60px rgba(0,0,0,0.2);
}

.teacher-image-container {
    position: relative;
    height: 250px;
    overflow: hidden;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
}

.teacher-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.teacher-placeholder {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    background: #f8f9fa;
}

.teacher-card:hover .teacher-image {
    transform: scale(1.1);
}

.teacher-content {
    padding: 2rem;
    text-align: center;
}

.teacher-name {
    color: #2c3e50;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.teacher-position {
    color: #007bff;
    font-weight: 600;
    margin-bottom: 1rem;
}

.teacher-subject, .teacher-education, .teacher-nip {
    font-size: 0.9rem;
    color: #6c757d;
    margin-bottom: 0.5rem;
}

/* Program Cards */
.program-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: all 0.4s ease;
    border: none;
}

.program-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 50px rgba(0,0,0,0.15);
}

.program-image-container {
    position: relative;
    height: 200px;
    overflow: hidden;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
}

.program-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.program-placeholder {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    background: #f8f9fa;
}

.program-card:hover .program-image {
    transform: scale(1.05);
}

.program-content {
    padding: 2rem;
}

.program-title {
    color: #2c3e50;
    font-weight: 700;
    margin-bottom: 1rem;
}

.program-description {
    color: #6c757d;
    margin-bottom: 1rem;
    line-height: 1.6;
}

.program-prospects {
    margin-top: 1rem;
}

/* Facility Placeholder */
.facility-placeholder {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    background: #f8f9fa;
}

.section-title h2 {
    color: #2c3e50;
    font-weight: 700;
    font-size: 2.5rem;
    margin-bottom: 1rem;
}

.section-title p {
    color: #6c757d;
    font-size: 1.1rem;
}

@media (max-width: 768px) {
    .profile-card-body,
    .info-card-body,
    .facility-content,
    .achievement-card-body {
        padding: 1.5rem;
    }
    
    .facility-image-container {
        height: 200px;
    }
    
    .info-icon {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
    }
}
</style>
@endsection