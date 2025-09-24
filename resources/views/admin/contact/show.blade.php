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

/* Button color overrides (solid colors, no gradients) scoped to Contact Detail */
.page-actions .btn-modern.primary,
.page-actions .btn-modern.primary:hover,
.page-actions .btn-modern.primary:focus,
.page-actions .btn-modern.primary:active,
.message-actions .btn-modern.primary,
.message-actions .btn-modern.primary:hover,
.message-actions .btn-modern.primary:focus,
.message-actions .btn-modern.primary:active {
    background: var(--elunora-primary) !important;
    border-color: var(--elunora-primary) !important;
    color: #fff !important;
    box-shadow: 0 4px 10px rgba(30,58,138,0.25) !important;
}

.page-actions .btn-modern.secondary,
.page-actions .btn-modern.secondary:hover,
.page-actions .btn-modern.secondary:focus,
.page-actions .btn-modern.secondary:active,
.message-actions .btn-modern.secondary,
.message-actions .btn-modern.secondary:hover,
.message-actions .btn-modern.secondary:focus,
.message-actions .btn-modern.secondary:active {
    background: var(--elunora-secondary) !important;
    border-color: var(--elunora-secondary) !important;
    color: #fff !important;
    box-shadow: 0 4px 10px rgba(108,117,125,0.25) !important;
}

/* Success/Warning/Danger in page-actions: keep solid colors (no gradient) */
.page-actions .btn-modern.success,
.page-actions .btn-modern.success:hover,
.page-actions .btn-modern.success:focus,
.page-actions .btn-modern.success:active {
    background: var(--elunora-success) !important;
    border-color: var(--elunora-success) !important;
    color: #fff !important;
    box-shadow: 0 4px 10px rgba(5,150,105,0.25) !important;
}

.page-actions .btn-modern.warning,
.page-actions .btn-modern.warning:hover,
.page-actions .btn-modern.warning:focus,
.page-actions .btn-modern.warning:active {
    background: var(--elunora-warning) !important;
    border-color: var(--elunora-warning) !important;
    color: #fff !important;
    box-shadow: 0 4px 10px rgba(217,119,6,0.25) !important;
}

.page-actions .btn-modern.danger,
.page-actions .btn-modern.danger:hover,
.page-actions .btn-modern.danger:focus,
.page-actions .btn-modern.danger:active {
    background: var(--elunora-danger) !important;
    border-color: var(--elunora-danger) !important;
    color: #fff !important;
    box-shadow: 0 4px 10px rgba(220,38,38,0.25) !important;
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

// (Toggle read/unread removed as requested)
</script>
@endsection
