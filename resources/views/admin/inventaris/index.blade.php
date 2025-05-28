@extends('admin.layouts.admin')

@section('title', 'Data Inventaris')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>Data Inventaris</h4>
    <a href="{{ route('admin.inventaris.create') }}" class="btn btn-success">Tambah Inventaris</a>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Foto</th>
            <th>Nama Inventaris</th>
            <th>Jenis</th>
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
                         alt="{{ $item->nama_inventaris }}" width="100">
                @else
                    Tidak ada gambar
                @endif
            </td>
            <td>{{ $item->nama_inventaris }}</td>
            <td>{{ $item->jenis }}</td>
            <td>{{ $item->deskripsi }}</td>
            <td>{{ $item->jumlah }}</td>
            <td>{{ $item->status }}</td>
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
@endsection

