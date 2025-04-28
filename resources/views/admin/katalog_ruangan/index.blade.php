@extends('admin.layouts.admin')

@section('title', 'Katalog Ruangan')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>Katalog Ruangan</h4>
    <a href="{{ route('admin.katalog_ruangan.create') }}" class="btn btn-success">Tambah Ruangan</a>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

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
            <th>Aksi</th>
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
                <a href="{{ route('admin.katalog_ruangan.edit', $ruangan) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('admin.katalog_ruangan.destroy', $ruangan) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
