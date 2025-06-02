
@extends('mahasiswa.layouts.app')

@section('content')
<div class="container py-4">
    <div id="mainContent" tabindex="-1">
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
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr class="text-secondary">
                                            <th class="py-3" width="5%">No</th>
                                            <th class="py-3" width="20%">Nama Ruangan</th>
                                            <th class="py-3" width="15%">Lokasi</th>
                                            <th class="py-3" width="15%">Tanggal</th>
                                            <th class="py-3" width="25%">Waktu</th>
                                            <th class="py-3 text-center" width="20%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cartRuangan as $key => $item)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="fw-medium">{{ $item['nama_ruangan'] }}</td>
                                                <td>{{ $item['lokasi'] }}</td>
                                                <td>{{ \Carbon\Carbon::parse($item['tanggal_booking'])->format('d M Y') }}</td>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <span class="fw-medium">
                                                            {{ \Carbon\Carbon::parse($item['waktu_mulai'])->format('H:i') }} - 
                                                            {{ \Carbon\Carbon::parse($item['waktu_selesai'])->format('H:i') }}
                                                        </span>
                                                        
                                                        @if(isset($item['selected_slots']) && is_array($item['selected_slots']) && count($item['selected_slots']) > 0)
                                                            <div class="mt-1">
                                                                <strong class="small text-primary">Detail slot waktu:</strong>
                                                                <div class="d-flex flex-wrap gap-1 mt-1">
                                                                    @foreach($item['selected_slots'] as $slot)
                                                                        <span class="badge bg-light text-dark border">
                                                                            {{ $slot['start'] }} - {{ $slot['end'] }}
                                                                        </span>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-link text-primary p-0 border-0 me-1" 
                                                    data-bs-toggle="modal" data-bs-target="#editModal{{ $loop->iteration }}">
                                                    <i class="fa fa-edit me-1"></i>Edit
                                                </button> / 
                                                <form action="{{ route('mahasiswa.cart.keranjang_ruangan.remove', $key) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-link text-danger p-0 border-0 ms-1" 
                                                        onclick="return confirm('Yakin ingin menghapus item ini?')">
                                                        <i class="fa fa-trash me-1"></i>Hapus
                                                    </button>
                                                </form>
                                            </td>
                                            </tr>

                                            @include('mahasiswa.cart.keranjang_ruangan.edit-modal', [
                                                'key' => $key, 
                                                'item' => $item, 
                                                'iteration' => $loop->iteration
                                            ])
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Tombol kosongkan keranjang dan checkout -->
                            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                                <form action="{{ route('mahasiswa.cart.keranjang_ruangan.clear') }}" method="POST">
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
</div>

<style>
.table th {
    font-weight: 600;
    color: #495057;
}

.table td {
    padding: 1rem 0.75rem;
}

.align-middle td {
    vertical-align: middle;
}

.badge {
    font-weight: 500;
    font-size: 0.7rem;
    padding: 0.35em 0.65em;
}

.card {
    transition: all 0.3s ease;
    border-radius: 0.5rem;
    overflow: hidden;
}

.btn {
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary, .btn-success {
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
}

.card:hover {
    transform: none !important;
}

.table-responsive {
    border-radius: 0.375rem;
    overflow: hidden;
}

.table-hover tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.02);
}

.gap-1 {
    gap: 0.25rem;
}
</style>
@endsection