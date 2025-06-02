
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
                                <h4 class="text-white mb-1 fw-bold">Edit Laporan Ruangan</h4>
                                <p class="text-white-50 mb-0">Perbarui informasi laporan pengembalian ruangan</p>
                            </div>
                        </div>
                        <a href="{{ route('mahasiswa.pelaporan.lapor_ruangan.index') }}" 
                           class="btn btn-outline-light btn-floating">
                            <i class="fa fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
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
                        <p class="section-subtitle">Informasi ruangan yang dilaporkan</p>
                    </div>
                </div>
                
                <div class="section-content">
                    <div class="room-grid">
                        <div class="room-card">
                            <div class="room-number">1</div>
                            <div class="room-info">
                                <h6 class="room-name">{{ $laporan->ruangan->nama_ruangan ?? 'Tidak ditemukan' }}</h6>
                                <div class="room-details">
                                    <span class="detail-item">
                                        <i class="fa fa-users"></i>
                                        {{ $laporan->ruangan->kapasitas ?? '-' }} orang
                                    </span>
                                    <span class="detail-item">
                                        <i class="fa fa-map-marker"></i>
                                        {{ $laporan->ruangan->lokasi ?? '-' }}
                                    </span>
                                    <span class="detail-item">
                                        <i class="fa fa-calendar"></i>
                                        {{ $laporan->peminjaman ? \Carbon\Carbon::parse($laporan->peminjaman->tanggal_pengajuan)->format('d M Y') : '-' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Form -->
            <form method="POST" action="{{ route('mahasiswa.pelaporan.lapor_ruangan.update', $laporan->id_lapor_ruangan) }}" enctype="multipart/form-data" id="reportForm">
                @csrf
                @method('PUT')
                
                <!-- Report Information Section -->
                <div class="section-card mb-4">
                    <div class="section-header">
                        <div class="section-icon">
                            <i class="fa fa-calendar-alt"></i>
                        </div>
                        <div>
                            <h5 class="section-title">Informasi Laporan</h5>
                            <p class="section-subtitle">Detail tanggal dan penanggung jawab</p>
                        </div>
                    </div>
                    
                    <div class="section-content">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="form-group-modern">
                                    <label for="datetime" class="form-label-modern">
                                        <i class="fa fa-calendar me-2"></i>Tanggal Laporan
                                    </label>
                                    <div class="input-group-modern">
                                        <input type="date" 
                                               class="form-control form-control-modern @error('datetime') is-invalid @enderror" 
                                               id="datetime" 
                                               name="datetime" 
                                               value="{{ old('datetime', $laporan->datetime ? date('Y-m-d', strtotime($laporan->datetime)) : '') }}" 
                                               readonly>
                                    </div>
                                    <small class="form-help">Tanggal laporan tidak dapat diubah</small>
                                    @error('datetime')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <div class="form-group-modern">
                                    <label for="id_logistik" class="form-label-modern">
                                        <i class="fa fa-user me-2"></i>Admin Penanggung Jawab
                                    </label>
                                    <div class="input-group-modern">
                                        <input type="text" 
                                               class="form-control form-control-modern" 
                                               value="{{ $laporan->logistik->nama ?? 'N/A' }}" 
                                               readonly>
                                        <input type="hidden" name="id_logistik" value="{{ $laporan->id_logistik }}">
                                    </div>
                                    <small class="form-help">Admin logistik tidak dapat diubah</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="form-group-modern">
                                    <label for="oleh" class="form-label-modern">
                                        <i class="fa fa-user me-2"></i>Pelapor
                                    </label>
                                    <div class="input-group-modern">
                                        <input type="text" 
                                               class="form-control form-control-modern" 
                                               id="oleh" 
                                               value="{{ $laporan->oleh }}" 
                                               readonly>
                                        <input type="hidden" name="oleh" value="{{ $laporan->oleh }}">
                                    </div>
                                    <small class="form-help">Nama pelapor tidak dapat diubah</small>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <div class="form-group-modern">
                                    <label for="kepada" class="form-label-modern">
                                        <i class="fa fa-user-tie me-2"></i>Dilaporkan Kepada
                                    </label>
                                    <div class="input-group-modern">
                                        <input type="text" 
                                               class="form-control form-control-modern @error('kepada') is-invalid @enderror" 
                                               id="kepada" 
                                               name="kepada" 
                                               value="{{ old('kepada', $laporan->kepada) }}" 
                                               placeholder="Masukkan nama penerima laporan"
                                               required>
                                    </div>
                                    <small class="form-help">Nama atau jabatan yang menerima laporan</small>
                                    @error('kepada')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Documentation Section -->
                <div class="section-card mb-4">
                    <div class="section-header">
                        <div class="section-icon">
                            <i class="fa fa-camera"></i>
                        </div>
                        <div>
                            <h5 class="section-title">Dokumentasi Kondisi</h5>
                            <p class="section-subtitle">Update foto kondisi awal dan akhir ruangan</p>
                        </div>
                    </div>
                    
                    <div class="section-content">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="file-upload-area">
                                    <div class="upload-box">
                                        <div class="upload-icon">
                                            <i class="fa fa-camera"></i>
                                        </div>
                                        <div class="upload-content">
                                            <h6>Foto Kondisi Awal</h6>
                                            @if($laporan->foto_awal)
                                                <div class="current-image mb-2">
                                                    <img src="{{ asset('storage/' . $laporan->foto_awal) }}" 
                                                         alt="Foto Kondisi Awal" 
                                                         class="img-thumbnail" 
                                                         style="max-height: 150px;">
                                                </div>
                                                <p>Klik untuk mengubah foto kondisi awal</p>
                                            @else
                                                <p>Upload foto kondisi ruangan saat mulai dipinjam</p>
                                            @endif
                                            <input type="file" 
                                                   class="form-control-file @error('foto_awal') is-invalid @enderror" 
                                                   id="foto_awal" 
                                                   name="foto_awal" 
                                                   accept="image/*">
                                            <small class="file-info">Format: JPG, PNG (Max: 2MB)</small>
                                        </div>
                                    </div>
                                    @error('foto_awal')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <div class="file-upload-area">
                                    <div class="upload-box">
                                        <div class="upload-icon">
                                            <i class="fa fa-camera"></i>
                                        </div>
                                        <div class="upload-content">
                                            <h6>Foto Kondisi Akhir</h6>
                                            @if($laporan->foto_akhir)
                                                <div class="current-image mb-2">
                                                    <img src="{{ asset('storage/' . $laporan->foto_akhir) }}" 
                                                         alt="Foto Kondisi Akhir" 
                                                         class="img-thumbnail" 
                                                         style="max-height: 150px;">
                                                </div>
                                                <p>Klik untuk mengubah foto kondisi akhir</p>
                                            @else
                                                <p>Upload foto kondisi ruangan saat akan dikembalikan</p>
                                            @endif
                                            <input type="file" 
                                                   class="form-control-file @error('foto_akhir') is-invalid @enderror" 
                                                   id="foto_akhir" 
                                                   name="foto_akhir" 
                                                   accept="image/*">
                                            <small class="file-info">Format: JPG, PNG (Max: 2MB)</small>
                                        </div>
                                    </div>
                                    @error('foto_akhir')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Report Description Section -->
                <div class="section-card mb-4">
                    <div class="section-header">
                        <div class="section-icon">
                            <i class="fa fa-clipboard-list"></i>
                        </div>
                        <div>
                            <h5 class="section-title">Deskripsi Laporan</h5>
                            <p class="section-subtitle">Berikan keterangan kondisi ruangan</p>
                        </div>
                    </div>
                    
                    <div class="section-content">
                        <div class="form-group-modern">
                            <label for="deskripsi" class="form-label-modern">
                                <i class="fa fa-edit me-2"></i>Keterangan Kondisi
                            </label>
                            <div class="input-group-modern">
                                <textarea class="form-control form-control-modern @error('deskripsi') is-invalid @enderror" 
                                          id="deskripsi" 
                                          name="deskripsi" 
                                          rows="4" 
                                          placeholder="Contoh: Ruangan dalam kondisi baik, tidak ada kerusakan. Semua fasilitas berfungsi normal."
                                          required>{{ old('deskripsi', $laporan->deskripsi) }}</textarea>
                            </div>
                            <small class="form-help">Berikan keterangan detail kondisi ruangan saat dikembalikan</small>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-section">
                    <div class="action-buttons">
                        <a href="{{ route('mahasiswa.pelaporan.lapor_ruangan.index') }}" 
                           class="btn btn-secondary btn-lg">
                            <i class="fa fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-success btn-lg" id="submitBtn">
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
   
    const fileInputs = document.querySelectorAll('input[type="file"]');
    
    fileInputs.forEach(function(fileInput) {
        const uploadBox = fileInput.closest('.upload-box');
        
        if (uploadBox) {
   
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
                    updateFileDisplay(uploadBox, files[0]);
                }
            });
            
            fileInput.addEventListener('change', function(e) {
                if (e.target.files.length > 0) {
                    updateFileDisplay(uploadBox, e.target.files[0]);
                }
            });
        }
    });
    
    function updateFileDisplay(uploadBox, file) {
        const uploadContent = uploadBox.querySelector('.upload-content h6');
        if (uploadContent) {
            uploadContent.textContent = `File dipilih: ${file.name}`;
        }
    }
    
   
    const form = document.getElementById('reportForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            const submitButton = document.getElementById('submitBtn');
            if (submitButton) {
                submitButton.innerHTML = '<i class="fa fa-spinner fa-spin me-2"></i>Menyimpan Perubahan...';
                submitButton.disabled = true;
            }
        });
    }
    
   
    const textareas = document.querySelectorAll('textarea');
    textareas.forEach(function(textarea) {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    });
});
</script>
@endpush

@endsection