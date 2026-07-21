@extends('admin.layouts.app')

@section('title', 'Kelola Artikel Analisis')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="fas fa-file-alt text-primary me-2"></i>
                Kelola Artikel Analisis
            </h2>
            <p class="text-muted mb-0">Manajemen konten analisis dan riset supply chain risk global.</p>
        </div>
        
        <div>
            <a href="{{ route('admin.articles.create') }}" class="btn btn-primary px-4 py-2 fw-semibold rounded-3 d-flex align-items-center" style="height:48px;">
                <i class="fas fa-plus me-2"></i> Buat Artikel Baru
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
            <form action="{{ route('admin.articles.index') }}" method="GET" class="mb-0">
                <div class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label fw-semibold text-secondary">Cari Artikel</label>
                        <input type="text" class="form-control rounded-3" name="search" placeholder="Cari judul, ringkasan, atau konten..." value="{{ $search }}" style="height:48px;">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label fw-semibold text-secondary">Kategori</label>
                        <select name="category" class="form-select rounded-3" style="height:48px;">
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ $category == $cat ? 'selected' : '' }}>
                                    {{ $cat }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-grid align-items-end">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1 rounded-3" style="height:48px;">
                                <i class="fas fa-search"></i> Cari
                            </button>
                            <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary rounded-3 d-flex align-items-center justify-content-center" style="height:48px; width:48px;">
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
                            <th class="ps-4" width="80">No</th>
                            <th>Judul Artikel</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Tanggal Publikasi</th>
                            <th class="text-end pe-4" width="200">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($articles as $item)
                            <tr>
                                <td class="ps-4">{{ ($articles->currentPage() - 1) * $articles->perPage() + $loop->iteration }}</td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $item->title }}</div>
                                    <small class="text-muted">{{ Str::limit($item->summary, 80) }}</small>
                                </td>
                                <td>
                                    @php
                                        $badge = match($item->category) {
                                            'Cuaca & Iklim', 'Weather' => 'success',
                                            'Geopolitik', 'Geopolitics' => 'danger',
                                            'Teknologi', 'Technology' => 'info text-dark',
                                            'Logistik', 'Logistics' => 'primary',
                                            'Ekonomi', 'Economy' => 'warning text-dark',
                                            default => 'secondary'
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $badge }} rounded-pill px-2.5 py-1.5" style="font-size: 0.75rem;">
                                        {{ $item->category }}
                                    </span>
                                </td>
                                <td>
                                    @if($item->status == 'Published')
                                        <span class="badge bg-success rounded-pill px-2.5 py-1.5" style="font-size: 0.75rem;">Published</span>
                                    @else
                                        <span class="badge bg-secondary rounded-pill px-2.5 py-1.5" style="font-size: 0.75rem;">Draft</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $item->published_at ? \Carbon\Carbon::parse($item->published_at)->format('d M Y H:i') : '-' }}
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('admin.articles.edit', $item) }}" class="btn btn-outline-warning btn-sm rounded-3 me-1">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    
                                    <form action="{{ route('admin.articles.destroy', $item) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-3" onclick="return confirm('Apakah Anda yakin ingin menghapus artikel {{ $item->title }}?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                                    <h5 class="fw-bold">Tidak ada data artikel</h5>
                                    <p class="text-muted">Cari dengan kata kunci lain atau buat artikel baru.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($articles->hasPages())
            <div class="card-footer bg-white border-0 py-3 rounded-bottom-4">
                {{ $articles->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
