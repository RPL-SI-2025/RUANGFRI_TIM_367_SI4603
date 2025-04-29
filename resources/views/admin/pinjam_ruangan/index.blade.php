
@extends('admin.layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Daftar Peminjaman Ruangan</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            @if($paginatedGroupedPeminjaman->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-3 py-3">No</th>
                                <th class="px-3 py-3">Mahasiswa</th>
                                <th class="px-3 py-3">Tanggal Pengajuan</th>
                                <th class="px-3 py-3">Tanggal Selesai</th>
                                <th class="px-3 py-3">Waktu</th>
                                <th class="px-3 py-3">Jumlah Ruangan</th>
                                <th class="px-3 py-3">Status</th>
                                <th class="px-3 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paginatedGroupedPeminjaman as $key => $items)
                                @php
                                    $firstItem = $items->first();
                                    $itemCount = $items->count();
                                    $status = $firstItem->status;
                                    $statusLabels = [
                                        0 => ['text' => 'Menunggu', 'class' => 'bg-warning text-dark'],
                                        1 => ['text' => 'Disetujui', 'class' => 'bg-success'],
                                        2 => ['text' => 'Ditolak', 'class' => 'bg-danger'],
                                        3 => ['text' => 'Selesai', 'class' => 'bg-info'],
                                        4 => ['text' => 'Dibatalkan', 'class' => 'bg-secondary']
                                    ];
                                @endphp
                                <tr>
                                    <td class="px-3 py-3">{{ $loop->iteration }}</td>
                                    <td class="px-3 py-3 fw-medium">{{ $firstItem->mahasiswa->nama_mahasiswa  ?? 'Tidak ada data' }}</td>
                                    <td class="px-3 py-3">{{ \Carbon\Carbon::parse($firstItem->tanggal_pengajuan)->format('d M Y') }}</td>
                                    <td class="px-3 py-3">{{ \Carbon\Carbon::parse($firstItem->tanggal_selesai)->format('d M Y') }}</td>
                                    <td class="px-3 py-3">
                                        {{ \Carbon\Carbon::parse($firstItem->waktu_mulai)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($firstItem->waktu_selesai)->format('H:i') }}
                                    </td>
                                    <td class="px-3 py-3">{{ $itemCount }} ruangan</td>
                                    <td class="px-3 py-3">
                                        <span class="badge {{ $statusLabels[$status]['class'] ?? 'bg-secondary' }}">
                                            {{ $statusLabels[$status]['text'] ?? 'Unknown' }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-3 text-center">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.pinjam-ruangan.show', $firstItem->id) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i> Detail
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-3 py-3">
                    {{ $paginatedGroupedPeminjaman->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-calendar-x text-muted" style="font-size: 4rem;"></i>
                    <p class="mt-3 text-muted">Belum ada peminjaman ruangan</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.badge {
    font-weight: 500;
    padding: 0.5em 0.75em;
}
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