@extends('admin.layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Peminjaman Inventaris</h6>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Mahasiswa</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Tanggal Selesai</th>
                            <th>Item yang Dipinjam</th>
                            <th>Status</th>
                            <th>Aksi</th>
                            <th>Tanggal Dibuat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($paginatedGroupedPeminjaman as $key => $group)
                            @php 
                                $firstItem = $group->first(); 
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $firstItem->mahasiswa->nama_mahasiswa ?? 'Tidak ditemukan' }}</td>
                                <td>{{ \Carbon\Carbon::parse($firstItem->tanggal_pengajuan)->format('d-m-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($firstItem->tanggal_selesai)->format('d-m-Y') }}</td>
                                <td>
                                    <ul>
                                        @foreach($group as $pinjam)
                                            <li>{{ $pinjam->inventaris->nama_inventaris ?? 'Inventaris tidak ditemukan' }} ({{ $pinjam->jumlah_pinjam }})</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    @php
                                        $statusClass = match($firstItem->status) {
                                            0 => 'warning',
                                            1 => 'success',
                                            2 => 'danger',
                                            3 => 'info',
                                            default => 'secondary'
                                        };
                                        $statusText = match($firstItem->status) {
                                            0 => 'Menunggu Persetujuan',
                                            1 => 'Disetujui',
                                            2 => 'Ditolak',
                                            3 => 'Selesai',
                                            default => 'Tidak Diketahui'
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $statusClass }}">{{ $statusText }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.pinjam-inventaris.show', $firstItem->id) }}" class="btn btn-sm btn-info">Detail</a>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($firstItem->created_at)->format('d-m-Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $paginatedGroupedPeminjaman->links() }}
            </div>
        </div>
    </div>
</div>
@endsection