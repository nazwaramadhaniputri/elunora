@extends('layouts.admin')

@section('title', 'Kategori Galeri')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kategori Galeri</h1>
        <button type="button" class="btn btn-sm btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalCreateGalleryCategory">
            <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Tambah Kategori
        </button>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Kategori Galeri</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama</th>
                            <th>Slug</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $key => $category)
                        <tr>
                            <td>{{ $categories->firstItem() + $key }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->slug }}</td>
                            <td>{{ Str::limit($category->description, 50) }}</td>
                            <td>
                                <span class="badge badge-{{ $category->status ? 'success' : 'danger' }}">
                                    {{ $category->status ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info btn-open-edit"
                                        data-id="{{ $category->id }}"
                                        data-name="{{ $category->name }}"
                                        data-slug="{{ $category->slug }}"
                                        data-description="{{ $category->description }}"
                                        data-status="{{ $category->status }}"
                                        data-bs-toggle="modal" data-bs-target="#modalEditGalleryCategory">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.gallery-categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada kategori galeri</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('modals')
<!-- Modal: Create Gallery Category -->
<div class="modal fade" id="modalCreateGalleryCategory" tabindex="-1" aria-labelledby="modalCreateGalleryCategoryLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCreateGalleryCategoryLabel">Tambah Kategori Galeri</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('admin.gallery-categories.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Slug (opsional)</label>
            <input type="text" name="slug" class="form-control" placeholder="otomatis jika dikosongkan">
          </div>
          <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" rows="3" class="form-control"></textarea>
          </div>
          <div class="mb-2">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
              <option value="1" selected>Aktif</option>
              <option value="0">Tidak Aktif</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
  </div>

<!-- Modal: Edit Gallery Category -->
<div class="modal fade" id="modalEditGalleryCategory" tabindex="-1" aria-labelledby="modalEditGalleryCategoryLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditGalleryCategoryLabel">Edit Kategori Galeri</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formEditGalleryCategory" action="#" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="name" id="egc_name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Slug (opsional)</label>
            <input type="text" name="slug" id="egc_slug" class="form-control" placeholder="otomatis jika dikosongkan">
          </div>
          <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" id="egc_description" rows="3" class="form-control"></textarea>
          </div>
          <div class="mb-2">
            <label class="form-label">Status</label>
            <select name="status" id="egc_status" class="form-select">
              <option value="1">Aktif</option>
              <option value="0">Tidak Aktif</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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
      const name = this.dataset.name || '';
      const slug = this.dataset.slug || '';
      const desc = this.dataset.description || '';
      const status = this.dataset.status || '1';
      const form = document.getElementById('formEditGalleryCategory');
      form.action = '/admin/gallery-categories/' + id;
      document.getElementById('egc_name').value = name;
      document.getElementById('egc_slug').value = slug;
      document.getElementById('egc_description').value = desc;
      document.getElementById('egc_status').value = String(status);
    });
  });
});
</script>
@endsection