@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Daftar Pengajuan Peminjaman Inventaris yang Menunggu Persetujuan</h5>
                        <div>
                            <a href="{{ route('pinjam-inventaris.index') }}" class="btn btn-secondary">
                                <i class="fa fa-list"></i> Semua Peminjaman
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

                    @if($pending->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Inventaris</th>
                                        <th>Peminjam</th>
                                        <th>Tanggal Pengajuan</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Waktu</th>
                                        <th>File</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pending as $index => $pinjam)
                                        <tr>
                                            <td>{{ $index + $pending->firstItem() }}</td>
                                            <td>{{ $pinjam->inventaris->nama_inventaris ?? 'N/A' }}</td>
                                            <td>{{ $pinjam->mahasiswa->nama ?? 'N/A' }} ({{ $pinjam->mahasiswa->nim ?? 'N/A' }})</td>
                                            <td>{{ \Carbon\Carbon::parse($pinjam->tanggal_pengajuan)->format('d-m-Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($pinjam->tanggal_selesai)->format('d-m-Y') }}</td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($pinjam->waktu_mulai)->format('H:i') }} - 
                                                {{ \Carbon\Carbon::parse($pinjam->waktu_selesai)->format('H:i') }}
                                            </td>
                                            <td>
                                                @if($pinjam->file_scan)
                                                    <a href="{{ asset('storage/uploads/file_scan/' . $pinjam->file_scan) }}" 
                                                       target="_blank" class="btn btn-sm btn-secondary">
                                                        <i class="fa fa-file"></i> Lihat File
                                                    </a>
                                                @else
                                                    <span class="badge bg-secondary">Tidak ada file</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('pinjam-inventaris.show', $pinjam->id) }}" class="btn btn-sm btn-info text-white">
                                                        <i class="fa fa-eye"></i> Detail
                                                    </a>
                                                    
                                                    <form action="{{ route('pinjam-inventaris.update-status', $pinjam->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="1">
                                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Apakah Anda yakin ingin menyetujui peminjaman ini?')">
                                                            <i class="fa fa-check"></i> Setujui
                                                        </button>
                                                    </form>
                                                    
                                                    <form action="{{ route('pinjam-inventaris.update-status', $pinjam->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="2">
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menolak peminjaman ini?')">
                                                            <i class="fa fa-times"></i> Tolak
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center mt-3">
                            {{ $pending->links() }}
                        </div>
                    @else
                        <div class="alert alert-info text-center">
                            Tidak ada pengajuan peminjaman yang menunggu persetujuan.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection