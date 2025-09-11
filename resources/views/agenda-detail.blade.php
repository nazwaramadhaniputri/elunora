@extends('layouts.app')

@section('title', $agenda->judul)

@section('hero')
<div class="page-header d-flex align-items-center" style="background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);">
    <div class="container position-relative">
        <div class="row">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold text-white mb-3">
                    <i class="fas fa-calendar-alt me-3"></i>{{ $agenda->judul }}
                </h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('agenda') }}" class="text-white-50">Agenda</a></li>
                        <li class="breadcrumb-item active text-white-50" aria-current="page">{{ Str::limit($agenda->judul, 30) }}</li>
                    </ol>
                </nav>
                <div class="d-flex flex-wrap align-items-center gap-3 mt-3">
                    <div class="d-flex align-items-center text-white">
                        <i class="far fa-calendar-alt me-2"></i>
                        <span>{{ \Carbon\Carbon::parse($agenda->tanggal)->translatedFormat('l, d F Y') }}</span>
                    </div>
                    <div class="d-flex align-items-center text-white">
                        <i class="far fa-clock me-2"></i>
                        <span>{{ \Carbon\Carbon::parse($agenda->waktu_mulai)->format('H:i') }} - {{ $agenda->waktu_selesai ? \Carbon\Carbon::parse($agenda->waktu_selesai)->format('H:i') : 'Selesai' }}</span>
                    </div>
                    @if($agenda->kategori)
                    <span class="badge bg-white text-primary">
                        <i class="fas fa-tag me-1"></i>{{ $agenda->kategori }}
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="position-absolute bottom-0 start-0 w-100 d-none d-md-block">
        <svg viewBox="0 0 1440 100" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 0L60 10C120 20 240 40 360 40C480 40 600 20 720 20C840 20 960 40 1080 50C1200 60 1320 60 1380 60H1440V100H1380C1320 100 1200 100 1080 100C960 100 840 100 720 100C600 100 480 100 360 100C240 100 120 100 60 100H0V0Z" fill="#ffffff"/>
        </svg>
    </div>
</div>
@endsection

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <!-- Status Alert -->
                        @if($agenda->is_today)
                        <div class="alert alert-warning d-flex align-items-center mb-4" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <div>
                                <strong>Agenda Hari Ini!</strong> Kegiatan ini berlangsung hari ini.
                            </div>
                        </div>
                        @elseif($agenda->is_past)
                        <div class="alert alert-secondary d-flex align-items-center mb-4" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <div>
                                <strong>Agenda Selesai</strong> Kegiatan ini telah berlangsung.
                            </div>
                        </div>
                        @endif

                        <!-- Event Details -->
                        <div class="event-details mb-5">
                            <div class="detail-item mb-3">
                                <h5 class="detail-label"><i class="far fa-calendar-alt me-2"></i>Tanggal</h5>
                                <p class="detail-content">{{ $agenda->tanggal_formatted }}</p>
                            </div>
                            <div class="detail-item mb-3">
                                <h5 class="detail-label"><i class="far fa-clock me-2"></i>Waktu</h5>
                                <p class="detail-content">{{ $agenda->waktu_formatted }}</p>
                            </div>
                            <div class="detail-item mb-3">
                                <h5 class="detail-label"><i class="fas fa-map-marker-alt me-2"></i>Lokasi</h5>
                                <p class="detail-content">{{ $agenda->lokasi }}</p>
                            </div>
                            @if($agenda->kategori)
                            <div class="detail-item mb-3">
                                <h5 class="detail-label"><i class="fas fa-tag me-2"></i>Kategori</h5>
                                <p class="detail-content">
                                    <span class="badge bg-primary">{{ $agenda->kategori }}</span>
                                </p>
                            </div>
                            @endif
                        </div>

                        <!-- Description -->
                        <div class="content-section mb-5">
                            <h4 class="section-title mb-4">
                                <i class="fas fa-align-left me-2"></i>Deskripsi Kegiatan
                            </h4>
                            <div class="content-text">
                                {!! nl2br(e($agenda->deskripsi)) !!}
                            </div>
                        </div>

                        <!-- Additional Notes -->
                        @if($agenda->catatan)
                        <div class="content-section mb-5">
                            <h4 class="section-title mb-4">
                                <i class="fas fa-sticky-note me-2"></i>Catatan Tambahan
                            </h4>
                            <div class="alert alert-light">
                                {!! nl2br(e($agenda->catatan)) !!}
                            </div>
                        </div>
                        @endif

                        <!-- Back Button -->
                        <div class="d-flex justify-content-between align-items-center pt-4 mt-4 border-top">
                            <a href="{{ route('agenda') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Agenda
                            </a>
                            <div class="share-buttons">
                                <span class="me-2 text-muted">Bagikan:</span>
                                <span class="me-2">Bagikan:</span>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('agenda.detail', $agenda)) }}" 
                                   target="_blank" class="btn btn-sm btn-outline-primary me-2">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('agenda.detail', $agenda)) }}&text={{ urlencode($agenda->judul) }}" 
                                   target="_blank" class="btn btn-sm btn-outline-primary me-2">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="https://wa.me/?text={{ urlencode($agenda->judul . ' - ' . route('agenda.detail', $agenda)) }}" 
                                   target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <i class="fas fa-info-circle me-2 text-primary"></i>Informasi
                        </h5>
                        <ul class="list-unstyled">
                            @if($agenda->lokasi)
                            <li class="mb-3">
                                <div class="d-flex">
                                    <i class="fas fa-map-marker-alt text-primary mt-1 me-2"></i>
                                    <div>
                                        <h6 class="mb-1">Lokasi</h6>
                                        <p class="mb-0 text-muted">{{ $agenda->lokasi }}</p>
                                    </div>
                                </div>
                            </li>
                            @endif
                            <li class="mb-3">
                                <div class="d-flex">
                                    <i class="far fa-calendar-alt text-primary mt-1 me-2"></i>
                                    <div>
                                        <h6 class="mb-1">Tanggal</h6>
                                        <p class="mb-0 text-muted">
                                            {{ \Carbon\Carbon::parse($agenda->tanggal)->translatedFormat('l, d F Y') }}
                                        </p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex">
                                    <i class="far fa-clock text-primary mt-1 me-2"></i>
                                    <div>
                                        <h6 class="mb-1">Waktu</h6>
                                        <p class="mb-0 text-muted">
                                            {{ \Carbon\Carbon::parse($agenda->waktu_mulai)->format('H:i') }} - {{ $agenda->waktu_selesai ? \Carbon\Carbon::parse($agenda->waktu_selesai)->format('H:i') : 'Selesai' }}
                                        </p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                
                @if($relatedAgendas->count() > 0)
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <i class="fas fa-calendar-check me-2 text-primary"></i>Agenda Lainnya
                        </h5>
                        <div class="list-group list-group-flush">
                            @foreach($relatedAgendas as $related)
                            <a href="{{ route('agenda.show', $related->id) }}" class="list-group-item list-group-item-action border-0 px-0 py-3">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $related->judul }}</h6>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($related->tanggal)->format('d M') }}</small>
                                </div>
                                <small class="text-muted">
                                    <i class="far fa-clock me-1"></i>{{ \Carbon\Carbon::parse($related->waktu_mulai)->format('H:i') }}
                                </small>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
                @if($relatedAgendas->count() > 0)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-calendar-week me-2"></i>Agenda Lainnya
                        </h5>
                    </div>
                    <div class="list-group list-group-flush">
                        @foreach($relatedAgendas as $related)
                        <a href="{{ route('agenda.detail', $related) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">{{ $related->judul }}</h6>
                                <small class="text-muted">{{ $related->tanggal_formatted }}</small>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="far fa-clock me-1"></i>{{ $related->waktu_formatted }}
                                </small>
                                @if($related->kategori)
                                <span class="badge bg-primary">{{ $related->kategori }}</span>
                                @endif
                            </div>
                        </a>
                        @endforeach
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('agenda') }}" class="btn btn-sm btn-outline-primary">
                            Lihat Semua Agenda <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
                @endif

                <!-- Quick Links -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-link me-2"></i>Tautan Cepat
                        </h5>
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="{{ route('home') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-home me-2"></i>Beranda
                        </a>
                        <a href="{{ route('agenda') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-calendar-alt me-2"></i>Semua Agenda
                        </a>
                        <a href="#" class="list-group-item list-group-item-action" data-bs-toggle="modal" data-bs-target="#contactModal">
                            <i class="fas fa-envelope me-2"></i>Hubungi Kami
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('styles')
<style>
.hero-section {
    background: linear-gradient(135deg, var(--elunora-primary) 0%, #1e3a8a 100%);
    padding: 4rem 0;
    margin-bottom: 3rem;
    color: white;
}

.hero-icon {
    position: relative;
    z-index: 1;
}

.icon-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.content-text {
    line-height: 1.8;
    color: #444;
    font-size: 1.05rem;
}

.card {
    border: none;
    border-radius: 10px;
    margin-bottom: 1.5rem;
}

.card-header {
    border-radius: 10px 10px 0 0 !important;
    font-weight: 600;
    padding: 1rem 1.5rem;
}

.btn {
    border-radius: 6px;
    font-weight: 500;
    padding: 0.5rem 1.25rem;
}

.btn-sm {
    padding: 0.4rem 0.9rem;
    font-size: 0.875rem;
}

.badge {
    font-weight: 500;
    padding: 0.4em 0.8em;
    border-radius: 6px;
}

/* Responsive adjustments */
@media (max-width: 991px) {
    .hero-section {
        padding: 3rem 0;
    }
    
    .hero-section h1 {
        font-size: 2rem;
    }
    
    .icon-circle {
        width: 36px;
        height: 36px;
        font-size: 0.9rem;
    }
}

@media (max-width: 767px) {
    .hero-section {
        text-align: center;
        padding: 2.5rem 0;
    }
    
    .hero-section h1 {
        font-size: 1.75rem;
    }
    
    .content-text {
        font-size: 1rem;
    }
    
    .btn {
        width: 100%;
        margin-bottom: 0.5rem;
    }
}
</style>
@endsection

<script>
function copyToClipboard() {
    navigator.clipboard.writeText(window.location.href).then(function() {
        alert('Link berhasil disalin!');
    }, function(err) {
        console.error('Gagal menyalin link: ', err);
    });
}
</script>
@endsection
