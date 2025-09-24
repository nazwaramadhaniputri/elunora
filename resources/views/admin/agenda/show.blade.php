@extends('layouts.admin')

@section('title', 'Detail Agenda')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header-modern d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="page-title mb-0">
                <i class="fas fa-calendar-alt me-2"></i>Detail Agenda
            </h1>
            <p class="page-subtitle mb-0">Informasi lengkap tentang agenda kegiatan</p>
        </div>
        <div>
            <a href="{{ route('admin.agenda.edit', $agenda->id) }}" class="btn-modern primary">
                <i class="fas fa-edit me-2"></i>Edit
            </a>
            <a href="{{ route('admin.agenda.index') }}" class="btn-modern secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="d-flex align-items-center mb-4">
                                <div class="bg-primary text-white p-3 rounded-circle me-3">
                                    <i class="fas fa-calendar-alt fa-2x"></i>
                                </div>
                                <div>
                                    <h2 class="mb-0">{{ $agenda->judul }}</h2>
                                    <div class="text-muted">
                                        <i class="far fa-calendar me-1"></i> {{ \Carbon\Carbon::parse($agenda->tanggal)->translatedFormat('l, d F Y') }}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <h5 class="fw-bold text-primary mb-3">
                                    <i class="fas fa-align-left me-2"></i>Deskripsi Kegiatan
                                </h5>
                                <div class="ps-4 border-start border-3 border-primary">
                                    <p class="mb-0">{{ $agenda->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                                </div>
                            </div>

                            @if($agenda->catatan)
                            <div class="mb-4">
                                <h5 class="fw-bold text-primary mb-3">
                                    <i class="fas fa-sticky-note me-2"></i>Catatan Tambahan
                                </h5>
                                <div class="ps-4 border-start border-3 border-warning">
                                    <p class="mb-0">{{ $agenda->catatan }}</p>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="col-lg-4">
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-light py-3">
                                <h6 class="m-0 fw-bold text-primary">Detail Agenda</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <h6 class="fw-bold text-secondary">Tanggal</h6>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-calendar-day text-primary me-2"></i>
                                        <span>{{ $agenda->tanggal_formatted }}</span>
                                        @if($agenda->is_past)
                                            <span class="badge bg-secondary ms-2">Selesai</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <h6 class="fw-bold text-secondary">Waktu</h6>
                                    <div class="d-flex align-items-center">
                                        <i class="far fa-clock text-primary me-2"></i>
                                        <span>
                                            {{ $agenda->waktu_mulai_formatted ?? (\Carbon\Carbon::parse($agenda->waktu_mulai)->format('H:i')) }}
                                            @if($agenda->waktu_selesai)
                                                - {{ $agenda->waktu_selesai_formatted ?? (\Carbon\Carbon::parse($agenda->waktu_selesai)->format('H:i')) }}
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <h6 class="fw-bold text-secondary">Lokasi</h6>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                        <span>{{ $agenda->lokasi }}</span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <h6 class="fw-bold text-secondary">Kategori</h6>
                                    <span class="badge bg-primary">{{ $agenda->kategori ?? '-' }}</span>
                                </div>

                                <div class="mb-3">
                                    <h6 class="fw-bold text-secondary">Status</h6>
                                    @if((string)$agenda->status === '1')
                                        <span class="badge bg-success">Published</span>
                                    @else
                                        <span class="badge bg-secondary">Draft</span>
                                    @endif
                                </div>

                                <hr>

                                <div class="small">
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">Dibuat</span>
                                        <span>{{ $agenda->created_at->format('d M Y H:i') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">Diperbarui</span>
                                        <span>{{ $agenda->updated_at->format('d M Y H:i') }}</span>
                                    </div>
                                </div>
                            </div>
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
    .card {
        border-radius: 0.5rem;
    }
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid rgba(0,0,0,.125);
    }
    .info-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin-right: 1rem;
    }
</style>
@endsection
