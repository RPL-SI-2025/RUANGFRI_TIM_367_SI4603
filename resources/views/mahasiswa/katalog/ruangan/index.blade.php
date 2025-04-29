@extends('mahasiswa.layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Katalog Ruangan</h2>
    <div class="row mt-4">
        @foreach($ruangans as $item)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <img src="{{ $item->gambar ?? asset('images/default-room.jpg') }}" class="card-img-top" alt="{{ $item->nama_ruangan }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $item->nama_ruangan }}</h5>
                    <p class="card-text">{{ Str::limit($item->deskripsi, 100) }}</p>
                    <p class="card-text">
                        <small class="text-muted">Kapasitas: {{ $item->kapasitas }} orang</small><br>
                        <small class="text-muted">Status: {{ $item->status }}</small>
                    </p>
                    <div class="d-flex justify-content-between mt-3">
                        <a href="{{ route('mahasiswa.katalog.ruangan.show', $item->id) }}"
                        class="btn btn-primary">Lihat Detail</a>
                        @if($item->status === 'Tersedia')
                        <form action="{{ route('mahasiswa.cart.keranjang_ruangan.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_ruangan" value="{{ $item->id }}">
                            <input type="hidden" name="tanggal_booking" value="{{ date('Y-m-d') }}">
                            <input type="hidden" name="waktu_mulai" value="08:00:00">
                            <input type="hidden" name="waktu_selesai" value="10:00:00">
                            <button class="btn btn-success">
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
