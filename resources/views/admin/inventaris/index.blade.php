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
