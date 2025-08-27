<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Elunora School</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Global Spacing CSS -->
    <link rel="stylesheet" href="{{ asset('css/global-spacing.css') }}">
    <!-- Custom CSS -->
    <style>
        :root {
            --admin-primary: #007bff;
            --admin-secondary: #6c757d;
            --admin-accent: #0056b3;
            --admin-success: #28a745;
            --admin-warning: #ffc107;
            --admin-danger: #dc3545;
            --admin-info: #17a2b8;
            --admin-light: #f8f9fa;
            --admin-dark: #343a40;
            --admin-gradient: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        }
        
        body {
            background: #f8f9fa;
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #495057;
            min-height: 100vh;
        }
        
        .sidebar {
            background: linear-gradient(180deg, #ffffff 0%, #f8f9fc 100%);
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
            background-color: rgba(0, 123, 255, 0.1);
        }
        
        .sidebar .nav-item .nav-link.active {
            color: white;
            background: linear-gradient(135deg, var(--admin-primary), var(--admin-accent));
            box-shadow: 0 3px 10px rgba(0, 123, 255, 0.3);
        }
        
        .sidebar .nav-link i {
            width: 20px;
            text-align: center;
        }
        
        /* Remove yellow/orange colors */
        .btn-warning {
            background: var(--admin-primary) !important;
            border-color: var(--admin-primary) !important;
            color: white !important;
        }
        
        .btn-warning:hover {
            background: var(--admin-accent) !important;
            border-color: var(--admin-accent) !important;
            color: white !important;
        }
        
        .text-warning {
            color: var(--admin-primary) !important;
        }
        
        .bg-warning {
            background-color: var(--admin-primary) !important;
        }
        
        .border-warning {
            border-color: var(--admin-primary) !important;
        }
        
        .alert-warning {
            color: #004085;
            background-color: rgba(0, 123, 255, 0.1);
            border-color: rgba(0, 123, 255, 0.2);
        }
        
        /* Dashboard Time Info */
        .dashboard-time-info {
            display: flex;
            align-items: center;
        }
        
        .time-badge {
            background: rgba(0, 123, 255, 0.1);
            color: var(--admin-primary);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
            border: 1px solid rgba(0, 123, 255, 0.2);
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
            border: none;
            margin: 0.2rem;
        }
        
        .btn-sm {
            padding: 0.4rem 1rem;
            font-size: 0.875rem;
        }
        
        .btn-primary {
            background: var(--admin-primary);
            border: 1px solid var(--admin-primary);
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 123, 255, 0.3);
        }
        
        .btn-primary:hover {
            background: var(--admin-accent);
            border-color: var(--admin-accent);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 86, 179, 0.4);
        }
        
        .btn-success {
            background: var(--admin-success);
            border: 1px solid var(--admin-success);
            box-shadow: 0 2px 4px rgba(40, 167, 69, 0.3);
        }
        
        .btn-warning {
            background: var(--admin-warning);
            border: 1px solid var(--admin-warning);
            box-shadow: 0 2px 4px rgba(255, 193, 7, 0.3);
        }
        
        .btn-danger {
            background: var(--admin-danger);
            border: 1px solid var(--admin-danger);
            box-shadow: 0 2px 4px rgba(220, 53, 69, 0.3);
        }
        
        .btn-info {
            background: #17a2b8;
            border: 1px solid #17a2b8;
            box-shadow: 0 2px 4px rgba(23, 162, 184, 0.3);
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
            background: #007bff;
            border: 1px solid #007bff;
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
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
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
            box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
            color: white;
        }
        
        .btn-modern.secondary {
            background: #6c757d;
            color: white;
        }
        
        .btn-modern.secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
            color: white;
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
            background: rgba(0, 123, 255, 0.05);
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
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 0.875rem;
        }
        
        .action-btn.info {
            background: rgba(23, 162, 184, 0.1);
            color: var(--admin-info);
        }
        
        .action-btn.primary {
            background: rgba(0, 123, 255, 0.1);
            color: var(--admin-primary);
        }
        
        .action-btn.danger {
            background: rgba(220, 53, 69, 0.1);
            color: var(--admin-danger);
        }
        
        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(0,0,0,0.2);
        }
        
        .action-btn.info:hover {
            background: var(--admin-info);
            color: white;
        }
        
        .action-btn.primary:hover {
            background: var(--admin-primary);
            color: white;
        }
        
        .action-btn.danger:hover {
            background: var(--admin-danger);
            color: white;
        }
        
        .empty-state {
            padding: 3rem;
            text-align: center;
        }
        
        .empty-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(0, 123, 255, 0.1);
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
            background: rgba(0, 123, 255, 0.8);
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
            background: rgba(0, 123, 255, 0.05);
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
            background: rgba(0, 123, 255, 0.02);
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
            box-shadow: 0 0 0 0.2rem rgba(15, 52, 96, 0.25);
        }
        
        /* Modal Improvements */
        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
        }
        
        .modal-header {
            background: linear-gradient(135deg, var(--admin-primary), var(--admin-accent));
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
            color: var(--admin-primary);
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
            background: rgba(0, 123, 255, 0.1);
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
            background: rgba(0, 123, 255, 0.1);
            color: var(--admin-primary);
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
            background: rgba(0, 123, 255, 0.02);
            border-radius: 10px;
            border: 1px solid rgba(0, 123, 255, 0.1);
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
            background: rgba(0, 123, 255, 0.05);
            border-color: rgba(0, 123, 255, 0.1);
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
            <div class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="sidebar-brand">
                    <h4><i class="fas fa-cog me-2"></i>Admin Panel</h4>
                    <small>Elunora School</small>
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
                                <i class="fas fa-school me-2"></i> Profil Sekolah
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