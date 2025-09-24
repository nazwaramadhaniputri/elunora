@extends('layouts.admin')

@section('title', 'Detail Guru')

@section('content')
<div class="fade-in">
    <div class="page-header-modern mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div class="page-title-section">
                <h4 class="page-title">
                    <i class="fas fa-user me-3"></i>Detail Guru & Staff
                </h4>
                <p class="page-subtitle">Informasi lengkap guru dan staff</p>
            </div>
            <div class="page-actions">
                <a href="{{ route('admin.guru.index') }}" class="btn-modern secondary me-2">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
                <a href="{{ route('admin.guru.edit', $guru->id) }}" class="btn-modern primary">
                    <i class="fas fa-edit me-2"></i>Edit Data
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="modern-card">
                <div class="card-body-modern text-center">
                    <div class="teacher-photo-container mb-4">
                        @if($guru->foto)
                            <img src="{{ asset($guru->foto) }}" alt="{{ $guru->nama }}" 
                                 class="teacher-photo img-fluid rounded-circle"
                                 onerror="this.src='{{ asset('img/no-image.jpg') }}'">
                        @else
                            <div class="teacher-photo-placeholder">
                                <i class="fas fa-user fa-4x text-muted"></i>
                            </div>
                        @endif
                    </div>
                    
                    <h4 class="teacher-name">{{ $guru->nama }}</h4>
                    <p class="teacher-position text-primary">{{ $guru->jabatan }}</p>
                    
                    
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="modern-card">
                <div class="card-header-modern">
                    <h5 class="card-title-modern">
                        <i class="fas fa-info-circle me-2"></i>Informasi Detail
                    </h5>
                </div>
                <div class="card-body-modern">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="info-item">
                                <label class="info-label">Nama Lengkap</label>
                                <div class="info-value">{{ $guru->nama }}</div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="info-item">
                                <label class="info-label">NIP</label>
                                <div class="info-value">{{ $guru->nip ?: '-' }}</div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="info-item">
                                <label class="info-label">Jabatan</label>
                                <div class="info-value">{{ $guru->jabatan }}</div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="info-item">
                                <label class="info-label">Mata Pelajaran</label>
                                <div class="info-value">{{ $guru->mata_pelajaran ?: '-' }}</div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="info-item">
                                <label class="info-label">Urutan</label>
                                <div class="info-value">{{ $guru->urutan }}</div>
                            </div>
                        </div>
                        
                        
                        <div class="col-12 mb-3">
                            <div class="info-item">
                                <label class="info-label">Tanggal Dibuat</label>
                                <div class="info-value">{{ $guru->created_at->format('d F Y, H:i') }} WIB</div>
                            </div>
                        </div>
                        
                        <div class="col-12 mb-3">
                            <div class="info-item">
                                <label class="info-label">Terakhir Diupdate</label>
                                <div class="info-value">{{ $guru->updated_at->format('d F Y, H:i') }} WIB</div>
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
.teacher-photo-container {
    position: relative;
    width: 200px;
    height: 200px;
    margin: 0 auto;
}

.teacher-photo {
    width: 200px;
    height: 200px;
    object-fit: cover;
    object-position: center top;
    border: 4px solid var(--elunora-primary);
    box-shadow: 0 10px 30px rgba(0, 123, 255, 0.3);
}

.teacher-photo-placeholder {
    width: 200px;
    height: 200px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 4px solid var(--elunora-secondary);
}

.teacher-name {
    color: var(--elunora-dark);
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.teacher-position {
    font-size: 1.1rem;
    font-weight: 500;
    margin-bottom: 1rem;
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
}
</style>
@endsection
