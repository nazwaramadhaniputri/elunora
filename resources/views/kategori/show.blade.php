@extends('layouts.app')

@section('title', $kategori->nama_kategori)

@section('hero')
<div class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-4 fw-bold text-white mb-3">
                    <i class="fas fa-tag me-3"></i>{{ $kategori->nama_kategori }}
                </h1>
                <p class="lead mb-4 text-white">Berita dan artikel dalam kategori ini</p>
                <div class="d-flex gap-3">
                    <span class="badge bg-light text-dark fs-6 px-3 py-2">
                        <i class="fas fa-newspaper me-2"></i>{{ $posts->total() }} Berita
                    </span>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="hero-icon">
                    <i class="fas fa-tag" style="font-size: 8rem; color: rgba(255, 255, 255, 0.2);"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('kategori') }}">Kategori</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $kategori->nama_kategori }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">Berita dalam Kategori "{{ $kategori->nama_kategori }}"</h2>
            </div>
        </div>

        <div class="row">
            @forelse($posts as $post)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 border-0 shadow-sm news-card">
                    @if($post->thumbnail)
                    <img src="{{ asset('storage/' . $post->thumbnail) }}" class="card-img-top" alt="{{ $post->judul }}">
                    @else
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                        <i class="fas fa-newspaper text-secondary" style="font-size: 3rem;"></i>
                    </div>
                    @endif
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-primary">{{ $post->kategori->nama_kategori }}</span>
                            <small class="text-muted">{{ $post->created_at->format('d M Y') }}</small>
                        </div>
                        <h5 class="card-title">{{ $post->judul }}</h5>
                        <p class="card-text">{{ Str::limit(strip_tags($post->konten), 100) }}</p>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <a href="{{ route('berita.detail', $post->id) }}" class="btn btn-primary">
                            Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="empty-state">
                    <i class="fas fa-newspaper" style="font-size: 4rem; color: #dee2e6; margin-bottom: 1rem;"></i>
                    <h4 class="text-muted">Belum Ada Berita</h4>
                    <p class="text-muted">Belum ada berita dalam kategori ini.</p>
                    <a href="{{ route('kategori') }}" class="btn btn-primary mt-3">Lihat Kategori Lain</a>
                </div>
            </div>
            @endforelse
        </div>

        <div class="row mt-4">
            <div class="col-12 d-flex justify-content-center">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</section>
@endsection