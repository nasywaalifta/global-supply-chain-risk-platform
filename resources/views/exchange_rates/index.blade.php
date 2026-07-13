@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2 class="text-white fw-bold mb-0">
        <i class="fas fa-coins text-warning me-2"></i>
        Nilai Tukar Mata Uang
    </h2>

    <span class="badge bg-success fs-6">
        <i class="fas fa-circle me-1"></i>
        Data Tersimpan
    </span>

</div>

<div class="card bg-dark text-white shadow border-0">

    <div class="card-header d-flex justify-content-between align-items-center">

        <span>
            💱 Daftar Nilai Tukar Mata Uang
        </span>

        <span class="badge bg-info">
            {{ $exchangeRates->count() }} Mata Uang
        </span>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-dark table-hover align-middle">

                <thead>

                <tr>

                    <th width="80">No</th>
                    <th>Mata Uang</th>
                    <th>Kode</th>
                    <th>Nilai Tukar</th>
                    <th>Mata Uang Acuan</th>
                    <th>Terakhir Diperbarui</th>

                </tr>

                </thead>

                <tbody>

                @forelse($exchangeRates as $rate)

                    <tr>

                        <td>
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            {{ $rate->currency }}
                        </td>

                        <td>
                            <span class="badge bg-primary">
                                {{ $rate->code }}
                            </span>
                        </td>

                        <td>
                            {{ number_format($rate->rate, 4) }}
                        </td>

                        <td>
                            {{ $rate->base_currency }}
                        </td>

                        <td>
                            {{ optional($rate->updated_at_api)->format('d-m-Y H:i') ?? '-' }}
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6" class="text-center py-4">

                            <i class="fas fa-circle-info me-2"></i>

                            Belum ada data nilai tukar.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection