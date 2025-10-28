<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>France-Isolation Admin | @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #059669;
            --primary-dark: #047857;
            --primary-light: #10b981;
            --secondary-color: #64748b;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --dark-color: #0f172a;
            --light-color: #f8fafc;
            --sidebar-width: 300px;
            --sidebar-collapsed-width: 80px;
            --header-height: 75px;
            --footer-height: 80px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f766e 0%, #059669 50%, #10b981 100%);
            min-height: 100vh;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
        }

        /* Header Styles */
        .admin-header {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(16, 185, 129, 0.2);
            height: var(--header-height);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .admin-header .navbar-brand {
            font-weight: 700;
            font-size: 1.6rem;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: flex;
            align-items: center;
        }

        .admin-header .navbar-brand i {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 1.8rem;
        }

        /* Enhanced Sidebar Styles */
        .admin-sidebar {
            position: fixed;
            top: var(--header-height);
            left: 0;
            width: var(--sidebar-width);
            height: calc(100vh - var(--header-height));
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(16, 185, 129, 0.2);
            transform: translateX(-100%);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 999;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: rgba(5, 150, 105, 0.3) transparent;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.08);
        }

        /* Sidebar collapsed state */
        .sidebar-collapsed .admin-sidebar {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar-collapsed .main-content {
            margin-left: var(--sidebar-collapsed-width);
        }

        .admin-sidebar::-webkit-scrollbar {
            width: 8px;
        }

        .admin-sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .admin-sidebar::-webkit-scrollbar-thumb {
            background: rgba(5, 150, 105, 0.3);
            border-radius: 4px;
        }

        .admin-sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(5, 150, 105, 0.5);
        }

        .sidebar-open .admin-sidebar {
            transform: translateX(0);
        }

        /* Fixed Sidebar Toggle Button */
        .sidebar-toggle-btn {
            position: absolute;
            top: 1rem;
            right: -20px;
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            border: 2px solid rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(5, 150, 105, 0.4);
            z-index: 1001;
        }

        .sidebar-toggle-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(5, 150, 105, 0.5);
            background: linear-gradient(135deg, var(--primary-dark), var(--primary-color));
        }

        .sidebar-toggle-btn i {
            font-size: 1rem;
            transition: transform 0.3s ease;
        }

        .sidebar-collapsed .sidebar-toggle-btn i {
            transform: rotate(180deg);
        }

        /* Hide toggle button on mobile */
        @media (max-width: 991.98px) {
            .sidebar-toggle-btn {
                display: none !important;
            }
        }

        /* Sidebar Navigation Groups */
        .sidebar-nav {
            padding: 3rem 0 2rem 0;
            position: relative;
        }

        .nav-group {
            margin-bottom: 2rem;
        }

        .nav-group-title {
            padding: 0.5rem 1.5rem 0.75rem 1.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--secondary-color);
            border-bottom: 1px solid rgba(16, 185, 129, 0.1);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .nav-group-title i {
            margin-right: 0.5rem;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .nav-group-title .title-text {
            transition: all 0.3s ease;
        }

        /* Collapsed sidebar styles */
        .sidebar-collapsed .nav-group-title {
            padding: 0.5rem 0.75rem 0.75rem 0.75rem;
            justify-content: center;
        }

        .sidebar-collapsed .nav-group-title .title-text {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }

        .sidebar-collapsed .nav-group-title i {
            margin-right: 0;
        }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            color: var(--secondary-color);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            border-radius: 0;
            margin: 0.125rem 1rem;
            border-radius: 12px;
            position: relative;
            overflow: hidden;
        }

        .sidebar-collapsed .sidebar-nav .nav-link {
            padding: 1rem 0.75rem;
            margin: 0.125rem 0.5rem;
            justify-content: center;
        }

        .sidebar-nav .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0;
            height: 100%;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            transition: width 0.3s ease;
            z-index: -1;
        }

        .sidebar-nav .nav-link:hover::before,
        .sidebar-nav .nav-link.active::before {
            width: 100%;
        }

        .sidebar-nav .nav-link:hover,
        .sidebar-nav .nav-link.active {
            color: white;
            transform: translateX(6px);
            box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3);
        }

        .sidebar-collapsed .sidebar-nav .nav-link:hover,
        .sidebar-collapsed .sidebar-nav .nav-link.active {
            transform: translateX(0) scale(1.05);
        }

        .sidebar-nav .nav-link i {
            width: 22px;
            margin-right: 0.875rem;
            font-size: 1.1rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .sidebar-collapsed .sidebar-nav .nav-link i {
            margin-right: 0;
        }

        .sidebar-nav .nav-link .nav-text {
            flex: 1;
            transition: all 0.3s ease;
        }

        .sidebar-collapsed .sidebar-nav .nav-link .nav-text {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }

        .sidebar-nav .nav-link .badge {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger-color);
            font-size: 0.7rem;
            padding: 0.25rem 0.5rem;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .sidebar-collapsed .sidebar-nav .nav-link .badge {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }

        /* Tooltip for collapsed sidebar */
        .sidebar-collapsed .nav-link {
            position: relative;
        }

        .sidebar-collapsed .nav-link::after {
            content: attr(data-tooltip);
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.9);
            color: white;
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            font-size: 0.8rem;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            margin-left: 10px;
            z-index: 1000;
        }

        .sidebar-collapsed .nav-link:hover::after {
            opacity: 1;
            visibility: visible;
        }

        /* Main Content Layout */
        .main-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin-top: var(--header-height);
        }

        .main-content {
            flex: 1;
            margin-left: 0;
            padding: 2rem;
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
        }

        .content-wrapper {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            min-height: calc(100vh - var(--header-height) - var(--footer-height) - 4rem);
            position: relative;
        }

        .content-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--primary-light));
            border-radius: 24px 24px 0 0;
        }

        /* Enhanced User Dropdown */
        .user-dropdown .dropdown-toggle {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            border: none;
            border-radius: 50px;
            padding: 0.75rem 1.25rem;
            color: white;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3);
        }

        .user-dropdown .dropdown-toggle:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(5, 150, 105, 0.4);
        }

        .user-dropdown .dropdown-toggle::after {
            margin-left: 0.5rem;
        }

        .user-dropdown .dropdown-menu {
            border: none;
            border-radius: 16px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.98);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 0.5rem;
            min-width: 200px;
        }

        .user-dropdown .dropdown-item {
            padding: 0.875rem 1.25rem;
            border-radius: 12px;
            margin: 0.125rem 0;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }

        .user-dropdown .dropdown-item i {
            width: 20px;
            margin-right: 0.75rem;
        }

        .user-dropdown .dropdown-item:hover {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: white;
            transform: translateX(4px);
        }

        .user-dropdown .dropdown-item.text-danger:hover {
            background: linear-gradient(135deg, var(--danger-color), #f87171);
        }

        /* Mobile Sidebar Toggle */
        .sidebar-toggle {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            border: none;
            border-radius: 12px;
            padding: 0.75rem;
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3);
        }

        .sidebar-toggle:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(5, 150, 105, 0.4);
        }

        /* Enhanced Alert Styles */
        .alert {
            border: none;
            border-radius: 16px;
            padding: 1.25rem 1.75rem;
            margin-bottom: 2rem;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
            border-left: 4px solid var(--success-color);
        }

        .alert i {
            font-size: 1.2rem;
            margin-right: 0.75rem;
        }

        /* Enhanced Footer - Fixed z-index */
        .admin-footer {
            background: rgba(15, 23, 42, 0.98);
            backdrop-filter: blur(20px);
            color: white;
            padding: 2rem 0;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.1);
            margin-top: auto;
            position: relative;
            z-index: 900;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 1.5rem;
        }

        .footer-section h6 {
            color: var(--primary-light);
            font-weight: 600;
            margin-bottom: 1rem;
            font-size: 1rem;
        }

        .footer-section p,
        .footer-section a {
            color: #cbd5e1;
            text-decoration: none;
            font-size: 0.9rem;
            line-height: 1.6;
            transition: color 0.3s ease;
        }

        .footer-section a:hover {
            color: var(--primary-light);
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 0.5rem;
        }

        .footer-links a {
            display: flex;
            align-items: center;
        }

        .footer-links i {
            width: 16px;
            margin-right: 0.5rem;
            font-size: 0.9rem;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .footer-bottom p {
            margin: 0;
            color: #94a3b8;
            font-size: 0.9rem;
        }

        .social-links {
            display: flex;
            gap: 1rem;
        }

        .social-links a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            color: #cbd5e1;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        /* Search and Filter Styles */
        .search-filter-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(16, 185, 129, 0.1);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .search-input {
            border: 2px solid rgba(16, 185, 129, 0.2);
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(5, 150, 105, 0.25);
        }

        .filter-select {
            border: 2px solid rgba(16, 185, 129, 0.2);
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .filter-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(5, 150, 105, 0.25);
        }

        .clear-filters-btn {
            background: linear-gradient(135deg, var(--secondary-color), #94a3b8);
            border: none;
            border-radius: 10px;
            padding: 0.75rem 1.25rem;
            color: white;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .clear-filters-btn:hover {
            background: linear-gradient(135deg, #475569, var(--secondary-color));
            transform: translateY(-1px);
        }

        .no-results {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--secondary-color);
        }

        .no-results i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        /* Table enhancements */
        .table-hover tbody tr:hover {
            background-color: rgba(16, 185, 129, 0.05);
        }

        /* Responsive Design */
        @media (min-width: 992px) {
            .admin-sidebar {
                transform: translateX(0);
                position: fixed;
            }

            .main-content {
                margin-left: var(--sidebar-width);
            }

            .sidebar-toggle {
                display: none;
            }
        }

        @media (max-width: 991.98px) {
            .main-content {
                padding: 1rem;
            }

            .content-wrapper {
                padding: 1.5rem;
                border-radius: 16px;
            }

            .footer-content {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .footer-bottom {
                flex-direction: column;
                text-align: center;
            }

            .search-filter-container {
                padding: 1rem;
            }
        }

        @media (max-width: 576px) {
            .admin-header .navbar-brand {
                font-size: 1.3rem;
            }

            .content-wrapper {
                padding: 1rem;
            }

            .nav-group-title {
                padding: 0.5rem 1rem 0.75rem 1rem;
            }

            .sidebar-nav .nav-link {
                padding: 0.875rem 1rem;
                margin: 0.125rem 0.5rem;
            }
        }

        /* Overlay for mobile */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 998;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            backdrop-filter: blur(4px);
        }

        .sidebar-open .sidebar-overlay {
            opacity: 1;
            visibility: visible;
        }

        /* Animation for page load */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .content-wrapper {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Status indicators */
        .status-indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 0.5rem;
        }

        .status-online {
            background: var(--success-color);
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.3);
        }

        .status-offline {
            background: var(--secondary-color);
        }
    </style>
    @stack('styles')
</head>

<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg admin-header">
        <div class="container-fluid">
            <button class="sidebar-toggle me-3 d-lg-none" type="button" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <a class="navbar-brand" href="{{ route('admin.services.index') }}">
                <i class="fas fa-leaf me-2"></i>France-Isolation Admin
            </a>
            <div class="ms-auto d-flex align-items-center">
                <div class="me-3 d-none d-md-block">
                    <span class="status-indicator status-online"></span>
                    <small class="text-muted">System Online</small>
                </div>
                <div class="dropdown user-dropdown">
                    <button class="btn dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fas fa-user-circle me-2"></i>
                        <span class="d-none d-sm-inline">Admin User</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-user"></i> My Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-cog"></i> Account Settings
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-bell"></i> Notifications
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="{{ route('admin.logout') }}" method="POST"
                                onsubmit="return confirm('Êtes-vous sûr de vouloir vous déconnecter ?');">
                                @csrf
                                <button type="submit" class="btn btn-danger">
                                    Déconnexion
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>
    <!-- Enhanced Sidebar with Fixed Toggle Button -->
    <nav class="admin-sidebar">
        <!-- Desktop Toggle Button - Fixed positioning -->
        <button class="sidebar-toggle-btn d-none d-lg-block" onclick="toggleDesktopSidebar()" title="Toggle Sidebar">
            <i class="fas fa-chevron-left"></i>
        </button>
        <div class="sidebar-nav">
            <!-- Content Management Group -->
            <div class="nav-group">
                <div class="nav-group-title">
                    <i class="fas fa-edit"></i>
                    <span class="title-text">Content Management</span>
                </div>
                <a class="nav-link @if(Route::is('admin.banners.*')) active @endif"
                    href="{{ route('admin.banners.index') }}" data-tooltip="Banners">
                    <i class="fas fa-image"></i>
                    <span class="nav-text">Banners</span>
                </a>
                <a class="nav-link @if(Route::is('admin.categories.*')) active @endif"
                    href="{{ route('admin.categories.index') }}" data-tooltip="Categories">
                    <i class="fas fa-tags"></i>
                    <span class="nav-text">Categories</span>
                </a>
                <a class="nav-link @if(Route::is('admin.services.*')) active @endif"
                    href="{{ route('admin.services.index') }}" data-tooltip="Services">
                    <i class="fas fa-cogs"></i>
                    <span class="nav-text">Services</span>
                </a>
                <a class="nav-link @if(Route::is('admin.projects.*')) active @endif"
                    href="{{ route('admin.projects.index') }}" data-tooltip="Projects">
                    <i class="fas fa-briefcase"></i>
                    <span class="nav-text">Projects</span>
                </a>
                <a class="nav-link @if(Route::is('admin.blogs.*')) active @endif"
                    href="{{ route('admin.blogs.index') }}" data-tooltip="Blog Posts">
                    <i class="fas fa-blog"></i>
                    <span class="nav-text">Blog Posts</span>
                </a>
                <a class="nav-link @if(Route::is('admin.quotes.*')) active @endif"
                    href="{{ route('admin.quotes.index') }}" data-tooltip="quotes">
                    <i class="fas fa-file-invoice float-lg-start"></i>
                    <span class="nav-text">Quote</span>
                </a>
                <a class="nav-link @if(Route::is('admin.partners.*')) active @endif"
                    href="{{ route('admin.partners.index') }}" data-tooltip="Partners">
                    <i class="fas fa-handshake"></i>
                    <span class="nav-text">Partners</span>
                </a>
                <a class="nav-link @if(Route::is('admin.customers.*')) active @endif"
   href="{{ route('admin.customers.index') }}" data-tooltip="Clients">
  <i class="fa-solid fa-users"></i>
  <span class="nav-text">Customers</span>
</a>


                </a>
            </div>
            <!-- Communication Group -->
            <div class="nav-group">
                <div class="nav-group-title">
                    <i class="fas fa-comments"></i>
                    <span class="title-text">Communication</span>
                </div>
                <a class="nav-link @if(Route::is('admin.contacts.*')) active @endif"
                    href="{{ route('admin.contacts.index') }}" data-tooltip="Contact Messages">
                    <i class="fas fa-envelope"></i>
                    <span class="nav-text">Contact Messages</span>
                    <span class="badge">5</span>
                </a>
                <a class="nav-link @if(Route::is('admin.teams.*')) active @endif"
                    href="{{ route('admin.teams.index') }}" data-tooltip="Team Members">
                    <i class="fas fa-users"></i>
                    <span class="nav-text">Team Members</span>
                </a>
            </div>
            <!-- Site Configuration Group -->
            <div class="nav-group">
                <div class="nav-group-title">
                    <i class="fas fa-sliders-h"></i>
                    <span class="title-text">Site Configuration</span>
                </div>
                <a class="nav-link @if(Route::is('admin.about.*')) active @endif" href="{{ route('admin.about.edit') }}"
                    data-tooltip="About Page">
                    <i class="fas fa-info-circle"></i>
                    <span class="nav-text">About Page</span>
                </a>
                <a class="nav-link @if(Route::is('admin.social.*')) active @endif"
                    href="{{ route('admin.social.edit') }}" data-tooltip="Social Links">
                    <i class="fab fa-facebook"></i>
                    <span class="nav-text">Social Links</span>
                </a>
                <a class="nav-link @if(Route::is('admin.video.*')) active @endif" href="{{ route('admin.video.edit') }}"
                    data-tooltip="YouTube Video">
                    <i class="fab fa-youtube"></i>
                    <span class="nav-text">YouTube Video</span>
                </a>
                <a class="nav-link @if(Route::is('admin.stats.*')) active @endif"
                    href="{{ route('admin.stats.index') }}" data-tooltip="Stats">
                    <i class="fas fa-chart-line float-lg-start"></i>
                    <span class="nav-text">Statistiques</span>
                </a>
            </div>
            <!-- System Management Group -->
            <div class="nav-group">
                <div class="nav-group-title">
                    <i class="fas fa-server"></i>
                    <span class="title-text">System Management</span>
                </div>
                <a class="nav-link" href="#" data-tooltip="User Management">
                    <i class="fas fa-users-cog"></i>
                    <span class="nav-text">User Management</span>
                </a>
                <a class="nav-link" href="#" data-tooltip="Analytics">
                    <i class="fas fa-chart-line"></i>
                    <span class="nav-text">Analytics</span>
                </a>
                <a class="nav-link" href="#" data-tooltip="System Settings">
                    <i class="fas fa-cog"></i>
                    <span class="nav-text">System Settings</span>
                </a>
            </div>
        </div>
    </nav>
    <!-- Main Content Wrapper -->
    <div class="main-wrapper">
        <main class="main-content">
            <div class="content-wrapper">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i>
                        <div>
                            <strong>Success!</strong> {{ session('success') }}
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i>
                        <div>
                            <strong>Error!</strong> {{ session('error') }}
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @yield('content')
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mobile sidebar toggle
        function toggleSidebar() {
            document.body.classList.toggle('sidebar-open');
        }
        // Desktop sidebar collapse/expand
        function toggleDesktopSidebar() {
            document.body.classList.toggle('sidebar-collapsed');
            // Save state to localStorage
            const isCollapsed = document.body.classList.contains('sidebar-collapsed');
            localStorage.setItem('sidebarCollapsed', isCollapsed);
        }
        // Load saved sidebar state on page load
        document.addEventListener('DOMContentLoaded', function () {
            const savedState = localStorage.getItem('sidebarCollapsed');
            if (savedState === 'true') {
                document.body.classList.add('sidebar-collapsed');
            }
            // Initialize table search and filter if table exists
            if (document.getElementById('table')) {
                initializeTableSearchAndFilter();
            }
        });
        // Close mobile sidebar when clicking on a link
        document.querySelectorAll('.sidebar-nav .nav-link').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 992) {
                    document.body.classList.remove('sidebar-open');
                }
            });
        });
        // Close mobile sidebar on window resize if screen becomes large
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 992) {
                document.body.classList.remove('sidebar-open');
            }
        });
        // Add smooth scrolling to sidebar
        document.querySelector('.admin-sidebar').addEventListener('wheel', (e) => {
            e.preventDefault();
            e.currentTarget.scrollTop += e.deltaY;
        });
        // Auto-hide alerts after 5 seconds
        document.querySelectorAll('.alert').forEach(alert => {
            setTimeout(() => {
                if (alert.querySelector('.btn-close')) {
                    alert.querySelector('.btn-close').click();
                }
            }, 5000);
        });
        // Add loading state to buttons
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function () {
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
                    submitBtn.disabled = true;
                }
            });
        });
        // System status check (simulated)
        function updateSystemStatus() {
            const statusIndicator = document.querySelector('.status-indicator');
            const statusText = document.querySelector('.status-indicator').nextElementSibling;
            // Simulate random status check
            const isOnline = Math.random() > 0.1; // 90% uptime simulation
            if (isOnline) {
                statusIndicator.className = 'status-indicator status-online';
                statusText.textContent = 'System Online';
            } else {
                statusIndicator.className = 'status-indicator status-offline';
                statusText.textContent = 'System Offline';
            }
        }
        // Update system status every 30 seconds
        setInterval(updateSystemStatus, 30000);
        // Keyboard shortcut for sidebar toggle (Ctrl/Cmd + B)
        document.addEventListener('keydown', function (e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'b') {
                e.preventDefault();
                if (window.innerWidth >= 992) {
                    toggleDesktopSidebar();
                } else {
                    toggleSidebar();
                }
            }
        });
        // Advanced Table Search and Filter System
        function initializeTableSearchAndFilter() {
            const table = document.getElementById('table');
            if (!table) return;
            // Create search and filter container
            const searchContainer = document.createElement('div');
            searchContainer.className = 'search-filter-container';
            searchContainer.innerHTML = `
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="tableSearch" class="form-label">
                            <i class="fas fa-search me-2"></i>Search
                        </label>
                        <input type="text" id="tableSearch" class="form-control search-input" placeholder="Search in all columns...">
                    </div>
                    <div class="col-md-3">
                        <label for="columnFilter" class="form-label">
                            <i class="fas fa-filter me-2"></i>Filter by Column
                        </label>
                        <select id="columnFilter" class="form-select filter-select">
                            <option value="">All Columns</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="rowsPerPage" class="form-label">
                            <i class="fas fa-list me-2"></i>Rows per Page
                        </label>
                        <select id="rowsPerPage" class="form-select filter-select">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="all">All</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="button" id="clearFilters" class="btn clear-filters-btn w-100">
                            <i class="fas fa-times me-2"></i>Clear
                        </button>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Showing <span id="resultCount">0</span> of <span id="totalCount">0</span> entries
                        </small>
                    </div>
                </div>
            `;
            // Insert search container before the table
            table.parentNode.insertBefore(searchContainer, table);
            // Get table elements
            const tbody = table.querySelector('tbody');
            const thead = table.querySelector('thead');
            const rows = Array.from(tbody.querySelectorAll('tr'));
            const headers = Array.from(thead.querySelectorAll('th'));
            // Populate column filter dropdown
            const columnFilter = document.getElementById('columnFilter');
            headers.forEach((header, index) => {
                if (header.textContent.trim() !== 'Actions') { // Skip actions column
                    const option = document.createElement('option');
                    option.value = index;
                    option.textContent = header.textContent.trim();
                    columnFilter.appendChild(option);
                }
            });
            // Search and filter variables
            let currentSearchTerm = '';
            let currentColumnFilter = '';
            let currentRowsPerPage = 10;
            let currentPage = 1;
            let filteredRows = [...rows];
            // Update result count
            function updateResultCount() {
                document.getElementById('resultCount').textContent = filteredRows.length;
                document.getElementById('totalCount').textContent = rows.length;
            }
            // Filter rows based on search and column filter
            function filterRows() {
                filteredRows = rows.filter(row => {
                    const cells = Array.from(row.querySelectorAll('td'));
                    // Apply search filter
                    let matchesSearch = true;
                    if (currentSearchTerm) {
                        const searchColumns = currentColumnFilter ? [parseInt(currentColumnFilter)] : cells.map((_, index) => index);
                        matchesSearch = searchColumns.some(colIndex => {
                            if (cells[colIndex]) {
                                const cellText = cells[colIndex].textContent.toLowerCase();
                                return cellText.includes(currentSearchTerm.toLowerCase());
                            }
                            return false;
                        });
                    }
                    return matchesSearch;
                });
                displayRows();
                updateResultCount();
            }
            // Display rows with pagination
            function displayRows() {
                // Hide all rows first
                rows.forEach(row => row.style.display = 'none');
                // Show filtered rows based on pagination
                if (currentRowsPerPage === 'all') {
                    filteredRows.forEach(row => row.style.display = '');
                } else {
                    const startIndex = (currentPage - 1) * parseInt(currentRowsPerPage);
                    const endIndex = startIndex + parseInt(currentRowsPerPage);
                    const pageRows = filteredRows.slice(startIndex, endIndex);
                    pageRows.forEach(row => row.style.display = '');
                }
                // Show no results message if needed
                showNoResultsMessage();
                updatePagination();
            }
            // Show no results message
            function showNoResultsMessage() {
                let noResultsRow = tbody.querySelector('.no-results-row');
                if (filteredRows.length === 0) {
                    if (!noResultsRow) {
                        noResultsRow = document.createElement('tr');
                        noResultsRow.className = 'no-results-row';
                        noResultsRow.innerHTML = `
                            <td colspan="${headers.length}" class="no-results">
                                <i class="fas fa-search"></i>
                                <h5>No results found</h5>
                                <p>Try adjusting your search terms or filters</p>
                            </td>
                        `;
                        tbody.appendChild(noResultsRow);
                    }
                    noResultsRow.style.display = '';
                } else {
                    if (noResultsRow) {
                        noResultsRow.style.display = 'none';
                    }
                }
            }
            // Update pagination
            function updatePagination() {
                let paginationContainer = document.querySelector('.custom-pagination');
                if (currentRowsPerPage === 'all' || filteredRows.length <= parseInt(currentRowsPerPage)) {
                    if (paginationContainer) {
                        paginationContainer.remove();
                    }
                    return;
                }
                const totalPages = Math.ceil(filteredRows.length / parseInt(currentRowsPerPage));
                if (!paginationContainer) {
                    paginationContainer = document.createElement('div');
                    paginationContainer.className = 'custom-pagination d-flex justify-content-center mt-3';
                    table.parentNode.appendChild(paginationContainer);
                }
                let paginationHTML = '<nav><ul class="pagination">';
                // Previous button
                paginationHTML += `
                    <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                        <a class="page-link" href="#" data-page="${currentPage - 1}">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </li>
                `;
                // Page numbers
                for (let i = 1; i <= totalPages; i++) {
                    if (i === 1 || i === totalPages || (i >= currentPage - 2 && i <= currentPage + 2)) {
                        paginationHTML += `
                            <li class="page-item ${i === currentPage ? 'active' : ''}">
                                <a class="page-link" href="#" data-page="${i}">${i}</a>
                            </li>
                        `;
                    } else if (i === currentPage - 3 || i === currentPage + 3) {
                        paginationHTML += '<li class="page-item disabled"><span class="page-link">...</span></li>';
                    }
                }
                // Next button
                paginationHTML += `
                    <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                        <a class="page-link" href="#" data-page="${currentPage + 1}">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                `;
                paginationHTML += '</ul></nav>';
                paginationContainer.innerHTML = paginationHTML;
                // Add pagination click handlers
                paginationContainer.querySelectorAll('.page-link').forEach(link => {
                    link.addEventListener('click', function (e) {
                        e.preventDefault();
                        const page = parseInt(this.dataset.page);
                        if (page && page !== currentPage && page >= 1 && page <= totalPages) {
                            currentPage = page;
                            displayRows();
                        }
                    });
                });
            }
            // Event listeners
            document.getElementById('tableSearch').addEventListener('input', function () {
                currentSearchTerm = this.value;
                currentPage = 1;
                filterRows();
            });
            document.getElementById('columnFilter').addEventListener('change', function () {
                currentColumnFilter = this.value;
                currentPage = 1;
                filterRows();
            });
            document.getElementById('rowsPerPage').addEventListener('change', function () {
                currentRowsPerPage = this.value;
                currentPage = 1;
                displayRows();
            });
            document.getElementById('clearFilters').addEventListener('click', function () {
                document.getElementById('tableSearch').value = '';
                document.getElementById('columnFilter').value = '';
                document.getElementById('rowsPerPage').value = '10';
                currentSearchTerm = '';
                currentColumnFilter = '';
                currentRowsPerPage = 10;
                currentPage = 1;
                filteredRows = [...rows];
                displayRows();
                updateResultCount();
            });
            // Initialize
            filterRows();
        }
    </script>
    @stack('scripts')
</body>

</html>