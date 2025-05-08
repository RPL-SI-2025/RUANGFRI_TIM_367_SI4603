@extends('mahasiswa.layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Katalog Inventaris</h2>
    
    <div class="row mt-4">
        @foreach($inventaris as $item)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                @if($item->gambar_inventaris)
                <img src="{{ asset('storage/inventaris/' . $item->gambar_inventaris) }}" class="card-img-top" alt="{{ $item->nama_inventaris }}">
                @else
                <img src="{{ asset('images/default-image.png') }}" class="card-img-top" alt="Default Image">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $item->nama_inventaris }}</h5>
                    <p class="card-text">{{ Str::limit($item->deskripsi, 100) }}</p>
                    <p class="card-text">
                        <small class="text-muted">Tersedia: {{ $item->jumlah }} buah</small>
                    </p>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('mahasiswa.katalog.inventaris.show', $item->id) }}" class="btn btn-primary">Detail</a>
                        
                        @if($item->status === 'Tersedia' && $item->jumlah > 0)
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_inventaris" value="{{ $item->id }}">
                            <input type="hidden" name="jumlah" value="1">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-cart-plus"></i> Tambahkan
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