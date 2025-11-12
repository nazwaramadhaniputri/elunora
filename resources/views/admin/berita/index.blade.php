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
                <button type="button" class="btn-modern primary" data-bs-toggle="modal" data-bs-target="#modalCreateBerita">
                    <i class="fas fa-plus me-2"></i>Tambah Berita
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
                                    <button type="button" class="action-btn primary btn-open-edit" 
                                            title="Edit"
                                            data-id="{{ $post->id }}"
                                            data-judul="{{ $post->judul }}"
                                            data-kategori="{{ $post->kategori_id }}"
                                            data-isi="{{ htmlspecialchars(strip_tags($post->isi)) }}"
                                            data-gambar-url="{{ $post->gambar ? asset($post->gambar) : '' }}"
                                            data-bs-toggle="modal" data-bs-target="#modalEditBerita">
                                        <i class="fas fa-edit"></i>
                                    </button>
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

@section('modals')
@php($allCategories = \App\Models\Kategori::all())
<!-- Modal: Create Berita -->
<div class="modal fade" id="modalCreateBerita" tabindex="-1" aria-labelledby="modalCreateBeritaLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCreateBeritaLabel"><i class="fas fa-plus me-2"></i>Tambah Berita</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-8">
              <label class="form-label fw-semibold">Judul</label>
              <input type="text" name="judul" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold">Kategori</label>
              <select name="kategori_id" class="form-select" required>
                <option value="" disabled selected>Pilih Kategori</option>
                @foreach($allCategories as $kat)
                  <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Isi Berita</label>
              <textarea name="isi" class="form-control" rows="8" required></textarea>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Gambar (opsional)</label>
              <input type="file" name="gambar" class="form-control" accept="image/*">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-modern secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn-modern primary"><i class="fas fa-save me-2"></i>Simpan</button>
        </div>
      </form>
    </div>
  </div>
  </div>

<!-- Modal: Edit Berita -->
<div class="modal fade" id="modalEditBerita" tabindex="-1" aria-labelledby="modalEditBeritaLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditBeritaLabel"><i class="fas fa-edit me-2"></i>Edit Berita</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formEditBerita" action="" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="_method" value="PUT">
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-8">
              <label class="form-label fw-semibold">Judul</label>
              <input type="text" name="judul" id="editjudul" class="form-control" value="{{ old('judul') }}" required>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold">Kategori</label>
              <select name="kategori_id" id="editkategori" class="form-select" required>
                <option value="">Pilih Kategori</option>
                @foreach($allCategories as $kat)
                  <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Isi Berita</label>
              <textarea name="isi" id="editisi" class="form-control" rows="8" required>{{ old('isi') }}</textarea>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Gambar (opsional)</label>
              <input type="file" name="gambar" class="form-control" accept="image/*">
              <div class="form-text">Biarkan kosong jika tidak mengubah gambar.</div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-modern secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn-modern primary"><i class="fas fa-save me-2"></i>Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
@parent
<script>
// Solusi sederhana untuk menangani modal
$(document).ready(function() {
    // Fungsi untuk menutup modal dengan animasi smooth
    function closeModal(modalId) {
        const $modal = $('#' + modalId);
        
        // Trigger animasi fade out
        $modal.removeClass('show');
        $modal.css('display', 'block');
        $modal.addClass('fade-out');
        
        // Tunggu animasi selesai (300ms sesuai durasi animasi Bootstrap)
        setTimeout(() => {
            // Sembunyikan modal
            $modal.modal('hide');
            
            // Hapus backdrop
            $('.modal-backdrop').remove();
            
            // Reset body
            $('body')
                .removeClass('modal-open')
                .css('overflow', '')
                .css('padding-right', '');
                
            // Reset class modal
            $modal.removeClass('fade-out');
        }, 300);
    }
    
    // Handle tombol close dan batal
    $(document).on('click', '.btn-close, [data-bs-dismiss="modal"], .btn-secondary', function(e) {
        e.preventDefault();
        const modal = $(this).closest('.modal');
        if (modal.length) {
            closeModal(modal.attr('id'));
        }
    });
    
    // Handle klik di luar modal (backdrop)
    $(document).on('click', '.modal', function(e) {
        if (e.target === this) {
            closeModal($(this).attr('id'));
        }
    });
    
    // Handle tombol escape
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape') {
            $('.modal.show').each(function() {
                closeModal($(this).attr('id'));
            });
        }
    });
    
    // Handle tombol edit
    $('.btn-open-edit').on('click', function(e) {
        e.preventDefault();
        
        const id = $(this).data('id');
        const judul = $(this).data('judul') || '';
        const kategori = $(this).data('kategori') || '';
        const isi = $(this).data('isi') || '';
        const gambarUrl = $(this).data('gambar-url') || '';
        
        // Update form action
        $('#formEditBerita').attr('action', '{{ url("admin/berita") }}/' + id);
        
        // Update form fields
        $('#editjudul').val(judul);
        $('#editkategori').val(kategori);
        $('#editisi').val(isi);
        
        // Tampilkan gambar jika ada
        if (gambarUrl) {
            $('#currentImage').html(`
                <div class="mb-3">
                    <label class="form-label fw-semibold">Gambar Saat Ini:</label>
                    <img src="${gambarUrl}" class="img-fluid rounded" style="max-height: 200px;">
                </div>
            `).show();
        } else {
            $('#currentImage').hide();
        }
    });
    
    // Handle form submission
    $('#formEditBerita').on('submit', function(e) {
        e.preventDefault();
        
        const form = $(this);
        const formData = new FormData(this);
        const submitBtn = form.find('button[type="submit"]');
        const originalBtnText = submitBtn.html();
        
        // Tampilkan loading
        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...');
        
        // Kirim form
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Tutup modal
                closeModal('modalEditBerita');
                
                // Tampilkan pesan sukses
                const toast = new bootstrap.Toast(document.getElementById('toastSuccess'));
                $('#toastSuccessMessage').text('Berita berhasil diperbarui');
                toast.show();
                
                // Refresh halaman setelah 1 detik
                setTimeout(() => window.location.reload(), 1000);
            },
            error: function(xhr) {
                let errorMessage = 'Terjadi kesalahan saat menyimpan perubahan';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                alert(errorMessage);
                submitBtn.prop('disabled', false).html(originalBtnText);
            }
        });
    });
});
</script>
@endsection
