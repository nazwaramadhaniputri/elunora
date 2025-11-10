@extends('layouts.admin')

@section('title', 'Detail Galeri')
@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
    <style>
    /* Debug styles */
    .gallery-image {
        position: relative;
    }
    .gallery-image::after {
        content: attr(data-original-path);
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0,0,0,0.7);
        color: white;
        padding: 2px 5px;
        font-size: 9px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: none; /* Sembunyikan debug info secara default */
    }
    
    /* Header action buttons: make all same size as 'Kembali' */
    .page-actions { display:flex; align-items:center; gap:12px; }
    .page-actions .btn-modern {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        height: 40px; /* samakan tinggi */
        padding: 8px 14px; /* unify padding */
        line-height: 1.2;
        white-space: nowrap; /* avoid two-line text */
        border-radius: 22px; /* pill-like to match Kembali */
        height: auto; /* rely on padding */
    }
    .page-actions .btn-modern i { margin-right: 6px; }
    /* Samakan tinggi tombol lonceng dan tombol lainnya */
    .page-actions .btn-modern { height: 40px; padding: 8px 14px; display: inline-flex; align-items: center; border-radius: 22px; }
    .page-actions .btn-modern.info {
        position: relative; width: 40px; height: 40px;
        padding: 0; justify-content: center; border-radius: 50%;
        border: none !important; box-shadow: none !important;
    }
    .page-actions .btn-modern.info i { margin-right: 0 !important; line-height: 1; }
    .page-actions .btn-modern.info .badge { pointer-events: none; }
    /* Prevent badge overlapping next button */
    .page-actions .btn-modern.info { position: relative; }
    .page-actions .btn-modern.info .badge { pointer-events: none; }
    .foto-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr); /* 3 per row */
        grid-gap: 16px;
        padding: 0 6px 28px 6px; /* more bottom padding so last row not stuck to edge */
    }
    @media (max-width: 600px) {
        .foto-grid { grid-template-columns: 1fr; }
    }
    /* Card look for each photo item */
    .foto-item {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 6px 16px rgba(0,0,0,0.08);
        overflow: hidden;
        position: relative; /* create stacking context */
        margin-bottom: 12px; /* extra spacing between rows */
    }
    /* Anchor (image link) sits below footer controls */
    .foto-item > a { position: relative; z-index: 0; display: block; }
    /* Comfortable padding for title under image */
    .foto-caption { padding: 12px 16px 0 16px; }
    .foto-item a img { display: block; border-top-left-radius: 16px; border-top-right-radius: 16px; }

    /* Delete tile: soft pink tile + solid red icon */
    .foto-actions .action-btn.danger,
    .foto-footer .action-btn.danger {
        background: rgba(253, 231, 234, 0.75) !important; /* soft pink tile translucent */
        color: var(--admin-danger) !important; /* solid red icon */
        border-radius: 12px !important; /* rounded square */
        border: none !important;
        box-shadow: 0 2px 8px rgba(220, 53, 69, 0.18) !important; /* soft red shadow */
        outline: none !important;
    }
    /* Keep same colors on hover/focus and add subtle press animation */
    .foto-actions .action-btn.danger:hover,
    .foto-actions .action-btn.danger:focus,
    .foto-footer .action-btn.danger:hover,
    .foto-footer .action-btn.danger:focus {
        background: rgba(253, 231, 234, 0.75) !important;
        color: var(--admin-danger) !important;
        border: none !important;
        box-shadow: 0 2px 8px rgba(220, 53, 69, 0.18) !important;
        outline: none !important;
    }
    /* Press animation for delete like edit */
    .foto-actions .action-btn.danger:active,
    .foto-footer .action-btn.danger:active { transform: translateY(1px) !important; }
    /* Also apply when JS adds .pressing during mousedown */
    .foto-actions .action-btn.danger.pressing,
    .foto-footer .action-btn.danger.pressing { transform: translateY(1px) !important; }
    /* Base tile button size */
    .foto-actions .action-btn,
    .foto-footer .action-btn {
        height: 36px;
        width: 36px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.12);
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.15s ease;
        position: relative;
        z-index: 10; /* above image link */
        pointer-events: auto;
    }
    /* Edit (primary) has subtle press animation */
    .foto-footer .action-btn.primary:active,
    .foto-actions .action-btn.primary:active { transform: translateY(1px); }
    /* Footer row under title: left (like/comment) + right (edit/delete) */
    .foto-footer {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: nowrap;
        margin: 10px 12px 16px 12px; /* extra spacing since caption removed */
        position: relative;
        z-index: 10; /* above image anchor */
        pointer-events: auto;
    }
    .foto-footer .left { display: inline-flex; align-items: center; gap: 8px; }
    .foto-footer .right { display: inline-flex; align-items: center; gap: 8px; margin-left: auto; }
    /* Like/Comment tiles styled like edit tile */
    .stat-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0 10px;
        height: 36px;
        border-radius: 12px;
        border: none;
        outline: none;
        box-shadow: 0 2px 6px rgba(0,0,0,0.12);
        cursor: pointer;
        position: relative;
        z-index: 10;
        pointer-events: auto;
        transition: transform 0.15s ease;
    }
    /* Match tile feel with themed backgrounds */
    .stat-pill.likes {
        background: rgba(220, 38, 38, 0.12); /* red tint */
        color: var(--admin-danger); /* match theme danger */
    }
    .stat-pill.comments {
        background: rgba(100, 116, 139, 0.12); /* slate */
        color: #334155;
    }
    .stat-pill:active { transform: translateY(1px); }
    .stat-pill .count { font-weight: 700; font-size: 13px; }
    /* icon size aligned with action tiles */
    .stat-pill i, .foto-footer .action-btn i { font-size: 16px; line-height: 1; }
    /* Both Comments and Likes are interactive in admin */
    .stat-pill.comments { pointer-events: auto; }
    .stat-pill.likes { pointer-events: auto; cursor: pointer; }
    .foto-footer form { display: inline-flex; margin: 0; padding: 0; }

    /* When any modal is open, disable interactions on overlays to avoid click-through */
    body.modal-open .foto-stats,
    body.modal-open .foto-actions {
        pointer-events: none !important;
    }

    /* Ensure Bootstrap modal overlays above Lightbox (which uses ~9999) */
    .modal { z-index: 12050 !important; }
    .modal-backdrop { z-index: 12040 !important; }

    /* If Lightbox overlay is active while a modal opens, hide Lightbox layers */
    body.modal-open #lightbox, 
    body.modal-open .lb-overlay, 
    body.modal-open .lb-outerContainer, 
    body.modal-open .lb-dataContainer { display: none !important; }

    /* Fallback Comments Popup (custom) */
    .comments-popup-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.5);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 2000; /* above everything */
    }
    .comments-popup-overlay.open { display: flex; }
    .comments-popup {
        width: min(800px, 92vw);
        max-height: 80vh;
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }
    .comments-popup-header { padding: 12px 16px; border-bottom: 1px solid #e5e7eb; display:flex; align-items:center; justify-content:space-between; }
    .comments-popup-title { font-weight: 700; color: #1f2937; }
    .comments-popup-body { padding: 0; overflow: auto; }
    .comments-close-btn { background: transparent; border: none; font-size: 18px; color: #6b7280; cursor: pointer; }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="page-header-modern mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div class="page-title-section">
                <h4 class="page-title">
                    <i class="fas fa-images me-3"></i>Detail Galeri: {{ $galeri->judul ?? ($galeri->post->judul ?? 'Galeri') }}
                </h4>
                <p class="page-subtitle mb-1">{{ $galeri->deskripsi ?? '' }}</p>
                <div class="text-muted small">Dibuat: {{ \Carbon\Carbon::parse($galeri->created_at)->format('d M Y H:i') }}</div>
            </div>
            @php
                // Capture common variants for user-photo pending submissions
                $pendingStatuses = ['pending','PENDING','awaiting','menunggu','waiting',0,'0',null,''];
                $pendingQuery = \App\Models\UserPhoto::whereIn('status', $pendingStatuses);
                $pendingList = (clone $pendingQuery)->with('user')->orderBy('created_at','desc')->take(20)->get();
                $pendingCount = $pendingQuery->count();
            @endphp

    <!-- Modal: Pending User Photos -->
    <div class="modal fade" id="pendingUserPhotosModal" tabindex="-1" aria-labelledby="pendingUserPhotosModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pendingUserPhotosModalLabel"><i class="fas fa-bell me-2"></i>Foto Tamu Menunggu Persetujuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($pendingList->count())
                    <div class="list-group">
                        @foreach($pendingList as $p)
                        <div class="list-group-item">
                            <div class="d-flex align-items-center">
                                @php
                                    $pRaw = ltrim((string)($p->image_path ?? ''), '/');
                                    if (\Illuminate\Support\Str::startsWith($pRaw, 'storage/')) { $pRaw = substr($pRaw, 8); }
                                    if (\Illuminate\Support\Str::startsWith($pRaw, 'public/')) { $pRaw = substr($pRaw, 7); }
                                    $pUrl = null;
                                    if (\Illuminate\Support\Facades\Storage::disk('public')->exists($pRaw)) { $pUrl = asset(\Illuminate\Support\Facades\Storage::url($pRaw)); }
                                    if (empty($pUrl) && \Illuminate\Support\Facades\File::exists(public_path('storage/'.$pRaw))) { $pUrl = asset('storage/'.$pRaw); }
                                    if (empty($pUrl) && \Illuminate\Support\Facades\File::exists(public_path($pRaw))) { $pUrl = asset($pRaw); }
                                    if (empty($pUrl)) { $pUrl = asset('img/no-image.jpg'); }
                                @endphp
                                <a href="{{ $pUrl }}" data-lightbox="pending" data-title="{{ $p->title }}" class="me-3">
                                    <img src="{{ $pUrl }}" alt="{{ $p->title }}" width="64" height="64" class="rounded" style="object-fit:cover" onerror="this.src='{{ asset('img/no-image.jpg') }}'">
                                </a>
                                <div class="flex-grow-1">
                                    <div class="fw-semibold mb-1">{{ $p->title ?: 'Tanpa judul' }}</div>
                                    <div class="small text-muted">Oleh: {{ optional($p->user)->name ?: 'Pengguna' }} • {{ optional($p->created_at)->format('d M Y H:i') }}</div>
                                    @if($p->description)
                                        <div class="small text-muted mt-1">{{ \Illuminate\Support\Str::limit($p->description, 120) }}</div>
                                    @endif
                                </div>
                                <div class="ms-3 d-flex gap-2">
                                    <form action="{{ route('admin.user-photos.approve', $p->id) }}" method="POST" class="pending-action-form" data-id="{{ $p->id }}" data-action="approve">
                                        @csrf
                                        <input type="hidden" name="galery_id" value="{{ $galeri->id }}">
                                        <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-check me-1"></i>Setuju</button>
                                    </form>
                                    <form action="{{ route('admin.user-photos.reject', $p->id) }}" method="POST" class="pending-action-form" data-id="{{ $p->id }}" data-action="reject" onsubmit="return confirm('Tolak foto ini?');">
                                        @csrf
                                        <input type="hidden" name="admin_notes" value="Ditolak dari modal galeri">
                                        <input type="hidden" name="galery_id" value="{{ $galeri->id }}">
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-times me-1"></i>Tolak</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center text-muted py-4">Tidak ada foto menunggu persetujuan.</div>
                    @endif
                </div>
                <div class="modal-footer d-none"></div>
            </div>
        </div>
    </div>

    <!-- Fallback Comments Popup (custom) -->
    <div class="comments-popup-overlay" id="commentsPopupOverlay" aria-hidden="true">
        <div class="comments-popup" role="dialog" aria-modal="true" aria-labelledby="commentsPopupTitle">
            <div class="comments-popup-header">
                <div class="comments-popup-title" id="commentsPopupTitle"><i class="fas fa-comments me-2"></i>Komentar Foto</div>
                <button type="button" class="comments-close-btn" id="commentsPopupClose" title="Tutup" onclick="window.closeCommentsOverlay && window.closeCommentsOverlay()"><i class="fas fa-times"></i></button>
            </div>
            <div class="comments-popup-body">
                <ul class="list-group" id="commentsListFallback">
                    <li class="list-group-item text-muted">Memuat...</li>
                </ul>
            </div>
        </div>
    </div>
            <div class="page-actions d-flex align-items-center gap-2">
                <button type="button" class="btn-modern info position-relative" data-bs-toggle="modal" data-bs-target="#pendingUserPhotosModal" title="Foto tamu menunggu persetujuan">
                    <i class="fas fa-bell"></i>
                    @if($pendingCount > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ $pendingCount }}</span>
                    @endif
                </button>
                <button type="button" class="btn-modern primary" data-bs-toggle="modal" data-bs-target="#uploadFotoModal">
                    <i class="fas fa-plus me-2"></i>Tambah Foto
                </button>
                <a href="{{ route('admin.galeri.index') }}" class="btn-modern secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Modal Upload Foto -->
    <div class="modal fade" id="uploadFotoModal" tabindex="-1" aria-labelledby="uploadFotoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadFotoModalLabel">Tambah Foto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.galeri.store-photo', $galeri->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="judul_upload">Judul Foto</label>
                            <input type="text" class="form-control" id="judul_upload" name="judul" placeholder="Masukkan judul foto (opsional)">
                        </div>
                        <div class="form-group">
                            <label for="file">Pilih Foto</label>
                            <input type="file" class="form-control-file @error('file') is-invalid @enderror" id="file" name="file" required>
                            <small class="form-text text-muted">Format: JPG, PNG, GIF. Maks: 5MB</small>
                            @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-modern secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-modern primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <div class="col-12">
            @if($galeri->fotos->isNotEmpty())
            <div class="foto-grid">
                @foreach($galeri->fotos as $foto)
                <div class="foto-item">
                            @php
                                $src = null;
                                $raw = trim((string)($foto->file ?? ''));
                                
                                // Debug: Tampilkan path file asli
                                // {{-- {{ dd('File path:', $raw) }} --}}
                                
                                // Jika path kosong, gunakan no-image
                                if (empty($raw)) {
                                    $src = asset('img/no-image.jpg');
                                } 
                                // Jika sudah full URL
                                elseif (\Illuminate\Support\Str::startsWith($raw, ['http://', 'https://'])) {
                                    $src = $raw;
                                }
                                // Jika path relatif
                                else {
                                    // Hapus awalan slash jika ada
                                    $raw = ltrim($raw, '/');
                                    
                                    // Coba beberapa lokasi yang mungkin
                                    $possiblePaths = [
                                        $raw,  // Path asli
                                        'storage/' . $raw,  // Jika file ada di storage public
                                        'public/' . $raw,  // Jika file ada di folder public
                                        'storage/app/public/' . $raw,  // Path lengkap storage
                                        'public/storage/' . $raw  // Path symlink
                                    ];
                                    
                                    // Cek setiap path yang mungkin
                                    foreach ($possiblePaths as $path) {
                                        // Cek di storage
                                        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
                                            $src = asset('storage/' . $path);
                                            break;
                                        }
                                        
                                        // Cek di public path
                                        $publicPath = public_path($path);
                                        if (file_exists($publicPath)) {
                                            $src = asset($path);
                                            break;
                                        }
                                    }
                                    
                                    // Jika masih belum ketemu, coba langsung akses file
                                    if (empty($src) && file_exists(public_path($raw))) {
                                        $src = asset($raw);
                                    }
                                    
                                    // Jika masih kosong, gunakan no-image
                                    if (empty($src)) {
                                        $src = asset('img/no-image.jpg');
                                        // Debug: Tampilkan path yang tidak ditemukan
                                        // {{-- {{ 'File not found: ' . $raw }} --}}
                                    }
                                }
                            @endphp
                            <a href="{{ $src }}" data-lightbox="galeri" data-title="{{ $foto->judul ?: 'Foto Galeri' }}">
                                <img 
                                    src="{{ $src }}" 
                                    alt="{{ $foto->judul }}" 
                                    style="height:280px; width:100%; object-fit:cover;" 
                                    onerror="this.onerror=null; this.src='{{ asset('img/no-image.jpg') }}'"
                                    loading="lazy"
                                    data-original-path="{{ $foto->file }}"
                                    class="gallery-image"
                                >
                                @if($src === asset('img/no-image.jpg'))
                                <div class="position-absolute top-50 start-50 translate-middle text-center">
                                    <i class="fas fa-image fa-3x text-muted mb-2"></i>
                                    <p class="small text-muted mb-0">Gambar tidak ditemukan</p>
                                </div>
                                @endif
                            </a>
                            <!-- Photo title under the image -->
                            <div class="foto-caption">
                                <small>{{ $foto->judul ?: 'Tanpa judul' }}</small>
                                @php
                                    // Prefer actual related user name if exists; otherwise fall back to stored uploader_name; otherwise Admin
                                    $uploaderName = optional($foto->user)->name
                                        ?? ($foto->uploader_name ?: (\Illuminate\Support\Str::startsWith((string)$foto->file, 'uploads/galeri/user/')
                                            ? 'Pengguna'
                                            : 'Admin'));
                                @endphp
                                <div class="text-muted small d-flex align-items-center gap-1">
                                    <i class="fas fa-user-circle me-1"></i>
                                    <span>{{ $uploaderName }}</span>
                                </div>
                            </div>
                            <!-- Footer actions under the photo: left (like/comment), right (edit/delete) -->
                            <div class="foto-footer mt-2">
                                <div class="left">
                                    <button type="button" class="stat-pill likes" data-id="{{ $foto->id }}" title="Jumlah yang menyukai" data-likes-initial="{{ (int) ($likeCounts[$foto->id] ?? 0) }}" data-bs-toggle="modal" data-bs-target="#likesModal">
                                        <i class="fas fa-heart"></i>
                                        <span class="count" id="likes-count-{{ $foto->id }}">{{ (int) ($likeCounts[$foto->id] ?? 0) }}</span>
                                    </button>
                                    <button type="button" class="stat-pill comments" data-id="{{ $foto->id }}" title="Lihat komentar" data-comments-initial="{{ (int) ($foto->comments_count ?? 0) }}" onclick="window.openCommentsForFoto && window.openCommentsForFoto({{ $foto->id }})">
                                        <i class="fas fa-comments"></i>
                                        <span class="count" id="comments-count-{{ $foto->id }}">{{ (int) ($foto->comments_count ?? 0) }}</span>
                                    </button>
                                </div>
                                <div class="right">
                                    <button type="button" class="action-btn primary edit-foto" data-id="{{ $foto->id }}" data-judul="{{ $foto->judul }}" title="Edit" data-bs-toggle="modal" data-bs-target="#editFotoModal">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('admin.galeri.delete-photo', $foto->id) }}" method="POST" class="m-0 p-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn danger" onclick="return confirm('Apakah Anda yakin ingin menghapus foto ini?')" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-5">
                <i class="fas fa-images fa-4x text-gray-300 mb-3"></i>
                <p class="text-gray-500">Unggah foto pertama untuk galeri ini.</p>
            </div>
            @endif
        </div>
        
        
    </div>
</div>

<!-- Modal Edit Foto -->
<div class="modal fade" id="editFotoModal" tabindex="-1" aria-labelledby="editFotoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="editFotoForm" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editFotoModalLabel">Edit Judul Foto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_judul">Judul Foto</label>
                        <input type="text" class="form-control" id="edit_judul" name="judul">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modern secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modern primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Likes Modal -->
    <div class="modal fade" id="likesModal" tabindex="-1" aria-labelledby="likesModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="likesModalLabel">Disukai oleh</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group" id="likesList"></ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Comments Modal -->
    <div class="modal fade" id="commentsModal" tabindex="-1" aria-labelledby="commentsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="commentsModalLabel">Komentar Foto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="max-height: 60vh; overflow: auto;">
                    <ul class="list-group" id="commentsList">
                        <li class="list-group-item text-muted">Memuat...</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script>
        // AJAX handle for approve/reject in pending photos modal
        (function(){
            var __suppressLB = false;
            // When suppression is on, cancel any click headed to lightbox anchors at capture
            document.addEventListener('click', function(ev){
                if (!__suppressLB) return;
                var a = ev.target && ev.target.closest && ev.target.closest('a[data-lightbox]');
                if (!a) return;
                ev.preventDefault();
                ev.stopImmediatePropagation();
            }, true);
            function updateBadge(delta){
                try {
                    var badge = document.querySelector('.page-actions .btn-modern.info .badge');
                    if (!badge) return;
                    var n = parseInt(badge.textContent.trim(), 10) || 0;
                    n = Math.max(0, n + delta);
                    badge.textContent = n;
                    if (n === 0) { badge.remove(); }
                } catch(_){}
            }
            document.addEventListener('submit', function(e){
                var form = e.target;
                if (!form.classList || !form.classList.contains('pending-action-form')) return;
                e.preventDefault();
                var url = form.getAttribute('action');
                var fd = new FormData(form);
                fetch(url, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: fd
                }).then(function(resp){
                    if (!resp.ok) return resp.text().then(function(t){ throw new Error(t || 'Request failed'); });
                    // remove item and update badge
                    var item = form.closest('.list-group-item');
                    if (item) item.parentNode.removeChild(item);
                    updateBadge(-1);
                    // if list empty, show empty message
                    var left = document.querySelectorAll('#pendingUserPhotosModal .list-group .list-group-item').length;
                    if (left === 0) {
                        var body = document.querySelector('#pendingUserPhotosModal .modal-body');
                        if (body) body.innerHTML = '<div class="text-center text-muted py-4">Tidak ada foto menunggu persetujuan.</div>';
                    }
                    // refresh agar foto approved muncul di grid
                    setTimeout(function(){ window.location.reload(); }, 200);
                }).catch(function(err){
                    var msg = 'Aksi gagal. Coba lagi.';
                    try { if (err && err.message) msg = err.message; } catch(_){ }
                    alert(msg.replace(/<[^>]+>/g,'').trim());
                });
            });
        })();
        // Helper: format datetime 'dd MMM yyyy HH:mm'
        function formatDateTime(dt){
            try {
                const d = new Date(dt);
                return d.toLocaleString('id-ID', { day:'2-digit', month:'short', year:'numeric', hour:'2-digit', minute:'2-digit', hour12:false });
            } catch(_) { return dt || ''; }
        }

        // Global helpers for overlay close and delete
        window.closeCommentsOverlay = function(){
            try { document.getElementById('commentsPopupOverlay').classList.remove('open'); } catch(_){ }
        };

        // Likes modal loader
        (function(){
            // Load counts for all photos on page
            try {
                var ids = Array.from(document.querySelectorAll('.stat-pill.likes[data-id]')).map(function(el){ return el.getAttribute('data-id'); });
                ids = ids.filter(function(x, i, a){ return x && a.indexOf(x) === i; });
                if (ids.length) {
                    fetch('/ajax/fotos/counts?ids=' + encodeURIComponent(ids.join(',')), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                        .then(function(r){ return r.json(); })
                        .then(function(data){
                            var map = (data && data.data) || {};
                            ids.forEach(function(id){
                                var likeEl = document.querySelector('#likes-count-' + id);
                                var comEl = document.querySelector('[data-id="' + id + '"] ~ .comments .count');
                                var d = map[id] || {};
                                if (likeEl && typeof d.likes_count === 'number') likeEl.textContent = d.likes_count;
                                if (comEl && typeof d.comments_count === 'number') comEl.textContent = d.comments_count;
                            });
                        }).catch(function(){});
                }
            } catch(_){}
            // Capture-phase guard: prevent any click inside footer from reaching the image anchor/Lightbox
            ['click','mousedown','mouseup','touchstart','touchend'].forEach(function(type){
                document.addEventListener(type, function(ev){
                    var footer = ev.target && ev.target.closest && ev.target.closest('.foto-footer');
                    if (!footer) return;
                    // Allow clicks on our interactive controls so their handlers can run
                    var allow = ev.target.closest('.stat-pill.likes, .stat-pill.comments, .action-btn, button, form');
                    if (allow) return; // do not block; bubble handler will stop propagation later
                    ev.preventDefault();
                    ev.stopPropagation();
                }, true); // capture phase
            });

            document.addEventListener('click', function(e){
                var btn = e.target.closest('.stat-pill.likes');
                if (!btn) return;
                // block Lightbox but allow Bootstrap data API to open modal
                e.stopPropagation();
                // Close Lightbox if somehow open
                try { if (window.lightbox && document.getElementById('lightbox')) { lightbox.end(); } } catch(_) {}
                // Briefly suppress Lightbox triggers
                __suppressLB = true; setTimeout(function(){ __suppressLB = false; }, 400);
                // set loading state now so modal shows content quickly when opened
                var list = document.getElementById('likesList');
                if (list) list.innerHTML = '<li class="list-group-item text-muted">Memuat...</li>';
            });

            // Load likers when the modal is about to be shown via Bootstrap Data API
            try {
                var likesModalEl = document.getElementById('likesModal');
                likesModalEl && likesModalEl.addEventListener('show.bs.modal', function (event) {
                    var trigger = event.relatedTarget; // button that opened the modal
                    var fotoId = trigger && trigger.getAttribute('data-id');
                    var list = document.getElementById('likesList');
                    if (list) list.innerHTML = '<li class="list-group-item text-muted">Memuat...</li>';
                    if (!fotoId) return;
                    fetch('/ajax/fotos/' + fotoId + '/likes', { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                        .then(function(r){ return r.json(); })
                        .then(function(data){
                            var items = (data && data.likes ? data.likes : []).map(function(u){
                                var name = u.name || u.username || u.email || 'Pengguna';
                                return '<li class="list-group-item">'
                                    + '<i class="fas fa-user me-2 text-primary"></i>' + name
                                    + '</li>';
                            });
                            if (list) list.innerHTML = items.length ? items.join('') : '<li class="list-group-item text-muted">Belum ada yang menyukai.</li>';
                        })
                        .catch(function(){
                            if (list) list.innerHTML = '<li class="list-group-item text-danger">Gagal memuat data.</li>';
                        });
                });
            } catch(_){}
            // Also stop propagation for comments tile to avoid opening lightbox behind the button
            document.addEventListener('click', function(e){
                var btn = e.target.closest('.stat-pill.comments');
                if (!btn) return;
                e.preventDefault();
                e.stopPropagation();
            });
        })();

        window.deleteComment = function(id){
            if (!id) return;
            if (!confirm('Hapus komentar ini?')) return;
            var url = (typeof DELETE_COMMENT_URL_BASE !== 'undefined') ? (DELETE_COMMENT_URL_BASE + '/' + id) : ('/admin/galeri/comment/' + id);
            fetch(url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: '_token={{ csrf_token() }}&_method=DELETE'
            }).then(function(){
                if (typeof openComments === 'function' && window.currentCommentsFotoId) {
                    openComments(window.currentCommentsFotoId);
                } else {
                    // Refresh fallback list by clicking reopen
                    if (window.currentCommentsFotoId) window.openCommentsForFoto(window.currentCommentsFotoId);
                }
            }).catch(function(){ alert('Gagal menghapus komentar. Coba lagi.'); });
        };

        // Global fallback to guarantee popup shows and loads comments
        window.openCommentsForFoto = window.openCommentsForFoto || function(id){
            try { if (typeof openComments === 'function') { return openComments(id); } } catch(_){ }
            var overlay = document.getElementById('commentsPopupOverlay');
            if (overlay) overlay.classList.add('open');
            // Try to load comments via fetch as a fallback
            try {
                fetch(`/ajax/fotos/${id}/comments`).then(function(r){ return r.json(); }).then(function(res){
                    var list = document.getElementById('commentsListFallback');
                    if (!list) return;
                    var items = (res && res.comments ? res.comments : []).map(function(c){
                        var content = (c.content || '').replace(/[&<>]/g, function(ch){ return ({'&':'&amp;','<':'&lt;','>':'&gt;'}[ch]); });
                        var time = formatDateTime(c.created_at);
                        return '<li class="list-group-item">'
                            + '<div class="d-flex justify-content-between align-items-start">'
                            +   '<strong><i class="fas fa-user me-1"></i>' + (c.guest_name || 'Tamu') + '</strong>'
                            +   '<div class="d-flex align-items-center gap-2">'
                            +       '<small class="text-muted">' + time + '</small>'
                            +       '<button type="button" class="btn btn-sm btn-outline-danger delete-comment" data-id="' + c.id + '" onclick="window.deleteComment(' + c.id + ')"><i class="fas fa-trash"></i></button>'
                            +   '</div>'
                            + '</div>'
                            + '<div class="mt-2">' + content + '</div>'
                            + '</li>';
                    });
                    list.innerHTML = items.length ? items.join('') : '<li class="list-group-item text-muted">Belum ada komentar.</li>';
                }).catch(function(){
                    var list = document.getElementById('commentsListFallback');
                    if (list) list.innerHTML = '<li class="list-group-item text-danger">Gagal memuat data.</li>';
                });
            } catch(_){ }
        };
    </script>
    <script>
        $(document).ready(function() {
            // Ensure modals are not inside transformed stacking contexts
            try { $('#likesModal,#commentsModal,#editFotoModal').appendTo('body'); } catch(_) {}
            // Configure lightbox
            lightbox.option({
                'resizeDuration': 200,
                'wrapAround': true,
                'albumLabel': "Foto %1 dari %2"
            });
            // Press animation for delete buttons even when confirm() interrupts :active
            $(document).on('mousedown touchstart', '.foto-actions .action-btn.danger, .foto-footer .action-btn.danger', function(){
                $(this).addClass('pressing');
            });
            $(document).on('mouseup mouseleave touchend touchcancel blur', '.foto-actions .action-btn.danger, .foto-footer .action-btn.danger', function(){
                $(this).removeClass('pressing');
            });
        
        // Baseline like logic to mirror guest when API returns 0
        function getBaseline(id) {
            const key = 'foto_like_baseline_' + id;
            let v = localStorage.getItem(key);
            if (v === null) {
                v = Math.floor(Math.random() * 23) + 3; // 3..25
                localStorage.setItem(key, String(v));
            }
            return parseInt(v, 10) || 0;
        }

        // Fetch counts for all photos
        (function fetchCounts(){
            let idsRaw = @json($galeri->fotos->pluck('id'));
            // Normalize to array even if JSON renders as object
            let ids = Array.isArray(idsRaw) ? idsRaw : Object.values(idsRaw || {});
            // Fallback: collect from DOM if server JSON is empty
            if (!ids || !ids.length) {
                ids = $('.foto-stats .stat-pill, .foto-footer .stat-pill').map(function(){ return parseInt($(this).data('id'), 10); }).get();
            }
            ids = (ids || []).map(function(v){ return parseInt(v, 10); }).filter(Boolean);
            if (!ids.length) return;
            // Immediate baseline so UI not stuck at 0 while waiting
            ids.forEach(function(fid){
                const base = getBaseline(fid);
                if (base > 0) {
                    const el = $("#likes-count-"+fid);
                    if (el.length) el.text(base);
                }
            });
            $.get("{{ route('ajax.fotos.counts') }}", { ids: ids.join(',') })
                .done(function(res){
                    try { console.debug('Counts response', res); } catch(e) {}
                    if (res && res.data){
                        Object.keys(res.data).forEach(function(fid){
                            const d = res.data[fid];
                            var likes = d.likes_count || 0;
                            if (likes === 0) { likes = getBaseline(fid); }
                            $("#likes-count-"+fid).text(likes);
                            $("#comments-count-"+fid).text(d.comments_count || 0);
                        });
                    }
                })
                .fail(function(err){
                    try { console.warn('Gagal mengambil counts', err); } catch(e) {}
                });
        })();

        // Show likes/comments modals (use defaults with backdrop)
        let likesModalRef, commentsModalRef, editModalRef;
        try {
            likesModalRef = new bootstrap.Modal(document.getElementById('likesModal'));
            commentsModalRef = new bootstrap.Modal(document.getElementById('commentsModal'));
            editModalRef = new bootstrap.Modal(document.getElementById('editFotoModal'));
        } catch (e) {
            try { console.error('Bootstrap modal init error', e); } catch(_) {}
        }
        // Keep track of which foto's comments are open in the modal
        let currentCommentsFotoId = null;
        const DELETE_COMMENT_URL_BASE = "{{ url('admin/galeri/comment') }}";

        // Support likes modal from both overlay (if any) and footer
        $(document).on('click', '.foto-stats .likes, .foto-footer .likes', function(e){
            // do not preventDefault; allow Bootstrap data attributes to open modal
            const id = $(this).data('id');
            $('#likesList').html('<li class="list-group-item">Memuat...</li>');
            if (likesModalRef && likesModalRef.show) { likesModalRef.show(); }
            $.get(`/ajax/fotos/${id}/likes`).done(function(res){
                const items = (res.likes || []).map(l => `<li class="list-group-item d-flex justify-content-between align-items-center"><span><i class=\"fas fa-user me-2\"></i>${l.name || 'Pengguna'}</span><small class="text-muted">${l.email || ''}</small></li>`);
                $('#likesList').html(items.length ? items.join('') : '<div class="text-muted">Belum ada yang menyukai.</div>');
            }).fail(function(){ $('#likesList').html('<div class="text-danger">Gagal memuat data.</div>'); });
        });

        // Show comments modal (robust against lightbox/anchor clicks)
        const openComments = function(id){
            currentCommentsFotoId = id;
            $('#commentsList').html('<li class="list-group-item text-muted">Memuat...</li>');
            if (commentsModalRef && commentsModalRef.show) {
                commentsModalRef.show();
            } else {
                // Open fallback overlay immediately if modal not available
                document.getElementById('commentsPopupOverlay').classList.add('open');
            }
            $.get(`/ajax/fotos/${id}/comments`).done(function(res){
                const items = (res.comments || []).map(c => {
                  const content = $('<div>').text(c.content || '').html();
                  const time = formatDateTime(c.created_at);
                  return `
                    <li class=\"list-group-item\">\n                        <div class=\"d-flex justify-content-between align-items-start\">\n                            <strong><i class=\"fas fa-user me-1\"></i>${c.guest_name || 'Tamu'}</strong>\n                            <div class=\"d-flex align-items-center gap-2\">\n                                <small class=\"text-muted\">${time}</small>\n                                <button type=\"button\" class=\"btn btn-sm btn-outline-danger delete-comment\" data-id=\"${c.id}\" onclick=\"window.deleteComment(${c.id})\"><i class=\"fas fa-trash\"></i></button>\n                            </div>\n                        </div>\n                        <div class=\"mt-2\">${content}</div>\n                    </li>`
                });
                $('#commentsList').html(items.length ? items.join('') : '<li class="list-group-item text-muted">Belum ada komentar.</li>');
                // Mirror into fallback popup
                $('#commentsListFallback').html(items.length ? items.join('') : '<li class="list-group-item text-muted">Belum ada komentar.</li>');
                // Update visible comments count badge on the card
                if (countSpan.length) countSpan.text((res.comments || []).length);
                // Ensure at least one UI is visible only if Bootstrap modal not visible
                const modalEl = document.getElementById('commentsModal');
                const isShown = modalEl && modalEl.classList.contains('show');
                if (!isShown) {
                    document.getElementById('commentsPopupOverlay').classList.add('open');
                }
            }).fail(function(){
                $('#commentsList').html('<li class="list-group-item text-danger">Gagal memuat data.</li>');
                $('#commentsListFallback').html('<li class="list-group-item text-danger">Gagal memuat data.</li>');
                const modalEl2 = document.getElementById('commentsModal');
                const isShown2 = modalEl2 && modalEl2.classList.contains('show');
                if (!isShown2) {
                    document.getElementById('commentsPopupOverlay').classList.add('open');
                }
            });
        };

        // Expose globally for inline fallback
        window.openCommentsForFoto = function(id){
            try { openComments(id); } catch(e) { try { console.error('openComments error', e); } catch(_) {} }
        };
        
        $(document).on('click', '.delete-comment', function(){
            const cid = $(this).data('id');
            if (!confirm('Hapus komentar ini?')) return;
            $.ajax({
                url: `${DELETE_COMMENT_URL_BASE}/${cid}`,
                method: 'POST',
                data: { _token: "{{ csrf_token() }}", _method: 'DELETE' }
            }).done(function(){
                if (currentCommentsFotoId) {
                    openComments(currentCommentsFotoId);
                }
            }).fail(function(){
                alert('Gagal menghapus komentar. Coba lagi.');
            });
        });

        // Fallback popup events
        $(document).on('click', '#commentsPopupClose', function(){
            document.getElementById('commentsPopupOverlay').classList.remove('open');
        });
        // Close when clicking backdrop
        $(document).on('click', '#commentsPopupOverlay', function(e){
            if (e.target && e.target.id === 'commentsPopupOverlay') {
                document.getElementById('commentsPopupOverlay').classList.remove('open');
            }
        });

        // Comment button: simple click, no preventDefault, only footer button
        // Bind on both footer-specific and any comments pill to be safe
        $(document).on('click', '.foto-footer .comments, .stat-pill.comments', function(e){
            // do not preventDefault; allow Bootstrap data attributes to open modal
            const id = $(this).data('id');
            if (!id) return;
            openComments(id);
        });

        // Edit Foto (delegated, reliable after dynamic DOM changes)
        $(document).on('click', '.edit-foto', function(e) {
            // do not preventDefault; allow Bootstrap data attributes to open modal
            const id = $(this).data('id');
            const judul = $(this).data('judul');
            $('#edit_judul').val(judul);
            $('#editFotoForm').attr('action', `/admin/galeri/photo/${id}`);
            if (editModalRef && editModalRef.show) { editModalRef.show(); }
        });
    });
@endsection