@extends('mahasiswa.layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="text-primary mb-0 fw-bold">
                    <i class="fa fa-info-circle me-2"></i>Detail Peminjaman Ruangan
                </h4>
                <a href="{{ route('mahasiswa.peminjaman.pinjam-ruangan.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="fa fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light py-3">
                    <h5 class="mb-0 fw-bold">Informasi Ruangan</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive mb-4">
                        <table class="table table-hover border">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Ruangan</th>
                                    <th>Kapasitas</th>
                                    <th>Lokasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($relatedRooms as $index => $room)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="fw-medium">{{ $room->ruangan->nama_ruangan }}</td>
                                        <td>{{ $room->ruangan->kapasitas }} orang</td>
                                        <td>{{ $room->ruangan->lokasi }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="row">
                        @foreach($relatedRooms as $room)
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 border shadow-sm">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">{{ $room->ruangan->nama_ruangan }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            @if($room->ruangan->gambar)
                                                <img src="{{ asset('storage/katalog_ruangan/'.$room->ruangan->gambar) }}" 
                                                    class="img-fluid rounded w-100" style="height: 200px; object-fit: cover;" 
                                                    alt="{{ $room->ruangan->nama_ruangan }}">
                                            @else
                                                <div class="bg-light rounded text-center py-5">
                                                    <i class="fa fa-building-o text-muted" style="font-size: 3rem;"></i>
                                                    <p class="text-muted mt-2">Tidak ada gambar</p>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-4 text-muted">Kapasitas</div>
                                            <div class="col-md-8 fw-medium">{{ $room->ruangan->kapasitas }} orang</div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-4 text-muted">Lokasi</div>
                                            <div class="col-md-8 fw-medium">{{ $room->ruangan->lokasi }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 text-muted">Fasilitas</div>
                                            <div class="col-md-8">{{ $room->ruangan->fasilitas }}</div>
                                        </div>
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
                            @if($pinjamRuangan->status == 0)
                                <span class="badge bg-warning text-dark">Menunggu Persetujuan</span>
                            @elseif($pinjamRuangan->status == 1)
                                <span class="badge bg-success">Disetujui</span>
                            @elseif($pinjamRuangan->status == 2)
                                <span class="badge bg-danger">Ditolak</span>
                            @elseif($pinjamRuangan->status == 3)
                                <span class="badge bg-info">Selesai</span>
                            @else
                                <span class="badge bg-secondary">Dibatalkan</span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Tanggal Pengajuan</div>
                        <div class="col-md-8">{{ \Carbon\Carbon::parse($pinjamRuangan->tanggal_pengajuan)->format('d F Y') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Tanggal Selesai</div>
                        <div class="col-md-8">{{ \Carbon\Carbon::parse($pinjamRuangan->tanggal_selesai)->format('d F Y') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Waktu</div>
                        <div class="col-md-8">
                            {{ \Carbon\Carbon::parse($pinjamRuangan->waktu_mulai)->format('H:i') }} - 
                            {{ \Carbon\Carbon::parse($pinjamRuangan->waktu_selesai)->format('H:i') }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Tujuan Peminjaman</div>
                        <div class="col-md-8">{{ $pinjamRuangan->tujuan_peminjaman }}</div>
                    </div>
                    @if($pinjamRuangan->file_scan)
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">File Scan</div>
                        <div class="col-md-8">
                            <a href="{{ asset('storage/uploads/file_scan/'.$pinjamRuangan->file_scan) }}" 
                               class="btn btn-sm btn-outline-primary" target="_blank">
                                <i class="fa fa-file-pdf-o me-1"></i> Lihat Dokumen
                            </a>
                        </div>
                    </div>
                    @endif
                    
                    @if($pinjamRuangan->catatan)
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Catatan Admin</div>
                        <div class="col-md-8">
                            <div class="alert alert-light">{{ $pinjamRuangan->catatan }}</div>
                        </div>
                    </div>
                    @endif
                    
                    @if($pinjamRuangan->status == 0)
                    <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                        <a href="{{ route('mahasiswa.peminjaman.pinjam-ruangan.edit', $pinjamRuangan->id) }}" 
                           class="btn btn-success me-2">
                            <i class="fa fa-edit me-1"></i> Edit
                        </a>
                        <form action="{{ route('mahasiswa.peminjaman.pinjam-ruangan.cancel', $pinjamRuangan->id) }}" 
                              method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan peminjaman ini?')">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-danger">
                                <i class="fa fa-times me-1"></i> Batalkan
                            </button>
                        </form>
                    </div>
                    @endif
                    
                    @if($pinjamRuangan->status == 1)
                    @php
                        $existingReport = \App\Models\Pelaporan::where('id_mahasiswa', Session::get('mahasiswa_id'))
                            ->where('datetime', '>=', \Carbon\Carbon::parse($pinjamRuangan->updated_at)->format('Y-m-d'))
                            ->exists();
                    @endphp
                    
                    @if(!$existingReport)
                    <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                        <a href="{{ route('mahasiswa.pelaporan.lapor_ruangan.create', ['id' => $pinjamRuangan->id]) }}" 
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
@endsection