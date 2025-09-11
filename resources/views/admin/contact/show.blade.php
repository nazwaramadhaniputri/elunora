@extends('layouts.admin')

@section('title', 'Detail Pesan Kontak')

@section('content')
<div class="fade-in">
    <div class="page-header-modern mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div class="page-title-section">
                <h4 class="page-title">
                    <i class="fas fa-envelope me-3"></i>Detail Pesan Kontak
                </h4>
                <p class="page-subtitle">Informasi lengkap pesan dari {{ $contact->nama }}</p>
            </div>
            <div class="page-actions">
                <a href="{{ route('admin.contact.index') }}" class="btn-modern secondary me-2">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
                <form id="toggleReadForm" action="{{ $contact->status == 0 ? route('admin.contact.read', $contact->id) : route('admin.contact.unread', $contact->id) }}" method="POST" class="d-inline me-2">
                    @csrf
                    @method('PATCH')
                    <button type="submit" id="toggleReadBtn" class="btn-modern {{ $contact->status == 0 ? 'success' : 'warning' }}">
                        <i id="toggleReadIcon" class="fas {{ $contact->status == 0 ? 'fa-check' : 'fa-undo' }} me-2"></i>
                        <span id="toggleReadText">{{ $contact->status == 0 ? 'Tandai Sudah Dibaca' : 'Tandai Belum Dibaca' }}</span>
                    </button>
                </form>
                <form action="{{ route('admin.contact.destroy', $contact->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-modern danger">
                        <i class="fas fa-trash me-2"></i>Hapus Pesan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="modern-card">
                <div class="card-header-modern">
                    <h5 class="card-title-modern">
                        <i class="fas fa-user me-2"></i>Informasi Pengirim
                    </h5>
                </div>
                <div class="card-body-modern">
                    <div class="contact-avatar mb-4 text-center">
                        <div class="avatar-placeholder">
                            <i class="fas fa-user fa-3x text-muted"></i>
                        </div>
                        <h5 class="mt-3 mb-1">{{ $contact->nama }}</h5>
                        <p class="text-muted">{{ $contact->email }}</p>
                        
                        <div class="contact-status mt-3">
                            @if($contact->status == 0)
                                <span class="status-badge draft">
                                    <i class="fas fa-envelope me-1"></i>Belum Dibaca
                                </span>
                            @else
                                <span class="status-badge published">
                                    <i class="fas fa-envelope-open me-1"></i>Sudah Dibaca
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="contact-details">
                        <div class="detail-item mb-3">
                            <label class="detail-label">Nama Lengkap</label>
                            <div class="detail-value">{{ $contact->nama }}</div>
                        </div>
                        
                        <div class="detail-item mb-3">
                            <label class="detail-label">Email</label>
                            <div class="detail-value">
                                <a href="mailto:{{ $contact->email }}" class="email-link">
                                    <i class="fas fa-envelope me-1"></i>{{ $contact->email }}
                                </a>
                            </div>
                        </div>
                        
                        <div class="detail-item mb-3">
                            <label class="detail-label">Tanggal Dikirim</label>
                            <div class="detail-value">{{ $contact->created_at->format('d F Y, H:i') }} WIB</div>
                        </div>
                        
                        <div class="detail-item">
                            <label class="detail-label">Waktu Berlalu</label>
                            <div class="detail-value">{{ $contact->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="modern-card">
                <div class="card-header-modern">
                    <h5 class="card-title-modern">
                        <i class="fas fa-comment me-2"></i>Isi Pesan
                    </h5>
                </div>
                <div class="card-body-modern">
                    <div class="message-subject mb-4">
                        <label class="message-label">Subjek</label>
                        <h4 class="subject-text">{{ $contact->subjek }}</h4>
                    </div>
                    
                    <div class="message-content">
                        <label class="message-label">Pesan</label>
                        <div class="message-text">
                            {!! nl2br(e($contact->pesan)) !!}
                        </div>
                    </div>
                    
                    <div class="message-actions mt-4">
                        <div class="d-flex gap-2">
                            <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subjek }}" class="btn-modern primary">
                                <i class="fas fa-reply me-2"></i>Balas Email
                            </a>
                            <button type="button" class="btn-modern secondary" onclick="copyToClipboard('{{ $contact->email }}')">
                                <i class="fas fa-copy me-2"></i>Salin Email
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.avatar-placeholder {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    border: 3px solid var(--elunora-primary);
}

.contact-status {
    margin-top: 1rem;
}

.detail-item {
    margin-bottom: 1rem;
}

.detail-label {
    font-weight: 600;
    color: var(--elunora-secondary);
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
    display: block;
}

.detail-value {
    color: var(--elunora-dark);
    font-size: 1rem;
    font-weight: 500;
}

.email-link {
    color: var(--elunora-primary);
    text-decoration: none;
    transition: all 0.3s ease;
}

.email-link:hover {
    color: #0056b3;
    text-decoration: underline;
}

.message-label {
    font-weight: 600;
    color: var(--elunora-secondary);
    font-size: 0.9rem;
    margin-bottom: 0.75rem;
    display: block;
}

.subject-text {
    color: var(--elunora-dark);
    font-weight: 600;
    margin: 0;
    line-height: 1.4;
}

.message-text {
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    border: 2px solid #e9ecef;
    border-radius: 15px;
    padding: 1.5rem;
    color: var(--elunora-dark);
    font-size: 1rem;
    line-height: 1.6;
    min-height: 200px;
}

.message-actions {
    border-top: 2px solid #e9ecef;
    padding-top: 1.5rem;
}
</style>
@endsection

@section('scripts')
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show success message
        const toast = document.createElement('div');
        toast.className = 'alert alert-success position-fixed';
        toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 250px;';
        toast.innerHTML = '<i class="fas fa-check me-2"></i>Email berhasil disalin!';
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.remove();
        }, 3000);
    });
}

// Handle toggle read/unread with AJAX
$(document).ready(function() {
    $('#toggleReadForm').on('submit', function(e) {
        e.preventDefault();
        
        const form = $(this);
        const btn = $('#toggleReadBtn');
        const icon = $('#toggleReadIcon');
        const text = $('#toggleReadText');
        const currentStatus = {{ $contact->status }};
        
        // Disable button during request
        btn.prop('disabled', true);
        
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                // Toggle the button state
                if (currentStatus == 0) {
                    // Was unread, now read
                    btn.removeClass('success').addClass('warning');
                    icon.removeClass('fa-check').addClass('fa-undo');
                    text.text('Tandai Belum Dibaca');
                    form.attr('action', '{{ route('admin.contact.unread', $contact->id) }}');
                    
                    // Update status badge
                    $('.status-badge').removeClass('draft').addClass('published')
                        .html('<i class="fas fa-envelope-open me-1"></i>Sudah Dibaca');
                } else {
                    // Was read, now unread
                    btn.removeClass('warning').addClass('success');
                    icon.removeClass('fa-undo').addClass('fa-check');
                    text.text('Tandai Sudah Dibaca');
                    form.attr('action', '{{ route('admin.contact.read', $contact->id) }}');
                    
                    // Update status badge
                    $('.status-badge').removeClass('published').addClass('draft')
                        .html('<i class="fas fa-envelope me-1"></i>Belum Dibaca');
                }
                
                // Update current status for next toggle
                window.currentContactStatus = currentStatus == 0 ? 1 : 0;
                
                // Show success message
                const toast = document.createElement('div');
                toast.className = 'alert alert-success position-fixed';
                toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 250px;';
                toast.innerHTML = '<i class="fas fa-check me-2"></i>Status berhasil diubah!';
                document.body.appendChild(toast);
                
                setTimeout(() => {
                    toast.remove();
                }, 3000);
            },
            error: function() {
                // Show error message
                const toast = document.createElement('div');
                toast.className = 'alert alert-danger position-fixed';
                toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 250px;';
                toast.innerHTML = '<i class="fas fa-times me-2"></i>Terjadi kesalahan!';
                document.body.appendChild(toast);
                
                setTimeout(() => {
                    toast.remove();
                }, 3000);
            },
            complete: function() {
                // Re-enable button
                btn.prop('disabled', false);
            }
        });
    });
});
</script>
@endsection
