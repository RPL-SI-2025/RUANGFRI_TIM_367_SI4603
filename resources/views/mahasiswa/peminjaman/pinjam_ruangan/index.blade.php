@extends('mahasiswa.layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="text-primary mb-0 fw-bold">
            <i class="fa fa-building me-2"></i>Daftar Peminjaman Ruangan
        </h4>
        <a href="{{ route('mahasiswa.cart.keranjang_ruangan.index') }}" class="btn btn-outline-primary rounded-pill">
            <i class="fa fa-plus me-1"></i> Pinjam Ruangan Baru
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            @if($pinjamRuangan->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-3 py-3">No</th>
                                <th class="px-3 py-3">Tanggal</th>
                                <th class="px-3 py-3">Daftar Ruangan</th>
                                <th class="px-3 py-3">Waktu</th>
                                <th class="px-3 py-3">Status</th>
                                <th class="px-3 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                                // Group reservations by similar booking details
                                $groupedPinjam = $pinjamRuangan->groupBy(function($item) {
                                    return $item->tanggal_pengajuan . '-' . $item->tanggal_selesai . '-' . 
                                        $item->waktu_mulai . '-' . $item->waktu_selesai . '-' . $item->file_scan;
                                });
                                $i = 1;
                            @endphp

                            @foreach($groupedPinjam as $group)
                                @php
                                    $firstItem = $group->first();
                                @endphp
                                <tr>
                                    <td class="px-3 py-3">{{ $i++ }}</td>
                                    <td class="px-3 py-3">
                                        {{ \Carbon\Carbon::parse($firstItem->tanggal_pengajuan)->format('d M Y') }}
                                        <span class="text-muted"> s/d </span>
                                        {{ \Carbon\Carbon::parse($firstItem->tanggal_selesai)->format('d M Y') }}
                                    </td>
                                    <td >
                                        <ul >
                                            @foreach($group as $item)
                                                <li>{{ $item->ruangan->nama_ruangan ?? 'Ruangan tidak ditemukan' }}</li>
            
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="px-3 py-3">
                                        {{ \Carbon\Carbon::parse($firstItem->waktu_mulai)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($firstItem->waktu_selesai)->format('H:i') }}
                                    </td>
                                    <td class="px-3 py-3">
                                        @if($firstItem->status == 0)
                                            <span class="badge bg-warning text-dark">Menunggu</span>
                                        @elseif($firstItem->status == 1)
                                            <span class="badge bg-success">Disetujui</span>
                                        @elseif($firstItem->status == 2)
                                            <span class="badge bg-danger">Ditolak</span>
                                        @elseif($firstItem->status == 3)
                                            <span class="badge bg-info">Selesai</span>
                                        @else
                                            <span class="badge bg-secondary">Dibatalkan</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-3 text-center">
                                        <div class="btn-group">
                                            <a href="{{ route('mahasiswa.peminjaman.pinjam-ruangan.show', $firstItem->id) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            @if($firstItem->status == 0)
                                                <a href="{{ route('mahasiswa.peminjaman.pinjam-ruangan.edit', $firstItem->id) }}" 
                                                   class="btn btn-sm btn-outline-success">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form action="{{ route('mahasiswa.peminjaman.pinjam-ruangan.cancel', $firstItem->id) }}" 
                                                      method="POST" class="d-inline" 
                                                      onsubmit="return confirm('Apakah Anda yakin ingin membatalkan peminjaman ini?')">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            @if($firstItem->status == 1)
                                                <a href="{{ route('mahasiswa.pelaporan.lapor_ruangan.create', ['id' => $firstItem->id]) }}" 
                                                class="btn btn-sm btn-outline-warning">
                                                    <i class="fa fa-flag"></i> Lapor
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fa fa-calendar-o text-muted" style="font-size: 4rem;"></i>
                    <p class="mt-3 text-muted">Belum ada peminjaman ruangan</p>
                    <a href="{{ route('mahasiswa.katalog.ruangan.index') }}" class="btn btn-primary mt-2">
                        <i class="fa fa-plus me-1"></i> Mulai Peminjaman Ruangan
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.btn-group .btn {
    border-radius: 0;
}
.btn-group .btn:first-child {
    border-top-left-radius: 0.25rem;
    border-bottom-left-radius: 0.25rem;
}
.btn-group .btn:last-child {
    border-top-right-radius: 0.25rem;
    border-bottom-right-radius: 0.25rem;
}
</style>
@endsection