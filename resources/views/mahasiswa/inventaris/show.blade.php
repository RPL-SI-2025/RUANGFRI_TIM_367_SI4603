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

        @if ($inventaris->status === 'Tersedia')
            <form action="{{ route('cart.add') }}" method="POST" class="mt-3">
                @csrf
                <input type="hidden" name="id_inventaris" value="{{ $inventaris->id }}">
                <!-- Change from $inventaris->id_inventaris to $inventaris->id -->
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="jumlah" class="col-form-label">Jumlah</label>
                    </div>
                    <div class="col-auto">
                        <input type="number" id="jumlah" name="jumlah" class="form-control" min="1" max="{{ $inventaris->jumlah }}" value="1" required>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-cart-plus"></i> Tambahkan ke Keranjang
                        </button>
                    </div>
                </div>
            </form>
        @endif
    </div>

    <a href="{{ route('mahasiswa.inventaris.index') }}" class="btn btn-link mt-3">← Kembali ke Katalog</a>
</div>
@endsection