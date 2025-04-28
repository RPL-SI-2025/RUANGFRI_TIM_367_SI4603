@extends('mahasiswa.layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="text-primary mb-0 fw-bold">
                            <i class="fas fa-clipboard-check me-2"></i>Detail Laporan Inventaris
                        </h4>
                        <a href="{{ route('mahasiswa.pelaporan.lapor_inventaris.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body px-4">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-secondary fw-bold mb-3">Informasi Laporan</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td width="40%"><strong>ID Laporan:</strong></td>
                                    <td>{{ $laporan->id_lapor_inventaris }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal Laporan:</strong></td>
                                    <td>{{ \Carbon\Carbon::parse($laporan->datetime)->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Dibuat Oleh:</strong></td>
                                    <td>{{ $laporan->oleh }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Ditujukan Kepada:</strong></td>
                                    <td>{{ $laporan->kepada }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Admin Logistik:</strong></td>
                                    <td>{{ $laporan->logistik->nama ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-secondary fw-bold mb-3">Deskripsi</h5>
                            <div class="border rounded p-3 bg-light">
                                {{ $laporan->deskripsi }}
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-secondary fw-bold mb-3">Foto Kondisi Awal</h5>
                            @if($laporan->foto_awal)
                                <img src="{{ asset('storage/' . $laporan->foto_awal) }}" class="img-fluid rounded border" alt="Foto Kondisi Awal">
                            @else
                                <div class="border rounded p-4 text-center text-muted">
                                    <i class="fas fa-image fa-2x mb-2"></i>
                                    <p>Tidak ada foto</p>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-secondary fw-bold mb-3">Foto Kondisi Akhir</h5>
                            @if($laporan->foto_akhir)
                                <img src="{{ asset('storage/' . $laporan->foto_akhir) }}" class="img-fluid rounded border" alt="Foto Kondisi Akhir">
                            @else
                                <div class="border rounded p-4 text-center text-muted">
                                    <i class="fas fa-image fa-2x mb-2"></i>
                                    <p>Tidak ada foto</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                        <a href="{{ route('mahasiswa.pelaporan.lapor_inventaris.edit', $laporan->id_lapor_inventaris) }}" class="btn btn-warning rounded-pill px-4 me-2">
                            <i class="fas fa-edit me-2"></i> Edit Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection