@extends('layouts.app')

@section('title', $post->judul)

@section('hero')
<div class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="breadcrumb-nav mb-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('berita') }}" class="text-white-50">Berita</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">{{ Str::limit($post->judul, 30) }}</li>
                        </ol>
                    </nav>
                </div>
                <h1 class="display-5 fw-bold text-white mb-3">{{ $post->judul }}</h1>
                <div class="d-flex gap-3 mb-4">
                    <span class="badge bg-light text-dark fs-6 px-3 py-2">
                        <i class="fas fa-tag me-2"></i>{{ $post->kategori->nama_kategori }}
                    </span>
                    <span class="badge bg-light text-dark fs-6 px-3 py-2">
                        <i class="fas fa-calendar me-2"></i>{{ \Carbon\Carbon::parse($post->created_at)->format('d M Y') }}
                    </span>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="hero-icon">
                    <i class="fas fa-newspaper" style="font-size: 6rem; color: rgba(255, 255, 255, 0.2);"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Konten Berita -->
            <div class="col-lg-8">
                <article class="news-detail-card">
                    @if($post->gambar)
                    <div class="news-featured-image">
                        <img src="{{ asset($post->gambar) }}" class="featured-image" alt="{{ $post->judul }}" onerror="this.src='{{ asset('img/no-image.jpg') }}'">
                        <div class="image-overlay">
                            <span class="category-badge">{{ $post->kategori->nama_kategori ?? 'Umum' }}</span>
                        </div>
                    </div>
                    @endif
                    
                    <div class="news-detail-body">
                        <div class="news-meta mb-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="meta-info">
                                    <span class="meta-item">
                                        <i class="fas fa-calendar-alt me-2 text-primary"></i>
                                        {{ \Carbon\Carbon::parse($post->created_at)->format('d M Y') }}
                                    </span>
                                    <span class="meta-item ms-3">
                                        <i class="fas fa-user me-2 text-primary"></i>
                                        Admin
                                    </span>
                                </div>
                                <div class="share-quick">
                                    <button class="btn btn-outline-primary btn-sm" onclick="toggleShare()">
                                        <i class="fas fa-share-alt me-1"></i>Bagikan
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="news-content">
                            {!! $post->isi !!}
                        </div>
                        
                        <!-- Back Button -->
                        <div class="mt-4 pt-3 border-top">
                            <a href="{{ route('berita') }}" class="btn btn-outline-success">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Berita
                            </a>
                        </div>
                        
                        <!-- Galeri Foto Berita -->
                        @if($post->galeris->isNotEmpty() && $post->galeris->first()->fotos->count() > 1)
                        <div class="news-gallery mt-5">
                            <h4 class="gallery-title">
                                <i class="fas fa-images me-2 text-primary"></i>Galeri Foto
                            </h4>
                            <div class="row g-3 mt-2">
                                @foreach($post->galeris->first()->fotos as $foto)
                                <div class="col-md-4">
                                    <div class="gallery-item">
                                        <a href="{{ asset('storage/' . $foto->file) }}" data-lightbox="berita-gallery" data-title="{{ $foto->judul }}">
                                            <img src="{{ asset('storage/' . $foto->file) }}" class="gallery-image" alt="{{ $foto->judul }}" onerror="this.src='{{ asset('img/no-image.jpg') }}'">
                                            <div class="gallery-overlay">
                                                <i class="fas fa-search-plus"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        
                        <!-- Share Buttons -->
                        <div class="share-section mt-5" id="shareSection" style="display: none;">
                            <div class="share-header">
                                <h5><i class="fas fa-share-alt me-2 text-primary"></i>Bagikan Artikel Ini</h5>
                                <p class="text-muted">Sebarkan informasi ini kepada teman dan keluarga</p>
                            </div>
                            <div class="share-buttons">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('berita.detail', $post->id)) }}" target="_blank" class="share-btn facebook">
                                    <i class="fab fa-facebook-f"></i>
                                    <span>Facebook</span>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('berita.detail', $post->id)) }}&text={{ urlencode($post->judul) }}" target="_blank" class="share-btn twitter">
                                    <i class="fab fa-twitter"></i>
                                    <span>Twitter</span>
                                </a>
                                <a href="https://wa.me/?text={{ urlencode($post->judul . ' ' . route('berita.detail', $post->id)) }}" target="_blank" class="share-btn whatsapp">
                                    <i class="fab fa-whatsapp"></i>
                                    <span>WhatsApp</span>
                                </a>
                                <button class="share-btn copy" onclick="copyToClipboard('{{ route('berita.detail', $post->id) }}')">
                                    <i class="fas fa-copy"></i>
                                    <span>Salin Link</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Berita Terkait -->
                <div class="sidebar-card mb-4">
                    <div class="sidebar-header">
                        <h5 class="mb-0"><i class="fas fa-newspaper me-2"></i>Berita Terkait</h5>
                    </div>
                    <div class="card-body">
                        @if($relatedPosts->count() > 0)
                        <ul class="list-group list-group-flush">
                            @foreach($relatedPosts as $item)
                            <li class="list-group-item px-0">
                                <a href="{{ route('berita.detail', $item->id) }}" class="text-decoration-none">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            @if($item->galeris->isNotEmpty() && $item->galeris->first()->fotos->isNotEmpty())
                                            <img src="{{ asset('storage/' . $item->galeris->first()->fotos->first()->file) }}" class="rounded" width="60" height="60" alt="{{ $item->judul }}" onerror="this.src='{{ asset('img/no-image.jpg') }}'">
                                            @else
                                            <img src="{{ asset('img/no-image.jpg') }}" class="rounded" width="60" height="60" alt="No Image">
                                            @endif
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1">{{ Str::limit($item->judul, 50) }}</h6>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</small>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        @else
                        <p class="mb-0">Tidak ada berita terkait.</p>
                        @endif
                    </div>
                </div>
                
                <!-- Kategori Berita -->
                <div class="sidebar-card">
                    <div class="sidebar-header">
                        <h5 class="mb-0"><i class="fas fa-tags me-2"></i>Kategori Berita</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @php
                            $kategoris = \App\Models\Kategori::withCount(['posts' => function($query) {
                                $query->where('status', 'published');
                            }])->having('posts_count', '>', 0)->get();
                            @endphp
                            
                            @forelse($kategoris as $kategori)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $kategori->nama_kategori }}
                                <span class="badge bg-success rounded-pill">{{ $kategori->posts_count }}</span>
                            </li>
                            @empty
                            <li class="list-group-item">Tidak ada kategori</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
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

.breadcrumb {
    background: none;
    padding: 0;
    margin: 0;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "›";
    color: rgba(255, 255, 255, 0.6);
}

.news-detail-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    border: none;
}

.news-featured-image {
    position: relative;
    height: 400px;
    overflow: hidden;
}

.featured-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, rgba(0,0,0,0.3), transparent);
    display: flex;
    align-items: flex-start;
    justify-content: flex-end;
    padding: 2rem;
}

.category-badge {
    background: rgba(0, 123, 255, 0.9);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
}

.news-detail-body {
    padding: 1.5rem;
}

.news-meta {
    border-bottom: 1px solid #e9ecef;
    padding-bottom: 1rem;
}

.meta-item {
    color: #6c757d;
    font-size: 0.9rem;
    font-weight: 500;
}

.news-content {
    font-size: 1rem;
    line-height: 1.6;
    color: #2c3e50;
}

.news-content p {
    margin-bottom: 1rem;
}

.news-content h1, .news-content h2, .news-content h3 {
    color: #2c3e50;
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.gallery-title {
    color: #2c3e50;
    font-weight: 700;
    font-size: 1.5rem;
}

.gallery-item {
    position: relative;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.gallery-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.2);
}

.gallery-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.gallery-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 123, 255, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    color: white;
    font-size: 1.5rem;
}

.gallery-item:hover .gallery-overlay {
    opacity: 1;
}

.share-section {
    background: rgba(0, 123, 255, 0.05);
    border-radius: 15px;
    padding: 2rem;
    border: 1px solid rgba(0, 123, 255, 0.1);
}

.share-header h5 {
    color: #2c3e50;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.share-buttons {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.share-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.share-btn.facebook {
    background: #1877f2;
    color: white;
}

.share-btn.twitter {
    background: #1da1f2;
    color: white;
}

.share-btn.whatsapp {
    background: #25d366;
    color: white;
}

.share-btn.copy {
    background: #6c757d;
    color: white;
}

.share-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    color: white;
}

.sidebar-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    overflow: hidden;
    border: none;
}

.sidebar-header {
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: white;
    padding: 1.25rem;
    font-weight: 600;
}

@media (max-width: 768px) {
    .news-featured-image {
        height: 250px;
    }
    
    .news-detail-body {
        padding: 1.5rem;
    }
    
    .share-buttons {
        flex-direction: column;
    }
    
    .share-btn {
        justify-content: center;
    }
}
</style>
@endsection

@section('scripts')
<script>
function toggleShare() {
    const shareSection = document.getElementById('shareSection');
    if (shareSection.style.display === 'none') {
        shareSection.style.display = 'block';
        shareSection.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    } else {
        shareSection.style.display = 'none';
    }
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show success message
        const btn = event.target.closest('.share-btn');
        const originalText = btn.querySelector('span').textContent;
        btn.querySelector('span').textContent = 'Tersalin!';
        btn.style.background = '#28a745';
        
        setTimeout(() => {
            btn.querySelector('span').textContent = originalText;
            btn.style.background = '#6c757d';
        }, 2000);
    }).catch(function(err) {
        console.error('Could not copy text: ', err);
        alert('Gagal menyalin link');
    });
}
</script>
@endsection