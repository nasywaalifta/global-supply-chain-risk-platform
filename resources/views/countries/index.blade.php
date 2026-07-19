@extends('layouts.app')

@section('breadcrumb', 'Analisis Negara')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: var(--text-main);">
                🌍 Analisis Negara
            </h2>
            <small class="text-muted">
                Analisis kondisi setiap negara berdasarkan data supply chain.
            </small>
        </div>
    </div>

    <!-- Search -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">

            <form method="GET">
                <div class="input-group">
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Cari negara berdasarkan nama atau kode..."
                        value="{{ $search }}"
                        style="border-radius: 10px 0 0 10px !important;">
                    <button class="btn btn-primary" style="border-radius: 0 10px 10px 0 !important; padding: 0 1.5rem !important;">
                        <i class="fas fa-search me-1"></i>
                        Cari
                    </button>
                </div>
            </form>

        </div>
    </div>

    <!-- Table -->
    <div class="card border-0 shadow-sm">

        <div class="card-header">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-globe-asia me-2 text-primary"></i>
                Daftar Negara
            </h5>
        </div>

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead>

                    <tr>
                        <th width="60" class="text-center">No</th>
                        <th class="text-center">Bendera</th>
                        <th>Negara</th>
                        <th>Region</th>
                        <th>Ibu Kota</th>
                        <th class="text-center">Risk Level</th>
                        <th class="text-center">Aksi</th>
                    </tr>

                </thead>

                <tbody>

                @forelse($countries as $country)

                @php
                    $risk = optional($country->riskScore)->risk_level;
                    $riskCustomStyle = 'background-color: #f1f5f9; color: #475569;';
                    if ($risk == 'High') {
                        $riskCustomStyle = 'background-color: rgba(239, 68, 68, 0.1) !important; color: #dc2626 !important; border: 1px solid rgba(239, 68, 68, 0.2) !important;';
                    } elseif ($risk == 'Medium') {
                        $riskCustomStyle = 'background-color: rgba(245, 158, 11, 0.1) !important; color: #b45309 !important; border: 1px solid rgba(245, 158, 11, 0.2) !important;';
                    } elseif ($risk == 'Low') {
                        $riskCustomStyle = 'background-color: rgba(16, 185, 129, 0.1) !important; color: #047857 !important; border: 1px solid rgba(16, 185, 129, 0.2) !important;';
                    } else {
                        $riskCustomStyle = 'background-color: rgba(100, 116, 139, 0.1) !important; color: #475569 !important;';
                    }
                @endphp

                <tr>

                    <td class="text-center fw-semibold">
                        {{ $countries->firstItem() + $loop->index }}
                    </td>

                    <td class="text-center">
                        <img
                            src="https://flagcdn.com/w160/{{ strtolower($country->cca2) }}.png"
                            alt="{{ $country->name }}"
                            class="rounded border shadow-sm"
                            style="width: 55px; height: 36px; object-fit: cover; border-color: var(--border-color) !important;">
                    </td>

                    <td>
                        <strong>{{ $country->name }}</strong>
                    </td>

                    <td>
                        {{ $country->region }}
                    </td>

                    <td>
                        {{ $country->capital ?? '-' }}
                    </td>

                    <td class="text-center">
                        <span class="badge px-3 py-2 rounded-3 fw-bold" style="{{ $riskCustomStyle }} font-size: 0.72rem; letter-spacing: 0.5px;">
                            {{ $risk == 'High' ? 'TINGGI' : ($risk == 'Medium' ? 'SEDANG' : ($risk == 'Low' ? 'RENDAH' : 'BELUM ADA')) }}
                        </span>
                    </td>

                    <td class="text-center">
                        <a
                            href="{{ route('countries.show',$country) }}"
                            class="btn btn-outline-primary btn-sm px-3 rounded-3 py-1.5 fw-bold">
                            <i class="fas fa-eye me-1"></i>
                            Detail
                        </a>
                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="7" class="text-center py-4">

                        Tidak ada data negara.

                    </td>

                </tr>

                @endforelse
                </tbody>

            </table>

        </div>

    </div>

    <div class="d-flex justify-content-end mt-4">

        {{ $countries->links() }}

    </div>

</div>

@endsection