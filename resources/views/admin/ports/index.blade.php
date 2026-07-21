@extends('admin.layouts.app')

@section('title', 'Kelola Dataset Pelabuhan')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="fas fa-anchor text-primary me-2"></i>
                Kelola Dataset Pelabuhan
            </h2>
            <p class="text-muted mb-0">Manajemen dataset pelabuhan global dan status kemacetan.</p>
        </div>
        
        <div class="d-flex flex-wrap gap-2">
            <form action="{{ route('admin.ports.sync') }}" method="POST" class="mb-0">
                @csrf
                <button type="submit" class="btn btn-outline-primary py-2 fw-semibold rounded-3 d-flex align-items-center" style="height:48px;">
                    <i class="fas fa-sync-alt me-2"></i> Sinkronisasi Data
                </button>
            </form>
            
            <a href="{{ route('admin.ports.create') }}" class="btn btn-primary px-4 py-2 fw-semibold rounded-3 d-flex align-items-center" style="height:48px;">
                <i class="fas fa-plus me-2"></i> Tambah Pelabuhan
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4 p-3" role="alert" style="background-color: #ccfbf1; color: #0f766e; border: 1px solid rgba(15, 118, 110, 0.15) !important;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Filter Card --}}
    <div class="card border-0 shadow-sm mb-4 rounded-4">
        <div class="card-body">
            <form action="{{ route('admin.ports.index') }}" method="GET" class="mb-0">
                <div class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label fw-semibold text-secondary">Cari Pelabuhan</label>
                        <input type="text" class="form-control rounded-3" name="search" placeholder="Cari nama atau kode..." value="{{ $search }}" style="height:48px;">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label fw-semibold text-secondary">Negara</label>
                        <select name="country" class="form-select rounded-3" style="height:48px;">
                            <option value="">Semua Negara</option>
                            @foreach($countries as $item)
                                <option value="{{ $item->id }}" {{ $country == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-grid align-items-end">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1 rounded-3" style="height:48px;">
                                <i class="fas fa-search"></i> Cari
                            </button>
                            <a href="{{ route('admin.ports.index') }}" class="btn btn-secondary rounded-3 d-flex align-items-center justify-content-center" style="height:48px; width:48px;">
                                <i class="fas fa-redo-alt"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">No</th>
                            <th>Kode</th>
                            <th>Nama Pelabuhan</th>
                            <th>Negara</th>
                            <th>Kemacetan</th>
                            <th class="text-center">Skor Risiko</th>
                            <th class="text-end pe-4" width="200">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ports as $port)
                            <tr>
                                <td class="ps-4">{{ ($ports->currentPage() - 1) * $ports->perPage() + $loop->iteration }}</td>
                                <td><code class="text-secondary fw-semibold">{{ $port->code ?? '-' }}</code></td>
                                <td class="fw-semibold text-dark">{{ $port->name }}</td>
                                <td>
                                    @if($port->country)
                                        <span class="fw-medium">{{ $port->country->name }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($port->congestion_level == 'High')
                                        <span class="badge bg-danger text-white rounded-pill px-3 py-2">High ({{ $port->congestion_score }}%)</span>
                                    @elseif($port->congestion_level == 'Medium')
                                        <span class="badge bg-warning text-dark rounded-pill px-3 py-2">Medium ({{ $port->congestion_score }}%)</span>
                                    @else
                                        <span class="badge bg-success text-white rounded-pill px-3 py-2">Low ({{ $port->congestion_score }}%)</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="fw-bold {{ $port->risk_score >= 70 ? 'text-danger' : ($port->risk_score >= 40 ? 'text-warning' : 'text-success') }}">
                                        {{ $port->risk_score }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('admin.ports.edit', $port) }}" class="btn btn-outline-warning btn-sm rounded-3 me-1">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    
                                    <form action="{{ route('admin.ports.destroy', $port) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-3" onclick="return confirm('Apakah Anda yakin ingin menghapus pelabuhan {{ $port->name }}?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="fas fa-anchor fa-3x text-muted mb-3"></i>
                                    <h5 class="fw-bold">Tidak ada data pelabuhan</h5>
                                    <p class="text-muted">Cari dengan kata kunci lain atau lakukan sinkronisasi data.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($ports->hasPages())
            <div class="card-footer bg-white border-0 py-3 rounded-bottom-4">
                {{ $ports->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
