@extends('layouts.admin')

@section('title', 'Detail Galeri')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
<style>
    .foto-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        grid-gap: 15px;
    }
    .foto-item {
        position: relative;
        overflow: hidden;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .foto-item img {
        width: 100%;
        height: 150px;
        object-fit: cover;
        transition: transform 0.3s;
    }
    .foto-item:hover img {
        transform: scale(1.05);
    }
    .foto-caption {
        padding: 10px;
        background: #fff;
        border-top: 1px solid #eee;
    }
    .foto-actions {
        position: absolute;
        top: 5px;
        right: 5px;
        display: flex;
        gap: 5px;
    }
    .foto-actions .btn {
        opacity: 1; /* always fully visible */
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .foto-item:hover .foto-actions .btn { opacity: 1; }
    /* Improve overlay action button visibility over images (keep global colors) */
    .foto-actions .action-btn {
        width: 40px;
        height: 40px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.12);
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    /* Make delete button (hapus) look like the screenshot: soft pink tile + solid red icon */
    .foto-actions .action-btn.danger {
        background: #fde7ea !important; /* soft pink tile */
        color: var(--admin-danger) !important; /* solid red icon */
        border-radius: 12px !important; /* rounded square */
        border: none !important;
        box-shadow: 0 2px 8px rgba(220, 53, 69, 0.18) !important; /* soft red shadow */
        outline: none !important;
    }
    .foto-actions .action-btn.danger:hover,
    .foto-actions .action-btn.danger:focus,
    .foto-actions .action-btn.danger:active {
        background: #fde7ea !important; /* keep same color */
        color: var(--admin-danger) !important;
        border: none !important;
        box-shadow: 0 3px 10px rgba(220, 53, 69, 0.22) !important; /* slightly stronger */
        transform: translateY(-1px);
        outline: none !important;
    }

    /* Ensure the trash icon is clearly visible and centered */
    .foto-actions .action-btn.danger i {
        color: var(--admin-danger) !important;
        font-size: 16px;
        line-height: 1;
    }
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
                <p class="page-subtitle">Kelola foto dan informasi galeri</p>
            </div>
            <div class="page-actions">
                <a href="{{ route('admin.galeri.edit', $galeri->id) }}" class="btn-modern primary me-2">
                    <i class="fas fa-edit me-2"></i>Edit Galeri
                </a>
                <a href="{{ route('admin.galeri.index') }}" class="btn-modern secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="row">
        <div class="col-lg-4">
            <!-- Informasi Galeri -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Galeri</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Status:</strong>
                        @if($galeri->status == 1)
                        <span class="badge badge-success">Dipublikasikan</span>
                        @else
                        <span class="badge badge-warning">Draft</span>
                        @endif
                    </div>
                    
                    <div class="mb-3">
                        <strong>Posisi:</strong>
                        <p>{{ $galeri->position }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Jumlah Foto:</strong>
                        <p>{{ $galeri->fotos->count() }} foto</p>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Tanggal Dibuat:</strong>
                        <p>{{ \Carbon\Carbon::parse($galeri->created_at)->format('d M Y H:i') }}</p>
                    </div>
                    
                    @if($galeri->post)
                    <div class="mb-3">
                        <strong>Berita Terkait:</strong>
                        <p>
                            <a href="#">
                                {{ $galeri->post->judul }}
                            </a>
                        </p>
                    </div>
                    @endif
                    
                    
                    <div class="mt-3">
                        <a href="{{ route('galeri.detail', $galeri->id) }}" class="btn-modern info btn-block" target="_blank">
                            <i class="fas fa-eye"></i> Lihat di Halaman Publik
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Tambah Foto -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tambah Foto</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.galeri.store-photo', $galeri->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="form-group">
                            <label for="file">Pilih Foto</label>
                            <input type="file" class="form-control-file @error('file') is-invalid @enderror" id="file" name="file" required>
                            <small class="form-text text-muted">Format: JPG, PNG, GIF. Maks: 5MB</small>
                            @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="judul">Judul Foto</label>
                            <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul') }}" placeholder="Masukkan judul foto (opsional)">
                            @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn-modern primary mt-3">
                            <i class="fas fa-plus me-2"></i>Upload Foto
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-8">
            <!-- Daftar Foto -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Foto</h6>
                    <span class="badge badge-info">{{ $galeri->fotos->count() }} Foto</span>
                </div>
                <div class="card-body">
                    @if($galeri->fotos->isNotEmpty())
                    <div class="foto-grid">
                        @foreach($galeri->fotos as $foto)
                        <div class="foto-item">
                            <a href="{{ asset($foto->file) }}" data-lightbox="galeri" data-title="{{ $foto->judul ?: 'Foto Galeri' }}">
                                <img src="{{ asset($foto->file) }}" alt="{{ $foto->judul }}" onerror="this.src='{{ asset('img/no-image.jpg') }}'">
                            </a>
                            <div class="foto-actions">
                                <button type="button" class="action-btn primary edit-foto" data-id="{{ $foto->id }}" data-judul="{{ $foto->judul }}" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.galeri.delete-photo', $foto->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn danger" onclick="return confirm('Apakah Anda yakin ingin menghapus foto ini?')" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="foto-caption">
                                <small>{{ $foto->judul ?: 'Tanpa judul' }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-images fa-4x text-gray-300 mb-3"></i>
                        <h5 class="text-gray-700">Belum ada foto</h5>
                        <p class="text-gray-500">Unggah foto pertama untuk galeri ini.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Foto -->
<div class="modal fade" id="editFotoModal" tabindex="-1" role="dialog" aria-labelledby="editFotoModalLabel" aria-hidden="true">
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
                    <button type="submit" class="btn-modern success">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<script>
    $(document).ready(function() {
        // Configure lightbox
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'albumLabel': "Foto %1 dari %2"
        });
        
        // Edit Foto
        $('.edit-foto').on('click', function() {
            const id = $(this).data('id');
            const judul = $(this).data('judul');
            
            $('#edit_judul').val(judul);
            $('#editFotoForm').attr('action', `/admin/galeri/photo/${id}`);
            $('#editFotoModal').modal('show');
        });
    });
</script>
@endsection