<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - SupplyRisk Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Google Fonts (Inter & Outfit) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

    <!-- Premium Custom Theme -->
    <link rel="stylesheet" href="{{ asset('css/premium-theme.css') }}">

    <style>
        .select2-container {
            width: 100% !important;
        }

        .select2-container--default .select2-selection--single {
            height: 48px !important;
            border: 1px solid #cbd5e1 !important;
            border-radius: 10px !important;
            display: flex !important;
            align-items: center !important;
            background-color: #ffffff !important;
            transition: all 0.2s ease !important;
        }

        .select2-container--default .select2-selection--single:focus,
        .select2-container--default .select2-selection--single.select2-container--focus {
            border-color: #06b6d4 !important;
            box-shadow: 0 0 0 4px rgba(6, 182, 212, 0.1) !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 48px !important;
            padding-left: 16px !important;
            color: #0f172a !important;
            font-size: 0.92rem;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 46px !important;
            right: 10px !important;
        }

        .select2-dropdown {
            border: 1px solid #cbd5e1 !important;
            border-radius: 10px !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
            overflow: hidden;
            font-size: 0.92rem;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #0e7490 !important;
        }
        
        .list-group-item {
            border-color: #e2e8f0 !important;
            color: #334155 !important;
            background-color: transparent !important;
        }
    </style>

    @stack('styles')

</head>

<body>

<div class="d-flex min-vh-100">

    {{-- Admin Sidebar --}}
    <div class="sidebar-custom">
        <!-- Logo -->
        <div class="sidebar-logo d-flex align-items-center">
            <div class="me-3 d-flex align-items-center justify-content-center text-white rounded-3 shadow-sm" 
                 style="width: 40px; height: 40px; background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary-color) 100%);">
                <i class="fas fa-user-shield fs-5 text-white"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-0 text-white" style="letter-spacing: 0.5px; font-size: 1.15rem;">
                    Supply<span class="text-warning">Risk</span>
                </h5>
                <small class="text-uppercase fw-semibold" style="font-size: 0.62rem; letter-spacing: 1px; color: #64748b;">
                    Admin Panel
                </small>
            </div>
        </div>

        <!-- Menus -->
        <div class="sidebar-menu flex-grow-1">
            <div class="sidebar-section-title">
                NAVIGASI UTAMA
            </div>

            <ul class="nav flex-column mb-4">
                <li class="nav-item">
                    <a class="nav-link nav-link-custom {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                       href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-chart-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link nav-link-custom {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                       href="{{ route('admin.users.index') }}">
                        <i class="fas fa-users"></i>
                        <span>Kelola User</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link nav-link-custom {{ request()->routeIs('admin.ports.*') ? 'active' : '' }}"
                       href="{{ route('admin.ports.index') }}">
                        <i class="fas fa-anchor"></i>
                        <span>Kelola Pelabuhan</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link nav-link-custom {{ request()->routeIs('admin.articles.*') ? 'active' : '' }}"
                       href="{{ route('admin.articles.index') }}">
                        <i class="fas fa-file-alt"></i>
                        <span>Kelola Artikel</span>
                    </a>
                </li>
            </ul>

            <div class="sidebar-section-title">
                AKSES LAINNYA
            </div>
            <ul class="nav flex-column mb-4">
                <li class="nav-item">
                    <a class="nav-link nav-link-custom" href="{{ route('dashboard') }}">
                        <i class="fas fa-globe"></i>
                        <span>Kembali ke Web</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Footer -->
        <div class="p-3 border-top mt-auto" style="border-color: rgba(255, 255, 255, 0.05) !important; background-color: rgba(0, 0, 0, 0.2) !important;">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="avatar text-white rounded-circle d-flex align-items-center justify-content-center me-2 shadow-sm" 
                         style="width: 36px; height: 36px; font-size: 0.85rem; font-weight: 600; background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 2)) }}
                    </div>
                    <div>
                        <h6 class="mb-0 text-white fw-bold" style="font-size: 0.85rem; font-family: var(--font-heading);">{{ Auth::user()->name }}</h6>
                        <small class="text-muted" style="font-size: 0.7rem;">Administrator</small>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('logout') }}" class="mb-0">
                    @csrf
                    <button type="submit" class="btn btn-link text-danger p-0 ms-2" title="Keluar" style="transition: all 0.2s ease;">
                        <i class="fas fa-sign-out-alt fs-5 hover:text-danger"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="flex-grow-1 d-flex flex-column main-wrapper">

        {{-- Navbar --}}
        @include('partials.navbar')

        <main class="container-fluid p-4 flex-grow-1">

            @yield('content')

        </main>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@stack('scripts')

</body>

</html>