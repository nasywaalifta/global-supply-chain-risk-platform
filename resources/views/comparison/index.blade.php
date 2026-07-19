@extends('layouts.app')

@section('breadcrumb', 'Perbandingan Negara')

@section('content')

@php
if (!function_exists('formatGDP')) {
    function formatGDP($value) {
        if ($value >= 1e12) {
            return '$' . number_format($value / 1e12, 2) . ' Trillion';
        } elseif ($value >= 1e9) {
            return '$' . number_format($value / 1e9, 2) . ' Billion';
        }
        return '$' . number_format($value);
    }
}
@endphp

<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0" style="color: var(--text-main);">
        <i class="fas fa-balance-scale text-primary me-2"></i>
        Perbandingan Negara
    </h2>
</div>

<div class="row">
    
    <!-- Left Column: Form Pilihan Dropdown (col-lg-4) -->
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm bg-white">
            <div class="card-header py-3">
                <h5 class="fw-bold mb-0" style="color: var(--text-main);"><i class="fas fa-sliders-h text-primary me-2"></i>Parameter</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('comparison.compare') }}" method="POST" class="mb-0">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary mb-2" style="font-size: 0.9rem;">
                            <i class="fas fa-globe text-primary me-1"></i> Negara Pertama
                        </label>
                        <select name="country1_id" class="form-select border shadow-sm rounded-3" style="font-size: 0.95rem; height: 48px;" required>
                            <option value="" disabled selected>-- Pilih Negara --</option>
                            @foreach($countries as $c)
                                <option value="{{ $c->id }}" {{ isset($country1Id) && $country1Id == $c->id ? 'selected' : '' }}>
                                    {{ $c->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- VS indicator -->
                    <div class="text-center py-2">
                        <span class="badge px-3 py-2 rounded-circle fw-bold fs-6" style="background-color: var(--dark-bg) !important; color: var(--secondary-color) !important; border: 1px solid rgba(255, 255, 255, 0.05) !important;">VS</span>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-secondary mb-2" style="font-size: 0.9rem;">
                            <i class="fas fa-globe text-primary me-1"></i> Negara Kedua
                        </label>
                        <select name="country2_id" class="form-select border shadow-sm rounded-3" style="font-size: 0.95rem; height: 48px;" required>
                            <option value="" disabled selected>-- Pilih Negara --</option>
                            @foreach($countries as $c)
                                <option value="{{ $c->id }}" {{ isset($country2Id) && $country2Id == $c->id ? 'selected' : '' }}>
                                    {{ $c->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg shadow rounded-3 fw-bold border-0 text-white d-flex align-items-center justify-content-center"
                                style="font-size: 0.95rem; height: 48px;">
                            <i class="fas fa-balance-scale me-2"></i> Bandingkan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Right Column: Results side-by-side or placeholder (col-lg-8) -->
    <div class="col-lg-8 mb-4">
        @if(!$comparison)
            <!-- Empty / Placeholder State -->
            <div class="card border-0 shadow-sm text-center py-5 bg-white h-100 d-flex flex-column align-items-center justify-content-center" style="min-height: 400px;">
                <div class="card-body py-5 d-flex flex-column align-items-center justify-content-center">
                    <div class="mb-4 text-secondary opacity-30" style="font-size: 4.5rem; color: var(--primary-light) !important;">
                        <i class="fas fa-balance-scale"></i>
                    </div>
                    <p class="text-secondary fw-semibold mb-0 px-3" style="font-size: 1.05rem; max-width: 500px; line-height: 1.5;">
                        Pilih dua negara di panel kiri dan klik "Bandingkan" untuk melihat analisis perbandingan risiko supply chain.
                    </p>
                </div>
            </div>
        @else
            <!-- Comparison Results View -->
            <div class="row animate-fade-in">
                
                <!-- Country 1 Card -->
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm bg-white h-100">
                        <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex align-items-center">
                            <img src="{{ $comparison['c1']['flag_png'] }}" alt="{{ $comparison['c1']['name'] }} flag" class="rounded border shadow-sm me-3" style="width: 50px; height: 32px; object-fit: cover; border-color: var(--border-color) !important;">
                            <div>
                                <h5 class="fw-bold mb-0" style="color: var(--text-main);">{{ $comparison['c1']['name'] }}</h5>
                                <small class="text-secondary fw-semibold">{{ $comparison['c1']['cca3'] }}</small>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            @php
                                $risk1 = $comparison['c1']['risk_level'];
                                $risk1Style = 'background-color: rgba(16, 185, 129, 0.1) !important; color: #047857 !important; border: 1px solid rgba(16, 185, 129, 0.2) !important;';
                                if ($risk1 == 'High' || $risk1 == 'Tinggi') {
                                    $risk1Style = 'background-color: rgba(239, 68, 68, 0.1) !important; color: #dc2626 !important; border: 1px solid rgba(239, 68, 68, 0.2) !important;';
                                } elseif ($risk1 == 'Medium' || $risk1 == 'Sedang') {
                                    $risk1Style = 'background-color: rgba(245, 158, 11, 0.1) !important; color: #b45309 !important; border: 1px solid rgba(245, 158, 11, 0.2) !important;';
                                }
                            @endphp
                            <div class="rounded-3 p-3 mb-4 text-center border" style="{{ $risk1Style }}">
                                <span class="d-block fw-semibold mb-1" style="font-size: 0.8rem; opacity: 0.8;">RISIKO RANTAI PASOK</span>
                                <h4 class="fw-bold mb-0">
                                    {{ $comparison['c1']['risk_score'] }}/100
                                </h4>
                                <small class="fw-bold">
                                    {{ strtoupper($comparison['c1']['risk_level']) }}
                                </small>
                            </div>

                            <div class="list-group list-group-flush">
                                <div class="list-group-item d-flex justify-content-between py-3 bg-transparent">
                                    <span class="text-secondary fw-semibold">PDB (GDP)</span>
                                    <span class="fw-bold" style="color: var(--text-main);">{{ formatGDP($comparison['c1']['gdp']) }}</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between py-3 bg-transparent">
                                    <span class="text-secondary fw-semibold">Tingkat Inflasi</span>
                                    <span class="fw-bold" style="color: var(--text-main);">{{ $comparison['c1']['inflation'] }}%</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between py-3 bg-transparent">
                                    <span class="text-secondary fw-semibold">Suhu Udara</span>
                                    <span class="fw-bold text-primary">{{ $comparison['c1']['temp'] }}°C</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between py-3 bg-transparent">
                                    <span class="text-secondary fw-semibold">Mata Uang</span>
                                    <span class="fw-bold text-info">{{ $comparison['c1']['currency_code'] }}</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between py-3 bg-transparent border-0">
                                    <span class="text-secondary fw-semibold">Nilai Tukar (vs USD)</span>
                                    <span class="fw-bold" style="color: var(--text-main);">{{ number_format($comparison['c1']['currency_rate'], 4) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Country 2 Card -->
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm bg-white h-100">
                        <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex align-items-center">
                            <img src="{{ $comparison['c2']['flag_png'] }}" alt="{{ $comparison['c2']['name'] }} flag" class="rounded border shadow-sm me-3" style="width: 50px; height: 32px; object-fit: cover; border-color: var(--border-color) !important;">
                            <div>
                                <h5 class="fw-bold mb-0" style="color: var(--text-main);">{{ $comparison['c2']['name'] }}</h5>
                                <small class="text-secondary fw-semibold">{{ $comparison['c2']['cca3'] }}</small>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            @php
                                $risk2 = $comparison['c2']['risk_level'];
                                $risk2Style = 'background-color: rgba(16, 185, 129, 0.1) !important; color: #047857 !important; border: 1px solid rgba(16, 185, 129, 0.2) !important;';
                                if ($risk2 == 'High' || $risk2 == 'Tinggi') {
                                    $risk2Style = 'background-color: rgba(239, 68, 68, 0.1) !important; color: #dc2626 !important; border: 1px solid rgba(239, 68, 68, 0.2) !important;';
                                } elseif ($risk2 == 'Medium' || $risk2 == 'Sedang') {
                                    $risk2Style = 'background-color: rgba(245, 158, 11, 0.1) !important; color: #b45309 !important; border: 1px solid rgba(245, 158, 11, 0.2) !important;';
                                }
                            @endphp
                            <div class="rounded-3 p-3 mb-4 text-center border" style="{{ $risk2Style }}">
                                <span class="d-block fw-semibold mb-1" style="font-size: 0.8rem; opacity: 0.8;">RISIKO RANTAI PASOK</span>
                                <h4 class="fw-bold mb-0">
                                    {{ $comparison['c2']['risk_score'] }}/100
                                </h4>
                                <small class="fw-bold">
                                    {{ strtoupper($comparison['c2']['risk_level']) }}
                                </small>
                            </div>

                            <div class="list-group list-group-flush">
                                <div class="list-group-item d-flex justify-content-between py-3 bg-transparent">
                                    <span class="text-secondary fw-semibold">PDB (GDP)</span>
                                    <span class="fw-bold" style="color: var(--text-main);">{{ formatGDP($comparison['c2']['gdp']) }}</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between py-3 bg-transparent">
                                    <span class="text-secondary fw-semibold">Tingkat Inflasi</span>
                                    <span class="fw-bold" style="color: var(--text-main);">{{ $comparison['c2']['inflation'] }}%</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between py-3 bg-transparent">
                                    <span class="text-secondary fw-semibold">Suhu Udara</span>
                                    <span class="fw-bold text-primary">{{ $comparison['c2']['temp'] }}°C</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between py-3 bg-transparent">
                                    <span class="text-secondary fw-semibold">Mata Uang</span>
                                    <span class="fw-bold text-info">{{ $comparison['c2']['currency_code'] }}</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between py-3 bg-transparent border-0">
                                    <span class="text-secondary fw-semibold">Nilai Tukar (vs USD)</span>
                                    <span class="fw-bold" style="color: var(--text-main);">{{ number_format($comparison['c2']['currency_rate'], 4) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Chart / Visual comparison block -->
            <div class="card border-0 shadow-sm bg-white mb-4">
                <div class="card-header border-bottom">
                    <h5 class="fw-bold mb-0" style="color: var(--text-main);">Analisis Visual Risiko</h5>
                </div>
                <div class="card-body p-4" style="height: 320px;">
                    <canvas id="riskCompareChart"></canvas>
                </div>
            </div>
        @endif
    </div>

</div>

@endsection

@push('scripts')
@if(isset($comparison))
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById('riskCompareChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Total Risiko', 'Suhu Udara (°C)', 'Tingkat Inflasi (%)'],
            datasets: [
                {
                    label: '{{ $comparison['c1']['name'] }}',
                    data: [{{ $comparison['c1']['risk_score'] }}, {{ $comparison['c1']['temp'] }}, {{ $comparison['c1']['inflation'] }}],
                    backgroundColor: 'rgba(14, 116, 144, 0.85)',
                    borderColor: '#0e7490',
                    borderWidth: 1.5,
                    borderRadius: 4
                },
                {
                    label: '{{ $comparison['c2']['name'] }}',
                    data: [{{ $comparison['c2']['risk_score'] }}, {{ $comparison['c2']['temp'] }}, {{ $comparison['c2']['inflation'] }}],
                    backgroundColor: 'rgba(245, 158, 11, 0.85)',
                    borderColor: '#d97706',
                    borderWidth: 1.5,
                    borderRadius: 4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: {
                        color: '#64748b',
                        font: {
                            family: 'var(--font-main)'
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        color: 'rgba(226, 232, 240, 0.5)'
                    },
                    ticks: {
                        color: '#64748b'
                    }
                },
                y: {
                    beginAtZero: true,
                    max: 100,
                    grid: {
                        color: 'rgba(226, 232, 240, 0.5)'
                    },
                    ticks: {
                        color: '#64748b'
                    }
                }
            }
        }
    });
});
</script>
@endif
@endpush

