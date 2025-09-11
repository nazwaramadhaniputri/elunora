@extends('layouts.admin')

@section('title', 'Detail Fasilitas')

@section('content')
<div class="fade-in">
    <div class="page-header-modern mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div class="page-title-section">
                <h4 class="page-title">
                    <i class="fas fa-building me-3"></i>Detail Fasilitas
                </h4>
                <p class="page-subtitle">Informasi lengkap fasilitas sekolah</p>
            </div>
            <div class="page-actions">
                <a href="{{ route('admin.fasilitas.index') }}" class="btn-modern secondary me-2">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
                <a href="{{ route('admin.fasilitas.edit', $fasilitas->id) }}" class="btn-modern primary">
                    <i class="fas fa-edit me-2"></i>Edit Data
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5">
            <div class="modern-card">
                <div class="card-body-modern">
                    <div class="facility-photo-container mb-4">
                        @if($fasilitas->foto)
                            <img src="{{ asset($fasilitas->foto) }}" alt="{{ $fasilitas->nama }}" 
                                 class="facility-photo img-fluid rounded"
                                 onerror="this.src='{{ asset('img/no-image.jpg') }}'">
                        @else
                            <div class="facility-photo-placeholder">
                                <i class="fas fa-building fa-4x text-muted"></i>
                                <p class="text-muted mt-2">Tidak ada foto</p>
                            </div>
                        @endif
                    </div>
                    
                    <div class="facility-status text-center">
                        @if($fasilitas->status)
                            <span class="status-badge published">
                                <i class="fas fa-check-circle me-1"></i>Aktif
                            </span>
                        @else
                            <span class="status-badge draft">
                                <i class="fas fa-pause-circle me-1"></i>Tidak Aktif
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-7">
            <div class="modern-card">
                <div class="card-header-modern">
                    <h5 class="card-title-modern">
                        <i class="fas fa-info-circle me-2"></i>Informasi Detail
                    </h5>
                </div>
                <div class="card-body-modern">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="info-item">
                                <label class="info-label">Nama Fasilitas</label>
                                <div class="info-value">{{ $fasilitas->nama }}</div>
                            </div>
                        </div>
                        
                        <div class="col-12 mb-3">
                            <div class="info-item">
                                <label class="info-label">Deskripsi</label>
                                <div class="info-value">{{ $fasilitas->deskripsi }}</div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="info-item">
                                <label class="info-label">Urutan</label>
                                <div class="info-value">{{ $fasilitas->urutan }}</div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="info-item">
                                <label class="info-label">Status</label>
                                <div class="info-value">
                                    @if($fasilitas->status)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Tidak Aktif</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12 mb-3">
                            <div class="info-item">
                                <label class="info-label">Tanggal Dibuat</label>
                                <div class="info-value">{{ $fasilitas->created_at->format('d F Y, H:i') }} WIB</div>
                            </div>
                        </div>
                        
                        <div class="col-12 mb-3">
                            <div class="info-item">
                                <label class="info-label">Terakhir Diupdate</label>
                                <div class="info-value">{{ $fasilitas->updated_at->format('d F Y, H:i') }} WIB</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.facility-photo-container {
    position: relative;
    width: 100%;
    max-height: 300px;
    overflow: hidden;
    border-radius: 15px;
}

.facility-photo {
    width: 100%;
    height: 300px;
    object-fit: cover;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 123, 255, 0.2);
}

.facility-photo-placeholder {
    width: 100%;
    height: 300px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 15px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    border: 2px dashed var(--elunora-secondary);
}

.info-item {
    margin-bottom: 1rem;
}

.info-label {
    font-weight: 600;
    color: var(--elunora-secondary);
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
    display: block;
}

.info-value {
    color: var(--elunora-dark);
    font-size: 1rem;
    font-weight: 500;
    line-height: 1.6;
}
</style>
@endsection
