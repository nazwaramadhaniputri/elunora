@extends('layouts.admin')

@section('title', 'Tambah Galeri')

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" rel="stylesheet">
<style>
    .dropzone {
        border: 2px dashed #0087F7;
        border-radius: 5px;
        background: #F9F9F9;
    }
    .dropzone .dz-message {
        font-weight: 400;
    }
    .dropzone .dz-message .note {
        font-size: 0.8em;
        font-weight: 200;
        display: block;
        margin-top: 1.4rem;
    }
    /* Prevent cards from hugging the sidebar; add safe side gutters on this page */
    .dashboard-safe-gutter { padding-left: 1rem; padding-right: 1rem; }
    @media (min-width: 992px) { .dashboard-safe-gutter { padding-left: 1.5rem; padding-right: 1.5rem; } }
    /* Give submit button more breathing room from the status select */
    #galeriForm .btn-modern.primary { 
        margin-top: 2.5rem;
        margin-bottom: 1.5rem;
        padding: 0.75rem 2rem;
    }
</style>
@endsection

@section('content')
<div class="dashboard-safe-gutter">
<div class="page-header-modern mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div class="page-title-section">
            <h4 class="page-title">
                <i class="fas fa-plus me-3"></i>Tambah Galeri Baru
            </h4>
            <p class="page-subtitle">Buat galeri foto baru untuk sekolah</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.galeri.index') }}" class="btn-modern primary">
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
        <div class="col-lg-12">
            <div class="modern-card mb-3">
                <div class="card-header-modern">
                    <h5 class="card-title-modern">
                        <i class="fas fa-info-circle me-2"></i>Informasi Galeri
                    </h5>
                </div>
                <div class="card-body-modern">
                    <form action="{{ route('admin.galeri.store') }}" method="POST" id="galeriForm" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="form-group">
                            <label for="judul">Judul Galeri *</label>
                            <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul') }}" required>
                            <small class="form-text text-muted">Masukkan judul untuk galeri ini.</small>
                            @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
                            <small class="form-text text-muted">Deskripsi singkat tentang galeri ini.</small>
                            @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="post_id" class="form-label">Terkait Berita (Opsional)</label>
                            <select class="form-control" id="post_id" name="post_id">
                                <option value="">Pilih Berita</option>
                                @foreach($posts as $post)
                                    <option value="{{ $post->id }}" {{ old('post_id') == $post->id ? 'selected' : '' }}>{{ $post->judul }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Kategori Galeri *</label>
                            <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="position">Posisi</label>
                            <input type="number" class="form-control @error('position') is-invalid @enderror" id="position" name="position" value="{{ old('position', 0) }}" min="0" required>
                            <small class="form-text text-muted">Urutan tampilan galeri (angka lebih kecil akan ditampilkan lebih dulu).</small>
                            @error('position')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="0" {{ old('status', '0') == '0' ? 'selected' : '' }}>Draft</option>
                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Publikasikan</option>
                            </select>
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mt-4 mb-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Galeri
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-12">
            <div class="modern-card">
                <div class="card-header-modern">
                    <h5 class="card-title-modern">
                        <i class="fas fa-upload me-2"></i>Unggah Foto
                    </h5>
                </div>
                <div class="card-body-modern">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Simpan informasi galeri terlebih dahulu sebelum mengunggah foto.
                    </div>
                    
                    <div id="uploadSection" class="d-none">
                        <form action="{{ route('admin.galeri.store-photo', 0) }}" class="dropzone" id="fotoDropzone">
                            @csrf
                            <input type="hidden" name="galeri_id" id="galeri_id" value="">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="dz-message" data-dz-message>
                                <span>Seret file foto ke sini atau klik untuk mengunggah</span>
                                <span class="note">(Foto akan diunggah secara otomatis. Format yang didukung: JPG, PNG, GIF. Ukuran maksimal: 5MB)</span>
                            </div>
                        </form>
                        
                        <div class="text-center mt-4">
                            <a href="#" id="viewGaleriBtn" class="btn-modern primary d-none">
                                <i class="fas fa-eye me-2"></i>Lihat Galeri
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
<script>
    // Disable auto discover for dropzone
    Dropzone.autoDiscover = false;
    
    $(document).ready(function() {
        // Check if we have a galeri_id (edit mode)
        var galeriId = $('#galeri_id').val();
        
        if (galeriId) {
            initializeDropzone(galeriId);
            $('#uploadSection').removeClass('d-none');
            $('#viewGaleriBtn').attr('href', '/admin/galeri/' + galeriId).removeClass('d-none');
        }
        
        // Handle form submission
        $('#galeriForm').on('submit', function(e) {
            // Client-side validation
            var isValid = true;
            var errorMessage = '';
            
            // Check required fields
            $(this).find('[required]').each(function() {
                if (!$(this).val()) {
                    var fieldName = $(this).attr('name');
                    var label = $('label[for="' + $(this).attr('id') + '"]').text().replace('*', '').trim();
                    errorMessage += '- ' + label + ' harus diisi\n';
                    isValid = false;
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Mohon lengkapi semua field yang wajib diisi:\n\n' + errorMessage);
                return false;
            }
            
            // If we get here, form is valid and will submit normally
            return true;
        });
        
        function initializeDropzone(galeriId) {
            // Initialize dropzone only if it hasn't been initialized yet
            if ($('#fotoDropzone').hasClass('dz-clickable')) return;
            
            var myDropzone = new Dropzone("#fotoDropzone", {
                url: '/admin/galeri/' + galeriId + '/store-photo',
                paramName: "file",
                maxFilesize: 5, // MB
                acceptedFiles: ".jpeg,.jpg,.png,.gif",
                addRemoveLinks: true,
                dictRemoveFile: "Hapus",
                dictFileTooBig: "File terlalu besar. Ukuran maksimal: 5MB.",
                dictInvalidFileType: "Format file tidak didukung.",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                init: function() {
                    this.on("success", function(file, response) {
                        if (response.success) {
                            file.previewElement.classList.add("dz-success");
                            // Update the view button to point to the gallery
                            $('#viewGaleriBtn').attr('href', '/admin/galeri/' + galeriId).removeClass('d-none');
                        } else {
                            file.previewElement.classList.add("dz-error");
                            alert('Gagal mengunggah foto: ' + (response.message || 'Terjadi kesalahan'));
                        }
                    });
                    
                    this.on("error", function(file, errorMessage) {
                        file.previewElement.classList.add("dz-error");
                        alert('Gagal mengunggah foto: ' + (errorMessage || 'Terjadi kesalahan'));
                    });
                }
            });
        }
    });
</script>
@endsection