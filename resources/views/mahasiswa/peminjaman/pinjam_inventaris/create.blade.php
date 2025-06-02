
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
                                <h4 class="text-white mb-1 fw-bold">Pengajuan Peminjaman Inventaris</h4>
                                <p class="text-white-50 mb-0">Ajukan peminjaman inventaris untuk kebutuhan akademik Anda</p>
                            </div>
                        </div>
                        <a href="{{ route('mahasiswa.cart.keranjang_inventaris.index') }}" 
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
                    <div class="room-grid">
                        @foreach($cartItems as $id => $item)
                            <div class="room-card">
                                <div class="room-number">{{ $loop->iteration }}</div>
                                <div class="room-info">
                                    <h6 class="room-name">{{ $item['nama_inventaris'] }}</h6>
                                    <div class="room-details">
                                        <span class="detail-item">
                                            <i class="fa fa-cubes"></i>
                                            {{ $item['jumlah'] }} unit
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Form -->
            <form action="{{ route('mahasiswa.peminjaman.pinjam-inventaris.store') }}" 
                  method="POST" enctype="multipart/form-data" id="peminjamanForm">
                @csrf
                
                <!-- Date & Time Section -->
                <div class="section-card mb-4">
                    <div class="section-header">
                        <div class="section-icon">
                            <i class="fa fa-calendar-alt"></i>
                        </div>
                        <div>
                            <h5 class="section-title">Waktu & Tanggal</h5>
                            <p class="section-subtitle">Tentukan periode peminjaman inventaris</p>
                        </div>
                    </div>
                    
                    <div class="section-content">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="form-group-modern">
                                    <label for="tanggal_pengajuan" class="form-label-modern">
                                        <i class="fa fa-calendar me-2"></i>Tanggal Pengajuan
                                    </label>
                                    <div class="input-group-modern">
                                        <input type="date" 
                                               class="form-control form-control-modern @error('tanggal_pengajuan') is-invalid @enderror" 
                                               id="tanggal_pengajuan" 
                                               name="tanggal_pengajuan" 
                                               value="{{ old('tanggal_pengajuan', date('Y-m-d')) }}" 
                                               required>
                                    </div>
                                    <small class="form-help">Tanggal mulai peminjaman inventaris</small>
                                    @error('tanggal_pengajuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <div class="form-group-modern">
                                    <label for="tanggal_selesai" class="form-label-modern">
                                        <i class="fa fa-calendar-check me-2"></i>Tanggal Selesai
                                    </label>
                                    <div class="input-group-modern">
                                        <input type="date" 
                                               class="form-control form-control-modern @error('tanggal_selesai') is-invalid @enderror" 
                                               id="tanggal_selesai" 
                                               name="tanggal_selesai" 
                                               value="{{ old('tanggal_selesai') }}" 
                                               required>
                                    </div>
                                    <small class="form-help">Tanggal berakhir peminjaman inventaris</small>
                                    @error('tanggal_selesai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                                               class="form-control form-control-modern @error('waktu_mulai') is-invalid @enderror" 
                                               id="waktu_mulai" 
                                               name="waktu_mulai" 
                                               value="{{ old('waktu_mulai') }}" 
                                               required>
                                    </div>
                                    <small class="form-help">Waktu mulai penggunaan inventaris</small>
                                    @error('waktu_mulai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <div class="form-group-modern">
                                    <label for="waktu_selesai" class="form-label-modern">
                                        <i class="fa fa-clock me-2"></i>Waktu Selesai
                                    </label>
                                    <div class="input-group-modern">
                                        <input type="time" 
                                               class="form-control form-control-modern @error('waktu_selesai') is-invalid @enderror" 
                                               id="waktu_selesai" 
                                               name="waktu_selesai" 
                                               value="{{ old('waktu_selesai') }}" 
                                               required>
                                    </div>
                                    <small class="form-help">Waktu selesai penggunaan inventaris</small>
                                    @error('waktu_selesai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
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
                        <a href="{{ route('mahasiswa.cart.keranjang_inventaris.index') }}" 
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
   
    const tanggalMulai = document.getElementById('tanggal_pengajuan');
    const tanggalSelesai = document.getElementById('tanggal_selesai');
    const waktuMulai = document.getElementById('waktu_mulai');
    const waktuSelesai = document.getElementById('waktu_selesai');
    
   
    const today = new Date().toISOString().split('T')[0];
    tanggalMulai.min = today;
    
   
    tanggalMulai.addEventListener('change', function() {
        tanggalSelesai.min = this.value;
        if (tanggalSelesai.value && tanggalSelesai.value < this.value) {
            tanggalSelesai.value = this.value;
        }
    });
    
   
    function validateTime() {
        if (tanggalMulai.value === tanggalSelesai.value && waktuMulai.value && waktuSelesai.value) {
            if (waktuSelesai.value <= waktuMulai.value) {
                waktuSelesai.setCustomValidity('Waktu selesai harus lebih dari waktu mulai');
            } else {
                waktuSelesai.setCustomValidity('');
            }
        }
    }
    
    tanggalMulai.addEventListener('change', validateTime);
    tanggalSelesai.addEventListener('change', validateTime);
    waktuMulai.addEventListener('change', validateTime);
    waktuSelesai.addEventListener('change', validateTime);
    
      const fileInput = document.getElementById('file_scan');
    const uploadBox = document.querySelector('.upload-box');
    
    if (uploadBox && fileInput) {
   
        uploadBox.addEventListener('click', function(e) {
   
            if (e.target !== fileInput) {
                fileInput.click();
            }
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
                updateFileDisplay(uploadBox, files[0]);
            }
        });
        
 
        let isProcessing = false;
        fileInput.addEventListener('change', function(e) {
            if (isProcessing) return;
            
            if (e.target.files.length > 0) {
                isProcessing = true;
                updateFileDisplay(uploadBox, e.target.files[0]);
                
   
                setTimeout(() => {
                    isProcessing = false;
                }, 100);
            }
        });
    }
    
    function updateFileDisplay(uploadBox, file) {
        const uploadContent = uploadBox.querySelector('.upload-content h6');
        if (uploadContent) {
            uploadContent.textContent = `File dipilih: ${file.name}`;
        }
        
   
        const uploadIcon = uploadBox.querySelector('.upload-icon i');
        if (uploadIcon) {
            uploadIcon.className = 'fa fa-check-circle';
            uploadIcon.style.color = '#28a745';
        }
    }
    
   
    const form = document.getElementById('peminjamanForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            const submitButton = document.getElementById('submitBtn');
            if (submitButton) {
                submitButton.innerHTML = '<i class="fa fa-spinner fa-spin me-2"></i>Mengajukan Peminjaman...';
                submitButton.disabled = true;
            }
        });
    }
});
</script>
@endpush
@endsection