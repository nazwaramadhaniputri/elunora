@extends('layouts.app')

@section('content')
<div class="container py-4" style="background: none;">
    <div class="row">
        <!-- Left Side - Profile Card -->
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <img src="{{ Auth::user()->photo ? asset(Auth::user()->photo) : asset('img/default-avatar.png') }}" 
                             class="rounded-circle img-thumbnail border-0" 
                             alt="{{ Auth::user()->name }}"
                             style="width: 120px; height: 120px; object-fit: cover; box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);">
                    </div>
                    <h5 class="mb-1">{{ Auth::user()->name }}</h5>
                    <p class="text-muted small mb-3">{{ Auth::user()->email }}</p>
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('profile.edit') }}" class="btn btn-light btn-sm border">
                            <i class="fas fa-user-edit me-1"></i> Edit Profil
                        </a>
                        <a href="#" class="btn btn-outline-secondary btn-sm" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-1"></i> Keluar
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Content -->
        <div class="col-lg-9">
            @if(session('success'))
                <div class="alert alert-light border alert-dismissible fade show mb-4" role="alert" style="background: #f8f9fa;">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <div class="text-dark">{{ session('success') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    @yield('profile-content')
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Override any blue colors from theme */
:root {
    --elunora-primary: #495057;
    --elunora-primary-light: #6c757d;
    --elunora-primary-dark: #343a40;
    --elunora-accent: #6c757d;
}

/* Profile specific styles */
.info-item-modern {
    display: flex;
    align-items: flex-start;
    padding: 1rem;
    border-bottom: 1px solid #f0f0f0;
    transition: background-color 0.2s;
    background: #fff;
}

.info-item-modern:last-child {
    border-bottom: none;
}

.info-item-modern:hover {
    background-color: #f9f9f9;
}

.info-icon-modern {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    flex-shrink: 0;
    color: #6c757d;
    border: 1px solid #e9ecef;
}

.info-content-modern {
    flex: 1;
}

.info-label-modern {
    display: block;
    font-size: 0.8rem;
    color: #6c757d;
    margin-bottom: 0.25rem;
}

.info-value-modern {
    display: block;
    font-weight: 500;
    color: #212529;
}

/* Button styles */
.btn {
    border-radius: 0.25rem;
}

.btn-light {
    background-color: #f8f9fa;
    border-color: #e9ecef;
    color: #212529;
}

.btn-light:hover {
    background-color: #e9ecef;
    border-color: #dee2e6;
    color: #212529;
}

/* Table styles */
.table {
    margin-bottom: 0;
}

.table thead th {
    background-color: #f8f9fa;
    border-bottom: 2px solid #e9ecef;
    font-weight: 600;
    color: #495057;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
}

.table tbody tr {
    transition: background-color 0.2s;
}

.table tbody tr:hover {
    background-color: #f8f9fa;
}

/* Badge styles */
.badge {
    font-weight: 500;
    padding: 0.35em 0.65em;
    border-radius: 0.25rem;
}

/* Alert styles */
.alert {
    border-radius: 0.25rem;
    margin-bottom: 1rem;
}

/* Card styles */
.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    margin-bottom: 1.5rem;
    border-radius: 0.5rem;
    overflow: hidden;
}

/* Remove any remaining blue links */
a:not(.btn) {
    color: #212529;
    text-decoration: none;
    transition: color 0.2s;
}

a:not(.btn):hover {
    color: #495057;
    text-decoration: none;
}

/* Form controls */
.form-control:focus {
    border-color: #adb5bd;
    box-shadow: 0 0 0 0.25rem rgba(108, 117, 125, 0.25);
}

/* Remove blue outline on focus */
*:focus {
    outline: none !important;
    box-shadow: none !important;
}
</style>

@push('styles')
<style>
    /* Ensure no blue colors in profile section */
    .profile-section {
        --bs-link-color: #212529;
        --bs-link-hover-color: #495057;
    }
    
    /* Override any remaining blue colors */
    .text-primary, a.text-primary {
        color: #212529 !important;
    }
    
    .btn-primary, .btn-primary:hover, .btn-primary:focus {
        background-color: #6c757d;
        border-color: #6c757d;
        color: #fff;
    }
</style>
@endpush

@endsection
