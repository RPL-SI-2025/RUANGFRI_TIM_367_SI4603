@extends('admin.layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Dashboard Admin</h2>
    
    <div class="row g-4">
        {{-- Baris 1 --}}
        <div class="col-md-4">
            <div class="card text-white bg-primary shadow">
                <div class="card-body">
                    <h5 class="card-title">Total Jumlah Ruangan</h5>
                    <p class="card-text fs-4"> {{ $totalRuangan }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-secondary shadow">
                <div class="card-body">
                    <h5 class="card-title">Ruangan Tersedia</h5>
                    <p class="card-text fs-4">{{ $ruanganTersedia }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-dark shadow">
                <div class="card-body">
                    <h5 class="card-title">Ruangan Tidak Tersedia</h5>
                    <p class="card-text fs-4">{{ $ruanganTidakTersedia }}</p>
                </div>
            </div>
        </div>

        {{-- Baris 2 --}}
        <div class="col-md-4">
            <div class="card text-white bg-success shadow">
                <div class="card-body">
                    <h5 class="card-title">Total Jumlah Inventaris</h5>
                    <p class="card-text fs-4">{{ $totalInventaris }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-warning shadow">
                <div class="card-body">
                    <h5 class="card-title">Inventaris Tersedia</h5>
                    <p class="card-text fs-4">{{ $inventarisTersedia }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-danger shadow">
                <div class="card-body">
                    <h5 class="card-title">Inventaris Tidak Tersedia</h5>
                    <p class="card-text fs-4">{{ $inventarisTidakTersedia }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
