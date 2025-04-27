@extends('mahasiswa.layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="text-primary mb-4">Detail Laporan Peminjaman Ruangan</h1>

    <!-- Identitas Peminjam -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Identitas Peminjam</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Nama:</strong> {{ Auth::user()->name }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>ID Mahasiswa:</strong> {{ Auth::user()->id }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Laporan -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Detail Laporan</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <p><strong>Dikembalikan Oleh:</strong> {{ $pelaporan->oleh }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p><strong>Dikembalikan Kepada:</strong> {{ $pelaporan->kepada }}</p>
                </div>
            </div>
            <div class="mb-3">
                <p><strong>Tanggal Pengembalian:</strong> {{ $pelaporan->datetime->format('d M Y, H:i') }}</p>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <p><strong>Foto Awal Peminjaman:</strong></p>
                    @if($pelaporan->foto_awal)
                        <a href="{{ Storage::url($pelaporan->foto_awal) }}" target="_blank">
                            <img src="{{ Storage::url($pelaporan->foto_awal) }}" alt="Foto Awal" class="img-fluid rounded shadow-sm" style="max-height: 200px;">
                        </a>
                    @else
                        <p class="text-muted">Tidak ada foto.</p>
                    @endif
                </div>
                <div class="col-md-6 mb-3">
                    <p><strong>Foto Akhir Peminjaman:</strong></p>
                    @if($pelaporan->foto_akhir)
                        <a href="{{ Storage::url($pelaporan->foto_akhir) }}" target="_blank">
                            <img src="{{ Storage::url($pelaporan->foto_akhir) }}" alt="Foto Akhir" class="img-fluid rounded shadow-sm" style="max-height: 200px;">
                        </a>
                    @else
                        <p class="text-muted">Tidak ada foto.</p>
                    @endif
                </div>
            </div>
            <div class="mb-3">
                <p><strong>Deskripsi:</strong></p>
                <p class="border rounded p-3 bg-light">{{ $pelaporan->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('pelaporans.edit', $pelaporan->id_lapor_ruangan) }}" class="btn btn-warning shadow-sm">
                    <i class="fas fa-edit me-2"></i>Edit Laporan
                </a>
                <a href="{{ route('pelaporans.index') }}" class="btn btn-secondary shadow-sm">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    .card-header {
        border-bottom: none;
    }
    .btn i {
        font-size: 1rem;
    }
    img {
        transition: transform 0.3s ease;
    }
    img:hover {
        transform: scale(1.05);
    }
</style>
@endsection