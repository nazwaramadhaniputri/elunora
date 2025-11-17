@extends('layouts.admin')

@push('styles')
<style>
    .action-buttons {
        display: flex;
        gap: 5px;
    }
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        font-weight: 600;
        border-radius: 0.25rem;
    }
    .status-badge.published {
        background-color: #d1e7dd;
        color: #0f5132;
    }
    .status-badge.draft {
        background-color: #fff3cd;
        color: #664d03;
    }
    .modern-table {
        width: 100%;
        margin-bottom: 1rem;
        color: #6e707e;
        border-collapse: fixed;
    }
    .modern-table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 0.5px;
        color: #5a5c69;
        border-bottom: 2px solid #e3e6f0;
        padding: 0.75rem 1rem;
        background-color: #f8f9fc;
    }
    .modern-table td {
        padding: 1rem;
        vertical-align: middle;
        border-top: 1px solid #e3e6f0;
    }
    .modern-table tbody tr:hover {
        background-color: #f8f9fc;
    }
    .modern-table-card {
        background: #fff;
        border-radius: 0.35rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        margin-bottom: 1.5rem;
    }
    .table-card-body {
        padding: 1.25rem;
    }
    .page-header-modern {
        margin-bottom: 1.5rem;
    }
    .page-title-section h4 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #4e73df;
        margin-bottom: 0.25rem;
    }
    .page-subtitle {
        color: #858796;
        font-size: 0.85rem;
        margin-bottom: 0;
    }
    .page-actions .btn-modern {
        padding: 0.4rem 1rem;
        font-size: 0.85rem;
        font-weight: 500;
        border-radius: 0.35rem;
        display: inline-flex;
        align-items: center;
    }
    .btn-modern.primary {
        background-color: #4e73df;
        border-color: #4e73df;
        color: #fff;
    }
    .btn-modern.primary:hover {
        background-color: #2e59d9;
        border-color: #2653d4;
    }
    .btn-modern i {
        font-size: 0.8rem;
    }
    .empty-state {
        padding: 2rem 1rem;
        text-align: center;
    }
    .empty-state i {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        color: #d1d3e2;
    }
    
    /* Mengurangi jarak antara tabel dan paginasi */
    .table-responsive {
        margin-bottom: 0.5rem !important;
    }
    
    .pagination {
        margin-top: 0.5rem !important;
        margin-bottom: 0.5rem !important;
    }
    .empty-state h5 {
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
    }
    .empty-state p {
        color: #858796;
        margin-bottom: 1.5rem;
    }
</style>
@endpush

@section('title', 'Log Aktivitas')

@section('content')
<div class="fade-in">
    <div class="page-header-modern mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div class="page-title-section">
                <h4 class="page-title">
                    <i class="fas fa-history me-3"></i>Log Aktifitas
                </h4>
                <p class="page-subtitle">Catatan aktivitas petugas</p>
            </div>
            <div class="page-actions">
                <button type="button" class="btn-modern primary" id="refreshButton" onclick="window.location.reload()">
                    <i class="fas fa-sync-alt me-2"></i>Segarkan
                </button>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="modern-table-card">
        <div class="table-card-body">
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th width="15%">WAKTU</th>
                            <th width="20%">PETUGAS</th>
                            <th width="10%">TIPE AKSI</th>
                            <th>DESKRIPSI</th>
                            <th width="10%">AKSI</th>
                        </tr>
                    </thead>
                        <tbody>
                            @forelse($activityLogs as $log)
                            <tr>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="font-weight-medium">{{ $log->created_at->format('d M Y') }}</span>
                                        <small class="text-muted">{{ $log->created_at->format('H:i:s') }}</small>
                                        <small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
                                    </div>
                                </td>
                                <td>
                                    @if($log->petugas)
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                @php
                                                    $petugas = $log->petugas;
                                                    $userName = $petugas->nama_lengkap ?? $petugas->username ?? 'Petugas';
                                                    $userEmail = $petugas->email ?? null;
                                                    $userPhoto = $petugas->photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($userName).'&background=random';
                                                @endphp
                                                <img class="rounded-circle me-2" src="{{ $userPhoto }}" width="30" height="30" alt="Petugas">
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="font-weight-bold">{{ $userName }}</div>
                                                @if($userEmail)
                                                    <small class="text-muted">{{ $userEmail }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">Sistem</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        @php
                                            $badgeClass = [
                                                'create' => 'success',
                                                'update' => 'primary',
                                                'delete' => 'danger',
                                                'login' => 'info',
                                                'logout' => 'secondary',
                                                'error' => 'warning'
                                            ][$log->action] ?? 'dark';
                                            
                                            $actionLabels = [
                                                'create' => 'Tambah',
                                                'update' => 'Ubah',
                                                'delete' => 'Hapus',
                                                'login' => 'Login',
                                                'logout' => 'Logout'
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $badgeClass }} log-badge">
                                            {{ $actionLabels[$log->action] ?? ucfirst($log->action) }}
                                        </span>
                                    </div>
                                </td>
                                <td class="log-description" title="{{ $log->description }}">
                                    {{ $log->description }}
                                    @if($log->model_type)
                                        <div class="text-muted small mt-1">
                                            {{ class_basename($log->model_type) }}
                                            @if($log->model_id)
                                                #{{ $log->model_id }}
                                            @endif
                                        </div>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="action-buttons d-flex justify-content-center">
                                        <button type="button" class="action-btn info" data-bs-toggle="modal" data-bs-target="#logDetail{{ $log->id }}" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <div class="empty-state">
                                        <i class="fas fa-inbox"></i>
                                        <h5>Belum Ada Aktivitas</h5>
                                        <p>Tidak ada catatan aktivitas yang ditemukan</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($activityLogs->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted small">
                        Menampilkan {{ $activityLogs->firstItem() }} - {{ $activityLogs->lastItem() }} dari {{ $activityLogs->total() }} entri
                    </div>
                    <div class="pagination">
                        {{ $activityLogs->withQueryString()->onEachSide(0)->links('pagination::simple-bootstrap-4') }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>


@foreach($activityLogs as $log)
<!-- Log Detail Modal -->
<div class="modal fade" id="logDetail{{ $log->id }}" tabindex="-1" aria-labelledby="logDetailLabel{{ $log->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logDetailLabel{{ $log->id }}">
                    <i class="fas fa-info-circle text-primary me-2"></i>Detail Aktivitas
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-3 fw-bold">Waktu</div>
                    <div class="col-md-9">
                        {{ $log->created_at->format('d F Y, H:i:s') }}
                        <small class="text-muted">({{ $log->created_at->diffForHumans() }})</small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3 fw-bold">User</div>
                    <div class="col-md-9">
                        @if($log->user)
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <img class="rounded-circle me-2" src="{{ $log->user->photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($log->user->name).'&background=random' }}" width="40" height="40" alt="User">
                                </div>
                                <div class="flex-grow-1">
                                    <div class="font-weight-bold">{{ $log->user->name }}</div>
                                    <div class="text-muted small">{{ $log->user->email }}</div>
                                </div>
                            </div>
                        @else
                            <span class="text-muted">Sistem</span>
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3 fw-bold">Aksi</div>
                    <div class="col-md-9">
                        @php
                            $badgeClass = [
                                'create' => 'success',
                                'update' => 'primary',
                                'delete' => 'danger',
                                'login' => 'info',
                                'logout' => 'secondary',
                                'error' => 'warning'
                            ][$log->action] ?? 'dark';
                        @endphp
                        <span class="badge bg-{{ $badgeClass }}">
                            {{ $actionLabels[$log->action] ?? ucfirst($log->action) }}
                        </span>
                    </div>
                </div>
                @if($log->model_type)
                <div class="row mb-3">
                    <div class="col-md-3 fw-bold">Model</div>
                    <div class="col-md-9">
                        {{ $log->model_type }}
                        @if($log->model_id)
                            <span class="text-muted">(ID: {{ $log->model_id }})</span>
                        @endif
                    </div>
                </div>
                @endif
                <div class="row mb-3">
                    <div class="col-md-3 fw-bold">Deskripsi</div>
                    <div class="col-md-9">
                        {{ $log->description }}
                    </div>
                </div>
                @if(!empty($log->properties) && (is_array($log->properties) || is_object($log->properties)))
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Properti</div>
                        <div class="col-md-9">
                            <pre class="bg-light p-2 rounded"><code>{{ is_string($log->properties) ? $log->properties : json_encode($log->properties, JSON_PRETTY_PRINT) }}</code></pre>
                        </div>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Format JSON in modals
        document.querySelectorAll('pre code').forEach((block) => {
            try {
                const data = JSON.parse(block.textContent);
                block.textContent = JSON.stringify(data, null, 2);
                hljs.highlightElement(block);
            } catch (e) {
                // If not valid JSON, leave as is
            }
        });
    });
</script>
@endpush

@endsection
