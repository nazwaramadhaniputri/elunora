@extends('layouts.admin')

@section('title', 'Detail Profil')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">
                        <i class="fas fa-eye me-2"></i>Detail Profil Sekolah
                    </h3>
                    <div>
                        <a href="{{ route('admin.profil.edit', $profile->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit
                        </a>
                        <a href="{{ route('admin.profil.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h2>{{ $profile->nama_sekolah }}</h2>
                            <div class="content mt-4">
                                <div class="mb-3">
                                    <strong>Alamat:</strong><br>
                                    {{ $profile->alamat }}
                                </div>
                                <div class="mb-3">
                                    <strong>Telepon:</strong> {{ $profile->telepon }}
                                </div>
                                <div class="mb-3">
                                    <strong>Email:</strong> {{ $profile->email }}
                                </div>
                                <div class="mb-3">
                                    <strong>Deskripsi:</strong><br>
                                    {!! nl2br(e($profile->deskripsi)) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Informasi</h5>
                                </div>
                                <div class="card-body">
                                    <p><strong>Dibuat:</strong> {{ $profile->created_at ? $profile->created_at->format('d M Y H:i') : '-' }}</p>
                                    <p><strong>Diupdate:</strong> {{ $profile->updated_at ? $profile->updated_at->format('d M Y H:i') : '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <a href="{{ route('profil') }}" class="btn btn-info" target="_blank">
                            <i class="fas fa-eye me-2"></i>Lihat di Halaman Publik
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection