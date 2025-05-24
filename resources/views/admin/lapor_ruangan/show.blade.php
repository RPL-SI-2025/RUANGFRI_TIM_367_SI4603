@extends('admin.layouts.admin')

@section('title', 'Detail Laporan Ruangan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="m-0">Detail Laporan Ruangan #{{ $pelaporan->id_lapor_ruangan }}</h5>
                    <a href="{{ route('admin.lapor_ruangan.index') }}" class="btn btn-secondary btn-sm">
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
                                    <td>{{ $pelaporan->id_lapor_ruangan }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">ID Peminjaman</th>
                                    <td>{{ $pelaporan->peminjaman->id}}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Tanggal</th>
                                    <td>{{ \Carbon\Carbon::parse($pelaporan->datetime)->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Ruangan</th>
                                    <td>{{ $pelaporan->ruangan->nama_ruangan ?? 'Tidak ada data' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Lokasi</th>
                                    <td>{{ $pelaporan->ruangan->lokasi ?? 'Tidak ada data' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Pelapor</th>
                                    <td>{{ $pelaporan->mahasiswa->nama_mahasiswa ?? 'Tidak ada data' }} ({{ $pelaporan->mahasiswa->nim ?? 'N/A' }})</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Ditujukan Kepada</th>
                                    <td>{{ $pelaporan->kepada ?? 'Tidak ada data' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold">Deskripsi Masalah</h6>
                            <div class="p-3 border rounded bg-light">
                                {{ $pelaporan->deskripsi }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <h6 class="fw-bold">Foto Kondisi Awal</h6>
                            @if($pelaporan->foto_awal)
                                <img src="{{ asset('storage/' . $pelaporan->foto_awal) }}" class="img-fluid rounded border" alt="Foto Kondisi Awal">
                                <div class="mt-2">
                                    <a href="{{ asset('storage/' . $pelaporan->foto_awal) }}" class="btn btn-sm btn-primary" target="_blank">
                                        <i class="bi bi-fullscreen"></i> Lihat Ukuran Penuh
                                    </a>
                                </div>
                            @else
                                <div class="border rounded p-4 text-center text-muted">
                                    <i class="bi bi-image"></i> Tidak ada foto
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6 mb-4">
                            <h6 class="fw-bold">Foto Kondisi Akhir</h6>
                            @if($pelaporan->foto_akhir)
                                <img src="{{ asset('storage/' . $pelaporan->foto_akhir) }}" class="img-fluid rounded border" alt="Foto Kondisi Akhir">
                                <div class="mt-2">
                                    <a href="{{ asset('storage/' . $pelaporan->foto_akhir) }}" class="btn btn-sm btn-primary" target="_blank">
                                        <i class="bi bi-fullscreen"></i> Lihat Ukuran Penuh
                                    </a>
                                </div>
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
