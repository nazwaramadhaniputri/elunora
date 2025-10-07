@extends('layouts.admin')

@section('title', 'Detail Galeri')
@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
<style>
    /* Header action buttons: make all same size as 'Kembali' */
    .page-actions .btn-modern {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px; /* unify padding */
        line-height: 1.2;
        white-space: nowrap; /* avoid two-line text */
        border-radius: 22px; /* pill-like to match Kembali */
        height: auto; /* rely on padding */
    }
    .page-actions .btn-modern i { margin-right: 6px; }
    .foto-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr); /* 3 per row */
        grid-gap: 16px;
        padding: 0 6px 28px 6px; /* more bottom padding so last row not stuck to edge */
    }
    @media (max-width: 600px) {
        .foto-grid { grid-template-columns: 1fr; }
    }
    /* Card look for each photo item */
    .foto-item {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 6px 16px rgba(0,0,0,0.08);
        overflow: hidden;
        position: relative; /* create stacking context */
        margin-bottom: 12px; /* extra spacing between rows */
    }
    /* Anchor (image link) sits below footer controls */
    .foto-item > a { position: relative; z-index: 0; display: block; }
    /* Comfortable padding for title under image */
    .foto-caption { padding: 12px 16px 0 16px; }
    .foto-item a img { display: block; border-top-left-radius: 16px; border-top-right-radius: 16px; }

    /* Delete tile: soft pink tile + solid red icon */
    .foto-actions .action-btn.danger,
    .foto-footer .action-btn.danger {
        background: rgba(253, 231, 234, 0.75) !important; /* soft pink tile translucent */
        color: var(--admin-danger) !important; /* solid red icon */
        border-radius: 12px !important; /* rounded square */
        border: none !important;
        box-shadow: 0 2px 8px rgba(220, 53, 69, 0.18) !important; /* soft red shadow */
        outline: none !important;
    }
    /* Keep same colors on hover/focus and add subtle press animation */
    .foto-actions .action-btn.danger:hover,
    .foto-actions .action-btn.danger:focus,
    .foto-footer .action-btn.danger:hover,
    .foto-footer .action-btn.danger:focus {
        background: rgba(253, 231, 234, 0.75) !important;
        color: var(--admin-danger) !important;
        border: none !important;
        box-shadow: 0 2px 8px rgba(220, 53, 69, 0.18) !important;
        outline: none !important;
    }
    /* Press animation for delete like edit */
    .foto-actions .action-btn.danger:active,
    .foto-footer .action-btn.danger:active { transform: translateY(1px) !important; }
    /* Also apply when JS adds .pressing during mousedown */
    .foto-actions .action-btn.danger.pressing,
    .foto-footer .action-btn.danger.pressing { transform: translateY(1px) !important; }
    /* Base tile button size */
    .foto-actions .action-btn,
    .foto-footer .action-btn {
        height: 36px;
        width: 36px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.12);
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.15s ease;
        position: relative;
        z-index: 10; /* above image link */
        pointer-events: auto;
    }
    /* Edit (primary) has subtle press animation */
    .foto-footer .action-btn.primary:active,
    .foto-actions .action-btn.primary:active { transform: translateY(1px); }
    /* Footer row under title: left (like/comment) + right (edit/delete) */
    .foto-footer {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: nowrap;
        margin: 10px 12px 16px 12px; /* extra spacing since caption removed */
        position: relative;
        z-index: 10; /* above image anchor */
        pointer-events: auto;
    }
    .foto-footer .left { display: inline-flex; align-items: center; gap: 8px; }
    .foto-footer .right { display: inline-flex; align-items: center; gap: 8px; margin-left: auto; }
    /* Like/Comment tiles styled like edit tile */
    .stat-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0 10px;
        height: 36px;
        border-radius: 12px;
        border: none;
        outline: none;
        box-shadow: 0 2px 6px rgba(0,0,0,0.12);
        cursor: pointer;
        position: relative;
        z-index: 10;
        pointer-events: auto;
        transition: transform 0.15s ease;
    }
    /* Match tile feel with themed backgrounds */
    .stat-pill.likes {
        background: rgba(220, 38, 38, 0.12); /* red tint */
        color: var(--admin-danger); /* match theme danger */
    }
    .stat-pill.comments {
        background: rgba(100, 116, 139, 0.12); /* slate */
        color: #334155;
    }
    .stat-pill:active { transform: translateY(1px); }
    .stat-pill .count { font-weight: 700; font-size: 13px; }
    /* icon size aligned with action tiles */
    .stat-pill i, .foto-footer .action-btn i { font-size: 16px; line-height: 1; }
    /* Comments interactive; Like non-interactive per request */
    .stat-pill.comments { pointer-events: auto; }
    .stat-pill.likes { pointer-events: none; cursor: default; }
    .foto-footer form { display: inline-flex; margin: 0; padding: 0; }

    /* When any modal is open, disable interactions on overlays to avoid click-through */
    body.modal-open .foto-stats,
    body.modal-open .foto-actions {
        pointer-events: none !important;
    }

    /* Use default Bootstrap modal styles (no transparency) on admin pages */
    .modal { z-index: 1085 !important; }
    .modal-backdrop { z-index: 1080 !important; }

    /* Fallback Comments Popup (custom) */
    .comments-popup-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.5);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 2000; /* above everything */
    }
    .comments-popup-overlay.open { display: flex; }
    .comments-popup {
        width: min(800px, 92vw);
        max-height: 80vh;
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }
    .comments-popup-header { padding: 12px 16px; border-bottom: 1px solid #e5e7eb; display:flex; align-items:center; justify-content:space-between; }
    .comments-popup-title { font-weight: 700; color: #1f2937; }
    .comments-popup-body { padding: 0; overflow: auto; }
    .comments-close-btn { background: transparent; border: none; font-size: 18px; color: #6b7280; cursor: pointer; }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="page-header-modern mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div class="page-title-section">
                <h4 class="page-title">
                    <i class="fas fa-images me-3"></i>Detail Galeri: {{ $galeri->judul ?? ($galeri->post->judul ?? 'Galeri') }}
                </h4>
                <p class="page-subtitle mb-1">{{ $galeri->deskripsi ?? '' }}</p>
                <div class="text-muted small">Dibuat: {{ \Carbon\Carbon::parse($galeri->created_at)->format('d M Y H:i') }}</div>
            </div>

    <!-- Fallback Comments Popup (custom) -->
    <div class="comments-popup-overlay" id="commentsPopupOverlay" aria-hidden="true">
        <div class="comments-popup" role="dialog" aria-modal="true" aria-labelledby="commentsPopupTitle">
            <div class="comments-popup-header">
                <div class="comments-popup-title" id="commentsPopupTitle"><i class="fas fa-comments me-2"></i>Komentar Foto</div>
                <button type="button" class="comments-close-btn" id="commentsPopupClose" title="Tutup" onclick="window.closeCommentsOverlay && window.closeCommentsOverlay()"><i class="fas fa-times"></i></button>
            </div>
            <div class="comments-popup-body">
                <ul class="list-group" id="commentsListFallback">
                    <li class="list-group-item text-muted">Memuat...</li>
                </ul>
            </div>
        </div>
    </div>
            <div class="page-actions d-flex align-items-center gap-2">
                <button type="button" class="btn-modern primary" data-bs-toggle="modal" data-bs-target="#uploadFotoModal">
                    <i class="fas fa-plus me-2"></i>Tambah Foto
                </button>
                <a href="{{ route('admin.galeri.index') }}" class="btn-modern secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Modal Upload Foto -->
    <div class="modal fade" id="uploadFotoModal" tabindex="-1" aria-labelledby="uploadFotoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadFotoModalLabel">Tambah Foto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.galeri.store-photo', $galeri->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="judul_upload">Judul Foto</label>
                            <input type="text" class="form-control" id="judul_upload" name="judul" placeholder="Masukkan judul foto (opsional)">
                        </div>
                        <div class="form-group">
                            <label for="file">Pilih Foto</label>
                            <input type="file" class="form-control-file @error('file') is-invalid @enderror" id="file" name="file" required>
                            <small class="form-text text-muted">Format: JPG, PNG, GIF. Maks: 5MB</small>
                            @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-modern secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-modern primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="row">
        <div class="col-12">
            @if($galeri->fotos->isNotEmpty())
            <div class="foto-grid">
                @foreach($galeri->fotos as $foto)
                <div class="foto-item">
                            <a href="{{ asset($foto->file) }}" data-lightbox="galeri" data-title="{{ $foto->judul ?: 'Foto Galeri' }}">
                                <img src="{{ asset($foto->file) }}" alt="{{ $foto->judul }}" style="height:280px; width:100%; object-fit:cover;" onerror="this.src='{{ asset('img/no-image.jpg') }}'">
                            </a>
                            <!-- Photo title under the image -->
                            <div class="foto-caption">
                                <small>{{ $foto->judul ?: 'Tanpa judul' }}</small>
                            </div>
                            <!-- Footer actions under the photo: left (like/comment), right (edit/delete) -->
                            <div class="foto-footer mt-2">
                                <div class="left">
                                    <button type="button" class="stat-pill likes" data-id="{{ $foto->id }}" title="Jumlah yang menyukai" data-likes-initial="{{ (int) ($likeCounts[$foto->id] ?? 0) }}">
                                        <i class="fas fa-heart"></i>
                                        <span class="count" id="likes-count-{{ $foto->id }}">{{ (int) ($likeCounts[$foto->id] ?? 0) }}</span>
                                    </button>
                                    <button type="button" class="stat-pill comments" data-id="{{ $foto->id }}" title="Lihat komentar" data-comments-initial="{{ (int) ($foto->comments_count ?? 0) }}" onclick="window.openCommentsForFoto && window.openCommentsForFoto({{ $foto->id }})">
                                        <i class="fas fa-comments"></i>
                                        <span class="count" id="comments-count-{{ $foto->id }}">{{ (int) ($foto->comments_count ?? 0) }}</span>
                                    </button>
                                </div>
                                <div class="right">
                                    <button type="button" class="action-btn primary edit-foto" data-id="{{ $foto->id }}" data-judul="{{ $foto->judul }}" title="Edit" data-bs-toggle="modal" data-bs-target="#editFotoModal">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('admin.galeri.delete-photo', $foto->id) }}" method="POST" class="m-0 p-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn danger" onclick="return confirm('Apakah Anda yakin ingin menghapus foto ini?')" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-5">
                <i class="fas fa-images fa-4x text-gray-300 mb-3"></i>
                <h5 class="text-gray-700">Belum ada foto</h5>
                <p class="text-gray-500">Unggah foto pertama untuk galeri ini.</p>
            </div>
            @endif
        </div>
        
        
    </div>
</div>

<!-- Modal Edit Foto -->
<div class="modal fade" id="editFotoModal" tabindex="-1" role="dialog" aria-labelledby="editFotoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="editFotoForm" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editFotoModalLabel">Edit Judul Foto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_judul">Judul Foto</label>
                        <input type="text" class="form-control" id="edit_judul" name="judul">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modern secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modern primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Likes Modal -->
    <div class="modal fade" id="likesModal" tabindex="-1" aria-labelledby="likesModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="likesModalLabel">Disukai oleh</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group" id="likesList"></ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Comments Modal -->
    <div class="modal fade" id="commentsModal" tabindex="-1" aria-labelledby="commentsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="commentsModalLabel">Komentar Foto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="max-height: 60vh; overflow: auto;">
                    <ul class="list-group" id="commentsList">
                        <li class="list-group-item text-muted">Memuat...</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script>
        // Helper: format datetime 'dd MMM yyyy HH:mm'
        function formatDateTime(dt){
            try {
                const d = new Date(dt);
                return d.toLocaleString('id-ID', { day:'2-digit', month:'short', year:'numeric', hour:'2-digit', minute:'2-digit', hour12:false });
            } catch(_) { return dt || ''; }
        }

        // Global helpers for overlay close and delete
        window.closeCommentsOverlay = function(){
            try { document.getElementById('commentsPopupOverlay').classList.remove('open'); } catch(_){ }
        };

        window.deleteComment = function(id){
            if (!id) return;
            if (!confirm('Hapus komentar ini?')) return;
            var url = (typeof DELETE_COMMENT_URL_BASE !== 'undefined') ? (DELETE_COMMENT_URL_BASE + '/' + id) : ('/admin/galeri/comment/' + id);
            fetch(url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: '_token={{ csrf_token() }}&_method=DELETE'
            }).then(function(){
                if (typeof openComments === 'function' && window.currentCommentsFotoId) {
                    openComments(window.currentCommentsFotoId);
                } else {
                    // Refresh fallback list by clicking reopen
                    if (window.currentCommentsFotoId) window.openCommentsForFoto(window.currentCommentsFotoId);
                }
            }).catch(function(){ alert('Gagal menghapus komentar. Coba lagi.'); });
        };

        // Global fallback to guarantee popup shows and loads comments
        window.openCommentsForFoto = window.openCommentsForFoto || function(id){
            try { if (typeof openComments === 'function') { return openComments(id); } } catch(_){ }
            var overlay = document.getElementById('commentsPopupOverlay');
            if (overlay) overlay.classList.add('open');
            // Try to load comments via fetch as a fallback
            try {
                fetch(`/ajax/fotos/${id}/comments`).then(function(r){ return r.json(); }).then(function(res){
                    var list = document.getElementById('commentsListFallback');
                    if (!list) return;
                    var items = (res && res.comments ? res.comments : []).map(function(c){
                        var content = (c.content || '').replace(/[&<>]/g, function(ch){ return ({'&':'&amp;','<':'&lt;','>':'&gt;'}[ch]); });
                        var time = formatDateTime(c.created_at);
                        return '<li class="list-group-item">'
                            + '<div class="d-flex justify-content-between align-items-start">'
                            +   '<strong><i class="fas fa-user me-1"></i>' + (c.guest_name || 'Tamu') + '</strong>'
                            +   '<div class="d-flex align-items-center gap-2">'
                            +       '<small class="text-muted">' + time + '</small>'
                            +       '<button type="button" class="btn btn-sm btn-outline-danger delete-comment" data-id="' + c.id + '" onclick="window.deleteComment(' + c.id + ')"><i class="fas fa-trash"></i></button>'
                            +   '</div>'
                            + '</div>'
                            + '<div class="mt-2">' + content + '</div>'
                            + '</li>';
                    });
                    list.innerHTML = items.length ? items.join('') : '<li class="list-group-item text-muted">Belum ada komentar.</li>';
                }).catch(function(){
                    var list = document.getElementById('commentsListFallback');
                    if (list) list.innerHTML = '<li class="list-group-item text-danger">Gagal memuat data.</li>';
                });
            } catch(_){ }
        };
    </script>
    <script>
        $(document).ready(function() {
            // Ensure modals are not inside transformed stacking contexts
            try { $('#likesModal,#commentsModal,#editFotoModal').appendTo('body'); } catch(_) {}
            // Configure lightbox
            lightbox.option({
                'resizeDuration': 200,
                'wrapAround': true,
                'albumLabel': "Foto %1 dari %2"
            });
            // Press animation for delete buttons even when confirm() interrupts :active
            $(document).on('mousedown touchstart', '.foto-actions .action-btn.danger, .foto-footer .action-btn.danger', function(){
                $(this).addClass('pressing');
            });
            $(document).on('mouseup mouseleave touchend touchcancel blur', '.foto-actions .action-btn.danger, .foto-footer .action-btn.danger', function(){
                $(this).removeClass('pressing');
            });
        
        // Baseline like logic to mirror guest when API returns 0
        function getBaseline(id) {
            const key = 'foto_like_baseline_' + id;
            let v = localStorage.getItem(key);
            if (v === null) {
                v = Math.floor(Math.random() * 23) + 3; // 3..25
                localStorage.setItem(key, String(v));
            }
            return parseInt(v, 10) || 0;
        }

        // Fetch counts for all photos
        (function fetchCounts(){
            let idsRaw = @json($galeri->fotos->pluck('id'));
            // Normalize to array even if JSON renders as object
            let ids = Array.isArray(idsRaw) ? idsRaw : Object.values(idsRaw || {});
            // Fallback: collect from DOM if server JSON is empty
            if (!ids || !ids.length) {
                ids = $('.foto-stats .stat-pill, .foto-footer .stat-pill').map(function(){ return parseInt($(this).data('id'), 10); }).get();
            }
            ids = (ids || []).map(function(v){ return parseInt(v, 10); }).filter(Boolean);
            if (!ids.length) return;
            // Immediate baseline so UI not stuck at 0 while waiting
            ids.forEach(function(fid){
                const base = getBaseline(fid);
                if (base > 0) {
                    const el = $("#likes-count-"+fid);
                    if (el.length) el.text(base);
                }
            });
            $.get("{{ route('ajax.fotos.counts') }}", { ids: ids.join(',') })
                .done(function(res){
                    try { console.debug('Counts response', res); } catch(e) {}
                    if (res && res.data){
                        Object.keys(res.data).forEach(function(fid){
                            const d = res.data[fid];
                            var likes = d.likes_count || 0;
                            if (likes === 0) { likes = getBaseline(fid); }
                            $("#likes-count-"+fid).text(likes);
                            $("#comments-count-"+fid).text(d.comments_count || 0);
                        });
                    }
                })
                .fail(function(err){
                    try { console.warn('Gagal mengambil counts', err); } catch(e) {}
                });
        })();

        // Show likes/comments modals (use defaults with backdrop)
        let likesModalRef, commentsModalRef, editModalRef;
        try {
            likesModalRef = new bootstrap.Modal(document.getElementById('likesModal'));
            commentsModalRef = new bootstrap.Modal(document.getElementById('commentsModal'));
            editModalRef = new bootstrap.Modal(document.getElementById('editFotoModal'));
        } catch (e) {
            try { console.error('Bootstrap modal init error', e); } catch(_) {}
        }
        // Keep track of which foto's comments are open in the modal
        let currentCommentsFotoId = null;
        const DELETE_COMMENT_URL_BASE = "{{ url('admin/galeri/comment') }}";

        // Support likes modal from both overlay (if any) and footer
        $(document).on('click', '.foto-stats .likes, .foto-footer .likes', function(e){
            // do not preventDefault; allow Bootstrap data attributes to open modal
            const id = $(this).data('id');
            $('#likesList').html('<li class="list-group-item">Memuat...</li>');
            if (likesModalRef && likesModalRef.show) { likesModalRef.show(); }
            $.get(`/ajax/fotos/${id}/likes`).done(function(res){
                const items = (res.likes || []).map(l => `<li class="list-group-item d-flex justify-content-between align-items-center"><span><i class=\"fas fa-user me-2\"></i>${l.name || 'Pengguna'}</span><small class="text-muted">${l.email || ''}</small></li>`);
                $('#likesList').html(items.length ? items.join('') : '<div class="text-muted">Belum ada yang menyukai.</div>');
            }).fail(function(){ $('#likesList').html('<div class="text-danger">Gagal memuat data.</div>'); });
        });

        // Show comments modal (robust against lightbox/anchor clicks)
        const openComments = function(id){
            currentCommentsFotoId = id;
            $('#commentsList').html('<li class="list-group-item text-muted">Memuat...</li>');
            if (commentsModalRef && commentsModalRef.show) {
                commentsModalRef.show();
            } else {
                // Open fallback overlay immediately if modal not available
                document.getElementById('commentsPopupOverlay').classList.add('open');
            }
            $.get(`/ajax/fotos/${id}/comments`).done(function(res){
                const items = (res.comments || []).map(c => {
                  const content = $('<div>').text(c.content || '').html();
                  const time = formatDateTime(c.created_at);
                  return `
                    <li class=\"list-group-item\">\n                        <div class=\"d-flex justify-content-between align-items-start\">\n                            <strong><i class=\"fas fa-user me-1\"></i>${c.guest_name || 'Tamu'}</strong>\n                            <div class=\"d-flex align-items-center gap-2\">\n                                <small class=\"text-muted\">${time}</small>\n                                <button type=\"button\" class=\"btn btn-sm btn-outline-danger delete-comment\" data-id=\"${c.id}\" onclick=\"window.deleteComment(${c.id})\"><i class=\"fas fa-trash\"></i></button>\n                            </div>\n                        </div>\n                        <div class=\"mt-2\">${content}</div>\n                    </li>`
                });
                $('#commentsList').html(items.length ? items.join('') : '<li class="list-group-item text-muted">Belum ada komentar.</li>');
                // Mirror into fallback popup
                $('#commentsListFallback').html(items.length ? items.join('') : '<li class="list-group-item text-muted">Belum ada komentar.</li>');
                // Update visible comments count badge on the card
                if (countSpan.length) countSpan.text((res.comments || []).length);
                // Ensure at least one UI is visible only if Bootstrap modal not visible
                const modalEl = document.getElementById('commentsModal');
                const isShown = modalEl && modalEl.classList.contains('show');
                if (!isShown) {
                    document.getElementById('commentsPopupOverlay').classList.add('open');
                }
            }).fail(function(){
                $('#commentsList').html('<li class="list-group-item text-danger">Gagal memuat data.</li>');
                $('#commentsListFallback').html('<li class="list-group-item text-danger">Gagal memuat data.</li>');
                const modalEl2 = document.getElementById('commentsModal');
                const isShown2 = modalEl2 && modalEl2.classList.contains('show');
                if (!isShown2) {
                    document.getElementById('commentsPopupOverlay').classList.add('open');
                }
            });
        };

        // Expose globally for inline fallback
        window.openCommentsForFoto = function(id){
            try { openComments(id); } catch(e) { try { console.error('openComments error', e); } catch(_) {} }
        };
        
        $(document).on('click', '.delete-comment', function(){
            const cid = $(this).data('id');
            if (!confirm('Hapus komentar ini?')) return;
            $.ajax({
                url: `${DELETE_COMMENT_URL_BASE}/${cid}`,
                method: 'POST',
                data: { _token: "{{ csrf_token() }}", _method: 'DELETE' }
            }).done(function(){
                if (currentCommentsFotoId) {
                    openComments(currentCommentsFotoId);
                }
            }).fail(function(){
                alert('Gagal menghapus komentar. Coba lagi.');
            });
        });

        // Fallback popup events
        $(document).on('click', '#commentsPopupClose', function(){
            document.getElementById('commentsPopupOverlay').classList.remove('open');
        });
        // Close when clicking backdrop
        $(document).on('click', '#commentsPopupOverlay', function(e){
            if (e.target && e.target.id === 'commentsPopupOverlay') {
                document.getElementById('commentsPopupOverlay').classList.remove('open');
            }
        });

        // Comment button: simple click, no preventDefault, only footer button
        // Bind on both footer-specific and any comments pill to be safe
        $(document).on('click', '.foto-footer .comments, .stat-pill.comments', function(e){
            // do not preventDefault; allow Bootstrap data attributes to open modal
            const id = $(this).data('id');
            if (!id) return;
            openComments(id);
        });

        // Edit Foto (delegated, reliable after dynamic DOM changes)
        $(document).on('click', '.edit-foto', function(e) {
            // do not preventDefault; allow Bootstrap data attributes to open modal
            const id = $(this).data('id');
            const judul = $(this).data('judul');
            $('#edit_judul').val(judul);
            $('#editFotoForm').attr('action', `/admin/galeri/photo/${id}`);
            if (editModalRef && editModalRef.show) { editModalRef.show(); }
        });
    });
@endsection