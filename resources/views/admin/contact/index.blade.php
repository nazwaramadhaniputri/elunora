@extends('layouts.admin')

@section('title', 'Kelola Pesan Kontak')

@section('content')
<div class="fade-in">
    <div class="page-header-modern mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div class="page-title-section">
                <h4 class="page-title">
                    <i class="fas fa-envelope me-3"></i>Kelola Pesan Kontak
                </h4>
                <p class="page-subtitle">Kelola semua pesan masuk dari pengunjung</p>
            </div>
            <div class="page-actions">
                <div class="stats-summary">
                    <span class="stat-badge unread">
                        <i class="fas fa-envelope me-1"></i>{{ $contacts->where('status', 0)->count() }} Belum Dibaca
                    </span>
                    <span class="stat-badge read ms-2">
                        <i class="fas fa-envelope-open me-1"></i>{{ $contacts->where('status', 1)->count() }} Sudah Dibaca
                    </span>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="modern-table-card">
        <div class="table-card-body">
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th width="60">#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Subjek</th>
                            <th>Tanggal</th>
                            <th width="100">Status</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contacts as $contact)
                        <tr class="{{ $contact->status == 0 ? 'unread-message' : '' }}">
                            <td>{{ $loop->iteration + ($contacts->currentPage() - 1) * $contacts->perPage() }}</td>
                            <td>
                                <div class="contact-info">
                                    <strong>{{ $contact->nama }}</strong>
                                    @if($contact->status == 0)
                                        <span class="new-badge">BARU</span>
                                    @endif
                                </div>
                            </td>
                            <td>{{ $contact->email }}</td>
                            <td>
                                <div class="message-preview">
                                    <strong>{{ $contact->subjek }}</strong>
                                    <p class="message-snippet">{{ Str::limit($contact->pesan, 50) }}</p>
                                </div>
                            </td>
                            <td>
                                <div class="date-info">
                                    <span class="date">{{ $contact->created_at->format('d M Y') }}</span>
                                    <span class="time">{{ $contact->created_at->format('H:i') }}</span>
                                </div>
                            </td>
                            <td>
                                @if($contact->status == 0)
                                    <span class="status-badge draft">
                                        <i class="fas fa-envelope me-1"></i>Belum Dibaca
                                    </span>
                                @else
                                    <span class="status-badge published">
                                        <i class="fas fa-envelope-open me-1"></i>Sudah Dibaca
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.contact.show', $contact->id) }}" class="action-btn info" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($contact->status == 0)
                                        <form action="{{ route('admin.contact.read', $contact->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="action-btn success" title="Tandai Sudah Dibaca">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.contact.unread', $contact->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="action-btn warning" title="Tandai Belum Dibaca">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.contact.destroy', $contact->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="fas fa-envelope fa-3x text-muted"></i>
                                    </div>
                                    <h5 class="empty-title">Belum Ada Pesan</h5>
                                    <p class="empty-text">Belum ada pesan masuk dari pengunjung</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if($contacts->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $contacts->links() }}
        </div>
    @endif
</div>
@endsection

@section('styles')
<style>
.stats-summary {
    display: flex;
    align-items: center;
}

.stat-badge {
    padding: 0.5rem 1rem;
    border-radius: 25px;
    font-size: 0.875rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
}

.stat-badge.unread {
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: white;
}

.stat-badge.read {
    background: linear-gradient(135deg, #28a745, #1e7e34);
    color: white;
}

.unread-message {
    background: linear-gradient(135deg, #fff3cd 0%, #ffffff 100%);
    border-left: 4px solid #ffc107;
}

.contact-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.new-badge {
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: white;
    font-size: 0.7rem;
    padding: 0.2rem 0.5rem;
    border-radius: 10px;
    font-weight: 600;
}

.message-preview strong {
    color: var(--elunora-dark);
    font-weight: 600;
}

.message-snippet {
    color: var(--elunora-secondary);
    font-size: 0.875rem;
    margin: 0.25rem 0 0 0;
    line-height: 1.4;
}

.date-info {
    display: flex;
    flex-direction: column;
    gap: 0.2rem;
}

.date-info .date {
    font-weight: 600;
    color: var(--elunora-dark);
}

.date-info .time {
    font-size: 0.875rem;
    color: var(--elunora-secondary);
}
</style>
@endsection
