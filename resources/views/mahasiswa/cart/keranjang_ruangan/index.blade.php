@extends('mahasiswa.layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="text-primary mb-0 fw-bold">
                            <i class="fa fa-shopping-basket me-2"></i>Keranjang Peminjaman
                        </h4>
                    </div>
                    
                    <div class="mt-4 d-flex justify-content-between align-items-center">
                        <h5 class="text-secondary mb-0">
                            <i class="fa fa-building me-2"></i>Daftar Ruangan
                        </h5>
                    </div>
                </div>

                <div class="card-body px-4">
                    @if(count($cartRuangan) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th class="py-3">No</th>
                                        <th class="py-3">Nama Ruangan</th>
                                        <th class="py-3">Lokasi</th>
                                        <th class="py-3">Tanggal</th>
                                        <th class="py-3">Waktu</th>
                                        <th class="py-3">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cartRuangan as $key => $item)
                                        <tr class="align-middle">
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="fw-medium">{{ $item['nama_ruangan'] }}</td>
                                            <td>{{ $item['lokasi'] }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item['tanggal_booking'])->format('d M Y') }}</td>
                                            <td>{{ $item['waktu_mulai'] }} - {{ $item['waktu_selesai'] }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill mb-1" 
                                                    data-bs-toggle="modal" data-bs-target="#editModal{{ $loop->iteration }}">
                                                    <i class="fa fa-edit me-1"></i> Edit
                                                </button>
                                                <form action="{{ route('mahasiswa.cart.keranjang_ruangan.remove', $key) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill"
                                                        onclick="return confirm('Yakin ingin menghapus item ini?')">
                                                        <i class="fa fa-trash me-1"></i> Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editModal{{ $loop->iteration }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel">Edit Peminjaman Ruangan</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('mahasiswa.cart.keranjang_ruangan.update', $key) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="tanggal_booking" class="form-label">Tanggal Booking</label>
                                                                <input type="date" class="form-control" id="tanggal_booking" name="tanggal_booking" 
                                                                    value="{{ $item['tanggal_booking'] }}" min="{{ date('Y-m-d') }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                                                                <input type="time" class="form-control" id="waktu_mulai" name="waktu_mulai" 
                                                                    value="{{ $item['waktu_mulai'] }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
                                                                <input type="time" class="form-control" id="waktu_selesai" name="waktu_selesai" 
                                                                    value="{{ $item['waktu_selesai'] }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                            <form action="{{ route('mahasiswa.cart.keranjang_ruangan.clear') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-secondary rounded-pill" 
                                onclick="return confirm('Yakin ingin mengosongkan keranjang?')">
                                    <i class="fa fa-trash me-1"></i> Kosongkan Keranjang
                                </button>
                            </form>
                            
                            <form action="{{ route('mahasiswa.cart.keranjang_ruangan.checkout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success rounded-pill px-4">
                                    <i class="fa fa-check-circle me-1"></i> Proses Peminjaman
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fa fa-building fa-4x text-muted"></i>
                            </div>
                            <h5 class="text-muted mb-4">Keranjang Ruangan Anda masih kosong</h5>
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