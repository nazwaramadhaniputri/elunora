@extends('layouts.admin')

@section('title', 'Galeri Foto')

@section('content')
<div class="fade-in">
    <div class="page-header-modern mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div class="page-title-section">
                <h4 class="page-title">
                    <i class="fas fa-images me-3"></i>Galeri Foto
                </h4>
                <p class="page-subtitle">Kelola galeri foto sekolah dengan mudah</p>
            </div>
            <div class="page-actions">
                <button class="btn-modern primary" data-bs-toggle="modal" data-bs-target="#createGaleriModal">
                    <i class="fas fa-plus me-2"></i>Tambah Galeri
                </button>
            </div>
        </div>
    </div>


    <div class="row">
        @forelse($galeris as $galeri)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="modern-gallery-card">
                <div class="gallery-image-container">
                    @if($galeri->fotos->isNotEmpty())
                    <img src="/{{ $galeri->fotos->first()->file }}" class="gallery-image" alt="{{ $galeri->fotos->first()->judul }}">
                    <div class="image-overlay">
                        <div class="overlay-content">
                            <i class="fas fa-eye fa-2x"></i>
                            <p class="mt-2">Lihat Galeri</p>
                        </div>
                    </div>
                    @else
                    <div class="empty-gallery-image">
                        <i class="fas fa-images fa-3x"></i>
                        <p class="mt-3">Belum ada foto</p>
                    </div>
                    @endif
                    
                    <div class="gallery-status-badge">
                        @if($galeri->status == 1)
                        <span class="status-badge published">
                            <i class="fas fa-check-circle me-1"></i>Aktif
                        </span>
                        @else
                        <span class="status-badge draft">
                            <i class="fas fa-pause-circle me-1"></i>Tidak Aktif
                        </span>
                        @endif
                    </div>
                </div>
                
                <div class="gallery-card-body">
                    <h5 class="gallery-title">
                        {{ $galeri->judul ?? ($galeri->post ? $galeri->post->judul : 'Galeri Tanpa Judul') }}
                    </h5>
                    @if($galeri->deskripsi)
                    <p class="gallery-description">{{ Str::limit($galeri->deskripsi, 80) }}</p>
                    @endif
                    <div class="gallery-meta">
                        <div class="meta-item">
                            <i class="fas fa-images"></i>
                            <span>{{ $galeri->fotos->count() }} foto</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-calendar-alt"></i>
                            <span>{{ $galeri->created_at ? $galeri->created_at->format('d M Y') : 'N/A' }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="gallery-card-actions">
                    <div class="action-buttons-gallery">
                        <a href="{{ route('admin.galeri.show', $galeri->id) }}" class="action-btn info" title="Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                        <button class="action-btn primary" onclick="editGaleri({{ $galeri->id }}, '{{ $galeri->judul }}', '{{ $galeri->deskripsi }}', {{ $galeri->post_id ?? 'null' }}, {{ $galeri->position }}, {{ $galeri->status }})" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="action-btn danger" onclick="deleteGaleri({{ $galeri->id }}, '{{ $galeri->judul }}')" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="modern-card">
                <div class="card-body-modern">
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-images"></i>
                        </div>
                        <h5 class="empty-title">Belum Ada Galeri</h5>
                        <p class="empty-text">Mulai dengan membuat galeri foto pertama Anda</p>
                        <button class="btn-modern primary" data-bs-toggle="modal" data-bs-target="#createGaleriModal">
                            <i class="fas fa-plus me-2"></i>Buat Galeri Pertama
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $galeris->links() }}
    </div>
</div>

<!-- Modal Tambah Galeri -->
<div class="modal fade" id="createGaleriModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.galeri.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-plus me-2"></i>Tambah Galeri Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Judul Galeri *</label>
                                <input type="text" class="form-control" name="judul" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Posisi</label>
                                <input type="number" class="form-control" name="position" value="0" min="0" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" rows="3" placeholder="Deskripsi singkat tentang galeri ini..."></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Terkait Berita</label>
                                <select class="form-control" name="post_id">
                                    <option value="">Tidak terkait berita</option>
                                    @foreach(\App\Models\Post::where('status', 'published')->get() as $post)
                                    <option value="{{ $post->id }}">{{ $post->judul }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <select class="form-control" name="status" required>
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modern secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modern success"><i class="fas fa-save me-2"></i>Simpan Galeri</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Galeri -->
<div class="modal fade" id="editGaleriModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editGaleriForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Galeri</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Judul Galeri *</label>
                                <input type="text" class="form-control" id="edit_judul" name="judul" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Posisi</label>
                                <input type="number" class="form-control" id="edit_position" name="position" min="1" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi</label>
                        <textarea class="form-control" id="edit_deskripsi" name="deskripsi" rows="3"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Terkait Berita</label>
                                <select class="form-control" id="edit_post_id" name="post_id">
                                    <option value="">Tidak terkait berita</option>
                                    @foreach(\App\Models\Post::where('status', 'published')->get() as $post)
                                    <option value="{{ $post->id }}">{{ $post->judul }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <select class="form-control" id="edit_status" name="status" required>
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modern secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modern warning"><i class="fas fa-save me-2"></i>Update Galeri</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
function editGaleri(id, judul, deskripsi, postId, position, status) {
    document.getElementById('editGaleriForm').action = '/admin/galeri/' + id;
    document.getElementById('edit_judul').value = judul || '';
    document.getElementById('edit_deskripsi').value = deskripsi || '';
    document.getElementById('edit_post_id').value = postId || '';
    document.getElementById('edit_position').value = position || 1;
    document.getElementById('edit_status').value = status || 1;
    
    new bootstrap.Modal(document.getElementById('editGaleriModal')).show();
}

function deleteGaleri(id, judul) {
    if (confirm('Apakah Anda yakin ingin menghapus galeri "' + judul + '"?\nSemua foto dalam galeri ini akan ikut terhapus.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/admin/galeri/' + id;
        form.innerHTML = `
            @csrf
            @method('DELETE')
        `;
        document.body.appendChild(form);
        form.submit();
    }
}
</script>