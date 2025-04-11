@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>{{ $inventaris->nama_inventaris }}</h2>

    <div class="card p-4 shadow-sm">
        <p><strong>Deskripsi:</strong> {{ $inventaris->deskripsi }}</p>
        <p><strong>Jumlah Tersedia:</strong> {{ $inventaris->jumlah }}</p>
        <p><strong>Status:</strong> 
            @if ($inventaris->status === 'Tersedia')
                <span class="text-success">{{ $inventaris->status }}</span>
            @else
                <span class="text-danger">{{ $inventaris->status }}</span>
            @endif
        </p>
    </div>

    <a href="{{ route('mahasiswa.inventaris.index') }}" class="btn btn-link mt-3">← Kembali ke Katalog</a>
</div>
@endsection
