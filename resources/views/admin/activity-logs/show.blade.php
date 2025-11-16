@extends('layouts.admin')

@section('title', 'Detail Log Aktivitas')

@push('styles')
<style>
    .nav-tabs .nav-link {
        color: #6c757d;
    }
    .nav-tabs .nav-link.active {
        font-weight: 600;
        color: #4e73df;
    }
    pre {
        background: #f8f9fc;
        padding: 1rem;
        border-radius: 0.35rem;
        border: 1px solid #e3e6f0;
        max-height: 400px;
        overflow-y: auto;
    }
    .info-label {
        font-weight: 600;
        color: #5a5c69;
        min-width: 120px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Log Aktivitas</h1>
        <a href="{{ route('admin.activity-logs.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Log</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <span class="info-label">ID Log:</span>
                                <span>#{{ $activityLog->id }}</span>
                            </div>
                            <div class="mb-3">
                                <span class="info-label">Waktu:</span>
                                <span>{{ $activityLog->created_at->format('d/m/Y H:i:s') }}</span>
                            </div>
                            <div class="mb-3">
                                <span class="info-label">Petugas:</span>
                                @if($activityLog->petugas)
                                    @php
                                        $petugas = $activityLog->petugas;
                                        $petugasName = $petugas->nama_lengkap ?? $petugas->username ?? 'Petugas';
                                        $petugasEmail = $petugas->email ?? null;
                                    @endphp
                                    <span>{{ $petugasName }} @if($petugasEmail)({{ $petugasEmail }})@endif</span>
                                @else
                                    <span>Sistem</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <span class="info-label">Aksi:</span>
                                @if($activityLog->action === 'create')
                                    <span class="badge badge-success">Tambah Data</span>
                                @elseif($activityLog->action === 'update')
                                    <span class="badge badge-primary">Perbarui Data</span>
                                @elseif($activityLog->action === 'delete')
                                    <span class="badge badge-danger">Hapus Data</span>
                                @else
                                    <span class="badge badge-secondary">{{ ucfirst($activityLog->action) }}</span>
                                @endif
                            </div>
                            <div class="mb-3">
                                <span class="info-label">Model:</span>
                                <span>{{ $activityLog->model_type ? class_basename($activityLog->model_type) : 'N/A' }}</span>
                                @if($activityLog->model_id)
                                    <span class="text-muted">(ID: {{ $activityLog->model_id }})</span>
                                @endif
                            </div>
                            <div class="mb-3">
                                <span class="info-label">IP Address:</span>
                                <span>{{ $activityLog->ip_address ?? 'N/A' }}</span>
                            </div>
                            <div class="mb-3">
                                <span class="info-label">Method:</span>
                                <span class="badge badge-info">{{ $activityLog->method ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="font-weight-bold text-primary">Deskripsi:</h6>
                        <p class="mb-0">{{ $activityLog->description }}</p>
                    </div>

                    @if($activityLog->old_data || $activityLog->new_data)
                    <div class="mb-4">
                        <h6 class="font-weight-bold text-primary mb-3">Data:</h6>
                        <ul class="nav nav-tabs" id="logDataTabs" role="tablist">
                            @if($activityLog->new_data)
                            <li class="nav-item">
                                <a class="nav-link active" id="new-tab" data-toggle="tab" href="#new" role="tab">
                                    <i class="fas fa-plus-circle mr-1"></i> Data Baru
                                </a>
                            </li>
                            @endif
                            @if($activityLog->old_data)
                            <li class="nav-item">
                                <a class="nav-link" id="old-tab" data-toggle="tab" href="#old" role="tab">
                                    <i class="fas fa-history mr-1"></i> Data Lama
                                </a>
                            </li>
                            @endif
                        </ul>
                        <div class="tab-content p-3 border border-top-0">
                            @if($activityLog->new_data)
                            <div class="tab-pane fade show active" id="new" role="tabpanel">
                                <h6 class="mb-3">Data Baru:</h6>
                                <pre><code class="json">{{ json_encode($activityLog->new_data, JSON_PRETTY_PRINT) }}</code></pre>
                            </div>
                            @endif
                            @if($activityLog->old_data)
                            <div class="tab-pane fade" id="old" role="tabpanel">
                                <h6 class="mb-3">Data Lama:</h6>
                                <pre><code class="json">{{ json_encode($activityLog->old_data, JSON_PRETTY_PRINT) }}</code></pre>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <div class="mt-4">
                        <h6 class="font-weight-bold text-primary mb-3">Informasi Tambahan:</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <span class="info-label">URL:</span>
                                    <span class="text-break">{{ $activityLog->url ?? 'N/A' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <span class="info-label">User Agent:</span>
                                    <span class="text-break">{{ $activityLog->user_agent ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="{{ route('admin.activity-logs.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Format JSON dengan indentasi yang benar
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('code.json').forEach(function(element) {
            try {
                const json = JSON.parse(element.textContent);
                element.textContent = JSON.stringify(json, null, 4);
            } catch (e) {
                // Biarkan seperti apa adanya jika bukan JSON yang valid
            }
        });
    });
</script>
@endpush
