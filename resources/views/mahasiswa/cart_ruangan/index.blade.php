@extends('mahasiswa.layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="text-primary mb-0 fw-bold">
                            <i class="fa fa-door-open me-2"></i>Keranjang Peminjaman Ruangan
                        </h4>
                    </div>

                    <div class="mt-4 d-flex justify-content-between align-items-center">
                        <h5 class="text-secondary mb-0">
                            <i class="fa fa-list me-2"></i>Daftar Ruangan
                        </h5>
                        <a href="{{ route('mahasiswa.katalog.ruangan.index') }}" class="btn btn-primary rounded-pill px-4">
                            <i class="fa fa-plus me-1"></i> Tambah Ruangan
                        </a>
                    </div>
                </div>

                <div class="card-body px-4">
                    @if(!empty($cartRuangan) && count($cartRuangan) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Ruangan</th>
                                        <th>Lokasi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cartRuangan as $id => $room)
                                        <tr class="align-middle">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $room['nama_ruangan'] }}</td>
                                            <td>{{ $room['lokasi'] }}</td>
                                            <td>{{ $room['tanggal_mulai'] }}</td>
                                            <td>{{ $room['tanggal_selesai'] }}</td>
                                            <td>
                                                <form action="{{ route('cart-ruangan.remove', $id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill"
                                                        onclick="return confirm('Yakin ingin menghapus ruangan ini?')">
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
                            <form action="{{ route('cart-ruangan.clear') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-secondary rounded-pill"
                                onclick="return confirm('Yakin ingin mengosongkan keranjang ruangan?')">
                                    <i class="fa fa-trash me-1"></i> Kosongkan Keranjang
                                </button>
                            </form>

                            <form action="{{ route('cart-ruangan.checkout') }}" method="POST">
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
                            <h5 class="text-muted mb-4">Keranjang ruangan Anda masih kosong</h5>
                            <a href="{{ route('mahasiswa.katalog.ruangan.index') }}" class="btn btn-primary rounded-pill px-4">
                                <i class="fa fa-plus me-1"></i> Pilih Ruangan
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
