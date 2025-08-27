@extends('layouts.admin')

@section('title', 'Profil Sekolah')

@section('content')
<div class="fade-in">
    <div class="page-header-modern mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div class="page-title-section">
                <h4 class="page-title">
                    <i class="fas fa-school me-3"></i>Profil Sekolah
                </h4>
                <p class="page-subtitle">Kelola informasi profil sekolah</p>
            </div>
            <div class="page-actions">
                <a href="{{ route('admin.profil.create') }}" class="btn-modern primary">
                    <i class="fas fa-plus me-2"></i>Tambah Profil
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

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="modern-table-card">
        <div class="table-card-body">
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th>Nama Sekolah</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($profiles as $index => $profile)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $profile->nama_sekolah }}</td>
                            <td>{{ $profile->email }}</td>
                            <td>{{ $profile->telepon }}</td>
                            <td class="text-center">
                                <div class="action-buttons">
                                    <a href="{{ route('admin.profil.show', $profile->id) }}" class="action-btn info" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.profil.edit', $profile->id) }}" class="action-btn primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.profil.destroy', $profile->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn danger" onclick="return confirm('Apakah Anda yakin ingin mengedit profil ini?')" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="fas fa-school"></i>
                                    </div>
                                    <h5 class="empty-title">Belum Ada Profil Sekolah</h5>
                                    <p class="empty-text">Mulai dengan menambahkan profil sekolah pertama</p>
                                    <a href="{{ route('admin.profil.create') }}" class="btn-modern primary">
                                        <i class="fas fa-plus me-2"></i>Tambah Profil
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
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
@endsection