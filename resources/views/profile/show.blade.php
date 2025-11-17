@extends('layouts.app')

@section('title', 'Profile User')

@section('hero')
<div class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-4 fw-bold text-white mb-3">
                    <i class="fas fa-user-circle me-3"></i>Profile Saya
                </h1>
                <p class="lead mb-4 text-white">Kelola informasi pribadi dan foto-foto Anda</p>
            </div>
            <div class="col-md-4 text-center">
                <div class="hero-icon">
                    <i class="fas fa-user" style="font-size: 8rem; color: rgba(255, 255, 255, 0.2);"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<section class="py-5 bg-light fade-in">
    <div class="container">
        <div class="mb-4">
            <a href="{{ url()->previous() }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-3">
            <!-- Left Column - Profile Info -->
            <div class="col-lg-4 d-flex">
                <div class="card w-100 p-0" style="border: none; border-radius: 0.75rem; overflow: hidden;">
                    <div class="card-header text-white p-0" style="background: linear-gradient(135deg, var(--elunora-primary) 0%, var(--elunora-primary-dark) 100%);">
                        <h5 class="m-0 p-3"><i class="fas fa-user-circle me-2"></i>Profil Saya</h5>
                    </div>
                    <div class="card-body text-center d-flex flex-column flex-grow-1">
                        <div class="mb-5">
                            @php
                                $initial = strtoupper(substr(Auth::user()->name, 0, 1));
                            @endphp
                            <div class="d-flex align-items-center justify-content-center mx-auto rounded-circle mb-4" 
                                 style="width: 140px; height: 140px; font-size: 56px; font-weight: bold; line-height: 140px; margin: 2rem 0 1.5rem 0; background: linear-gradient(135deg, var(--elunora-primary) 0%, var(--elunora-primary-dark) 100%); color: white;">
                                {{ $initial }}
                            </div>
                            <h4 class="mb-1 text-center">{{ Auth::user()->name }}</h4>
                            <p class="text-muted text-center mb-3">{{ Auth::user()->email }}</p>
                            <div class="d-flex justify-content-center gap-5 mb-5">
                                <div class="text-center">
                                    <div class="fw-bold fs-4" style="color: var(--elunora-primary);">{{ $likeCount > 1000 ? number_format($likeCount / 1000, 1) . 'K' : $likeCount }}</div>
                                    <div class="text-muted">Like</div>
                                </div>
                                <div class="text-center">
                                    <div class="fw-bold fs-4" style="color: var(--elunora-primary);">{{ $commentCount > 1000 ? number_format($commentCount / 1000, 1) . 'K' : $commentCount }}</div>
                                    <div class="text-muted">Komentar</div>
                                </div>
                                <div class="text-center">
                                    <div class="fw-bold fs-4" style="color: var(--elunora-primary);">{{ $photos->count() > 1000 ? number_format($photos->count() / 1000, 1) . 'K' : $photos->count() }}</div>
                                    <div class="text-muted">Foto</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Edit Form -->
            <div class="col-lg-8 d-flex">
                <div class="card w-100 p-0" style="border: none; border-radius: 0.75rem; overflow: hidden;">
                    <div class="card-header text-white d-flex justify-content-between align-items-center p-0" style="background: linear-gradient(135deg, var(--elunora-primary) 0%, var(--elunora-primary-dark) 100%);">
                        <h5 class="m-0 p-3"><i class="fas fa-edit me-2"></i>Edit Profil</h5>
                    </div>
                    <form action="{{ route('profile.update') }}" method="POST" id="profileForm" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="text-start">
                                <!-- Name -->
                                <div class="mb-4">
                                    <label class="form-label text-muted small mb-1">Nama Lengkap</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" required>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="mb-4">
                                    <label class="form-label text-muted small mb-1">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="email" class="form-control" value="{{ Auth::user()->email }}" disabled>
                                    </div>
                                    <small class="text-muted">Email tidak dapat diubah</small>
                                </div>

                                <!-- Photo Preview -->
                                <!-- Photo Upload -->
                                <div class="mb-4">
                                    <label class="form-label text-muted small mb-1">Foto Profil</label>
                                    <div class="border rounded p-3">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-upload text-muted mb-2" style="font-size: 1rem; color: #1e3a8a;"></i>
                                            <label for="photo" class="btn btn-link p-0" style="color: #1e3a8a;">
                                                Pilih Foto
                                                <input type="file" id="photo" name="photo" class="d-none" accept="image/jpeg,image/png" onchange="previewImage(this)">
                                            </label>
                                            <p class="small text-muted mt-2 mb-0">Format: JPG, PNG (maks. 2MB)</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="d-grid gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Photo Gallery Section -->
        <div class="row mt-1">
            <div class="col-12">
                <div class="card p-0" style="border: none; border-radius: 0.75rem; overflow: hidden;">
                    <div class="card-header p-0" style="background: linear-gradient(135deg, var(--elunora-primary) 0%, var(--elunora-primary-dark) 100%);">
                        <h5 class="m-0 text-white p-3"><i class="fas fa-images me-2"></i>Galeri Foto Saya</h5>
                    </div>
                    <div class="card-body p-2">
                        @if($photos->count() > 0)
                            <div class="row g-0">
                                @foreach($photos->take(4) as $photo)
                                <div class="col-6 col-md-4 col-lg-3 p-1">
                                    <div class="gallery-item position-relative overflow-hidden rounded-3 w-100" style="height: 150px;">
                                        <img src="{{ asset('storage/' . $photo->image_path) }}" 
                                             alt="{{ $photo->title ?? 'Foto Saya' }}" 
                                             class="img-fluid w-100 h-100"
                                             style="object-fit: cover;">
                                        
                                        @if($photo->status == 'approved')
                                            <div class="position-absolute top-0 end-0 m-2">
                                                <span class="badge bg-success bg-opacity-90 rounded-pill px-2 py-1">
                                                    <i class="fas fa-check me-1"></i> Disetujui
                                                </span>
                                            </div>
                                        @elseif($photo->status == 'rejected')
                                            <div class="position-absolute top-0 end-0 m-2">
                                                <span class="badge bg-danger bg-opacity-90 rounded-pill px-2 py-1" 
                                                      @if($photo->admin_notes) 
                                                      data-bs-toggle="tooltip" 
                                                      title="Ditolak: {{ $photo->admin_notes }}"
                                                      @endif>
                                                    <i class="fas fa-times me-1"></i> Ditolak
                                                </span>
                                            </div>
                                        @else
                                            <div class="position-absolute top-0 end-0 m-2">
                                                <span class="badge bg-warning text-dark bg-opacity-90 rounded-pill px-2 py-1">
                                                    <i class="fas fa-clock me-1"></i> Menunggu
                                                </span>
                                            </div>
                                        @endif
                                        
                                        <div class="gallery-overlay d-flex align-items-center justify-content-center">
                                            <a href="#" class="view-full-photo d-flex align-items-center justify-content-center" 
                                               data-image="{{ asset('storage/' . $photo->image_path) }}"
                                               data-title="{{ $photo->title ?? 'Foto Saya' }}"
                                               style="width: 40px; height: 40px; border-radius: 50%; background: rgba(255,255,255,0.2);">
                                                <i class="fas fa-eye text-white"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            
                            @if($photos->count() > 4)
                            <div class="text-center mt-4">
                                <a href="{{ route('user-photos.my-photos') }}" class="btn btn-outline-primary">
                                    Lihat Semua Foto <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                            @endif
                        @else
                            <div class="container py-3">
                                <div class="mb-3">
                                    <i class="fas fa-image fa-4x text-muted mb-3" style="opacity: 0.5;"></i>
                                </div>
                                <p class="text-muted mb-4">Anda belum memiliki foto di galeri</p>
                                <a href="{{ route('galeri') }}" class="btn btn-primary">
                                    <i class="fas fa-upload me-1"></i> Unggah Foto
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Add some spacing at the bottom -->
<div class="mb-5"></div>

<!-- Custom Lightbox -->
<div id="lightbox" class="lightbox">
    <div class="lightbox-container">
        <div class="lightbox-content">
            <div class="lightbox-image-container">
                <div class="lightbox-image-wrapper">
                    <img id="lightbox-img" src="" alt="" class="lightbox-image">
                    <div class="lightbox-caption" id="lightbox-caption">Judul Foto</div>
                    <button type="button" class="lightbox-close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editBtn = document.getElementById('editProfileBtn');
        const cancelBtn = document.getElementById('cancelEditBtn');
        const viewModeElements = document.querySelectorAll('.view-mode');
        const editModeElements = document.querySelectorAll('.edit-mode');
        const profileForm = document.getElementById('profileForm');
        const changePhotoBtn = document.getElementById('changePhotoBtn');
        const photoInput = document.getElementById('photo');
        const profileImage = document.getElementById('profileImage');

        // Toggle between view and edit modes
        function toggleEditMode(showEdit) {
            viewModeElements.forEach(el => {
                el.style.display = showEdit ? 'none' : 'block';
            });
            
            editModeElements.forEach(el => {
                el.style.display = showEdit ? 'block' : 'none';
            });
            
            // Show/hide edit button and change photo button
            editBtn.style.display = showEdit ? 'none' : 'block';
            changePhotoBtn.style.display = showEdit ? 'block' : 'none';
            
            // Show/hide form actions
            document.getElementById('formActions').style.display = showEdit ? 'flex' : 'none';
        }

        // Edit button click handler
        editBtn.addEventListener('click', function() {
            toggleEditMode(true);
        });

        // Cancel button click handler
        cancelBtn.addEventListener('click', function() {
            toggleEditMode(false);
        });

        // Function to handle image preview
        function previewImage(input) {
            const preview = document.getElementById('previewImage');
            const initialsDisplay = document.getElementById('initialsDisplay');
            const file = input.files[0];
            const reader = new FileReader();
            const maxSize = 2 * 1024 * 1024; // 2MB

            // Reset error message
            const errorElement = input.parentElement.querySelector('.invalid-feedback');
            if (errorElement) {
                errorElement.remove();
            }

            // Check file size
            if (file && file.size > maxSize) {
                const errorDiv = document.createElement('div');
                errorDiv.className = 'invalid-feedback d-block';
                errorDiv.textContent = 'Ukuran file melebihi 2MB';
                input.parentElement.appendChild(errorDiv);
                input.value = ''; // Reset input file
                return false;
            }

            // Check file type
            if (file && !file.type.match('image/jpeg') && !file.type.match('image/png')) {
                const errorDiv = document.createElement('div');
                errorDiv.className = 'invalid-feedback d-block';
                errorDiv.textContent = 'Format file tidak didukung. Gunakan JPG atau PNG';
                input.parentElement.appendChild(errorDiv);
                input.value = ''; // Reset input file
                return false;
            }

            reader.onload = function(e) {
                // Tampilkan preview gambar
                if (preview) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                    
                    // Sembunyikan inisial jika ada
                    if (initialsDisplay) {
                        initialsDisplay.style.display = 'none';
                    }
                }
            }

            if (file) {
                reader.readAsDataURL(file);
            } else if (preview) {
                // Jika tidak ada file yang dipilih, tampilkan kembali inisial
                if (initialsDisplay) {
                    preview.src = "";
                    preview.classList.add('d-none');
                    initialsDisplay.style.display = 'flex';
                }
            }
            
            return true;
        }

        // Handle form submission
        profileForm.addEventListener('submit', function(e) {
            // Client-side validation can be added here if needed
            // The form will submit normally and the server will handle validation
        });

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush

<style>
/* Form Styles */
.form-control {
    border-radius: 8px;
    border: 1px solid #dee2e6;
    padding: 0.5rem 0.75rem;
    font-size: 0.9rem;
}

textarea.form-control {
    min-height: 100px;
    resize: vertical;
}

/* Profile Image */
.profile-image-container {
    position: relative;
    display: inline-block;
    margin-bottom: 1rem;
}

.profile-image-container:hover .change-photo-btn {
    opacity: 1;
}

.change-photo-btn {
    position: absolute;
    bottom: 10px;
    right: 10px;
    background: var(--elunora-primary);
    color: white;
    border: none;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.change-photo-btn:hover {
    background: var(--elunora-primary-dark);
}

/* Form Group */
.form-group {
    margin-bottom: 1.5rem;
}

/* Photo Gallery */
.gallery-item {
    position: relative;
    overflow: hidden;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    background: #fff;
    border: 1px solid #e9ecef;
}

.gallery-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.gallery-item:hover img {
    transform: scale(1.05);
}

/* Gallery Overlay */
.gallery-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(30, 58, 138, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.gallery-item:hover .gallery-overlay {
    opacity: 1;
}

.gallery-overlay a {
    color: white;
    text-decoration: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
}

.gallery-overlay a:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: scale(1.1);
}

/* Status Badges */
.badge {
    font-weight: 500;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.bg-success {
    background-color: #10b981 !important;
}

.bg-warning {
    background-color: #f59e0b !important;
    color: #1e293b !important;
}

.bg-danger {
    background-color: #ef4444 !important;
}

/* Lightbox Styles */
.lightbox {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    z-index: 1000;
    justify-content: center;
    align-items: center;
    padding: 20px;
    box-sizing: border-box;
}

.lightbox-container {
    position: relative;
    max-width: 90%;
    max-height: 90vh;
    max-height: 90vh;
    display: flex;
    flex-direction: column;
}

.lightbox-content {
    position: relative;
    background: transparent;
    max-height: 90vh;
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.lightbox-image-container {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    max-width: 100%;
    max-height: 100vh;
    background: transparent;
    border-radius: 0;
    overflow: visible;
    padding: 20px;
}

.lightbox-image-wrapper {
    position: relative;
    background: white;
    border-radius: 4px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    padding: 2px;
}

.lightbox-image {
    max-width: 100%;
    max-height: 90vh;
    object-fit: contain;
    display: block;
    border-radius: 2px;
}

.lightbox-caption-container {
    position: absolute;
    bottom: 20px;
    left: 0;
    right: 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 20px;
    box-sizing: border-box;
    z-index: 10;
}

.lightbox-caption {
    font-size: 1rem;
    color: white;
    font-weight: 500;
    background: rgba(0, 0, 0, 0.6);
    padding: 5px 15px;
    border-radius: 4px;
}

@media (max-width: 768px) {
    .lightbox-container {
        max-width: 95%;
    }
}

.lightbox-caption {
    position: absolute;
    left: 10px;
    bottom: 10px;
    color: white;
    background: rgba(0, 0, 0, 0.6);
    padding: 4px 10px;
    border-radius: 4px;
    font-size: 14px;
    max-width: 80%;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    z-index: 2;
}

.lightbox-close {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(0, 0, 0, 0.6);
    border: none;
    color: white;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 1rem;
    transition: all 0.2s;
    z-index: 3;
}

.lightbox-caption {
    position: absolute;
    bottom: 15px;
    left: 15px;
    color: white;
    background: rgba(0, 0, 0, 0.5);
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 14px;
    max-width: 80%;
    white-space: nowrap;
.lightbox-close:hover {
    background: rgba(0, 0, 0, 0.8);
    transform: scale(1.1);
}

.lightbox-close i {
    margin: 0;
    font-size: 1.5rem;
}

}

.lightbox img {
    max-width: 100%;
    max-height: 90vh;
    object-fit: contain;
    border-radius: 4px;
}

.lightbox-close {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    color: #333;
    padding: 8px 15px;
    border-radius: 4px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 0.9rem;
    transition: all 0.2s;
}

.lightbox-close:hover {
    background: #e9ecef;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const lightbox = document.getElementById('lightbox');
    const lightboxImg = document.getElementById('lightbox-img');
    const lightboxClose = document.querySelector('.lightbox-close');
    
    // Fungsi untuk membuka lightbox
    function openLightbox(imageSrc, imageAlt = '', imageTitle = '') {
        const lightboxImg = document.getElementById('lightbox-img');
        const lightboxCaption = document.getElementById('lightbox-caption');
        
        lightboxImg.src = imageSrc;
        lightboxImg.alt = imageAlt;
        
        // Set judul foto, gunakan alt jika judul kosong
        const displayTitle = imageTitle || imageAlt || 'Tidak ada judul';
        lightboxCaption.textContent = displayTitle;
        
        // Tampilkan lightbox
        lightbox.style.display = 'flex';
        
        // Nonaktifkan scroll pada body
        document.body.classList.add('lightbox-active');
        document.documentElement.style.overflow = 'hidden';
        document.body.style.overflow = 'hidden';
        
        // Hitung lebar scrollbar dan tambahkan padding ke body
        const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;
        document.body.style.paddingRight = `${scrollbarWidth}px`;
        
        // Fokus ke tombol close untuk aksesibilitas
        setTimeout(() => lightboxClose.focus(), 100);
    }
    
    // Fungsi untuk menutup lightbox
    function closeLightbox() {
        lightbox.style.display = 'none';
        // Hapus class dan aktifkan kembali interaksi
        document.body.classList.remove('lightbox-active');
        document.documentElement.style.overflow = '';
        document.body.style.overflow = 'auto';
        document.body.style.paddingRight = '';
    }
    
    // Buka lightbox saat tombol view diklik
    document.querySelectorAll('.view-full-photo').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            openLightbox(this.dataset.image, this.dataset.alt || '', this.dataset.title || '');
        });
    });
    
    // Buka lightbox saat gambar di-klik langsung
    document.querySelectorAll('.gallery-item img').forEach(img => {
        img.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const title = this.getAttribute('data-title') || this.alt || '';
            openLightbox(this.src, this.alt, title);
        });
    });
    
    // Tutup lightbox saat tombol close diklik
    lightboxClose.addEventListener('click', closeLightbox);
    
    // Tutup lightbox dengan tombol ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && lightbox.style.display === 'flex') {
            closeLightbox();
        }
    });
    
    // Menutup lightbox saat mengklik area di sekitar foto
    document.getElementById('lightbox').addEventListener('click', function() {
        closeLightbox();
    });
    
    // Mencegah event click pada lightbox content agar tidak menutup lightbox
    document.querySelector('.lightbox-content').addEventListener('click', function(e) {
        e.stopPropagation();
    });
    
    // Close lightbox with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && lightbox.style.display === 'flex') {
            lightbox.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    });
});
</script>

<style>
:root {
    --elunora-primary: #1e3a8a;
    --elunora-primary-light: #3b82f6;
    --elunora-primary-dark: #1e40af;
    --elunora-secondary: #64748b;
    --elunora-light: #f8fafc;
    --elunora-card-bg: #ffffff;
    --elunora-text: #1e293b;
    --elunora-text-light: #64748b;
    --elunora-border: #e2e8f0;
}

.hero-section {
    background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
    padding: 4rem 0;
    color: white;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29-22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-29c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
    opacity: 0.5;
}

.card {
    border: 1px solid rgba(0, 0, 0, 0.1);
    .card {
        border: none;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        background: #fff;
        border-radius: 0.75rem;
        overflow: hidden;
    }background: #fff;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.card-header {
    background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
    color: white;
    padding: 0;
    font-weight: 600;
    border: none;
    margin: 0;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
}

.card-header h5 {
    font-weight: 600;
    margin: 0;
}

.card-body {
    padding: 1.5rem;
    color: #2d3748;
}

.btn-outline-primary {
    color: #1e3a8a;
    border-color: #1e3a8a;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    background-color: #1e3a8a;
    color: white;
}

.btn-primary {
    background-color: #1e3a8a;
    border-color: #1e3a8a;
    font-weight: 500;
    padding: 0.5rem 1.25rem;
}

.btn-primary:hover {
    background-color: #1e40af;
    border-color: #1e40af;
    box-shadow: 0 4px 8px rgba(30, 58, 138, 0.2);
}

.badge {
    font-weight: 500;
    padding: 0.4em 0.8em;
    border-radius: 0.375rem;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}

.profile-header-sub.text-muted {
    color: #4a5568 !important;
}

.form-label {
    color: #4a5568;
    font-weight: 500;
}

.profile-info h6 {
    color: #2d3748;
    font-weight: 600;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .hero-section {
        padding: 3rem 0;
    }
    
    .profile-avatar {
        width: 120px;
        height: 120px;
    }
    
    .gallery-item img {
        height: 120px;
    }
}

.profile-header {
    padding: 2rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    background: white;
    border-bottom: 1px solid #eee;
}

.profile-avatar {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    overflow: hidden;
    border: 4px solid white;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    margin-bottom: 1rem;
}

.profile-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.profile-header-title {
    font-size: 1.5rem;
    font-weight: 600;
    margin: 0.5rem 0 0.25rem;
    color: #1e40af;
}

.profile-header-subtitle {
    color: #6c757d;
    margin-bottom: 1rem;
}

.gallery-item {
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    background-color: #fff;
    aspect-ratio: 1/1;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f8f9fa;
}

.gallery-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
    object-position: center;
}

.gallery-item:hover img {
    transform: scale(1.05);
}

.gallery-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.gallery-item:hover .gallery-overlay {
    opacity: 1;
}

.photo-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 12px;
    z-index: 2;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    border: 2px solid white;
}

.photo-badge i {
    margin: 0;
    padding: 0;
    line-height: 1;
}

.info-item {
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #f0f0f0;
}

.info-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

@media (min-width: 768px) {
    .profile-header {
        flex-direction: row;
        justify-content: space-between;
        text-align: left;
    }
    
    .profile-avatar {
        margin-right: 1.5rem;
        margin-bottom: 0;
    }
    
    .profile-header-content {
        display: flex;
        align-items: center;
        flex: 1;
    }
    
    .profile-header-text {
        flex: 1;
    }
}
</style>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush
@endsection
