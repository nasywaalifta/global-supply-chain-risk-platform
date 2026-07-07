@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2 class="text-white fw-bold">

        <i class="fas fa-ship text-primary me-2"></i>

        Data Pelabuhan

    </h2>

</div>

<div class="card bg-dark text-white shadow border-0">

    <div class="card-header d-flex justify-content-between">

        <span>🚢 Daftar Pelabuhan</span>

        <form action="{{ route('ports.index') }}" method="GET">

            <div class="input-group">

                <input
                    type="text"
                    class="form-control"
                    name="search"
                    placeholder="Cari pelabuhan..."
                    value="{{ $search }}">

                <button class="btn btn-primary">

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

                    <th>No</th>

                    <th>Pelabuhan</th>

                    <th>Kota</th>

                    <th>Negara</th>

                    <th>Tipe</th>

                    <th>Risk</th>

                </tr>

                </thead>

                <tbody>

                @forelse($ports as $port)

                    <tr>

                        <td>

                            {{ $loop->iteration + ($ports->currentPage()-1) * $ports->perPage() }}

                        </td>

                        <td>{{ $port->name }}</td>

                        <td>{{ $port->city }}</td>

                        <td>{{ $port->country?->name }}</td>

                        <td>{{ $port->type }}</td>

                        <td>

                            <span class="badge bg-success">

                                {{ $port->risk_score }}

                            </span>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6" class="text-center">

                            Belum ada data pelabuhan.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-3">

            {{ $ports->links() }}

        </div>

    </div>

</div>

@endsection