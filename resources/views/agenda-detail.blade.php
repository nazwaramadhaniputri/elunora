@extends('layouts.app')

@section('title', $agenda->judul)

@section('hero')
<div class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="breadcrumb-wrapper mb-3 text-start">
                    <div class="d-inline-block">
                        <a href="{{ route('home') }}" class="text-decoration-none text-white-50 me-2">Beranda</a>
                        <span class="text-white-50 mx-2">/</span>
                        <a href="{{ route('agenda') }}" class="text-decoration-none text-white-50 me-2">Agenda</a>
                        <span class="text-white-50 mx-2">/</span>
                        <span class="text-white">{{ Str::limit($agenda->judul, 30) }}</span>
                    </div>
                </div>
                <h1 class="display-4 fw-bold text-white mb-4">
                    {{ $agenda->judul }}
                </h1>
                <div class="d-flex gap-3">
                    <span class="badge bg-light text-dark fs-6 px-3 py-2 rounded-pill">
                        <i class="far fa-calendar-alt me-2"></i>{{ \Carbon\Carbon::parse($agenda->tanggal)->translatedFormat('l, d F Y') }}
                    </span>
                    <span class="badge bg-light text-dark fs-6 px-3 py-2 rounded-pill">
                        <i class="far fa-clock me-2"></i>{{ \Carbon\Carbon::parse($agenda->waktu_mulai)->format('H:i') }} - {{ $agenda->waktu_selesai ? \Carbon\Carbon::parse($agenda->waktu_selesai)->format('H:i') : 'Selesai' }}
                    </span>
                    @if($agenda->kategori)
                    <span class="badge bg-light text-dark fs-6 px-3 py-2 rounded-pill">
                        <i class="fas fa-tag me-2"></i>{{ $agenda->kategori }}
                    </span>
                    @endif
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
<section class="py-5 fade-in">
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
.hero-section {
    background: linear-gradient(135deg, var(--elunora-primary), var(--elunora-primary-dark));
    padding: 4rem 0 3rem;
    position: relative;
    overflow: hidden;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M54.627 0l.366.366c-1.049 1.05-1.098 2.331-1.098 3.516 0 .47.016.94.098 1.386l-2.148 2.149A5.005 5.005 0 0050 5c-2.761 0-5 2.239-5 5 0 .338.034.669.1.988l-2.138 2.137A9.017 9.017 0 0041 13c-4.971 0-9 4.029-9 9 0 .338.019.672.057 1H11v2h21.057a9.05 9.05 0 000 2H11v2h21.057a9.05 9.05 0 000 2H11v2h21.057c.038.328.057.662.057 1 0 4.971 4.029 9 9 9 1.374 0 2.687-.315 3.859-.885l2.137 2.137c-.319.066-.65.1-.988.1-1.185 0-2.366-.049-3.516 1.098L60 54.628 54.627 60l-.366-.366c-1.049-1.05-1.098-2.331-1.098-3.516 0-.47.016-.94.098-1.386l-2.148-2.149A5.005 5.005 0 0050 55c-2.761 0-5-2.239-5-5 0-.338.034-.669.1-.988l-2.138-2.137A9.017 9.017 0 0041 47c-3.86 0-7.07-2.814-7.688-6.51l-2.245 2.246c.317.065.627.155.933.265 1.374.491 2.6 1.343 3.56 2.468l-2.138 2.137A9.05 9.05 0 0035 50c0 .338-.019.672-.057 1H59v-2H34.943a9.05 9.05 0 000-2H59v-2H34.943a9.05 9.05 0 000-2H59v-2H34.943A9.05 9.05 0 0035 41c0-.338-.019-.672-.057-1H59v-2H34.943a9.05 9.05 0 000-2H59v-2H34.943a9.05 9.05 0 00-.1-.988l2.138-2.137C38.93 29.814 42.14 27 46 27c1.374 0 2.687.315 3.859.885l2.137-2.137c-.319-.066-.65-.1-.988-.1-1.185 0-2.366.049-3.516-1.098L54.627 0zM50 7c1.657 0 3 1.343 3 3s-1.343 3-3 3-3-1.343-3-3 1.343-3 3-3zm-9 36c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7z' fill='%23ffffff' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
    opacity: 0.6;
    z-index: 0;
}

.hero-section .container {
    position: relative;
    z-index: 1;
}

.hero-section h1 {
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    font-weight: 700;
}

.hero-section .breadcrumb {
    background: rgba(255, 255, 255, 0.1);
    padding: 0.75rem 1rem;
    border-radius: 0.5rem;
    display: inline-block;
}

.hero-section .breadcrumb-item a {
    color: rgba(255, 255, 255, 0.8) !important;
    text-decoration: none;
    transition: color 0.2s;
}

.hero-section .breadcrumb-item a:hover {
    color: white !important;
    text-decoration: underline;
}

.hero-section .breadcrumb-item.active {
    color: white !important;
    font-weight: 500;
}

.hero-section .breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255, 255, 255, 0.6);
}

.hero-icon i {
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
    transition: transform 0.3s ease;
}

.hero-icon i:hover {
    transform: scale(1.05);
}

/* Animations */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.fade-in {
    animation: fadeIn 0.6s ease-out forwards;
}

/* Agenda Detail */
.agenda-detail-card {
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    overflow: hidden;
    border: none;
    margin-bottom: 2rem;
}

.agenda-detail-body { 
    padding: 2.5rem; 
}

.agenda-content {
    line-height: 1.8;
    color: #4b5563;
    font-size: 1.05rem;
}

.agenda-content p { 
    margin-bottom: 1.5rem;
    text-align: justify;
}

.agenda-content img { 
    max-width: 100%; 
    height: auto; 
    border-radius: 12px; 
    margin: 1.5rem 0; 
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.agenda-content h2, 
.agenda-content h3, 
.agenda-content h4 { 
    color: #1e293b;
    margin: 2rem 0 1.25rem;
    font-weight: 700;
}

.agenda-content ul, 
.agenda-content ol { 
    padding-left: 2rem;
    margin-bottom: 1.5rem;
}

.agenda-content li { 
    margin-bottom: 0.75rem;
    position: relative;
}

.agenda-content ul li::before {
    content: '•';
    color: var(--elunora-primary);
    font-weight: bold;
    display: inline-block;
    width: 1em;
    margin-left: -1em;
}

.agenda-meta {
    background: #f8fafc;
    padding: 1.5rem;
    border-radius: 0.75rem;
    margin-bottom: 2rem;
    border: 1px solid #e2e8f0;
}

.meta-item {
    display: flex;
    align-items: center;
    color: #4b5563;
    margin-bottom: 0.75rem;
    font-size: 0.95rem;
}

.meta-item i {
    width: 24px;
    color: var(--elunora-primary);
    text-align: center;
    margin-right: 0.75rem;
}

/* Sidebar */
.sidebar-card { 
    background: #fff; 
    border-radius: 12px; 
    box-shadow: 0 5px 20px rgba(0,0,0,0.05); 
    overflow: hidden; 
    border: 1px solid #e2e8f0;
    margin-bottom: 1.5rem;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.sidebar-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.sidebar-header { 
    background: linear-gradient(135deg, var(--elunora-primary), var(--elunora-primary-dark)); 
    color: #fff; 
    padding: 1.25rem; 
    font-weight: 600;
    font-size: 1.1rem;
}

.sidebar-card .card-body { 
    padding: 1.5rem; 
}

/* Common controls */
.btn { 
    border-radius: 8px; 
    font-weight: 600; 
    padding: 0.6rem 1.5rem;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.btn i {
    margin-right: 0.5rem;
}

.btn-outline-primary {
    border-color: var(--elunora-primary);
    color: var(--elunora-primary);
}

.btn-outline-primary:hover {
    background-color: var(--elunora-primary);
    border-color: var(--elunora-primary);
}

.btn-sm { 
    padding: 0.5rem 1rem; 
    font-size: 0.875rem; 
}

.badge { 
    font-weight: 600; 
    padding: 0.5em 1em; 
    border-radius: 8px;
    font-size: 0.85rem;
    letter-spacing: 0.3px;
}

/* Responsive */
@media (max-width: 991px) {
    .hero-section {
        padding: 3rem 0 2rem;
    }
    
    .hero-icon i { 
        font-size: 6rem !important; 
    }
    
    .agenda-detail-body {
        padding: 1.75rem;
    }
}

@media (max-width: 767px) {
    .hero-section {
        text-align: center;
        padding: 2.5rem 0 1.5rem;
    }
    
    .hero-section .breadcrumb {
        margin: 0 auto 1.5rem;
    }
    
    .hero-section h1 {
        font-size: 1.8rem;
    }
    
    .hero-section .lead {
        font-size: 1.1rem;
    }
    
    .btn { 
        width: 100%; 
        margin-bottom: 0.75rem; 
    }
    
    .agenda-detail-body {
        padding: 1.5rem;
    }
    
    .agenda-content {
        font-size: 1rem;
    }
}

/* Responsive */
.hero-bg {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 50%;
    background: linear-gradient(135deg, #1e3a8a 0%, #0f172a 100%);
    z-index: 0;
}

.hero {
    position: relative;
    padding: 2rem 0;
    background: white;
}

.hero h1 {
    color: #1e3a8a;
    font-weight: 700;
    margin-bottom: 1.5rem;
}

.breadcrumb {
    background-color: rgba(30, 58, 138, 0.1);
    padding: 0.75rem 1rem;
    border-radius: 0.5rem;
    margin-bottom: 1.5rem;
}

.breadcrumb-item a {
    color: #1e3a8a !important;
    text-decoration: none;
    transition: color 0.2s;
    font-weight: 500;
}

.breadcrumb-item a:hover {
    color: #0f172a !important;
    text-decoration: underline;
}

.breadcrumb-item.active {
    color: #4b5563 !important;
    font-weight: 500;
}

.hero-icon i {
    color: rgba(30, 58, 138, 0.1);
    font-size: 6rem;
}

.agenda-meta {
    background: #f8fafc;
    padding: 1.5rem;
    border-radius: 0.75rem;
    margin-bottom: 2rem;
    border: 1px solid #e2e8f0;
}

.meta-item {
    display: flex;
    align-items: center;
    color: #4b5563;
    margin-bottom: 0.5rem;
}

.meta-item i {
    margin-right: 0.5rem;
    color: #1e3a8a;
}

@media (max-width: 991px) {
    .hero-icon i { font-size: 4rem !important; }
}

@media (max-width: 767px) {
    .btn { width: 100%; margin-bottom: 0.5rem; }
    .hero {
        padding: 2rem 0;
    }
    .hero h1 {
        font-size: 1.8rem;
    }
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
