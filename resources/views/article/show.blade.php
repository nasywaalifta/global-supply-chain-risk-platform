@extends('layouts.app')

@section('breadcrumb', 'Artikel Analisis')

@section('content')

<!-- Back Button -->
<div class="mb-4">
    <a href="{{ route('articles.index') }}" class="btn btn-outline-secondary rounded-3 fw-bold shadow-sm">
        <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Artikel
    </a>
</div>

<!-- Main Content Card -->
<div class="card border-0 shadow rounded-4 overflow-hidden bg-white mb-4">
    
    <!-- Large Header Image -->
    @if($article->thumbnail)
        <div style="height: 350px; width: 100%; position: relative;">
            <img src="{{ $article->thumbnail }}" alt="{{ $article->title }}" class="w-100 h-100" style="object-fit: cover;">
            <div class="position-absolute bottom-0 start-0 w-100 p-4" style="background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                <span class="badge rounded-pill bg-primary px-3 py-1.5 fw-bold mb-2">
                    <i class="fas fa-tag me-1"></i> {{ $article->category }}
                </span>
                <h1 class="text-white fw-bold mb-0" style="font-size: 2rem;">{{ $article->title }}</h1>
            </div>
        </div>
    @endif

    <div class="card-body p-5">
        
        @if(!$article->thumbnail)
            <div class="mb-3">
                <span class="badge rounded-pill bg-primary px-3 py-1.5 fw-bold">
                    <i class="fas fa-tag me-1"></i> {{ $article->category }}
                </span>
            </div>
            <h1 class="text-dark fw-bold mb-3">{{ $article->title }}</h1>
        @endif

        <!-- Metadata -->
        <div class="d-flex align-items-center text-muted mb-4 pb-3 border-bottom">
            <span class="me-4">
                <i class="far fa-user me-1 text-primary"></i> Oleh <strong>Tim Analis SupplyRisk</strong>
            </span>
            <span>
                <i class="far fa-calendar-alt me-1 text-primary"></i> Diterbitkan pada {{ optional($article->published_at)->format('d F Y H:i') ?? $article->created_at->format('d F Y H:i') }}
            </span>
        </div>

        <!-- Article Content -->
        <div class="article-content text-dark" style="font-size: 1.1rem; line-height: 1.8;">
            {!! nl2br(e($article->content)) !!}
        </div>

    </div>

</div>

@endsection
