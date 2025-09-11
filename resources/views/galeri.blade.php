@extends('layouts.app')

@section('title', 'Galeri Foto')

@section('hero')
<div class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-4 fw-bold text-white mb-3">
                    <i class="fas fa-camera-retro me-3"></i>Galeri Foto
                </h1>
                <p class="lead mb-4 text-white">Koleksi foto kegiatan dan acara sekolah yang menginspirasi</p>
                <div class="d-flex gap-3">
                    <span class="badge bg-light text-dark fs-6 px-3 py-2">
                        <i class="fas fa-images me-2"></i>{{ $galeris->total() }} Galeri
                    </span>
                    <span class="badge bg-light text-dark fs-6 px-3 py-2">
                        <i class="fas fa-camera me-2"></i>Foto Terbaru
                    </span>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="hero-icon">
                    <i class="fas fa-camera-retro camera-animation" style="font-size: 8rem; color: rgba(255, 255, 255, 0.2);"></i>
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
            <!-- Daftar Galeri -->
            <div class="col-lg-8">
                <div class="row">
                @forelse($galeris as $galeri)
                <div class="col-md-6 mb-4">
                    <div class="card news-card h-100 shadow-sm">
                        <div class="gallery-image-container position-relative overflow-hidden">
                            @if($galeri->fotos->count() > 0)
                                <!-- Gallery Grid Preview -->
                                <div class="gallery-preview" style="height: 280px; position: relative;">
                                    @if($galeri->fotos->count() == 1)
                                        <img src="{{ asset($galeri->fotos->first()->file) }}" 
                                             class="w-100 h-100" 
                                             alt="{{ $galeri->judul ?? ($galeri->post ? $galeri->post->judul : 'Galeri') }}"
                                             style="object-fit: cover;">
                                    @elseif($galeri->fotos->count() == 2)
                                        <div class="row g-1 h-100">
                                            <div class="col-6">
                                                <img src="{{ asset($galeri->fotos->get(0)->file) }}" 
                                                     class="w-100 h-100" style="object-fit: cover;" alt="">
                                            </div>
                                            <div class="col-6">
                                                <img src="{{ asset($galeri->fotos->get(1)->file) }}" 
                                                     class="w-100 h-100" style="object-fit: cover;" alt="">
                                            </div>
                                        </div>
                                    @elseif($galeri->fotos->count() == 3)
                                        <div class="row g-1 h-100">
                                            <div class="col-6">
                                                <img src="{{ asset($galeri->fotos->get(0)->file) }}" 
                                                     class="w-100 h-100" style="object-fit: cover;" alt="">
                                            </div>
                                            <div class="col-6">
                                                <div class="row g-1 h-100">
                                                    <div class="col-12" style="height: 50%;">
                                                        <img src="{{ asset($galeri->fotos->get(1)->file) }}" 
                                                             class="w-100 h-100" style="object-fit: cover;" alt="">
                                                    </div>
                                                    <div class="col-12" style="height: 50%;">
                                                        <img src="{{ asset($galeri->fotos->get(2)->file) }}" 
                                                             class="w-100 h-100" style="object-fit: cover;" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="row g-1 h-100">
                                            <div class="col-6">
                                                <img src="{{ asset($galeri->fotos->get(0)->file) }}" 
                                                     class="w-100 h-100" style="object-fit: cover;" alt="">
                                            </div>
                                            <div class="col-6">
                                                <div class="row g-1 h-100">
                                                    <div class="col-12" style="height: 33.33%;">
                                                        <img src="{{ asset($galeri->fotos->get(1)->file) }}" 
                                                             class="w-100 h-100" style="object-fit: cover;" alt="">
                                                    </div>
                                                    <div class="col-12" style="height: 33.33%;">
                                                        <img src="{{ asset($galeri->fotos->get(2)->file) }}" 
                                                             class="w-100 h-100" style="object-fit: cover;" alt="">
                                                    </div>
                                                    <div class="col-12 position-relative" style="height: 33.33%;">
                                                        <img src="{{ asset($galeri->fotos->get(3)->file) }}" 
                                                             class="w-100 h-100" style="object-fit: cover;" alt="">
                                                        @if($galeri->fotos->count() > 4)
                                                            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" 
                                                                 style="background: rgba(0,0,0,0.7);">
                                                                <span class="text-white fw-bold fs-4">+{{ $galeri->fotos->count() - 4 }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <img src="{{ asset('img/no-image.jpg') }}" 
                                     class="card-img-top gallery-image" 
                                     alt="No Image"
                                     style="height: 280px; object-fit: cover;">
                            @endif
                            <div class="gallery-overlay">
                                <div class="gallery-info">
                                    <span class="badge bg-success">
                                        <i class="fas fa-images me-1"></i>{{ $galeri->fotos->count() }} Foto
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body gallery-content d-flex flex-column" style="padding: 1rem;">
                            <h5 class="card-title mb-2">{{ $galeri->judul ?? ($galeri->post ? $galeri->post->judul : 'Galeri Tanpa Judul') }}</h5>
                            <p class="card-text text-muted flex-grow-1">
                                {{ Str::limit(strip_tags($galeri->deskripsi ?? ($galeri->post ? $galeri->post->isi : 'Deskripsi galeri')), 100) }}
                            </p>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ \Carbon\Carbon::parse($galeri->created_at)->format('d M Y') }}
                                </small>
                                <a href="{{ route('galeri.detail', $galeri->id) }}" class="btn btn-success btn-sm">
                                    <i class="fas fa-eye me-1"></i>Lihat Galeri
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="empty-state text-center py-5">
                    <i class="fas fa-images" style="font-size: 4rem; color: #dee2e6; margin-bottom: 1rem;"></i>
                    <h4 class="text-muted">Belum Ada Galeri</h4>
                    <p class="text-muted">Galeri foto akan ditampilkan di sini ketika sudah dipublikasikan.</p>
                </div>
                @endforelse
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $galeris->links() }}
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Galeri Terbaru -->
                <div class="sidebar-card mb-4">
                    <div class="sidebar-header">
                        <h5 class="mb-0"><i class="fas fa-images me-2"></i>Galeri Terbaru</h5>
                    </div>
                    <div class="card-body">
                        @php
                        $galeriTerbaru = \App\Models\Galeri::where('status', 1)
                            ->with('fotos', 'post')
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();
                        @endphp
                        
                        <ul class="list-group list-group-flush">
                            @forelse($galeriTerbaru as $item)
                            <li class="list-group-item px-0">
                                <a href="{{ route('galeri.detail', $item->id) }}" class="text-decoration-none">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            @if($item->fotos->isNotEmpty())
                                            <img src="{{ asset($item->fotos->first()->file) }}" class="rounded" width="60" height="60" alt="{{ $item->fotos->first()->judul }}" onerror="this.src='{{ asset('img/no-image.jpg') }}'" style="object-fit: cover;">
                                            @else
                                            <img src="{{ asset('img/no-image.jpg') }}" class="rounded" width="60" height="60" alt="No Image" style="object-fit: cover;">
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ Str::limit($item->judul ?? ($item->post ? $item->post->judul : 'Galeri Tanpa Judul'), 50) }}</h6>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</small>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            @empty
                            <li class="list-group-item">Belum ada galeri</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
                
                <!-- Statistik Galeri -->
                <div class="sidebar-card">
                    <div class="sidebar-header">
                        <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Statistik Galeri</h5>
                    </div>
                    <div class="card-body">
                        @php
                        $totalGaleri = \App\Models\Galeri::where('status', 1)->count();
                        $totalFoto = \App\Models\Foto::whereHas('galeri', function($query) {
                            $query->where('status', 1);
                        })->count();
                        @endphp
                        
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Total Galeri
                                <span class="badge bg-success rounded-pill">{{ $totalGaleri }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Total Foto
                                <span class="badge bg-primary rounded-pill">{{ $totalFoto }}</span>
                            </li>
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

.camera-animation {
    animation: cameraShutter 2s ease-in-out infinite;
}

@keyframes cameraShutter {
    0%, 90%, 100% { 
        transform: scale(1) rotate(0deg); 
        opacity: 0.2;
    }
    5%, 15% { 
        transform: scale(1.1) rotate(-2deg); 
        opacity: 0.4;
    }
    10% { 
        transform: scale(1.05) rotate(2deg); 
        opacity: 0.6;
    }
}

.gallery-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    border: none;
}

.gallery-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

.gallery-image-container {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.gallery-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.gallery-card:hover .gallery-image {
    transform: scale(1.05);
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

.gallery-card:hover .gallery-overlay {
    opacity: 1;
}

.gallery-content {
    padding: 2rem;
}

.gallery-title {
    color: #2c3e50;
    font-weight: 700;
    line-height: 1.3;
}

.gallery-excerpt {
    color: #6c757d;
    line-height: 1.6;
}

.gallery-meta .badge {
    font-size: 0.75rem;
    padding: 0.5rem 1rem;
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

.empty-state {
    padding: 3rem 0;
}

/* Global Card and Box Text Spacing */
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
}

.card-text {
    line-height: 1.6;
    margin-bottom: 1rem;
    font-size: 1rem;
}

/* Table Styling for Better Spacing */
.table {
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.table th,
.table td {
    padding: 1rem 1.5rem;
    vertical-align: middle;
    border: none;
    border-bottom: 1px solid #e9ecef;
    line-height: 1.5;
    font-size: 0.95rem;
}

.table th {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.875rem;
    letter-spacing: 0.5px;
}

.table tbody tr {
    transition: all 0.3s ease;
}

.table tbody tr:hover {
    background-color: #f8f9fa;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.table tbody tr:last-child td {
    border-bottom: none;
}

/* Card Tables */
.card .table {
    margin-bottom: 0;
}

/* Form Controls */
.form-control {
    padding: 0.75rem 1rem;
    border-radius: 10px;
    border: 2px solid #e9ecef;
    line-height: 1.5;
    font-size: 1rem;
}

.form-label {
    margin-bottom: 0.75rem;
    font-weight: 600;
    font-size: 1rem;
}

/* Alert Boxes */
.alert {
    padding: 1rem 1.5rem;
    border-radius: 12px;
    margin-bottom: 1.5rem;
    font-size: 1rem;
}

/* List Groups */
.list-group-item {
    padding: 1rem 1.5rem;
    border-radius: 0;
    line-height: 1.5;
    font-size: 1rem;
}

.list-group-item:first-child {
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
}

.list-group-item:last-child {
    border-bottom-left-radius: 12px;
    border-bottom-right-radius: 12px;
}

/* Modal Content */
.modal-body {
    padding: 1.5rem;
}

.modal-header {
    padding: 1.25rem 1.5rem;
}

.modal-footer {
    padding: 1.25rem 1.5rem;
}

@media (max-width: 768px) {
    .gallery-image-container {
        height: 150px;
    }
    
    .gallery-content {
        padding: 1.5rem;
    }
    
    .card-body {
        padding: 1.25rem;
    }
    
    .card-header {
        padding: 1rem 1.25rem;
    }
    
    .table th,
    .table td {
        padding: 0.875rem 1.25rem;
        font-size: 0.9rem;
    }
    
    .form-control {
        padding: 0.75rem 1rem;
    }
    
    .alert {
        padding: 1rem 1.25rem;
    }
    
    .list-group-item {
        padding: 0.875rem 1.25rem;
    }
    
    .modal-body,
    .modal-header,
    .modal-footer {
        padding: 1.25rem;
    }
}
</style>
@endsection