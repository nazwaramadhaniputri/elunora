<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Elunora School</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Global Spacing CSS -->
    <link rel="stylesheet" href="{{ asset('css/global-spacing.css') }}">
    <!-- Elunora Theme CSS -->
    <link rel="stylesheet" href="{{ asset('css/elunora-theme.css') }}">
    <!-- Custom CSS -->
    <style>
        /* Using variables from elunora-theme.css */
        :root {
            --primary: var(--elunora-primary);
            --secondary: var(--elunora-secondary);
            --accent: var(--elunora-accent);
            --success: var(--elunora-success);
            --warning: var(--elunora-warning);
            --danger: var(--elunora-danger);
            --info: var(--elunora-info);
            --light: var(--elunora-light);
            --dark: var(--elunora-dark);
            --gradient: var(--elunora-gradient-primary);

            /* ADMIN-scoped variables (missing before) */
            --admin-primary: var(--elunora-primary);
            --admin-accent: var(--elunora-accent);
            --admin-success: var(--elunora-success);
            --admin-warning: var(--elunora-warning);
            --admin-danger: var(--elunora-danger);
            --admin-info: var(--elunora-info);
            --admin-light: var(--elunora-light);
            --admin-dark: var(--elunora-dark);
        }
        
        body {
            background: #f8f9fa;
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #495057;
            min-height: 100vh;
        }
        
        .sidebar {
            background: #ffffff;
            min-height: 100vh;
            box-shadow: 0 0 35px 0 rgba(154, 161, 171, 0.15);
        }
        
        .sidebar .nav-item {
            position: relative;
        }
        
        .sidebar .nav-item .nav-link {
            text-align: left;
            padding: 1rem;
            width: 14rem;
            color: #858796;
            font-weight: 500;
            border-radius: 0.35rem;
            margin: 0.2rem 1rem;
            transition: all 0.3s ease;
        }
        
        .sidebar .nav-item .nav-link:hover {
            color: var(--admin-primary);
            background-color: rgba(30, 58, 138, 0.1);
        }
        
        .sidebar .nav-item .nav-link.active {
            color: white !important;
            background: var(--elunora-primary) !important;
            box-shadow: 0 3px 10px rgba(26, 54, 93, 0.3) !important;
        }
        
        .sidebar .nav-link i {
            width: 20px;
            text-align: center;
        }
        
        /* Remove yellow/orange colors */
        .btn-warning {
            background: var(--elunora-primary) !important;
            border-color: var(--elunora-primary) !important;
            color: white !important;
        }
        
        .btn-warning:hover {
            background: var(--elunora-accent) !important;
            border-color: var(--elunora-accent) !important;
            color: white !important;
        }
        
        .text-warning {
            color: var(--elunora-primary) !important;
        }
        
        .bg-warning {
            background-color: var(--elunora-primary) !important;
        }
        
        .border-warning {
            border-color: var(--elunora-primary) !important;
        }
        
        .alert-warning {
            color: #1e40af;
            background-color: rgba(30, 58, 138, 0.1);
            border-color: rgba(30, 58, 138, 0.2);
        }
        
        /* Dashboard Time Info */
        .dashboard-time-info {
            display: flex;
            align-items: center;
        }
        
        .time-badge {
            background: rgba(37, 99, 235, 0.1);
            color: var(--admin-primary);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
            border: 1px solid rgba(37, 99, 235, 0.2);
        }
        
        .main-content {
            margin-left: 0;
            padding: 2rem;
            min-height: 100vh;
            background: transparent;
        }
        
        @media (min-width: 768px) {
            .main-content {
                margin-left: 280px;
            }
        }
        
        .admin-header {
            background: var(--admin-primary);
            color: white;
            padding: 2rem;
            margin: -1.5rem -1.5rem 2rem -1.5rem;
            border-radius: 0 0 15px 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .admin-header h1 {
            margin: 0;
            font-weight: 700;
        }
        
        .stats-card {
            background: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }
        
        .stats-card .icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        
        .stats-card.primary .icon { color: var(--admin-primary); }
        .stats-card.secondary .icon { color: var(--admin-accent); }
        .stats-card.success .icon { color: var(--admin-success); }
        .stats-card.warning .icon { color: var(--admin-warning); }
        
        .stats-card h3 {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0.5rem 0;
            color: var(--admin-dark);
        }
        
        .stats-card p {
            color: #6c757d;
            margin: 0;
            font-weight: 500;
        }
        
        .table-centered {
            margin: 0 auto;
            text-align: center;
        }
        
        .table-centered th,
        .table-centered td {
            text-align: center;
            vertical-align: middle;
        }
        
        .card {
            border: 1px solid #dee2e6;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background: #ffffff;
            overflow: hidden;
            margin-bottom: 2rem;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.12);
        }
        
        .card-header {
            background: var(--admin-light);
            border-bottom: 1px solid #dee2e6;
            border-radius: 15px 15px 0 0 !important;
            padding: 1.25rem 1.5rem;
        }
        
        .card-body {
            padding: 2rem;
        }
        
        .table {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 15px rgba(0,0,0,0.05);
            margin-bottom: 0;
        }
        
        .table thead th {
            background: var(--admin-primary);
            color: white;
            border: none;
            font-weight: 600;
            padding: 1rem;
            text-align: center;
        }
        
        .table tbody tr {
            transition: all 0.2s ease;
        }
        
        .table tbody tr:hover {
            background-color: var(--admin-light);
            transform: scale(1.01);
        }
        
        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-color: #e9ecef;
        }
        
        .btn {
            border-radius: 25px;
            padding: 0.6rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
            border: 1px solid transparent; /* keep borders for outline variants */
            margin: 0.2rem;
        }
        
        .btn-sm {
            padding: 0.4rem 1rem;
            font-size: 0.875rem;
        }
        
        .btn-primary {
            background: var(--admin-primary) !important;
            border: 1px solid var(--admin-primary) !important;
            border-radius: 8px !important;
            padding: 0.75rem 1.5rem !important;
            font-weight: 600 !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 2px 4px rgba(30, 58, 138, 0.3) !important;
            color: white !important;
        }
        
        .btn-primary:hover {
            background: var(--admin-accent) !important;
            border-color: var(--admin-accent) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 8px rgba(30, 58, 138, 0.4) !important;
            color: white !important;
        }
        .btn-primary:focus,
        .btn-primary:active,
        .btn-primary.active { background: var(--admin-primary) !important; border-color: var(--admin-primary) !important; color: #fff !important; box-shadow: 0 4px 10px rgba(30,58,138,0.35) !important; }
        
        .btn-success {
            background: var(--admin-success);
            border: 1px solid var(--admin-success);
            box-shadow: 0 2px 4px rgba(40, 167, 69, 0.3);
        }
        .btn-success:hover { background: #2ea44f !important; border-color: #2ea44f !important; color:#fff !important; box-shadow: 0 4px 10px rgba(40,167,69,0.35) !important; }
        .btn-success:focus,
        .btn-success:active,
        .btn-success.active { background: var(--admin-success) !important; border-color: var(--admin-success) !important; color:#fff !important; box-shadow: 0 4px 10px rgba(40,167,69,0.35) !important; }
        
        .btn-warning {
            background: var(--admin-warning);
            border: 1px solid var(--admin-warning);
            box-shadow: 0 2px 4px rgba(255, 193, 7, 0.3);
        }
        .btn-warning:hover { background: #d97706 !important; border-color: #d97706 !important; color:#fff !important; box-shadow: 0 4px 10px rgba(255,193,7,0.35) !important; }
        .btn-warning:focus,
        .btn-warning:active,
        .btn-warning.active { background: var(--admin-warning) !important; border-color: var(--admin-warning) !important; color:#fff !important; box-shadow: 0 4px 10px rgba(255,193,7,0.35) !important; }
        
        .btn-danger {
            background: var(--admin-danger);
            border: 1px solid var(--admin-danger);
            box-shadow: 0 2px 4px rgba(220, 53, 69, 0.3);
        }
        .btn-danger:hover { background: #c82333 !important; border-color: #c82333 !important; color:#fff !important; box-shadow: 0 4px 10px rgba(220,53,69,0.35) !important; }
        .btn-danger:focus,
        .btn-danger:active,
        .btn-danger.active { background: var(--admin-danger) !important; border-color: var(--admin-danger) !important; color:#fff !important; box-shadow: 0 4px 10px rgba(220,53,69,0.35) !important; }
        
        .btn-info {
            background: #17a2b8;
            border: 1px solid #17a2b8;
            box-shadow: 0 2px 4px rgba(23, 162, 184, 0.3);
        }
        .btn-info:hover { background: #138496 !important; border-color: #138496 !important; color:#fff !important; box-shadow: 0 4px 10px rgba(23,162,184,0.35) !important; }
        .btn-info:focus,
        .btn-info:active,
        .btn-info.active { background: #17a2b8 !important; border-color: #17a2b8 !important; color:#fff !important; box-shadow: 0 4px 10px rgba(23,162,184,0.35) !important; }

        /* Ensure Bootstrap .btn-secondary (if used for Kembali) is locked to solid gray */
        .btn-secondary {
            background: var(--elunora-secondary) !important;
            border-color: var(--elunora-secondary) !important;
            color: #fff !important;
        }
        .btn-secondary:hover,
        .btn-secondary:focus,
        .btn-secondary:active,
        .btn-secondary.active {
            background: var(--elunora-secondary) !important;
            border-color: var(--elunora-secondary) !important;
            color: #fff !important;
            box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3) !important;
            transform: translateY(-2px) !important;
        }

        /* Outline variants: never flip to white */
        .btn-outline-primary {
            color: var(--admin-primary) !important;
            background-color: transparent !important;
            border-color: var(--admin-primary) !important;
        }
        .btn-outline-primary:hover,
        .btn-outline-primary:focus,
        .btn-outline-primary:active,
        .btn-outline-primary.active {
            color: #fff !important;
            background-color: var(--admin-primary) !important;
            border-color: var(--admin-primary) !important;
            box-shadow: none !important;
        }

        .btn-outline-info {
            color: var(--admin-info) !important;
            background-color: transparent !important;
            border-color: var(--admin-info) !important;
        }
        .btn-outline-info:hover,
        .btn-outline-info:focus,
        .btn-outline-info:active,
        .btn-outline-info.active {
            color: #fff !important;
            background-color: var(--admin-info) !important;
            border-color: var(--admin-info) !important;
            box-shadow: none !important;
        }

        .btn-outline-danger {
            color: var(--admin-danger) !important;
            background-color: transparent !important;
            border-color: var(--admin-danger) !important;
        }
        .btn-outline-danger:hover,
        .btn-outline-danger:focus,
        .btn-outline-danger:active,
        .btn-outline-danger.active {
            color: #fff !important;
            background-color: var(--admin-danger) !important;
            border-color: var(--admin-danger) !important;
            box-shadow: none !important;
        }

        .btn-outline-success {
            color: var(--admin-success) !important;
            background-color: transparent !important;
            border-color: var(--admin-success) !important;
        }
        .btn-outline-success:hover,
        .btn-outline-success:focus,
        .btn-outline-success:active,
        .btn-outline-success.active {
            color: #fff !important;
            background-color: var(--admin-success) !important;
            border-color: var(--admin-success) !important;
            box-shadow: none !important;
        }

        /* Default anchor buttons with .btn should not flash white on active */
        .btn:active,
        .btn:focus {
            box-shadow: none !important;
        }
        
        .alert {
            border: none;
            border-radius: 10px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        
        .badge {
            border-radius: 20px;
            padding: 0.5rem 1rem;
            font-weight: 500;
        }
        
        .pagination {
            justify-content: center;
            margin-top: 2rem;
        }
        
        .page-link {
            border-radius: 25px;
            margin: 0 0.2rem;
            border: none;
            padding: 0.6rem 1rem;
            color: var(--admin-primary);
        }
        
        .page-link:hover {
            background-color: var(--admin-accent);
            color: white;
        }
        
        .page-item.active .page-link {
            background: var(--admin-primary);
            border: 1px solid var(--admin-primary);
        }
        
        /* Modern Admin Components */
        .page-header-modern {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }
        
        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #2c3e50;
            margin: 0;
        }
        
        .page-subtitle {
            color: #6c757d;
            margin: 0.5rem 0 0 0;
            font-size: 1rem;
        }
        
        .btn-modern {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 25px; /* unified: lonjong */
            font-weight: 600;
            text-decoration: none;
            /* Limit transition to avoid color flash */
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border: none;
            cursor: pointer;
        }
        
        .btn-modern.primary {
            background: var(--admin-primary);
            color: white;
        }
        
        .btn-modern.primary:hover {
            background: var(--admin-accent);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(30, 58, 138, 0.3);
            color: white;
        }
        .btn-modern.primary:focus,
        .btn-modern.primary:active,
        .btn-modern.primary.active {
            background: var(--admin-primary) !important;
            color: #fff !important;
            box-shadow: 0 4px 10px rgba(30, 58, 138, 0.3) !important;
        }
        
        .btn-modern.secondary {
            background: var(--elunora-secondary);
            color: white;
        }
        
        .btn-modern.secondary:hover {
            background: var(--elunora-secondary) !important; /* keep solid gray */
            color: #fff !important;
            transform: translateY(-2px) !important; /* subtle lift */
            box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3) !important; /* subtle shadow */
        }
        .btn-modern.secondary:focus,
        .btn-modern.secondary:active,
        .btn-modern.secondary.active {
            background: var(--elunora-secondary) !important; /* keep solid gray */
            color: #fff !important;
            transform: translateY(-1px) !important; /* slight press */
            box-shadow: 0 4px 10px rgba(108, 117, 125, 0.28) !important;
        }

        /* Add missing modern button variants used in admin pages */
        .btn-modern.success { background: var(--admin-success); color: #fff; }
        .btn-modern.success:hover { background: #2ea44f; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(40,167,69,0.3); color: #fff; }
        .btn-modern.success:focus,
        .btn-modern.success:active,
        .btn-modern.success.active { background: var(--admin-success) !important; color: #fff !important; box-shadow: 0 4px 10px rgba(40,167,69,0.3) !important; }

        .btn-modern.warning { background: var(--admin-warning); color: #fff; }
        .btn-modern.warning:hover { background: #d97706; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(245,158,11,0.3); color: #fff; }
        .btn-modern.warning:focus,
        .btn-modern.warning:active,
        .btn-modern.warning.active { background: var(--admin-warning) !important; color: #fff !important; box-shadow: 0 4px 10px rgba(245,158,11,0.3) !important; }

        .btn-modern.info { background: var(--admin-info); color: #fff; }
        .btn-modern.info:hover { background: #138496; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(23,162,184,0.3); color: #fff; }
        .btn-modern.info:focus,
        .btn-modern.info:active,
        .btn-modern.info.active { background: var(--admin-info) !important; color: #fff !important; box-shadow: 0 4px 10px rgba(23,162,184,0.3) !important; }
        
        /* Pin common Admin Berita buttons to solid colors on all states (prevent white blink) */
        .page-actions .btn-modern.primary,
        .page-actions .btn-modern.primary:hover,
        .page-actions .btn-modern.primary:focus,
        .page-actions .btn-modern.primary:active,
        .page-actions .btn-modern.primary.active {
            background: var(--admin-primary) !important;
            color: #fff !important;
            border-color: var(--admin-primary) !important;
        }
        .card .btn-modern.primary,
        .card .btn-modern.primary:hover,
        .card .btn-modern.primary:focus,
        .card .btn-modern.primary:active,
        .card .btn-modern.primary.active,
        form .btn-modern.primary,
        form .btn-modern.primary:hover,
        form .btn-modern.primary:focus,
        form .btn-modern.primary:active,
        form .btn-modern.primary.active {
            background: var(--admin-primary) !important; /* Simpan */
            color: #fff !important;
            border-color: var(--admin-primary) !important;
        }
        .page-actions .btn-modern.secondary,
        .page-actions .btn-modern.secondary:hover,
        .page-actions .btn-modern.secondary:focus,
        .page-actions .btn-modern.secondary:active,
        .page-actions .btn-modern.secondary.active {
            background: var(--elunora-secondary) !important; /* Kembali solid, no gradient */
            color: #fff !important;
            border-color: var(--elunora-secondary) !important;
        }

        /* Ensure create/edit/show forms keep consistent primary/secondary on hover/focus/active */
        form .btn-modern.primary,
        form .btn-modern.primary:hover,
        form .btn-modern.primary:focus,
        form .btn-modern.primary:active,
        form .btn-modern.primary.active,
        .card .btn-modern.primary,
        .card .btn-modern.primary:hover,
        .card .btn-modern.primary:focus,
        .card .btn-modern.primary:active,
        .card .btn-modern.primary.active {
            background: var(--admin-primary) !important;
            color: #fff !important;
            border-color: var(--admin-primary) !important;
        }

        form .btn-modern.secondary,
        form .btn-modern.secondary:hover,
        form .btn-modern.secondary:focus,
        form .btn-modern.secondary:active,
        form .btn-modern.secondary.active,
        .card .btn-modern.secondary,
        .card .btn-modern.secondary:hover,
        .card .btn-modern.secondary:focus,
        .card .btn-modern.secondary:active,
        .card .btn-modern.secondary.active {
            background: var(--elunora-secondary) !important;
            color: #fff !important;
            border-color: var(--elunora-secondary) !important;
        }

        /* Add subtle lift/shadow for secondary buttons in forms and cards */
        form .btn-modern.secondary:hover,
        .card .btn-modern.secondary:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3) !important;
        }
        form .btn-modern.secondary:focus,
        form .btn-modern.secondary:active,
        .card .btn-modern.secondary:focus,
        .card .btn-modern.secondary:active {
            transform: translateY(-1px) !important;
            box-shadow: 0 4px 10px rgba(108, 117, 125, 0.28) !important;
        }

        .modern-table-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .table-card-body {
            padding: 0;
        }
        
        .modern-table {
            width: 100%;
            margin: 0;
        }
        
        .modern-table thead th {
            background: linear-gradient(135deg, var(--admin-primary), var(--admin-accent));
            color: white;
            border: none;
            font-weight: 600;
            padding: 1.25rem;
            text-align: center;
            font-size: 0.95rem;
        }
        
        .modern-table tbody tr {
            transition: all 0.2s ease;
            border-bottom: 1px solid #e9ecef;
        }
        
        .modern-table tbody tr:hover {
            background: rgba(37, 99, 235, 0.05);
            transform: scale(1.01);
        }
        
        .modern-table tbody td {
            padding: 1.25rem;
            vertical-align: middle;
            border: none;
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .status-badge.published {
            background: rgba(40, 167, 69, 0.1);
            color: var(--admin-success);
            border: 1px solid rgba(40, 167, 69, 0.3);
        }
        
        .status-badge.draft {
            background: rgba(255, 193, 7, 0.1);
            color: var(--admin-warning);
            border: 1px solid rgba(255, 193, 7, 0.3);
        }
        
        .action-buttons {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
        }
        
        .action-btn {
            width: 35px;
            height: 35px;
            border-radius: 8px; /* reverted: small rounded */
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            /* Limit transition to avoid background/color flicker */
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border: none;
            cursor: pointer;
            font-size: 0.875rem;
        }
        
        .action-btn.info {
            background: rgba(23, 162, 184, 0.1);
            color: var(--admin-info);
        }
        
        .action-btn.primary {
            background: #e9ecef !important; /* reverted neutral */
            color: #6c757d !important;
        }
        
        .action-btn.danger {
            background: rgba(220, 53, 69, 0.1);
            color: var(--admin-danger);
        }
        
        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(0,0,0,0.2);
        }
        
        /* Lihat (info) — keep same tinted bg and brand color on hover/focus/active */
        .action-btn.info:hover {
            background: rgba(23, 162, 184, 0.1) !important;
            color: var(--admin-info) !important;
        }
        /* Ensure Lihat (info) never flips color */
        .action-buttons .action-btn.info:hover,
        .action-buttons .action-btn.info:focus,
        .action-buttons .action-btn.info:active,
        .action-buttons .action-btn.info.active,
        .action-buttons-agenda .action-btn.info:hover,
        .action-buttons-agenda .action-btn.info:focus,
        .action-buttons-agenda .action-btn.info:active,
        .action-buttons-agenda .action-btn.info.active,
        .action-buttons-gallery .action-btn.info:hover,
        .action-buttons-gallery .action-btn.info:focus,
        .action-buttons-gallery .action-btn.info:active,
        .action-buttons-gallery .action-btn.info.active {
            background: rgba(23, 162, 184, 0.1) !important;
            color: var(--admin-info) !important;
            box-shadow: 0 3px 10px rgba(23, 162, 184, 0.25) !important;
        }
        
        /* Edit (primary/neutral) — keep same neutral bg */
        .action-btn.primary:hover,
        .action-buttons .action-btn.primary:hover,
        .action-buttons-agenda .action-btn.primary:hover,
        .action-buttons-gallery .action-btn.primary:hover {
            background: #e9ecef !important;
            color: #6c757d !important;
        }
        
        /* Hapus (danger) — keep same tinted bg and brand color on hover/focus/active */
        .action-btn.danger:hover {
            background: rgba(220, 53, 69, 0.1) !important;
            color: var(--admin-danger) !important;
        }
        /* Ensure Hapus (danger) never flips color */
        .action-buttons .action-btn.danger:hover,
        .action-buttons .action-btn.danger:focus,
        .action-buttons .action-btn.danger:active,
        .action-buttons .action-btn.danger.active,
        .action-buttons-agenda .action-btn.danger:hover,
        .action-buttons-agenda .action-btn.danger:focus,
        .action-buttons-agenda .action-btn.danger:active,
        .action-buttons-agenda .action-btn.danger.active,
        .action-buttons-gallery .action-btn.danger:hover,
        .action-buttons-gallery .action-btn.danger:focus,
        .action-buttons-gallery .action-btn.danger:active,
        .action-buttons-gallery .action-btn.danger.active {
            background: rgba(220, 53, 69, 0.1) !important;
            color: var(--admin-danger) !important;
            box-shadow: 0 3px 10px rgba(220, 53, 69, 0.25) !important;
        }

        /* Prevent buttons from turning white on click/active */
        .action-btn:focus,
        .action-btn:active {
            outline: none;
            box-shadow: none;
            -webkit-tap-highlight-color: transparent;
        }
        .action-btn.info:focus,
        .action-btn.info:active {
            background: var(--admin-info) !important;
            color: #fff !important;
        }
        .action-btn.danger:focus,
        .action-btn.danger:active {
            background: var(--admin-danger) !important;
            color: #fff !important;
        }
        .action-btn.primary:focus,
        .action-btn.primary:active {
            background: #dee2e6 !important;
            color: #495057 !important;
        }

        /* Remove tap highlight globally within admin to avoid white blink */
        .container-fluid a,
        .container-fluid button,
        .container-fluid .btn,
        .container-fluid .action-btn,
        .container-fluid .btn-modern {
            -webkit-tap-highlight-color: rgba(0,0,0,0);
        }
        
        .empty-state {
            padding: 3rem;
            text-align: center;
        }
        
        .empty-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(37, 99, 235, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: var(--admin-primary);
        }
        
        .empty-title {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .empty-text {
            color: #6c757d;
            margin-bottom: 2rem;
        }
        
        /* Gallery Cards */
        .modern-gallery-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .modern-gallery-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.15);
        }
        
        .gallery-image-container {
            position: relative;
            height: 200px;
            overflow: hidden;
        }
        
        .gallery-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .modern-gallery-card:hover .gallery-image {
            transform: scale(1.1);
        }
        
        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(37, 99, 235, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: all 0.3s ease;
        }
        
        .modern-gallery-card:hover .image-overlay {
            opacity: 1;
        }
        
        .overlay-content {
            text-align: center;
            color: white;
        }
        
        .overlay-content p {
            margin: 0;
            font-weight: 500;
        }
        
        .empty-gallery-image {
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: rgba(37, 99, 235, 0.05);
            color: #6c757d;
        }
        
        .empty-gallery-image p {
            margin: 0;
            font-weight: 500;
        }
        
        .gallery-status-badge {
            position: absolute;
            top: 15px;
            right: 15px;
        }
        
        .gallery-card-body {
            padding: 1.5rem;
        }
        
        .gallery-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0.75rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .gallery-description {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            line-height: 1.4;
        }
        
        .gallery-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #6c757d;
            font-size: 0.875rem;
        }
        
        .meta-item i {
            color: var(--admin-primary);
        }
        
        .gallery-card-actions {
            padding: 1rem 1.5rem;
            background: rgba(37, 99, 235, 0.02);
            border-top: 1px solid #e9ecef;
        }
        
        .action-buttons-gallery {
            display: flex;
            gap: 0.75rem;
            justify-content: center;
        }
        
        .action-buttons-gallery .action-btn {
            width: 40px;
            height: 40px;
        }
        
        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--admin-accent);
            box-shadow: 0 0 0 0.2rem rgba(29, 78, 216, 0.25);
        }
        
        /* Modal Improvements */
        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
        }
        
        .modal-header {
            background: var(--elunora-primary);
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 1.5rem 2rem;
        }
        
        .modal-title {
            font-weight: 600;
        }
        
        .modal-body {
            padding: 2rem;
        }
        
        .modal-footer {
            padding: 1.5rem 2rem;
            border-top: 1px solid #e9ecef;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .page-header-modern {
                padding: 1.5rem;
            }
            
            .page-title {
                font-size: 1.5rem;
            }
            
            .page-header-modern .d-flex {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 1rem;
            }
            
            .modern-table-card {
                margin: 0 -15px;
                border-radius: 0;
            }
            
            .modern-table thead th {
                padding: 1rem 0.5rem;
                font-size: 0.875rem;
            }
            
            .modern-table tbody td {
                padding: 1rem 0.5rem;
            }
            
            .action-buttons {
                flex-direction: column;
                gap: 0.25rem;
            }
            
            .action-btn {
                width: 30px;
                height: 30px;
                font-size: 0.75rem;
            }
            
            .modern-gallery-card {
                margin-bottom: 1rem;
            }
            
            .gallery-image-container {
                height: 150px;
            }
            
            .gallery-card-body {
                padding: 1rem;
            }
            
            .action-buttons-gallery {
                gap: 0.5rem;
            }
            
            .action-buttons-gallery .action-btn {
                width: 35px;
                height: 35px;
            }
            
            .modal-body {
                padding: 1.5rem;
            }
            
            .modal-header {
                padding: 1rem 1.5rem;
            }
            
            .modal-footer {
                padding: 1rem 1.5rem;
            }
        }
        
        @media (max-width: 576px) {
            .page-header-modern {
                padding: 1rem;
                margin: 0 -15px 1rem;
                border-radius: 0;
            }
            
            .page-title {
                font-size: 1.25rem;
            }
            
            .page-subtitle {
                font-size: 0.875rem;
            }
            
            .btn-modern {
                padding: 0.5rem 1rem;
                font-size: 0.875rem;
            }
            
            .modern-table {
                font-size: 0.875rem;
            }
            
            .gallery-meta {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
            
            .empty-state {
                padding: 2rem 1rem;
            }
            
            .empty-icon {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }
        }
        }
        
        .sidebar-brand {
            padding: 2rem 1.5rem;
            text-align: center;
            border-bottom: 1px solid #e9ecef;
            margin-bottom: 1rem;
        }
        
        .sidebar-brand h4 {
            color: #1e3a8a;
            margin: 0;
            font-weight: 700;
        }
        
        .sidebar-brand small {
            color: #6c757d;
        }
        
        .fade-in {
            animation: fadeIn 0.6s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Dashboard Specific Styles */
        .modern-stats-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
        }

        .modern-stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.15);
        }

        .stats-content {
            padding: 2rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .stats-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            flex-shrink: 0;
        }

        .modern-stats-card.primary .stats-icon {
            background: rgba(37, 99, 235, 0.1);
            color: var(--admin-primary);
        }

        .modern-stats-card.success .stats-icon {
            background: rgba(40, 167, 69, 0.1);
            color: var(--admin-success);
        }

        .modern-stats-card.info .stats-icon {
            background: rgba(23, 162, 184, 0.1);
            color: var(--admin-info);
        }

        .modern-stats-card.warning .stats-icon {
            background: rgba(245, 158, 11, 0.1);
            color: var(--admin-warning);
        }

        .stats-info {
            flex: 1;
        }

        .stats-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0;
            color: #2c3e50;
            line-height: 1;
        }

        .stats-label {
            color: #6c757d;
            margin: 0.5rem 0 0 0;
            font-weight: 500;
            font-size: 1rem;
        }

        .stats-trend {
            position: absolute;
            top: 1rem;
            right: 1rem;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: rgba(40, 167, 69, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--admin-success);
        }

        .system-info-list {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .system-info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            background: rgba(37, 99, 235, 0.02);
            border-radius: 10px;
            border: 1px solid rgba(37, 99, 235, 0.1);
        }

        .info-label {
            display: flex;
            align-items: center;
            font-weight: 500;
            color: #2c3e50;
        }

        .info-badge {
            background: var(--admin-primary);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .quick-actions {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .quick-action-btn {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.5rem;
            border-radius: 15px;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .quick-action-btn.primary {
            background: rgba(37, 99, 235, 0.05);
            border-color: rgba(37, 99, 235, 0.1);
            color: var(--admin-primary);
        }

        .quick-action-btn.success {
            background: rgba(40, 167, 69, 0.05);
            border-color: rgba(40, 167, 69, 0.1);
            color: var(--admin-success);
        }

        .quick-action-btn.info {
            background: rgba(23, 162, 184, 0.05);
            border-color: rgba(23, 162, 184, 0.1);
            color: var(--admin-info);
        }

        .quick-action-btn:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .quick-action-btn.primary:hover {
            background: var(--admin-primary);
            color: white;
            border-color: var(--admin-primary);
        }

        .quick-action-btn.success:hover {
            background: var(--admin-success);
            color: white;
            border-color: var(--admin-success);
        }

        .quick-action-btn.info:hover {
            background: var(--admin-info);
            color: white;
            border-color: var(--admin-info);
        }

        .action-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
            background: rgba(255, 255, 255, 0.2);
        }

        .action-content h6 {
            margin: 0 0 0.25rem 0;
            font-weight: 600;
            font-size: 1rem;
        }

        .action-content p {
            margin: 0;
            font-size: 0.875rem;
            opacity: 0.8;
        }

        @media (max-width: 768px) {
            .stats-content {
                padding: 1.5rem;
                gap: 1rem;
            }

            .stats-icon {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }

            .stats-number {
                font-size: 2rem;
            }

            .card-body-modern {
                padding: 1.5rem;
            }

            .quick-action-btn {
                padding: 1rem;
            }

            .action-icon {
                width: 40px;
                height: 40px;
                font-size: 1.25rem;
            }
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-md-block sidebar collapse elunora-admin-sidebar">
                <div class="sidebar-brand elunora-admin-brand" style="padding: 1.5rem 1rem; text-align: center; border-bottom: 1px solid #e3e6f0;">
                    <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 0.5rem;">
                        <img src="{{ asset('img/logo.png') }}" alt="Elunora School" style="height: 50px; width: auto; margin-right: 8px;">
                        <div style="text-align: left;">
                            <h4 style="margin: 0; font-size: 1.1rem; font-weight: 700; color: #1a365d; line-height: 1.2;">Elunora School</h4>
                            <small style="color: #4a5568; font-size: 0.75rem; font-weight: 500;">Admin Panel</small>
                        </div>
                    </div>
                </div>
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.berita.*') && !request()->routeIs('admin.berita.kategori.*') ? 'active' : '' }}" href="{{ route('admin.berita.index') }}">
                                <i class="fas fa-newspaper me-2"></i> Berita
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.berita.kategori.*') ? 'active' : '' }}" href="{{ route('admin.berita.kategori.index') }}">
                                <i class="fas fa-tags me-2"></i> Kategori Berita
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.galeri.*') ? 'active' : '' }}" href="{{ route('admin.galeri.index') }}">
                                <i class="fas fa-images me-2"></i> Galeri
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.profil.*') ? 'active' : '' }}" href="{{ route('admin.profil.index') }}">
                                <i class="fas fa-school me-2"></i> Profile Sekolah
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.fasilitas.*') ? 'active' : '' }}" href="{{ route('admin.fasilitas.index') }}">
                                <i class="fas fa-building me-2"></i> Fasilitas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.guru.*') ? 'active' : '' }}" href="{{ route('admin.guru.index') }}">
                                <i class="fas fa-chalkboard-teacher me-2"></i> Guru & Staff
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.agenda.*') ? 'active' : '' }}" href="{{ route('admin.agenda.index') }}">
                                <i class="fas fa-calendar-alt me-2"></i> Agenda
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.contact.*') ? 'active' : '' }}" href="{{ route('admin.contact.index') }}">
                                <i class="fas fa-envelope me-2"></i> Pesan Kontak
                                @if(\App\Models\Contact::where('status', 0)->count() > 0)
                                    <span class="badge bg-danger ms-2">{{ \App\Models\Contact::where('status', 0)->count() }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item mt-5">
                            <form action="{{ route('admin.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="nav-link border-0 bg-transparent">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 content">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">@yield('header')</h1>
                </div>

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @yield('scripts')
</body>
</html>