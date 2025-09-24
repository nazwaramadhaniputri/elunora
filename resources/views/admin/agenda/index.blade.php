@extends('layouts.admin')

@section('title', 'Manajemen Agenda')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header-modern d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="page-title mb-0">
                <i class="fas fa-calendar-alt me-2"></i>Manajemen Agenda
            </h1>
            <p class="page-subtitle mb-0">Kelola jadwal kegiatan dan acara sekolah</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.agenda.create') }}" class="btn-modern primary">
                <i class="fas fa-plus me-2"></i>Tambah Agenda
            </a>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-12">
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
@endsection

@section('styles')
<style>
/* Agenda Card Styles aligned with theme */
.modern-agenda-card {
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}
.modern-agenda-card:hover { transform: translateY(-5px); box-shadow: 0 20px 50px rgba(0,0,0,0.15); }

.agenda-image-container {
    position: relative;
    height: 180px;
    overflow: hidden;
    background: var(--elunora-gradient-primary);
}
/* Removed hover overlay content for cleaner banner */

/* Date and status on top of banner */
.agenda-date-display { position: absolute; left: 0; right: 0; top: 50%; transform: translateY(-50%); text-align: center; color: #fff; z-index: 2; }
.agenda-date-display .date-number { font-size: 3rem; font-weight: 800; line-height: 1; text-shadow: 0 2px 10px rgba(0,0,0,0.3); }
.agenda-date-display .date-month { font-size: 0.9rem; letter-spacing: 1px; font-weight: 700; opacity: 0.95; text-transform: uppercase; }
.agenda-status-badge { position: absolute; top: 15px; right: 15px; z-index: 3; }
.status-badge { padding: 0.35rem 0.75rem; border-radius: 25px; font-size: 0.75rem; font-weight: 700; }
.status-badge.today { background: rgba(255,193,7,0.9); color: #212529; }
.status-badge.completed { background: rgba(108,117,125,0.9); color: #fff; }
.status-badge.upcoming { background: rgba(40,167,69,0.9); color: #fff; }

.agenda-card-body { padding: 1.25rem 1.5rem; flex: 1 1 auto; }
.agenda-title { color: #2c3e50; font-weight: 700; margin: 0 0 0.25rem; font-size: 1.05rem; }
.agenda-category { color: var(--admin-primary); font-weight: 600; margin-bottom: 0.75rem; font-size: 0.85rem; }
.agenda-meta { margin-bottom: 0.75rem; }
.agenda-meta .meta-item { display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; color: #6c757d; }
.agenda-meta .meta-item i { width: 16px; color: var(--admin-primary); }
.agenda-description { color: #6c757d; margin: 0; line-height: 1.6; font-size: 0.9rem; }

.agenda-card-actions { padding: 0.75rem 1.5rem 1.25rem; border-top: 1px solid #f1f5f9; background: rgba(37, 99, 235, 0.02); margin-top: auto; }

/* Footer pills (if needed later) */
.agenda-meta-footer { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem; }
.agenda-meta-footer .meta-left,
.agenda-meta-footer .meta-right { display: inline-flex; align-items: center; gap: 0.4rem; background: #f1f5f9; color: #475569; padding: 0.25rem 0.6rem; border-radius: 9999px; font-size: 0.85rem; font-weight: 600; }
.agenda-meta-footer i { color: var(--admin-primary); width: 16px; text-align: center; }

/* Action buttons: inline and centered; keep theme-consistent colors */
.action-buttons-agenda { display: flex; gap: 0.5rem; align-items: center; justify-content: center; flex-wrap: nowrap; }
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
