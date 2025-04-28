@extends('admin.layouts.app')

@section('title', 'Detail Ruangan')

@section('content')
<div class="container">
    <h2 class="mb-4">Detail Ruangan</h2>

    <div class="card shadow-sm p-4 mb-4">
        <h4>{{ $ruangan->nama_ruangan }}</h4>

        <p><strong>Deskripsi:</strong><br> {{ $ruangan->deskripsi }}</p>

        <p><strong>Kapasitas:</strong> {{ $ruangan->kapasitas }} orang</p>

        <p><strong>Status:</strong>
            @if($ruangan->status === 'Tersedia')
                <span class="badge bg-success">Tersedia</span>
            @else
                <span class="badge bg-danger">Tidak Tersedia</span>
            @endif
        </p>

        <p><strong>Penanggung Jawab:</strong> {{ $ruangan->penanggung_jawab }}</p>

        <div class="mt-3">
            <a href="{{ route('ruangan.index') }}" class="btn btn-secondary">Kembali</a>

            {{-- Tombol hanya untuk admin --}}
            @if(auth()->check() && auth()->user()->role === 'admin')
                <a href="{{ route('ruangan.edit', $ruangan->id_ruangan) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('ruangan.destroy', $ruangan->id_ruangan) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                </form>
            @endif

            {{-- Tombol hanya untuk mahasiswa --}}
            @if(auth()->check() && auth()->user()->role === 'mahasiswa' && $ruangan->status === 'Tersedia')
                <a href="{{ route('pinjam.ruangan', $ruangan->id_ruangan) }}" class="btn btn-primary">Pinjam</a>
            @endif
        </div>
    </div>
</div>
@endsection
