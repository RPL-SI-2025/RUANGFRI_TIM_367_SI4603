@extends('mahasiswa.layouts.app')

@section('content')
<div class="container py-4">
    <h4 class="mb-4">
        <i class="fas fa-toolbox fa-sm me-2"></i> Daftar Laporan Inventaris
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
    
    @if(count($laporan) > 0)
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID Laporan</th>
                                <th>ID Peminjaman</th>
                                <th>Tanggal</th>
                                <th>Deskripsi</th>
                                <th>Admin Logistik</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($laporan as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><strong>{{ $item->peminjaman->id }}</strong></td>
                                    <td>{{ \Carbon\Carbon::parse($item->datetime)->format('d/m/Y') }}</td>
                                    <td>{{ \Str::limit($item->deskripsi, 50) }}</td>
                                    <td>{{ $item->logistik->nama ?? 'N/A' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('mahasiswa.pelaporan.lapor_inventaris.show', $item->id_lapor_inventaris) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                        <a href="{{ route('mahasiswa.pelaporan.lapor_inventaris.edit', $item->id_lapor_inventaris) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="card shadow-sm border-0">
            <div class="card-body py-5 text-center">
                <div class="py-4">
                    <i class="fas fa-clipboard fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada laporan inventaris</h5>
                    <p class="text-muted">Laporan akan muncul saat Anda menyelesaikan peminjaman inventaris.</p>
                    <a href="{{ route('mahasiswa.peminjaman.pinjam-inventaris.index') }}" class="btn btn-primary mt-2">
                        <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Peminjaman
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection