@extends('mahasiswa.layouts.app')

@section('content')
<div class="container py-4">
    <h4 class="mb-4">
        <i class="fas fa-history me-2"></i>Riwayat Peminjaman & Pelaporan
    </h4>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <!-- Inventaris History Section -->
    <div class="card shadow-sm border-0 mb-5">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-box-open me-2 text-primary"></i>Riwayat Peminjaman Inventaris
            </h5>
        </div>
        <div class="card-body">
            @if(count($paginatedInventaris) > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID Pelaporan</th>
                                <th>ID Peminjaman</th>
                                <th>Tanggal</th>
                                <th>File Scan</th>
                                <th>Foto Awal</th>
                                <th>Foto Akhir</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paginatedInventaris as $item)
                                <tr>
                                    <td>{{ $item->id_lapor_inventaris }}</td>
                                    <td><strong>{{ $item->peminjaman->id }}</strong></td>
                                    <td>{{ \Carbon\Carbon::parse($item->datetime)->format('d/m/Y') }}</td>
                                    <td>
                                        @if($item->peminjaman && $item->peminjaman->file_scan)
                                            <a href="{{ asset('storage/uploads/file_scan/' . $item->peminjaman->file_scan) }}" 
                                               class="btn btn-sm btn-outline-primary" target="_blank">
                                                <i class="fas fa-file"></i>
                                            </a>
                                        @else
                                            <span class="badge bg-secondary">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->foto_awal)
                                            <a href="{{ asset('storage/' . $item->foto_awal) }}" 
                                               class="btn btn-sm btn-outline-info" target="_blank">
                                                <i class="fas fa-image"></i>
                                            </a>
                                        @else
                                            <span class="badge bg-secondary">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->foto_akhir)
                                            <a href="{{ asset('storage/' . $item->foto_akhir) }}" 
                                               class="btn btn-sm btn-outline-info" target="_blank">
                                                <i class="fas fa-image"></i>
                                            </a>
                                        @else
                                            <span class="badge bg-secondary">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-info">Selesai</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('mahasiswa.history.mahasiswa.history.history_inventaris.show', ['inventaris', $item->id_lapor_inventaris]) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $paginatedInventaris->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-box fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada riwayat peminjaman inventaris yang selesai</p>
                </div>
            @endif
        </div>
    </div>
    
    <!-- If both are empty -->
    @if(count($paginatedInventaris) == 0 )
        <div class="mt-4 text-center">
            <div class="d-flex justify-content-center mt-3">
                <a href="{{ route('mahasiswa.peminjaman.pinjam-inventaris.index') }}" class="btn btn-primary me-2">
                    <i class="fas fa-box me-1"></i> Peminjaman Inventaris
                </a>
                <a href="{{ route('mahasiswa.peminjaman.pinjam-ruangan.index') }}" class="btn btn-success">
                    <i class="fas fa-door-open me-1"></i> Peminjaman Ruangan
                </a>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        
    });
</script>
@endpush
@endsection