@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                <i class="fas fa-chart-area text-primary me-2"></i>

                Visualisasi Data

            </h2>

            <p class="text-muted mb-0">

                Analisis visual data ekonomi dan risiko berbagai negara.

            </p>

        </div>
        
    </div>

    <!-- Filter -->

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <div class="row">

                <div class="col-md-6">

                    <label class="form-label fw-semibold">

                        Negara

                    </label>

                    <select id="countrySelect" class="form-select">

                        @foreach($countries as $country)

                            <option value="{{ $country->name }}">
                                {{ $country->name }}
                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-md-6">

                    <label class="form-label fw-semibold">

                        Jenis Grafik

                    </label>

                    <select class="form-select">

                        <option>Semua Grafik</option>
                        <option>GDP</option>
                        <option>Inflasi</option>
                        <option>Nilai Tukar</option>
                        <option>Risiko</option>

                    </select>

                </div>

            </div>

        </div>

    </div>
    <!-- ========================= -->
    <!-- BARIS 1 -->
    <!-- ========================= -->

    <div class="row g-4 mb-4">

        <!-- Grafik GDP -->
        <div class="col-lg-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header d-flex justify-content-between align-items-center">

                    <h5 class="fw-bold mb-0">

                        <i class="fas fa-chart-line text-primary me-2"></i>

                        Grafik GDP

                    </h5>

                    <span class="badge" style="background-color: rgba(14, 116, 144, 0.1) !important; color: var(--primary-color) !important;">

                        Line

                    </span>

                </div>

                <div class="card-body">

                    <canvas
                        id="gdpChart"
                        height="260">

                    </canvas>

                </div>

            </div>

        </div>

        <!-- Grafik Inflasi -->
        <div class="col-lg-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header d-flex justify-content-between align-items-center">

                    <h5 class="fw-bold mb-0">

                        <i class="fas fa-percent text-warning me-2"></i>

                        Grafik Inflasi

                    </h5>

                    <span class="badge" style="background-color: rgba(245, 158, 11, 0.1) !important; color: #b45309 !important; border: 1px solid rgba(245, 158, 11, 0.2) !important;">

                        Bar

                    </span>

                </div>

                <div class="card-body">

                    <canvas
                        id="inflationChart"
                        height="260">

                    </canvas>

                </div>

            </div>

        </div>

    </div>

    <!-- ========================= -->
    <!-- BARIS 2 -->
    <!-- ========================= -->

    <div class="row g-4 mb-4">

        <!-- Grafik Nilai Tukar -->
        <div class="col-lg-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header d-flex justify-content-between align-items-center">

                    <h5 class="fw-bold mb-0">

                        <i class="fas fa-coins text-success me-2"></i>

                        Grafik Nilai Tukar

                    </h5>

                    <span class="badge" style="background-color: rgba(16, 185, 129, 0.1) !important; color: #047857 !important; border: 1px solid rgba(16, 185, 129, 0.2) !important;">

                        Area

                    </span>

                </div>

                <div class="card-body">

                    <canvas
                        id="exchangeChart"
                        height="260">

                    </canvas>

                </div>

            </div>

        </div>

        <!-- Grafik Risiko -->
        <div class="col-lg-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header d-flex justify-content-between align-items-center">

                    <h5 class="fw-bold mb-0">

                        <i class="fas fa-shield-halved text-danger me-2"></i>

                        Radar Risiko

                    </h5>

                    <span class="badge" style="background-color: rgba(239, 68, 68, 0.1) !important; color: #dc2626 !important; border: 1px solid rgba(239, 68, 68, 0.2) !important;">

                        Radar

                    </span>

                </div>

                <div class="card-body">

                    <canvas
                        id="riskChart"
                        height="260">

                    </canvas>

                </div>

            </div>

        </div>

    </div>
    <!-- Ringkasan -->

<div class="card border-0 shadow-sm">

    <div class="card-header">

        <h5 class="fw-bold mb-0">

            <i class="fas fa-circle-info text-primary me-2"></i>

            Ringkasan Negara

        </h5>

    </div>

    <div class="card-body">

        <div class="row text-center">

            <div class="col-md-3">
                <h6 class="text-muted mb-1" style="font-size: 0.85rem;">GDP</h6>
                <h4 class="fw-bold text-primary mb-0" id="summaryGDP">-</h4>
            </div>

            <div class="col-md-3">
                <h6 class="text-muted mb-1" style="font-size: 0.85rem;">Inflasi</h6>
                <h4 class="fw-bold text-warning mb-0" id="summaryInflation">-</h4>
            </div>

            <div class="col-md-3">
                <h6 class="text-muted mb-1" style="font-size: 0.85rem;">Nilai Tukar</h6>
                <h4 class="fw-bold text-success mb-0" id="summaryExchange">-</h4>
            </div>

            <div class="col-md-3">
                <h6 class="text-muted mb-1" style="font-size: 0.85rem;">Skor Risiko</h6>
                <h4 class="fw-bold text-danger mb-0" id="summaryRisk">-</h4>
            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const gdpChart = new Chart(document.getElementById('gdpChart'), {
    type: 'line',
    data: {
        labels: [],
        datasets: [{
            label: 'GDP',
            data: [],
            borderColor: '#0e7490',
            backgroundColor: 'rgba(14, 116, 144, 0.1)',
            fill: true,
            tension: .4
        }]
    }
});

const inflationChart = new Chart(document.getElementById('inflationChart'), {
    type: 'bar',
    data: {
        labels: [],
        datasets: [{
            label: 'Inflasi',
            data: [],
            backgroundColor: '#d97706'
        }]
    }
});

const exchangeChart = new Chart(document.getElementById('exchangeChart'), {
    type: 'line',
    data: {
        labels: ['USD'],
        datasets: [{
            label: 'Nilai Tukar',
            data: [],
            borderColor: '#10b981',
            backgroundColor: 'rgba(16, 185, 129, 0.1)',
            fill: true,
            tension: .4
        }]
    }
});

const riskChart = new Chart(document.getElementById('riskChart'), {
    type: 'radar',
    data: {
        labels: [
            'Cuaca',
            'Inflasi',
            'Mata Uang',
            'Berita'
        ],
        datasets: [{
            label: 'Risk Score',
            data: [],
            borderColor: '#e11d48',
            backgroundColor: 'rgba(225, 29, 72, 0.15)'
        }]
    },

    options:{
    scales:{
        r:{
            min:0,
            max:100,
            ticks:{
                stepSize:20
            }
        }
    }
}
});

const countrySelect = document.getElementById('countrySelect');

async function loadCountry(country) {

    const response = await fetch('/visualisasi/data/' + encodeURIComponent(country));

    const result = await response.json();

    console.log(result);

    if (!result.success) {
        return;
    }

    // =========================
    // GDP
    // =========================

    let gdpLabels = [];
    let gdpValues = [];

    if (Array.isArray(result.gdp) && result.gdp.length > 1) {

        result.gdp[1]
            .filter(item => item.value !== null)
            .reverse()
            .forEach(item => {

                gdpLabels.push(item.date);
                gdpValues.push(item.value);

            });
    }

    gdpChart.data.labels = gdpLabels;
    gdpChart.data.datasets[0].data = gdpValues;
    gdpChart.update();

    // =========================
    // Inflasi
    // =========================

    let inflationLabels = [];
    let inflationValues = [];

    inflationLabels.push('Inflasi');
    inflationValues.push(result.inflation);


    inflationChart.data.labels = inflationLabels;
    inflationChart.data.datasets[0].data = inflationValues;
    inflationChart.update();

    // =========================
    // Exchange Rate
    // =========================

    let currencyCode = result.country.currency_code;

    let exchange = result.exchange[currencyCode];

    exchangeChart.data.labels = [currencyCode];
    exchangeChart.data.datasets[0].data = [exchange ?? 0];
    exchangeChart.update();

    // =========================
    // Risk Radar
    // =========================

    if (result.risk) {

        riskChart.data.datasets[0].data = [

            result.risk.weather_score,
            result.risk.inflation_score,
            result.risk.currency_score,
            result.risk.news_score

        ];

    } else {

        riskChart.data.datasets[0].data = [0,0,0,0];

    }

    riskChart.update();

    // =========================
    // Summary
    // =========================

    const lastGDP = gdpValues.length ? Number(gdpValues.at(-1)) : null;

    document.getElementById('summaryGDP').innerHTML =
        lastGDP
            ? (lastGDP / 1_000_000_000).toFixed(2) + ' Billion USD'
            : '-';

    const lastInflation = inflationValues.length
        ? Number(inflationValues.at(-1))
        : null;

    document.getElementById('summaryInflation').innerHTML =
        lastInflation !== null
            ? lastInflation.toFixed(2) + '%'
            : '-';

    document.getElementById('summaryExchange').innerHTML =
        exchange
            ? Number(exchange).toFixed(2) + ' ' + currencyCode
            : '-';

    if(result.risk){

        let score = Number(result.risk.total_score);

        let level = result.risk.risk_level;

        let color = '#16a34a';

        if(level === 'Medium'){
            color = '#f59e0b';
        }

        if(level === 'High'){
            color = '#dc2626';
        }

        document.getElementById('summaryRisk').innerHTML =
            `<span style="color:${color}">
                ${score.toFixed(0)} (${level})
            </span>`;

    }else{

        document.getElementById('summaryRisk').innerHTML='-';

    }

}

countrySelect.addEventListener('change', function () {

    loadCountry(this.value);

});

loadCountry(countrySelect.value);

</script>

@endsection