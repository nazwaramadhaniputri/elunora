@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Foto Pengunjung (Ditolak)</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Foto Ditolak</h6>
            <div>
                <a href="{{ route('admin.user-photos.index') }}" class="btn btn-sm btn-warning">Menunggu Persetujuan</a>
                <a href="{{ route('admin.user-photos.approved') }}" class="btn btn-sm btn-success">Foto Disetujui</a>
            </div>
        </div>
        <div class="card-body">
            @if($photos->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Thumbnail</th>
                            <th width="20%">Judul</th>
                            <th width="15%">Pengunggah</th>
                            <th width="15%">Tanggal Ditolak</th>
                            <th width="30%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($photos as $key => $photo)
                        <tr>
                            <td>{{ $photos->firstItem() + $key }}</td>
                            <td>
                                <img src="{{ asset('storage/' . $photo->image_path) }}" alt="{{ $photo->title }}" class="img-thumbnail" style="max-height: 80px;">
                            </td>
                            <td>{{ $photo->title }}</td>
                            <td>{{ $photo->user->name }}</td>
                            <td>{{ $photo->updated_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('admin.user-photos.show', $photo->id) }}" class="btn btn-sm btn-info">Detail</a>
                                <form action="{{ route('admin.user-photos.approve', $photo->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Apakah Anda yakin ingin menyetujui foto ini?')">Setujui</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $photos->links() }}
            </div>
            @else
            <div class="alert alert-info">
                Tidak ada foto yang ditolak saat ini.
            </div>
            @endif
        </div>
    </div>
</div>
@endsection