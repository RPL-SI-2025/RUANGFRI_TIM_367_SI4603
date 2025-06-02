
@extends('mahasiswa.layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/edit_peminjaman.css') }}">
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-10 col-xl-9">
            <!-- Enhanced Header Card -->
            <div class="card border-0 shadow-lg mb-4 header-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper me-3">
                                <i class="fa fa-edit"></i>
                            </div>
                            <div>
                                <h4 class="text-white mb-1 fw-bold">Edit Pengajuan Peminjaman Inventaris</h4>
                                <p class="text-white-50 mb-0">Perbarui informasi peminjaman inventaris Anda</p>
                            </div>
                        </div>
                        <a href="{{ route('mahasiswa.peminjaman.pinjam-inventaris.index') }}" 
                           class="btn btn-outline-light btn-floating">
                            <i class="fa fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>

            <!-- Progress Indicator -->
            <div class="progress-indicator mb-4">
                <div class="progress-step active">
                    <div class="step-number">1</div>
                    <span>Detail Inventaris</span>
                </div>
                <div class="progress-line"></div>
                <div class="progress-step active">
                    <div class="step-number">2</div>
                    <span>Waktu & Tanggal</span>
                </div>
                <div class="progress-line"></div>
                <div class="progress-step active">
                    <div class="step-number">3</div>
                    <span>Dokumen Pendukung</span>
                </div>
            </div>

            <!-- Alert Messages -->
            @if (session('error'))
                <div class="alert alert-danger alert-modern border-0 shadow-sm mb-4">
                    <div class="d-flex align-items-center">
                        <div class="alert-icon me-3">
                            <i class="fa fa-exclamation-triangle"></i>
                        </div>
                        <div>
                            <strong>Kesalahan!</strong>
                            <p class="mb-0 mt-1">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Edit Form -->
            <form action="{{ route('mahasiswa.peminjaman.pinjam-inventaris.update', $pinjamInventaris->id) }}" 
                  method="POST" enctype="multipart/form-data" id="editForm">
                @csrf
                @method('PUT')

                <!-- Inventaris Details Section -->
                <div class="section-card mb-4">
                    <div class="section-header">
                        <div class="section-icon">
                            <i class="fa fa-box"></i>
                        </div>
                        <div>
                            <h5 class="section-title">Detail Inventaris</h5>
                            <p class="section-subtitle">Inventaris yang akan dipinjam</p>
                        </div>
                    </div>
                    
                    <div class="section-content">
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

                        <div class="room-grid">
                            @foreach($relatedItems as $item)
                                <div class="room-card">
                                    <div class="room-number">{{ $loop->iteration }}</div>
                                    <div class="room-info">
                                        <h6 class="room-name">{{ $item->inventaris->nama_inventaris ?? 'Inventaris tidak ditemukan' }}</h6>
                                        <div class="room-details">
                                            <span class="detail-item">
                                                <i class="fa fa-cubes"></i>
                                                {{ $item->jumlah_pinjam }} unit
                                            </span>
                                            @if($item->inventaris && $item->inventaris->deskripsi)
                                                <span class="detail-item">
                                                    <i class="fa fa-info-circle"></i>
                                                    {{ Str::limit($item->inventaris->deskripsi, 30) }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Editable Inventaris Table -->
                        <div class="mt-4">
                            <h6 class="mb-3">Edit Jumlah Inventaris</h6>
                            <div class="table-responsive">
                                <table class="table table-hover table-modern">
                                    <thead>
                                        <tr>
                                            <th class="border-0">No</th>
                                            <th class="border-0">Nama Inventaris</th>
                                            <th class="border-0">Jumlah Tersedia</th>
                                            <th class="border-0">Jumlah Pinjam</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($relatedItems as $item)
                                            <tr>
                                                <td>
                                                    <div class="number-circle-small">{{ $loop->iteration }}</div>
                                                </td>
                                                <td>
                                                    <div class="room-info-compact">
                                                        <h6 class="mb-1">{{ $item->inventaris->nama_inventaris ?? 'Inventaris tidak ditemukan' }}</h6>
                                                        <small class="text-muted">
                                                            <i class="fa fa-info-circle me-1"></i>{{ Str::limit($item->inventaris->deskripsi ?? 'Tidak ada deskripsi', 50) }}
                                                        </small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="location-badge">
                                                        <i class="fa fa-cubes me-1"></i>{{ $item->inventaris->jumlah ?? 0 }} unit
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="form-group-modern">
                                                        <input type="number" 
                                                               name="inventaris[{{ $item->id }}][jumlah]" 
                                                               class="form-control form-control-modern" 
                                                               value="{{ $item->jumlah_pinjam }}" 
                                                               min="1" 
                                                               max="{{ $item->inventaris->jumlah ?? 1 }}" 
                                                               required>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Date & Time Section -->
                <div class="section-card mb-4">
                    <div class="section-header">
                        <div class="section-icon">
                            <i class="fa fa-calendar-alt"></i>
                        </div>
                        <div>
                            <h5 class="section-title">Waktu & Tanggal</h5>
                            <p class="section-subtitle">Ubah tanggal dan waktu peminjaman</p>
                        </div>
                    </div>
                    
                    <div class="section-content">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="form-group-modern">
                                    <label for="tanggal_pengajuan" class="form-label-modern">
                                        <i class="fa fa-calendar me-2"></i>Tanggal Mulai
                                    </label>
                                    <div class="input-group-modern">
                                        <input type="date" 
                                               class="form-control form-control-modern" 
                                               id="tanggal_pengajuan" 
                                               name="tanggal_pengajuan" 
                                               value="{{ old('tanggal_pengajuan', $pinjamInventaris->tanggal_pengajuan) }}" 
                                               required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <div class="form-group-modern">
                                    <label for="tanggal_selesai" class="form-label-modern">
                                        <i class="fa fa-calendar-check me-2"></i>Tanggal Selesai
                                    </label>
                                    <div class="input-group-modern">
                                        <input type="date" 
                                               class="form-control form-control-modern" 
                                               id="tanggal_selesai" 
                                               name="tanggal_selesai" 
                                               value="{{ old('tanggal_selesai', $pinjamInventaris->tanggal_selesai) }}" 
                                               required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="form-group-modern">
                                    <label for="waktu_mulai" class="form-label-modern">
                                        <i class="fa fa-clock me-2"></i>Waktu Mulai
                                    </label>
                                    <div class="input-group-modern">
                                        <input type="time" 
                                               class="form-control form-control-modern" 
                                               id="waktu_mulai" 
                                               name="waktu_mulai" 
                                               value="{{ old('waktu_mulai', $pinjamInventaris->waktu_mulai) }}" 
                                               required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <div class="form-group-modern">
                                    <label for="waktu_selesai" class="form-label-modern">
                                        <i class="fa fa-clock-o me-2"></i>Waktu Selesai
                                    </label>
                                    <div class="input-group-modern">
                                        <input type="time" 
                                               class="form-control form-control-modern" 
                                               id="waktu_selesai" 
                                               name="waktu_selesai" 
                                               value="{{ old('waktu_selesai', $pinjamInventaris->waktu_selesai) }}" 
                                               required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Current Time Display -->
                        <div class="current-selection">
                            <h6 class="mb-3 text-primary">
                                <i class="fa fa-clock-o me-2"></i>Waktu Terpilih Saat Ini
                            </h6>
                            <div class="time-display">
                                <span class="time-badge">
                                    {{ \Carbon\Carbon::parse($pinjamInventaris->waktu_mulai)->format('H:i') }} - 
                                    {{ \Carbon\Carbon::parse($pinjamInventaris->waktu_selesai)->format('H:i') }}
                                </span>
                            </div>
                            <div class="alert alert-info alert-modern border-0 mt-3">
                                <i class="fa fa-info-circle me-2"></i>
                                <strong>Periode peminjaman:</strong> 
                                {{ \Carbon\Carbon::parse($pinjamInventaris->tanggal_pengajuan)->format('d M Y') }} - 
                                {{ \Carbon\Carbon::parse($pinjamInventaris->tanggal_selesai)->format('d M Y') }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Documents Section -->
                <div class="section-card mb-4">
                    <div class="section-header">
                        <div class="section-icon">
                            <i class="fa fa-paperclip"></i>
                        </div>
                        <div>
                            <h5 class="section-title">Dokumen Pendukung</h5>
                            <p class="section-subtitle">Upload dokumen yang diperlukan</p>
                        </div>
                    </div>
                    
                    <div class="section-content">
                        <div class="file-upload-area">
                            <div class="upload-box">
                                <div class="upload-icon">
                                    <i class="fa fa-cloud-upload"></i>
                                </div>
                                <div class="upload-content">
                                    <h6>Upload File Baru</h6>
                                    <p>Drag & drop file atau klik untuk browse</p>
                                    <input type="file" 
                                           class="form-control-file @error('file_scan') is-invalid @enderror" 
                                           id="file_scan" 
                                           name="file_scan" 
                                           accept=".pdf,.jpg,.jpeg,.png">
                                    <small class="file-info">Format: PDF, JPG, PNG (Max: 2MB)</small>
                                </div>
                            </div>
                            
                            @if($pinjamInventaris->file_scan)
                                <div class="current-file">
                                    <div class="file-preview">
                                        <div class="file-icon">
                                            <i class="fa fa-file-pdf-o"></i>
                                        </div>
                                        <div class="file-details">
                                            <h6>File Saat Ini</h6>
                                            <p>{{ $pinjamInventaris->file_scan }}</p>
                                            <a href="{{ asset('storage/uploads/file_scan/' . $pinjamInventaris->file_scan) }}" 
                                               class="btn btn-sm btn-outline-primary" 
                                               target="_blank">
                                                <i class="fa fa-eye me-1"></i>Lihat File
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            @error('file_scan')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-section">
                    <div class="action-buttons">
                        <a href="{{ route('mahasiswa.peminjaman.pinjam-inventaris.show', $pinjamInventaris->id) }}" 
                           class="btn btn-secondary btn-lg">
                            <i class="fa fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                            <i class="fa fa-save me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
   
    const tanggalMulai = document.getElementById('tanggal_pengajuan');
    const tanggalSelesai = document.getElementById('tanggal_selesai');
    const waktuMulai = document.getElementById('waktu_mulai');
    const waktuSelesai = document.getElementById('waktu_selesai');
    
   
    const today = new Date().toISOString().split('T')[0];
    tanggalMulai.min = today;
    
   
    tanggalMulai.addEventListener('change', function() {
        tanggalSelesai.min = this.value;
        if (tanggalSelesai.value < this.value) {
            tanggalSelesai.value = this.value;
        }
    });
    
   
    function validateTime() {
        if (tanggalMulai.value === tanggalSelesai.value) {
            if (waktuSelesai.value <= waktuMulai.value) {
                waktuSelesai.setCustomValidity('Waktu selesai harus lebih besar dari waktu mulai');
            } else {
                waktuSelesai.setCustomValidity('');
            }
        } else {
            waktuSelesai.setCustomValidity('');
        }
    }
    
    waktuMulai.addEventListener('change', validateTime);
    waktuSelesai.addEventListener('change', validateTime);
    tanggalMulai.addEventListener('change', validateTime);
    tanggalSelesai.addEventListener('change', validateTime);
    
   
    const fileInput = document.getElementById('file_scan');
    const uploadBox = document.querySelector('.upload-box');
    
    if (fileInput && uploadBox) {
   
        uploadBox.addEventListener('click', function() {
            fileInput.click();
        });
        
   
        uploadBox.addEventListener('dragover', function(e) {
            e.preventDefault();
            uploadBox.style.borderColor = 'var(--primary-color)';
            uploadBox.style.background = 'rgba(30, 41, 59, 0.05)';
        });
        
        uploadBox.addEventListener('dragleave', function(e) {
            e.preventDefault();
            uploadBox.style.borderColor = 'var(--border-color)';
            uploadBox.style.background = 'transparent';
        });
        
        uploadBox.addEventListener('drop', function(e) {
            e.preventDefault();
            uploadBox.style.borderColor = 'var(--border-color)';
            uploadBox.style.background = 'transparent';
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                updateFileDisplay(files[0]);
            }
        });
        
        fileInput.addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                updateFileDisplay(e.target.files[0]);
            }
        });
        
        function updateFileDisplay(file) {
            const uploadContent = document.querySelector('.upload-content h6');
            if (uploadContent) {
                uploadContent.textContent = `File dipilih: ${file.name}`;
            }
        }
    }
    
   
    const form = document.getElementById('editForm');
    form.addEventListener('submit', function(e) {
        const submitButton = document.getElementById('submitBtn');
        if (submitButton) {
            submitButton.innerHTML = '<i class="fa fa-spinner fa-spin me-2"></i>Menyimpan...';
            submitButton.disabled = true;
        }
    });
    
   
    validateTime();
});
</script>
@endpush
@endsection