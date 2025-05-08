@extends('mahasiswa.layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="text-primary mb-0 fw-bold">
                            <i class="fa fa-edit me-2"></i>Edit Pengajuan Peminjaman Ruangan
                        </h4>
                        <a href="{{ route('mahasiswa.peminjaman.pinjam-ruangan.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                            <i class="fa fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body px-4">
                    @if (session('error'))
                        <div class="alert alert-danger border-0 shadow-sm">
                            <i class="fa fa-exclamation-circle me-2"></i>{{ session('error') }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <h5 class="text-secondary fw-bold mb-3">
                            <i class="fa fa-list-alt me-2"></i>Daftar Ruangan
                        </h5>
                        <div class="table-responsive">
                            <table class="table table-hover border">
                                <thead class="table-light">
                                    <tr>
                                        <th class="py-3">No</th>
                                        <th class="py-3">Nama Ruangan</th>
                                        <th class="py-3">Kapasitas</th>
                                        <th class="py-3">Lokasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($relatedBookings as $booking)
                                        <tr class="align-middle">
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="fw-medium">{{ $booking->ruangan->nama_ruangan }}</td>
                                            <td>{{ $booking->ruangan->kapasitas }} orang</td>
                                            <td>{{ $booking->ruangan->lokasi }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h5 class="text-secondary fw-bold mb-4">
                            <i class="fa fa-calendar me-2"></i>Informasi Pengajuan
                        </h5>
                        
                        <form action="{{ route('pinjam-ruangan.update', $pinjamRuangan->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="card mb-4 border shadow-sm">
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="tanggal_pengajuan" class="form-label fw-bold">Tanggal Pengajuan</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light border-end-0">
                                                        <i class="fa fa-calendar-check-o text-primary"></i>
                                                    </span>
                                                    <input type="date" class="form-control @error('tanggal_pengajuan') is-invalid @enderror border-start-0" 
                                                        id="tanggal_pengajuan" name="tanggal_pengajuan" value="{{ old('tanggal_pengajuan', $pinjamRuangan->tanggal_pengajuan) }}" required>
                                                </div>
                                                @error('tanggal_pengajuan')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="tanggal_selesai" class="form-label fw-bold">Tanggal Selesai</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light border-end-0">
                                                        <i class="fa fa-calendar-times-o text-primary"></i>
                                                    </span>
                                                    <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror border-start-0" 
                                                        id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai', $pinjamRuangan->tanggal_selesai) }}" required>
                                                </div>
                                                @error('tanggal_selesai')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="waktu_mulai" class="form-label fw-bold">Waktu Mulai</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light border-end-0">
                                                        <i class="fa fa-clock-o text-primary"></i>
                                                    </span>
                                                    <input type="time" class="form-control @error('waktu_mulai') is-invalid @enderror border-start-0" 
                                                        id="waktu_mulai" name="waktu_mulai" value="{{ old('waktu_mulai', $pinjamRuangan->waktu_mulai) }}" required>
                                                </div>
                                                @error('waktu_mulai')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="waktu_selesai" class="form-label fw-bold">Waktu Selesai</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light border-end-0">
                                                        <i class="fa fa-clock-o text-primary"></i>
                                                    </span>
                                                    <input type="time" class="form-control @error('waktu_selesai') is-invalid @enderror border-start-0" 
                                                        id="waktu_selesai" name="waktu_selesai" value="{{ old('waktu_selesai', $pinjamRuangan->waktu_selesai) }}" required>
                                                </div>
                                                @error('waktu_selesai')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="tujuan_peminjaman" class="form-label fw-bold">Tujuan Peminjaman</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fa fa-info-circle text-primary"></i>
                                            </span>
                                            <textarea class="form-control @error('tujuan_peminjaman') is-invalid @enderror border-start-0" 
                                                id="tujuan_peminjaman" name="tujuan_peminjaman" rows="3" required>{{ old('tujuan_peminjaman', $pinjamRuangan->tujuan_peminjaman) }}</textarea>
                                        </div>
                                        <small class="form-text text-muted">Jelaskan tujuan peminjaman ruangan dengan jelas</small>
                                        @error('tujuan_peminjaman')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-4 border shadow-sm">
                                <div class="card-header bg-light py-3">
                                    <h6 class="mb-0 fw-bold">Dokumen Pendukung</h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="file_scan" class="form-label fw-bold">File Scan</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fa fa-file-pdf-o text-primary"></i>
                                            </span>
                                            <input type="file" class="form-control @error('file_scan') is-invalid @enderror border-start-0" 
                                                id="file_scan" name="file_scan">
                                        </div>
                                        <small class="form-text text-muted mt-1">
                                            Upload surat permohonan atau dokumen pendukung baru (PDF, JPG, PNG, max 2MB)
                                        </small>
                                        @if($pinjamRuangan->file_scan)
                                        <div class="mt-3">
                                            <a href="{{ asset('storage/uploads/file_scan/' . $pinjamRuangan->file_scan) }}" 
                                            class="btn btn-sm btn-outline-info" target="_blank">
                                                <i class="fa fa-file-o me-1"></i> Lihat file saat ini
                                            </a>
                                            <small class="d-block text-muted mt-1">Biarkan kosong jika tidak ingin mengubah file</small>
                                        </div>
                                        @endif
                                        @error('file_scan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                                <a href="{{ route('mahasiswa.peminjaman.pinjam-ruangan.show', $pinjamRuangan->id) }}" class="btn btn-secondary">
                                    <i class="fa fa-times me-1"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-success px-5">
                                    <i class="fa fa-save me-2"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.input-group-text {
    border-radius: 0.375rem 0 0 0.375rem;
    background-color: #f8f9fa;
}
.form-control, .form-select {
    border-radius: 0 0.375rem 0.375rem 0;
}
.card {
    transition: all 0.3s ease;
    border-radius: 0.5rem;
    overflow: hidden;
}
.card-header {
    background-color: rgba(0,0,0,0.03);
}
.btn {
    font-weight: 500;
    transition: all 0.3s ease;
}
.btn-success {
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
}
.form-label {
    margin-bottom: 0.5rem;
    color: #444;
}
.table th, .table td {
    vertical-align: middle;
}
</style>
@endsection