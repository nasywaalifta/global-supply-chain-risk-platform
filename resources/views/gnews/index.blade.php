@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2 class="text-white fw-bold">
        📰 Berita Global
    </h2>

</div>

<form id="countryForm" method="GET">

    <div class="row mb-4">

        <div class="col-md-4">

            <select
                id="country"
                name="country"
                class="form-select">

                <option value="">Semua Negara</option>

                @foreach($countries as $country)

                    <option value="{{ $country->country }}"
                        {{ request('country') == $country->country ? 'selected' : '' }}>

                        {{ $country->country }}

                    </option>

                @endforeach

            </select>

        </div>

    </div>

</form>

    <div class="row mb-4">

    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h6 class="text-muted">📰 Total Berita</h6>
                <h3 class="fw-bold text-primary">{{ $total }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h6 class="text-muted">🟢 Positive</h6>
                <h3 class="fw-bold text-success">{{ $positive }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h6 class="text-muted">🟡 Neutral</h6>
                <h3 class="fw-bold text-warning">{{ $neutral }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h6 class="text-muted">🔴 Negative</h6>
                <h3 class="fw-bold text-danger">{{ $negative }}</h3>
            </div>
        </div>
    </div>

</div>

<div class="card bg-dark text-white shadow border-0">

    <div class="card-header">
        Daftar Berita Supply Chain
    </div>

    <div class="card-body">

        <div class="row">

            @forelse($news as $item)

                <div class="col-md-6 col-lg-4 mb-4">

                    <div class="card bg-secondary h-100">

                        @if($item->image_url)
                            <img src="{{ $item->image_url }}"
                                class="card-img-top"
                                style="height:200px;object-fit:cover;">
                            @endif

                        <div class="card-body">

                            <h5 class="card-title">

                                {{ $item->title }}

                            </h5>

                            @if($item->sentiment == 'Positive')

                                <span class="badge bg-success mb-2">
                                    🟢 Positive
                                </span>

                            @elseif($item->sentiment == 'Negative')

                                <span class="badge bg-danger mb-2">
                                    🔴 Negative
                                </span>

                            @else

                                <span class="badge bg-warning text-dark mb-2">
                                    🟡 Neutral
                                </span>

                            @endif

                            <small class="text-info d-block mb-2">
                                AI Sentiment Analysis
                            </small>

                            <p class="small text-light">

                                {{ \Illuminate\Support\Str::limit($item->description ?? '',120) }}

                            </p>

                            <span class="badge bg-info">

                                {{ $item->source ?? '-' }}

                            </span>


                            <hr>

                            <small>

                                {{ optional($item->published_at)->format('d M Y H:i') }}

                            </small>

                        </div>

                        <div class="card-footer bg-transparent border-0">

                            <a href="{{ $item->url }}"
                               target="_blank"
                               class="btn btn-primary w-100">

                                Baca Selengkapnya

                            </a>

                        </div>

                    </div>

                </div>

            @empty

                <div class="col-12 text-center">

                    Belum ada berita.

                </div>

            @endforelse

        </div>


    </div>

</div>

@endsection