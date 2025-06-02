@extends('mahasiswa.layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="text-primary mb-0 fw-bold">
                            <i class="fa fa-file-text me-2"></i>Pengajuan Peminjaman Ruangan
                        </h4>
                        <a href="{{ route('mahasiswa.cart.keranjang_ruangan.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
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
                            <i class="fa fa-list-alt me-2"></i>Daftar Ruangan
                        </h5>
                        <div class="table-responsive">
                            <table class="table table-hover border">
                                <thead class="table-light">
                                    <tr>
                                        <th class="py-3">No</th>
                                        <th class="py-3">Nama Ruangan</th>
                                        
                                        <th class="py-3">Lokasi</th>
                                        <th class="py-3">Tanggal</th>
                                        <th class="py-3">Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cartItems as $id => $item)
                                        <tr class="align-middle">
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="fw-medium">{{ $item['nama_ruangan'] }}</td>
                                            <td>{{ $item['lokasi'] }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item['tanggal_booking'])->format('d M Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item['waktu_mulai'])->format('H:i') }} - {{ \Carbon\Carbon::parse($item['waktu_selesai'])->format('H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mt-5">
                        <form action="{{ route('mahasiswa.peminjaman.pinjam-ruangan.store') }}" method="POST" enctype="multipart/form-data" id="bookingForm">
                            @csrf
                            @foreach($cartItems as $id => $item)
                                <input type="hidden" name="ruangan_ids[]" value="{{ $id }}">
                            @endforeach
                            <input type="hidden" name="tanggal_pengajuan" value="{{ reset($cartItems)['tanggal_booking'] }}">
                            <input type="hidden" name="tanggal_selesai" value="{{ reset($cartItems)['tanggal_booking'] }}">
                            <input type="hidden" name="waktu_mulai" value="{{ reset($cartItems)['waktu_mulai'] }}">
                            <input type="hidden" name="waktu_selesai" value="{{ reset($cartItems)['waktu_selesai'] }}">
                            
                            <div class="form-group mb-4">
                                <label for="tujuan_peminjaman" class="form-label fw-medium">Tujuan Peminjaman</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fa fa-info-circle text-primary"></i>
                                    </span>
                                    <textarea class="form-control @error('tujuan_peminjaman') is-invalid @enderror border-start-0" 
                                        id="tujuan_peminjaman" name="tujuan_peminjaman" rows="3" required>{{ old('tujuan_peminjaman') }}</textarea>
                                </div>
                                @error('tujuan_peminjaman')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group mb-5">
                                <label for="file_scan" class="form-label fw-medium">File Scan (Opsional)</label>
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
                                <button type="submit" class="btn btn-success rounded-pill px-5" id="submitBtn" onclick="showLoading()">
                                    <i class="fa fa-paper-plane me-2"></i> Ajukan Peminjaman Ruangan
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
<!-- <script>
function showLoading() {
    const btn = document.getElementById('submitBtn');
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Memproses...';
    btn.disabled = true;
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('bookingForm');
    form.addEventListener('submit', function(event) {
        if (!this.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            showLoading();
        }
        this.classList.add('was-validated');
    });
});
</script> -->
@endsection