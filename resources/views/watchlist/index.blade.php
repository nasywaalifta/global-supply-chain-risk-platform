@extends('layouts.app')

@section('breadcrumb', 'Daftar Pantau')

@section('content')

<!-- Alert success / error -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4 p-3" role="alert" style="background-color: #ccfbf1; color: #0f766e; border: 1px solid rgba(15, 118, 110, 0.15) !important;">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4 p-3" role="alert" style="background-color: #fee2e2; color: #991b1b; border: 1px solid rgba(220, 38, 38, 0.15) !important;">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0" style="color: var(--text-main);">
        <i class="fas fa-star text-warning me-2"></i>
        Daftar Pantau Negara
    </h2>
</div>

<!-- Grid / Columns Layout -->
<div class="row">
    
    <!-- Left Column: Watchlist Grid (col-lg-8) -->
    <div class="col-lg-8 mb-4">
        <div class="row">
            @forelse($watchlist as $item)
                @php
                    $riskCustomStyle = 'background-color: #f1f5f9; color: #475569;';
                    $barColor = '#10b981';
                    if (strtoupper($item->risk_level) === 'TINGGI') {
                        $riskCustomStyle = 'background-color: rgba(239, 68, 68, 0.1) !important; color: #dc2626 !important; border: 1px solid rgba(239, 68, 68, 0.2) !important;';
                        $barColor = '#ef4444';
                    } elseif (strtoupper($item->risk_level) === 'SEDANG') {
                        $riskCustomStyle = 'background-color: rgba(245, 158, 11, 0.1) !important; color: #b45309 !important; border: 1px solid rgba(245, 158, 11, 0.2) !important;';
                        $barColor = '#f59e0b';
                    } elseif (strtoupper($item->risk_level) === 'RENDAH') {
                        $riskCustomStyle = 'background-color: rgba(16, 185, 129, 0.1) !important; color: #047857 !important; border: 1px solid rgba(16, 185, 129, 0.2) !important;';
                        $barColor = '#10b981';
                    }
                @endphp
                <div class="col-md-6 mb-4">
                    <div class="card h-100 overflow-hidden bg-white">
                        <div class="card-body p-4 d-flex flex-column justify-content-between">
                            <div>
                                <!-- Header: Flag, Name, Region, Risk Level Badge -->
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $item->flag_png }}" alt="{{ $item->name }} flag" class="rounded border shadow-sm me-3" style="width: 50px; height: 32px; object-fit: cover; border-color: var(--border-color) !important;">
                                        <div>
                                            <h5 class="fw-bold mb-0" style="font-size: 1.05rem; color: var(--text-main);">{{ $item->name }}</h5>
                                            <small class="text-secondary fw-semibold" style="font-size: 0.78rem;">
                                                {{ $item->cca2 }} • {{ $item->region }}
                                            </small>
                                        </div>
                                    </div>
                                    <span class="badge px-3 py-2 rounded-3 fw-bold" style="{{ $riskCustomStyle }} font-size: 0.72rem; letter-spacing: 0.5px;">
                                        {{ $item->risk_level }}
                                    </span>
                                </div>

                                <!-- Risk Score and Progress Bar -->
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="text-secondary fw-semibold" style="font-size: 0.8rem;">Skor Risiko Rantai Pasok</span>
                                        <span class="fw-bold" style="font-size: 0.95rem; color: var(--text-main);">{{ $item->risk_score }}/100</span>
                                    </div>
                                    <div class="progress rounded-pill" style="height: 8px; background-color: #e2e8f0;">
                                        <div class="progress-bar rounded-pill" role="progressbar" style="width: {{ $item->risk_score }}%; background-color: {{ $barColor }} !important;" aria-valuenow="{{ $item->risk_score }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>

                                <!-- Parameter Indicators: CUACA, INFLASI, VALUTA -->
                                <div class="row text-center bg-light rounded-3 py-2 px-1 mb-4 border g-0 align-items-center" style="background-color: #f8fafc !important; border-color: var(--border-color) !important;">
                                    <div class="col-4 border-end" style="border-color: var(--border-color) !important;">
                                        <small class="text-muted d-block fw-bold mb-1" style="font-size: 0.65rem; letter-spacing: 0.5px;">CUACA</small>
                                        <span class="fw-bold text-primary" style="font-size: 0.9rem;">
                                            {{ $item->temp }}°C
                                        </span>
                                    </div>
                                    <div class="col-4 border-end" style="border-color: var(--border-color) !important;">
                                        <small class="text-muted d-block fw-bold mb-1" style="font-size: 0.65rem; letter-spacing: 0.5px;">INFLASI</small>
                                        <span class="fw-bold text-warning" style="font-size: 0.9rem;">
                                            {{ $item->inflation }}%
                                        </span>
                                    </div>
                                    <div class="col-4">
                                        <small class="text-muted d-block fw-bold mb-1" style="font-size: 0.65rem; letter-spacing: 0.5px;">VALUTA</small>
                                        <span class="fw-bold text-info" style="font-size: 0.9rem; color: #06b6d4 !important;">
                                            {{ $item->currency }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Footer -->
                            <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top" style="border-color: var(--border-color) !important;">
                                <a href="{{ route('countries.show', $item->country_id) }}" class="btn btn-outline-primary px-3 fw-bold rounded-3 btn-sm d-flex align-items-center shadow-sm">
                                    <i class="fas fa-chart-line me-2"></i>Dashboard
                                </a>
                                <form action="{{ route('watchlist.destroy', $item->watchlist_id) }}" method="POST" class="mb-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm px-3 rounded-3" title="Hapus dari daftar pantau" onclick="return confirm('Apakah Anda yakin ingin menghapus {{ $item->name }} dari daftar pantau?')">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card border-0 shadow rounded-4 text-center py-5 bg-white">
                        <div class="card-body">
                            <i class="fas fa-star fa-3x text-muted opacity-30 mb-3"></i>
                            <h5 class="fw-bold text-secondary">Belum ada negara yang dipantau</h5>
                            <p class="text-muted">Pilih negara dari panel di sebelah kanan untuk mulai memantau.</p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Right Column: Form Tambah & Ringkasan (col-lg-4) -->
    <div class="col-lg-4 mb-4">
        
        <!-- Add Country Card -->
        <div class="card border-0 shadow rounded-4 mb-4 bg-white">
            <div class="card-header bg-transparent pt-4 px-4 border-0">
                <h5 class="fw-bold mb-0" style="color: var(--text-main);"><i class="fas fa-plus-circle text-primary me-2"></i>Tambah Negara</h5>
            </div>
            <div class="card-body p-4">
                <p class="text-secondary fw-semibold mb-3" style="font-size: 0.9rem;">
                    Pilih negara untuk dipantau secara berkala dan dianalisis tingkat risikonya.
                </p>
                <form action="{{ route('watchlist.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <select name="country_id" class="form-select border shadow-sm rounded-3" style="font-size: 0.95rem; height: 48px;" required>
                            <option value="" disabled selected>-- Pilih Negara --</option>
                            @foreach($availableCountries as $c)
                                <option value="{{ $c->id }}">[{{ $c->cca2 }}] {{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg shadow-sm rounded-3 fw-bold" style="font-size: 0.95rem; height: 48px;">
                            <i class="fas fa-plus me-1"></i> Tambahkan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Summary Stats Card -->
        <div class="card border-0 shadow rounded-4 bg-white">
            <div class="card-header bg-transparent pt-4 px-4 border-0">
                <h5 class="fw-bold mb-0" style="color: var(--text-main);"><i class="fas fa-chart-pie text-primary me-2" style="color: var(--primary-color) !important;"></i>Statistik Pantau</h5>
            </div>
            <div class="card-body p-4">
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center py-3 bg-transparent">
                        <span class="text-secondary fw-semibold">Negara Dipantau</span>
                        <span class="badge rounded-pill px-3 py-1.5 fw-bold" style="background-color: var(--primary-color) !important; color: #ffffff !important;">{{ count($watchlist) }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center py-3 bg-transparent border-0">
                        <span class="text-secondary fw-semibold">Kategori Risiko</span>
                        <span class="text-dark fw-bold" style="color: var(--text-main) !important;">
                            @php
                                $risks = collect($watchlist)->pluck('risk_level')->countBy();
                                $high = $risks->get('TINGGI', 0);
                                $medium = $risks->get('SEDANG', 0);
                                $low = $risks->get('RENDAH', 0);
                            @endphp
                            🔴{{ $high }} &nbsp; 🟡{{ $medium }} &nbsp; 🟢{{ $low }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
