@extends('admin.layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Detail Peminjaman Inventaris</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.pinjam-inventaris.index') }}">Peminjaman Inventaris</a></li>
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

    <!-- Informasi Peminjaman -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="m-0 font-weight-bold text-primary">Informasi Peminjaman</h5>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Nama Mahasiswa</div>
                <div class="col-md-8">{{ $pinjamInventaris->mahasiswa->nama_mahasiswa ?? 'Tidak ditemukan' }}</div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-4 fw-bold">NIM</div>
                <div class="col-md-8">{{ $pinjamInventaris->mahasiswa->nim ?? 'Tidak ditemukan' }}</div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Status</div>
                <div class="col-md-8">
                    @php
                        $statusClass = match($pinjamInventaris->status) {
                            0 => 'warning',
                            1 => 'success',
                            2 => 'danger', 
                            3 => 'info',
                            default => 'secondary'
                        };
                        $statusText = match($pinjamInventaris->status) {
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
                            <thead class="table-light">
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
        </div>
    </div>

    <!-- Aksi Peminjaman -->
    @if($pinjamInventaris->status == 0)
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="m-0 font-weight-bold text-primary">Aksi Peminjaman</h5>
        </div>
        <div class="card-body">
            <div class="d-flex gap-2">
                <form action="{{ route('admin.pinjam-inventaris.update-status', $pinjamInventaris->id) }}" method="POST" class="me-2">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="1">
                    <button type="submit" class="btn btn-success" onclick="return confirm('Apakah Anda yakin ingin menyetujui peminjaman ini?')">
                        <i class="fa fa-check"></i> Setujui Peminjaman
                    </button>
                </form>

                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                    <i class="fa fa-times"></i> Tolak Peminjaman
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Modal untuk Penolakan dengan Catatan -->
    @if($pinjamInventaris->status == 2 && $pinjamInventaris->notes)
    <div class="card shadow-sm mt-4">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-danger">
                <i class="fa fa-exclamation-circle me-2"></i>Catatan Penolakan
            </h5>
            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editNotesModal">
                <i class="fa fa-edit"></i> Edit Catatan
            </button>
        </div>
        <div class="card-body">
            <div class="alert alert-light border">
                <p class="mb-0">{{ $pinjamInventaris->notes }}</p>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Modal untuk Penolakan dengan Catatan -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true" data-bs-backdrop="static" style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.pinjam-inventaris.update-status', $pinjamInventaris->id) }}" method="POST" id="rejectForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="2">

                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="rejectModalLabel">
                        <i class="fa fa-exclamation-triangle me-2"></i>Tolak Peminjaman Inventaris
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <div class="alert alert-warning border-0">
                        <i class="fa fa-info-circle me-2"></i>
                        <strong>Perhatian:</strong> Peminjaman ini akan ditolak dan mahasiswa akan menerima notifikasi beserta catatan Anda.
                    </div>
                    
                    <div class="mb-3">
                        <label for="notes" class="form-label fw-bold">Catatan Penolakan <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="notes" name="notes" rows="4" 
                            placeholder="Berikan alasan yang jelas mengapa peminjaman ini ditolak..." required></textarea>
                        <div class="form-text">Contoh: Inventaris sedang dalam perbaikan, dokumen tidak lengkap, stok tidak mencukupi, dll.</div>
                        <div class="invalid-feedback" id="notesError"></div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fa fa-times me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-danger" id="rejectSubmitBtn">
                        <i class="fa fa-ban me-1"></i>Tolak Peminjaman
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal untuk Edit Catatan -->
@if($pinjamInventaris->status == 2 && $pinjamInventaris->notes)
<div class="modal fade" id="editNotesModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.pinjam-inventaris.update-notes', $pinjamInventaris->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fa fa-edit me-2"></i>Edit Catatan Penolakan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editNotes" class="form-label fw-bold">Catatan</label>
                        <textarea class="form-control" id="editNotes" name="notes" rows="4">{{ $pinjamInventaris->notes }}</textarea>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fa fa-times me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save me-1"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@push('styles')
<style>
/* Modal Styles */
.modal {
    z-index: 1060 !important;
}

.modal-backdrop {
    z-index: 1055 !important;
    opacity: 0.5;
}

.modal-dialog {
    pointer-events: auto;
    margin: 1.75rem auto;
}

.modal-header.bg-danger .btn-close-white {
    filter: invert(1) grayscale(100%) brightness(200%);
}

/* Responsive modal */
@media (max-width: 576px) {
    .modal-dialog {
        margin: 0.5rem;
        max-width: calc(100% - 1rem);
    }
}

/* Form validation */
.is-invalid {
    border-color: #dc3545;
}

.invalid-feedback {
    display: block;
}

/* Modal content */
.modal-content {
    border-radius: 0.5rem;
    overflow: hidden;
}

/* Ensure modal is clickable */
.modal-dialog {
    z-index: 1061;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle modal inventaris
    const rejectModal = document.getElementById('rejectModal');
    const editNotesModal = document.getElementById('editNotesModal');
    const rejectForm = document.getElementById('rejectForm');
    
    // Reset form saat modal dibuka
    if (rejectModal) {
        rejectModal.addEventListener('show.bs.modal', function (event) {
            // Reset form
            if (rejectForm) {
                rejectForm.reset();
                // Clear any validation errors
                const inputs = rejectForm.querySelectorAll('.is-invalid');
                inputs.forEach(input => {
                    input.classList.remove('is-invalid');
                });
                const errors = rejectForm.querySelectorAll('.invalid-feedback');
                errors.forEach(error => {
                    error.style.display = 'none';
                });
            }
        });
        
        rejectModal.addEventListener('shown.bs.modal', function (event) {
            // Focus pada textarea setelah modal selesai ditampilkan
            const textarea = rejectModal.querySelector('#notes');
            if (textarea) {
                textarea.focus();
            }
        });
    }
    
    if (editNotesModal) {
        editNotesModal.addEventListener('shown.bs.modal', function (event) {
            const textarea = editNotesModal.querySelector('#editNotes');
            if (textarea) {
                textarea.focus();
                // Set cursor ke akhir text
                textarea.setSelectionRange(textarea.value.length, textarea.value.length);
            }
        });
    }
    
    // Form validation
    if (rejectForm) {
        rejectForm.addEventListener('submit', function(e) {
            const notes = document.getElementById('notes');
            const notesError = document.getElementById('notesError');
            
            // Reset validation
            notes.classList.remove('is-invalid');
            notesError.style.display = 'none';
            
            // Validate
            if (!notes.value.trim()) {
                e.preventDefault();
                notes.classList.add('is-invalid');
                notesError.textContent = 'Catatan penolakan wajib diisi.';
                notesError.style.display = 'block';
                notes.focus();
                return false;
            }
            
            if (notes.value.trim().length < 10) {
                e.preventDefault();
                notes.classList.add('is-invalid');
                notesError.textContent = 'Catatan penolakan minimal 10 karakter.';
                notesError.style.display = 'block';
                notes.focus();
                return false;
            }
            
            // Show loading state
            const submitBtn = document.getElementById('rejectSubmitBtn');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status"></span>Memproses...';
            }
        });
    }
    
    // Auto-resize textarea
    const textareas = document.querySelectorAll('textarea');
    textareas.forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });
    });
    
    // Ensure modal is properly positioned
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        modal.addEventListener('show.bs.modal', function() {
            // Remove any existing backdrops
            const existingBackdrops = document.querySelectorAll('.modal-backdrop');
            existingBackdrops.forEach(backdrop => {
                if (backdrop.parentNode) {
                    backdrop.parentNode.removeChild(backdrop);
                }
            });
        });
    });
});
</script>
@endpush
@endsection