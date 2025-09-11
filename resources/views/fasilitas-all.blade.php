@extends('layouts.app')

@section('title', 'Semua Fasilitas')

@section('hero')
<div class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-4 fw-bold text-white mb-3">
                    <i class="fas fa-building me-3"></i>Fasilitas Sekolah
                </h1>
                <p class="lead mb-4 text-white">Fasilitas modern untuk mendukung pendidikan kejuruan yang berkualitas</p>
                <div class="d-flex gap-3">
                    <span class="badge bg-light text-dark fs-6 px-3 py-2">
                        <i class="fas fa-building me-2"></i>{{ $fasilitas->total() }} Fasilitas
                    </span>
                    <span class="badge bg-light text-dark fs-6 px-3 py-2">
                        <i class="fas fa-tools me-2"></i>Lengkap & Modern
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
<section class="py-5">
    <div class="container">
        <!-- Back Button -->
        <div class="row mb-4">
            <div class="col-12">
                <a href="{{ route('profil') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Profil
                </a>
            </div>
        </div>

        <div class="row">
            @forelse($fasilitas as $item)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="modern-card facility-card h-100">
                    <div class="facility-image-container">
                        @if($item->foto)
                            <img src="{{ asset($item->foto) }}" class="facility-image" alt="{{ $item->nama }}">
                        @else
                            <div class="facility-placeholder">
                                <i class="fas fa-building fa-3x text-muted"></i>
                            </div>
                        @endif
                    </div>
                    <div class="card-body-modern">
                        <h5 class="facility-name">{{ $item->nama }}</h5>
                        <p class="facility-description">{{ $item->deskripsi }}</p>
                        <div class="facility-meta">
                            <small class="text-muted">
                                <i class="fas fa-sort-numeric-up me-1"></i>Urutan: {{ $item->urutan }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="empty-state">
                    <i class="fas fa-building fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">Belum Ada Fasilitas</h4>
                    <p class="text-muted">Data fasilitas akan ditampilkan di sini.</p>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($fasilitas->hasPages())
        <div class="row mt-5">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    {{ $fasilitas->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection

@section('styles')
<style>
.facility-card {
    transition: all 0.3s ease;
    overflow: hidden;
}

.facility-card:hover {
    transform: translateY(-5px);
}

.facility-image-container {
    position: relative;
    height: 200px;
    overflow: hidden;
    border-radius: 15px 15px 0 0;
}

.facility-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.facility-card:hover .facility-image {
    transform: scale(1.05);
}

.facility-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    display: flex;
    align-items: center;
    justify-content: center;
}

.facility-name {
    color: var(--elunora-dark);
    font-weight: 600;
    margin-bottom: 0.75rem;
}

.facility-description {
    color: var(--elunora-secondary);
    line-height: 1.6;
    margin-bottom: 1rem;
}

.facility-meta {
    border-top: 1px solid #eee;
    padding-top: 0.75rem;
}
</style>
@endsection
