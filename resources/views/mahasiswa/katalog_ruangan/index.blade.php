@extends('mahasiswa.layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Katalog Ruangan</h2>

    <div class="row mt-4">
        @foreach($ruangans as $item)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">{{ $item->nama_ruangan }}</h5>
                    <p class="card-text">{{ Str::limit($item->deskripsi, 100) }}</p>
                    <p class="card-text">
                        <small class="text-muted">Kapasitas: {{ $item->kapasitas }} orang</small>
                    </p>
                    <p class="card-text">
                        <small class="text-muted">Status: {{ $item->status }}</small>
                    </p>
                    <div class="d-flex justify-content-between">
                        <!-- Link untuk detail ruangan -->
                        <a href="{{ route('mahasiswa.katalog.ruangan.show', $item->id) }}" class="btn btn-primary">Detail</a>

                        @if($item->status === 'Tersedia')
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_ruangan" value="{{ $item->id }}">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-cart-plus"></i> Tambahkan ke Keranjang
                            </button>
                        </form>
                        @else
                        <button class="btn btn-secondary" disabled>Tidak Tersedia</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
