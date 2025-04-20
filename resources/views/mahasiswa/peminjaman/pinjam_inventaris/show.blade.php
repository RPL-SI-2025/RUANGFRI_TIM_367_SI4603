
@extends('mahasiswa.layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Detail Peminjaman Inventaris</h2>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4"><strong>Tanggal Pengajuan:</strong></div>
                <div class="col-md-8">{{ \Carbon\Carbon::parse($pinjamInventaris->tanggal_pengajuan)->format('d-m-Y') }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><strong>Tanggal Selesai:</strong></div>
                <div class="col-md-8">{{ \Carbon\Carbon::parse($pinjamInventaris->tanggal_selesai)->format('d-m-Y') }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><strong>Waktu Mulai:</strong></div>
                <div class="col-md-8">{{ $pinjamInventaris->waktu_mulai }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><strong>Waktu Selesai:</strong></div>
                <div class="col-md-8">{{ $pinjamInventaris->waktu_selesai }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><strong>Status:</strong></div>
                <div class="col-md-8">
                    @if($pinjamInventaris->status == 0)
                        <span class="badge bg-warning">Menunggu Persetujuan</span>
                    @elseif($pinjamInventaris->status == 1)
                        <span class="badge bg-success">Disetujui</span>
                    @elseif($pinjamInventaris->status == 2)
                        <span class="badge bg-danger">Ditolak</span>
                    @endif
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-4"><strong>File Scan:</strong></div>
                <div class="col-md-8">
                    @if($pinjamInventaris->file_scan)
                        <a href="{{ asset('storage/uploads/file_scan/' . $pinjamInventaris->file_scan) }}" target="_blank" class="btn btn-sm btn-primary">Lihat File</a>
                    @else
                        <span class="text-muted">Tidak ada file</span>
                    @endif
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-4"><strong>Inventaris yang Dipinjam:</strong></div>
                <div class="col-md-8">
                    @php
                        // Find related inventory items from the same request
                        $relatedItems = \App\Models\PinjamInventaris::where('tanggal_pengajuan', $pinjamInventaris->tanggal_pengajuan)
                            ->where('tanggal_selesai', $pinjamInventaris->tanggal_selesai)
                            ->where('waktu_mulai', $pinjamInventaris->waktu_mulai)
                            ->where('waktu_selesai', $pinjamInventaris->waktu_selesai)
                            ->where('file_scan', $pinjamInventaris->file_scan)
                            ->where('id_mahasiswa', $pinjamInventaris->id_mahasiswa)
                            ->get();
                    @endphp
                    
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
                                    <td>{{ $item->jumlah_pinjam ?? '1' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            @if($pinjamInventaris->status == 0)
                <div class="mt-4">
                    <a href="{{ route('mahasiswa.peminjaman.pinjam-inventaris.edit', $pinjamInventaris->id) }}" class="btn btn-warning">Edit Peminjaman</a>
                    <form action="{{ route('pinjam-inventaris.destroy', $pinjamInventaris->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan peminjaman ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Batalkan Peminjaman</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
    
    <div class="mt-3">
        <a href="{{ route('mahasiswa.peminjaman.pinjam-inventaris.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection