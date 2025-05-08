@extends('admin.layouts.admin')

@section('title', 'Detail Laporan Inventaris')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="m-0">Detail Laporan Inventaris #{{ $laporan->id_lapor_inventaris }}</h5>
                    <a href="{{ route('admin.lapor_inventaris.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold">Informasi Laporan</h6>
                            <table class="table table-bordered">
                                <tr>
                                    <th class="bg-light" width="40%">ID Laporan</th>
                                    <td>{{ $laporan->id_lapor_inventaris }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Tanggal</th>
                                    <td>{{ \Carbon\Carbon::parse($laporan->datetime)->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Mahasiswa</th>
                                    <td>{{ $laporan->mahasiswa->nama_mahasiswa ?? 'N/A' }} ({{ $laporan->mahasiswa->nim ?? 'N/A' }})</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Admin Logistik</th>
                                    <td>{{ $laporan->logistik->nama ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Dibuat Oleh</th>
                                    <td>{{ $laporan->oleh }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Ditujukan Kepada</th>
                                    <td>{{ $laporan->kepada }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold">Deskripsi</h6>
                            <div class="p-3 border rounded bg-light">
                                {{ $laporan->deskripsi }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <h6 class="fw-bold">Foto Kondisi Awal</h6>
                            @if($laporan->foto_awal)
                                <img src="{{ asset('storage/' . $laporan->foto_awal) }}" class="img-fluid rounded border" alt="Foto Kondisi Awal">
                            @else
                                <div class="border rounded p-4 text-center text-muted">
                                    <i class="bi bi-image"></i> Tidak ada foto
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6 mb-4">
                            <h6 class="fw-bold">Foto Kondisi Akhir</h6>
                            @if($laporan->foto_akhir)
                                <img src="{{ asset('storage/' . $laporan->foto_akhir) }}" class="img-fluid rounded border" alt="Foto Kondisi Akhir">
                            @else
                                <div class="border rounded p-4 text-center text-muted">
                                    <i class="bi bi-image"></i> Tidak ada foto
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection