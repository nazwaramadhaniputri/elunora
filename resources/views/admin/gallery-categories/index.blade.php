@extends('layouts.admin')

@section('title', 'Kategori Galeri')

@section('content')
<div class="fade-in">
    <div class="page-header-modern mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div class="page-title-section">
                <h4 class="page-title">
                    <i class="fas fa-tags me-3"></i>Kategori Galeri
                </h4>
                <p class="page-subtitle">Kelola kategori untuk mengorganisir galeri</p>
            </div>
            <div class="page-actions">
                <button type="button" class="btn-modern primary" data-bs-toggle="modal" data-bs-target="#modalCreateGalleryCategory">
                    <i class="fas fa-plus me-2"></i>Tambah Kategori
                </button>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif

    @php($list = $categories ?? collect())
    <div class="modern-table-card">
        <div class="table-card-body">
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th>Nama Kategori</th>
                            <th class="text-center">Jumlah Galeri</th>
                            <th width="18%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($list as $index => $category)
                        @php($galleryCount = method_exists($category, 'galleries') ? ($category->galleries_count ?? $category->galleries()->where('status',1)->count()) : 0)
                        <tr>
                            <td class="text-center">{{ ($list->firstItem() ?? 1) + $index }}</td>
                            <td>{{ $category->name }}</td>
                            <td class="text-center">
                                <span class="status-badge published">
                                    <i class="fas fa-images me-1"></i>{{ $galleryCount }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="action-buttons">
                                    <button type="button" class="action-btn primary btn-open-edit"
                                            data-id="{{ $category->id }}"
                                            data-name="{{ $category->name }}"
                                            data-slug="{{ $category->slug }}"
                                            data-description="{{ $category->description }}"
                                            data-status="{{ $category->status }}"
                                            data-bs-toggle="modal" data-bs-target="#modalEditGalleryCategory"
                                            title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('admin.gallery-categories.destroy', $category->id) }}" method="POST" class="d-inline">
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
                            <td colspan="4" class="text-center py-4">
                                <div class="empty-state" style="padding: 2rem;">
                                    <div class="empty-icon" style="width:64px;height:64px;"><i class="fas fa-tags"></i></div>
                                    <h5 class="empty-title">Belum Ada Kategori</h5>
                                    <p class="empty-text">Mulai dengan menambahkan kategori pertama</p>
                                    <button type="button" class="btn-modern primary" data-bs-toggle="modal" data-bs-target="#modalCreateGalleryCategory">
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

    <div class="d-flex justify-content-center mt-3">
        {{ $categories->links() }}
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Handle form submission
    $('#createCategoryForm').on('submit', function(e) {
        e.preventDefault();
        
        var form = $(this);
        var formData = form.serialize();
        var submitBtn = form.find('button[type="submit"]');
        var originalBtnText = submitBtn.html();
        
        // Tampilkan loading state
        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...');
        
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            success: function(response) {
                // Tampilkan pesan sukses
                $('#form-message').html('<div class="alert alert-success">' + response.message + '</div>');
                
                // Reset form dan sembunyikan modal setelah 1.5 detik
                setTimeout(function() {
                    $('#modalCreateGalleryCategory').modal('hide');
                    window.location.reload();
                }, 1500);
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;
                var errorHtml = '<div class="alert alert-danger"><ul class="mb-0">';
                
                $.each(errors, function(key, value) {
                    errorHtml += '<li>' + value[0] + '</li>';
                });
                
                errorHtml += '</ul></div>';
                $('#form-message').html(errorHtml);
                
                // Reset button state
                submitBtn.prop('disabled', false).html(originalBtnText);
            }
        });
    });
    
    // Reset form saat modal ditutup
    $('#modalCreateGalleryCategory').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset();
        $('#form-message').empty();
    });
});
</script>
@endsection

@section('modals')
<!-- Modal: Create Gallery Category -->
<div class="modal fade" id="modalCreateGalleryCategory" tabindex="-1" aria-labelledby="modalCreateGalleryCategoryLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fas fa-plus-circle me-2"></i>Tambah Kategori Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="createCategoryForm" action="{{ route('admin.gallery-categories.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div id="form-message"></div>
          <div class="mb-3">
            <label class="form-label fw-bold">Nama Kategori <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" required>
            <input type="hidden" name="status" value="1">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-1"></i> Simpan Kategori
          </button>
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
            <label class="form-label">Nama Kategori</label>
            <input type="text" name="name" id="egc_name" class="form-control" required>
            <input type="hidden" name="status" value="1">
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
      const form = document.getElementById('formEditGalleryCategory');
      form.action = '/admin/gallery-categories/' + id;
      document.getElementById('egc_name').value = name;
    });
  });
});
</script>
@endsection
