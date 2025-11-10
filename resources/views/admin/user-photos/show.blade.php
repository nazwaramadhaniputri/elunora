@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Foto Pengunjung</h1>
        <div>
            <a href="{{ route('admin.user-photos.index') }}" class="btn-modern secondary"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $photo->title }}</h6>
                </div>
                <div class="card-body">
                    @php
                        $imgRaw = ltrim((string)($photo->image_path ?? ''), '/');
                        if (\Illuminate\Support\Str::startsWith($imgRaw, 'storage/')) { $imgRaw = substr($imgRaw, 8); }
                        if (\Illuminate\Support\Str::startsWith($imgRaw, 'public/')) { $imgRaw = substr($imgRaw, 7); }
                        $imgUrl = asset(\Illuminate\Support\Facades\Storage::url($imgRaw));
                    @endphp
                    <img src="{{ $imgUrl }}" alt="{{ $photo->title }}" class="img-fluid rounded mb-4" onerror="this.src='{{ asset('img/no-image.jpg') }}'">
                    <h5>Deskripsi:</h5>
                    <p>{{ $photo->description }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Status:</strong>
                        @if($photo->status == 'pending')
                            <span class="badge badge-warning">Menunggu Persetujuan</span>
                        @elseif($photo->status == 'approved')
                            <span class="badge badge-success">Disetujui</span>
                        @elseif($photo->status == 'rejected')
                            <span class="badge badge-danger">Ditolak</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <strong>Pengunggah:</strong> {{ $photo->user->name }}
                    </div>
                    <div class="mb-3">
                        <strong>Email:</strong> {{ $photo->user->email }}
                    </div>
                    <div class="mb-3">
                        <strong>Tanggal Upload:</strong> {{ $photo->created_at->format('d M Y H:i') }}
                    </div>
                    
                    @if($photo->status == 'rejected')
                    <div class="mb-3">
                        <strong>Catatan Admin:</strong>
                        <p>{{ $photo->admin_notes ?: 'Tidak ada catatan' }}</p>
                    </div>
                    @endif
                    
                    @if($photo->status == 'pending')
                    <hr>
                    <form action="{{ route('admin.user-photos.approve', $photo->id) }}" method="POST" class="mb-2">
                        @csrf
                        <button type="submit" class="btn-modern success w-100">Setujui Foto</button>
                    </form>
                    <button type="button" class="btn-modern danger w-100" data-bs-toggle="modal" data-bs-target="#rejectModal">Tolak Foto</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.user-photos.reject', $photo->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">Tolak Foto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="admin_notes">Catatan Penolakan (Opsional)</label>
                        <textarea class="form-control" id="admin_notes" name="admin_notes" rows="4" placeholder="Berikan alasan mengapa foto ini ditolak..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modern secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modern danger">Tolak Foto</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection