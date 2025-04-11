@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Katalog Inventaris</h2>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @forelse ($inventaris as $item)
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $item->nama_inventaris }}</h5>
                        <p class="card-text text-muted">{{ $item->deskripsi }}</p>
                        <p class="mb-1"><strong>Jumlah:</strong> {{ $item->jumlah }}</p>
                        <p>
                            <strong>Status:</strong>
                            @if($item->status === 'Tersedia')
                                <span class="badge bg-success">{{ $item->status }}</span>
                            @else
                                <span class="badge bg-danger">{{ $item->status }}</span>
                            @endif
                        </p>
                        <div class="mt-auto">
                            <a href="{{ route('mahasiswa.inventaris.show', $item->id_inventaris) }}"
                               class="btn btn-primary w-100 {{ $item->status !== 'Tersedia' ? 'disabled' : '' }}">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">Tidak ada inventaris tersedia saat ini.</p>
        @endforelse
    </div>
</div>
@endsection
