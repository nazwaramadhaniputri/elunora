@extends('layouts.admin')

@section('title', 'Detail Berita')

@section('content')
<div class="fade-in">
    <div class="page-header-modern mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div class="page-title-section">
                <h4 class="page-title">
                    <i class="fas fa-eye me-3"></i>Detail Berita
                </h4>
                <p class="page-subtitle">Lihat detail berita atau artikel</p>
            </div>
            <div class="page-actions">
                <a href="{{ route('admin.berita.edit', $post->id) }}" class="btn-modern primary">
                    <i class="fas fa-edit me-2"></i>Edit
                </a>
                <a href="{{ route('admin.berita.index') }}" class="btn-modern secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="modern-table-card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    @if($post->gambar)
                        <div class="mb-4">
                            <img src="{{ asset($post->gambar) }}" alt="{{ $post->judul }}" 
                                 class="img-fluid rounded shadow-sm" style="max-height: 400px; width: 100%; object-fit: cover;">
                        </div>
                    @endif
                    
                    <h5>{{ $post->judul }}</h5>
                    <p class="text-muted mb-3">
                        <i class="fas fa-calendar me-2"></i>{{ $post->created_at ? $post->created_at->format('d F Y') : 'N/A' }}
                        <span class="ms-3">
                            <i class="fas fa-tag me-2"></i>{{ $post->kategori->nama_kategori ?? 'Tidak ada kategori' }}
                        </span>
                    </p>
                    <div class="content">
                        {!! nl2br(e($post->isi)) !!}
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Informasi</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Kategori:</strong> {{ $post->kategori->nama_kategori ?? 'Tidak ada kategori' }}</p>
                            <p><strong>Status:</strong> 
                                @if($post->status == 'published')
                                    <span class="text-success">Published</span>
                                @else
                                    <span class="text-warning">Draft</span>
                                @endif
                            </p>
                            <p><strong>Dibuat:</strong> {{ $post->created_at ? $post->created_at->format('d M Y H:i') : '-' }}</p>
                            <p><strong>Diupdate:</strong> {{ $post->updated_at ? $post->updated_at->format('d M Y H:i') : '-' }}</p>
                            <p><strong>Jumlah Komentar:</strong> {{ \App\Models\Comment::where('post_id', $post->id)->count() }}</p>
                            <div class="mt-3">
                                <a href="{{ route('berita.detail', $post->id) }}" class="btn-modern info btn-sm" target="_blank">
                                    <i class="fas fa-external-link-alt me-1"></i> Lihat di Halaman Publik
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Komentar Masuk -->
                    <div class="card mt-3">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Komentar Masuk</h5>
                            @php($commentsCount = \App\Models\Comment::where('post_id', $post->id)->count())
                            <span class="badge bg-primary">{{ $commentsCount }}</span>
                        </div>
                        <div class="card-body" style="max-height: 420px; overflow:auto;">
                            @php($comments = \App\Models\Comment::where('post_id', $post->id)->latest()->take(100)->get())
                            @if($comments->isEmpty())
                                <div class="text-muted">Belum ada komentar.</div>
                            @else
                                @foreach($comments as $c)
                                <div class="border rounded p-2 mb-2">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <strong><i class="fas fa-user me-1"></i>{{ $c->name ?? $c->nama ?? 'Tamu' }}</strong>
                                            <div class="small text-muted">{{ $c->email ?? '' }}</div>
                                        </div>
                                        <small class="text-muted">{{ optional($c->created_at)->format('d M Y H:i') }}</small>
                                    </div>
                                    <div class="mt-2">{{ $c->content ?? $c->komentar ?? $c->isi }}</div>
                                    <form method="POST" action="{{ route('admin.berita.delete-comment', $c->id) }}" class="mt-2" onsubmit="return confirm('Hapus komentar ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash me-1"></i>Hapus</button>
                                    </form>
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
