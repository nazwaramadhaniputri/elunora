@extends('layouts.app')

@section('title', $galeri->post->judul)

@section('hero')
<div class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('galeri') }}" class="text-white-50">Galeri</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ Str::limit($galeri->post->judul, 30) }}</li>
                    </ol>
                </nav>
                <h1 class="display-4 fw-bold mb-3">{{ $galeri->post->judul }}</h1>
                <div class="d-flex gap-3 mb-3">
                    <span class="badge bg-success fs-6 px-3 py-2">
                        <i class="fas fa-images me-2"></i>{{ $galeri->fotos->count() }} Foto
                    </span>
                    <span class="badge bg-success fs-6 px-3 py-2">
                        <i class="fas fa-calendar me-2"></i>{{ \Carbon\Carbon::parse($galeri->post->created_at)->format('d M Y') }}
                    </span>
                </div>
                <p class="lead mb-0">{{ Str::limit(strip_tags($galeri->post->isi), 120) }}</p>
            </div>
            <div class="col-md-4 text-center">
                <div class="hero-stats">
                    <div class="stat-circle">
                        <div class="stat-number">{{ $galeri->fotos->count() }}</div>
                        <div class="stat-label">Foto</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<section class="py-5 fade-in">
    <div class="container">
        
        <!-- Back Button -->
        <div class="row mb-4">
            <div class="col-12">
                <a href="{{ route('galeri') }}" class="btn btn-outline-success">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Galeri
                </a>
            </div>
        </div>

        <!-- Gallery Photos -->
        <div class="text-box">
            <div class="row gallery-photos">
                @forelse($galeri->fotos as $foto)
                <div class="col-md-4 col-lg-3 mb-4">
                    <div class="gallery-photo-item">
                        <div class="photo-container">
                            <img src="{{ asset($foto->file) }}" 
                                 alt="{{ $foto->judul }}" 
                                 class="img-fluid gallery-photo"
                                 onerror="this.src='{{ asset('img/no-image.jpg') }}'">
                            <div class="photo-overlay">
                                <div class="photo-actions">
                                    <a href="{{ asset($foto->file) }}" 
                                       data-lightbox="gallery" 
                                       data-title="{{ $foto->judul }}" 
                                       class="btn btn-light btn-sm me-2">
                                        <i class="fas fa-expand"></i>
                                    </a>
                                    <button class="btn btn-success btn-sm" onclick="downloadImage('{{ asset($foto->file) }}', '{{ $foto->judul }}')">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="photo-info">
                            <h6 class="photo-title">{{ $foto->judul }}</h6>
                            <small class="text-muted">Foto {{ $loop->iteration }} dari {{ $galeri->fotos->count() }}</small>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-camera" style="font-size: 4rem; color: #dee2e6; margin-bottom: 1rem;"></i>
                        <h4 class="text-muted">Belum Ada Foto</h4>
                        <p class="text-muted">Foto akan ditampilkan di sini ketika sudah diupload.</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
        
        <!-- Related Galleries -->
        <div class="row mt-5">
            <div class="col-md-12 mb-4">
                <div class="section-header">
                    <h3><i class="fas fa-images me-2 text-success"></i>Galeri Lainnya</h3>
                    <p class="text-muted">Jelajahi galeri foto lainnya yang menarik</p>
                </div>
            </div>
            
            @php
            $galeriLainnya = \App\Models\Galeri::with('fotos', 'post')
                ->where('status', 1)
                ->where('id', '!=', $galeri->id)
                ->orderBy('position', 'asc')
                ->take(3)
                ->get();
            @endphp
            
            @forelse($galeriLainnya as $item)
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="related-gallery-card h-100">
                    <div class="related-image-container">
                        @if($item->fotos->isNotEmpty())
                        <img src="{{ asset($item->fotos->first()->file) }}" 
                             class="related-image" 
                             alt="{{ $item->fotos->first()->judul }}"
                             onerror="this.src='{{ asset('img/no-image.jpg') }}'">
                        @else
                        <img src="{{ asset('img/no-image.jpg') }}" class="related-image" alt="No Image">
                        @endif
                        <div class="related-overlay">
                            <a href="{{ route('galeri.detail', $item->id) }}" class="btn btn-light">
                                <i class="fas fa-eye me-1"></i>Lihat Galeri
                            </a>
                        </div>
                        <div class="related-badge">
                            <span class="badge bg-success">{{ $item->fotos->count() }} foto</span>
                        </div>
                    </div>
                    <div class="related-content">
                        <h5 class="related-title">{{ Str::limit($item->post->judul, 40) }}</h5>
                        <p class="related-date text-muted">
                            <i class="fas fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($item->post->created_at)->format('d M Y') }}
                        </p>
                        <a href="{{ route('galeri.detail', $item->id) }}" class="btn btn-success btn-sm w-100">
                            <i class="fas fa-arrow-right me-1"></i>Lihat Galeri
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-4">
                <div class="empty-state">
                    <i class="fas fa-images" style="font-size: 3rem; color: #dee2e6; margin-bottom: 1rem;"></i>
                    <p class="text-muted">Tidak ada galeri lainnya saat ini.</p>
                </div>
            </div>
            @endforelse
        </div>
        
        <!-- Share Buttons -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="share-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h5 class="mb-0"><i class="fas fa-share-alt me-2 text-success"></i>Bagikan Galeri Ini</h5>
                                <p class="text-muted mb-0">Sebarkan keindahan momen ini</p>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('galeri.detail', $galeri->id)) }}" target="_blank" class="btn btn-facebook">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('galeri.detail', $galeri->id)) }}&text={{ urlencode($galeri->post->judul) }}" target="_blank" class="btn btn-twitter">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="https://wa.me/?text={{ urlencode($galeri->post->judul . ' ' . route('galeri.detail', $galeri->id)) }}" target="_blank" class="btn btn-whatsapp">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                    <button class="btn btn-secondary" onclick="copyToClipboard('{{ route('galeri.detail', $galeri->id) }}')">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
<style>
.stat-circle {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: #007bff;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    box-shadow: 0 10px 30px rgba(0, 123, 255, 0.3);
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: white;
    line-height: 1;
}

.stat-label {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.8);
    margin-top: 0.2rem;
}

.description-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    border: none;
    overflow: hidden;
}

.description-content {
    font-size: 1.1rem;
    line-height: 1.7;
    color: var(--dark-text);
}

.gallery-info {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 500;
}

.info-item i {
    font-size: 1.2rem;
}

.section-header {
    text-align: center;
    margin-bottom: 2rem;
}

.section-header h3 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.photo-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.photo-card.seamless {
    border-radius: 0;
    box-shadow: none;
    background: transparent;
}

.photo-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.2);
}

.photo-card.seamless:hover {
    transform: scale(1.02);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.photo-container {
    position: relative;
    height: 350px;
    overflow: hidden;
}

.photo-image {
    width: 100%;
    height: 350px;
    object-fit: cover;
    transition: all 0.4s ease;
}

.animate-photo {
    animation: photoFloat 6s ease-in-out infinite;
}

.photo-image:hover {
    transform: scale(1.08) rotate(1deg);
    box-shadow: 0 15px 35px rgba(0,0,0,0.3);
}

@keyframes photoFloat {
    0%, 100% { 
        transform: translateY(0px) scale(1);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    50% { 
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    }
}

.photo-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.photo-card:hover .photo-overlay {
    opacity: 1;
}

.photo-actions {
    display: flex;
    gap: 0.5rem;
}

.photo-info {
    padding: 1rem;
    text-align: center;
}

.photo-title {
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--dark-text);
}

.related-gallery-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.related-gallery-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.2);
}

.related-image-container {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.related-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.related-gallery-card:hover .related-image {
    transform: scale(1.05);
}

.related-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.related-gallery-card:hover .related-overlay {
    opacity: 1;
}

.related-badge {
    position: absolute;
    top: 10px;
    right: 10px;
}

.related-content {
    padding: 1.5rem;
}

.related-title {
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--dark-text);
}

.related-date {
    font-size: 0.9rem;
    margin-bottom: 1rem;
}

.share-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    border: none;
}

.btn-facebook {
    background: #1877f2;
    border: none;
    color: white;
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.btn-facebook:hover {
    background: #166fe5;
    transform: translateY(-2px);
    color: white;
}

.btn-twitter {
    background: #1da1f2;
    border: none;
    color: white;
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.btn-twitter:hover {
    background: #1a91da;
    transform: translateY(-2px);
    color: white;
}

.btn-whatsapp {
    background: #25d366;
    border: none;
    color: white;
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.btn-whatsapp:hover {
    background: #22c55e;
    transform: translateY(-2px);
    color: white;
}

.breadcrumb {
    background: transparent;
    padding: 0;
}

.breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255, 255, 255, 0.5);
}

@media (max-width: 768px) {
    .photo-container {
        height: 200px;
    }
    
    .related-image-container {
        height: 150px;
    }
    
    .stat-circle {
        width: 80px;
        height: 80px;
    }
    
    .stat-number {
        font-size: 1.5rem;
    }
}
</style>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<script>
    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true,
        'imageFadeDuration': 300,
        'positionFromTop': 50
    });
    
    function downloadImage(url, filename) {
        const link = document.createElement('a');
        link.href = url;
        link.download = filename;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
    
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            // Show success message
            const btn = event.target.closest('button');
            const originalIcon = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-check"></i>';
            btn.classList.add('btn-success');
            btn.classList.remove('btn-secondary');
            
            setTimeout(() => {
                btn.innerHTML = originalIcon;
                btn.classList.remove('btn-success');
                btn.classList.add('btn-secondary');
            }, 2000);
        });
    }
</script>
@endsection