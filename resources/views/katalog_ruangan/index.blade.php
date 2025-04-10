@extends('layouts.app')

@section('title', 'Katalog Ruangan')

@section('content')
<div class='card'>
    <div class='card-header bg-primary text-white d-flex justify-content-between align-items-center'>
        <div class='d-flex align-items-center'>
            <h3 class='mb-0'>Katalog Ruangan</h3>
        <h4 class='card-title'>Katalog Ruangan</h4>
        <form action="{{ route('katalog_ruangan.index') }}" method="GET" class="ml-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control me-2" placeholder="Cari ruangan..." value="{{ request()->get('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                </div>
            </div>
        </form>
        </div>
    </div>

    <div class="card-body"
        @if($ruangan->isEmpty())
            <div class="alert alert-info">
                Tidak ada data ruangan yang ditemukan.
            </div>
        @else
            <div class="card-body">
                @foreach($ruangans as $ruangan)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        @if($ruangan->image)
                            <img src="{{ asset('storage/' . $ruangan->image) }}" class="card-img-top" alt="{{ $ruangan->name }}" style="max-height: 200px; object-fit: cover;">
                        @else
                            <div class="card-img-top" style="height: 200px; bg-secondary text-white text-center d-flex aligh-items-center justify-content-center">
                                Tidak ada gambar
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $ruangan->name }}</h5>
                            <p class="card-text">
                                <strong>Deskripsi:</strong> {{ $ruangan->description }}<br>
                                <strong>Kapasitas:</strong> {{ruangan->kapasitas}} orang<br>
                                <strong>Lokasi:</strong> {{ $ruangan->lokasi }}<br>
                                <strong>Status:</strong>
                                <span class="badge {{ $ruangan->status == 'Tersedia' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $ruangan->status }}
                            </p>
                            <a href="{{{ route('katalog_ruangan.show', $ruangan->id) }}}" class="btn btn-primary">Lihat Detail</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

@endsection
