@extends('layouts.admin')

@section('title', 'Fasilitas Sekolah')

@section('content')
<div class="fade-in">
    <div class="page-header-modern mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div class="page-title-section">
                <h4 class="page-title">
                    <i class="fas fa-building me-3"></i>Fasilitas Sekolah
                </h4>
                <p class="page-subtitle">Kelola fasilitas dan sarana prasarana sekolah</p>
            </div>
            <div class="page-actions">
                <a href="{{ route('admin.fasilitas.create') }}" class="btn-modern primary">
                    <i class="fas fa-plus me-2"></i>Tambah Fasilitas
                </a>
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
                            <th width="80">Foto</th>
                            <th>Nama Fasilitas</th>
                            <th>Deskripsi</th>
                            <th width="80">Urutan</th>
                            <th width="100">Status</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($fasilitas as $item)
                        <tr>
                            <td>{{ $loop->iteration + ($fasilitas->currentPage() - 1) * $fasilitas->perPage() }}</td>
                            <td>
                                @if($item->foto)
                                    <img src="{{ asset($item->foto) }}" alt="{{ $item->nama }}" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; border-radius: 8px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $item->nama }}</strong>
                            </td>
                            <td>{{ Str::limit($item->deskripsi, 80) }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ $item->urutan }}</span>
                            </td>
                            <td>
                                @if($item->status)
                                    <span class="status-badge published">
                                        <i class="fas fa-check-circle me-1"></i>Aktif
                                    </span>
                                @else
                                    <span class="status-badge draft">
                                        <i class="fas fa-pause-circle me-1"></i>Tidak Aktif
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.fasilitas.show', $item->id) }}" class="action-btn info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.fasilitas.edit', $item->id) }}" class="action-btn primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.fasilitas.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus fasilitas ini?')">
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
                            <td colspan="7" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="fas fa-building fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Belum Ada Fasilitas</h5>
                                    <p class="text-muted">Mulai dengan menambahkan fasilitas sekolah pertama</p>
                                    <a href="{{ route('admin.fasilitas.create') }}" class="btn-modern primary">
                                        <i class="fas fa-plus me-2"></i>Tambah Fasilitas
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if($fasilitas->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $fasilitas->links() }}
        </div>
    @endif
</div>
@endsection
