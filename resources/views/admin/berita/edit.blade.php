@extends('layouts.admin')

@section('title', 'Edit Berita')

@section('content')
<div class="fade-in">
    <div class="page-header-modern mb-4">
        <div class="page-title-section">
            <h4 class="page-title">
                <i class="fas fa-edit me-3"></i>Edit Berita
            </h4>
            <p class="page-subtitle">Edit berita atau artikel yang sudah ada</p>
        </div>
    </div>

    <div class="modern-table-card">
        <div class="card-body">
                    <form action="{{ route('admin.berita.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="judul" class="form-label">Judul Berita</label>
                                    <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                                           id="judul" name="judul" value="{{ old('judul', $post->judul) }}" required>
                                    @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="gambar" class="form-label">Gambar Berita</label>
                                    <input type="file" class="form-control @error('gambar') is-invalid @enderror" 
                                           id="gambar" name="gambar" accept="image/*">
                                    @if($post->gambar)
                                        <div class="mt-2">
                                            <img src="{{ asset($post->gambar) }}" alt="Gambar saat ini" class="img-thumbnail" style="max-width: 200px;">
                                            <p class="text-muted small">Gambar saat ini</p>
                                        </div>
                                    @endif
                                    @error('gambar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="isi" class="form-label">Isi Berita</label>
                                    <textarea class="form-control @error('isi') is-invalid @enderror" 
                                              id="isi" name="isi" rows="10" required>{{ old('isi', $post->isi) }}</textarea>
                                    @error('isi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="kategori_id" class="form-label">Kategori</label>
                                    <select class="form-select @error('kategori_id') is-invalid @enderror" 
                                            id="kategori_id" name="kategori_id" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}" {{ old('kategori_id', $post->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                            {{ $kategori->nama_kategori }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('kategori_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select @error('status') is-invalid @enderror" 
                                            id="status" name="status" required>
                                        <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>Published</option>
                                    </select>
                                    @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn-modern primary">
                                    <i class="fas fa-save me-2"></i>Update
                                </button>
                                <a href="{{ route('admin.berita.index') }}" class="btn-modern secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
