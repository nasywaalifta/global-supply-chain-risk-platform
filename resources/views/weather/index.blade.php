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
            Data Cuaca Global dari Open-Meteo API
        </small>
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
            <div class="card border-0 shadow-sm mb-3">
    <div class="card-body">

        <label class="form-label fw-semibold">
            <i class="fas fa-globe me-2 text-primary"></i>
            Pilih Negara
        </label>

        <select id="countrySelect" class="form-select">
            <option value="">-- Pilih Negara --</option>

            @foreach($mapWeather as $country)
                <option
                    value="{{ $country->name }}"
                    data-lat="{{ $country->latitude }}"
                    data-lng="{{ $country->longitude }}">
                    {{ $country->name }}
                </option>
            @endforeach

        </select>

    </div>
</div>

                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-body py-2">

                            <strong>Legenda :</strong>

                            <span class="badge bg-success ms-3">🟢 Rendah</span>
                            <span class="badge bg-warning text-dark ms-2">🟡 Sedang</span>
                            <span class="badge bg-danger ms-2">🔴 Tinggi</span>

                        </div>
                    </div>
                    <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">
                                <i class="fas fa-earth-asia me-2 text-primary"></i>
                                Peta Monitoring Cuaca
                            </h5>
                            <span class="badge bg-primary">
                                {{ $mapWeather->count() }} Negara
                            </span>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div id="weatherMap" style="height:600px; border-radius:12px;"></div>
                    </div>

                    </div>               
                </div>
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
                            <strong>{{ $item->port->country->name }}</strong>
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
@push('styles')
<link rel="stylesheet"
href="https://unpkg.com/leaflet/dist/leaflet.css"/>
@endpush
@push('scripts')
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
var map = L.map('weatherMap').setView([20, 0], 2);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap'
}).addTo(map);

// Simpan semua marker
let markers = {};

// Icon marker
const greenIcon = new L.Icon({
    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-green.png',
    shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
    iconSize: [25, 41],
    iconAnchor: [12, 41],
    popupAnchor: [1, -34],
    shadowSize: [41, 41]
});

const yellowIcon = new L.Icon({
    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-yellow.png',
    shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
    iconSize: [25, 41],
    iconAnchor: [12, 41],
    popupAnchor: [1, -34],
    shadowSize: [41, 41]
});

const redIcon = new L.Icon({
    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
    shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
    iconSize: [25, 41],
    iconAnchor: [12, 41],
    popupAnchor: [1, -34],
    shadowSize: [41, 41]
});

@foreach($mapWeather as $country)

    @php
        $port = $country->ports->first();
        $weather = $port?->weather;

        $icon = 'greenIcon';

        if ($weather) {
            if ($weather->storm_risk == 'Sedang') {
                $icon = 'yellowIcon';
            }

            if ($weather->storm_risk == 'Tinggi') {
                $icon = 'redIcon';
            }
        }
    @endphp

    @if($weather && $country->latitude && $country->longitude)

        var marker = L.marker(
            [
                {{ $country->latitude }},
                {{ $country->longitude }}
            ],
            {
                icon: {{ $icon }}
            }
        ).addTo(map);

        markers["{{ $country->name }}"] = marker;

        marker.bindPopup(`
<div style="min-width:240px">
<h6 class="fw-bold mb-2">🌍 {{ $country->name }}</h6>
<table class="table table-sm mb-0">
<tr><td>🌡️ Suhu</td><td><b>{{ $weather->temperature }} °C</b></td></tr>
<tr><td>🌧️ Hujan</td><td><b>{{ $weather->precipitation }} mm</b></td></tr>
<tr><td>💨 Angin</td><td><b>{{ $weather->wind_speed }} km/h</b></td></tr>
<tr><td>🌪️ Risiko</td><td><b>{{ $weather->storm_risk }}</b></td></tr>
</table>
</div>
`);

    @endif

@endforeach

document.getElementById('countrySelect').addEventListener('change', function () {

    let option = this.options[this.selectedIndex];

    if (!option.value) return;

    let lat = parseFloat(option.dataset.lat);
    let lng = parseFloat(option.dataset.lng);

    map.flyTo([lat, lng], 5, {
        duration: 1.5
    });

    if (markers[option.value]) {
        markers[option.value].openPopup();
    }

});
</script>
@endpush
@endsection