@extends('layouts.app')

@section('breadcrumb', 'Pelabuhan Global')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0" style="color: var(--text-main);">
        <i class="fas fa-anchor text-primary me-2"></i>
        Pelabuhan Global
    </h2>
</div>

<div class="row g-3 mb-4">

    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center justify-content-between p-3">
                <div>
                    <small class="text-muted text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">Total Pelabuhan</small>
                    <h3 class="fw-bold mb-0 mt-1" style="color: var(--text-main);">{{ $totalPorts }}</h3>
                </div>
                <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background-color: rgba(14, 116, 144, 0.1); color: var(--primary-color);">
                    <i class="fas fa-anchor fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center justify-content-between p-3">
                <div>
                    <small class="text-muted text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">Kemacetan Rendah</small>
                    <h3 class="fw-bold mb-0 mt-1 text-success">{{ $lowCount }}</h3>
                </div>
                <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background-color: rgba(16, 185, 129, 0.1); color: #10b981;">
                    <i class="fas fa-circle-check fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center justify-content-between p-3">
                <div>
                    <small class="text-muted text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">Kemacetan Sedang</small>
                    <h3 class="fw-bold mb-0 mt-1 text-warning">{{ $mediumCount }}</h3>
                </div>
                <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background-color: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                    <i class="fas fa-circle-exclamation fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center justify-content-between p-3">
                <div>
                    <small class="text-muted text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">Kemacetan Tinggi</small>
                    <h3 class="fw-bold mb-0 mt-1 text-danger">{{ $highCount }}</h3>
                </div>
                <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background-color: rgba(239, 68, 68, 0.1); color: #ef4444;">
                    <i class="fas fa-fire fs-4"></i>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- PETA PELABUHAN -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header">
        <h5 class="fw-bold mb-0">
            🗺️ Peta Pelabuhan Global
        </h5>
    </div>
    <div class="card-body p-2">
        <div id="portMap" style="height:500px; border-radius:12px;"></div>
    </div>
</div>

<div class="card border-0 shadow-sm bg-white text-dark mb-4">
    <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <h5 class="fw-bold mb-0" style="color: var(--text-main);">
            🚢 Daftar Pelabuhan Dunia
        </h5>

        <div class="d-flex flex-wrap align-items-center gap-2">
            {{-- Tombol Sinkronisasi --}}
            <form action="{{ route('ports.sync') }}" method="POST" class="mb-0">
                @csrf
                <button type="submit" class="btn btn-secondary py-2 fw-bold" style="height:48px;">
                    <i class="fas fa-rotate me-2"></i> Sinkronisasi
                </button>
            </form>

            {{-- Form Filter & Pencarian --}}
            <form action="{{ route('ports.index') }}" method="GET" class="mb-0">
                <div class="d-flex gap-2">
                    <select
                        name="country"
                        class="form-select"
                        style="width:220px; height:48px;">
                        <option value="">🌍 Semua Negara</option>
                        @foreach($countries as $item)
                            <option
                                value="{{ $item->id }}"
                                {{ $country == $item->id ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>

                    <input
                        type="text"
                        class="form-control"
                        name="search"
                        placeholder="Cari pelabuhan..."
                        value="{{ $search }}"
                        style="height:48px;">

                    <button type="submit" class="btn btn-primary" style="height:48px; width:48px; padding:0 !important; display:flex; align-items:center; justify-content:center;">
                        <i class="fas fa-search"></i>
                    </button>

                    <a href="{{ route('ports.index') }}" class="btn btn-secondary d-flex align-items-center justify-content-center" style="height:48px;">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4 p-3" role="alert" style="background-color: #ccfbf1; color: #0f766e; border: 1px solid rgba(15, 118, 110, 0.15) !important;">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pelabuhan</th>
                        <th>Negara</th>
                        <th>Ukuran Pelabuhan</th>
                        <th width="110">Risk Score</th>
                        <th width="180">Kemacetan</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($ports as $port)
                <tr>
                    <td>
                        {{ $loop->iteration + ($ports->currentPage()-1) * $ports->perPage() }}
                    </td>
                    <td>
                        <strong>{{ $port->name }}</strong>
                    </td>
                    <td>
                        {{ $port->country?->name }}
                    </td>
                    <td>
                        @switch($port->type)
                            @case('L')
                                Large Harbor
                                @break
                            @case('M')
                                Medium Harbor
                                @break
                            @case('S')
                                Small Harbor
                                @break
                            @case('V')
                                Very Small Harbor
                                @break
                            @default
                                -
                        @endswitch
                    </td>
                    <td>
                        <span class="badge rounded-3 px-3 py-1.5 fw-bold" style="background-color: rgba(14, 116, 144, 0.1) !important; color: var(--primary-color) !important;">
                            {{ $port->risk_score }}
                        </span>
                    </td>
                    <td>
                        @php
                            $congestionCustomStyle = 'background-color: #f1f5f9; color: #475569;';
                            if ($port->congestion_level == 'Low') {
                                $congestionCustomStyle = 'background-color: rgba(16, 185, 129, 0.1) !important; color: #047857 !important; border: 1px solid rgba(16, 185, 129, 0.2) !important;';
                            } elseif ($port->congestion_level == 'Medium') {
                                $congestionCustomStyle = 'background-color: rgba(245, 158, 11, 0.1) !important; color: #b45309 !important; border: 1px solid rgba(245, 158, 11, 0.2) !important;';
                            } else {
                                $congestionCustomStyle = 'background-color: rgba(239, 68, 68, 0.1) !important; color: #dc2626 !important; border: 1px solid rgba(239, 68, 68, 0.2) !important;';
                            }
                        @endphp
                        <span class="badge px-3 py-2 rounded-3 fw-bold" style="{{ $congestionCustomStyle }} font-size: 0.72rem; letter-spacing: 0.5px;">
                            {{ $port->congestion_level == 'Low' ? 'RENDAH' : ($port->congestion_level == 'Medium' ? 'SEDANG' : 'TINGGI') }}
                        </span>
                        <br>
                        <small class="text-muted d-block mt-1">
                            Skor {{ $port->congestion_score }}/100
                        </small>
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            Belum ada data pelabuhan.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $ports->links() }}
        </div>
    </div>
</div>

@endsection

@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {
    const map = L.map('portMap').setView([20, 0], 2);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    @foreach($mapPorts as $port)
    @if($port->latitude && $port->longitude)
    @php
        $color = '#10b981';
        if($port->congestion_level == 'Medium'){
            $color = '#f59e0b';
        }
        if($port->congestion_level == 'High'){
            $color = '#ef4444';
        }
    @endphp

    L.circleMarker(
        [{{ $port->latitude }}, {{ $port->longitude }}],
        {
            radius: 7,
            color: '{{ $color }}',
            fillColor: '{{ $color }}',
            fillOpacity: 0.9,
            weight: 2
        }
    )
    .addTo(map)
    .bindPopup(`
        <b>{{ $port->name }}</b><br>
        {{ $port->country?->name }}<br>
        Risk Score: {{ $port->risk_score }}<br>
        Kemacetan: {{ $port->congestion_level }}
    `);
    @endif
    @endforeach

    setTimeout(() => {
        map.invalidateSize();
    }, 300);
});
</script>

@endpush