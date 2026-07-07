@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2 class="text-white fw-bold">
        <i class="fas fa-globe-asia text-success me-2"></i>
        Daftar Negara
    </h2>

</div>

<div class="card bg-dark text-white shadow border-0">

    <div class="card-header d-flex justify-content-between align-items-center">

        <span>
            🌍 Data Negara
        </span>

        <form action="{{ route('countries.index') }}" method="GET">

            <div class="input-group">

                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Cari negara..."
                    value="{{ $search }}">

                <button class="btn btn-info">

                    <i class="fas fa-search"></i>

                </button>

            </div>

        </form>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-dark table-hover align-middle">

                <thead>

                <tr>

                    <th width="70">No</th>

                    <th>Negara</th>

                    <th>ISO3</th>

                    <th>Region</th>

                    <th>Capital</th>

                    <th>Population</th>

                    <th width="120">Aksi</th>

                </tr>

                </thead>

                <tbody>

                @forelse($countries as $country)

                    <tr>

                        <td>

                            {{ $loop->iteration + ($countries->currentPage()-1) * $countries->perPage() }}

                        </td>

                        <td>

                            {{ $country->name }}

                        </td>

                        <td>

                            <span class="badge bg-primary">

                                {{ $country->cca3 }}

                            </span>

                        </td>

                        <td>

                            {{ $country->region }}

                        </td>

                        <td>

                            {{ $country->capital }}

                        </td>

                        <td>

                            {{ number_format($country->population) }}

                        </td>

                        <td>

                            <a href="{{ route('countries.show',$country) }}"
                               class="btn btn-sm btn-info">

                                <i class="fas fa-eye"></i>

                                Detail

                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="7"
                            class="text-center">

                            Belum ada data negara.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-3">

            {{ $countries->links() }}

        </div>

    </div>

</div>

@endsection