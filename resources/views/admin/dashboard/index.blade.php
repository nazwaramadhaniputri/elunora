@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="fade-in">
    <!-- Welcome Header -->
    <div class="dashboard-welcome mb-5">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="welcome-content">
                    <h2 class="welcome-title" style="display: flex; align-items: center; justify-content: center;">
                        <img src="{{ asset('img/logo.png') }}" alt="Elunora School" style="height: 100px; width: auto; margin-right: 20px;">
                        Selamat Datang di Dashboard Admin
                    </h2>
                    <p class="welcome-subtitle">Panel kontrol untuk mengelola sistem Elunora School</p>
                </div>
            </div>
            <div class="col-md-4 text-end">
                <div class="dashboard-time">
                    <div class="time-info">
                        <i class="fas fa-calendar-alt text-primary me-2"></i>
                        <span id="dateWIB" class="fw-bold">{{ now()->format('d M Y') }}</span>
                    </div>
                    <div class="time-info mt-2">
                        <i class="fas fa-clock text-primary me-2"></i>
                        <span id="timeWIB" class="fw-bold">{{ now()->format('H:i') }} WIB</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

    

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="dashboard-stat-card">
                <div class="stat-card-body">
                    <div class="stat-icon-container">
                        <div class="stat-icon bg-primary">
                            <i class="fas fa-newspaper"></i>
                        </div>
                    </div>
                    <div class="stat-content">
                        <h4 class="stat-number" id="statTotalBerita">{{ $totalBerita }}</h4>
                        <p class="stat-label">Total Berita</p>
                        <div class="stat-trend">
                            <i class="fas fa-arrow-up text-success me-1"></i>
                            <small class="text-success">Aktif</small>
                        </div>
                    </div>
                </div>
                <a href="{{ route('admin.berita.index') }}" class="stat-card-footer">
                    Lihat Semua <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="dashboard-stat-card">
                <div class="stat-card-body">
                    <div class="stat-icon-container">
                        <div class="stat-icon bg-success">
                            <i class="fas fa-images"></i>
                        </div>
                    </div>
                    <div class="stat-content">
                        <h4 class="stat-number" id="statTotalGaleri">{{ $totalGaleri }}</h4>
                        <p class="stat-label">Total Galeri</p>
                        <div class="stat-trend">
                            <i class="fas fa-arrow-up text-success me-1"></i>
                            <small class="text-success">Aktif</small>
                        </div>
                    </div>
                </div>
                <a href="{{ route('admin.galeri.index') }}" class="stat-card-footer">
                    Lihat Semua <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="dashboard-stat-card">
                <div class="stat-card-body">
                    <div class="stat-icon-container">
                        <div class="stat-icon bg-info">
                            <i class="fas fa-camera"></i>
                        </div>
                    </div>
                    <div class="stat-content">
                        <h4 class="stat-number" id="statTotalFoto">{{ $totalFoto }}</h4>
                        <p class="stat-label">Total Foto</p>
                        <div class="stat-trend">
                            <i class="fas fa-arrow-up text-success me-1"></i>
                            <small class="text-success">Aktif</small>
                        </div>
                    </div>
                </div>
                <a href="{{ route('admin.galeri.index') }}" class="stat-card-footer">
                    Lihat Semua <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="dashboard-stat-card">
                <div class="stat-card-body">
                    <div class="stat-icon-container">
                        <div class="stat-icon bg-warning">
                            <i class="fas fa-tags"></i>
                        </div>
                    </div>
                    <div class="stat-content">
                        <h4 class="stat-number" id="statTotalKategori">{{ $totalKategori }}</h4>
                        <p class="stat-label">Total Kategori</p>
                        <div class="stat-trend">
                            <i class="fas fa-arrow-up text-success me-1"></i>
                            <small class="text-success">Aktif</small>
                        </div>
                    </div>
                </div>
                <a href="{{ route('admin.berita.kategori.index') }}" class="stat-card-footer">
                    Lihat Semua <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Management Cards -->

    <div class="row">
        <div class="col-md-8 mb-4">
            <div class="dashboard-management-card">
                <div class="management-header">
                    <h5 class="management-title">
                        <i class="fas fa-cogs me-2 text-primary"></i>
                        Manajemen Sekolah
                    </h5>
                    <p class="management-subtitle">Kelola data dan informasi sekolah</p>
                </div>
                <div class="management-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="management-item">
                                <div class="management-icon">
                                    <i class="fas fa-chalkboard-teacher text-primary"></i>
                                </div>
                                <div class="management-content">
                                    <h6 class="management-count">{{ \App\Models\Guru::where('status', 1)->count() }}</h6>
                                    <p class="management-label">Guru & Staff</p>
                                    <a href="{{ route('admin.guru.index') }}" class="management-link">
                                        Kelola <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="management-item">
                                <div class="management-icon">
                                    <i class="fas fa-building text-success"></i>
                                </div>
                                <div class="management-content">
                                    <h6 class="management-count">{{ \App\Models\Fasilitas::where('status', 1)->count() }}</h6>
                                    <p class="management-label">Fasilitas</p>
                                    <a href="{{ route('admin.fasilitas.index') }}" class="management-link">
                                        Kelola <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="management-item">
                                <div class="management-icon">
                                    <i class="fas fa-calendar-alt text-info"></i>
                                </div>
                                <div class="management-content">
                                    <h6 class="management-count">{{ \App\Models\Agenda::where('tanggal', '>=', now())->count() }}</h6>
                                    <p class="management-label">Agenda Mendatang</p>
                                    <a href="{{ route('admin.agenda.index') }}" class="management-link">
                                        Kelola <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="management-item">
                                <div class="management-icon">
                                    <i class="fas fa-envelope text-warning"></i>
                                </div>
                                <div class="management-content">
                                    <h6 class="management-count">{{ \App\Models\Contact::where('status', 0)->count() }}</h6>
                                    <p class="management-label">Pesan Baru</p>
                                    <a href="{{ route('admin.contact.index') }}" class="management-link">
                                        Lihat <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="dashboard-quick-actions">
                <div class="quick-actions-header">
                    <h5 class="quick-actions-title">
                        <i class="fas fa-bolt me-2 text-primary"></i>
                        Aksi Cepat
                    </h5>
                    <p class="quick-actions-subtitle">Tambah konten baru dengan cepat</p>
                </div>
                <div class="quick-actions-body">
                    <a href="{{ route('admin.berita.create') }}" class="dashboard-quick-btn">
                        <div class="quick-btn-icon bg-primary">
                            <i class="fas fa-plus"></i>
                        </div>
                        <div class="quick-btn-content">
                            <span class="quick-btn-title">Tambah Berita</span>
                            <small class="quick-btn-desc">Buat artikel baru</small>
                        </div>
                    </a>
                    
                    <a href="{{ route('admin.galeri.create') }}" class="dashboard-quick-btn">
                        <div class="quick-btn-icon bg-success">
                            <i class="fas fa-images"></i>
                        </div>
                        <div class="quick-btn-content">
                            <span class="quick-btn-title">Tambah Galeri</span>
                            <small class="quick-btn-desc">Upload foto baru</small>
                        </div>
                    </a>
                    
                    <a href="{{ route('admin.guru.create') }}" class="dashboard-quick-btn">
                        <div class="quick-btn-icon bg-info">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="quick-btn-content">
                            <span class="quick-btn-title">Tambah Guru</span>
                            <small class="quick-btn-desc">Daftarkan guru baru</small>
                        </div>
                    </a>
                    
                    <a href="{{ route('admin.fasilitas.create') }}" class="dashboard-quick-btn">
                        <div class="quick-btn-icon bg-warning">
                            <i class="fas fa-plus-square"></i>
                        </div>
                        <div class="quick-btn-content">
                            <span class="quick-btn-title">Tambah Fasilitas</span>
                            <small class="quick-btn-desc">Daftarkan fasilitas</small>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Content and Today's Agenda -->
    <div class="row mt-2 dashboard-equal align-items-stretch">
        <!-- Latest News -->
        <div class="col-lg-6 mb-4 d-flex">
            <div class="card w-100 h-100" id="latestNewsCard">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-newspaper me-2"></i>Berita Terbaru</h5>
                    <a href="{{ route('admin.berita.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="card-body">
                    @php
                        // Debug: Tampilkan jumlah post yang diambil
                        // dd($latestPosts);
                    @endphp
                    @if($latestPosts->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tbody>
                                    @foreach($latestPosts as $post)
                                        <tr>
                                            <td style="width: 70%; vertical-align: middle;">
                                                <div class="fw-semibold text-truncate" style="max-width: 300px;" title="{{ $post->judul }}">
                                                    {{ $post->judul ?? 'Tanpa Judul' }}
                                                </div>
                                                <small class="text-muted">
                                                    {{ \Carbon\Carbon::parse($post->created_at)->format('d M Y H:i') }}
                                                </small>
                                            </td>
                                            <td class="text-end" style="vertical-align: middle;">
                                                <a href="{{ route('admin.berita.edit', $post->id) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i> Lihat
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state" id="emptyLatestPosts">
                            <div class="empty-icon"><i class="fas fa-newspaper"></i></div>
                            <div class="empty-title">Belum ada berita</div>
                            <div class="empty-text">Tambahkan berita pertama Anda.</div>
                            <a href="{{ route('admin.berita.create') }}" class="btn-modern primary"><i class="fas fa-plus me-2"></i>Tambah Berita</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Latest Photos -->
        <div class="col-lg-6 mb-4 d-flex">
            <div class="card w-100 h-100" id="latestPhotosCard">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-camera me-2"></i>Foto Terbaru</h5>
                    <a href="{{ route('admin.galeri.index') }}" class="btn btn-sm btn-outline-primary">Kelola Galeri</a>
                </div>
                <div class="card-body">
                    @if(isset($latestFotos) && $latestFotos->count())
                        <div class="row g-3" id="gridLatestFotos">
                            @foreach($latestFotos as $foto)
                                <div class="col-6 col-md-3">
                                    <div class="ratio ratio-1x1" style="border-radius:10px; overflow:hidden; background:#f1f5f9;">
                                        <img src="{{ asset($foto->file) }}" alt="{{ $foto->judul ?? 'Foto' }}" onerror="this.src='{{ asset('img/no-image.jpg') }}'" style="width:100%; height:100%; object-fit:cover;">
                                    </div>
                                    <small class="d-block text-truncate mt-1">{{ $foto->judul ?? 'Tanpa judul' }}</small>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state" id="emptyLatestFotos">
                            <div class="empty-icon"><i class="fas fa-camera"></i></div>
                            <div class="empty-title">Belum ada foto</div>
                            <div class="empty-text">Upload foto untuk galeri Anda.</div>
                            <a href="{{ route('admin.galeri.create') }}" class="btn-modern primary"><i class="fas fa-images me-2"></i>Tambah Galeri</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Today's Agenda -->
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-calendar-day me-2"></i>Agenda Hari Ini</h5>
                    <a href="{{ route('admin.agenda.index') }}" class="btn btn-sm btn-outline-primary">Kelola Agenda</a>
                </div>
                <div class="card-body">
                    @if(isset($todaysAgendaList) && $todaysAgendaList->count())
                        <div class="table-responsive" id="tableAgendaWrap">
                            <table class="table table-striped align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Waktu</th>
                                        <th>Judul</th>
                                        <th>Lokasi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tableAgendaBody">
                                @foreach($todaysAgendaList as $ag)
                                    <tr>
                                        <td>
                                            <span class="badge bg-primary">
                                                {{ $ag->waktu_mulai ? \Illuminate\Support\Str::of($ag->waktu_mulai)->substr(0,5) : '-' }}
                                                @if($ag->waktu_selesai)
                                                    - {{ \Illuminate\Support\Str::of($ag->waktu_selesai)->substr(0,5) }}
                                                @endif
                                            </span>
                                        </td>
                                        <td>{{ $ag->judul }}</td>
                                        <td>{{ $ag->lokasi ?? '-' }}</td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="{{ route('admin.agenda.show', $ag->id) }}" class="action-btn info" title="Lihat"><i class="fas fa-eye"></i></a>
                                                <a href="{{ route('admin.agenda.edit', $ag->id) }}" class="action-btn primary" title="Edit"><i class="fas fa-edit"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-icon"><i class="fas fa-calendar-day"></i></div>
                            <div class="empty-title">Tidak ada agenda hari ini</div>
                            <div class="empty-text">Tambahkan agenda baru untuk hari ini.</div>
                            <a href="{{ route('admin.agenda.create') }}" class="btn-modern primary"><i class="fas fa-plus me-2"></i>Tambah Agenda</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('styles')
<style>
/* Equal heights for the two latest cards */
.dashboard-equal .card { display: flex; flex-direction: column; }
.dashboard-equal .card-header { flex: 0 0 auto; }
.dashboard-equal .card-body { flex: 1 1 auto; min-height: 280px; }
@media (max-width: 992px) {
  .dashboard-equal .card-body { min-height: 0; }
}
/* Make the news card a bit more compact so bottoms align with photos */
#latestNewsCard .card-body { padding: 1.25rem !important; }
#latestNewsCard .empty-state { padding: 1.25rem !important; }
#latestNewsCard .empty-icon { width: 56px; height: 56px; font-size: 1.5rem; }
#latestNewsCard .empty-title { margin-bottom: .4rem; }
#latestNewsCard .empty-text { margin-bottom: .75rem; }
/* Stat Card Footer */
.stat-card-footer {
    background: rgba(37, 99, 235, 0.05);
    padding: 1rem;
    text-align: center;
    border-top: 1px solid #e9ecef;
    transition: all 0.3s ease;
    color: var(--elunora-primary) !important;
    text-decoration: none !important;
    display: block;
    font-weight: 500;
}

.stat-card-footer:hover {
    background: var(--elunora-primary);
    color: white !important;
    text-decoration: none !important;
}
/* Dashboard Welcome Section */
.dashboard-welcome {
    background: linear-gradient(135deg, var(--elunora-light) 0%, #e9ecef 100%);
    border-radius: 15px;
    padding: 2rem;
    border: 1px solid #dee2e6;
}

.welcome-title {
    color: #2c3e50;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.welcome-subtitle {
    color: #6c757d;
    font-size: 1.1rem;
    margin-bottom: 0;
}

.dashboard-time {
    text-align: right;
}

.time-info {
    font-size: 0.95rem;
    color: #495057;
}

/* Dashboard Statistics Cards */
.dashboard-stat-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    border: 1px solid #f1f3f4;
    transition: all 0.3s ease;
    overflow: hidden;
}

.dashboard-stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
}

.stat-card-body {
    padding: 1.25rem;
    position: relative;
}

.stat-icon-container {
    position: absolute;
    top: 15px;
    right: 15px;
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    box-shadow: 0 3px 12px rgba(0,0,0,0.15);
}

.stat-content {
    padding-right: 65px;
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.5rem;
    line-height: 1;
}

.stat-label {
    color: #6c757d;
    font-size: 1rem;
    margin-bottom: 0.5rem;
    font-weight: 500;
}

.stat-trend {
    font-size: 0.875rem;
}

/* Management Card */
.dashboard-management-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    border: 1px solid #f1f3f4;
    overflow: hidden;
}

.management-header {
    background: var(--elunora-gradient-primary);
    color: white;
    padding: 1.5rem;
}

.management-title {
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.management-subtitle {
    margin-bottom: 0;
    opacity: 0.9;
    font-size: 0.95rem;
}

.management-body {
    padding: 1.5rem;
}

.management-item {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 1.25rem;
    text-align: center;
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
    height: 100%;
}

.management-item:hover {
    background: #e9ecef;
    transform: translateY(-2px);
}

.management-icon {
    font-size: 2rem;
    margin-bottom: 1rem;
}

.management-count {
    font-size: 1.75rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.management-label {
    color: #6c757d;
    margin-bottom: 1rem;
    font-weight: 500;
}

.management-link {
    color: var(--elunora-primary);
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    transition: color 0.3s ease;
}

.management-link:hover {
    color: var(--elunora-primary-dark);
}

/* Quick Actions */
.dashboard-quick-actions {
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    border: 1px solid #f1f3f4;
    overflow: hidden;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.quick-actions-header {
    background: var(--elunora-gradient-success);
    color: white;
    padding: 1.5rem;
}

.quick-actions-title {
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.quick-actions-subtitle {
    margin-bottom: 0;
    opacity: 0.9;
    font-size: 0.95rem;
}

.quick-actions-body {
    padding: 1.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.dashboard-quick-btn {
    display: flex;
    align-items: center;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 10px;
    text-decoration: none;
    color: inherit;
    margin-bottom: 1rem;
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.dashboard-quick-btn:last-child {
    margin-bottom: 0;
}

.dashboard-quick-btn:hover {
    background: #e9ecef;
    transform: translateX(5px);
    text-decoration: none;
    color: inherit;
}

.quick-btn-icon {
    width: 45px;
    height: 45px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    margin-right: 1rem;
    font-size: 1.1rem;
}

.quick-btn-content {
    flex: 1;
}

.quick-btn-title {
    display: block;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.25rem;
}

.quick-btn-desc {
    color: #6c757d;
    font-size: 0.85rem;
}

/* Responsive */
@media (max-width: 768px) {
    .dashboard-welcome {
        padding: 1.5rem;
    }
    
    .welcome-title {
        font-size: 1.5rem;
    }
    
    .stat-number {
        font-size: 2rem;
    }
    
    .management-body {
        padding: 1rem;
    }
    
    .quick-actions-body {
        padding: 1rem;
    }
}

</style>

@endsection

@section('scripts')
<script>
  (function() {
    const dateEl = document.getElementById('dateWIB');
    const timeEl = document.getElementById('timeWIB');
    function updateWIB() {
      try {
        const now = new Date();
        const optsDate = { timeZone: 'Asia/Jakarta', day: '2-digit', month: 'short', year: 'numeric' };
        const optsTime = { timeZone: 'Asia/Jakarta', hour: '2-digit', minute: '2-digit', hour12: false };
        const dateStr = now.toLocaleDateString('id-ID', optsDate);
        const timeStr = now.toLocaleTimeString('id-ID', optsTime);
        if (dateEl) dateEl.textContent = dateStr;
        if (timeEl) timeEl.textContent = timeStr + ' WIB';
      } catch (e) { /* ignore */ }
    }
    updateWIB();
    setInterval(updateWIB, 1000);
  })();

  // Auto-refresh dashboard widgets every 60s
  (function(){
    function equalizeLatestHeights(){
      try {
        const a = document.getElementById('latestNewsCard');
        const b = document.getElementById('latestPhotosCard');
        if (!a || !b) return;
        // reset before measure
        a.style.height = '';
        b.style.height = '';
        const h = Math.max(a.offsetHeight, b.offsetHeight);
        a.style.height = h + 'px';
        b.style.height = h + 'px';
      } catch(_) {}
    }
    // equalize on resize (debounced)
    let __eqTimer = null;
    window.addEventListener('resize', function(){
      clearTimeout(__eqTimer);
      __eqTimer = setTimeout(equalizeLatestHeights, 120);
    });

    const fmtDate = (iso)=>{
      try { return new Date(iso).toLocaleString('id-ID',{day:'2-digit',month:'short',year:'numeric', hour:'2-digit', minute:'2-digit'}); } catch(_) { return ''; }
    };
    function render(){
      fetch("{{ route('admin.dashboard.latest') }}", { headers: { 'X-Requested-With': 'XMLHttpRequest' }})
        .then(r=>r.json())
        .then(data=>{
          // counts
          const c = (data && data.counts) || {};
          const set = (id,val)=>{ const el=document.getElementById(id); if(el) el.textContent = (val ?? 0); };
          set('statTotalBerita', c.berita);
          set('statTotalGaleri', c.galeri);
          set('statTotalFoto', c.foto);
          set('statTotalKategori', c.kategori);

          // latest posts
          const list = document.getElementById('listLatestPosts');
          const emptyLP = document.getElementById('emptyLatestPosts');
          if (Array.isArray(data.latestPosts)) {
            if (list) list.innerHTML = data.latestPosts.map(p=>`
              <li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                  <div class="fw-semibold">${(p.judul||'Tanpa Judul')}</div>
                  <small class="text-muted">${fmtDate(p.created_at)}</small>
                </div>
                <a href="/admin/berita/${p.id}/edit" class="btn btn-sm btn-outline-secondary">Kelola</a>
              </li>`).join('');
            if (emptyLP) emptyLP.style.display = data.latestPosts.length ? 'none' : '';
          }

          // latest photos
          const grid = document.getElementById('gridLatestFotos');
          const emptyLF = document.getElementById('emptyLatestFotos');
          if (Array.isArray(data.latestFotos) && grid) {
            grid.innerHTML = data.latestFotos.map(f=>{
              const base = (f.file||'').startsWith('http') ? f.file : `${location.origin}/${f.file}`;
              const src = `${base}?t=${Date.now()}`;
              return `
              <div class="col-6 col-md-3">
                <div class="ratio ratio-1x1" style="border-radius:10px; overflow:hidden; background:#f1f5f9;">
                  <img src="${src}" onerror="this.src='{{ asset('img/no-image.jpg') }}'" alt="${f.judul||'Foto'}" style="width:100%; height:100%; object-fit:cover;">
                </div>
                <small class="d-block text-truncate mt-1">${f.judul||'Tanpa judul'}</small>
              </div>`;
            }).join('');
            if (emptyLF) emptyLF.style.display = data.latestFotos.length ? 'none' : '';
          }

          // today's agenda
          const tbody = document.getElementById('tableAgendaBody');
          const emptyAT = document.getElementById('emptyAgendaToday');
          if (Array.isArray(data.todaysAgenda) && tbody) {
            tbody.innerHTML = data.todaysAgenda.map(a=>{
              const wmulai = (a.waktu_mulai||'').toString().slice(0,5);
              const wselesai = (a.waktu_selesai||'').toString().slice(0,5);
              const waktu = wselesai ? `${wmulai} - ${wselesai}` : (wmulai||'-');
              return `
                <tr>
                  <td><span class="badge bg-primary">${waktu}</span></td>
                  <td>${a.judul||''}</td>
                  <td>${a.lokasi||'-'}</td>
                  <td>
                    <div class="action-buttons">
                      <a href="/admin/agenda/${a.id}" class="action-btn info" title="Lihat"><i class="fas fa-eye"></i></a>
                      <a href="/admin/agenda/${a.id}/edit" class="action-btn primary" title="Edit"><i class="fas fa-edit"></i></a>
                    </div>
                  </td>
                </tr>`;
            }).join('');
            if (emptyAT) emptyAT.style.display = data.todaysAgenda.length ? 'none' : '';
          }
        })
        .catch(()=>{});
    }
    // first run and interval
    render();
    setInterval(render, 60000);
  })();
</script>
@endsection