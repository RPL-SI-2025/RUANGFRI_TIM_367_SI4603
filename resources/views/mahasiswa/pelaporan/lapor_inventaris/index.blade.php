@extends('mahasiswa.layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary">Daftar Laporan Peminjaman inventaris</h1>
        <a href="{{ route('mahasiswa.pelaporan.lapor_inventaris.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus me-2"></i>Buat Laporan Baru
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($laporan->isEmpty())
        <div class="alert alert-info text-center">
            Belum ada laporan peminjaman Inventaris.
        </div>
    @else
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="p-3">No</th>
                                <th class="p-3">Tanggal Pengembalian</th>
                                <th class="p-3">Dikembalikan Oleh</th>
                                <th class="p-3">Dikembalikan Kepada</th>
                                <th class="p-3">Deskripsi</th>
                                <th class="p-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($laporan as $index => $lapor)
                                <tr>
                                    <td class="p-3">{{ $index + 1 }}</td>
                                    <td class="p-3">{{ $laporan->datetime->format('d M Y, H:i') }}</td>
                                    <td class="p-3">{{ $laporan->oleh }}</td>
                                    <td class="p-3">{{ $laporan->kepada }}</td>
                                    <td class="p-3">{{ Str::limit($laporan->deskripsi, 50) }}</td>
                                    <td class="p-3">
                                        <a href="{{ route('mahasiswa.pelaporan.lapor_inventaris.show', $pelaporan->id_lapor_inventaris) }}" class="btn btn-sm btn-info me-1">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('mahasiswa.pelaporan.lapor_inventaris.edit', $pelaporan->id_lapor_inventaris) }}" class="btn btn-sm btn-warning me-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('mahasiswa.pelaporan.lapor_inventaris.destroy', $pelaporan->id_lapor_inventaris) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    .table thead th {
        border-top: none;
    }
    .table tbody tr:hover {
        background-color: #f8f9fa;
    }
    .btn-sm i {
        font-size: 0.9rem;
    }
</style>
@endsection