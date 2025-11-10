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
                <button type="button" class="btn-modern primary" data-bs-toggle="modal" data-bs-target="#modalCreateFasilitas">
                    <i class="fas fa-plus me-2"></i>Tambah Fasilitas
                </button>
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
                                    <button type="button" class="action-btn primary btn-open-edit" title="Edit"
                                            data-id="{{ $item->id }}"
                                            data-nama="{{ $item->nama }}"
                                            data-deskripsi="{{ $item->deskripsi }}"
                                            data-urutan="{{ $item->urutan }}"
                                            data-status="{{ $item->status }}"
                                            data-bs-toggle="modal" data-bs-target="#modalEditFasilitas">
                                        <i class="fas fa-edit"></i>
                                    </button>
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
        <div class="mt-1">
            <nav aria-label="Page navigation" class="d-flex justify-content-end">
                <ul class="pagination mb-0">
                    {{-- Previous Page Link --}}
                    @if ($fasilitas->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">Previous</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $fasilitas->previousPageUrl() }}" rel="prev">Previous</a>
                        </li>
                    @endif

                    {{-- Next Page Link --}}
                    @if ($fasilitas->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $fasilitas->nextPageUrl() }}" rel="next">Next</a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link">Next</span>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    @endif
</div>
@endsection

@section('styles')
<style>
/* Pagination Styles */
/* Pagination container */
.pagination {
    margin: 0.25rem 0 0 0;
    padding: 0.25rem 0;
}

.page-item .page-link {
    color: #4e73df;
    border: 1px solid #d1d3e2;
    padding: 0.25rem 0.85rem;
    margin: 0 0.1rem;
    border-radius: 0.2rem;
    font-size: 0.85rem;
    transition: all 0.15s;
    background: #f8f9fc;
}

.page-item.active .page-link {
    background-color: #4e73df;
    border-color: #4e73df;
    color: white;
}

.page-item .page-link:hover {
    background-color: #e3e6f0;
    border-color: #d1d3e2;
}

.page-item.disabled .page-link {
    color: #b7b9cc;
    pointer-events: none;
    background-color: #f8f9fc;
    border-color: #d1d3e2;
}
</style>
@endsection

@section('modals')
<!-- Modal: Create Fasilitas -->
<div class="modal fade" id="modalCreateFasilitas" tabindex="-1" aria-labelledby="modalCreateFasilitasLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCreateFasilitasLabel">Tambah Fasilitas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('admin.fasilitas.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-8">
              <label class="form-label">Nama Fasilitas</label>
              <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Urutan</label>
              <input type="number" name="urutan" class="form-control" value="1" min="1" required>
            </div>
            <div class="col-12">
              <label class="form-label">Deskripsi</label>
              <textarea name="deskripsi" rows="5" class="form-control" required></textarea>
            </div>
            <div class="col-md-8">
              <label class="form-label">Foto Fasilitas</label>
              <input type="file" name="foto" class="form-control" accept="image/*">
            </div>
            <div class="col-md-4">
              <label class="form-label">Status</label>
              <select name="status" class="form-select">
                <option value="1" selected>Aktif</option>
                <option value="0">Tidak Aktif</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal: Edit Fasilitas -->
<div class="modal fade" id="modalEditFasilitas" tabindex="-1" aria-labelledby="modalEditFasilitasLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditFasilitasLabel">Edit Fasilitas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formEditFasilitas" action="#" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-8">
              <label class="form-label">Nama Fasilitas</label>
              <input type="text" name="nama" id="ef_nama" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Urutan</label>
              <input type="number" name="urutan" id="ef_urutan" class="form-control" min="1" required>
            </div>
            <div class="col-12">
              <label class="form-label">Deskripsi</label>
              <textarea name="deskripsi" id="ef_deskripsi" rows="5" class="form-control" required></textarea>
            </div>
            <div class="col-md-8">
              <label class="form-label">Foto Fasilitas (opsional)</label>
              <input type="file" name="foto" class="form-control" accept="image/*">
              <div class="form-text">Biarkan kosong jika tidak mengubah foto.</div>
            </div>
            <div class="col-md-4">
              <label class="form-label">Status</label>
              <select name="status" id="ef_status" class="form-select">
                <option value="1">Aktif</option>
                <option value="0">Tidak Aktif</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
@parent
<script>
document.addEventListener('DOMContentLoaded', function(){
  document.querySelectorAll('.btn-open-edit').forEach(function(btn){
    btn.addEventListener('click', function(){
      const id = this.dataset.id;
      const nama = this.dataset.nama || '';
      const deskripsi = this.dataset.deskripsi || '';
      const urutan = this.dataset.urutan || '1';
      const status = String(this.dataset.status || '1');
      const form = document.getElementById('formEditFasilitas');
      form.action = '/admin/fasilitas/' + id;
      document.getElementById('ef_nama').value = nama;
      document.getElementById('ef_deskripsi').value = deskripsi;
      document.getElementById('ef_urutan').value = urutan;
      document.getElementById('ef_status').value = status;
    });
  });
});
</script>
@endsection
