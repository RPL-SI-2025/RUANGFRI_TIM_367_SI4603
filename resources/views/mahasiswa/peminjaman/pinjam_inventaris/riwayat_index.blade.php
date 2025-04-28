@extends('mahasiswa.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Riwayat Peminjaman Inventaris</h5>
                        <div>
                            <a href="{{ route('inventaris.index') }}" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Ajukan Peminjaman Baru
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($peminjaman->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Inventaris</th>
                                        <th>Tanggal Pengajuan</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Waktu</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($peminjaman as $pinjam)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $pinjam->inventaris->nama_inventaris ?? 'N/A' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($pinjam->tanggal_pengajuan)->format('d-m-Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($pinjam->tanggal_selesai)->format('d-m-Y') }}</td>
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
                                                <a href="{{ route('pinjam-inventaris.show', $pinjam->id) }}" class="btn btn-sm btn-info">
                                                    <i class="fa fa-eye"></i> Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4">
                            {{ $peminjaman->links() }}
                        </div>
                    @else
                        <div class="alert alert-info text-center">
                            Anda belum memiliki riwayat peminjaman inventaris.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection