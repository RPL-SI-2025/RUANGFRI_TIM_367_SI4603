@extends('admin.layouts.admin')

@section('title', 'Katalog Ruangan')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>Katalog Ruangan</h4>
    <a href="{{ route('admin.katalog_ruangan.create') }}"
    class="btn btn-success d-inline-flex align-items-center gap-2 px-3 py-2">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" width="18" height="18">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                d="M12 4v16m8-8H4"/>
        </svg>
        <span class="fs-6">Tambah Ruangan</span>
    </a>
</div>

<form method="GET" action="{{ route('admin.katalog_ruangan.index') }}" class="row g-2 mb-4 align-items-center">
    <div class="col-auto">
        <input type="text" name="search" class="form-control" placeholder="Cari nama ruangan..." value="{{ request('search') }}">
    </div>
    <div class="col-auto">
        <select name="lokasi" class="form-select">
            <option value="">Lokasi</option>
            <option value="Gedung B (Cacuk)" {{ request('lokasi') == 'Gedung B (Cacuk)' ? 'selected' : '' }}>Gedung B (Cacuk)</option>
            <option value="Telkom University Landmark Tower (TULT)" {{ request('lokasi') == 'Telkom University Landmark Tower (TULT)' ? 'selected' : '' }}>Telkom University Landmark Tower (TULT)</option>
            <option value="Gedung Kuliah Umum (GKU)" {{ request('lokasi') == 'Gedung Kuliah Umum (GKU)' ? 'selected' : '' }}>Gedung Kuliah Umum (GKU)</option>
        </select>
    </div>
    <div class="col-auto">
        <select name="status" class="form-select">
            <option value="">Status</option>
            <option value="Tersedia" {{ request('status') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
            <option value="Tidak Tersedia" {{ request('status') == 'Tidak Tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
        </select>
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary">Filter</button>
    </div>
</form>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<style>
    thead th {
        text-align: center;
        background-color: #198754;
        color: white;
        vertical-align: middle;
    }
</style>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Foto</th>
            <th>Nama Ruangan</th>
            <th>Kapasitas</th>
            <th>Fasilitas</th>
            <th>Lokasi</th>
            <th>Status</th>
            <th style="width: 180px;">Aksi</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($ruangans as $ruangan)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>
                @if ($ruangan->gambar)
                    <img src="{{ asset('storage/katalog_ruangan/' . $ruangan->gambar) }}" alt="{{ $ruangan->nama_ruangan }}" width="100">
                @else
                    Tidak ada gambar
                @endif
            </td>
            <td>{{ $ruangan->nama_ruangan }}</td>
            <td>{{ $ruangan->kapasitas }}</td>
            <td>{{ $ruangan->fasilitas }}</td>
            <td>{{ $ruangan->lokasi }}</td>
            <td>{{ $ruangan->status }}</td>
            <td>
                    <a href="{{ route('admin.katalog_ruangan.edit', $ruangan) }}"
                       class="btn btn-secondary btn-sm d-inline-flex align-items-center gap-2 px-2 py-1 mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" width="16" height="16">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 4h4v4M6 14l3 3h8l3-3M9 4l5 5 5-5M5 20h14a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2z"/>
                        </svg>
                        <span>Edit</span>
                    </a>

                    <form action="{{ route('admin.katalog_ruangan.destroy', $ruangan) }}" method="POST"
                          class="d-inline"
                          onsubmit="return confirm('Apakah kamu yakin ingin menghapus ruangan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="btn btn-danger btn-sm d-inline-flex align-items-center gap-2 px-2 py-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" width="16" height="16">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            <span>Hapus</span>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
