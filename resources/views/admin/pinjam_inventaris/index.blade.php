@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Semua Peminjaman Inventaris</h5>
                        <div>
                            <a href="{{ route('admin.approval') }}" class="btn btn-warning">
                                <i class="fa fa-clock"></i> Menunggu Persetujuan
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Inventaris</th>
                                    <th>Peminjam</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($peminjaman as $index => $pinjam)
                                    <tr>
                                        <td>{{ $index + $peminjaman->firstItem() }}</td>
                                        <td>{{ $pinjam->inventaris->nama_inventaris ?? 'N/A' }}</td>
                                        <td>{{ $pinjam->mahasiswa->nama ?? 'N/A' }} ({{ $pinjam->mahasiswa->nim ?? 'N/A' }})</td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($pinjam->tanggal_pengajuan)->format('d-m-Y') }} s/d
                                            {{ \Carbon\Carbon::parse($pinjam->tanggal_selesai)->format('d-m-Y') }}
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($pinjam->waktu_mulai)->format('H:i') }} - 
                                            {{ \Carbon\Carbon::parse($pinjam->waktu_selesai)->format('H:i') }}
                                        </td>
                                        <td>
                                            @php
                                                $badgeClass = '';
                                                switch($pinjam->status) {
                                                    case 0:
                                                        $badgeClass = 'bg-warning';
                                                        break;
                                                    case 1:
                                                        $badgeClass = 'bg-success';
                                                        break;
                                                    case 2:
                                                        $badgeClass = 'bg-danger';
                                                        break;
                                                    case 3:
                                                        $badgeClass = 'bg-info';
                                                        break;
                                                }
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">{{ $pinjam->status_text }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('pinjam-inventaris.show', $pinjam->id_pinjam_inventaris) }}" class="btn btn-sm btn-info text-white">
                                                <i class="fa fa-eye"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data peminjaman inventaris</td>
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
    </div>
</div>
@endsection