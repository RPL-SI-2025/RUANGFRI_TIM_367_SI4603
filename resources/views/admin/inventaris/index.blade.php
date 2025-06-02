@extends('admin.layouts.admin')

@section('title', 'Data Inventaris')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>Data Inventaris</h4>
    <a href="{{ route('admin.inventaris.create') }}"
       class="btn btn-success d-inline-flex align-items-center gap-2 px-3 py-2 rounded-bg hover-transition shadow-sm"
       style="transition: 0.3s ease; transform: scale(1);"
       onmouseover="this.style.transform='scale(1.05)';"
       onmouseout="this.style.transform='scale(1)';">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" width="18" height="18">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                d="M12 4v16m8-8H4"/>
        </svg>
        <span class="fs-6">Tambah Inventaris</span>
    </a>
</div>

<div class="card mb-4">
    <div class="card-header bg-light">
        <h5 class="mb-0">Filter Inventaris</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.inventaris.index') }}" class="row g-2 align-items-center">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari nama inventaris..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Status</option>
                    <option value="Tersedia" {{ request('status') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="Tidak Tersedia" {{ request('status') == 'Tidak Tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('admin.inventaris.index') }}" class="btn btn-secondary w-100">Reset</a>
            </div>
        </form>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Foto</th>
                <th>Nama Inventaris</th>
                <th>Kategori</th>
                <th>Deskripsi</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($inventaris as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    @if ($item->gambar_inventaris)
                        <img src="{{ asset('storage/katalog_inventaris/' . $item->gambar_inventaris) }}" 
                             alt="{{ $item->nama_inventaris }}" width="100" class="img-thumbnail">
                    @else
                        <span class="text-muted">Tidak ada gambar</span>
                    @endif
                </td>
                <td>{{ $item->nama_inventaris }}</td>
                <td>
                    <span class="badge bg-secondary">
                        {{ $item->kategori->nama_kategori ?? 'Tidak ada kategori' }}
                    </span>
                </td>
                <td>{{ Str::limit($item->deskripsi, 50) }}</td>
                <td>{{ $item->jumlah }}</td>
                <td>
                    <span class="badge {{ $item->status == 'Tersedia' ? 'bg-success' : 'bg-danger' }}">
                        {{ $item->status }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('admin.inventaris.edit', $item) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.inventaris.destroy', $item) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Yakin ingin menghapus?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

