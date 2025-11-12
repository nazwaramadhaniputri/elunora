@extends('layouts.admin')

@section('title', 'Edit Galeri')

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" rel="stylesheet">
<style>
    .dropzone {
        border: 2px dashed var(--elunora-primary);
        border-radius: 10px;
        background: #f8f9fa;
        min-height: 200px;
        padding: 20px;
    }
    .dropzone .dz-message {
        font-weight: 500;
        color: var(--elunora-primary);
        margin: 2em 0;
    }
    .dropzone .dz-message:before {
        content: '\f093';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        font-size: 3em;
        display: block;
        margin-bottom: 10px;
        color: var(--elunora-primary);
    }
    .foto-preview {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        height: 150px;
        width: 200px;
    }
    .foto-actions {
        position: absolute;
        top: 5px;
        right: 5px;
        display: none;
        gap: 4px;
    }
    .foto-actions .btn {
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        font-size: 12px;
        border-radius: 4px;
        opacity: 0.9;
        transition: all 0.2s ease;
    }
    .foto-actions .btn:hover {
        opacity: 1;
        transform: scale(1.05);
    }
    .foto-actions .btn-edit {
        background-color: #6c757d;
        border-color: #6c757d;
    }
    .foto-actions .btn-edit:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }
    .foto-preview:hover .foto-actions {
        display: flex;
    }
    .foto-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .foto-preview:hover {
        transform: translateY(-2px);
    }
    .foto-preview .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(30, 58, 138, 0.8);
        opacity: 0;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .foto-preview:hover .overlay {
        opacity: 1;
    }
    .foto-preview .actions {
        display: flex;
        gap: 10px;
    }
    .btn-edit-foto {
        background: rgba(255,255,255,0.9);
        color: #6c757d;
        border: none;
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        transition: all 0.3s;
        pointer-events: none;
        opacity: 0.7;
    }
    .btn-edit-foto:hover {
        background: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        margin-bottom: 1.5rem;
    }
    .card-header {
        background: #fff;
        color: #333;
        border-radius: 8px 8px 0 0 !important;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #e2e8f0;
    }
    .card-body {
        padding: 1.5rem;
    }
    .form-label {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #4a5568;
    }
    .form-control, .form-select {
        border-radius: 6px;
        padding: 0.5rem 1rem;
        border: 1px solid #e2e8f0;
        transition: all 0.2s;
    }
    .form-control:focus, .form-select:focus {
        border-color: var(--elunora-primary);
        box-shadow: 0 0 0 0.2rem rgba(30, 58, 138, 0.15);
    }
    .btn {
        border-radius: 6px;
        padding: 0.5rem 1.25rem;
        font-weight: 500;
        transition: all 0.2s;
    }
    .btn-primary {
        background-color: var(--elunora-primary);
        border-color: var(--elunora-primary);
        min-width: 160px;
    }
    .btn-light {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        min-width: 120px;
    }
    .btn-light:hover {
        background-color: #e9ecef;
        border-color: #dee2e6;
    }
    .form-control, .form-select {
        border-radius: 8px;
        padding: 10px 15px;
        border: 1px solid #e2e8f0;
        background-color: #f8f9fa;
        text-align: center;
        transition: all 0.2s;
        font-size: 0.9375rem; /* 15px */
    }
    .form-control:focus, .form-select:focus {
        border-color: var(--elunora-primary);
        box-shadow: 0 0 0 0.25rem rgba(30, 58, 138, 0.15);
        background-color: #fff;
    }
    .form-control::placeholder {
        text-align: center;
        color: #6c757d;
    }
</style>
@endsection

@section('content')
<div class="fade-in">
    <div class="container-fluid px-4">
        <div class="page-header-modern mb-4">
            <div class="d-flex justify-content-between align-items-start">
                <div class="page-title-section" style="margin-top: 4px;">
                    <h4 class="page-title m-0">
                        <i class="fas fa-images me-3"></i>Edit Galeri
                    </h4>
                </div>
                <a href="{{ route('admin.galeri.index') }}" class="btn" style="background-color: #6c757d; border: none; padding: 10px 24px; border-radius: 20px; font-weight: 500; color: white; height: 40px; display: flex; align-items: center; justify-content: center; margin: 0 0 0 auto; position: relative; top: 4px;">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
            <p class="page-subtitle mb-0">Edit galeri foto yang sudah ada</p>
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
        <div class="col-12">
            <div class="modern-table-card mb-4">
                <div class="card-body">
                    <form action="{{ route('admin.galeri.update', $galeri->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label for="judul" class="form-label fw-bold">Judul Galeri <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                                   id="judul" name="judul" value="{{ old('judul', $galeri->judul) }}" required
                                   placeholder="Masukkan judul galeri"
                                   style="background-color: transparent; text-align: left; font-size: 1.05rem; border: 1px solid #dee2e6; padding: 12px 16px;">
                            <div class="form-text">Judul yang akan ditampilkan di halaman galeri</div>
                            @error('judul')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="deskripsi" class="form-label fw-bold">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                     id="deskripsi" name="deskripsi" rows="6"
                                     placeholder="Masukkan deskripsi galeri"
                                     style="background-color: transparent; text-align: left; resize: none; font-size: 1.05rem; border: 1px solid #dee2e6; min-height: 150px; padding: 12px 16px;">{{ old('deskripsi', $galeri->deskripsi) }}</textarea>
                            <div class="form-text">Deskripsi singkat tentang isi galeri ini</div>
                            @error('deskripsi')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="category_id" class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select @error('category_id') is-invalid @enderror" 
                                        id="category_id" name="category_id" required
                                        style="background-color: transparent; border: 1px solid #dee2e6; padding: 12px 16px; font-size: 1.05rem;">
                                    <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $galeri->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <label for="post_id" class="form-label fw-bold">Terkait Berita</label>
                                <select class="form-select @error('post_id') is-invalid @enderror" 
                                        id="post_id" name="post_id"
                                        style="background-color: transparent; border: 1px solid #dee2e6; padding: 12px 16px; font-size: 1.05rem;">
                                    <option value="" selected>Pilih Berita (Opsional)</option>
                                    @foreach($posts as $post)
                                        <option value="{{ $post->id }}" {{ old('post_id', $galeri->post_id) == $post->id ? 'selected' : '' }}>
                                            {{ $post->judul }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('post_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="position" class="form-label fw-bold">Posisi Tampilan</label>
                                <input type="number" class="form-control @error('position') is-invalid @enderror" 
                                       id="position" name="position" 
                                       value="{{ old('position', $galeri->position ?? 0) }}" min="0"
                                       style="background-color: transparent; font-size: 1.05rem; border: 1px solid #dee2e6; padding: 12px 16px;">
                                <div class="form-text">Angka lebih kecil akan ditampilkan lebih dulu</div>
                                @error('position')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <label for="status" class="form-label fw-bold">Status</label>
                                <select class="form-select @error('status') is-invalid @enderror" 
                                        id="status" name="status" required
                                        style="background-color: transparent; border: 1px solid #dee2e6; padding: 12px 16px; font-size: 1.05rem;">
                                    <option value="1" {{ (int)old('status', $galeri->status) === 1 ? 'selected' : '' }}>
                                        <i class="fas fa-check-circle me-2"></i>Publikasikan
                                    </option>
                                    <option value="0" {{ (int)old('status', $galeri->status) === 0 ? 'selected' : '' }}>
                                        <i class="far fa-save me-2"></i>Simpan Sebagai Draft
                                    </option>
                                </select>
                                @error('status')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-3 mt-5 pt-4 border-top">
                            <a href="{{ route('admin.galeri.index') }}" class="btn btn-secondary d-flex align-items-center justify-content-center" style="min-width: 150px; height: 38px;">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center" style="min-width: 150px; height: 38px;">
                                <i class="fas fa-save me-2"></i>Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="modern-table-card">
                <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                <h5 class="m-0 fw-bold text-dark">Foto Galeri</h5>
            </div>
            <div class="mt-3">
                <div class="d-flex flex-nowrap overflow-auto pb-3">
                    @foreach($galeri->fotos as $foto)
                        <div class="me-4" style="min-width: 200px;">
                            <div class="foto-preview">
                                <img src="{{ asset($foto->file) }}" alt="{{ $foto->judul }}" onerror="this.src='{{ asset('img/no-image.jpg') }}'" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                                <div class="foto-actions" style="gap: 4px;">
                                    <button type="button" class="btn btn-sm btn-primary p-0" 
                                            data-id="{{ $foto->id }}" 
                                            data-judul="{{ $foto->judul }}" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editFotoModal"
                                            title="Edit Foto"
                                            style="width: 28px; min-width: 28px; height: 28px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px;">
                                        <i class="fas fa-edit" style="font-size: 12px; margin: 0;"></i>
                                    </button>
                                    <form action="{{ route('admin.galeri.delete-photo', $foto->id) }}" method="POST" style="display: inline; margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus foto ini?')"
                                                title="Hapus Foto"
                                                style="width: 28px; height: 28px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px;">
                                            <i class="fas fa-trash" style="font-size: 12px;"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="text-center mt-2 small text-truncate" title="{{ $foto->judul }}">
                                {{ $foto->judul }}
                            </div>
                        </div>
                    @endforeach
                </div>
                
                @if($galeri->fotos->count() == 0)
                    <div class="text-center py-5">
                        <i class="fas fa-images fa-3x text-gray-300 mb-3"></i>
                        <p class="text-muted">Belum ada foto di galeri ini</p>
                    </div>
                @endif
                
                <hr>
                
                <h5 class="mb-3">Unggah Foto Baru</h5>
                    <form action="{{ route('admin.galeri.store-photo', $galeri->id) }}" class="dropzone" id="fotoDropzone">
                        @csrf
                        <div class="dz-message" data-dz-message>
                            <span>Seret file foto ke sini atau klik untuk mengunggah</span>
                            <span class="note">(Foto akan diunggah secara otomatis. Format yang didukung: JPG, PNG, GIF. Ukuran maksimal: 5MB)</span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Foto -->
<div class="modal fade" id="editFotoModal" tabindex="-1" role="dialog" aria-labelledby="editFotoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-top" role="document" style="margin-top: 20px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="editFotoModalLabel">Edit Judul Foto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editFotoForm" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_judul" class="form-label fw-bold">Judul Foto</label>
                        <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                               id="edit_judul" name="judul" 
                               placeholder="Masukkan judul foto"
                               value="{{ old('judul') }}"
                               style="background-color: transparent; border: 1px solid #dee2e6; border-radius: 4px; padding: 12px 16px; font-size: 1.05rem; height: 48px; text-align: left;">
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer px-4 py-3 d-flex justify-content-end" style="gap: 4px;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="min-width: 100px; padding: 8px 12px; font-size: 15px; height: 42px; display: inline-flex; align-items: center; justify-content: center; margin: 0;">
                        <i class="fas fa-times me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary" style="min-width: 100px; padding: 8px 12px; font-size: 15px; height: 42px; display: inline-flex; align-items: center; justify-content: center; margin: 0;">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<style>
    .modal-dialog-top {
        margin: 20px auto 20px auto !important;
    }
    .modal-content {
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid rgba(0, 0, 0, 0.1);
    }
    .modal-header {
        border-bottom: 1px solid #e9ecef;
    }
    .modal-footer {
        border-top: 1px solid #e9ecef;
        background-color: #f8f9fa;
        padding: 1rem;
    }
    /* Ensure consistent form controls */
    .form-control {
        display: block;
        width: 100%;
        padding: 10px 16px;
        font-size: 16px;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 4px;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        height: 46px;
    }
    
    .btn {
        padding: 10px 20px;
        font-size: 16px;
        line-height: 1.5;
        border-radius: 4px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 46px;
    }
</style>

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
<script>
    // Disable auto discover for dropzone
    Dropzone.autoDiscover = false;
    
    $(document).ready(function() {
        // Initialize dropzone
        var myDropzone = new Dropzone("#fotoDropzone", {
            paramName: "file",
            maxFilesize: 5, // MB
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: true,
            dictRemoveFile: "Hapus",
            dictFileTooBig: "File terlalu besar. Ukuran maksimal: 5MB.",
            dictInvalidFileType: "Format file tidak didukung.",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        // Handle dropzone events
        myDropzone.on("success", function(file, response) {
            if (response.success) {
                file.previewElement.classList.add("dz-success");
                // Reload page after successful upload to show new photos
                setTimeout(function() {
                    location.reload();
                }, 1500);
            } else {
                file.previewElement.classList.add("dz-error");
                alert('Gagal mengunggah foto: ' + response.message);
            }
        });
        
        myDropzone.on("error", function(file, errorMessage) {
            file.previewElement.classList.add("dz-error");
        });
        
        // Edit Foto
        $('.edit-foto').on('click', function() {
            const id = $(this).data('id');
            const judul = $(this).data('judul');
            
            $('#edit_judul').val(judul);
            $('#editFotoForm').attr('action', `/admin/galeri/photo/${id}`);
        });
    });
</script>
@endsection