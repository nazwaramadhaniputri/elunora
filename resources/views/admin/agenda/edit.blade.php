@extends('layouts.admin')

@section('title', 'Edit Agenda')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">
                <i class="fas fa-edit me-2"></i>Edit Agenda
            </h1>
            <p class="mb-0 text-muted">Perbarui informasi agenda: {{ $agenda->judul }}</p>
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
                    <form action="{{ route('admin.agenda.update', $agenda->id) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        
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
                                                   id="judul" name="judul" value="{{ old('judul', $agenda->judul) }}" required
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
                                                    placeholder="Jelaskan secara rinci tentang agenda kegiatan ini">{{ old('deskripsi', $agenda->deskripsi) }}</textarea>
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
                                                       id="lokasi" name="lokasi" value="{{ old('lokasi', $agenda->lokasi) }}" required
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
                                                    placeholder="Contoh: Peserta diharap hadir 15 menit sebelum acara dimulai">{{ old('catatan', $agenda->catatan) }}</textarea>
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
                                                       id="tanggal" name="tanggal" value="{{ old('tanggal', $agenda->tanggal->format('Y-m-d')) }}" required>
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
                                                               id="waktu_mulai" name="waktu_mulai" value="{{ old('waktu_mulai', $agenda->waktu_mulai) }}" required>
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
                                                               id="waktu_selesai" name="waktu_selesai" value="{{ old('waktu_selesai', $agenda->waktu_selesai ? $agenda->waktu_selesai->format('H:i') : '') }}">
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
                                                <option value="" disabled>Pilih Kategori</option>
                                                <option value="Akademik" {{ old('kategori', $agenda->kategori) == 'Akademik' ? 'selected' : '' }}>Akademik</option>
                                                <option value="Ekstrakurikuler" {{ old('kategori', $agenda->kategori) == 'Ekstrakurikuler' ? 'selected' : '' }}>Ekstrakurikuler</option>
                                                <option value="Rapat" {{ old('kategori', $agenda->kategori) == 'Rapat' ? 'selected' : '' }}>Rapat</option>
                                                <option value="Acara Sekolah" {{ old('kategori', $agenda->kategori) == 'Acara Sekolah' ? 'selected' : '' }}>Acara Sekolah</option>
                                                <option value="Ujian" {{ old('kategori', $agenda->kategori) == 'Ujian' ? 'selected' : '' }}>Ujian</option>
                                                <option value="Lainnya" {{ old('kategori', $agenda->kategori) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                            </select>
                                            @error('kategori')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label fw-bold d-block">Status <span class="text-danger">*</span></label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="status" id="statusDraft" value="0" 
                                                    {{ old('status', $agenda->status) == '0' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="statusDraft">Draft</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="status" id="statusPublished" value="1"
                                                    {{ old('status', $agenda->status) == '1' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="statusPublished">Published</label>
                                            </div>
                                            @error('status')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Status publikasi agenda</div>
                                        </div>
                                </div>
                            </div>
                            </div>
                        </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between border-top pt-4">
                                <button type="reset" class="btn-modern light">
                                    <i class="fas fa-undo me-2"></i>Reset Perubahan
                                </button>
                                <div>
                                    <a href="{{ route('admin.agenda.index') }}" class="btn-modern secondary me-2">
                                        <i class="fas fa-times me-2"></i>Batal
                                    </a>
                                    <button type="submit" class="btn-modern primary">
                                        <i class="fas fa-save me-2"></i>Perbarui Agenda
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    .form-control, .form-select, .form-check-input {
        border-radius: 0.375rem;
    }
    .card {
        border-radius: 0.5rem;
    }
    .input-group-text {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }
    .btn {
        border-radius: 0.375rem;
        padding: 0.5rem 1.25rem;
    }
    .form-check-input:checked {
        background-color: #1e3a8a;
        border-color: #1e3a8a;
    }
</style>
@endpush

@push('scripts')
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
</script>
@endpush
