@extends('layouts.app') {{-- Pastikan kamu pakai layout utama --}}
@section('title', 'Detail Laporan Inventaris')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Detail Laporan Inventaris</h1>

    <div class="card">
        <div class="card-header">
            Data Laporan
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-4">Mahasiswa</dt>
                <dd class="col-sm-8">{{ $laporan->mahasiswa->nama ?? '-' }}</dd>

                <dt class="col-sm-4">Logistik</dt>
                <dd class="col-sm-8">{{ $laporan->logistik->nama ?? '-' }}</dd>

                <dt class="col-sm-4">Tanggal & Waktu</dt>
                <dd class="col-sm-8">{{ \Carbon\Carbon::parse($laporan->datetime)->format('d M Y, H:i') }}</dd>

                <dt class="col-sm-4">Foto Awal</dt>
                <dd class="col-sm-8">
                    @if($laporan->foto_awal)
                        <img src="{{ asset('storage/' . $laporan->foto_awal) }}" alt="Foto Awal" class="img-fluid" style="max-width: 300px;">
                    @else
                        Tidak Ada
                    @endif
                </dd>

                <dt class="col-sm-4">Foto Akhir</dt>
                <dd class="col-sm-8">
                    @if($laporan->foto_akhir)
                        <img src="{{ asset('storage/' . $laporan->foto_akhir) }}" alt="Foto Akhir" class="img-fluid" style="max-width: 300px;">
                    @else
                        Tidak Ada
                    @endif
                </dd>

                <dt class="col-sm-4">Deskripsi</dt>
                <dd class="col-sm-8">{{ $laporan->deskripsi ?? '-' }}</dd>
            </dl>

            <a href="{{ route('lapor_inventaris.index') }}" class="btn btn-secondary mt-3">
                Kembali ke Daftar Laporan
            </a>
        </div>
    </div>
</div>
@endsection
