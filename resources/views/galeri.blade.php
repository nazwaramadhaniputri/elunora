@extends('layouts.app')

@section('title', 'Galeri Foto')

@section('styles')
<link href="{{ asset('css/floating-button.css') }}" rel="stylesheet">
<style>
    .gallery-card {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
        position: relative;
    }
    
    .gallery-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }
    
    .gallery-img-container {
        position: relative;
        height: 200px;
        overflow: hidden;
    }
    
    .gallery-img-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .gallery-card:hover .gallery-img-container img {
        transform: scale(1.05);
    }
    
    .gallery-card-body {
        padding: 1.5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
        position: relative;
    }
    
    .gallery-card-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.75rem;
    }
    
    .gallery-card .badge {
        font-size: 0.75rem;
        padding: 0.35em 0.65em;
        font-weight: 500;
    }
    
    .gallery-card .btn-outline-primary {
        border-width: 1.5px;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .gallery-card .btn-outline-primary:hover {
        background-color: var(--bs-primary);
        border-color: var(--bs-primary);
    }
    
    .gallery-footer {
        margin-top: auto;
        padding: 1rem 0 0;
        border-top: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .gallery-footer .btn-outline-primary {
        border-radius: 6px;
        padding: 0.5rem 1.5rem;
        font-weight: 600;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.85rem;
        text-transform: none;
        background: #1e40af;
        color: #ffffff !important;
        border: 2px solid #1e40af;
    }
    
    .gallery-footer .btn-outline-primary i {
        color: #ffffff !important;
    }
    
    .gallery-footer .btn-outline-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
        background: #1d4ed8;
        border-color: #1d4ed8;
        color: #ffffff !important;
    }
    
    .category-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        z-index: 2;
    }
    
    .category-badge .badge {
        background: rgba(30, 64, 175, 0.15) !important;
        color: #1e40af !important;
        font-weight: 500;
        border-radius: 20px;
        padding: 0.4em 1.2em;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: 1px solid rgba(30, 64, 175, 0.2);
        position: relative;
        display: inline-flex;
        align-items: center;
        line-height: 1.2;
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
    }
    
    .category-badge .badge i {
        margin-right: 6px;
        font-size: 0.9em;
        color: #1e40af;
    }
    
    
    .gallery-footer .badge {
        font-size: 0.75rem;
        padding: 0.35em 0.65em;
        font-weight: 500;
        margin-right: 0.5rem;
    }
    
    .gallery-meta {
        display: flex;
        justify-content: space-between;
        margin-top: 0.5rem;
        font-size: 0.85rem;
        color: #6c757d;
    }
    /* Align bottoms using flex (not absolute) */
    .gallery-card { position: relative !important; min-height: 400px; display: flex; flex-direction: column; }
    .gallery-card .gallery-img-container { flex: 0 0 auto; }
    .gallery-card .card-body.gallery-content { flex: 1 1 auto; display: flex; flex-direction: column; padding: 1rem !important; }
    .gallery-card .card-body .card-title { margin-bottom: .5rem !important; }
    .gallery-card .card-body .card-text { margin-bottom: 0 !important; display: -webkit-box; -webkit-line-clamp: 2; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .gallery-card .gallery-bottom { margin-top: auto; padding-top: .5rem; display: flex; justify-content: space-between; align-items: center; }
    .gallery-card .gallery-date { margin: 0 !important; line-height: 1; display: inline-flex; align-items: center; gap: 6px; }
    .gallery-card .btn-view { margin: 0 !important; display: inline-flex; align-items: center; }
</style>
@endsection

@section('scripts')
<script>
    function previewImage(input) {
        const preview = document.getElementById('photoPreview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
            }
            
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.innerHTML = `<i class="fas fa-camera fa-3x text-muted"></i>`;
        }
    }
</script>
@endsection

<!-- Modal Upload Foto -->
@auth
<div class="modal fade photo-upload-modal" id="uploadPhotoModal" tabindex="-1" aria-labelledby="uploadPhotoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadPhotoModalLabel">Tambah Foto ke Galeri</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('user-photos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="photo-preview" id="photoPreview">
                        <i class="fas fa-camera fa-3x text-muted"></i>
                    </div>
                    
                    <div class="mb-3">
                        <label for="photo" class="form-label">Pilih Foto</label>
                        <input type="file" class="form-control" id="photo" name="image" accept="image/*" required onchange="previewImage(this)">
                    </div>
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Foto</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    
                    <div class="alert alert-info">
                        <small><i class="fas fa-info-circle me-1"></i> Foto Anda akan ditampilkan setelah disetujui oleh admin.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Upload Foto</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endauth

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
            <!-- Tombol Floating dihapus karena sudah dipindahkan ke halaman detail -->
            
            <!-- Daftar Galeri -->
            <div class="col-lg-8">
                <!-- Search Bar -->
                <div class="mb-3 position-relative">
                    <input type="text" class="form-control js-page-search" placeholder="Cari galeri..." aria-label="Cari galeri" data-target=".col-md-6.mb-4" style="padding-right: 40px; border-radius: 30px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                    <span class="position-absolute top-50 end-0 translate-middle-y me-3" style="z-index: 10; color: #1e3a8a;">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
                
                <!-- Filter Kategori -->
                <div class="mb-4">
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('galeri') }}" class="btn btn-sm btn-chip {{ !request('category') ? 'active' : '' }}">
                            Semua
                        </a>
                        @foreach($categories as $category)
                        <a href="{{ route('galeri', ['category' => $category->id]) }}" 
                           class="btn btn-sm btn-chip {{ request('category') == $category->id ? 'active' : '' }}">
                            {{ $category->name }}
                        </a>
                        @endforeach
                    </div>
                </div>
                <div class="row">
                @forelse($galeris as $galeri)
                <div class="col-md-6 mb-4">
                    <div class="gallery-card">
                        <div class="gallery-img-container position-relative">
                            @if($galeri->category)
                                <div class="category-badge">
                                    <span class="badge">
                                        <i class="fas fa-tag"></i>
                                        {{ strtoupper($galeri->category->name) }}
                                    </span>
                                </div>
                            @endif
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
                                            <div class="col-6 h-100">
                                                <img src="{{ asset($galeri->fotos->get(0)->file) }}" 
                                                     class="w-100 h-100" style="object-fit: cover;" alt="">
                                            </div>
                                            <div class="col-6 h-100">
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
                                    <span class="badge bg-primary">
                                        <i class="fas fa-images me-1"></i>{{ $galeri->fotos->count() }} Foto
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-card-body d-flex flex-column h-100">
                            <h5 class="card-title mb-2">{{ $galeri->judul ?? ($galeri->post ? $galeri->post->judul : 'Galeri Tanpa Judul') }}</h5>
                            
                            <p class="card-text flex-grow-1">{{ Str::limit($galeri->deskripsi ?? ($galeri->post ? strip_tags($galeri->post->isi) : 'Deskripsi tidak tersedia'), 100) }}</p>
                            
                            <div class="gallery-footer">
                                <div class="d-flex align-items-center gap-2">
                                    <small class="text-muted">
                                        <i class="far fa-calendar-alt me-1"></i>{{ $galeri->created_at->format('d M Y') }}
                                    </small>
                                    @if($galeri->fotos->count() > 0)
                                        <small class="text-muted ms-2">
                                            <i class="fas fa-images me-1"></i>{{ $galeri->fotos->count() }}
                                        </small>
                                    @endif
                                </div>
                                <a href="{{ route('galeri.detail', $galeri->id) }}" class="btn btn-outline-primary">
                                    Lihat <i class="fas fa-arrow-right"></i>
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
                            <li class="list-group-item">
                                <a href="{{ route('galeri.detail', $item->id) }}" class="text-decoration-none d-block py-2">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-3">
                                            @if($item->fotos->isNotEmpty())
                                            <img src="{{ asset($item->fotos->first()->file) }}" class="rounded" width="60" height="60" alt="{{ $item->fotos->first()->judul }}" onerror="this.src='{{ asset('img/no-image.jpg') }}'" style="object-fit: cover;">
                                            @else
                                            <img src="{{ asset('img/no-image.jpg') }}" class="rounded" width="60" height="60" alt="No Image" style="object-fit: cover;">
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-2">{{ Str::limit($item->judul ?? ($item->post ? $item->post->judul : 'Galeri Tanpa Judul'), 50) }}</h6>
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

                <!-- Kategori Galeri (moved below Galeri Terbaru) -->
                <div class="sidebar-card mb-4">
                    <div class="sidebar-header">
                        <h5 class="mb-0"><i class="fas fa-tags me-2"></i>Kategori Galeri</h5>
                    </div>
                    <div class="card-body">
                        @php
                        $kategoriGaleri = \App\Models\GalleryCategory::where('status', 1)
                            ->withCount(['galleries' => function($query) {
                                $query->where('status', 1);
                            }])
                            ->orderBy('name')
                            ->get();
                        @endphp
                        <ul class="list-group list-group-flush">
                            @forelse($kategoriGaleri as $kategori)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <a href="{{ route('galeri', ['category' => $kategori->slug]) }}" class="text-decoration-none">
                                    {{ $kategori->name }}
                                </a>
                                <span class="badge bg-success rounded-pill">{{ $kategori->galleries_count }}</span>
                            </li>
                            @empty
                            <li class="list-group-item px-0">Tidak ada kategori</li>
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
                                <span class="badge bg-primary rounded-pill">{{ $totalGaleri }}</span>
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

/* Kategori button styling - selalu lonjong */
.btn, .btn-primary, .btn-outline-primary, .page-item .page-link {
    border-radius: 30px !important;
    transition: all 0.3s ease;
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
    background: linear-gradient(to top, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.4));
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    color: white;
    font-size: 1.5rem;
    text-align: center;
}

.gallery-card:hover .gallery-overlay {
    opacity: 1;
}

.gallery-content {
    padding: 2rem;
}

/* Enforce bottom pin for date and button (final styles section) */
.gallery-card { min-height: 420px; }
.gallery-card { position: relative !important; }
.gallery-card .card-body { padding: 1rem 1rem 3.5rem 1rem !important; }
.gallery-card .btn-view { position: absolute !important; right: 16px !important; bottom: 16px !important; margin: 0 !important; display: inline-flex; align-items: center; }
.gallery-card .gallery-date { position: absolute !important; left: 16px !important; bottom: 16px !important; margin: 0 !important; line-height: 1; display: inline-flex; align-items: center; gap: 6px; }
/* Standardize gallery preview height regardless of inline styles */
.gallery-preview { height: 200px !important; }

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

/* Sidebar: gunakan style global dari elunora-theme.css */

.empty-state {
    padding: 3rem 0;
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