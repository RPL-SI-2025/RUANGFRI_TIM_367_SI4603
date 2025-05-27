@extends('mahasiswa.layouts.app')

@section('content')
<div class="container py-4">
    <h4 class="text-primary fw-bold mb-4">
        <i class="fa fa-dashboard me-2"></i>Dashboard Mahasiswa
    </h4>

    <!-- Katalog Ringkas -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h5 class="fw-bold">Katalog Ruangan</h5>
            <div class="list-group">
                @foreach($ruangans as $ruangan)
                    <a href="{{ route('mahasiswa.katalog.ruangan.show', $ruangan->id) }}" class="list-group-item list-group-item-action">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <img src="{{ $ruangan->gambar ? asset('storage/katalog_ruangan/' . $ruangan->gambar) : asset('images/default-room.jpg') }}" 
                                     alt="{{ $ruangan->nama_ruangan }}" class="me-3" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                <span>{{ $ruangan->nama_ruangan }}</span>
                            </div>
                            <span class="badge {{ $ruangan->status == 'Tersedia' ? 'bg-success' : 'bg-danger' }}">
                                {{ $ruangan->status }}
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        <div class="col-md-6">
            <h5 class="fw-bold">Katalog Inventaris</h5>
            <div class="list-group">
                @foreach($inventaris as $item)
                    <a href="{{ route('mahasiswa.katalog.inventaris.show', $item->id) }}" class="list-group-item list-group-item-action">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <img src="{{ $item->gambar_inventaris ? asset('storage/katalog_inventaris/' . $item->gambar_inventaris) : asset('images/default-image.png') }}" 
                                     alt="{{ $item->nama_inventaris }}" class="me-3" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                <span>{{ $item->nama_inventaris }}</span>
                            </div>
                            <span class="badge {{ $item->status == 'Tersedia' ? 'bg-success' : 'bg-danger' }}">
                                {{ $item->status }}
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Status Peminjaman -->
        <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Status Peminjaman</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="p-3 mb-3 bg-success text-white rounded">
                        <h6 class="fw-bold">Diterima</h6>
                        <ul class="list-group list-group-flush">
                            @foreach($peminjamanDiterima as $peminjaman)
                                <li class="list-group-item bg-transparent text-white border-0">{{ $peminjaman->nama }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 mb-3 bg-danger text-white rounded">
                        <h6 class="fw-bold">Ditolak</h6>
                        <ul class="list-group list-group-flush">
                            @foreach($peminjamanDitolak as $peminjaman)
                                <li class="list-group-item bg-transparent text-white border-0">{{ $peminjaman->nama }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 mb-3 bg-warning text-dark rounded">
                        <h6 class="fw-bold">Pending</h6>
                        <ul class="list-group list-group-flush">
                            @foreach($peminjamanPending as $peminjaman)
                                <li class="list-group-item bg-transparent text-dark border-0">{{ $peminjaman->nama }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection