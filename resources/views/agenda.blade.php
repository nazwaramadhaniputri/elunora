@extends('layouts.app')

@section('title', 'Agenda')

@section('hero')
<div class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-4 fw-bold text-white mb-3">
                    <i class="fas fa-calendar-alt me-3"></i>Agenda Kegiatan
                </h1>
                <p class="lead mb-4 text-white">Jadwal lengkap kegiatan dan acara di Elunora School</p>
                <div class="d-flex gap-3">
                    <span class="badge bg-light text-dark fs-6 px-3 py-2">
                        <i class="fas fa-clock me-2"></i>Agenda Terbaru
                    </span>
                    <span class="badge bg-light text-dark fs-6 px-3 py-2">
                        <i class="fas fa-star me-2"></i>Kegiatan Sekolah
                    </span>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="hero-icon">
                    <i class="fas fa-calendar-alt" style="font-size: 8rem; color: rgba(255, 255, 255, 0.2);"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<section class="py-5">
    <div class="container">
        @if($todayAgenda->count() > 0)
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-0" style="color: var(--elunora-primary-dark);">
                <i class="fas fa-star me-3" style="color: var(--elunora-primary-dark);"></i>Agenda Hari Ini
            </h2>
        </div>
        
        <div class="row g-4">
            @foreach($todayAgenda as $agenda)
            <div class="col-md-6 col-lg-4">
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
                                <i class="far fa-calendar-alt me-2"></i>{{ \Carbon\Carbon::parse($agenda->tanggal)->translatedFormat('l, d F Y') }}
                            </span>
                            <span class="text-muted">
                                <i class="far fa-clock me-2"></i>{{ \Carbon\Carbon::parse($agenda->waktu_mulai)->format('H:i') }} - {{ $agenda->waktu_selesai ? \Carbon\Carbon::parse($agenda->waktu_selesai)->format('H:i') : 'Selesai' }}
                            </span>
                        </div>
                        
                        @if($agenda->lokasi)
                        <p class="text-muted mb-3">
                            <i class="fas fa-map-marker-alt me-2"></i>{{ $agenda->lokasi }}
                        </p>
                        @endif
                        
                        @if($agenda->deskripsi)
                        <p class="card-text">{{ Str::limit($agenda->deskripsi, 150) }}</p>
                        @endif
                        
                        <div class="d-flex justify-content-between align-items-center mt-auto pt-2">
                            <a href="{{ route('agenda.show', $agenda->id) }}" class="btn btn-primary btn-sm">
                                Detail <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                            <small class="text-muted">{{ $agenda->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <hr class="my-5">
        @endif
        
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-0" style="color: var(--elunora-primary-dark);">
                <i class="fas fa-calendar-alt me-3" style="color: var(--elunora-primary-dark);"></i>Agenda Mendatang
            </h2>
        </div>
        
        @if($upcomingAgenda->count() > 0)
        <div class="row g-4">
            @foreach($upcomingAgenda as $agenda)
            <div class="col-md-6 col-lg-4">
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
                                <i class="far fa-calendar-alt me-2"></i>{{ \Carbon\Carbon::parse($agenda->tanggal)->translatedFormat('l, d F Y') }}
                            </span>
                            <span class="text-muted">
                                <i class="far fa-clock me-2"></i>{{ \Carbon\Carbon::parse($agenda->waktu_mulai)->format('H:i') }} - {{ $agenda->waktu_selesai ? \Carbon\Carbon::parse($agenda->waktu_selesai)->format('H:i') : 'Selesai' }}
                            </span>
                        </div>
                        
                        @if($agenda->lokasi)
                        <p class="text-muted mb-3">
                            <i class="fas fa-map-marker-alt me-2"></i>{{ $agenda->lokasi }}
                        </p>
                        @endif
                        
                        @if($agenda->deskripsi)
                        <p class="card-text">{{ Str::limit($agenda->deskripsi, 120) }}</p>
                        @endif
                        
                        <div class="d-flex justify-content-between align-items-center mt-auto pt-2">
                            <a href="{{ route('agenda.show', $agenda->id) }}" class="btn btn-primary btn-sm">
                                Detail <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                            <small class="text-muted">{{ $agenda->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="mt-5 d-flex justify-content-center">
            {{ $upcomingAgenda->links() }}
        </div>
        @else
            <div class="empty-state text-center py-5">
                <i class="fas fa-calendar-alt" style="font-size: 4rem; color: #dee2e6; margin-bottom: 1rem;"></i>
                <h4 class="text-muted">Tidak Ada Agenda Mendatang</h4>
                <p class="text-muted">Agenda mendatang akan ditampilkan di sini ketika sudah dipublikasikan.</p>
            </div>
        @endif
        
        <!-- Agenda Sedang Berlangsung -->
        @if(isset($ongoingAgenda) && $ongoingAgenda->count() > 0)
        <hr class="my-5">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-0" style="color: var(--elunora-primary-dark);">
                <i class="fas fa-play-circle me-3" style="color: var(--elunora-primary-dark);"></i>Agenda Sedang Berlangsung
            </h2>
        </div>
        
        <div class="row g-4">
            @foreach($ongoingAgenda as $agenda)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm border-warning">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="card-title mb-0">{{ $agenda->judul }}</h5>
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-play me-1"></i>Berlangsung
                            </span>
                        </div>
                        
                        <div class="agenda-date mb-3">
                            <span class="text-muted d-block mb-1">
                                <i class="far fa-calendar-alt me-2"></i>{{ \Carbon\Carbon::parse($agenda->tanggal)->translatedFormat('l, d F Y') }}
                            </span>
                            <span class="text-muted">
                                <i class="far fa-clock me-2"></i>{{ \Carbon\Carbon::parse($agenda->waktu_mulai)->format('H:i') }} - {{ $agenda->waktu_selesai ? \Carbon\Carbon::parse($agenda->waktu_selesai)->format('H:i') : 'Selesai' }}
                            </span>
                        </div>
                        
                        @if($agenda->lokasi)
                        <p class="text-muted mb-3">
                            <i class="fas fa-map-marker-alt me-2"></i>{{ $agenda->lokasi }}
                        </p>
                        @endif
                        
                        @if($agenda->deskripsi)
                        <p class="card-text">{{ Str::limit($agenda->deskripsi, 120) }}</p>
                        @endif
                        
                        <div class="d-flex justify-content-between align-items-center mt-auto pt-2">
                            <a href="{{ route('agenda.show', $agenda->id) }}" class="btn btn-warning btn-sm">
                                Detail <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                            <small class="text-muted">{{ $agenda->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
        
        <!-- Agenda Terlaksana -->
        @if(isset($pastAgenda) && $pastAgenda->count() > 0)
        <hr class="my-5">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-0" style="color: var(--elunora-primary-dark);">
                <i class="fas fa-check-circle me-3" style="color: var(--elunora-primary-dark);"></i>Agenda Terlaksana
            </h2>
        </div>
        
        <div class="row g-4">
            @foreach($pastAgenda as $agenda)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="card-title mb-0">{{ $agenda->judul }}</h5>
                            <span class="badge bg-success">
                                <i class="fas fa-check me-1"></i>Selesai
                            </span>
                        </div>
                        
                        <div class="agenda-date mb-3">
                            <span class="text-muted d-block mb-1">
                                <i class="far fa-calendar-alt me-2"></i>{{ \Carbon\Carbon::parse($agenda->tanggal)->translatedFormat('l, d F Y') }}
                            </span>
                            <span class="text-muted">
                                <i class="far fa-clock me-2"></i>{{ \Carbon\Carbon::parse($agenda->waktu_mulai)->format('H:i') }} - {{ $agenda->waktu_selesai ? \Carbon\Carbon::parse($agenda->waktu_selesai)->format('H:i') : 'Selesai' }}
                            </span>
                        </div>
                        
                        @if($agenda->lokasi)
                        <p class="text-muted mb-3">
                            <i class="fas fa-map-marker-alt me-2"></i>{{ $agenda->lokasi }}
                        </p>
                        @endif
                        
                        @if($agenda->deskripsi)
                        <p class="card-text">{{ Str::limit($agenda->deskripsi, 120) }}</p>
                        @endif
                        
                        <div class="d-flex justify-content-between align-items-center mt-auto pt-2">
                            <a href="{{ route('agenda.show', $agenda->id) }}" class="btn btn-primary btn-sm">
                                Detail <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                            <small class="text-muted">{{ $agenda->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="mt-5 d-flex justify-content-center">
            {{ $pastAgenda->links('pagination::bootstrap-4', ['pageName' => 'past_page']) }}
        </div>
        @endif
    </div>
</section>
@endsection

@section('styles')
<style>
.empty-state {
    padding: 3rem 1rem;
    background: #f8f9fa;
    border-radius: 8px;
    text-align: center;
}

.card {
    border: none;
    border-radius: 15px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    margin-bottom: 1.5rem;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}

.btn-outline-primary {
    color: var(--elunora-primary);
    border-color: var(--elunora-primary);
}

.btn-outline-primary:hover,
.btn-outline-primary:focus {
    background-color: var(--elunora-primary);
    border-color: var(--elunora-primary);
    color: #fff;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .card {
        margin-bottom: 1rem;
    }
}
</style>
@endsection
