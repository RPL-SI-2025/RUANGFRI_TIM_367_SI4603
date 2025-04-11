@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Keranjang Peminjaman Inventaris</h5>
                        <a href="{{ route('mahasiswa.inventaris.index') }}" class="btn btn-primary">
                            <i class="fa fa-plus"></i> Tambah Inventaris
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    @if(count($cartItems) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
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
                                                    <button class="btn btn-sm btn-danger">
                                                        <i class="fa fa-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-secondary" 
                                onclick="return confirm('Yakin ingin mengosongkan keranjang?')">
                                    <i class="fa fa-trash"></i> Kosongkan Keranjang
                                </button>
                            </form>
                            
                            <form action="{{ route('cart.checkout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-shopping-cart"></i> Checkout
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="alert alert-info text-center">
                            Keranjang Anda masih kosong.<br>
                            <a href="{{ route('mahasiswa.inventaris.index') }}" class="btn btn-primary mt-2">
                                <i class="fa fa-shopping-cart"></i> Pilih Inventaris
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection