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
                <button type="button" class="btn-modern primary" data-bs-toggle="modal" data-bs-target="#modalCreateGuru">
                    <i class="fas fa-plus me-2"></i>Tambah Guru
                </button>
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
                                            <button type="button" class="action-btn primary btn-open-edit" title="Edit"
                                                    data-id="{{ $guru->id }}"
                                                    data-nama="{{ $guru->nama }}"
                                                    data-nip="{{ $guru->nip }}"
                                                    data-jabatan="{{ $guru->jabatan }}"
                                                    data-mapel="{{ $guru->mata_pelajaran }}"
                                                    data-status="{{ $guru->status }}"
                                                    data-bs-toggle="modal" data-bs-target="#modalEditGuru">
                                                <i class="fas fa-edit"></i>
                                            </button>
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

@section('modals')
<!-- Modal: Create Guru -->
<div class="modal fade" id="modalCreateGuru" tabindex="-1" aria-labelledby="modalCreateGuruLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="max-width: 800px;">
    <div class="modal-content" style="min-height: 500px; display: flex; flex-direction: column;">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCreateGuruLabel">Tambah Guru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('admin.guru.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">NIP (opsional)</label>
                <input type="text" name="nip" class="form-control">
              </div>
              <div class="mb-3">
                <label class="form-label">Jabatan</label>
                <input type="text" name="jabatan" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Mata Pelajaran (opsional)</label>
                <input type="text" name="mata_pelajaran" class="form-control">
              </div>
              <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                  <option value="1" selected>Aktif</option>
                  <option value="0">Tidak Aktif</option>
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label">Urutan</label>
                <input type="number" name="urutan" class="form-control" min="1" value="1" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Foto (opsional)</label>
                <input type="file" name="foto" class="form-control" accept="image/*">
              </div>
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

<!-- Modal: Edit Guru -->
<div class="modal fade" id="modalEditGuru" tabindex="-1" aria-labelledby="modalEditGuruLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="max-width: 800px;">
    <div class="modal-content" style="min-height: 500px; display: flex; flex-direction: column;">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditGuruLabel">Edit Guru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formEditGuru" action="#" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="nama" id="eg_nama" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">NIP (opsional)</label>
                <input type="text" name="nip" id="eg_nip" class="form-control">
              </div>
              <div class="mb-3">
                <label class="form-label">Jabatan</label>
                <input type="text" name="jabatan" id="eg_jabatan" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Mata Pelajaran (opsional)</label>
                <input type="text" name="mata_pelajaran" id="eg_mapel" class="form-control">
              </div>
              <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" id="eg_status" class="form-select">
                  <option value="1">Aktif</option>
                  <option value="0">Tidak Aktif</option>
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label">Foto (opsional)</label>
                <input type="file" name="foto" class="form-control" accept="image/*">
                <div class="form-text">Biarkan kosong jika tidak mengubah foto.</div>
              </div>
              <div class="mb-3">
                <label class="form-label">Urutan</label>
                <input type="number" name="urutan" id="eg_urutan" class="form-control" min="1" required>
              </div>
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
      const nip = this.dataset.nip || '';
      const jabatan = this.dataset.jabatan || '';
      const mapel = this.dataset.mapel || '';
      const status = String(this.dataset.status || '1');
      const form = document.getElementById('formEditGuru');
      form.action = '/admin/guru/' + id;
      document.getElementById('eg_nama').value = nama;
      document.getElementById('eg_nip').value = nip;
      document.getElementById('eg_jabatan').value = jabatan;
      document.getElementById('eg_mapel').value = mapel;
      document.getElementById('eg_status').value = status;
    });
  });
});
</script>
@endsection
