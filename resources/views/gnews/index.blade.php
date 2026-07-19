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
                <h6 class="text-muted">📦 Logistics</h6>
                <h3 class="fw-bold text-success">{{ $logistics }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h6 class="text-muted">💹 Economy</h6>
                <h3 class="fw-bold text-warning">{{ $economy }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h6 class="text-muted">🌍 Geopolitics</h6>
                <h3 class="fw-bold text-danger">{{ $geopolitics }}</h3>
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

                        @if(!empty($item['image']))
                            <img src="{{ $item['image'] }}"
                                class="card-img-top"
                                style="height:200px;object-fit:cover;">
                        @endif

                        <div class="card-body">

                            <h5 class="card-title">

                                {{ $item['title'] }}

                            </h5>

                            @if($item['category'] == 'Logistics')
                                <span class="badge bg-success mb-2">📦 Logistics</span>
                            @elseif($item['category'] == 'Economy')
                                <span class="badge bg-warning text-dark mb-2">💹 Economy</span>
                            @elseif($item['category'] == 'Geopolitics')
                                <span class="badge bg-danger mb-2">🌍 Geopolitics</span>
                            @else
                                <span class="badge bg-secondary mb-2">General</span>
                            @endif

                            <p class="small text-light">

                                {{ \Illuminate\Support\Str::limit($item['description'] ?? '',120) }}

                            </p>

                            <span class="badge bg-info">

                                {{ $item['source']['name'] ?? '-' }}

                            </span>


                            <hr>

                            <small>

                                {{ \Carbon\Carbon::parse($item['publishedAt'])->format('d M Y H:i') }}

                            </small>

                        </div>

                        <div class="card-footer bg-transparent border-0">

                            <a href="{{ $item['url'] }}"
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