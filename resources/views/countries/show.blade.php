@extends('layouts.app')

@section('content')

<h2 class="text-white mb-4">

    🌍 {{ $country->name }}

</h2>

<div class="card bg-dark text-white shadow">

    <div class="card-body">

        <table class="table table-dark">

            <tr>

                <th width="250">Nama Negara</th>

                <td>{{ $country->name }}</td>

            </tr>

            <tr>

                <th>ISO2</th>

                <td>{{ $country->cca2 }}</td>

            </tr>

            <tr>

                <th>ISO3</th>

                <td>{{ $country->cca3 }}</td>

            </tr>

            <tr>

                <th>Region</th>

                <td>{{ $country->region }}</td>

            </tr>

            <tr>

                <th>Sub Region</th>

                <td>{{ $country->subregion }}</td>

            </tr>

            <tr>

                <th>Capital</th>

                <td>{{ $country->capital }}</td>

            </tr>

            <tr>

                <th>Population</th>

                <td>{{ number_format($country->population) }}</td>

            </tr>

            <tr>

                <th>Area</th>

                <td>{{ number_format($country->area,2) }} km²</td>

            </tr>

        </table>

        <a href="{{ route('countries.index') }}"
           class="btn btn-secondary">

            ← Kembali

        </a>

    </div>

</div>

@endsection