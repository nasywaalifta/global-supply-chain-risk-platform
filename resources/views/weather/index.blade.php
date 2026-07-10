@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2 class="text-white fw-bold">
        <i class="fas fa-cloud-sun text-warning me-2"></i>
        Cuaca Global
    </h2>

</div>

<div class="card bg-dark text-white shadow">

    <div class="card-header">

        🌦 Data Cuaca Pelabuhan

    </div>

    <div class="card-body">

        <table class="table table-dark table-hover align-middle">

            <thead>

                <tr>

                    <th>Pelabuhan</th>
                    <th>Negara</th>
                    <th>Suhu</th>
                    <th>Humidity</th>
                    <th>Angin</th>
                    <th>Kondisi</th>
                    <th>Risk</th>

                </tr>

            </thead>

            <tbody>

            @forelse($weather as $item)

                <tr>

                    <td>{{ $item->port->name }}</td>

                    <td>{{ $item->port->country->name }}</td>

                    <td>{{ $item->temperature }} °C</td>

                    <td>{{ $item->humidity }} %</td>

                    <td>{{ $item->wind_speed }} km/h</td>

                    <td>{{ $item->condition }}</td>

                    <td>

                        @if($item->weather_risk >= 70)

                            <span class="badge bg-danger">High</span>

                        @elseif($item->weather_risk >= 40)

                            <span class="badge bg-warning text-dark">Medium</span>

                        @else

                            <span class="badge bg-success">Low</span>

                        @endif

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="7" class="text-center">
                        Belum ada data cuaca.
                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

        <div class="mt-3">

            {{ $weather->links() }}

        </div>

    </div>

</div>

@endsection