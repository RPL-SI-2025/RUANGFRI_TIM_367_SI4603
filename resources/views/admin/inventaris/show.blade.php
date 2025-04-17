@extends('admin.layouts.app')

@section('title', 'Detail Inventaris')

@section('content')
<div class="container">
    <h2 class="mb-4">Detail Inventaris</h2>

    <div class="card shadow-sm p-4 mb-4">
        <h4>{{ $inventaris->nama_inventaris }}</h4>

        <p><strong>Deskripsi:</strong><br> {{ $inventaris->deskripsi }}</p>

        <p><strong>Jumlah:</strong> {{ $inventaris->jumlah }}</p>

        <p><strong>Status:</strong>
            @if($inventaris->status === 'Tersedia')
                <span class="badge bg-success">Tersedia</span>
            @else
                <span class="badge bg-danger">Tidak Tersedia</span>
            @endif
        </p>

        <p><strong>Admin Logistik:</strong> {{ $inventaris->id_logistik }}</p>

        <div class="mt-3">
            <a href="{{ route('inventaris.index') }}" class="btn btn-secondary">Kembali</a>

            {{-- Tombol hanya untuk admin --}}
            @if(auth()->check() && auth()->user()->role === 'admin')
                <a href="{{ route('inventaris.edit', $inventaris->id_inventaris) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('inventaris.destroy', $inventaris->id_inventaris) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                </form>
            @endif

            {{-- Tombol hanya untuk mahasiswa --}}
            @if(auth()->check() && auth()->user()->role === 'mahasiswa' && $inventaris->status === 'Tersedia')
                <a href="{{ route('pinjam.inventaris', $inventaris->id_inventaris) }}" class="btn btn-primary">Pinjam</a>
            @endif
        </div>
    </div>
</div>
@endsection
