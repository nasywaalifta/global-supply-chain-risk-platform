@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                <i class="fas fa-coins text-warning me-2"></i>
                Nilai Tukar Mata Uang
            </h2>

            <p class="text-muted mb-0">
                Monitoring nilai tukar mata uang dunia secara real-time.
            </p>

        </div>

    </div>

    <div class="row g-4">

        <!-- ========================= -->
        <!-- KALKULATOR -->
        <!-- ========================= -->

        <div class="col-lg-7">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header">

                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-calculator text-primary me-2"></i>
                        Kalkulator Nilai Tukar
                    </h5>

                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Mata Uang Asal
                            </label>

                            <select
                                id="fromCurrency"
                                class="form-select"
                                onchange="convertCurrency()">

                                @foreach($exchangeRates as $currency)

                                @php
                                    $country = $countries[$currency->code] ?? null;
                                @endphp

                                <option
                                    value="{{ $currency->rate }}"
                                    {{ $currency->code=='USD' ? 'selected' : '' }}>

                                    {{ $country?->name ?? $currency->currency }}
                                    ({{ $currency->code }})

                                </option>

                                @endforeach

                            </select>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Mata Uang Tujuan
                            </label>

                            <select
                                id="toCurrency"
                                class="form-select"
                                onchange="convertCurrency()">

                                @foreach($exchangeRates as $currency)

                                @php
                                    $country = $countries[$currency->code] ?? null;
                                @endphp

                                <option
                                    value="{{ $currency->rate }}"
                                    {{ $currency->code=='IDR' ? 'selected' : '' }}>

                                    {{ $country?->name ?? $currency->currency }}
                                    ({{ $currency->code }})

                                </option>

                                @endforeach

                            </select>

                        </div>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Jumlah
                        </label>

                        <input
                            type="number"
                            id="amount"
                            class="form-control"
                            value="1"
                            oninput="convertCurrency()">

                    </div>

                    <button
                        class="btn btn-primary w-100"
                        onclick="convertCurrency()">

                        <i class="fas fa-exchange-alt me-2"></i>
                        Hitung Nilai Tukar

                    </button>

                    <div
                        id="result"
                        class="border rounded p-4 mt-4"
                        style="background-color: #f8fafc; border-color: rgba(226, 232, 240, 0.8) !important;">

                        <small class="text-muted">
                            Hasil Konversi
                        </small>

                        <h2 class="fw-bold text-primary mt-2 mb-0">
                            -
                        </h2>

                    </div>

                </div>

            </div>

        </div>
                <!-- ========================= -->
        <!-- RINGKASAN -->
        <!-- ========================= -->

        <div class="col-lg-5">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header">

                    <h5 class="fw-bold mb-0">

                        <i class="fas fa-chart-line text-primary me-2"></i>

                        Ringkasan Kurs

                    </h5>

                </div>

                <div class="card-body">

                    <div class="row g-3">

                        <div class="col-6">

                            <div class="border rounded p-3 text-center h-100" style="background-color: #f8fafc; border-color: rgba(226, 232, 240, 0.8) !important;">

                                <small class="text-muted d-block">
                                    Total Mata Uang
                                </small>

                                <h2 class="fw-bold text-primary mb-0">

                                    {{ $exchangeRates->count() }}

                                </h2>

                            </div>

                        </div>

                        <div class="col-6">

                            <div class="border rounded p-3 text-center h-100" style="background-color: #f8fafc; border-color: rgba(226, 232, 240, 0.8) !important;">

                                <small class="text-muted d-block">
                                    Base Currency
                                </small>

                                <h2 class="fw-bold text-success mb-0">

                                    USD

                                </h2>

                            </div>

                        </div>

                        <div class="col-6">

                            <div class="border rounded p-3 text-center h-100" style="background-color: #f8fafc; border-color: rgba(226, 232, 240, 0.8) !important;">

                                <small class="text-muted d-block">
                                    Kurs Tertinggi
                                </small>

                                <h5 class="fw-bold text-danger mb-0">

                                    {{ number_format($exchangeRates->max('rate'),2) }}

                                </h5>

                            </div>

                        </div>

                        <div class="col-6">

                            <div class="border rounded p-3 text-center h-100" style="background-color: #f8fafc; border-color: rgba(226, 232, 240, 0.8) !important;">

                                <small class="text-muted d-block">
                                    Kurs Terendah
                                </small>

                                <h5 class="fw-bold text-info mb-0">

                                    {{ number_format($exchangeRates->min('rate'),2) }}

                                </h5>

                            </div>

                        </div>

                    </div>

                    <hr>

                    <div class="d-flex justify-content-between">

                        <span class="text-muted">

                            Status

                        </span>

                        <span class="badge bg-success">

                            Real-Time

                        </span>

                    </div>

                    <div class="d-flex justify-content-between mt-2">

                        <span class="text-muted">

                            Update Terakhir

                        </span>

                        <strong>

                            {{ optional($exchangeRates->first()?->updated_at_api)->format('d M Y H:i') }}

                        </strong>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- SEARCH -->

    <div class="card border-0 shadow-sm mt-4 mb-4">

        <div class="card-body">

            <div class="row align-items-center">

                <div class="col-md-8">

                    <div class="input-group">

                        <span class="input-group-text">

                            <i class="fas fa-search"></i>

                        </span>

                        <input
                            type="text"
                            id="searchCurrency"
                            class="form-control"
                            placeholder="Cari negara atau kode mata uang...">

                    </div>

                </div>

                <div class="col-md-4 text-end">

                    <span class="badge bg-primary fs-6">

                        {{ $exchangeRates->count() }} Mata Uang

                    </span>

                </div>

            </div>

        </div>

    </div>
    <!-- DAFTAR MATA UANG -->

<div class="card border-0 shadow-sm">

    <div class="card-header">

        <div class="d-flex justify-content-between align-items-center">

            <h5 class="fw-bold mb-0">

                <i class="fas fa-globe text-primary me-2"></i>

                Daftar Mata Uang Dunia

            </h5>

            <span class="badge" style="background-color: rgba(16, 185, 129, 0.1) !important; color: #047857 !important; border: 1px solid rgba(16, 185, 129, 0.2) !important;">

                Real-Time

            </span>

        </div>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle" id="currencyTable">

                <thead class="table-light">

                <tr>

                    <th width="60">#</th>
                    <th>Negara</th>
                    <th>Kode</th>
                    <th>Nilai Tukar</th>
                    <th>Base</th>

                </tr>

                </thead>

                <tbody>

                @foreach($exchangeRates as $rate)

                @php
                    $country = $countries[$rate->code] ?? null;
                @endphp

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>

                        🌍 {{ $country?->name ?? $rate->currency }}

                    </td>

                    <td>

                        <span class="badge bg-primary">

                            {{ $rate->code }}

                        </span>

                    </td>

                    <td>

                        {{ number_format($rate->rate,4) }}

                    </td>

                    <td>

                        {{ $rate->base_currency }}

                    </td>

                </tr>

                @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

</div>

<script>

function convertCurrency(){

    let amount = parseFloat(document.getElementById('amount').value);

    let from = parseFloat(document.getElementById('fromCurrency').value);

    let to = parseFloat(document.getElementById('toCurrency').value);

    if(isNaN(amount) || amount<=0){

        return;

    }

    let usd = amount / from;

    let result = usd * to;

    document.getElementById('result').innerHTML = `
        <small class="text-muted">
            Hasil Konversi
        </small>

        <h2 class="fw-bold text-primary mt-2">

            ${result.toLocaleString('id-ID',{
                minimumFractionDigits:2,
                maximumFractionDigits:2
            })}

        </h2>
    `;

}

document.getElementById('searchCurrency').addEventListener('keyup',function(){

    let keyword=this.value.toLowerCase();

    document.querySelectorAll('#currencyTable tbody tr').forEach(function(row){

        row.style.display=row.innerText.toLowerCase().includes(keyword)
            ?''
            :'none';

    });

});

window.onload=function(){

    convertCurrency();

}

</script>

@endsection