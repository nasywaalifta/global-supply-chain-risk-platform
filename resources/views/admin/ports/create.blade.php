@extends('admin.layouts.app')

@section('title', 'Tambah Pelabuhan')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="fas fa-plus text-primary me-2"></i>
                Tambah Pelabuhan Baru
            </h2>
            <p class="text-muted mb-0">Tambahkan data pelabuhan baru ke dalam sistem.</p>
        </div>
        <a href="{{ route('admin.ports.index') }}" class="btn btn-outline-secondary px-4 rounded-3">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger rounded-3 shadow-sm mb-4">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.ports.store') }}" method="POST">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-semibold">Nama Pelabuhan</label>
                        <input type="text" class="form-control rounded-3 @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required placeholder="Masukkan nama pelabuhan" style="height: 48px;">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="code" class="form-label fw-semibold">Kode Pelabuhan (UN/LOCODE)</label>
                        <input type="text" class="form-control rounded-3 @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code') }}" placeholder="Contoh: IDTPP" style="height: 48px;">
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="city" class="form-label fw-semibold">Kota / Wilayah</label>
                        <input type="text" class="form-control rounded-3 @error('city') is-invalid @enderror" id="city" name="city" value="{{ old('city') }}" placeholder="Masukkan nama kota" style="height: 48px;">
                        @error('city')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="country_id" class="form-label fw-semibold">Negara</label>
                        <select class="form-select rounded-3 @error('country_id') is-invalid @enderror" id="country_id" name="country_id" required style="height: 48px;">
                            <option value="" disabled selected>Pilih Negara...</option>
                            @foreach($countries as $c)
                                <option value="{{ $c->id }}" {{ old('country_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                        @error('country_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="latitude" class="form-label fw-semibold">Latitude</label>
                        <input type="number" step="any" class="form-control rounded-3 @error('latitude') is-invalid @enderror" id="latitude" name="latitude" value="{{ old('latitude') }}" placeholder="-6.123456" style="height: 48px;">
                        @error('latitude')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="longitude" class="form-label fw-semibold">Longitude</label>
                        <input type="number" step="any" class="form-control rounded-3 @error('longitude') is-invalid @enderror" id="longitude" name="longitude" value="{{ old('longitude') }}" placeholder="106.123456" style="height: 48px;">
                        @error('longitude')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="type" class="form-label fw-semibold">Tipe Pelabuhan</label>
                        <input type="text" class="form-control rounded-3 @error('type') is-invalid @enderror" id="type" name="type" value="{{ old('type') }}" placeholder="Contoh: Sea Port, River Port" style="height: 48px;">
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="status" class="form-label fw-semibold">Status</label>
                        <input type="text" class="form-control rounded-3 @error('status') is-invalid @enderror" id="status" name="status" value="{{ old('status') }}" placeholder="Contoh: Active" style="height: 48px;">
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="risk_score" class="form-label fw-semibold">Skor Risiko (0 - 100)</label>
                        <input type="number" min="0" max="100" class="form-control rounded-3 @error('risk_score') is-invalid @enderror" id="risk_score" name="risk_score" value="{{ old('risk_score', 0) }}" required style="height: 48px;">
                        @error('risk_score')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="congestion_score" class="form-label fw-semibold">Skor Kemacetan (0 - 100)</label>
                        <input type="number" min="0" max="100" class="form-control rounded-3 @error('congestion_score') is-invalid @enderror" id="congestion_score" name="congestion_score" value="{{ old('congestion_score', 0) }}" required style="height: 48px;">
                        @error('congestion_score')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="congestion_level" class="form-label fw-semibold">Tingkat Kemacetan</label>
                        <select class="form-select rounded-3 @error('congestion_level') is-invalid @enderror" id="congestion_level" name="congestion_level" required style="height: 48px;">
                            <option value="Low" {{ old('congestion_level') == 'Low' ? 'selected' : '' }}>Low (Rendah)</option>
                            <option value="Medium" {{ old('congestion_level') == 'Medium' ? 'selected' : '' }}>Medium (Sedang)</option>
                            <option value="High" {{ old('congestion_level') == 'High' ? 'selected' : '' }}>High (Tinggi)</option>
                        </select>
                        @error('congestion_level')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary px-5 rounded-3 py-2.5" style="height: 48px;">
                            <i class="fas fa-save me-2"></i> Simpan Pelabuhan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
