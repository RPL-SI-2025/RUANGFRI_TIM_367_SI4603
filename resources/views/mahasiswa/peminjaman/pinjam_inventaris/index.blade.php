@extends('mahasiswa.layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Daftar Peminjaman Inventaris</h2>
        <a href="{{ route('mahasiswa.peminjaman.pinjam-inventaris.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Peminjaman
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Inventaris</th>
                            <th>Peminjam</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Tanggal Selesai</th>
                            <th>Waktu</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($peminjaman as $index => $pinjam)
                            <tr>
                                <td>{{ $index + $peminjaman->firstItem() }}</td>
                                <td>{{ $pinjam->inventaris->nama_inventaris }}</td>
                                <td>{{ $pinjam->mahasiswa->nama }} ({{ $pinjam->mahasiswa->nim }})</td>
                                <td>{{ date('d-m-Y', strtotime($pinjam->tanggal_pengajuan)) }}</td>
                                <td>{{ date('d-m-Y', strtotime($pinjam->tanggal_selesai)) }}</td>
                                <td>{{ date('H:i', strtotime($pinjam->waktu_mulai)) }} - {{ date('H:i', strtotime($pinjam->waktu_selesai)) }}</td>
                                <td>
                                    @if($pinjam->status == 0)
                                        <span class="badge bg-warning">Menunggu Persetujuan</span>
                                    @elseif($pinjam->status == 1)
                                        <span class="badge bg-success">Disetujui</span>
                                    @elseif($pinjam->status == 2)
                                        <span class="badge bg-danger">Ditolak</span>
                                    @elseif($pinjam->status == 3)
                                        <span class="badge bg-info">Selesai</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('mahasiswa.peminjaman.pinjam-inventaris.show', $pinjam->id) }}" class="btn btn-sm btn-info text-white">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('mahasiswa.peminjaman.pinjam-inventaris.edit', $pinjam->id) }}" class="btn btn-sm btn-warning text-white">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data peminjaman inventaris</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-3">
                {{ $peminjaman->links() }}
            </div>
        </div>
    </div>
</div>
@endsection