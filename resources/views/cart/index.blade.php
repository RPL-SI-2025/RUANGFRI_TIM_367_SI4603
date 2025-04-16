@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Keranjang Peminjaman</h5>
                        <div>
                            <a href="{{ route('inventaris.index') }}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left"></i> Kembali ke Katalog
                            </a>
                            @if(count(Session::get('cart', [])) > 0)
                                <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fa fa-trash"></i> Kosongkan Keranjang
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif -->

                    @if(count($cartItems) > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Inventaris</th>
                                    <th>Jumlah</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartItems as $id => $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item['nama_inventaris'] }}</td>
                                        <td>{{ $item['jumlah'] }}</td>
                                        <td>
                                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        <div class="text-end mt-3">
                            <a href="{{ route('cart.checkout') }}" class="btn btn-primary">
                                Lanjutkan ke Pengajuan <i class="fa fa-arrow-right"></i>
                            </a>
                        </div>
                    @else
                        <div class="alert alert-info text-center">
                            Keranjang anda kosong. Silahkan pilih inventaris terlebih dahulu.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection