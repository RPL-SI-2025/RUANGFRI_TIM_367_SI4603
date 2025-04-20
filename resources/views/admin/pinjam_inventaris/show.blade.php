@extends('admin.layouts.admin')

@section('content')
<div class="container">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Detail Peminjaman Inventaris</h6>
            <a href="{{ route('admin.pinjam-inventaris.index') }}" class="btn btn-sm btn-secondary">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Status</div>
                <div class="col-md-8">
                    @php
                        $badgeClass = match($pinjamInventaris->status) {
                            0 => 'bg-warning',
                            1 => 'bg-success',
                            2 => 'bg-danger',
                            3 => 'bg-info',
                            default => 'bg-secondary'
                        };
                        $statusText = match($pinjamInventaris->status) {
                            0 => 'Menunggu Persetujuan',
                            1 => 'Disetujui',
                            2 => 'Ditolak',
                            3 => 'Selesai',
                            default => 'Tidak Diketahui'
                        };
                    @endphp
                    <span class="badge {{ $badgeClass }}">{{ $statusText }}</span>
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Peminjam</div>
                <div class="col-md-8">{{ $pinjamInventaris->mahasiswa->nama_mahasiswa?? 'Tidak ditemukan' }} ({{ $pinjamInventaris->mahasiswa->nim ?? 'N/A' }})</div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Tanggal Pengajuan</div>
                <div class="col-md-8">{{ \Carbon\Carbon::parse($pinjamInventaris->tanggal_pengajuan)->format('d-m-Y') }}</div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Tanggal Selesai</div>
                <div class="col-md-8">{{ \Carbon\Carbon::parse($pinjamInventaris->tanggal_selesai)->format('d-m-Y') }}</div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Waktu</div>
                <div class="col-md-8">
                    {{ \Carbon\Carbon::parse($pinjamInventaris->waktu_mulai)->format('H:i') }} - 
                    {{ \Carbon\Carbon::parse($pinjamInventaris->waktu_selesai)->format('H:i') }}
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-4 fw-bold">File Scan</div>
                <div class="col-md-8">
                    @if($pinjamInventaris->file_scan)
                        <a href="{{ asset('storage/uploads/file_scan/' . $pinjamInventaris->file_scan) }}" 
                           target="_blank" class="btn btn-sm btn-primary">
                            <i class="fa fa-file"></i> Lihat File
                        </a>
                    @else
                        <span class="text-muted">Tidak ada file</span>
                    @endif
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Inventaris yang Dipinjam</div>
                <div class="col-md-8">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Inventaris</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($relatedItems as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->inventaris->nama_inventaris ?? 'Inventaris tidak ditemukan' }}</td>
                                        <td>{{ $item->jumlah_pinjam }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            @if($pinjamInventaris->status == 0)
                <div class="d-flex gap-2 mt-4">
                    <form action="{{ route('pinjam-inventaris.update-status', $pinjamInventaris->id) }}" method="POST" class="me-2">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="1">
                        <button type="submit" class="btn btn-success" onclick="return confirm('Apakah Anda yakin ingin menyetujui peminjaman ini?')">
                            <i class="fa fa-check"></i> Setujui Peminjaman
                        </button>
                    </form>
                    
                    <form action="{{ route('pinjam-inventaris.update-status', $pinjamInventaris->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="2">
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menolak peminjaman ini?')">
                            <i class="fa fa-times"></i> Tolak Peminjaman
                        </button>
                    </form>
                </div>
            @endif

            @if($pinjamInventaris->status == 1)
                <div class="border-top pt-3 mt-4">
                    <form action="{{ route('pinjam-inventaris.update-status', $pinjamInventaris->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="3">
                        <button type="submit" class="btn btn-info" onclick="return confirm('Apakah Anda yakin peminjaman ini telah selesai?')">
                            <i class="fa fa-check-circle"></i> Tandai Selesai
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection