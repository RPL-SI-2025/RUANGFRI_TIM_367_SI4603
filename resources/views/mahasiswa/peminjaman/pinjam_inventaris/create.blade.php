@extends('mahasiswa.layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="text-primary mb-0 fw-bold">
                            <i class="fa fa-file-text me-2"></i>Pengajuan Peminjaman
                        </h4>
                        <a href="{{ route('mahasiswa.cart.keranjang_inventaris.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                            <i class="fa fa-arrow-left me-1"></i> Kembali ke Keranjang
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
                            <i class="fa fa-list-alt me-2"></i>Daftar Item
                        </h5>
                        <div class="table-responsive">
                            <table class="table table-hover border">
                                <thead class="table-light">
                                    <tr>
                                        <th class="py-3">No</th>
                                        <th class="py-3">Nama Inventaris</th>
                                        <th class="py-3">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cartItems as $id => $item)
                                        <tr class="align-middle">
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="fw-medium">{{ $item['nama_inventaris'] }}</td>
                                            <td>{{ $item['jumlah'] }}</td>
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
                        
                        <form action="{{ route('mahasiswa.peminjaman.pinjam-inventaris.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="tanggal_pengajuan" class="form-label fw-medium">Tanggal Pengajuan</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fa fa-calendar-check-o text-primary"></i>
                                            </span>
                                            <input type="date" class="form-control @error('tanggal_pengajuan') is-invalid @enderror border-start-0" 
                                                id="tanggal_pengajuan" name="tanggal_pengajuan" value="{{ old('tanggal_pengajuan', date('Y-m-d')) }}" required>
                                        </div>
                                        @error('tanggal_pengajuan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="tanggal_selesai" class="form-label fw-medium">Tanggal Selesai</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fa fa-calendar-times-o text-primary"></i>
                                            </span>
                                            <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror border-start-0" 
                                                id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" required>
                                        </div>
                                        @error('tanggal_selesai')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="waktu_mulai" class="form-label fw-medium">Waktu Mulai</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fa fa-clock-o text-primary"></i>
                                            </span>
                                            <input type="time" class="form-control @error('waktu_mulai') is-invalid @enderror border-start-0" 
                                                id="waktu_mulai" name="waktu_mulai" value="{{ old('waktu_mulai') }}" required>
                                        </div>
                                        @error('waktu_mulai')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="waktu_selesai" class="form-label fw-medium">Waktu Selesai</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fa fa-clock-o text-primary"></i>
                                            </span>
                                            <input type="time" class="form-control @error('waktu_selesai') is-invalid @enderror border-start-0" 
                                                id="waktu_selesai" name="waktu_selesai" value="{{ old('waktu_selesai') }}" required>
                                        </div>
                                        @error('waktu_selesai')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-5">
                                <label for="file_scan" class="form-label fw-medium">File Scan </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fa fa-file-pdf-o text-primary"></i>
                                    </span>
                                    <input type="file" class="form-control @error('file_scan') is-invalid @enderror border-start-0" 
                                        id="file_scan" name="file_scan">
                                </div>
                                <small class="form-text text-muted mt-1">
                                    Upload surat permohonan atau dokumen pendukung (PDF, JPG, PNG, max 2MB)
                                </small>
                                @error('file_scan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end mt-5 pt-3 border-top">
                                <button type="submit" class="btn btn-success rounded-pill px-5">
                                    <i class="fa fa-paper-plane me-2"></i> Ajukan Peminjaman
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
}
.form-control {
    border-radius: 0 0.375rem 0.375rem 0;
}
.table th, .table td {
    vertical-align: middle;
}
.card {
    transition: all 0.3s ease;
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
</style>
@endsection