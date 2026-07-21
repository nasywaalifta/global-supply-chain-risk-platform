@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('header')
    Dashboard Admin
@endsection

@section('content')

<div class="container-fluid">

    <h2 class="fw-bold mb-4">
        Admin Dashboard
    </h2>

    <div class="row g-4">

        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h6>Total User</h6>
                    <h2 class="fw-bold">{{ $totalUsers }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h6>Dataset Pelabuhan</h6>
                    <h2 class="fw-bold">{{ $totalPorts }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h6>Artikel Analisis</h6>
                    <h2 class="fw-bold">{{ $totalArticles }}</h2>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection