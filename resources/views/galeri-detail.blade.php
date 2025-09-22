@extends('layouts.app')

@section('title', $galeri->judul ?? ($galeri->post->judul ?? 'Detail Galeri'))

@section('hero')
<div class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('galeri') }}" class="text-white-50">Galeri</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ Str::limit($galeri->judul ?? ($galeri->post->judul ?? 'Detail Galeri'), 30) }}</li>
                    </ol>
                </nav>
                <h1 class="display-4 fw-bold mb-3">{{ $galeri->judul ?? ($galeri->post->judul ?? 'Detail Galeri') }}</h1>
                <div class="d-flex gap-3 mb-3">
                    <span class="badge bg-light text-dark fs-6 px-3 py-2">
                        <i class="fas fa-images me-2"></i>{{ $galeri->fotos->count() }} Foto
                    </span>
                    <span class="badge bg-light text-dark fs-6 px-3 py-2">
                        <i class="fas fa-calendar me-2"></i>{{ \Carbon\Carbon::parse($galeri->created_at)->format('d M Y') }}
                    </span>
                </div>
                <p class="lead mb-0">{{ Str::limit(strip_tags($galeri->deskripsi ?? ($galeri->post->isi ?? 'Galeri foto menarik')), 120) }}</p>
            </div>
            <div class="col-md-4 text-center">
                <div class="hero-stats">
                    <h2 class="display-2 fw-bold text-white mb-2">{{ $galeri->fotos->count() }}</h2>
                    <p class="text-white-50 fs-4">Foto dalam galeri</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<section class="py-5 fade-in">
    <div class="container">
        
        <!-- Back Button -->
        <div class="row mb-4">
            <div class="col-12">
                <a href="{{ route('galeri') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Galeri
                </a>
            </div>
        </div>

        <!-- Gallery Photos -->
        <div class="gallery-section">
            <div class="section-header mb-4">
                <h3 class="section-title" style="color: var(--elunora-primary-dark);">
                    <i class="fas fa-images me-2" style="color: var(--elunora-primary-dark);"></i>Koleksi Foto
                </h3>
                <p class="section-subtitle fs-5 fw-semibold">{{ $galeri->fotos->count() }} foto dalam galeri ini</p>
            </div>
            <div class="row gallery-photos">
                @forelse($galeri->fotos as $foto)
                <div class="col-md-6 col-lg-4 mb-2">
                    <div class="modern-card photo-card">
                        <div class="photo-container">
                            <img src="{{ asset($foto->file) }}" 
                                 alt="{{ $foto->judul }}" 
                                 class="img-fluid gallery-photo"
                                 onerror="this.src='{{ asset('img/no-image.jpg') }}'">
                            <div class="photo-overlay">
                                <div class="photo-actions">
                                    <a href="{{ asset($foto->file) }}" 
                                       data-lightbox="gallery" 
                                       data-title="{{ $foto->judul }}" 
                                       class="btn-modern light">
                                        <i class="fas fa-expand me-1"></i>Lihat
                                    </a>
                                    <button class="btn-modern primary" onclick="downloadImage('{{ asset($foto->file) }}', '{{ $foto->judul }}')">
                                        <i class="fas fa-download me-1"></i>Unduh
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body-modern" style="padding: 0.5rem;">
                            <h6 class="photo-title" style="margin-bottom: 0.1rem; font-size: 0.9rem;">{{ $foto->judul }}</h6>
                            <small class="text-muted" style="font-size: 0.75rem;">
                                <i class="fas fa-camera me-1"></i>Foto {{ $loop->iteration }} dari {{ $galeri->fotos->count() }}
                            </small>
                        </div>
                        <!-- Photo Actions like Instagram -->
                        <div class="photo-actions-bar px-3 pb-3">
                            <div class="d-flex align-items-center gap-3">
                                <button class="action-icon like-btn" data-foto-id="{{ $foto->id }}" aria-label="Suka" type="button" role="button">
                                    <i class="fa-regular fa-heart"></i>
                                    <span class="count ms-1">0</span>
                                </button>
                                <button class="action-icon comment-btn" data-foto-id="{{ $foto->id }}" aria-label="Komentar" type="button" role="button">
                                    <i class="fa-regular fa-comment"></i>
                                    <span class="count ms-1">0</span>
                                </button>
                                <button class="action-icon share-btn ms-auto" data-foto-id="{{ $foto->id }}" data-share-url="{{ asset($foto->file) }}" aria-label="Bagikan" type="button" role="button">
                                    <i class="fa-solid fa-arrow-up-from-bracket"></i>
                                </button>
                            </div>
                            <div class="comments-panel mt-2 d-none" id="comments-panel-{{ $foto->id }}">
                                <div class="comments-list small mb-2" id="comments-list-{{ $foto->id }}">
                                    <!-- filled by JS -->
                                </div>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" placeholder="Tulis komentar..." id="comment-input-{{ $foto->id }}">
                                    <button class="btn btn-primary" type="button" onclick="addComment({{ $foto->id }})">Kirim</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-camera" style="font-size: 4rem; color: #dee2e6; margin-bottom: 1rem;"></i>
                        <h4 class="text-muted">Belum Ada Foto</h4>
                        <p class="text-muted">Foto akan ditampilkan di sini ketika sudah diupload.</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
        
        <!-- Related Galleries -->
        <div class="row mt-5">
            <div class="col-md-12 mb-4">
                <div class="section-header">
                    <h3 style="color: var(--elunora-primary-dark);"><i class="fas fa-images me-2" style="color: var(--elunora-primary-dark);"></i>Galeri Lainnya</h3>
                    <p class="text-muted">Jelajahi galeri foto lainnya yang menarik</p>
                </div>
            </div>
            
            @php
            $galeriLainnya = \App\Models\Galeri::with('fotos', 'post')
                ->where('status', 1)
                ->where('id', '!=', $galeri->id)
                ->orderBy('position', 'asc')
                ->take(3)
                ->get();
            @endphp
            
            @forelse($galeriLainnya as $item)
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="related-gallery-card h-100">
                    <div class="related-image-container">
                        @if($item->fotos->isNotEmpty())
                        <img src="{{ asset($item->fotos->first()->file) }}" 
                             class="related-image" 
                             alt="{{ $item->fotos->first()->judul }}"
                             onerror="this.src='{{ asset('img/no-image.jpg') }}'">
                        @else
                        <img src="{{ asset('img/no-image.jpg') }}" class="related-image" alt="No Image">
                        @endif
                        <div class="related-overlay">
                            <a href="{{ route('galeri.detail', $item->id) }}" class="btn btn-primary">
                                <i class="fas fa-eye me-1"></i>Lihat Galeri
                            </a>
                        </div>
                        <div class="related-badge">
                            <span class="badge bg-primary">{{ $item->fotos->count() }} foto</span>
                        </div>
                    </div>
                    <div class="related-content">
                        <h5 class="related-title">{{ Str::limit($item->judul ?? ($item->post->judul ?? 'Galeri'), 40) }}</h5>
                        <p class="related-date text-muted">
                            <i class="fas fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                        </p>
                        <a href="{{ route('galeri.detail', $item->id) }}" class="btn btn-primary btn-sm w-100">
                            <i class="fas fa-arrow-right me-1"></i>Lihat Galeri
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-4">
                <div class="empty-state">
                    <i class="fas fa-images" style="font-size: 3rem; color: #dee2e6; margin-bottom: 1rem;"></i>
                    <p class="text-muted">Tidak ada galeri lainnya saat ini.</p>
                </div>
            </div>
            @endforelse
        </div>
        
    </div>

    <!-- Global Share Modal -->
    <div class="modal fade" id="global-share-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-share-nodes me-2"></i>Bagikan Foto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="list-group">
                        <a class="list-group-item list-group-item-action d-flex align-items-center" target="_blank" data-share-wa href="#"><i class="fab fa-whatsapp me-2 text-success"></i>WhatsApp</a>
                        <a class="list-group-item list-group-item-action d-flex align-items-center" target="_blank" data-share-fb href="#"><i class="fab fa-facebook me-2 text-primary"></i>Facebook</a>
                        <a class="list-group-item list-group-item-action d-flex align-items-center" target="_blank" data-share-tw href="#"><i class="fab fa-x-twitter me-2"></i>Twitter/X</a>
                        <button class="list-group-item list-group-item-action d-flex align-items-center" type="button" data-copy-link><i class="fas fa-link me-2"></i>Salin Link</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
<style>
.info-badge {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 50px;
    padding: 0.75rem 1.25rem;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
}

.info-badge:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
}

.info-badge-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--elunora-primary), #0056b3);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1rem;
    flex-shrink: 0;
}

.info-badge-text {
    display: flex;
    flex-direction: column;
    gap: 0.1rem;
}

.info-badge-number {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--elunora-dark);
    line-height: 1;
}

.info-badge-label {
    font-size: 0.85rem;
    color: var(--elunora-secondary);
    font-weight: 500;
}

.info-badge-date {
    font-size: 1rem;
    font-weight: 600;
    color: var(--elunora-dark);
}

.hero-stats {
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.description-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    border: none;
    overflow: hidden;
}

.description-content {
    font-size: 1.1rem;
    line-height: 1.7;
    color: var(--dark-text);
}

.gallery-info {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 500;
}

.info-item i {
    font-size: 1.2rem;
}

.section-header {
    text-align: center;
    margin-bottom: 2rem;
}

.section-header h3 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.photo-card {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    margin-bottom: 1rem;
}

.photo-card.seamless {
    border-radius: 0;
    box-shadow: none;
    background: transparent;
}

.photo-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.2);
}

.photo-card.seamless:hover {
    transform: scale(1.02);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.photo-container {
    position: relative;
    height: 250px;
    overflow: hidden;
}

.photo-image {
    width: 100%;
    height: 250px;
    object-fit: cover;
    transition: all 0.4s ease;
}

.animate-photo {
    animation: photoFloat 6s ease-in-out infinite;
}

.photo-image:hover {
    transform: scale(1.08) rotate(1deg);
    box-shadow: 0 15px 35px rgba(0,0,0,0.3);
}

@keyframes photoFloat {
    0%, 100% { 
        transform: translateY(0px) scale(1);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    50% { 
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    }
}

.photo-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.photo-card:hover .photo-overlay {
    opacity: 1;
}

.photo-actions {
    display: flex;
    gap: 0.5rem;
}

.photo-info {
    padding: 1rem;
    text-align: center;
}

.photo-title {
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--dark-text);
}

.related-gallery-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.related-gallery-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.2);
}

.related-image-container {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.related-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.related-gallery-card:hover .related-image {
    transform: scale(1.05);
}

.related-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.related-gallery-card:hover .related-overlay {
    opacity: 1;
}

.related-badge {
    position: absolute;
    top: 10px;
    right: 10px;
}

.related-content {
    padding: 1.5rem;
}

.related-title {
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--dark-text);
}

.related-date {
    font-size: 0.9rem;
    margin-bottom: 1rem;
}

.share-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    border: none;
}

.btn-facebook {
    background: #1877f2;
    border: none;
    color: white;
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.btn-facebook:hover {
    background: #166fe5;
    transform: translateY(-2px);
    color: white;
}

.btn-twitter {
    background: #1da1f2;
    border: none;
    color: white;
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.btn-twitter:hover {
    background: #1a91da;
    transform: translateY(-2px);
    color: white;
}

.btn-whatsapp {
    background: #25d366;
    border: none;
    color: white;
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.btn-whatsapp:hover {
    background: #22c55e;
    transform: translateY(-2px);
    color: white;
}

.breadcrumb {
    background: transparent;
    padding: 0;
}

.breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255, 255, 255, 0.5);
}

/* Photo actions bar (like Instagram) */
.photo-actions-bar {
    border-top: 1px solid #eef2f7;
}

.action-icon {
    background: transparent;
    border: none;
    color: var(--elunora-dark);
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 8px;
    border-radius: 8px;
    transition: background 0.2s ease, transform 0.1s ease;
    cursor: pointer;
}

.action-icon:hover {
    background: #f1f5f9;
}

.action-icon.liked i {
    color: #ef4444; /* red heart when liked */
}

.action-icon .count {
    font-weight: 700;
}

.comments-panel {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 10px;
}

.comments-list .comment-item {
    background: #fff;
    border: 1px solid #eef2f7;
    border-radius: 8px;
    padding: 8px 10px;
    margin-bottom: 6px;
}

@media (max-width: 768px) {
    .photo-container {
        height: 180px;
    }
    
    .related-image-container {
        height: 150px;
    }
    
    .stat-circle {
        width: 80px;
        height: 80px;
    }
    
    .stat-number {
        font-size: 1.5rem;
    }
    
    .photo-card {
        margin-bottom: 0.5rem;
    }
    
    .card-body-modern {
        padding: 0.4rem !important;
    }
}
</style>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<script>
    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true,
        'imageFadeDuration': 300,
        'positionFromTop': 50
    });
    
    function downloadImage(url, filename) {
        const link = document.createElement('a');
        link.href = url;
        link.download = filename;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
    
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            // If triggered by a button click, give visual feedback
            try {
                if (typeof event !== 'undefined' && event.target) {
                    const btn = event.target.closest('button');
                    if (btn) {
                        const originalIcon = btn.innerHTML;
                        btn.innerHTML = '<i class="fas fa-check"></i>';
                        btn.classList.add('btn-success');
                        btn.classList.remove('btn-secondary');
                        setTimeout(() => {
                            btn.innerHTML = originalIcon;
                            btn.classList.remove('btn-success');
                            btn.classList.add('btn-secondary');
                        }, 2000);
                        return;
                    }
                }
            } catch (e) { /* no-op */ }
            // Fallback: simple console message
            console.log('Tautan disalin ke clipboard');
        });
    }

    // --- Server-backed per photo like, comment, share ---
    function formatCountID(n) {
        if (typeof n !== 'number') n = parseInt(n || 0, 10);
        if (n >= 1000000) return (n / 1000000).toFixed(1).replace('.', ',') + 'jt';
        if (n >= 1000) return (n / 1000).toFixed(1).replace('.', ',') + 'rb';
        return new Intl.NumberFormat('id-ID').format(n);
    }

    function getBaseline(id) {
        const key = 'foto_like_baseline_' + id;
        let v = localStorage.getItem(key);
        if (v === null) {
            v = Math.floor(Math.random() * 23) + 3; // 3..25
            localStorage.setItem(key, String(v));
        }
        return parseInt(v, 10) || 0;
    }

    function updateLikeUI(fotoId, liked, likesCount) {
        const likeBtn = document.querySelector('.like-btn[data-foto-id="' + fotoId + '"]');
        if (!likeBtn) return;
        likeBtn.querySelector('.count').textContent = formatCountID(likesCount);
        likeBtn.classList.toggle('liked', !!liked);
        likeBtn.dataset.liked = liked ? '1' : '0';
        const icon = likeBtn.querySelector('i');
        if (icon) {
            // Support FA5 (far/fas) and FA6 (fa-regular/fa-solid)
            icon.classList.toggle('far', !liked);
            icon.classList.toggle('fas', !!liked);
            icon.classList.toggle('fa-regular', !liked);
            icon.classList.toggle('fa-solid', !!liked);
        }
    }

    function getLiked(fotoId) {
        return localStorage.getItem('foto_liked_' + fotoId) === '1';
    }
    function setLiked(fotoId, val) {
        if (val) localStorage.setItem('foto_liked_' + fotoId, '1');
        else localStorage.removeItem('foto_liked_' + fotoId);
    }

    function updateCommentsCountUI(fotoId, count) {
        const commentBtn = document.querySelector('.comment-btn[data-foto-id="' + fotoId + '"]');
        if (commentBtn) {
            commentBtn.querySelector('.count').textContent = formatCountID(count);
        }
    }

    async function fetchCounts(ids) {
        const qs = encodeURI(ids.join(','));
        if (!qs) return {};
        const res = await fetch(`/ajax/fotos/counts?ids=${qs}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            credentials: 'same-origin'
        });
        const data = await res.json();
        return data.data || {};
    }

    async function likeFoto(fotoId) {
        try {
            const likeBtn = document.querySelector('.like-btn[data-foto-id="' + fotoId + '"]');
            if (likeBtn) {
                likeBtn.disabled = true;
                // Optimistic increment on UI
                const current = likeBtn.querySelector('.count').textContent.replace(/\./g, '').replace(/,rb|,jt|rb|jt/g, '');
                let currNum = parseInt(current || '0', 10);
                if (isNaN(currNum)) currNum = 0;
                updateLikeUI(fotoId, true, currNum + 1);
            }
            const res = await fetch(`/ajax/fotos/${fotoId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': window.csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });
            if (!res.ok) {
                let msg = 'Failed to like';
                try {
                    const j = await res.json();
                    if (j && (j.message || j.hint)) {
                        msg = `${j.message || ''}${j.hint ? `\n${j.hint}` : ''}`.trim();
                    }
                } catch (_) {}
                throw new Error(msg);
            }
            await res.json();
            // Keep optimistic UI count; just ensure liked state is stored
            setLiked(fotoId, true);
            if (likeBtn) likeBtn.disabled = false;
        } catch (e) {
            console.error(e);
            const likeBtn = document.querySelector('.like-btn[data-foto-id="' + fotoId + '"]');
            if (likeBtn) likeBtn.disabled = false;
            alert(e.message || 'Gagal menyukai foto. Silakan coba lagi.');
        }
    }

    async function unlikeFoto(fotoId) {
        try {
            const likeBtn = document.querySelector('.like-btn[data-foto-id="' + fotoId + '"]');
            if (likeBtn) {
                likeBtn.disabled = true;
                // Optimistic decrement on UI
                const current = likeBtn.querySelector('.count').textContent.replace(/\./g, '').replace(/,rb|,jt|rb|jt/g, '');
                let currNum = parseInt(current || '0', 10);
                if (isNaN(currNum)) currNum = 0;
                updateLikeUI(fotoId, false, Math.max(0, currNum - 1));
            }
            const res = await fetch(`/ajax/fotos/${fotoId}/unlike`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': window.csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });
            if (!res.ok) {
                let msg = 'Failed to unlike';
                try {
                    const j = await res.json();
                    if (j && (j.message || j.hint)) {
                        msg = `${j.message || ''}${j.hint ? `\n${j.hint}` : ''}`.trim();
                    }
                } catch (_) {}
                throw new Error(msg);
            }
            await res.json();
            // Keep optimistic UI count; just ensure liked state is stored
            setLiked(fotoId, false);
            if (likeBtn) likeBtn.disabled = false;
        } catch (e) {
            console.error(e);
            const likeBtn = document.querySelector('.like-btn[data-foto-id="' + fotoId + '"]');
            if (likeBtn) likeBtn.disabled = false;
            alert(e.message || 'Gagal membatalkan like. Silakan coba lagi.');
        }
    }

    async function loadComments(fotoId) {
        try {
            const res = await fetch(`/ajax/fotos/${fotoId}/comments`);
            const data = await res.json();
            const list = document.getElementById('comments-list-' + fotoId);
            if (list) {
                list.innerHTML = (data.comments || []).map(c => `
                    <div class="comment-item">
                        <strong>${c.guest_name ? c.guest_name : 'Tamu'}</strong>
                        <div>${c.content}</div>
                        <small class="text-muted">${(new Date(c.created_at)).toLocaleString()}</small>
                    </div>
                `).join('');
            }
            updateCommentsCountUI(fotoId, (data.comments || []).length);
        } catch (e) {
            console.error(e);
        }
    }

    async function addComment(fotoId) {
        const input = document.getElementById('comment-input-' + fotoId);
        if (!input) return;
        const text = (input.value || '').trim();
        if (!text) return;
        try {
            const res = await fetch(`/ajax/fotos/${fotoId}/comments`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': window.csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ content: text }),
                credentials: 'same-origin'
            });
            if (!res.ok) {
                let msg = 'Failed to comment';
                try {
                    const j = await res.json();
                    if (j && (j.message || j.hint)) {
                        msg = `${j.message || ''}${j.hint ? `\n${j.hint}` : ''}`.trim();
                    }
                } catch (_) {}
                throw new Error(msg);
            }
            input.value = '';
            await loadComments(fotoId);
        } catch (e) {
            console.error(e);
            alert(e.message || 'Gagal mengirim komentar. Pastikan koneksi stabil lalu coba lagi.');
        }
    }
    window.addComment = addComment;

    // Share helpers
    function shareFoto(url) {
        if (navigator.share) {
            navigator.share({ title: 'Bagikan Foto', text: 'Lihat foto galeri Elunora School', url });
            return;
        }
        openShareModal(url);
    }

    function openShareModal(url) {
        const modal = document.getElementById('global-share-modal');
        if (!modal) return copyToClipboard(url);
        modal.querySelector('[data-share-wa]').href = `https://wa.me/?text=${encodeURIComponent(url)}`;
        modal.querySelector('[data-share-fb]').href = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
        modal.querySelector('[data-share-tw]').href = `https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}`;
        modal.querySelector('[data-copy-link]').onclick = () => copyToClipboard(url);
        const bsModal = new bootstrap.Modal(modal);
        bsModal.show();
    }

    document.addEventListener('DOMContentLoaded', async function() {
        // Collect all foto IDs on the page
        const ids = Array.from(document.querySelectorAll('.like-btn')).map(btn => btn.getAttribute('data-foto-id'));
        // Set initial baseline to avoid plain 0 while loading
        ids.forEach(id => {
            const likeBtn = document.querySelector('.like-btn[data-foto-id="' + id + '"]');
            if (likeBtn) {
                const base = getBaseline(id);
                if (base > 0) updateLikeUI(id, false, base);
            }
        });

        // Fetch counts from server
        try {
            const counts = await fetchCounts(ids);
            ids.forEach(id => {
                const c = counts[id];
                if (c) {
                    const base = c.likes_count === 0 ? getBaseline(id) : 0;
                    updateLikeUI(id, false, c.likes_count + base);
                    updateCommentsCountUI(id, c.comments_count);
                }
            });
        } catch (e) {
            console.error(e);
        }

        // Apply initial liked state from localStorage without changing counts
        ids.forEach(id => {
            const likeBtn = document.querySelector('.like-btn[data-foto-id="' + id + '"]');
            if (!likeBtn) return;
            const icon = likeBtn.querySelector('i');
            const liked = getLiked(id);
            likeBtn.classList.toggle('liked', liked);
            likeBtn.dataset.liked = liked ? '1' : '0';
            if (icon) {
                icon.classList.toggle('far', !liked);
                icon.classList.toggle('fas', liked);
                icon.classList.toggle('fa-regular', !liked);
                icon.classList.toggle('fa-solid', liked);
            }
        });

        // Wire like buttons (decide by data-liked / UI state for robustness)
        document.querySelectorAll('.like-btn').forEach(btn => {
            const id = btn.getAttribute('data-foto-id');
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                const isLikedNow = (btn.dataset.liked === '1') || btn.classList.contains('liked') || getLiked(id);
                if (isLikedNow) {
                    unlikeFoto(id);
                } else {
                    likeFoto(id);
                }
            });
        });

        // Wire comment buttons
        document.querySelectorAll('.comment-btn').forEach(btn => {
            const id = btn.getAttribute('data-foto-id');
            btn.addEventListener('click', async (e) => {
                e.preventDefault();
                e.stopPropagation();
                const panel = document.getElementById('comments-panel-' + id);
                if (!panel) return;
                const toShow = panel.classList.contains('d-none');
                panel.classList.toggle('d-none');
                if (toShow) {
                    await loadComments(id);
                    const input = document.getElementById('comment-input-' + id);
                    if (input) {
                        input.focus();
                        input.addEventListener('keydown', function(ev) {
                            if (ev.key === 'Enter') {
                                ev.preventDefault();
                                addComment(id);
                            }
                        }, { once: true });
                    }
                }
            });
        });

        // Wire share buttons
        document.querySelectorAll('.share-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                const url = btn.getAttribute('data-share-url');
                shareFoto(url);
            });
        });
    });
</script>
@endsection