@extends('layouts.app')

@section('breadcrumb', 'Detail Negara')

@section('content')

<!-- Back Link -->
<div class="mb-4">
    <a href="{{ route('countries.index') }}" class="btn btn-secondary shadow-sm">
        <i class="fas fa-arrow-left me-2"></i> Kembali ke Analisis Negara
    </a>
</div>

<!-- Header Negara -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body d-flex align-items-center p-4">
        <img
            src="https://flagcdn.com/w160/{{ strtolower(trim($country->cca2)) }}.png"
            alt="{{ $country->name }}"
            width="90"
            class="rounded shadow-sm me-4 border"
            style="border-color: var(--border-color) !important;"
            onerror="this.src='https://placehold.co/160x120?text=No+Flag'">
        <div>
            <h2 class="fw-bold mb-1" style="color: var(--text-main);">
                {{ $country->name }}
            </h2>
            <div class="text-muted" style="font-size: 0.95rem;">
                {{ $country->official_name ?? $country->name }}
            </div>
            <div class="mt-2 d-flex gap-2">
                <span class="badge rounded-3 px-3 py-1.5 fw-bold" style="background-color: rgba(14, 116, 144, 0.1) !important; color: var(--primary-color) !important;">
                    ISO 2: {{ $country->cca2 }}
                </span>
                <span class="badge rounded-3 px-3 py-1.5 fw-bold" style="background-color: rgba(6, 182, 212, 0.1) !important; color: var(--primary-light) !important;">
                    ISO 3: {{ $country->cca3 }}
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Informasi Negara -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header py-3">
        <h5 class="mb-0 fw-bold">
            <i class="fas fa-globe-asia me-2 text-primary"></i>
            Informasi Negara
        </h5>
    </div>
    <div class="card-body">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="border rounded-4 p-3 h-100" style="background-color: #f8fafc; border-color: rgba(226, 232, 240, 0.8) !important;">
                    <small class="text-muted d-block mb-1">Nama Resmi</small>
                    <h6 class="fw-bold mb-0" style="color: var(--text-main);">
                        {{ $country->official_name ?? $country->name }}
                    </h6>
                </div>
            </div>

            <div class="col-md-3">
                <div class="border rounded-4 p-3 h-100" style="background-color: #f8fafc; border-color: rgba(226, 232, 240, 0.8) !important;">
                    <small class="text-muted d-block mb-1">Kode ISO2</small>
                    <h6 class="fw-bold mb-0" style="color: var(--text-main);">
                        {{ $country->cca2 }}
                    </h6>
                </div>
            </div>

            <div class="col-md-3">
                <div class="border rounded-4 p-3 h-100" style="background-color: #f8fafc; border-color: rgba(226, 232, 240, 0.8) !important;">
                    <small class="text-muted d-block mb-1">Kode ISO3</small>
                    <h6 class="fw-bold mb-0" style="color: var(--text-main);">
                        {{ $country->cca3 }}
                    </h6>
                </div>
            </div>

            <div class="col-md-6">
                <div class="border rounded-4 p-3 h-100" style="background-color: #f8fafc; border-color: rgba(226, 232, 240, 0.8) !important;">
                    <small class="text-muted d-block mb-1">Region</small>
                    <h6 class="fw-bold mb-0" style="color: var(--text-main);">
                        {{ $country->region }}
                    </h6>
                </div>
            </div>

            <div class="col-md-6">
                <div class="border rounded-4 p-3 h-100" style="background-color: #f8fafc; border-color: rgba(226, 232, 240, 0.8) !important;">
                    <small class="text-muted d-block mb-1">Sub Region</small>
                    <h6 class="fw-bold mb-0" style="color: var(--text-main);">
                        {{ $country->subregion ?? '-' }}
                    </h6>
                </div>
            </div>

            <div class="col-md-6">
                <div class="border rounded-4 p-3 h-100" style="background-color: #f8fafc; border-color: rgba(226, 232, 240, 0.8) !important;">
                    <small class="text-muted d-block mb-1">Ibu Kota</small>
                    <h6 class="fw-bold mb-0" style="color: var(--text-main);">
                        {{ $country->capital ?? '-' }}
                    </h6>
                </div>
            </div>

            <div class="col-md-6">
                <div class="border rounded-4 p-3 h-100" style="background-color: #f8fafc; border-color: rgba(226, 232, 240, 0.8) !important;">
                    <small class="text-muted d-block mb-1">Jumlah Penduduk</small>
                    <h6 class="fw-bold mb-0" style="color: var(--text-main);">
                        {{ number_format($country->population,0,',','.') }}
                    </h6>
                </div>
            </div>

            <div class="col-md-6">
                <div class="border rounded-4 p-3 h-100" style="background-color: #f8fafc; border-color: rgba(226, 232, 240, 0.8) !important;">
                    <small class="text-muted d-block mb-1">Luas Wilayah</small>
                    <h6 class="fw-bold mb-0" style="color: var(--text-main);">
                        {{ number_format($country->area,2,',','.') }} km²
                    </h6>
                </div>
            </div>

            <div class="col-md-6">
                <div class="border rounded-4 p-3 h-100" style="background-color: #f8fafc; border-color: rgba(226, 232, 240, 0.8) !important;">
                    <small class="text-muted d-block mb-1">Mata Uang</small>
                    <h6 class="fw-bold mb-0" style="color: var(--text-main);">
                        {{ $country->currency_name }} ({{ $country->currency_code }} {{ $country->currency_symbol }})
                    </h6>
                </div>
            </div>

            <div class="col-md-6">
    <div class="border rounded-4 p-3 h-100" style="background-color:#f8fafc; border-color:rgba(226,232,240,.8)!important;">
        <small class="text-muted d-block mb-1">GDP</small>
        <h6 class="fw-bold mb-0" style="color: var(--text-main);">
            {{ $country->gdp ? '$' . number_format($country->gdp, 2) : '-' }}
        </h6>
    </div>
</div>

            <div class="col-md-6">
                <div class="border rounded-4 p-3 h-100" style="background-color:#f8fafc; border-color:rgba(226,232,240,.8)!important;">
                    <small class="text-muted d-block mb-1">Inflasi</small>
                    <h6 class="fw-bold mb-0" style="color: var(--text-main);">
                        {{ $country->inflation ? $country->inflation.'%' : '-' }}
                    </h6>
                </div>
            </div>

            <div class="col-md-12">
                <div class="border rounded-4 p-3 d-flex justify-content-between align-items-center" style="background-color: #f8fafc; border-color: rgba(226, 232, 240, 0.8) !important;">
                    <div>
                        <small class="text-muted d-block mb-1">Total Pelabuhan</small>
                        <h5 class="fw-bold mb-0" style="color: var(--text-main);">
                            {{ $totalPorts }}
                        </h5>
                    </div>
                    <span class="badge px-3 py-2 rounded-3 fw-bold" style="background-color: rgba(14, 116, 144, 0.1) !important; color: var(--primary-color) !important;">
                        {{ $totalPorts }} Pelabuhan terdaftar
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Monitoring Cuaca -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-header py-3">
        <h5 class="mb-0 fw-bold">
            <i class="fas fa-cloud-sun me-2 text-primary"></i>
            Monitoring Cuaca
        </h5>
    </div>
    <div class="card-body">
        <div class="row g-4">
            <div class="col-md-3">
                <div class="border rounded-4 p-3 h-100" style="background-color: #f8fafc; border-color: rgba(226, 232, 240, 0.8) !important;">
                    <small class="text-muted d-block mb-1">Suhu</small>
                    <h5 class="fw-bold mb-0" style="color: var(--text-main);">
                        {{ optional($country->weather)->temperature ?? '-' }} °C
                    </h5>
                </div>
            </div>

            <div class="col-md-3">
                <div class="border rounded-4 p-3 h-100" style="background-color: #f8fafc; border-color: rgba(226, 232, 240, 0.8) !important;">
                    <small class="text-muted d-block mb-1">Curah Hujan</small>
                    <h5 class="fw-bold mb-0" style="color: var(--text-main);">
                        {{ optional($country->weather)->precipitation ?? '-' }} mm
                    </h5>
                </div>
            </div>

            <div class="col-md-3">
                <div class="border rounded-4 p-3 h-100" style="background-color: #f8fafc; border-color: rgba(226, 232, 240, 0.8) !important;">
                    <small class="text-muted d-block mb-1">Kecepatan Angin</small>
                    <h5 class="fw-bold mb-0" style="color: var(--text-main);">
                        {{ optional($country->weather)->wind_speed ?? '-' }} km/jam
                    </h5>
                </div>
            </div>

            <div class="col-md-3">
                <div class="border rounded-4 p-3 h-100" style="background-color: #f8fafc; border-color: rgba(226, 232, 240, 0.8) !important;">
                    <small class="text-muted d-block mb-1">Risiko Badai</small>
                    <h5 class="fw-bold mb-0">
                        @php
                            $storm = optional($country->weather)->storm_risk;
                        @endphp

                        @if($storm == 'Tinggi')
                            <span class="badge px-3 py-2 rounded-3 fw-bold" style="background-color: rgba(239, 68, 68, 0.1) !important; color: #dc2626 !important; border: 1px solid rgba(239, 68, 68, 0.2) !important;">TINGGI</span>
                        @elseif($storm == 'Sedang')
                            <span class="badge px-3 py-2 rounded-3 fw-bold" style="background-color: rgba(245, 158, 11, 0.1) !important; color: #b45309 !important; border: 1px solid rgba(245, 158, 11, 0.2) !important;">SEDANG</span>
                        @elseif($storm == 'Rendah')
                            <span class="badge px-3 py-2 rounded-3 fw-bold" style="background-color: rgba(16, 185, 129, 0.1) !important; color: #047857 !important; border: 1px solid rgba(16, 185, 129, 0.2) !important;">RENDAH</span>
                        @else
                            <span class="badge bg-secondary">-</span>
                        @endif
                    </h5>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection