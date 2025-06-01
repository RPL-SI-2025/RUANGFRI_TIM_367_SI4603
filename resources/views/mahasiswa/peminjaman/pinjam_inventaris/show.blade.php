@extends('mahasiswa.layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="text-primary mb-0 fw-bold">
                    <i class="fa fa-info-circle me-2"></i>Detail Peminjaman Inventaris
                </h4>
                <a href="{{ route('mahasiswa.peminjaman.pinjam-inventaris.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="fa fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light py-3">
                    <h5 class="mb-0 fw-bold">Informasi Inventaris</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive mb-4">
                        <table class="table table-hover border">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Inventaris</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php

                                    $relatedItems = \App\Models\PinjamInventaris::where('tanggal_pengajuan', $pinjamInventaris->tanggal_pengajuan)
                                        ->where('tanggal_selesai', $pinjamInventaris->tanggal_selesai)
                                        ->where('waktu_mulai', $pinjamInventaris->waktu_mulai)
                                        ->where('waktu_selesai', $pinjamInventaris->waktu_selesai)
                                        ->where('file_scan', $pinjamInventaris->file_scan)
                                        ->where('id_mahasiswa', $pinjamInventaris->id_mahasiswa)
                                        ->with('inventaris')
                                        ->get();
                                @endphp
                                
                                @foreach($relatedItems as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="fw-medium">{{ $item->inventaris->nama_inventaris ?? 'Inventaris tidak ditemukan' }}</td>
                                        <td>{{ $item->jumlah_pinjam }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="row">
                        @foreach($relatedItems as $item)
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 border shadow-sm">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">{{ $item->inventaris->nama_inventaris ?? 'Inventaris tidak ditemukan' }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            @if($item->inventaris && $item->inventaris->gambar_inventaris)
                                                <img src="{{ asset('storage/katalog_inventaris/'.$item->inventaris->gambar_inventaris) }}" 
                                                    class="img-fluid rounded w-100" style="height: 200px; object-fit: cover;" 
                                                    alt="{{ $item->inventaris->nama_inventaris }}">
                                            @else
                                                <div class="bg-light rounded text-center py-5">
                                                    <i class="fa fa-box text-muted" style="font-size: 3rem;"></i>
                                                    <p class="text-muted mt-2">Tidak ada gambar</p>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-4 text-muted">Jumlah</div>
                                            <div class="col-md-8 fw-medium">{{ $item->jumlah_pinjam }} unit</div>
                                        </div>
                                        @if($item->inventaris)
                                            <div class="row">
                                                <div class="col-md-4 text-muted">Deskripsi</div>
                                                <div class="col-md-8">{{ Str::limit($item->inventaris->deskripsi, 100) ?? 'Tidak ada deskripsi' }}</div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-light py-3">
                    <h5 class="mb-0 fw-bold">Informasi Peminjaman</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Status</div>
                        <div class="col-md-8">
                            @if($pinjamInventaris->status == 0)
                                <span class="badge bg-warning text-dark">Menunggu Persetujuan</span>
                            @elseif($pinjamInventaris->status == 1)
                                <span class="badge bg-success">Disetujui</span>
                            @elseif($pinjamInventaris->status == 2)
                                <span class="badge bg-danger">Ditolak</span>
                            @elseif($pinjamInventaris->status == 3)
                                <span class="badge bg-info">Selesai</span>
                            @else
                                <span class="badge bg-secondary">Dibatalkan</span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Tanggal Pengajuan</div>
                        <div class="col-md-8">{{ \Carbon\Carbon::parse($pinjamInventaris->tanggal_pengajuan)->format('d F Y') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Tanggal Selesai</div>
                        <div class="col-md-8">{{ \Carbon\Carbon::parse($pinjamInventaris->tanggal_selesai)->format('d F Y') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Waktu</div>
                        <div class="col-md-8">
                            {{ \Carbon\Carbon::parse($pinjamInventaris->waktu_mulai)->format('H:i') }} - 
                            {{ \Carbon\Carbon::parse($pinjamInventaris->waktu_selesai)->format('H:i') }}
                        </div>
                    </div>
                    @if($pinjamInventaris->file_scan)
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">File Scan</div>
                        <div class="col-md-8">
                            <a href="{{ asset('storage/uploads/file_scan/'.$pinjamInventaris->file_scan) }}" 
                               class="btn btn-sm btn-outline-primary" target="_blank">
                                <i class="fa fa-file-pdf-o me-1"></i> Lihat Dokumen
                            </a>
                        </div>
                    </div>
                    @endif
                    
                    @if($pinjamInventaris->status == 2 && $pinjamInventaris->notes)
                        <div class="card shadow-sm border-0 mt-4">
                            <div class="card-header bg-light py-3">
                                <h5 class="mb-0 fw-bold text-danger">
                                    <i class="fa fa-exclamation-circle me-2"></i>Catatan Penolakan
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-danger border-0">
                                    <p class="mb-0">{{ $pinjamInventaris->notes }}</p>
                                </div>
                                <p class="text-muted small mt-3 mb-0">
                                    <i class="fa fa-info-circle me-1"></i>
                                    Perhatikan catatan di atas untuk melakukan pengajuan peminjaman baru.
                                </p>
                            </div>
                        </div>
                    @endif
                    
                    @if($pinjamInventaris->status == 0)
                    <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                        <a href="{{ route('mahasiswa.peminjaman.pinjam-inventaris.edit', $pinjamInventaris->id) }}" 
                           class="btn btn-success me-2">
                            <i class="fa fa-edit me-1"></i> Edit
                        </a>
                        <form action="{{ route('mahasiswa.peminjaman.pinjam-inventaris.destroy', $pinjamInventaris->id) }}" 
                              method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan peminjaman ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fa fa-times me-1"></i> Batalkan
                            </button>
                        </form>
                    </div>
                    @endif
                    
                    @if($pinjamInventaris->status == 1)
                    @php
                        $existingReport = \App\Models\LaporInventaris::where('id_mahasiswa', Session::get('mahasiswa_id'))
                            ->where('datetime', '>=', \Carbon\Carbon::parse($pinjamInventaris->updated_at)->format('Y-m-d'))
                            ->exists();
                    @endphp
                    
                    @if(!$existingReport)
                    <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                        <a href="{{ route('mahasiswa.pelaporan.lapor_inventaris.create', ['id_peminjaman' => $pinjamInventaris->id]) }}" 
                        class="btn btn-warning">
                            <i class="fa fa-flag me-1"></i> Buat Laporan
                        </a>
                    </div>
                    @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection