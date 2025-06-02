
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
                                <i class="fa fa-file-text"></i>
                            </div>
                            <div>
                                <h4 class="text-white mb-1 fw-bold">Pengajuan Peminjaman Ruangan</h4>
                                <p class="text-white-50 mb-0">Ajukan peminjaman ruangan untuk kebutuhan akademik Anda</p>
                            </div>
                        </div>
                        <a href="{{ route('mahasiswa.cart.keranjang_ruangan.index') }}" 
                           class="btn btn-outline-light btn-floating">
                            <i class="fa fa-arrow-left me-2"></i>Kembali ke Keranjang
                        </a>
                    </div>
                </div>
            </div>

            <!-- Progress Indicator -->
            <div class="progress-indicator mb-4">
                <div class="progress-step active">
                    <div class="step-number">1</div>
                    <span>Detail Ruangan</span>
                </div>
                <div class="progress-line"></div>
                <div class="progress-step active">
                    <div class="step-number">2</div>
                    <span>Tujuan Peminjaman</span>
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

            <!-- Room Details Section -->
            <div class="section-card mb-4">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fa fa-building"></i>
                    </div>
                    <div>
                        <h5 class="section-title">Detail Ruangan</h5>
                        <p class="section-subtitle">Ruangan yang akan dipinjam</p>
                    </div>
                </div>
                
                <div class="section-content">
                    <div class="room-grid">
                        @foreach($cartItems as $id => $item)
                            <div class="room-card">
                                <div class="room-number">{{ $loop->iteration }}</div>
                                <div class="room-info">
                                    <h6 class="room-name">{{ $item['nama_ruangan'] }}</h6>
                                    <div class="room-details">
                                        <span class="detail-item">
                                            <i class="fa fa-map-marker"></i>
                                            {{ $item['lokasi'] }}
                                        </span>
                                        <span class="detail-item">
                                            <i class="fa fa-calendar"></i>
                                            {{ \Carbon\Carbon::parse($item['tanggal_booking'])->format('d M Y') }}
                                        </span>
                                        <span class="detail-item">
                                            <i class="fa fa-clock"></i>
                                            {{ \Carbon\Carbon::parse($item['waktu_mulai'])->format('H:i') }} - {{ \Carbon\Carbon::parse($item['waktu_selesai'])->format('H:i') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Form -->
            <form action="{{ route('mahasiswa.peminjaman.pinjam-ruangan.store') }}" 
                  method="POST" enctype="multipart/form-data" id="bookingForm">
                @csrf
                @foreach($cartItems as $id => $item)
                    <input type="hidden" name="ruangan_ids[]" value="{{ $id }}">
                @endforeach
                <input type="hidden" name="tanggal_pengajuan" value="{{ reset($cartItems)['tanggal_booking'] }}">
                <input type="hidden" name="tanggal_selesai" value="{{ reset($cartItems)['tanggal_booking'] }}">
                <input type="hidden" name="waktu_mulai" value="{{ reset($cartItems)['waktu_mulai'] }}">
                <input type="hidden" name="waktu_selesai" value="{{ reset($cartItems)['waktu_selesai'] }}">
                
                <!-- Purpose Section -->
                <div class="section-card mb-4">
                    <div class="section-header">
                        <div class="section-icon">
                            <i class="fa fa-clipboard-list"></i>
                        </div>
                        <div>
                            <h5 class="section-title">Tujuan Peminjaman</h5>
                            <p class="section-subtitle">Jelaskan tujuan penggunaan ruangan</p>
                        </div>
                    </div>
                    
                    <div class="section-content">
                        <div class="form-group-modern">
                            <label for="tujuan_peminjaman" class="form-label-modern">
                                <i class="fa fa-edit me-2"></i>Deskripsi Tujuan
                            </label>
                            <div class="input-group-modern">
                                <textarea class="form-control form-control-modern @error('tujuan_peminjaman') is-invalid @enderror" 
                                          id="tujuan_peminjaman" 
                                          name="tujuan_peminjaman" 
                                          rows="4" 
                                          placeholder="Contoh: Rapat organisasi, seminar, workshop, presentasi tugas akhir, dll."
                                          required>{{ old('tujuan_peminjaman') }}</textarea>
                            </div>
                            <small class="form-help">Jelaskan secara detail untuk mempercepat proses persetujuan</small>
                            @error('tujuan_peminjaman')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                            <p class="section-subtitle">Upload dokumen yang diperlukan (opsional)</p>
                        </div>
                    </div>
                    
                    <div class="section-content">
                        <div class="file-upload-area">
                            <div class="upload-box">
                                <div class="upload-icon">
                                    <i class="fa fa-cloud-upload"></i>
                                </div>
                                <div class="upload-content">
                                    <h6>Upload Dokumen</h6>
                                    <p>Upload surat permohonan atau dokumen pendukung</p>
                                    <input type="file" 
                                           class="form-control-file @error('file_scan') is-invalid @enderror" 
                                           id="file_scan" 
                                           name="file_scan" 
                                           accept=".pdf,.jpg,.jpeg,.png">
                                    <small class="file-info">Format: PDF, JPG, PNG (Max: 2MB)</small>
                                </div>
                            </div>
                            @error('file_scan')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-section">
                    <div class="action-buttons">
                        <a href="{{ route('mahasiswa.cart.keranjang_ruangan.index') }}" 
                           class="btn btn-secondary btn-lg">
                            <i class="fa fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-success btn-lg" id="submitBtn">
                            <i class="fa fa-paper-plane me-2"></i>Ajukan Peminjaman
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
    // File upload enhancement
    const fileInput = document.getElementById('file_scan');
    const uploadBox = document.querySelector('.upload-box');
    
    if (uploadBox && fileInput) {
        // Click to upload
        uploadBox.addEventListener('click', function() {
            fileInput.click();
        });
        
        // Drag and drop functionality
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
                updateFileDisplay(uploadBox, files[0]);
            }
        });
        
        fileInput.addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                updateFileDisplay(uploadBox, e.target.files[0]);
            }
        });
    }
    
    function updateFileDisplay(uploadBox, file) {
        const uploadContent = uploadBox.querySelector('.upload-content h6');
        if (uploadContent) {
            uploadContent.textContent = `File dipilih: ${file.name}`;
        }
    }
    
    // Form validation enhancement
    const form = document.getElementById('bookingForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!this.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            } else {
                const submitButton = document.getElementById('submitBtn');
                if (submitButton) {
                    submitButton.innerHTML = '<i class="fa fa-spinner fa-spin me-2"></i>Mengajukan Peminjaman...';
                    submitButton.disabled = true;
                }
            }
            this.classList.add('was-validated');
        });
    }
    
    // Enhanced textarea auto-resize
    const textarea = document.getElementById('tujuan_peminjaman');
    if (textarea) {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    }
});
</script>
@endpush
@endsection