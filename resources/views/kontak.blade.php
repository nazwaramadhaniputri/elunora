@extends('layouts.app')

@section('title', 'Kontak')

@section('hero')
<div class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-4 fw-bold text-white mb-3">
                    <i class="fas fa-phone-alt me-3"></i>Hubungi Elunora School
                </h1>
                <p class="lead mb-4 text-white">Silakan hubungi kami untuk informasi lebih lanjut tentang sekolah</p>
                <div class="d-flex gap-3">
                    <span class="badge bg-light text-dark fs-6 px-3 py-2">
                        <i class="fas fa-clock me-2"></i>Respon Cepat
                    </span>
                    <span class="badge bg-light text-dark fs-6 px-3 py-2">
                        <i class="fas fa-headset me-2"></i>24/7 Support
                    </span>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="hero-icon">
                    <i class="fas fa-envelope" style="font-size: 8rem; color: rgba(255, 255, 255, 0.2);"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Informasi Kontak -->
            <div class="col-lg-4 mb-4 mb-lg-0">
                <div class="contact-info-card h-100">
                    <div class="contact-info-body">
                        <h3 class="contact-info-title mb-4">
                            <i class="fas fa-info-circle me-2 text-primary"></i>Informasi Kontak
                        </h3>
                        
                        <div class="contact-item mb-4">
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="contact-content">
                                <h5 class="contact-label">Alamat</h5>
                                <p class="contact-text mb-0">Jl. Magnolia No. 17, The Aurora Residence, Kota Lavendra 88990</p>
                            </div>
                        </div>
                        
                        <div class="contact-item mb-4">
                            <div class="contact-icon">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div class="contact-content">
                                <h5 class="contact-label">Telepon</h5>
                                <p class="contact-text mb-0">(021) 7788-9900</p>
                            </div>
                        </div>
                        
                        <div class="contact-item mb-4">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="contact-content">
                                <h5 class="contact-label">Email</h5>
                                <p class="contact-text mb-0">info@elunoraschool.sch.id</p>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="contact-content">
                                <h5 class="contact-label">Jam Operasional</h5>
                                <p class="contact-text mb-0">Senin - Jumat: 08.00 - 16.00<br>Sabtu: 08.00 - 12.00<br>Minggu: Tutup</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Form Kontak -->
            <div class="col-lg-8">
                <div class="contact-form-card">
                    <div class="contact-form-body">
                        <h3 class="contact-form-title mb-4">
                            <i class="fas fa-paper-plane me-2 text-primary"></i>Kirim Pesan
                        </h3>
                        
                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                        
                        <form action="{{ route('kontak.kirim') }}" method="POST" class="d-flex flex-column h-100">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nama" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" required>
                                    @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="subjek" class="form-label">Subjek</label>
                                <input type="text" class="form-control @error('subjek') is-invalid @enderror" id="subjek" name="subjek" value="{{ old('subjek') }}" required>
                                @error('subjek')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3 flex-grow-1 d-flex flex-column">
                                <label for="pesan" class="form-label">Pesan</label>
                                <textarea class="form-control flex-grow-1 @error('pesan') is-invalid @enderror" id="pesan" name="pesan" style="min-height: 250px; resize: vertical;" required>{{ old('pesan') }}</textarea>
                                @error('pesan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mt-auto pt-3">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-paper-plane me-2"></i>Kirim Pesan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Peta Lokasi -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="map-card">
                    <div class="map-card-body">
                        <h3 class="map-title mb-4">
                            <i class="fas fa-map-marked-alt me-2 text-primary"></i>Lokasi Kami
                        </h3>
                        <div class="ratio ratio-16x9">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3162.4!2d126.9779!3d37.5665!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x357ca2eb7b5b5b5b%3A0x5b5b5b5b5b5b5b5b!2sHanlim%20Multi%20Art%20School!5e0!3m2!1sen!2skr!4v1629789960367!5m2!1sen!2skr" allowfullscreen="" loading="lazy"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
.hero-icon {
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

.contact-info-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    overflow: hidden;
    border: none;
    transition: all 0.3s ease;
}

.contact-info-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 50px rgba(0,0,0,0.15);
}

.contact-info-body {
    padding: 2.5rem;
}

.contact-info-title {
    color: #2c3e50;
    font-weight: 700;
    font-size: 1.5rem;
}

.contact-item {
    display: flex;
    align-items: flex-start;
    padding: 1.5rem;
    border-radius: 15px;
    background: rgba(0, 123, 255, 0.05);
    transition: all 0.3s ease;
}

.contact-item:hover {
    background: rgba(0, 123, 255, 0.1);
    transform: translateX(5px);
}

.contact-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #007bff, #0056b3);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    margin-right: 1.5rem;
    flex-shrink: 0;
}

.contact-content {
    flex: 1;
}

.contact-label {
    color: #2c3e50;
    font-weight: 600;
    margin-bottom: 0.5rem;
    font-size: 1.1rem;
}

.contact-text {
    color: #6c757d;
    line-height: 1.6;
}

.contact-form-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    overflow: hidden;
    border: none;
    height: 100%;
}

.contact-form-body {
    padding: 2.5rem;
}

.contact-form-title {
    color: #2c3e50;
    font-weight: 700;
    font-size: 1.8rem;
}

.form-control {
    border: 2px solid #e9ecef;
    border-radius: 10px;
    padding: 0.75rem 1rem;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.form-label {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.75rem;
}

.btn-primary.btn-lg {
    padding: 1rem 2rem;
    font-size: 1.1rem;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary.btn-lg:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 123, 255, 0.3);
}

.map-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    overflow: hidden;
    border: none;
}

.map-card-body {
    padding: 2.5rem;
}

.map-title {
    color: #2c3e50;
    font-weight: 700;
    font-size: 1.8rem;
}

.ratio iframe {
    border-radius: 15px;
}

@media (max-width: 768px) {
    .contact-info-body,
    .contact-form-body,
    .map-card-body {
        padding: 1.5rem;
    }
    
    .contact-item {
        padding: 1rem;
    }
    
    .contact-icon {
        width: 50px;
        height: 50px;
        font-size: 1.2rem;
        margin-right: 1rem;
    }
}
</style>
@endsection