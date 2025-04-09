@extends('layouts.app')

@section('content')
<h1>Daftar Inventaris</h1>

@auth
    @if(auth()->user()->role === 'admin')
        <a href="{{ route('inventaris.create') }}" class="btn btn-primary">Tambah Inventaris</a>
    @endif
@endauth

<table class="table">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Deskripsi</th>
            <th>Jumlah</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($inventaris as $item)
        <tr>
            <td>{{ $item->nama_inventaris }}</td>
            <td>{{ $item->deskripsi }}</td>
            <td>{{ $item->jumlah }}</td>
            <td>{{ $item->status }}</td>
            <td>
                <a href="{{ route('inventaris.show', $item->id_inventaris) }}" class="btn btn-info">Detail</a>

                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('inventaris.edit', $item->id_inventaris) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('inventaris.destroy', $item->id_inventaris) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger">Hapus</button>
                        </form>
                    @elseif(auth()->user()->role === 'mahasiswa')
                        <a href="{{ route('inventaris.pinjam', $item->id_inventaris) }}" class="btn btn-success">Pinjam</a>
                    @endif
                @endauth
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
