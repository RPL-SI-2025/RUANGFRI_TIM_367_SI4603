@extends('admin.layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Laporan Ruangan</h1>
        <a href="{{ route('admin.lapor_ruangan.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Laporan</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th style="width: 30%">ID Laporan</th>
                                    <td>{{ $pelaporan->id_lapor_ruangan }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Laporan</th>
                                    <td>{{ \Carbon\Carbon::parse($pelaporan->datetime)->format('d F Y, H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Ruangan</th>
                                    <td>{{ $pelaporan->ruangan->nama_ruangan ?? 'Tidak ada data' }}</td>
                                </tr>
                                <tr>
                                    <th>Lokasi</th>
                                    <td>{{ $pelaporan->ruangan->lokasi ?? 'Tidak ada data' }}</td>
                                </tr>
                                <tr>
                                    <th>Pelapor</th>
                                    <td>{{ $pelaporan->mahasiswa->nama_mahasiswa ?? 'Tidak ada data' }}</td>
                                </tr>
                                <tr>
                                    <th>Dilaporkan Kepada</th>
                                    <td>{{ $pelaporan->kepada ?? 'Tidak ada data' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5 class="border-bottom pb-2 mb-3">Deskripsi Masalah</h5>
                            <p>{{ $pelaporan->deskripsi }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Keterangan Admin</h6>
                </div>
                <div class="card-body">
                    @if($pelaporan->keterangan)
                        <p>{{ $pelaporan->keterangan }}</p>
                    @else
                        <form action="{{ route('admin.lapor_ruangan.update', $pelaporan->id_lapor_ruangan) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="keterangan">Tambahkan Keterangan:</label>
                                <textarea class="form-control" id="keterangan" name="keterangan" rows="4" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">Simpan Keterangan</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Foto Kondisi Awal</h6>
                </div>
                <div class="card-body text-center">
                    @if($pelaporan->foto_awal)
                        <img src="{{ asset('storage/' . $pelaporan->foto_awal) }}" class="img-fluid rounded" alt="Foto Kondisi Awal" style="max-height: 300px;">
                        <div class="mt-3">
                            <a href="{{ asset('storage/' . $pelaporan->foto_awal) }}" class="btn btn-sm btn-primary" target="_blank">
                                <i class="bi bi-fullscreen"></i> Lihat Ukuran Penuh
                            </a>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-image" style="font-size: 4rem; color: #d3d3d3;"></i>
                            <p class="mt-3 text-muted">Tidak ada foto kondisi awal</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Foto Kondisi Akhir</h6>
                </div>
                <div class="card-body text-center">
                    @if($pelaporan->foto_akhir)
                        <img src="{{ asset('storage/' . $pelaporan->foto_akhir) }}" class="img-fluid rounded" alt="Foto Kondisi Akhir" style="max-height: 300px;">
                        <div class="mt-3">
                            <a href="{{ asset('storage/' . $pelaporan->foto_akhir) }}" class="btn btn-sm btn-primary" target="_blank">
                                <i class="bi bi-fullscreen"></i> Lihat Ukuran Penuh
                            </a>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-image" style="font-size: 4rem; color: #d3d3d3;"></i>
                            <p class="mt-3 text-muted">Tidak ada foto kondisi akhir</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection