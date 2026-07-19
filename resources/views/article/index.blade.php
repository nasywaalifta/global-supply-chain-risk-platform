@extends('layouts.app')

@section('title', 'Insight & Analisis')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                <i class="fas fa-newspaper text-primary me-2"></i>
                Insight & Analisis
            </h2>

            <p class="text-muted mb-0">
                Kumpulan artikel mengenai supply chain, logistik,
                perdagangan global, ekonomi, dan geopolitik.
            </p>

        </div>

    </div>

    <div class="row mb-4">

        <div class="col-md-4">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <small class="text-muted">

                        Total Artikel

                    </small>

                    <h3 class="fw-bold text-primary mt-2">

                        {{ $totalArticles }}

                    </h3>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <small class="text-muted">

                        Total Kategori

                    </small>

                    <h3 class="fw-bold text-success mt-2">

                        {{ count($categories)-1 }}

                    </h3>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <small class="text-muted">

                        Hasil Ditampilkan

                    </small>

                    <h3 class="fw-bold text-warning mt-2">

                        {{ $totalArticles }}

                    </h3>

                </div>

            </div>

        </div>

    </div>

    <div class="card border-0 shadow rounded-4 mb-4">

        <div class="card-body">

            <form method="GET"
                  action="{{ route('articles.index') }}">

                <div class="row g-3">

                    <div class="col-lg-6">

                        <label class="form-label fw-semibold">

                            Cari Artikel

                        </label>

                        <input
                            type="text"
                            name="search"
                            value="{{ $search }}"
                            class="form-control"
                            placeholder="Cari judul artikel...">

                    </div>

                    <div class="col-lg-4">

                        <label class="form-label fw-semibold">

                            Kategori

                        </label>

                        <select
                            name="category"
                            class="form-select">

                            @foreach($categories as $cat)

                                <option
                                    value="{{ $cat }}"
                                    {{ $category==$cat ? 'selected' : '' }}>

                                    {{ $cat }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-lg-2 d-grid">

                        <label class="form-label">

                            &nbsp;

                        </label>

                        <button
                            class="btn btn-primary">

                            <i class="fas fa-search me-2"></i>

                            Cari

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <div class="row">
    @forelse($articles as $item)

<div class="col-lg-4 col-md-6 mb-4">

    <a href="{{ route('articles.show', $item->slug) }}"
       class="text-decoration-none">

        <div class="card article-card border-0 shadow-sm rounded-4 overflow-hidden h-100">

            <div class="position-relative">

                @if($item->thumbnail)

                    <img
                        src="{{ $item->thumbnail }}"
                        class="w-100 article-image"
                        alt="{{ $item->title }}">

                @else

                    <div
                        class="article-image bg-light d-flex align-items-center justify-content-center">

                        <i class="fas fa-image fa-3x text-secondary"></i>

                    </div>

                @endif

                @php

                    $badge = match($item->category){

                        'Logistics' => 'primary',
                        'Economy' => 'warning',
                        'Weather' => 'success',
                        'Geopolitics' => 'danger',
                        'Technology' => 'info',

                        default => 'secondary'

                    };

                @endphp

                <span
                    class="badge bg-{{ $badge }} rounded-pill px-3 py-2 position-absolute top-0 start-0 m-3">

                    {{ $item->category }}

                </span>

            </div>

            <div class="card-body d-flex flex-column">

                <small class="text-muted mb-2">

                    <i class="far fa-calendar-alt me-1"></i>

                    {{ optional($item->published_at)->format('d M Y') }}

                </small>

                <h5 class="fw-bold article-title mb-3">

                    {{ $item->title }}

                </h5>

                <p class="text-secondary flex-grow-1">

                    {{ Str::limit($item->summary,120) }}

                </p>

                <div
                    class="d-flex justify-content-between align-items-center mt-3">

                    <span class="fw-semibold text-primary">

                        Baca Selengkapnya

                    </span>

                    <i class="fas fa-arrow-right text-primary"></i>

                </div>

            </div>

        </div>

    </a>

</div>

@empty

<div class="col-12">

    <div class="card border-0 shadow rounded-4">

        <div class="card-body text-center py-5">

            <i
                class="fas fa-newspaper fa-4x text-secondary mb-3">
            </i>

            <h4 class="fw-bold">

                Artikel Tidak Ditemukan

            </h4>

            <p class="text-muted">

                Coba gunakan kata kunci atau kategori yang berbeda.

            </p>

        </div>

    </div>

</div>

@endforelse

</div>


</div>

<style>

.article-card{
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    background: #fff;
    border-radius: 16px !important;
}

.article-card:hover{
    transform: translateY(-8px);
    box-shadow: 0 20px 35px rgba(15, 118, 110, 0.08) !important;
    border-color: rgba(20, 184, 166, 0.25) !important;
}

.article-image{
    height: 220px;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.article-card:hover .article-image{
    transform: scale(1.03);
}

.article-title{
    color: var(--text-main);
    transition: color 0.3s ease;
    line-height: 1.5;
}

.article-card:hover .article-title{
    color: var(--primary-color);
}

.form-control,
.form-select{
    border-radius: 10px !important;
    height: 48px;
}

.btn-primary{
    height: 48px;
    border-radius: 10px !important;
    font-weight: 600;
}

.card{
    border-radius: 16px !important;
}

.badge{
    font-size: 0.72rem;
    letter-spacing: 0.3px;
}

.pagination{
    justify-content: center;
}

.page-link{
    border-radius: 8px !important;
    margin: 0 4px;
    border: 1px solid var(--border-color);
    color: var(--primary-color);
}

.page-item.active .page-link{
    background: var(--primary-color) !important;
    border-color: var(--primary-color) !important;
    color: #fff !important;
}

.page-link:hover{
    background: var(--primary-glow) !important;
    color: var(--primary-dark) !important;
}

@media(max-width:768px){
    .article-image{
        height: 200px;
    }
    h2{
        font-size: 1.6rem;
    }
}

</style>
<script>

document.addEventListener('DOMContentLoaded', function () {

    const cards = document.querySelectorAll('.article-card');

    cards.forEach(function(card){

        card.addEventListener('mouseenter', function(){

            this.style.cursor = 'pointer';

        });

    });

});

</script>

@endsection