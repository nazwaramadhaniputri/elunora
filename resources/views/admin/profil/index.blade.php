@extends('layouts.admin')

@section('title', 'Profile Sekolah')

@section('content')
<div class="fade-in">
    <div class="page-header-modern mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div class="page-title-section">
                <h4 class="page-title">
                    <i class="fas fa-school me-3"></i>Profile Sekolah
                </h4>
                <p class="page-subtitle">Kelola informasi profile sekolah</p>
            </div>
            <div class="page-actions">
                @if($profiles->count() > 0)
                    <a href="{{ route('admin.profil.edit', $profiles->first()->id) }}" class="btn-modern primary">
                        <i class="fas fa-edit me-2"></i>Edit Profile
                    </a>
                @else
                    <a href="{{ route('admin.profil.create') }}" class="btn-modern primary">
                        <i class="fas fa-plus me-2"></i>Tambah Profile
                    </a>
                @endif
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
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3 bg-light rounded d-flex align-items-center justify-content-center" 
                                             style="width: 50px; height: 50px;">
                                            <i class="fas fa-school text-primary"></i>
                                        </div>
                                        <div>
                                            <strong>{{ $profile->nama_sekolah }}</strong>
                                            <br><small class="text-muted">{{ Str::limit($profile->deskripsi ?? 'Profil sekolah', 50) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge published">
                                        <i class="fas fa-envelope me-1"></i>{{ $profile->email }}
                                    </span>
                                </td>
                                <td>{{ $profile->telepon }}</td>
                                <td class="text-center">
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.profil.show', $profile->id) }}" class="action-btn info" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.profil.edit', $profile->id) }}" class="action-btn primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
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
                                        <p class="empty-text">Hubungi administrator untuk menambahkan profil sekolah</p>
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