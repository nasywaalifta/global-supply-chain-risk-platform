@extends('layouts.app')

@section('breadcrumb', 'Monitoring Cuaca Global')

@section('content')

<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: var(--text-main);">
                🌦 Monitoring Cuaca Global
            </h2>
            <small class="text-muted">
                Data Cuaca Real-Time dari Open-Meteo API
            </small>
        </div>
        <div class="text-end">
            <small class="text-muted">Update :</small>
            <br>
            <strong>{{ now()->format('d M Y H:i') }}</strong>
        </div>
    </div>

    <!-- Card Statistik -->
    <div class="row g-3 mb-4">

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between p-3">
                    <div>
                        <small class="text-muted text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">Rata-rata Suhu</small>
                        <h3 class="fw-bold mb-0 mt-1" style="color: var(--text-main);">{{ $avgTemperature }}°C</h3>
                    </div>
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background-color: rgba(14, 116, 144, 0.1); color: var(--primary-color);">
                        <i class="fas fa-temperature-half fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between p-3">
                    <div>
                        <small class="text-muted text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">Curah Hujan</small>
                        <h3 class="fw-bold mb-0 mt-1" style="color: var(--text-main);">{{ $avgRain }} mm</h3>
                    </div>
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background-color: rgba(6, 182, 212, 0.1); color: var(--primary-light);">
                        <i class="fas fa-cloud-showers-heavy fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between p-3">
                    <div>
                        <small class="text-muted text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">Angin Terkuat</small>
                        <h3 class="fw-bold mb-0 mt-1" style="color: var(--text-main);">{{ $maxWind }} km/h</h3>
                    </div>
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background-color: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                        <i class="fas fa-wind fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between p-3">
                    <div>
                        <small class="text-muted text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">Risiko Tinggi</small>
                        <h3 class="fw-bold mb-0 mt-1 text-danger">{{ $highRisk }}</h3>
                    </div>
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background-color: rgba(239, 68, 68, 0.1); color: #ef4444;">
                        <i class="fas fa-triangle-exclamation fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Filter Form -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <form method="GET" action="{{ route('weather.index') }}" class="mb-0">
                <div class="row g-2">
                    <div class="col-md-5">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            class="form-control"
                            placeholder="🔍 Cari negara..."
                            style="height:48px;">
                    </div>
                    <div class="col-md-3">
                        <select
                            name="risk"
                            class="form-select"
                            style="height:48px;">
                            <option value="">Semua Risiko Badai</option>
                            <option value="Rendah" {{ request('risk')=='Rendah'?'selected':'' }}>Rendah</option>
                            <option value="Sedang" {{ request('risk')=='Sedang'?'selected':'' }}>Sedang</option>
                            <option value="Tinggi" {{ request('risk')=='Tinggi'?'selected':'' }}>Tinggi</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-grid">
                        <button class="btn btn-primary" style="height:48px;">
                            <i class="fas fa-search me-1"></i> Cari
                        </button>
                    </div>
                    <div class="col-md-2 d-grid">
                        <a href="{{ route('weather.index') }}" class="btn btn-secondary d-flex align-items-center justify-content-center" style="height:48px;">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel -->
    <div class="card border-0 shadow-sm">
        <div class="card-header">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-cloud-sun me-2 text-primary"></i>
                Data Cuaca Negara
            </h5>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Negara</th>
                        <th>Temperatur</th>
                        <th>Curah Hujan</th>
                        <th>Kecepatan Angin</th>
                        <th>Risiko Badai</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($weather as $item)
                    <tr>
                        <td>
                            <strong>{{ $item->country->name }}</strong>
                        </td>
                        <td>
                            {{ $item->temperature }} °C
                        </td>
                        <td>
                            {{ $item->precipitation }} mm
                        </td>
                        <td>
                            {{ $item->wind_speed }} km/h
                        </td>
                        <td>
                            @php
                                $stormCustomStyle = 'background-color: #f1f5f9; color: #475569;';
                                if ($item->storm_risk == 'Tinggi') {
                                    $stormCustomStyle = 'background-color: rgba(239, 68, 68, 0.1) !important; color: #dc2626 !important; border: 1px solid rgba(239, 68, 68, 0.2) !important;';
                                } elseif ($item->storm_risk == 'Sedang') {
                                    $stormCustomStyle = 'background-color: rgba(245, 158, 11, 0.1) !important; color: #b45309 !important; border: 1px solid rgba(245, 158, 11, 0.2) !important;';
                                } else {
                                    $stormCustomStyle = 'background-color: rgba(16, 185, 129, 0.1) !important; color: #047857 !important; border: 1px solid rgba(16, 185, 129, 0.2) !important;';
                                }
                            @endphp
                            <span class="badge px-3 py-2 rounded-3 fw-bold" style="{{ $stormCustomStyle }} font-size: 0.72rem; letter-spacing: 0.5px;">
                                {{ $item->storm_risk == 'Tinggi' ? 'TINGGI' : ($item->storm_risk == 'Sedang' ? 'SEDANG' : 'RENDAH') }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            Belum ada data cuaca.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $weather->links() }}
        </div>
    </div>

</div>
@endsection