@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2 class="text-white fw-bold">
        📰 Berita Global
    </h2>

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

                            <p class="small text-light">

                                {{ Str::limit($item->description,120) }}

                            </p>

                            <span class="badge bg-info">

                                {{ $item->source }}

                            </span>

                            <span class="badge bg-warning text-dark">

                                {{ $item->sentiment }}

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

        <div class="mt-3">

            {{ $news->links() }}

        </div>

    </div>

</div>

@endsection