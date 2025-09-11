@extends('layouts.admin')

@section('title', 'Manajemen Agenda')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">
                <i class="fas fa-calendar-alt me-2"></i>Manajemen Agenda
            </h1>
            <p class="mb-0 text-muted">Kelola jadwal kegiatan dan acara sekolah</p>
        </div>
        <div>
            <a href="{{ route('admin.agenda.create') }}" class="btn-modern primary">
                <i class="fas fa-plus me-2"></i>Tambah Agenda
            </a>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-12">
            <div class="modern-table-card">
                <div class="table-card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row">
                        @forelse($agenda as $index => $item)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="modern-agenda-card">
                                <div class="agenda-image-container">
                                    <div class="agenda-overlay">
                                        <div class="overlay-content">
                                            <i class="fas fa-calendar-alt fa-2x"></i>
                                            <p class="mt-2">Lihat Agenda</p>
                                        </div>
                                    </div>
                                    
                                    <div class="agenda-date-display">
                                        <div class="date-number">{{ \Carbon\Carbon::parse($item->tanggal)->format('d') }}</div>
                                        <div class="date-month">{{ \Carbon\Carbon::parse($item->tanggal)->format('M') }}</div>
                                    </div>
                                    
                                    <div class="agenda-status-badge">
                                        @if(\Carbon\Carbon::parse($item->tanggal)->isToday())
                                            <span class="status-badge today">
                                                <i class="fas fa-calendar-day me-1"></i>Hari Ini
                                            </span>
                                        @elseif(\Carbon\Carbon::parse($item->tanggal)->isPast())
                                            <span class="status-badge completed">
                                                <i class="fas fa-check-circle me-1"></i>Selesai
                                            </span>
                                        @else
                                            <span class="status-badge upcoming">
                                                <i class="fas fa-clock me-1"></i>Akan Datang
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="agenda-card-body">
                                    <h5 class="agenda-title">{{ $item->judul }}</h5>
                                    <p class="agenda-category">{{ $item->kategori ?? 'Umum' }}</p>
                                    
                                    <div class="agenda-meta">
                                        <div class="meta-item">
                                            <i class="fas fa-clock"></i>
                                            <span>{{ \Carbon\Carbon::parse($item->waktu_mulai)->format('H:i') }}{{ $item->waktu_selesai ? ' - ' . \Carbon\Carbon::parse($item->waktu_selesai)->format('H:i') : '' }}</span>
                                        </div>
                                        <div class="meta-item">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <span>{{ $item->lokasi ?? '-' }}</span>
                                        </div>
                                    </div>
                                    
                                    @if($item->deskripsi)
                                    <p class="agenda-description">{{ Str::limit($item->deskripsi, 80) }}</p>
                                    @endif
                                </div>
                                
                                <div class="agenda-card-actions">
                                    <div class="action-buttons-agenda">
                                        <a href="{{ route('admin.agenda.show', $item->id) }}" class="action-btn info" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.agenda.edit', $item->id) }}" class="action-btn primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.agenda.destroy', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn danger" onclick="return confirm('Apakah Anda yakin ingin menghapus agenda ini?')" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="empty-state text-center py-5">
                                <i class="fas fa-calendar-alt fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum Ada Agenda</h5>
                                <p class="text-muted">Mulai dengan menambahkan agenda kegiatan pertama</p>
                                <a href="{{ route('admin.agenda.create') }}" class="btn-modern primary">
                                    <i class="fas fa-plus me-2"></i>Tambah Agenda
                                </a>
                            </div>
                        </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $agenda->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
/* Modern Agenda Card Styles - Similar to Galeri */
.modern-agenda-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: all 0.4s ease;
    border: none;
}

.modern-agenda-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 60px rgba(0,0,0,0.2);
}

.agenda-image-container {
    position: relative;
    height: 180px;
    background: linear-gradient(135deg, #1e3a8a, #3b82f6);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.agenda-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(30, 58, 138, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.3s ease;
    color: white;
}

.modern-agenda-card:hover .agenda-overlay {
    opacity: 1;
}

.overlay-content {
    text-align: center;
    color: white;
    transform: translateY(20px);
    transition: transform 0.3s ease;
}

.modern-agenda-card:hover .overlay-content {
    transform: translateY(0);
}

.agenda-date-display {
    text-align: center;
    color: white;
    z-index: 2;
    position: relative;
}

.date-number {
    font-size: 3rem;
    font-weight: bold;
    line-height: 1;
    text-shadow: 0 2px 10px rgba(0,0,0,0.3);
}

.date-month {
    font-size: 1rem;
    text-transform: uppercase;
    opacity: 0.9;
    font-weight: 600;
    letter-spacing: 1px;
}

.agenda-status-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    z-index: 3;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 25px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-badge.today {
    background: rgba(255, 193, 7, 0.9);
    color: #212529;
}

.status-badge.completed {
    background: rgba(108, 117, 125, 0.9);
    color: white;
}

.status-badge.upcoming {
    background: rgba(40, 167, 69, 0.9);
    color: white;
}

.agenda-card-body {
    padding: 2rem;
}

.agenda-title {
    color: #2c3e50;
    font-weight: 700;
    margin-bottom: 0.5rem;
    font-size: 1.2rem;
}

.agenda-category {
    color: #1e3a8a;
    font-weight: 600;
    margin-bottom: 1rem;
    font-size: 0.9rem;
}

.agenda-meta {
    margin-bottom: 1rem;
}

.meta-item {
    display: flex;
    align-items: center;
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
    color: #6c757d;
}

.meta-item i {
    width: 16px;
    margin-right: 0.5rem;
    color: #1e3a8a;
}

.agenda-description {
    color: #6c757d;
    margin-bottom: 0;
    line-height: 1.6;
    font-size: 0.9rem;
    background: transparent !important;
    border: none !important;
    padding: 0 !important;
}

.agenda-card-actions {
    padding: 1rem 2rem 2rem;
    border-top: 1px solid #f8f9fa;
}

.action-buttons-agenda {
    display: flex;
    gap: 0.5rem;
    justify-content: space-between;
}

.action-buttons-agenda .action-btn {
    flex: 1;
    text-align: center;
    padding: 0.75rem;
    border-radius: 12px;
    transition: all 0.2s ease;
    text-decoration: none;
    border: none;
    font-size: 0.875rem;
    font-weight: 500;
}

.action-buttons-agenda .action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

/* Legacy styles for backward compatibility */
.agenda-date-badge {
    background: linear-gradient(135deg, #1e3a8a, #3b82f6);
    color: white;
    padding: 0.75rem;
    border-radius: 12px;
    text-align: center;
    min-width: 60px;
}

.agenda-details .detail-item {
    display: flex;
    align-items: center;
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

.agenda-details .detail-item:last-child {
    margin-bottom: 0;
}

.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    background: #f8f9fa;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endsection
