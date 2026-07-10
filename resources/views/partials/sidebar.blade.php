<div class="bg-black text-white d-flex flex-column shadow"
     style="width:260px; min-height:100vh;">

    <!-- Logo -->
    <div class="p-4 border-bottom border-secondary">

        <h3 class="text-info fw-bold mb-0">
            <i class="fas fa-globe-asia me-2"></i>
            SupplyRisk
        </h3>

        <small class="text-secondary">
            Intelligence Platform
        </small>

    </div>

    <div class="mt-4">

        <small class="text-secondary px-4">
            DASHBOARD
        </small>

        <ul class="nav flex-column mt-2">

            <li class="nav-item">

                <a class="nav-link py-3 px-4 {{ request()->is('/') ? 'active bg-info text-white rounded' : 'text-white' }}"
                   href="{{ url('/') }}">

                    <i class="fas fa-chart-line me-2"></i>

                    Dashboard

                </a>

            </li>

            <li class="nav-item">

                <a class="nav-link py-3 px-4 {{ request()->is('countries*') ? 'active bg-success text-white rounded' : 'text-white' }}"
                   href="{{ route('countries.index') }}">

                    <i class="fas fa-globe me-2"></i>

                    Negara

                </a>

            </li>

            <li class="nav-item">

                <a class="nav-link text-white py-3 px-4 {{ request()->routeIs('weather.*') ? 'active bg-warning text-dark' : '' }}"
                    href="{{ route('weather.index') }}">

                    <i class="fas fa-cloud-sun me-2 text-warning"></i>

                    Cuaca Global

                </a>

            </li>

            <li class="nav-item">

                <a class="nav-link py-3 px-4 {{ request()->is('ports*') ? 'active bg-primary text-white rounded' : 'text-white' }}"
                    href="{{ route('ports.index') }}">

                    <i class="fas fa-ship me-2 text-primary"></i>

                    Pelabuhan

</a>

                </a>

            </li>

        </ul>

        <hr class="border-secondary">

        <small class="text-secondary px-4">
            ANALISIS
        </small>

        <ul class="nav flex-column mt-2">

            <li class="nav-item">

                <a class="nav-link py-3 px-4 text-white"
                   href="#">

                    <i class="fas fa-chart-pie me-2 text-danger"></i>

                    Risk Score

                </a>

            </li>

            <li class="nav-item">

                <a class="nav-link py-3 px-4 text-white"
                   href="#">

                    <i class="fas fa-newspaper me-2 text-info"></i>

                    Berita

                </a>

            </li>

            <li class="nav-item">

                <a class="nav-link py-3 px-4 text-white"
                   href="#">

                    <i class="fas fa-star me-2 text-warning"></i>

                    Watchlist

                </a>

            </li>

        </ul>

    </div>

    <div class="mt-auto p-4 border-top border-secondary">

        <small class="text-secondary">

            Version 1.0

        </small>

    </div>

</div>