<div class="sidebar-custom">

    <!-- Logo -->
    <div class="sidebar-logo d-flex align-items-center">
        <div class="me-3 d-flex align-items-center justify-content-center text-white rounded-3 shadow-sm" 
             style="width: 40px; height: 40px; background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary-color) 100%);">
            <i class="fas fa-globe-asia fs-5 text-white"></i>
        </div>
        <div>
            <h5 class="fw-bold mb-0 text-white" style="letter-spacing: 0.5px; font-size: 1.15rem;">
                Supply<span class="text-warning">Risk</span>
            </h5>
            <small class="text-uppercase fw-semibold" style="font-size: 0.62rem; letter-spacing: 1px; color: #4b5563;">
                Intelligence Platform
            </small>
        </div>
    </div>

    <!-- Menus -->
    <div class="sidebar-menu flex-grow-1">

        <!-- ================= DASHBOARD ================= -->
        <div class="sidebar-section-title">
            DASHBOARD
        </div>

        <ul class="nav flex-column mb-4">
            <li class="nav-item">
                <a class="nav-link nav-link-custom {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                   href="{{ route('dashboard') }}">
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- ================= MONITORING ================= -->
        <div class="sidebar-section-title">
            MONITORING
        </div>

            <li class="nav-item">
                <a class="nav-link nav-link-custom {{ request()->routeIs('weather.index') ? 'active' : '' }}"
                   href="{{ route('weather.index') }}">
                    <i class="fas fa-cloud-sun"></i>
                    <span>Monitoring Cuaca</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link nav-link-custom {{ request()->routeIs('ports.index') ? 'active' : '' }}"
                   href="{{ route('ports.index') }}">
                    <i class="fas fa-anchor"></i>
                    <span>Lokasi Pelabuhan</span>
                </a>
            </li>
        </ul>

        <!-- ================= ANALISIS DATA ================= -->
        <div class="sidebar-section-title">
            Analisis Data
        </div>

        <ul class="nav flex-column mb-4">
            <li class="nav-item">
                <a class="nav-link nav-link-custom {{ request()->routeIs('countries.index') || request()->routeIs('countries.show') ? 'active' : '' }}"
                   href="{{ route('countries.index') }}">
                    <i class="fas fa-globe-americas"></i>
                    <span>Data Negara</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link nav-link-custom {{ request()->routeIs('exchange-rates.index') ? 'active' : '' }}"
                   href="{{ route('exchange-rates.index') }}">
                    <i class="fas fa-exchange-alt"></i>
                    <span>Kurs Mata Uang</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link nav-link-custom {{ request()->routeIs('visualisasi.index') ? 'active' : '' }}"
                   href="{{ route('visualisasi.index') }}">
                    <i class="fas fa-chart-area"></i>
                    <span>Visualisasi Data</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link nav-link-custom {{ request()->routeIs('risk-score.index') ? 'active' : '' }}"
                   href="{{ route('risk-score.index') }}">
                    <i class="fas fa-triangle-exclamation"></i>
                    <span>Skor Risiko</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link nav-link-custom {{ request()->routeIs('comparison.index') ? 'active' : '' }}"
                   href="{{ route('comparison.index') }}">
                    <i class="fas fa-balance-scale"></i>
                    <span>Perbandingan Negara</span>
                </a>
            </li>
        </ul>

        <!-- ================= INFORMASI ================= -->
        <div class="sidebar-section-title">
            INFORMASI
        </div>

        <ul class="nav flex-column mb-4">
            <li class="nav-item">
                <a class="nav-link nav-link-custom {{ request()->routeIs('news.index') ? 'active' : '' }}"
                   href="{{ route('news.index') }}">
                    <i class="fas fa-newspaper"></i>
                    <span>Berita Global</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link nav-link-custom {{ request()->routeIs('articles.index') || request()->routeIs('articles.show') ? 'active' : '' }}"
                   href="{{ route('articles.index') }}">
                    <i class="fas fa-file-alt"></i>
                    <span>Artikel Analisis</span>
                </a>
            </li>
        </ul>

        <!-- ================= WATCHLIST ================= -->
        <div class="sidebar-section-title">
            Watchlist
        </div>

        <ul class="nav flex-column mb-4">
            <li class="nav-item">
                <a class="nav-link nav-link-custom {{ request()->routeIs('watchlist.index') ? 'active' : '' }}"
                   href="{{ route('watchlist.index') }}">
                    <i class="fas fa-star"></i>
                    <span>Daftar Pantau</span>
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
                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 2)) }}
                </div>
                <div>
                    <h6 class="mb-0 text-white fw-bold" style="font-size: 0.85rem; font-family: var(--font-heading);">{{ Auth::user()->name }}</h6>
                    <small class="text-muted" style="font-size: 0.7rem;">Analyst User</small>
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