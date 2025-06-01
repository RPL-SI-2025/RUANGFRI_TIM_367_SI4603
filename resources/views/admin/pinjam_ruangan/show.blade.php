@extends('admin.layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Detail Peminjaman Ruangan</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.pinjam-ruangan.index') }}">Peminjaman Ruangan</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="mdi mdi-check-all me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="mdi mdi-block-helper me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Detail Peminjaman -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="m-0 font-weight-bold text-primary">Informasi Peminjaman</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label text-muted">Nama Mahasiswa</label>
                        <div class="col-sm-8">
                            <p class="form-control-plaintext">{{ $pinjamRuangan->mahasiswa->nama_mahasiswa ?? 'Tidak ada data' }}</p>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label text-muted">NIM</label>
                        <div class="col-sm-8">
                            <p class="form-control-plaintext">{{ $pinjamRuangan->mahasiswa->nim ?? 'Tidak ada data' }}</p>
                        </div>
                    </div>
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
                </div>
                <div class="col-lg-6">
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
                                    0 => 'warning',
                                    1 => 'success', 
                                    2 => 'danger',
                                    3 => 'info',
                                    default => 'secondary'
                                };
                                $statusText = match($pinjamRuangan->status) {
                                    0 => 'Menunggu Persetujuan',
                                    1 => 'Disetujui',
                                    2 => 'Ditolak', 
                                    3 => 'Selesai',
                                    default => 'Tidak Diketahui'
                                };
                            @endphp
                            <span class="badge bg-{{ $statusClass }} fs-6">{{ $statusText }}</span>
                        </div>
                    </div>
                    @if($pinjamRuangan->file_scan)
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label text-muted">File Scan</label>
                        <div class="col-sm-8">
                            <a href="{{ asset('storage/uploads/file_scan/' . $pinjamRuangan->file_scan) }}" 
                               class="btn btn-sm btn-outline-primary" target="_blank">
                                <i class="bi bi-file-earmark-pdf"></i> Lihat File
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Ruangan -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="m-0 font-weight-bold text-primary">Daftar Ruangan yang Dipinjam</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
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
                        @php
                            $relatedItems = \App\Models\PinjamRuangan::where('tanggal_pengajuan', $pinjamRuangan->tanggal_pengajuan)
                                ->where('tanggal_selesai', $pinjamRuangan->tanggal_selesai)
                                ->where('waktu_mulai', $pinjamRuangan->waktu_mulai)
                                ->where('waktu_selesai', $pinjamRuangan->waktu_selesai)
                                ->where('file_scan', $pinjamRuangan->file_scan)
                                ->where('id_mahasiswa', $pinjamRuangan->id_mahasiswa)
                                ->with('ruangan')
                                ->get();
                        @endphp
                        @foreach($relatedItems as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->ruangan->nama_ruangan ?? 'Tidak ada data' }}</td>
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

    <!-- Informasi Tambahan -->
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
            @if($pinjamRuangan->catatan)
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label text-muted">Catatan Admin</label>
                <div class="col-sm-9">
                    <div class="alert alert-light border">
                        {{ $pinjamRuangan->catatan }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Aksi Peminjaman -->
    @if($pinjamRuangan->status == 0)
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="m-0 font-weight-bold text-primary">Aksi Peminjaman</h5>
        </div>
        <div class="card-body">
            <div class="d-flex gap-2">
                <form action="{{ route('admin.pinjam-ruangan.update-status', $pinjamRuangan->id) }}" method="POST" class="me-2">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="1">
                    <button type="submit" class="btn btn-success" onclick="return confirm('Apakah Anda yakin ingin menyetujui peminjaman ini?')">
                        <i class="bi bi-check-circle"></i> Setujui Peminjaman
                    </button>
                </form>

                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#tolakModal">
                    <i class="bi bi-x-circle"></i> Tolak Peminjaman
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Modal Edit Catatan (jika sudah ditolak) -->
    @if($pinjamRuangan->status == 2 && $pinjamRuangan->catatan)
    <div class="card shadow-sm mt-4">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-danger">
                <i class="bi bi-exclamation-triangle me-2"></i>Catatan Penolakan
            </h5>
            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editCatatanModal">
                <i class="bi bi-pencil"></i> Edit Catatan
            </button>
        </div>
        <div class="card-body">
            <div class="alert alert-light border">
                <p class="mb-0">{{ $pinjamRuangan->catatan }}</p>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Modal Tolak Peminjaman -->
<div class="modal fade" id="tolakModal" tabindex="-1" aria-labelledby="tolakModalLabel" aria-hidden="true" data-bs-backdrop="static" style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="tolakModalLabel">
                    <i class="bi bi-exclamation-triangle me-2"></i>Tolak Peminjaman Ruangan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.pinjam-ruangan.update-status', $pinjamRuangan->id) }}" method="POST" id="tolakForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="2">
                
                <div class="modal-body">
                    <div class="alert alert-warning border-0">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Perhatian:</strong> Peminjaman ini akan ditolak dan mahasiswa akan menerima notifikasi beserta catatan Anda.
                    </div>
                    
                    <div class="mb-3">
                        <label for="catatan" class="form-label fw-bold">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="catatan" name="catatan" rows="4" 
                            placeholder="Berikan alasan yang jelas mengapa peminjaman ini ditolak..." required></textarea>
                        <div class="form-text">Contoh: Ruangan sedang dalam renovasi, jadwal bentrok, dokumen tidak lengkap, dll.</div>
                        <div class="invalid-feedback" id="catatanError"></div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-danger" id="tolakSubmitBtn">
                        <i class="bi bi-x-circle me-1"></i>Tolak Peminjaman
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Catatan -->
@if($pinjamRuangan->status == 2 && $pinjamRuangan->catatan)
<div class="modal fade" id="editCatatanModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.pinjam-ruangan.update-notes', $pinjamRuangan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-pencil me-2"></i>Edit Catatan Penolakan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editCatatan" class="form-label fw-bold">Catatan</label>
                        <textarea class="form-control" id="editCatatan" name="catatan" rows="4">{{ $pinjamRuangan->catatan }}</textarea>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@push('styles')
<style>
  
.modal {
    z-index: 1060 !important;
}

.modal-backdrop {
    z-index: 1055 !important;
}

.modal-dialog {
    pointer-events: auto;
}

.modal-header.bg-danger .btn-close-white {
    filter: invert(1) grayscale(100%) brightness(200%);
}

  
@media (max-width: 576px) {
    .modal-dialog {
        margin: 0.5rem;
        max-width: calc(100% - 1rem);
    }
}

  
.is-invalid {
    border-color: #dc3545;
}

.invalid-feedback {
    display: block;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    const tolakModal = document.getElementById('tolakModal');
    const editCatatanModal = document.getElementById('editCatatanModal');
    const tolakForm = document.getElementById('tolakForm');
    
    
    if (tolakModal) {
        tolakModal.addEventListener('show.bs.modal', function (event) {
            
            if (tolakForm) {
                tolakForm.reset();
                
                const inputs = tolakForm.querySelectorAll('.is-invalid');
                inputs.forEach(input => {
                    input.classList.remove('is-invalid');
                });
                const errors = tolakForm.querySelectorAll('.invalid-feedback');
                errors.forEach(error => {
                    error.style.display = 'none';
                });
            }
        });
        
        tolakModal.addEventListener('shown.bs.modal', function (event) {
            
            const textarea = tolakModal.querySelector('#catatan');
            if (textarea) {
                textarea.focus();
            }
        });
    }
    
    if (editCatatanModal) {
        editCatatanModal.addEventListener('shown.bs.modal', function (event) {
            const textarea = editCatatanModal.querySelector('#editCatatan');
            if (textarea) {
                textarea.focus();
                
                textarea.setSelectionRange(textarea.value.length, textarea.value.length);
            }
        });
    }
    
    
    if (tolakForm) {
        tolakForm.addEventListener('submit', function(e) {
            const catatan = document.getElementById('catatan');
            const catatanError = document.getElementById('catatanError');
            
            
            catatan.classList.remove('is-invalid');
            catatanError.style.display = 'none';
            
            
            if (!catatan.value.trim()) {
                e.preventDefault();
                catatan.classList.add('is-invalid');
                catatanError.textContent = 'Catatan penolakan wajib diisi.';
                catatanError.style.display = 'block';
                catatan.focus();
                return false;
            }
            
            if (catatan.value.trim().length < 10) {
                e.preventDefault();
                catatan.classList.add('is-invalid');
                catatanError.textContent = 'Catatan penolakan minimal 10 karakter.';
                catatanError.style.display = 'block';
                catatan.focus();
                return false;
            }
            
            
            const submitBtn = document.getElementById('tolakSubmitBtn');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status"></span>Memproses...';
            }
        });
    }
    
    
    const textareas = document.querySelectorAll('textarea');
    textareas.forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });
    });
});
</script>
@endpush
@endsection