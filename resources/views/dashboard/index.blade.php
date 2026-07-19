@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                <i class="fas fa-chart-line text-primary"></i>
                Dashboard
            </h2>

            <small class="text-muted">
                Global Supply Chain Risk Intelligence Platform
            </small>
        </div>

    </div>

    <!-- Statistik -->
    <div class="row g-3 mb-4">

        <div class="col-xl-2 col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between p-3">
                    <div>
                        <small class="text-muted text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">
                            Total Negara
                        </small>
                        <h2 class="fw-bold mb-0 mt-1" style="font-size: 1.8rem; color: var(--text-main);">
                            {{ $totalCountries }}
                        </h2>
                    </div>
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 46px; height: 46px; background-color: rgba(15, 118, 110, 0.1); color: var(--primary-color);">
                        <i class="fas fa-globe fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between p-3">
                    <div>
                        <small class="text-muted text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">
                            Risiko Tinggi
                        </small>
                        <h2 class="fw-bold mb-0 mt-1 text-danger" style="font-size: 1.8rem;">
                            {{ $highRisk }}
                        </h2>
                    </div>
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 46px; height: 46px; background-color: rgba(239, 68, 68, 0.1); color: #ef4444;">
                        <i class="fas fa-triangle-exclamation fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between p-3">
                    <div>
                        <small class="text-muted text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">
                            Risiko Sedang
                        </small>
                        <h2 class="fw-bold mb-0 mt-1 text-warning" style="font-size: 1.8rem;">
                            {{ $mediumRisk }}
                        </h2>
                    </div>
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 46px; height: 46px; background-color: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                        <i class="fas fa-circle-half-stroke fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between p-3">
                    <div>
                        <small class="text-muted text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">
                            Risiko Rendah
                        </small>
                        <h2 class="fw-bold mb-0 mt-1 text-success" style="font-size: 1.8rem;">
                            {{ $lowRisk }}
                        </h2>
                    </div>
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 46px; height: 46px; background-color: rgba(16, 185, 129, 0.1); color: #10b981;">
                        <i class="fas fa-shield-heart fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between p-3">
                    <div>
                        <small class="text-muted text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">
                            Berita
                        </small>
                        <h2 class="fw-bold mb-0 mt-1" style="font-size: 1.8rem; color: var(--text-main);">
                            {{ $totalNews }}
                        </h2>
                    </div>
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 46px; height: 46px; background-color: rgba(6, 182, 212, 0.1); color: #06b6d4;">
                        <i class="fas fa-newspaper fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between p-3">
                    <div>
                        <small class="text-muted text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">
                            Pelabuhan
                        </small>
                        <h2 class="fw-bold mb-0 mt-1" style="font-size: 1.8rem; color: var(--text-main);">
                            {{ $totalPorts }}
                        </h2>
                    </div>
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 46px; height: 46px; background-color: rgba(100, 116, 139, 0.1); color: #64748b;">
                        <i class="fas fa-ship fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- MAP + RINGKASAN -->
    <div class="row mb-4">

        <!-- World Risk Map -->
        <div class="col-lg-8">

            <div class="card shadow border-0 h-100">

                <div class="card-header bg-white fw-bold">
                    🌍 World Risk Map
                </div>

                <div class="card-body p-2">

                    <div id="map"
                        style="height:520px;border-radius:12px;">
                    </div>

                </div>

            </div>

        </div>

        <!-- Ringkasan -->
        <div class="col-lg-4">

            @php
                $totalRisk = $highRisk + $mediumRisk + $lowRisk;

                $highPercent = $totalRisk ? ($highRisk / $totalRisk) * 100 : 0;

                $mediumPercent = $totalRisk ? ($mediumRisk / $totalRisk) * 100 : 0;

                $lowPercent = $totalRisk ? ($lowRisk / $totalRisk) * 100 : 0;
            @endphp

            <div class="card shadow border-0">

                <div class="card-header bg-white fw-bold">
                    📊 Ringkasan Risiko
                </div>

                <div class="card-body">

                    <div class="mb-4">

                        <div class="d-flex justify-content-between">

                            <span class="text-danger">
                                🔴 Risiko Tinggi
                            </span>

                            <strong>{{ $highRisk }}</strong>

                        </div>

                        <div class="progress mt-2">

                            <div
                                class="progress-bar bg-danger"
                                style="width:{{ $highPercent }}%">

                                {{ number_format($highPercent,1) }}%

                            </div>

                        </div>

                    </div>

                    <div class="mb-4">

                        <div class="d-flex justify-content-between">

                            <span class="text-warning">
                                🟡 Risiko Sedang
                            </span>

                            <strong>{{ $mediumRisk }}</strong>

                        </div>

                        <div class="progress mt-2">

                            <div
                                class="progress-bar bg-warning text-dark"
                                style="width:{{ $mediumPercent }}%">

                                {{ number_format($mediumPercent,1) }}%

                            </div>

                        </div>

                    </div>

                    <div class="mb-4">

                        <div class="d-flex justify-content-between">

                            <span class="text-success">
                                🟢 Risiko Rendah
                            </span>

                            <strong>{{ $lowRisk }}</strong>

                        </div>

                        <div class="progress mt-2">

                            <div
                                class="progress-bar bg-success"
                                style="width:{{ $lowPercent }}%">

                                {{ number_format($lowPercent,1) }}%

                            </div>

                        </div>

                    </div>

                    <hr>

                    <div class="alert alert-success mb-0">

                        <strong>⭐ Total Negara Dipantau</strong>

                        <span class="float-end fw-bold">

                            {{ $totalWatchlist }}

                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>
    <!-- CHART -->
    <div class="row mb-4">

        <!-- Risk Trend -->
        <div class="col-lg-6">

            <div class="card shadow border-0 h-100">

                <div class="card-header bg-white fw-bold">
                    📈 Risk Trend
                </div>

                <div class="card-body">

                    <canvas id="riskTrendChart" height="150"></canvas>

                </div>

            </div>

        </div>

        <!-- Currency Trend -->
        <div class="col-lg-6">

            <div class="card shadow border-0 h-100">

                <div class="card-header bg-white fw-bold">
                    💱 Currency Trend
                </div>

                <div class="card-body">

                    <canvas id="currencyChart" height="150"></canvas>

                </div>

            </div>

        </div>

    </div>


    <!-- NEWS -->
    <div class="row mb-4">

        <div class="col-12">

            <div class="card shadow border-0">

                <div class="card-header bg-white fw-bold">
                    📰 News Intelligence
                </div>

                <div class="card-body">

                    @forelse($latestNews as $news)

    @if(!empty($news->url))
        <a href="{{ $news->url }}"
           target="_blank"
           class="text-decoration-none text-dark">

            <div class="border-bottom py-3">

                <strong>{{ $news->title }}</strong>

                @if(!empty($news->source))
                    <br>
                    <small class="text-muted">
                        {{ $news->source }}
                    </small>
                @endif

            </div>

        </a>
    @else

        <div class="border-bottom py-3">

            <strong>{{ $news->title }}</strong>

            @if(!empty($news->source))
                <br>
                <small class="text-muted">
                    {{ $news->source }}
                </small>
            @endif

        </div>

    @endif

@empty

    <div class="text-center text-muted py-4">

        Belum ada berita.

    </div>

@endforelse

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    // ===============================
    // WORLD RISK MAP
    // ===============================

    const map = L.map('map').setView([20,0],2);

    L.tileLayer(
        'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        {
            attribution:'&copy; OpenStreetMap contributors'
        }
    ).addTo(map);

    const weatherMap = @json($weatherMap);

    weatherMap.forEach(item=>{

        if(!item.country) return;

        if(!item.country.latitude || !item.country.longitude) return;

        let color='#10b981';

        if(item.storm_risk==='Tinggi'){
            color='#ef4444';
        }else if(item.storm_risk==='Sedang'){
            color='#f59e0b';
        }

        L.circleMarker(
            [
                item.country.latitude,
                item.country.longitude
            ],
            {
                radius:8,
                color:color,
                fillColor:color,
                fillOpacity:.9,
                weight:2
            }
        )
        .addTo(map)
        .bindPopup(`
            <b>${item.country.name}</b><br>
            🌡️ ${item.temperature} °C<br>
            💨 ${item.wind_speed} km/h<br>
            🌧️ ${item.precipitation} mm<br>
            <b>Risiko : ${item.storm_risk}</b>
        `);

    });

    setTimeout(()=>{
        map.invalidateSize();
    },300);

    // ===============================
    // RISK TREND
    // ===============================

    new Chart(
        document.getElementById('riskTrendChart'),
        {
            type:'bar',
            data:{
                labels:@json($riskChartLabels),
                datasets:[{
                    data:@json($riskChartData),
                    backgroundColor:[
                        '#ef4444',
                        '#f59e0b',
                        '#10b981'
                    ]
                }]
            },
            options:{
                responsive:true,
                plugins:{
                    legend:{
                        display:false
                    }
                }
            }
        }
    );

    // ===============================
    // CURRENCY TREND
    // ===============================

    new Chart(
        document.getElementById('currencyChart'),
        {
            type:'line',
            data:{
                labels:@json($currencyLabels),
                datasets:[{
                    label:'Exchange Rate',
                    data:@json($currencyRates),
                    borderColor:'#0f766e',
                    backgroundColor:'rgba(15, 118, 110, 0.1)',
                    fill:true,
                    tension:.4
                }]
            },
            options:{
                responsive:true
            }
        }
    );

});
</script>

@endpush