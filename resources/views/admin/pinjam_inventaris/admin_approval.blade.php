
@extends('admin.layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Permintaan Peminjaman Menunggu Persetujuan</h6>
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
                            <th>Waktu</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($paginatedGroupedPending as $key => $group)
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
                                <td>{{ $firstItem->waktu_mulai }} - {{ $firstItem->waktu_selesai }}</td>
                                <td>
                                    <a href="{{ route('admin.pinjam-inventaris.show', $firstItem->id) }}" class="btn btn-sm btn-info">Detail</a>
                                    
                                    <form action="{{ route('pinjam-inventaris.update-status', $firstItem->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="1">
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Setujui permintaan peminjaman ini?')">Setujui</button>
                                    </form>
                                    
                                    <form action="{{ route('pinjam-inventaris.update-status', $firstItem->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="2">
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tolak permintaan peminjaman ini?')">Tolak</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada permintaan peminjaman yang menunggu persetujuan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $paginatedGroupedPending->links() }}
            </div>
        </div>
    </div>
</div>
@endsection