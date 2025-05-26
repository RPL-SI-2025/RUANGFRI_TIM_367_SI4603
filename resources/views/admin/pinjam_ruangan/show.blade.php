
@extends('admin.layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Detail Peminjaman Ruangan</h2>
        <a href="{{ route('admin.pinjam-ruangan.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="m-0 font-weight-bold text-primary">Informasi Mahasiswa</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label text-muted">Nama Mahasiswa</label>
                        <div class="col-sm-8">
                            <p class="form-control-plaintext fw-medium">{{ $pinjamRuangan->mahasiswa->nama_mahasiswa ?? 'Tidak ada data' }}</p>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label text-muted">NPM</label>
                        <div class="col-sm-8">
                            <p class="form-control-plaintext">{{ $pinjamRuangan->mahasiswa->npm ?? 'Tidak ada data' }}</p>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label text-muted">Program Studi</label>
                        <div class="col-sm-8">
                            <p class="form-control-plaintext">{{ $pinjamRuangan->mahasiswa->prodi ?? 'Tidak ada data' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="m-0 font-weight-bold text-primary">Detail Peminjaman</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label text-muted">Tanggal Pengajuan</label>
                        <div class="col-sm-8">
                            <p class="form-control-plaintext">{{ \Carbon\Carbon::parse($pinjamRuangan->tanggal_pengajuan)->format('d F Y') }}</p>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label text-muted">Tanggal Selesai</label>
                        <div class="col-sm-8">
                            <p class="form-control-plaintext">{{ \Carbon\Carbon::parse($pinjamRuangan->tanggal_selesai)->format('d F Y') }}</p>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label text-muted">Waktu</label>
                        <div class="col-sm-8">
                            <p class="form-control-plaintext">
                                {{ \Carbon\Carbon::parse($pinjamRuangan->waktu_mulai)->format('H:i') }} - 
                                {{ \Carbon\Carbon::parse($pinjamRuangan->waktu_selesai)->format('H:i') }}
                            </p>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label text-muted">Status</label>
                        <div class="col-sm-8">
                            @php
                                $statusClass = match($pinjamRuangan->status) {
                                    0 => 'warning text-dark',
                                    1 => 'success',
                                    2 => 'danger',
                                    3 => 'info',
                                    4 => 'secondary',
                                    default => 'secondary'
                                };
                                $statusText = match($pinjamRuangan->status) {
                                    0 => 'Menunggu Persetujuan',
                                    1 => 'Disetujui',
                                    2 => 'Ditolak',
                                    3 => 'Selesai',
                                    4 => 'Dibatalkan',
                                    default => 'Tidak Diketahui'
                                };
                            @endphp
                            <span class="badge bg-{{ $statusClass }}">{{ $statusText }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="m-0 font-weight-bold text-primary">Daftar Ruangan yang Dipinjam</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Ruangan</th>
                            <th>Kapasitas</th>
                            <th>Lokasi</th>
                            <th>Fasilitas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($relatedItems as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="fw-medium">{{ $item->ruangan->nama_ruangan ?? 'Tidak ada data' }}</td>
                                <td>{{ $item->ruangan->kapasitas ?? 'Tidak ada data' }} orang</td>
                                <td>{{ $item->ruangan->lokasi ?? 'Tidak ada data' }}</td>
                                <td>{{ Str::limit($item->ruangan->fasilitas ?? 'Tidak ada data', 50) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="m-0 font-weight-bold text-primary">Informasi Tambahan</h5>
        </div>
        <div class="card-body">
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label text-muted">Tujuan Peminjaman</label>
                <div class="col-sm-9">
                    <p class="form-control-plaintext">{{ $pinjamRuangan->tujuan_peminjaman ?? 'Tidak ada data' }}</p>
                </div>
            </div>
            @if($pinjamRuangan->file_scan)
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label text-muted">File Pendukung</label>
                <div class="col-sm-9">
                    <a href="{{ asset('storage/uploads/file_scan/' . $pinjamRuangan->file_scan) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                        <i class="bi bi-file-earmark-pdf"></i> Lihat File
                    </a>
                </div>
            </div>
            @endif
            @if($pinjamRuangan->catatan)
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label text-muted">catatan</label>
                <div class="col-sm-9">
                    <p class="form-control-plaintext">{{ $pinjamRuangan->catatan }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>

    @if($pinjamRuangan->status == 0)
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="m-0 font-weight-bold text-primary">Perbarui Status</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('pinjam-ruangan.update-status', $pinjamRuangan->id) }}" method="POST" class="d-flex">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="1">
                <button type="submit" class="btn btn-success me-2" onclick="return confirm('Setujui peminjaman ruangan ini?')">
                    <i class="bi bi-check-circle"></i> Setujui
                </button>
            </form>
            
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#tolakModal">
                <i class="bi bi-x-circle"></i> Tolak
            </button>
            
            <!-- Modal Tolak -->
            <div class="modal fade" id="tolakModal" tabindex="-1" aria-labelledby="tolakModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tolakModalLabel">Tolak Peminjaman Ruangan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('pinjam-ruangan.update-status', $pinjamRuangan->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <input type="hidden" name="status" value="2">
                                <div class="mb-3">
                                    <label for="catatan" class="form-label">Alasan Penolakan</label>
                                    <textarea class="form-control" id="catatan" name="catatan" rows="3" required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-danger">Tolak Peminjaman</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection