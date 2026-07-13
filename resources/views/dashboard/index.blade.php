@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2 class="text-white fw-bold mb-0">
        <i class="fas fa-chart-line text-info me-2"></i>
        Dashboard Utama
    </h2>

    <span class="badge bg-success fs-6">
        <i class="fas fa-circle me-1"></i>
        Sistem Aktif
    </span>

</div>

{{-- CARD STATISTIK --}}

<div class="row g-3 mb-4">

    <div class="col-xl-2 col-md-4">
        <div class="card bg-primary text-white border-0 shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small>Total Negara</small>
                        <h2>{{ $totalCountries }}</h2>
                    </div>
                    <i class="fas fa-globe fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-md-4">
        <div class="card bg-danger text-white border-0 shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small>Risiko Tinggi</small>
                        <h2>{{ $highRisk }}</h2>
                    </div>
                    <i class="fas fa-triangle-exclamation fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-md-4">
        <div class="card bg-warning text-dark border-0 shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small>Risiko Sedang</small>
                        <h2>{{ $mediumRisk }}</h2>
                    </div>
                    <i class="fas fa-circle-half-stroke fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-md-4">
        <div class="card bg-success text-white border-0 shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small>Risiko Rendah</small>
                        <h2>{{ $lowRisk }}</h2>
                    </div>
                    <i class="fas fa-shield-heart fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-md-4">
        <div class="card bg-info text-white border-0 shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small>Berita</small>
                        <h2>{{ $totalNews }}</h2>
                    </div>
                    <i class="fas fa-newspaper fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-md-4">
        <div class="card bg-secondary text-white border-0 shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small>Pelabuhan</small>
                        <h2>{{ $totalPorts }}</h2>
                    </div>
                    <i class="fas fa-ship fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

</div>

    

{{-- MAP + RINGKASAN --}}

<div class="row mb-4">

    <div class="col-lg-8">

        <div class="card bg-dark text-white shadow">

            <div class="card-header">
                🗺️ Peta Monitoring Global
            </div>

            <div class="card-body">

                <div id="map"
                     style="height:420px; width:100%; border-radius:12px;">
                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-4">

        <div class="card bg-dark text-white shadow mb-3">

            <div class="card-header">
                📈 Ringkasan Risiko
            </div>

            <div class="card-body">

                @php

                    $totalRisk = $highRisk + $mediumRisk + $lowRisk;

                    $highPercent = $totalRisk ? ($highRisk / $totalRisk) * 100 : 0;
                    $mediumPercent = $totalRisk ? ($mediumRisk / $totalRisk) * 100 : 0;
                    $lowPercent = $totalRisk ? ($lowRisk / $totalRisk) * 100 : 0;

                @endphp

                <div class="mb-4">

                    <div class="d-flex justify-content-between">

                        <span>🔴 Risiko Tinggi</span>

                        <strong>{{ $highRisk }}</strong>

                    </div>

                    <div class="progress mt-2">

                        <div class="progress-bar bg-danger"
                             style="width: {{ $highPercent }}%">

                            {{ number_format($highPercent,1) }}%

                        </div>

                    </div>

                </div>

                <div class="mb-4">

                    <div class="d-flex justify-content-between">

                        <span>🟡 Risiko Sedang</span>

                        <strong>{{ $mediumRisk }}</strong>

                    </div>

                    <div class="progress mt-2">

                        <div class="progress-bar bg-warning text-dark"
                             style="width: {{ $mediumPercent }}%">

                            {{ number_format($mediumPercent,1) }}%

                        </div>

                    </div>

                </div>

                <div>

                    <div class="d-flex justify-content-between">

                        <span>🟢 Risiko Rendah</span>

                        <strong>{{ $lowRisk }}</strong>

                    </div>

                    <div class="progress mt-2">

                        <div class="progress-bar bg-success"
                             style="width: {{ $lowPercent }}%">

                            {{ number_format($lowPercent,1) }}%

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="card bg-dark text-white shadow">

            <div class="card-header">
                ⭐ Daftar Pantau
            </div>

            <div class="card-body">

                @if($totalWatchlist)

                    <div class="alert alert-success mb-0">

                        Total Daftar Pantau :
                        <strong>{{ $totalWatchlist }}</strong>

                    </div>

                @else

                    <span class="text-secondary">

                        Belum ada negara yang dipantau.

                    </span>

                @endif

            </div>

        </div>

    </div>

</div>

{{-- TABEL + QUICK ACTION --}}

<div class="row">

    <div class="col-lg-8">

        <div class="card bg-dark text-white shadow">

            <div class="card-header d-flex justify-content-between align-items-center">

                <span>
                    🌍 Monitoring Negara
                </span>

                <span class="badge bg-info">
                    {{ $totalCountries }} Data Negara
                </span>

            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-dark table-hover mb-0 align-middle">

                        <thead>

                        <tr>

                            <th>Negara</th>

                            <th>Region</th>

                            <th>Ibukota</th>

                            <th>Status</th>

                        </tr>

                        </thead>

                        <tbody>

                        @forelse($countries->take(15) as $country)

                            <tr>

                                <td>

                                    <strong>{{ $country->name }}</strong>

                                </td>

                                <td>

                                    {{ $country->region }}

                                </td>

                                <td>

                                    {{ $country->capital ?? '-' }}

                                </td>

                                <td>

                                    <span class="badge bg-secondary">
                                        Belum Dinilai
                                    </span>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4" class="text-center py-4">

                                    Tidak ada data negara.

                                </td>

                            </tr>

                        @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

            <div class="card-footer text-end">

                <a href="{{ route('countries.index') }}"
                   class="btn btn-outline-info btn-sm">

                    Lihat Seluruh Negara →

                </a>

            </div>

        </div>

    </div>

    <div class="col-lg-4">

        <div class="card bg-dark text-white shadow">

            <div class="card-header">

                ⚡ Menu Cepat

            </div>

            <div class="card-body d-grid gap-2">

                <button class="btn btn-info">
                    🌍 Negara
                </button>

                <button class="btn btn-primary">
                    🚢 Pelabuhan
                </button>

                <button class="btn btn-warning">
                    ☁ Cuaca
                </button>

                <button class="btn btn-success">
                    📰 Berita
                </button>

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>

document.addEventListener("DOMContentLoaded", function () {

    const map = L.map('map', {
        center: [20, 0],
        zoom: 2
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors',
        maxZoom: 18
    }).addTo(map);

    setTimeout(function () {
        map.invalidateSize();
        map.setView([20, 0], 2);
    }, 300);

});

</script>

@endpush