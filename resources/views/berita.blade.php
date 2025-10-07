@extends('layouts.app')

@section('title', 'Berita')

@section('hero')
<div class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-4 fw-bold text-white mb-3">
                    <i class="fas fa-newspaper me-3"></i>Berita Terbaru
                </h1>
                <p class="lead mb-4 text-white">Informasi dan kegiatan terbaru dari sekolah kami</p>
                <div class="d-flex gap-3">
                    <span class="badge bg-light text-dark fs-6 px-3 py-2">
                        <i class="fas fa-clock me-2"></i>Update Terkini
                    </span>
                    <span class="badge bg-light text-dark fs-6 px-3 py-2">
                        <i class="fas fa-fire me-2"></i>Berita Populer
                    </span>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="hero-icon">
                    <i class="fas fa-newspaper" style="font-size: 8rem; color: rgba(255, 255, 255, 0.2);"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<section class="py-5">
    <div class="container" data-search-scope>
        <div class="row">
            <!-- Daftar Berita -->
            <div class="col-lg-8">
                <div class="mb-3">
                    <input type="text" class="form-control js-page-search" placeholder="Cari berita..." aria-label="Cari berita" data-target="article.news-card">
                </div>
                @forelse($posts as $berita)
                <article class="news-card mb-4">
                    <div class="row g-0 align-items-stretch">
                        <div class="col-md-4 h-100">
                            <div class="news-image-container h-100">
                                @if($berita->gambar)
                                <img src="{{ asset($berita->gambar) }}" class="news-image" alt="{{ $berita->judul }}">
                                @else
                                <img src="{{ asset('img/no-image.jpg') }}" class="news-image" alt="No Image">
                                @endif
                                <div class="news-overlay">
                                    <i class="fas fa-eye"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="news-content p-4 d-flex flex-column h-100">
                                <div class="news-meta mb-3">
                                    <span class="badge bg-primary">{{ $berita->kategori->nama_kategori }}</span>
                                    <small class="text-muted ms-2">
                                        <i class="fas fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($berita->created_at)->format('d M Y') }}
                                    </small>
                                </div>
                                <h4 class="news-title mb-3">{{ $berita->judul }}</h4>
                                <p class="news-excerpt mb-4">{{ Str::limit(strip_tags($berita->isi), 150) }}</p>
                                <div class="news-actions mt-auto">
                                    <a href="{{ route('berita.detail', $berita->id) }}" class="btn btn-primary">
                                        <i class="fas fa-arrow-right me-2"></i>Baca Selengkapnya
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                @empty
                <div class="empty-state text-center py-5">
                    <i class="fas fa-newspaper" style="font-size: 4rem; color: #dee2e6; margin-bottom: 1rem;"></i>
                    <h4 class="text-muted">Belum Ada Berita</h4>
                    <p class="text-muted">Berita terbaru akan ditampilkan di sini ketika sudah dipublikasikan.</p>
                </div>
                @endforelse
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $posts->links() }}
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Kategori Berita -->
                <div class="sidebar-card mb-4">
                    <div class="sidebar-header">
                        <h5 class="mb-0"><i class="fas fa-tags me-2"></i>Kategori Berita</h5>
                    </div>
                    <div class="card-body">
                        @php
                        $kategoris = \App\Models\Kategori::withCount(['posts' => function($query) {
                            $query->where('status', 'published');
                        }])->having('posts_count', '>', 0)->get();
                        @endphp
                        
                        <ul class="list-group list-group-flush">
                            @forelse($kategoris as $kategori)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                {{ $kategori->nama_kategori }}
                                <span class="badge bg-success rounded-pill">{{ $kategori->posts_count }}</span>
                            </li>
                            @empty
                            <li class="list-group-item px-0">Tidak ada kategori</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
                
                <!-- Berita Populer -->
                <div class="sidebar-card">
                    <div class="sidebar-header">
                        <h5 class="mb-0"><i class="fas fa-fire me-2"></i>Berita Terbaru</h5>
                    </div>
                    <div class="card-body">
                        @php
                        $beritaTerbaru = \App\Models\Post::where('status', 'published')
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();
                        @endphp
                        
                        <ul class="list-group list-group-flush">
                            @forelse($beritaTerbaru as $item)
                            <li class="list-group-item px-0">
                                <a href="{{ route('berita.detail', $item->id) }}" class="text-decoration-none">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            @if($item->gambar)
                                            <img src="{{ asset($item->gambar) }}" class="rounded" width="60" height="60" alt="{{ $item->judul }}" style="object-fit: cover;">
                                            @else
                                            <img src="{{ asset('img/no-image.jpg') }}" class="rounded" width="60" height="60" alt="No Image" style="object-fit: cover;">
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ Str::limit($item->judul, 50) }}</h6>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</small>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            @empty
                            <li class="list-group-item px-0">Belum ada berita</li>
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

.news-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    border: none;
}

.news-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

.news-image-container {
    position: relative;
    height: 100%;
    min-height: 200px;
    overflow: hidden;
    display: flex;
    align-self: stretch;
    width: 100%;
}

.news-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
    display: block;
    flex: 1 1 auto;
}

/* Make sure the image gets the left rounded corners only, to match the card */
.news-card .news-image-container img {
    border-top-left-radius: 15px;
    border-bottom-left-radius: 15px;
}

.news-card:hover .news-image {
    transform: scale(1.05);
}

.news-overlay {
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

.news-card:hover .news-overlay {
    opacity: 1;
}

.news-content {
    padding: 1.5rem;
}

.news-title {
    color: #2c3e50;
    font-weight: 700;
    line-height: 1.3;
}

.news-excerpt {
    color: #6c757d;
    line-height: 1.6;
}

.news-meta .badge {
    font-size: 0.75rem;
    padding: 0.5rem 1rem;
    margin-bottom: 1rem;
}

.news-actions {
    margin-top: auto;
}

.card {
    border-radius: 15px;
    border: none;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.card-body {
    padding: 1.5rem;
}

.card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 15px 15px 0 0 !important;
    padding: 1.25rem 1.5rem;
}

.card-title {
    margin-bottom: 1rem;
    font-size: 1.25rem;
    line-height: 1.4;
}

.card-text {
    line-height: 1.6;
    margin-bottom: 1rem;
    font-size: 1rem;
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

.list-group-item {
    padding: 1rem 0;
    border-radius: 0;
    line-height: 1.5;
    font-size: 1rem;
}

.list-group-item:first-child {
    border-top-left-radius: 0;
    border-top-right-radius: 0;
}

.list-group-item:last-child {
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
}

.flex-shrink-0 {
    margin-right: 1rem;
}

.flex-grow-1 h6 {
    margin-bottom: 0.5rem;
    line-height: 1.4;
}

.empty-state {
    padding: 3rem 0;
}

@media (max-width: 768px) {
    .news-image-container {
        height: 150px;
        min-height: 150px;
    }

    /* On mobile, round all corners since it stacks above content */
    .news-card .news-image-container img {
        border-top-right-radius: 15px;
        border-bottom-left-radius: 0;
    }
    
    .news-content {
        padding: 1.5rem;
    }
}

/* Equal height layout using Flex (more reliable with Bootstrap rows) */
.news-card > .row.g-0.align-items-stretch {
    display: flex;
    align-items: stretch;
}

.news-card > .row.g-0.align-items-stretch > [class^="col-"],
.news-card > .row.g-0.align-items-stretch > [class*=" col-"] {
    display: flex;
    align-items: stretch;
}

.news-card > .row.g-0.align-items-stretch .news-image-container,
.news-card > .row.g-0.align-items-stretch .news-content {
    height: 100%;
    width: 100%;
}

/* Mobile: stack naturally */
@media (max-width: 991.98px) {
    .news-card > .row.g-0.align-items-stretch {
        display: block;
    }
}
</style>
@endsection