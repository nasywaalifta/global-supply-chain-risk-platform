@extends('layouts.app')

@section('breadcrumb', 'Skor Risiko')

@section('content')

<div class="container-fluid">

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4 p-3" role="alert" style="background-color: #ccfbf1; color: #0f766e; border: 1px solid rgba(15, 118, 110, 0.15) !important;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4 p-3" role="alert" style="background-color: #fee2e2; color: #991b1b; border: 1px solid rgba(220, 38, 38, 0.15) !important;">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: var(--text-main);">Risk Score Analysis</h2>
            <p class="text-muted mb-0">
                Analisis tingkat risiko supply chain global berdasarkan parameter cuaca, inflasi, valuta, dan sentimen berita.
            </p>
        </div>

        <form action="{{ route('risk-score.update') }}" method="POST" class="mb-0">
            @csrf
            <button type="submit" class="btn btn-primary d-flex align-items-center" style="height:48px;">
                <i class="fas fa-calculator me-2"></i> Hitung Ulang Risk Score
            </button>
        </form>
    </div>

    {{-- Statistik --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between p-3">
                    <div>
                        <small class="text-muted text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">Risiko Tinggi</small>
                        <h2 class="text-danger fw-bold mb-0 mt-1" style="font-size: 1.8rem;">{{ $high }}</h2>
                    </div>
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background-color: rgba(239, 68, 68, 0.1); color: #ef4444;">
                        <i class="fas fa-triangle-exclamation fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between p-3">
                    <div>
                        <small class="text-muted text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">Risiko Sedang</small>
                        <h2 class="text-warning fw-bold mb-0 mt-1" style="font-size: 1.8rem;">{{ $medium }}</h2>
                    </div>
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background-color: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                        <i class="fas fa-circle-half-stroke fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between p-3">
                    <div>
                        <small class="text-muted text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">Risiko Rendah</small>
                        <h2 class="text-success fw-bold mb-0 mt-1" style="font-size: 1.8rem;">{{ $low }}</h2>
                    </div>
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background-color: rgba(16, 185, 129, 0.1); color: #10b981;">
                        <i class="fas fa-shield-heart fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header">
            <form method="GET" class="mb-0">
                <div class="row g-2">
                    <div class="col-md-4">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            class="form-control"
                            placeholder="Cari negara..."
                            style="height: 48px;"
                        >
                    </div>
                    <div class="col-md-2 d-grid">
                        <button class="btn btn-primary" style="height: 48px;">
                            <i class="fas fa-search me-1"></i> Cari
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Negara</th>
                        <th>Weather Score</th>
                        <th>Currency Score</th>
                        <th>News Score</th>
                        <th>Total Score</th>
                        <th>Risk Level</th>
                        <th>Tanggal Analisis</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($riskScores as $risk)
                    <tr>
                        <td>
                            <strong>{{ $risk->country->name ?? '-' }}</strong>
                        </td>
                        <td>
                            {{ number_format($risk->weather_score,2) }}
                        </td>
                        <td>
                            {{ number_format($risk->currency_score,2) }}
                        </td>
                        <td>
                            {{ number_format($risk->news_score,2) }}
                        </td>
                        <td>
                            <strong style="color: var(--text-main);">{{ number_format($risk->total_score,2) }}</strong>
                        </td>
                        <td>
                            @php
                                $riskCustomStyle = 'background-color: #f1f5f9; color: #475569;';
                                if ($risk->risk_level == 'High') {
                                    $riskCustomStyle = 'background-color: rgba(239, 68, 68, 0.1) !important; color: #dc2626 !important; border: 1px solid rgba(239, 68, 68, 0.2) !important;';
                                } elseif ($risk->risk_level == 'Medium') {
                                    $riskCustomStyle = 'background-color: rgba(245, 158, 11, 0.1) !important; color: #b45309 !important; border: 1px solid rgba(245, 158, 11, 0.2) !important;';
                                } else {
                                    $riskCustomStyle = 'background-color: rgba(16, 185, 129, 0.1) !important; color: #047857 !important; border: 1px solid rgba(16, 185, 129, 0.2) !important;';
                                }
                            @endphp
                            <span class="badge px-3 py-2 rounded-3 fw-bold" style="{{ $riskCustomStyle }} font-size: 0.72rem; letter-spacing: 0.5px;">
                                {{ $risk->risk_level == 'High' ? 'TINGGI' : ($risk->risk_level == 'Medium' ? 'SEDANG' : 'RENDAH') }}
                            </span>
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($risk->score_date)->format('d M Y') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            Tidak ada data analisis risiko.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if(method_exists($riskScores,'links'))
            <div class="card-footer bg-white">
                {{ $riskScores->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection