@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    @php
        // Fallback aman agar halaman tetap render jika controller tidak mengirim $photos
        if (!isset($photos)) {
            $photos = \App\Models\UserPhoto::where('status','pending')->with('user')->latest()->paginate(10);
        }
        $hasData = false;
        try {
            if (is_object($photos) && method_exists($photos, 'count')) {
                $hasData = $photos->count() > 0;
            } elseif (is_array($photos)) {
                $hasData = count($photos) > 0;
            }
        } catch (\Throwable $e) { $hasData = false; }
    @endphp
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Foto Pengunjung (Menunggu Persetujuan)</h1>
        <div>
            <a href="{{ url()->previous() }}" class="btn-modern secondary"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Foto Menunggu Persetujuan</h6>
            <div></div>
        </div>
        <div class="card-body">
            @if($hasData)
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Thumbnail</th>
                            <th width="20%">Judul</th>
                            <th width="15%">Pengunggah</th>
                            <th width="15%">Tanggal Upload</th>
                            <th width="30%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($photos as $key => $photo)
                        <tr>
                            <td>{{ (method_exists($photos,'firstItem') ? $photos->firstItem() : 0) + $key + 1 }}</td>
                            <td>
                                @php
                                    $imgRaw = ltrim((string)($photo->image_path ?? ''), '/');
                                    // normalisasi: jika diawali storage/ buang agar tidak dobel
                                    if (\Illuminate\Support\Str::startsWith($imgRaw, 'storage/')) { $imgRaw = substr($imgRaw, 8); }
                                    if (\Illuminate\Support\Str::startsWith($imgRaw, 'public/')) { $imgRaw = substr($imgRaw, 7); }
                                    $imgUrl = asset(\Illuminate\Support\Facades\Storage::url($imgRaw));
                                @endphp
                                <img src="{{ $imgUrl }}" alt="{{ $photo->title }}" class="img-thumbnail" style="max-height: 80px;"
                                     onerror="this.src='{{ asset('img/no-image.jpg') }}'">
                            </td>
                            <td>{{ $photo->title }}</td>
                            <td>{{ $photo->user->name }}</td>
                            <td>{{ $photo->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('admin.user-photos.show', $photo->id) }}" class="btn btn-sm btn-info">Detail</a>
                                <form action="{{ route('admin.user-photos.approve', $photo->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Apakah Anda yakin ingin menyetujui foto ini?')">Setuju</button>
                                </form>
                                <form action="{{ route('admin.user-photos.reject', $photo->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menolak foto ini?')">Tolak</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if(method_exists($photos,'links'))
            <div class="d-flex justify-content-center mt-4">
                {{ $photos->links() }}
            </div>
            @endif
            @else
            <div class="alert alert-info">
                Tidak ada foto yang menunggu persetujuan saat ini.
            </div>
            @endif
        </div>
    </div>
</div>
@endsection