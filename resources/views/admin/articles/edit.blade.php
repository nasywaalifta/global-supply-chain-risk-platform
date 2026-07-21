@extends('admin.layouts.app')

@section('title', 'Edit Artikel')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="fas fa-edit text-primary me-2"></i>
                Edit Artikel: {{ $article->title }}
            </h2>
            <p class="text-muted mb-0">Perbarui konten analisis, ringkasan, kategori, atau status publikasi artikel.</p>
        </div>
        <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-secondary px-4 rounded-3">
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
            <form action="{{ route('admin.articles.update', $article) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="title" class="form-label fw-semibold">Judul Artikel</label>
                            <input type="text" class="form-control rounded-3 @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $article->title) }}" required placeholder="Masukkan judul artikel..." style="height: 48px;">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="summary" class="form-label fw-semibold">Ringkasan (Summary)</label>
                            <textarea class="form-control rounded-3 @error('summary') is-invalid @enderror" id="summary" name="summary" rows="3" placeholder="Tulis ringkasan singkat artikel..." required>{{ old('summary', $article->summary) }}</textarea>
                            @error('summary')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label fw-semibold">Konten Artikel</label>
                            <textarea class="form-control rounded-3 @error('content') is-invalid @enderror" id="content" name="content" rows="12" placeholder="Tulis isi lengkap artikel di sini..." required style="font-family: inherit;">{{ old('content', $article->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card bg-light border-0 p-3 rounded-3 mb-3">
                            <h6 class="fw-bold mb-3"><i class="fas fa-cog text-secondary me-2"></i>Pengaturan Publikasi</h6>
                            
                            <div class="mb-3">
                                <label for="category" class="form-label fw-semibold">Kategori</label>
                                <select class="form-select rounded-3 @error('category') is-invalid @enderror" id="category" name="category" required style="height: 48px;">
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat }}" {{ old('category', $article->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label fw-semibold">Status</label>
                                <select class="form-select rounded-3 @error('status') is-invalid @enderror" id="status" name="status" required style="height: 48px;">
                                    <option value="Draft" {{ old('status', $article->status) == 'Draft' ? 'selected' : '' }}>Draft (Sembunyikan)</option>
                                    <option value="Published" {{ old('status', $article->status) == 'Published' ? 'selected' : '' }}>Published (Publikasikan)</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="card bg-light border-0 p-3 rounded-3">
                            <h6 class="fw-bold mb-3"><i class="fas fa-image text-secondary me-2"></i>Media Utama</h6>
                            
                            <div class="mb-3">
                                <label for="thumbnail" class="form-label fw-semibold">URL Thumbnail Image</label>
                                <input type="text" class="form-control rounded-3 @error('thumbnail') is-invalid @enderror" id="thumbnail" name="thumbnail" value="{{ old('thumbnail', $article->thumbnail) }}" placeholder="https://images.unsplash.com/..." style="height: 48px;">
                                <small class="text-muted d-block mt-1">Masukkan URL gambar (misal dari Unsplash).</small>
                                @error('thumbnail')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary px-5 rounded-3 py-2.5" style="height: 48px;">
                            <i class="fas fa-save me-2"></i> Perbarui Artikel
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
