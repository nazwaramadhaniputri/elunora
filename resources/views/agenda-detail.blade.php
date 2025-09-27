@extends('layouts.app')

@section('title', $agenda->judul)

@section('hero')
<div class="row align-items-center">
    <div class="col-md-8">
        <div class="breadcrumb-nav mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('agenda') }}" class="text-white-50">Agenda</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">{{ Str::limit($agenda->judul, 30) }}</li>
                </ol>
            </nav>
        </div>
        <h1 class="display-5 fw-bold text-white mb-3">{{ $agenda->judul }}</h1>
        <div class="d-flex gap-3 mb-2 flex-wrap">
            <span class="badge bg-light text-dark fs-6 px-3 py-2">
                <i class="far fa-calendar-alt me-2"></i>{{ \Carbon\Carbon::parse($agenda->tanggal)->translatedFormat('l, d F Y') }}
            </span>
            <span class="badge bg-light text-dark fs-6 px-3 py-2">
                <i class="far fa-clock me-2"></i>{{ \Carbon\Carbon::parse($agenda->waktu_mulai)->format('H:i') }} - {{ $agenda->waktu_selesai ? \Carbon\Carbon::parse($agenda->waktu_selesai)->format('H:i') : 'Selesai' }}
            </span>
            @if($agenda->kategori)
            <span class="badge bg-light text-dark fs-6 px-3 py-2">
                <i class="fas fa-tag me-2"></i>{{ $agenda->kategori }}
            </span>
            @endif
        </div>
    </div>
    <div class="col-md-4 text-center">
        <div class="hero-icon">
            <i class="fas fa-calendar-alt" style="font-size: 6rem; color: rgba(255, 255, 255, 0.2);"></i>
        </div>
    </div>
</div>
@endsection

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <article class="agenda-detail-card">
                    <div class="agenda-detail-body">
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

                        <!-- Meta row -->
                        <div class="agenda-meta mb-4">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                <div class="meta-info d-flex align-items-center flex-wrap gap-3">
                                    <span class="meta-item"><i class="far fa-calendar-alt me-2 text-primary"></i>{{ $agenda->tanggal_formatted }}</span>
                                    <span class="meta-item"><i class="far fa-clock me-2 text-primary"></i>{{ $agenda->waktu_formatted }}</span>
                                    @if($agenda->lokasi)
                                    <span class="meta-item"><i class="fas fa-map-marker-alt me-2 text-primary"></i>{{ $agenda->lokasi }}</span>
                                    @endif
                                    @if($agenda->kategori)
                                    <span class="badge bg-primary align-self-center">{{ $agenda->kategori }}</span>
                                    @endif
                                </div>
                                <div class="share-quick">
                                    <button class="btn btn-outline-primary btn-sm" onclick="copyToClipboard()">
                                        <i class="fas fa-share-alt me-1"></i>Bagikan
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="agenda-content">
                            {!! nl2br(e($agenda->deskripsi)) !!}
                            @if($agenda->catatan)
                            <div class="alert alert-light mt-4">{!! nl2br(e($agenda->catatan)) !!}</div>
                            @endif
                        </div>

                        <!-- Back Button -->
                        <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center">
                            <a href="{{ route('agenda') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Agenda
                            </a>
                            <div class="share-buttons">
                                <span class="me-2 text-muted">Bagikan:</span>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('agenda.show', $agenda->id)) }}" 
                                   target="_blank" class="btn btn-sm btn-outline-primary me-2">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('agenda.show', $agenda->id)) }}&text={{ urlencode($agenda->judul) }}" 
                                   target="_blank" class="btn btn-sm btn-outline-primary me-2">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="https://wa.me/?text={{ urlencode($agenda->judul . ' - ' . route('agenda.show', $agenda->id)) }}" 
                                   target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="sidebar-card mb-4">
                    <div class="sidebar-header">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi</h5>
                    </div>
                    <div class="card-body">
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
                
                <!-- Removed 'Agenda Lainnya' blocks as requested -->
            </div>
        </div>
    </div>
</section>

@endsection

@section('styles')
<style>
/* Hero icon tweaks (use layout hero styles; no override on .hero-section here) */
.hero-icon { position: relative; z-index: 1; }

/* Main detail card (match Berita detail proportions) */
.agenda-detail-card {
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    border: none;
}
.agenda-detail-body { padding: 1.5rem; }

/* Meta row */
.agenda-meta { border-bottom: 1px solid #e9ecef; padding-bottom: 1rem; }
.meta-item { color: #6c757d; font-size: 0.95rem; font-weight: 500; }

/* Content typography */
.agenda-content { font-size: 1rem; line-height: 1.7; color: #2c3e50; }
.agenda-content p { margin-bottom: 1rem; }
.agenda-content h1, .agenda-content h2, .agenda-content h3 { color: #2c3e50; margin: 1.5rem 0 1rem; }

/* Sidebar cards (reuse Berita sidebar look) */
.sidebar-card { background: #fff; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.08); overflow: hidden; border: none; }
.sidebar-header { background: linear-gradient(135deg, #007bff, #0056b3); color: #fff; padding: 1.25rem; font-weight: 600; }
.sidebar-card .card-body { padding: 1.25rem 1.25rem 1.5rem; }

/* Common controls */
.btn { border-radius: 999px; font-weight: 600; padding: 0.5rem 1.25rem; }
.btn-sm { padding: 0.4rem 0.9rem; font-size: 0.875rem; }
.badge { font-weight: 600; padding: 0.45em 0.95em; border-radius: 999px; }

/* Responsive */
@media (max-width: 991px) {
    .hero-icon i { font-size: 4rem !important; }
}
@media (max-width: 767px) {
    .btn { width: 100%; margin-bottom: 0.5rem; }
}
</style>
@endsection

@section('scripts')
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
