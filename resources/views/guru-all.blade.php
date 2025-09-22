@extends('layouts.app')

@section('title', 'Semua Guru & Staff')

@section('hero')
<div class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-4 fw-bold text-white mb-3">
                    <i class="fas fa-chalkboard-teacher me-3"></i>Guru & Staff
                </h1>
                <p class="lead mb-4 text-white">Tim pendidik profesional yang berpengalaman dan berdedikasi</p>
                <div class="d-flex gap-3">
                    <span class="badge bg-light text-dark fs-6 px-3 py-2">
                        <i class="fas fa-users me-2"></i>{{ $gurus->total() }} Guru & Staff
                    </span>
                    <span class="badge bg-light text-dark fs-6 px-3 py-2">
                        <i class="fas fa-award me-2"></i>Berpengalaman
                    </span>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="hero-icon">
                    <i class="fas fa-graduation-cap" style="font-size: 8rem; color: rgba(255, 255, 255, 0.2);"></i>
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
            @forelse($gurus as $guru)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="modern-card teacher-card h-100">
                    <div class="teacher-image-container">
                        @if($guru->foto)
                            <img src="{{ asset($guru->foto) }}" class="teacher-image" alt="{{ $guru->nama }}">
                        @else
                            <div class="teacher-placeholder">
                                <i class="fas fa-user fa-3x text-muted"></i>
                            </div>
                        @endif
                    </div>
                    <div class="card-body-modern">
                        <h5 class="teacher-name">{{ $guru->nama }}</h5>
                        <p class="teacher-position">{{ $guru->jabatan }}</p>
                        
                        <div class="teacher-details">
                            @if($guru->mata_pelajaran)
                                <p class="teacher-subject">
                                    <i class="fas fa-book me-2"></i>{{ $guru->mata_pelajaran }}
                                </p>
                            @endif
                            
                            @if($guru->nip)
                                <p class="teacher-nip">
                                    <i class="fas fa-id-card me-2"></i>NIP: {{ $guru->nip }}
                                </p>
                            @endif
                            
                            @if($guru->pendidikan)
                                <p class="teacher-education">
                                    <i class="fas fa-graduation-cap me-2"></i>{{ $guru->pendidikan }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="empty-state">
                    <i class="fas fa-chalkboard-teacher fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">Belum Ada Data Guru</h4>
                    <p class="text-muted">Data guru dan staff akan ditampilkan di sini.</p>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($gurus->hasPages())
        <div class="row mt-5">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    {{ $gurus->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection

@section('styles')
<style>
.teacher-card {
    transition: all 0.3s ease;
    overflow: hidden;
}

.teacher-card:hover {
    transform: translateY(-5px);
}

.teacher-image-container {
    position: relative;
    height: 320px; /* taller so wajah tidak terpotong */
    overflow: hidden;
    border-radius: 15px 15px 0 0;
}

.teacher-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center top; /* fokus ke wajah */
    transition: transform 0.3s ease;
}

.teacher-card:hover .teacher-image {
    transform: scale(1.05);
}

.teacher-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    display: flex;
    align-items: center;
    justify-content: center;
}

.teacher-name {
    color: var(--elunora-dark);
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.teacher-position {
    color: var(--elunora-primary);
    font-weight: 500;
    margin-bottom: 1rem;
}

.teacher-details p {
    margin-bottom: 0.5rem;
    color: var(--elunora-secondary);
    font-size: 0.9rem;
}

.teacher-subject {
    color: var(--elunora-success) !important;
}

.teacher-nip {
    color: var(--elunora-info) !important;
}

.teacher-education {
    color: var(--elunora-warning) !important;
}

@media (max-width: 768px) {
    .teacher-image-container {
        height: 260px; /* responsive height */
    }
}
</style>
@endsection
