@extends('layouts.app')

@section('title', 'Kategori')

@section('hero')
<div class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-4 fw-bold text-white mb-3">
                    <i class="fas fa-tags me-3"></i>Kategori
                </h1>
                <p class="lead mb-4 text-white">Jelajahi konten berdasarkan kategori yang tersedia</p>
                <div class="d-flex gap-3">
                    <span class="badge bg-light text-dark fs-6 px-3 py-2">
                        <i class="fas fa-newspaper me-2"></i>Berita
                    </span>
                    <span class="badge bg-light text-dark fs-6 px-3 py-2">
                        <i class="fas fa-images me-2"></i>Galeri
                    </span>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="hero-icon">
                    <i class="fas fa-tags" style="font-size: 8rem; color: rgba(255, 255, 255, 0.2);"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12">
                <div class="position-relative">
                    <input type="text" class="form-control js-page-search" id="searchKategori" placeholder="Cari kategori..." style="padding-right: 50px; border-radius: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <span class="position-absolute" style="top: 50%; right: 20px; transform: translateY(-50%);">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <h2 class="mb-4">Semua Kategori</h2>
                
                <div class="row" id="kategoriContainer">
                    @forelse($kategoris as $kategori)
                    <div class="col-md-6 mb-4 kategori-item">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="card-title mb-0">{{ $kategori->nama_kategori }}</h5>
                                    <span class="badge bg-primary">
                                        <i class="fas fa-newspaper me-1"></i>{{ $kategori->posts_count }}
                                    </span>
                                </div>
                                <p class="card-text text-muted">Lihat semua berita dalam kategori ini</p>
                                <a href="{{ route('kategori.show', $kategori->id) }}" class="btn btn-primary mt-2" style="border-radius: 30px;">
                                    Lihat Berita <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-5">
                        <div class="empty-state">
                            <i class="fas fa-tags" style="font-size: 4rem; color: #dee2e6; margin-bottom: 1rem;"></i>
                            <h4 class="text-muted">Belum Ada Kategori</h4>
                            <p class="text-muted">Kategori akan ditampilkan di sini ketika sudah ditambahkan.</p>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="sidebar-card mb-4">
                    <div class="sidebar-card-header">
                        <h5><i class="fas fa-chart-pie me-2"></i>Statistik Kategori</h5>
                    </div>
                    <div class="sidebar-card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span>Total Kategori</span>
                            <span class="badge bg-primary">{{ $kategoris->count() }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Total Berita</span>
                            <span class="badge bg-success">{{ $totalBerita }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="sidebar-card">
                    <div class="sidebar-card-header">
                        <h5><i class="fas fa-newspaper me-2"></i>Berita Terbaru</h5>
                    </div>
                    <div class="sidebar-card-body">
                        <ul class="list-unstyled">
                            @foreach($latestPosts as $post)
                            <li class="sidebar-list-item">
                                <a href="{{ route('berita.show', $post->id) }}" class="d-flex align-items-center">
                                    @if($post->gambar)
                                    <div class="sidebar-thumbnail">
                                        <img src="{{ asset($post->gambar) }}" alt="{{ $post->judul }}">
                                    </div>
                                    @else
                                    <div class="sidebar-thumbnail bg-light d-flex align-items-center justify-content-center">
                                        <i class="fas fa-newspaper text-muted"></i>
                                    </div>
                                    @endif
                                    <div class="ms-3">
                                        <h6 class="mb-1">{{ Str::limit($post->judul, 40) }}</h6>
                                        <small class="text-muted">
                                            <i class="far fa-calendar-alt me-1"></i>{{ $post->created_at->format('d M Y') }}
                                        </small>
                                    </div>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchKategori');
        const kategoriItems = document.querySelectorAll('.kategori-item');
        
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            
            kategoriItems.forEach(item => {
                const kategoriName = item.querySelector('.card-title').textContent.toLowerCase();
                
                if (kategoriName.includes(searchTerm)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection

@section('styles')
<style>
    .sidebar-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        margin-bottom: 25px;
    }
    
    .sidebar-card-header {
        padding: 15px 20px;
        background: linear-gradient(135deg, var(--elunora-primary), #0056b3);
        color: white;
    }
    
    .sidebar-card-body {
        padding: 20px;
    }
    
    .sidebar-list-item {
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .sidebar-list-item:last-child {
        border-bottom: none;
    }
    
    .sidebar-list-item a {
        color: var(--bs-body-color);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 15px; /* Menambahkan jarak antara foto dan teks */
    }
    
    .sidebar-list-item a:hover {
        color: var(--elunora-primary);
    }
    
    .sidebar-thumbnail {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        overflow: hidden;
        flex-shrink: 0;
        margin-right: 10px; /* Menambahkan margin kanan */
    }
    
    .sidebar-thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .empty-state {
        padding: 3rem 1rem;
        background: #f8f9fa;
        border-radius: 8px;
        text-align: center;
    }
    
    .card {
        border-radius: 15px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    
    .btn {
        border-radius: 30px;
    }
</style>
@endsection