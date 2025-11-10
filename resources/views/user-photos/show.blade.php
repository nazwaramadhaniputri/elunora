@extends('layouts.app')

@section('content')
<div class="hero-section" style="background-image: url('{{ asset('assets/img/hero-bg.jpg') }}');">
    <div class="hero-content">
        <h1>{{ $photo->title }}</h1>
        <p>Diupload oleh {{ $photo->user->name }}</p>
    </div>
</div>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user-photos.index') }}">Galeri Foto Pengunjung</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $photo->title }}</li>
                </ol>
            </nav>

            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <img src="{{ asset('storage/' . $photo->image_path) }}" class="img-fluid rounded" alt="{{ $photo->title }}">
                        </div>
                        <div class="col-md-4">
                            <h3>{{ $photo->title }}</h3>
                            <p class="text-muted">Diupload oleh {{ $photo->user->name }}</p>
                            <p class="text-muted">{{ $photo->created_at->format('d F Y') }}</p>
                            <div class="mb-4">
                                <p>{{ $photo->description }}</p>
                            </div>
                            
                            @if(auth()->check() && auth()->id() == $photo->user_id)
                            <div class="d-flex gap-2 mt-4">
                                <a href="{{ route('user-photos.edit', $photo->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('user-photos.destroy', $photo->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('user-photos.index') }}" class="btn btn-secondary">Kembali ke Galeri</a>
                @if(auth()->check())
                <a href="{{ route('user-photos.create') }}" class="btn btn-primary">Upload Foto Baru</a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection