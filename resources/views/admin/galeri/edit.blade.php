@extends('layouts.admin')

@section('title', 'Edit Galeri')

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
    .foto-preview {
        position: relative;
        margin-bottom: 20px;
    }
    .foto-preview img {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: 5px;
    }
    .foto-preview .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        opacity: 0;
        transition: opacity 0.3s;
        border-radius: 5px;
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
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Galeri</h1>
        <a href="{{ route('admin.galeri.index') }}" class="d-none d-sm-inline-block btn-modern secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
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
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Galeri</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.galeri.update', $galeri->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label for="judul">Judul Galeri *</label>
                            <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul', $galeri->judul) }}" required>
                            <small class="form-text text-muted">Masukkan judul untuk galeri ini.</small>
                            @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $galeri->deskripsi) }}</textarea>
                            <small class="form-text text-muted">Deskripsi singkat tentang galeri ini.</small>
                            @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="category_id">Kategori Galeri *</label>
                            <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ (old('category_id', $galeri->category_id) == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="post_id">Terkait Berita (Opsional)</label>
                            <select class="form-control @error('post_id') is-invalid @enderror" id="post_id" name="post_id">
                                <option value="">Pilih Berita</option>
                                @foreach($posts as $post)
                                    <option value="{{ $post->id }}" {{ (old('post_id', $galeri->post_id) == $post->id) ? 'selected' : '' }}>{{ $post->judul }}</option>
                                @endforeach
                            </select>
                            @error('post_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="position">Posisi</label>
                            <input type="number" class="form-control @error('position') is-invalid @enderror" id="position" name="position" value="{{ old('position', $galeri->position) }}" min="0" required>
                            <small class="form-text text-muted">Urutan tampilan galeri (angka lebih kecil akan ditampilkan lebih dulu).</small>
                            @error('position')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="0" {{ (old('status', $galeri->status) == '0') ? 'selected' : '' }}>Draft</option>
                                <option value="1" {{ (old('status', $galeri->status) == '1') ? 'selected' : '' }}>Publikasikan</option>
                            </select>
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <div class="mb-3">
                                <label for="post_id" class="form-label">Terkait Berita (Opsional)</label>
                                <select class="form-control" id="post_id" name="post_id">
                                    <option value="">Pilih Berita</option>
                                    @foreach($posts as $post)
                                        <option value="{{ $post->id }}" {{ old('post_id', $galeri->post_id) == $post->id ? 'selected' : '' }}>{{ $post->judul }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Kategori Galeri</label>
                                <select class="form-control" id="category_id" name="category_id" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $galeri->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <small class="form-text text-muted">Pilih berita yang terkait dengan galeri ini (opsional).</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="position">Posisi</label>
                            <input type="number" class="form-control @error('position') is-invalid @enderror" id="position" name="position" value="{{ old('position', $galeri->position) }}">
                            <small class="form-text text-muted">Urutan tampilan galeri (angka lebih kecil akan ditampilkan lebih dulu).</small>
                            @error('position')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                                <option value="0" {{ old('status', $galeri->status) == 0 ? 'selected' : '' }}>Draft</option>
                                <option value="1" {{ old('status', $galeri->status) == 1 ? 'selected' : '' }}>Publikasikan</option>
                            </select>
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn-modern success">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Foto Galeri</h6>
                    <a href="{{ route('admin.galeri.show', $galeri->id) }}" class="btn-modern info">
                        <i class="fas fa-eye"></i> Lihat Semua Foto
                    </a>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        @forelse($galeri->fotos as $foto)
                        <div class="col-md-3 col-sm-6">
                            <div class="foto-preview">
                                <img src="{{ asset($foto->file) }}" alt="{{ $foto->judul }}" onerror="this.src='{{ asset('img/no-image.jpg') }}'">
                                <div class="overlay">
                                    <div class="actions">
                                        <button type="button" class="btn btn-sm btn-info edit-foto" 
                                                data-id="{{ $foto->id }}" 
                                                data-judul="{{ $foto->judul }}" 
                                                data-toggle="modal" 
                                                data-target="#editFotoModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.galeri.delete-photo', $foto->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus foto ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="mt-2 text-center">
                                    <small class="text-muted">{{ $foto->judul ?: 'Tanpa judul' }}</small>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center py-4">
                            <i class="fas fa-images fa-3x text-gray-300 mb-3"></i>
                        </div>
                        @endforelse
                    </div>
                    
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
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="editFotoForm" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editFotoModalLabel">Edit Judul Foto</h5>
                    <button type="button" class="btn-modern secondary" onclick="window.history.back()">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </button>
                    <button type="submit" class="btn-modern primary">
                        <i class="fas fa-save me-2"></i>Perbarui Galeri
                    </button>
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