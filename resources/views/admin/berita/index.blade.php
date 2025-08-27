@extends('layouts.admin')

@section('title', 'Berita')

@section('content')
<div class="fade-in">
    <div class="page-header-modern mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div class="page-title-section">
                <h4 class="page-title">
                    <i class="fas fa-newspaper me-3"></i>Berita
                </h4>
                <p class="page-subtitle">Kelola berita dan artikel sekolah</p>
            </div>
            <div class="page-actions">
                <a href="{{ route('admin.berita.create') }}" class="btn-modern primary">
                    <i class="fas fa-plus me-2"></i>Tambah Berita
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
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Tanggal</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($posts as $index => $post)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($post->gambar)
                                        <img src="{{ asset($post->gambar) }}" alt="{{ $post->judul }}" 
                                             class="me-3 rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                        <div class="me-3 bg-light rounded d-flex align-items-center justify-content-center" 
                                             style="width: 50px; height: 50px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <strong>{{ $post->judul }}</strong>
                                        <br><small class="text-muted">{{ Str::limit(strip_tags($post->isi), 50) }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="status-badge published">
                                    <i class="fas fa-tag me-1"></i>{{ $post->kategori->nama_kategori ?? 'Tidak ada kategori' }}
                                </span>
                            </td>
                            <td>{{ $post->created_at ? $post->created_at->format('d/m/Y') : 'N/A' }}</td>
                            <td class="text-center">
                                <div class="action-buttons">
                                    <a href="{{ route('admin.berita.show', $post->id) }}" class="action-btn info" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.berita.edit', $post->id) }}" class="action-btn primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.berita.destroy', $post->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn danger" onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?')" title="Hapus">
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
                                        <i class="fas fa-newspaper"></i>
                                    </div>
                                    <h5 class="empty-title">Belum Ada Berita</h5>
                                    <p class="empty-text">Mulai dengan menambahkan berita pertama</p>
                                    <a href="{{ route('admin.berita.create') }}" class="btn-modern primary">
                                        <i class="fas fa-plus me-2"></i>Tambah Berita
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
    <div class="d-flex justify-content-center">
        {{ $posts->links() }}
    </div>
</div>
@endsection
