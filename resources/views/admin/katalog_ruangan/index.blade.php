@extends('admin.layouts.app')

@section('title', 'Katalog Ruangan')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>Katalog Ruangan</h4>
    <a href="{{ route('admin.katalog_ruangan.create') }}" class="btn btn-success">Tambah Ruangan</a>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Ruangan</th>
            <th>Kapasitas</th>
            <th>Fasilitas</th>
            <th>Lokasi</th>
            <th>Status</th>
            <th>Gambar</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($ruangans as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->nama_ruangan }}</td>
            <td>{{ $item->kapasitas }}</td>
            <td>{{ $item->fasilitas }}</td>
            <td>{{ $item->lokasi }}</td>
            <td>{{ $item->status }}</td>
            <td>
                @if ($item->gambar)
                    <img src="{{ asset($item->gambar) }}" alt="gambar" width="100">
                @else
                    Tidak ada gambar
                @endif
            </td>
            <td>
                <a href="{{ route('admin.katalog_ruangan.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('admin.katalog_ruangan.destroy', $item->id) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Yakin ingin menghapus ruangan ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8" class="text-center">Belum ada ruangan</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
