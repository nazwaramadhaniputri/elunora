@extends('layouts.admin')

@section('title', 'Tambah Agenda')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header-modern d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="page-title mb-0">
                <i class="fas fa-calendar-plus me-2"></i>Tambah Agenda Baru
            </h1>
            <p class="page-subtitle mb-0">Isi form berikut untuk menambahkan agenda baru</p>
        </div>
        <div>
            <a href="{{ route('admin.agenda.index') }}" class="btn-modern secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.agenda.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="mb-4">
                                    <h5 class="fw-bold text-primary mb-4">
                                        <i class="fas fa-info-circle me-2"></i>Informasi Dasar
                                    </h5>
                                    <div class="ps-4">
                                        <div class="form-group mb-4">
                                            <label for="judul" class="form-label fw-bold">Judul Agenda <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control form-control-lg @error('judul') is-invalid @enderror" 
                                                   id="judul" name="judul" value="{{ old('judul') }}" required
                                                   placeholder="Contoh: Upacara Bendera, Rapat Guru, dll.">
                                            @error('judul')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Judul singkat yang menggambarkan agenda</div>
                                        </div>

                                        <div class="form-group mb-4">
                                            <label for="deskripsi" class="form-label fw-bold">Deskripsi Kegiatan <span class="text-danger">*</span></label>
                                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                                    id="deskripsi" name="deskripsi" rows="5" required
                                                    placeholder="Jelaskan secara rinci tentang agenda kegiatan ini">{{ old('deskripsi') }}</textarea>
                                            @error('deskripsi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Deskripsi lengkap tentang agenda kegiatan</div>
                                        </div>

                                        <div class="form-group mb-4">
                                            <label for="lokasi" class="form-label fw-bold">Lokasi <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light"><i class="fas fa-map-marker-alt text-primary"></i></span>
                                                <input type="text" class="form-control @error('lokasi') is-invalid @enderror" 
                                                       id="lokasi" name="lokasi" value="{{ old('lokasi') }}" required
                                                       placeholder="Contoh: Aula Sekolah, Lapangan Upacara, dll.">
                                                @error('lokasi')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-text">Tempat dilaksanakannya kegiatan</div>
                                        </div>

                                        <div class="mb-4">
                                            <label for="catatan" class="form-label fw-bold">Catatan Tambahan</label>
                                            <textarea class="form-control @error('catatan') is-invalid @enderror" 
                                                    id="catatan" name="catatan" rows="3"
                                                    placeholder="Contoh: Peserta diharap hadir 15 menit sebelum acara dimulai">{{ old('catatan') }}</textarea>
                                            @error('catatan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Catatan tambahan untuk peserta (opsional)</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <h5 class="fw-bold text-primary mb-4">
                                            <i class="far fa-clock me-2"></i>Waktu & Kategori
                                        </h5>
                                        
                                        <div class="mb-4">
                                            <label for="tanggal" class="form-label fw-bold">Tanggal <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light"><i class="far fa-calendar text-primary"></i></span>
                                                <input type="date" class="form-control @error('tanggal') is-invalid @enderror" 
                                                       id="tanggal" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                                @error('tanggal')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label fw-bold">Waktu <span class="text-danger">*</span></label>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-light"><i class="far fa-clock text-primary"></i></span>
                                                        <input type="time" class="form-control @error('waktu_mulai') is-invalid @enderror" 
                                                               id="waktu_mulai" name="waktu_mulai" value="{{ old('waktu_mulai', '08:00') }}" required>
                                                        @error('waktu_mulai')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-text text-center">Mulai</div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-light"><i class="far fa-clock text-primary"></i></span>
                                                        <input type="time" class="form-control @error('waktu_selesai') is-invalid @enderror" 
                                                               id="waktu_selesai" name="waktu_selesai" value="{{ old('waktu_selesai', '10:00') }}">
                                                        @error('waktu_selesai')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-text text-center">Selesai</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label for="kategori" class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                                            <select class="form-select @error('kategori') is-invalid @enderror" 
                                                    id="kategori" name="kategori" required>
                                                <option value="" disabled selected>Pilih Kategori</option>
                                                <option value="Akademik" {{ old('kategori') == 'Akademik' ? 'selected' : '' }}>Akademik</option>
                                                <option value="Ekstrakurikuler" {{ old('kategori') == 'Ekstrakurikuler' ? 'selected' : '' }}>Ekstrakurikuler</option>
                                                <option value="Rapat" {{ old('kategori') == 'Rapat' ? 'selected' : '' }}>Rapat</option>
                                                <option value="Acara Sekolah" {{ old('kategori') == 'Acara Sekolah' ? 'selected' : '' }}>Acara Sekolah</option>
                                                <option value="Ujian" {{ old('kategori') == 'Ujian' ? 'selected' : '' }}>Ujian</option>
                                                <option value="Lainnya" {{ old('kategori') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                            </select>
                                            @error('kategori')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-4">
                                            <label for="status" class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                                            <select class="form-select @error('status') is-invalid @enderror" 
                                                    id="status" name="status" required>
                                                <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Published</option>
                                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Draft</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-center align-items-center gap-2 border-top pt-4 flex-wrap">
                                    <button type="reset" class="btn-modern light">
                                        <i class="fas fa-undo me-2"></i>Reset Form
                                    </button>
                                    <a href="{{ route('admin.agenda.index') }}" class="btn-modern secondary">
                                        <i class="fas fa-times me-2"></i>Batal
                                    </a>
                                    <button type="submit" class="btn-modern primary">
                                        <i class="fas fa-save me-2"></i>Simpan Agenda
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    .form-control, .form-select {
        width: 100% !important; /* same width */
        border-radius: 0.375rem;
        padding: 0.625rem 0.75rem; /* consistent height */
        box-shadow: none !important; /* avoid duplicated box look */
        background-image: none !important; /* prevent extra background */
    }
    /* Ensure large title input behaves the same */
    .form-control.form-control-lg { width: 100% !important; }
    .card {
        border-radius: 0.5rem;
    }
    .input-group-text {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        border-right: 0; /* merge with input visually */
        height: 44px;
    }
    .input-group .form-control {
        border-left: 0; /* merge with input-group-text */
        height: 44px;
    }
    /* Add top breathing space so focus ring is not cut */
    .form-group, .mb-4 { scroll-margin-top: 80px; }
    .form-group .form-control, .mb-4 .form-control, .mb-4 .form-select { margin-top: 2px; }
    .btn {
        border-radius: 0.375rem;
        padding: 0.5rem 1.25rem;
    }
</style>
@endsection

@section('scripts')
<script>
    // Validasi form
    (function () {
        'use strict'
        
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')
        
        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    
                    form.classList.add('was-validated')
                }, false)
            })
    })()

    // Remove any unintended tooltips that may show (e.g., on labels/icons)
    document.addEventListener('DOMContentLoaded', function() {
      const form = document.querySelector('form.needs-validation');
      if (form) {
        form.querySelectorAll('[title]').forEach(function(el){ el.removeAttribute('title'); });
      }
    });
</script>
@endsection
