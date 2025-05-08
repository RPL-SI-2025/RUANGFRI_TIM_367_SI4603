@extends('mahasiswa.layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0 rounded-lg">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-3">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-3">
                <div class="d-flex justify-content-between align-items-center">
                        <h4 class="text-primary mb-0 fw-bold">
                            <i class="fa fa-shopping-basket me-2"></i>Keranjang Peminjaman
                        </h4>
                    </div>
                    
                    <div class="mt-4 d-flex justify-content-between align-items-center">
                        <h5 class="text-secondary mb-0">
                            <i class="fa fa-list me-2"></i>Daftar Inventaris
                        </h5>
                    </div>
                </div>

                <div class="card-body px-4">
                    @if(count($cartItems) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th class="py-3">No</th>
                                        <th class="py-3">Nama Inventaris</th>
                                        <th class="py-3">Jumlah</th>
                                        <th class="py-3">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cartItems as $id => $item)
                                        <tr class="align-middle">
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="fw-medium">{{ $item['nama_inventaris'] }}</td>
                                            <td>
                                                <form action="{{ route('cart.update', $id) }}" method="POST" class="d-flex align-items-center">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="input-group input-group-sm" style="width: 140px;">
                                                        <input type="number" name="jumlah" value="{{ $item['jumlah'] }}" 
                                                            min="1" max="{{ $item['stok_tersedia'] }}" class="form-control" 
                                                            aria-label="Quantity">
                                                        <button type="submit" class="btn btn-outline-primary">
                                                            <i class="fa fa-refresh"></i>
                                                        </button>
                                                    </div>
                                                    <small class="text-muted ms-2">Max: {{ $item['stok_tersedia'] }}</small>
                                                </form>
                                            </td>
                                            <td>
                                                <form action="{{ route('cart.remove', $id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill"
                                                        onclick="return confirm('Yakin ingin menghapus item ini?')">
                                                        <i class="fa fa-trash me-1"></i> Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                            <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-secondary rounded-pill" 
                                onclick="return confirm('Yakin ingin mengosongkan keranjang?')">
                                    <i class="fa fa-trash me-1"></i> Kosongkan Keranjang
                                </button>
                            </form>
                            
                            <form action="{{ route('cart.checkout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success rounded-pill px-4">
                                    <i class="fa fa-check-circle me-1"></i> Proses Peminjaman
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fa fa-shopping-cart fa-4x text-muted"></i>
                            </div>
                            <h5 class="text-muted mb-4">Keranjang Anda masih kosong</h5>
                            <a href="{{ route('mahasiswa.katalog.inventaris.index') }}" class="btn btn-primary rounded-pill px-4">
                                <i class="fa fa-plus me-1"></i> Pilih Inventaris
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.table th, .table td {
    vertical-align: middle;
}
.card {
    transition: all 0.3s ease;
}
.btn {
    font-weight: 500;
    transition: all 0.3s ease;
}
.btn-primary, .btn-success {
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
}
</style>
@endsection