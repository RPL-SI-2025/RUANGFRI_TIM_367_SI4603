@extends('mahasiswa.layouts.app')
@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Dashboard</h2>
        <a href="{{ route('pinjam-inventaris.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Peminjaman
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Selamat datang, </h5>
            <p class="card-text">Ini adalah dashboard Anda. Silakan pilih menu di atas untuk melanjutkan.</p>
        </div>
    </div>
@endsection