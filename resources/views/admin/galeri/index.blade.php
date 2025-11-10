@extends('layouts.admin')

@section('title', 'Galeri Foto')

@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="fade-in">
    <div class="page-header-modern mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div class="page-title-section">
                <h4 class="page-title">
                    <i class="fas fa-images me-3"></i>Galeri Foto
                </h4>
                <p class="page-subtitle">Kelola galeri foto sekolah dengan mudah</p>
            </div>
            <div class="page-actions">
                <button class="btn-modern primary" data-bs-toggle="modal" data-bs-target="#createGaleriModal">
                    <i class="fas fa-plus me-2"></i>Tambah Galeri
                </button>
            </div>
        </div>
    </div>

    <div class="row">
        @forelse($galeris as $galeri)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="modern-gallery-card">
                <div class="gallery-image-container">
                    @if($galeri->fotos->isNotEmpty())
                    <img src="/{{ $galeri->fotos->first()->file }}" class="gallery-image" alt="{{ $galeri->fotos->first()->judul }}">
                    <div class="image-overlay">
                        <div class="overlay-content">
                            <i class="fas fa-eye fa-2x"></i>
                            <p class="mt-2">Lihat Galeri</p>
                        </div>
                    </div>
                    @else
                    <div class="empty-gallery-image">
                        <i class="fas fa-images fa-3x text-muted"></i>
                    </div>
                    @endif
                    
                    <div class="gallery-badges" style="position: absolute; top: 10px; left: 0; right: 0; z-index: 2; display: flex; justify-content: space-between; padding: 0 15px;">
                        @if($galeri->category)
                        <span style="background: rgba(30, 58, 138, 0.15); color: #1e3a8a; padding: 0.5em 1.2em; border-radius: 20px; font-size: 0.95rem; font-weight: 600; display: inline-flex; align-items: center; height: 30px; border: 1px solid rgba(30, 58, 138, 0.3);">
                            <i class="fas fa-tag me-1" style="font-size: 0.9em; color: #1e3a8a;"></i>{{ $galeri->category->name }}
                        </span>
                        @else
                        <span></span> <!-- Empty span to maintain flex layout -->
                        @endif
                        
                        @if($galeri->status == 1)
                        <span style="background: rgba(16, 185, 129, 0.15); color: #10b981; padding: 0.5em 1.2em; border-radius: 20px; font-size: 0.95rem; font-weight: 600; display: inline-flex; align-items: center; height: 30px; border: 1px solid rgba(16, 185, 129, 0.3);">
                            <i class="fas fa-check-circle me-1" style="font-size: 0.9em; color: #10b981;"></i>Aktif
                        </span>
                        @else
                        <span style="background: rgba(245, 158, 11, 0.15); color: #d97706; padding: 0.5em 1.2em; border-radius: 20px; font-size: 0.95rem; font-weight: 600; display: inline-flex; align-items: center; height: 30px; border: 1px solid rgba(245, 158, 11, 0.3);">
                            <i class="fas fa-pause-circle me-1" style="font-size: 0.9em; color: #d97706;"></i>Tidak Aktif
                        </span>
                        @endif
                    </div>
                </div>
                
                <div class="gallery-card-body">
                    <h5 class="gallery-title">
                        {{ $galeri->judul ?? ($galeri->post ? $galeri->post->judul : 'Galeri Tanpa Judul') }}
                    </h5>
                    @if($galeri->deskripsi)
                    <p class="gallery-description">{{ Str::limit($galeri->deskripsi, 80) }}</p>
                    @endif
                    <div class="gallery-meta">
                        <div class="meta-item">
                            <i class="fas fa-images"></i>
                            <span>{{ $galeri->fotos->count() }} foto</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-calendar-alt"></i>
                            <span>{{ $galeri->created_at ? $galeri->created_at->format('d M Y') : 'N/A' }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="gallery-card-actions">
                    <div class="action-buttons-gallery">
                        <a href="{{ route('admin.galeri.show', $galeri->id) }}" class="action-btn info" title="Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                        <button class="action-btn primary edit-galeri"
                            data-bs-toggle="modal"
                            data-bs-target="#editGaleriModal"
                            data-id="{{ $galeri->id }}"
                            data-judul="{{ addslashes($galeri->judul) }}"
                            data-deskripsi="{{ addslashes($galeri->deskripsi ?? '') }}"
                            data-post-id="{{ $galeri->post_id ?? '' }}"
                            data-category-id="{{ $galeri->category_id ?? '' }}"
                            data-status="{{ $galeri->status ?? '1' }}"
                            data-position="{{ $galeri->position ?? '0' }}"
                            title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form action="{{ route('admin.galeri.destroy', $galeri->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus galeri ini? Tindakan ini tidak dapat dibatalkan.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn danger" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="modern-card">
                <div class="card-body-modern">
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-images"></i>
                        </div>
                        <h5 class="empty-title">Belum Ada Galeri</h5>
                        <p class="empty-text">Mulai dengan membuat galeri foto pertama Anda</p>
                        <button class="btn-modern primary" data-bs-toggle="modal" data-bs-target="#createGaleriModal">
                            <i class="fas fa-plus me-2"></i>Buat Galeri Pertama
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $galeris->links() }}
    </div>
</div>

<!-- Modal Tambah Galeri -->
<div class="modal fade" id="createGaleriModal" tabindex="-1" aria-labelledby="createGaleriModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="createGaleriForm" action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-header" style="background-color: #1e3a8a; color: white;">
                    <h5 class="modal-title"><i class="fas fa-plus-circle me-2"></i>Tambah Galeri Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Judul Galeri <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="judul" id="create_judul" required>
                                <div class="invalid-feedback" id="create_judul_error"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Kategori Galeri</label>
                                <select class="form-select" name="category_id" id="create_category_id">
                                    <option value="">Pilih kategori</option>
                                    @foreach(\App\Models\GalleryCategory::where('status',1)->orderBy('name')->get() as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback" id="create_category_error"></div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" id="create_deskripsi" rows="3"></textarea>
                        <div class="invalid-feedback" id="create_deskripsi_error"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Terkait Berita</label>
                                <select class="form-select" name="post_id" id="create_post_id">
                                    <option value="">Tidak terkait berita</option>
                                    @foreach(\App\Models\Post::where('status', 'published')->get() as $post)
                                    <option value="{{ $post->id }}">{{ $post->judul }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback" id="create_post_error"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Posisi</label>
                                <input type="number" class="form-control" name="position" id="create_position" value="0" style="width: 100%;">
                                <small class="text-muted">Angka lebih kecil akan muncul lebih dulu</small>
                                <div class="invalid-feedback" id="create_position_error"></div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold me-3">Status</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="create_status_active" value="1" checked>
                            <label class="form-check-label" for="create_status_active">Aktif</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="create_status_inactive" value="0">
                            <label class="form-check-label" for="create_status_inactive">Tidak Aktif</label>
                        </div>
                        <div class="invalid-feedback" id="create_status_error"></div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary" id="saveCreateBtn">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Galeri -->
<div class="modal fade" id="editGaleriModal" tabindex="-1" aria-labelledby="editGaleriModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #1e3a8a; color: white;">
                <h5 class="modal-title" id="editGaleriModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Galeri
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editGaleriForm" method="POST" enctype="multipart/form-data" class="update-gallery-form">
                @csrf
                @method('PUT')
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="gallery_id" id="gallery_id" value="">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Judul Galeri <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="judul" id="edit_judul" required>
                                <div class="invalid-feedback" id="judul_error"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Kategori Galeri</label>
                                <select class="form-select" name="category_id" id="edit_category_id">
                                    <option value="">Pilih kategori</option>
                                    @foreach(\App\Models\GalleryCategory::where('status',1)->orderBy('name')->get() as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback" id="category_error"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" id="edit_deskripsi" rows="3"></textarea>
                        <div class="invalid-feedback" id="deskripsi_error"></div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Terkait Berita</label>
                                <select class="form-select" name="post_id" id="edit_post_id">
                                    <option value="">Tidak terkait berita</option>
                                    @foreach(\App\Models\Post::where('status', 'published')->get() as $post)
                                    <option value="{{ $post->id }}">{{ $post->judul }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback" id="post_error"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Posisi</label>
                                <input type="number" class="form-control" name="position" id="edit_position" style="width: 100%;">
                                <small class="text-muted">Angka lebih kecil akan muncul lebih dulu</small>
                                <div class="invalid-feedback" id="position_error"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold me-3">Status</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="status_active" value="1">
                            <label class="form-check-label" for="status_active">Aktif</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="status_inactive" value="0">
                            <label class="form-check-label" for="status_inactive">Tidak Aktif</label>
                        </div>
                        <div class="invalid-feedback" id="status_error"></div>
                    </div>
                </div>
                
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary" id="saveChangesBtn">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        <i class="fas fa-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Custom styles for the edit modal */
    #editGaleriModal .modal-header {
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    #editGaleriModal .modal-footer {
        border-top: 1px solid #eee;
    }
    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    .form-label.required:after {
        content: ' *';
        color: #dc3545;
    }
    .invalid-feedback {
        display: none;
        font-size: 0.875em;
        color: #dc3545;
    }
    .was-validated .form-control:invalid ~ .invalid-feedback,
    .was-validated .form-select:invalid ~ .invalid-feedback {
        display: block;
    }
    
    /* Tambahan styling untuk form edit */
    #editGaleriModal .form-control,
    #editGaleriModal .form-select {
        border-radius: 8px;
        border: 1px solid #ced4da;
        transition: all 0.3s ease;
    }
    
    #editGaleriModal .form-control:focus,
    #editGaleriModal .form-select:focus {
        border-color: #1e3a8a;
        box-shadow: 0 0 0 0.2rem rgba(30, 58, 138, 0.25);
    }
    
    #editGaleriModal .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
    }
    
    #editGaleriModal .modal-body {
        padding: 2rem;
    }
    
    /* Animasi untuk modal */
    #editGaleriModal .modal-content {
        animation: modalFadeIn 0.3s ease-out;
    }
    
    @keyframes modalFadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Event handler untuk saat modal edit ditampilkan
    $('#editGaleriModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Tombol yang memicu modal

        // Ekstrak data dari atribut data-*
        var id = button.data('id');
        var judul = button.data('judul');
        var deskripsi = button.data('deskripsi');
        var postId = button.data('post-id');
        var categoryId = button.data('category-id');
        var status = button.data('status');
        var position = button.data('position');

        // Dapatkan elemen modal
        var modal = $(this);

        // Isi form di dalam modal dengan data yang diekstrak
        modal.find('#edit_judul').val(judul);
        modal.find('#edit_deskripsi').val(deskripsi);
        modal.find('#edit_post_id').val(postId);
        modal.find('#edit_category_id').val(categoryId);
        modal.find('#edit_position').val(position);

        // Atur status radio button
        if (status == 1) {
            modal.find('#status_active').prop('checked', true);
        } else {
            modal.find('#status_inactive').prop('checked', true);
        }

        // Atur action form
        var updateUrl = '{{ url('admin/galeri') }}/' + id;
        modal.find('#editGaleriForm').attr('action', updateUrl);
        modal.find('#gallery_id').val(id);

        // Atur judul modal
        modal.find('#editGaleriModalLabel').html('<i class="fas fa-edit me-2"></i>Edit: ' + judul);
    });

    // ... (kode lain seperti delete, dll bisa ditambahkan di sini)
});
</script>
@endpush

@endsection
