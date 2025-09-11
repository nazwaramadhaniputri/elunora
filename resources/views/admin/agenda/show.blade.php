@extends('layouts.admin')

@section('title', 'Detail Agenda')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">
                <i class="fas fa-calendar-alt me-2"></i>Detail Agenda
            </h1>
            <p class="mb-0 text-muted">Informasi lengkap tentang agenda kegiatan</p>
        </div>
        <div>
            <a href="{{ route('admin.agenda.edit', $agenda->id) }}" class="btn-modern warning">
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
                                <h6 class="m-0 font-weight-bold text-primary">Detail Agenda</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <h6 class="font-weight-bold text-gray-700">Tanggal</h6>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-calendar-day text-primary mr-2"></i>
                                        <span>{{ $agenda->tanggal_formatted }}</span>
                                        @if($agenda->is_today)
                                            <span class="badge badge-warning ml-2">Hari ini</span>
                                        @elseif($agenda->is_past)
                                            <span class="badge badge-secondary ml-2">Selesai</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <h6 class="font-weight-bold text-gray-700">Waktu</h6>
                                    <div class="d-flex align-items-center">
                                        <i class="far fa-clock text-primary mr-2"></i>
                                        <span>
                                            {{ $agenda->waktu_mulai_formatted }}
                                            @if($agenda->waktu_selesai)
                                                - {{ $agenda->waktu_selesai_formatted }}
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <h6 class="font-weight-bold text-gray-700">Lokasi</h6>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-map-marker-alt text-primary mr-2"></i>
                                        <span>{{ $agenda->lokasi }}</span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <h6 class="font-weight-bold text-gray-700">Kategori</h6>
                                    <span class="badge badge-primary">{{ $agenda->kategori ?? '-' }}</span>
                                </div>

                                <div class="mb-3">
                                    <h6 class="font-weight-bold text-gray-700">Status</h6>
                                    @if($agenda->status == 'published')
                                        <span class="badge badge-success">Published</span>
                                    @else
                                        <span class="badge badge-secondary">Draft</span>
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

                        <div class="text-center mt-3">
                            <a href="{{ route('admin.agenda.edit', $agenda) }}" class="btn-modern warning btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-edit"></i>
                                </span>
                                <span class="text">Edit Agenda</span>
                            </a>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
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
@endpush
