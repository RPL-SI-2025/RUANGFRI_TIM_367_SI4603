@extends('layouts.app')

@section('title', 'Manajemen Inventaris')

@section('content')
<div class="container">
    <h2 class="mb-4">Manajemen Inventaris</h2>

    <a href="{{ route('inventaris.create') }}" class="btn btn-primary mb-3">Tambah Inventaris</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Deskripsi</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Logistik</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventaris as $item)
            <tr>
                <td>{{ $item->nama_inventaris }}</td>
                <td>{{ $item->deskripsi }}</td>
                <td>{{ $item->jumlah }}</td>
                <td>
                    @if($item->status === 'Tersedia')
                        <span class="badge bg-success">Tersedia</span>
                    @else
                        <span class="badge bg-danger">Tidak Tersedia</span>
                    @endif
                </td>
                <td>{{ $item->id_logistik }}</td>
                <td>
                    <a href="{{ route('inventaris.edit', $item->id_inventaris) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('inventaris.destroy', $item->id_inventaris) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
