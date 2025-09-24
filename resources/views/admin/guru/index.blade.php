@extends('layouts.admin')

@section('title', 'Manajemen Guru & Staff')

@section('content')
<div class="fade-in">
    <div class="page-header-modern mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div class="page-title-section">
                <h4 class="page-title">
                    <i class="fas fa-chalkboard-teacher me-3"></i>Manajemen Guru & Staff
                </h4>
                <p class="page-subtitle">Kelola data guru dan staff sekolah</p>
            </div>
            <div class="page-actions">
                <a href="{{ route('admin.guru.create') }}" class="btn-modern primary">
                    <i class="fas fa-plus me-2"></i>Tambah Guru
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="modern-table-card">
        <div class="table-card-body">
            <div class="table-responsive">
                <table class="modern-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Foto</th>
                                    <th>Nama</th>
                                    <th>NIP</th>
                                    <th>Jabatan</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($gurus as $guru)
                                <tr>
                                    <td>{{ $loop->iteration + ($gurus->currentPage() - 1) * $gurus->perPage() }}</td>
                                    <td>
                                        @if($guru->foto)
                                            <img src="{{ asset($guru->foto) }}" alt="{{ $guru->nama }}" 
                                                 class="rounded-circle" width="50" height="50" style="object-fit: cover; object-position: center top;">
                                        @else
                                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" 
                                                 style="width: 50px; height: 50px;">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $guru->nama }}</strong>
                                    </td>
                                    <td>{{ $guru->nip ?: '-' }}</td>
                                    <td>{{ $guru->jabatan }}</td>
                                    <td>{{ $guru->mata_pelajaran ?: '-' }}</td>
                                    <td>
                                        @if($guru->status)
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
                                            <a href="{{ route('admin.guru.show', $guru->id) }}" class="action-btn info" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.guru.edit', $guru->id) }}" class="action-btn primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.guru.destroy', $guru->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus guru ini?')">
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
                                    <td colspan="9" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-chalkboard-teacher fa-3x mb-3"></i>
                                            <p>Belum ada data guru.</p>
                                            <a href="{{ route('admin.guru.create') }}" class="btn-modern primary">
                                                <i class="fas fa-plus me-2"></i>Tambah Guru Pertama
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

    <!-- Pagination -->
    @if($gurus->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $gurus->links() }}
        </div>
    @endif
</div>
@endsection
