@extends('layouts.app')

@section('content')
<div class="hero-section" style="background-image: url('{{ asset('assets/img/hero-bg.jpg') }}');">
    <div class="hero-content">
        <h1>Galeri Foto Pengunjung</h1>
        <p>Lihat dan bagikan foto-foto menarik dari pengunjung Elunora</p>
    </div>
</div>

<div class="container mt-5 mb-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="section-title">Galeri Foto Pengunjung</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('user-photos.create') }}" class="btn btn-primary">Upload Foto</a>
        </div>
    </div>

    <div class="row">
        @if($photos->count() > 0)
            @foreach($photos as $photo)
            <div class="col-md-4 mb-4">
                <div class="card gallery-item">
                    <img src="{{ asset('storage/' . $photo->image_path) }}" class="card-img-top" alt="{{ $photo->title }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $photo->title }}</h5>
                        <p class="card-text text-muted">Oleh: {{ $photo->user->name }}</p>
                        <p class="card-text">{{ Str::limit($photo->description, 100) }}</p>
                        <a href="{{ route('user-photos.show', $photo->id) }}" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="alert alert-info">
                    Belum ada foto yang diupload. Jadilah yang pertama mengupload foto!
                </div>
            </div>
        @endif
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $photos->links() }}
    </div>
</div>
@endsection