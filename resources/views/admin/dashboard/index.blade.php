@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="fade-in">
    <div class="page-header-modern mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div class="page-title-section">
                <h4 class="page-title">
                    <i class="fas fa-tachometer-alt me-3"></i>Dashboard Admin
                </h4>
                <p class="page-subtitle">Selamat datang di panel admin Elunora School</p>
            </div>
            <div class="page-actions">
                <div class="dashboard-time-info">
                    <span class="time-badge">
                        <i class="fas fa-calendar me-1"></i>{{ now()->format('d M Y') }}
                    </span>
                    <span class="time-badge ms-2">
                        <i class="fas fa-clock me-1"></i>{{ now()->format('H:i') }} WIB
                    </span>
                </div>
            </div>
        </div>
    </div>

<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="modern-stats-card primary">
            <div class="stats-content">
                <div class="stats-icon">
                    <i class="fas fa-newspaper"></i>
                </div>
                <div class="stats-info">
                    <h3 class="stats-number">{{ $totalBerita }}</h3>
                    <p class="stats-label">Total Berita</p>
                </div>
            </div>
            <div class="stats-trend">
                <i class="fas fa-arrow-up"></i>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="modern-stats-card success">
            <div class="stats-content">
                <div class="stats-icon">
                    <i class="fas fa-images"></i>
                </div>
                <div class="stats-info">
                    <h3 class="stats-number">{{ $totalGaleri }}</h3>
                    <p class="stats-label">Total Galeri</p>
                </div>
            </div>
            <div class="stats-trend">
                <i class="fas fa-arrow-up"></i>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="modern-stats-card info">
            <div class="stats-content">
                <div class="stats-icon">
                    <i class="fas fa-camera"></i>
                </div>
                <div class="stats-info">
                    <h3 class="stats-number">{{ $totalFoto }}</h3>
                    <p class="stats-label">Total Foto</p>
                </div>
            </div>
            <div class="stats-trend">
                <i class="fas fa-arrow-up"></i>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="modern-stats-card warning">
            <div class="stats-content">
                <div class="stats-icon">
                    <i class="fas fa-tags"></i>
                </div>
                <div class="stats-info">
                    <h3 class="stats-number">{{ $totalKategori }}</h3>
                    <p class="stats-label">Total Kategori</p>
                </div>
            </div>
            <div class="stats-trend">
                <i class="fas fa-arrow-up"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="modern-card">
            <div class="card-header-modern">
                <h5 class="card-title-modern">
                    <i class="fas fa-chart-line me-2"></i>Statistik Sekolah
                </h5>
            </div>
            <div class="card-body-modern">
                <div class="school-stats-list">
                    <div class="school-stat-item">
                        <div class="stat-icon-wrapper">
                            <i class="fas fa-chalkboard-teacher text-primary"></i>
                        </div>
                        <div class="stat-details">
                            <h6>Total Guru & Staff</h6>
                            <span class="stat-number">{{ \App\Models\Guru::where('status', 1)->count() }}</span>
                        </div>
                    </div>
                    <div class="school-stat-item">
                        <div class="stat-icon-wrapper">
                            <i class="fas fa-building text-info"></i>
                        </div>
                        <div class="stat-details">
                            <h6>Fasilitas Sekolah</h6>
                            <span class="stat-number">{{ \App\Models\Fasilitas::where('status', 1)->count() }}</span>
                        </div>
                    </div>
                    <div class="school-stat-item">
                        <div class="stat-icon-wrapper">
                            <i class="fas fa-envelope text-warning"></i>
                        </div>
                        <div class="stat-details">
                            <h6>Pesan Masuk</h6>
                            <span class="stat-number">{{ \App\Models\Contact::where('status', 0)->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="modern-card">
            <div class="card-header-modern">
                <h5 class="card-title-modern">
                    <i class="fas fa-bolt me-2"></i>Aksi Cepat
                </h5>
            </div>
            <div class="card-body-modern">
                <div class="quick-actions">
                    <a href="{{ route('admin.berita.create') }}" class="quick-action-btn primary">
                        <div class="action-icon">
                            <i class="fas fa-plus-circle"></i>
                        </div>
                        <div class="action-content">
                            <h6>Tambah Berita</h6>
                            <p>Buat artikel berita baru</p>
                        </div>
                    </a>
                    <a href="{{ route('admin.galeri.index') }}" class="quick-action-btn success">
                        <div class="action-icon">
                            <i class="fas fa-images"></i>
                        </div>
                        <div class="action-content">
                            <h6>Kelola Galeri</h6>
                            <p>Tambah foto ke galeri</p>
                        </div>
                    </a>
                    <a href="{{ route('admin.guru.create') }}" class="quick-action-btn info">
                        <div class="action-icon">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <div class="action-content">
                            <h6>Tambah Guru</h6>
                            <p>Daftarkan guru baru</p>
                        </div>
                    </a>
                    <a href="{{ route('admin.fasilitas.create') }}" class="quick-action-btn warning">
                        <div class="action-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="action-content">
                            <h6>Tambah Fasilitas</h6>
                            <p>Daftarkan fasilitas baru</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection