@extends('layouts.admin')

@section('title', 'Kategori Berita')

@section('content')
<div class="fade-in">
    <div class="page-header-modern mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div class="page-title-section">
                <h4 class="page-title">
                    <i class="fas fa-tags me-3"></i>Kategori Berita
                </h4>
                <p class="page-subtitle">Kelola kategori untuk mengorganisir berita</p>
            </div>
            <div class="page-actions">
                <button type="button" class="btn-modern primary" data-bs-toggle="modal" data-bs-target="#tambahKategoriModal">
                    <i class="fas fa-plus me-2"></i>Tambah Kategori
                </button>
            </div>
        </div>
    </div>

    <div class="modern-table-card">
        <div class="table-card-body">
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th>Nama Kategori</th>
                            <th class="text-center">Jumlah Berita</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kategoris as $index => $kategori)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $kategori->nama_kategori }}</td>
                            <td class="text-center">
                                <span class="status-badge published">
                                    <i class="fas fa-newspaper me-1"></i>{{ $kategori->posts_count }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="action-buttons">
                                    <button type="button" class="action-btn primary edit-kategori" 
                                            data-id="{{ $kategori->id }}" 
                                            data-nama="{{ $kategori->nama_kategori }}" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editKategoriModal"
                                            title="Edit">
                                        <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.berita.kategori.destroy', $kategori->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-tags"></i>
                                </div>
                                <h5 class="empty-title">Belum Ada Kategori</h5>
                                <p class="empty-text">Mulai dengan menambahkan kategori pertama</p>
                                <button type="button" class="btn-modern primary" data-bs-toggle="modal" data-bs-target="#tambahKategoriModal">
                                    <i class="fas fa-plus me-2"></i>Tambah Kategori
                                </button>
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

<!-- Modal Tambah Kategori -->
<div class="modal fade" id="tambahKategoriModal" tabindex="-1" aria-labelledby="tambahKategoriModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.berita.kategori.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahKategoriModalLabel">Tambah Kategori Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror" id="nama_kategori" name="nama_kategori" value="{{ old('nama_kategori') }}" required>
                        @error('nama_kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modern secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modern primary">Tambah Kategori</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Kategori -->
<div class="modal fade" id="editKategoriModal" tabindex="-1" aria-labelledby="editKategoriModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editKategoriForm" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editKategoriModalLabel">Edit Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_nama_kategori" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror" id="edit_nama_kategori" name="nama_kategori" required>
                        @error('nama_kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modern secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modern success">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Edit Kategori
        $('.edit-kategori').on('click', function() {
            const id = $(this).data('id');
            const nama = $(this).data('nama');
            
            $('#edit_nama_kategori').val(nama);
            $('#editKategoriForm').attr('action', `/admin/kategori/${id}`);
        });
    });
</script>
@endsection