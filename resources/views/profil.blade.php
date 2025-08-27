@extends('layouts.app')

@section('title', 'Profil Sekolah')

@section('hero')
<div class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-4 fw-bold text-white mb-3">
                    <i class="fas fa-school me-3"></i>Profil Elunora School
                </h1>
                <p class="lead mb-4 text-white">Sekolah Menengah Kejuruan Unggulan dengan Prestasi Membanggakan</p>
                <div class="d-flex gap-3">
                    <span class="badge bg-light text-dark fs-6 px-3 py-2">
                        <i class="fas fa-award me-2"></i>Terakreditasi A
                    </span>
                    <span class="badge bg-light text-dark fs-6 px-3 py-2">
                        <i class="fas fa-graduation-cap me-2"></i>5 Jurusan
                    </span>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="hero-icon">
                    <i class="fas fa-university" style="font-size: 8rem; color: rgba(255, 255, 255, 0.2);"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
@if($profile)
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-lg">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0"><i class="fas fa-info-circle me-2"></i>{{ $profile->nama_sekolah }}</h3>
                    </div>
                    <div class="card-body p-4">
                        <div class="profile-content">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <p><strong>Nama Sekolah:</strong> {{ $profile->nama_sekolah }}</p>
                                    <p><strong>Alamat:</strong> {{ $profile->alamat }}</p>
                                    <p><strong>Telepon:</strong> {{ $profile->telepon }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Email:</strong> {{ $profile->email }}</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <h5>Deskripsi Sekolah</h5>
                                <p>{!! nl2br(e($profile->deskripsi)) !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

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
                        <p class="text-justify">"Menjadi sekolah kejuruan unggulan yang melahirkan lulusan profesional, kreatif, dan siap bersaing di dunia kerja nasional maupun internasional."</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="info-card h-100">
                    <div class="info-card-body">
                        <div class="info-icon mb-3">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h3 class="info-title mb-4">Kompetensi Keahlian</h3>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>Teknik Komputer dan Jaringan (TKJ)
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>Rekayasa Perangkat Lunak (RPL)
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>Multimedia (MM)
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>Akuntansi dan Keuangan Lembaga (AKL)
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>Otomatisasi dan Tata Kelola Perkantoran (OTKP)
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
    </div>
</section>

@endsection

@section('styles')
<style>
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