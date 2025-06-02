
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
                                <i class="fa fa-clipboard-check"></i>
                            </div>
                            <div>
                                <h4 class="text-white mb-1 fw-bold">Pelaporan Pengembalian Ruangan</h4>
                                <p class="text-white-50 mb-0">Laporkan kondisi ruangan setelah selesai digunakan</p>
                            </div>
                        </div>
                        <a href="{{ route('mahasiswa.peminjaman.pinjam-ruangan.index') }}" 
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
                    <span>Detail Ruangan</span>
                </div>
                <div class="progress-line"></div>
                <div class="progress-step active">
                    <div class="step-number">2</div>
                    <span>Dokumentasi</span>
                </div>
                <div class="progress-line"></div>
                <div class="progress-step active">
                    <div class="step-number">3</div>
                    <span>Laporan</span>
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

            @if(isset($peminjaman) && isset($ruangan))
                <!-- Room Details Section -->
                <div class="section-card mb-4">
                    <div class="section-header">
                        <div class="section-icon">
                            <i class="fa fa-building"></i>
                        </div>
                        <div>
                            <h5 class="section-title">Detail Ruangan</h5>
                            <p class="section-subtitle">Ruangan yang akan dilaporkan</p>
                        </div>
                    </div>
                    
                    <div class="section-content">
                        <div class="room-grid">
                            <div class="room-card">
                                <div class="room-number">1</div>
                                <div class="room-info">
                                    <h6 class="room-name">
                                        @if(isset($peminjaman) && isset($peminjaman->ruangan))
                                            {{ $peminjaman->ruangan->nama_ruangan ?? 'Tidak ditemukan' }}
                                        @else
                                            Tidak ditemukan
                                        @endif
                                    </h6>
                                    <div class="room-details">
                                        <span class="detail-item">
                                            <i class="fa fa-users"></i>
                                            @if(isset($peminjaman) && isset($peminjaman->ruangan))
                                                {{ $peminjaman->ruangan->kapasitas ?? '-' }} orang
                                            @else
                                                - orang
                                            @endif
                                        </span>
                                        <span class="detail-item">
                                            <i class="fa fa-map-marker"></i>
                                            @if(isset($peminjaman) && isset($peminjaman->ruangan))
                                                {{ $peminjaman->ruangan->lokasi ?? '-' }}
                                            @else
                                                -
                                            @endif
                                        </span>
                                        <span class="detail-item">
                                            <i class="fa fa-calendar"></i>
                                            {{ $peminjaman->tanggal_pengajuan ? \Carbon\Carbon::parse($peminjaman->tanggal_pengajuan)->format('d M Y') : '-' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Create Form -->
                <form action="{{ route('mahasiswa.pelaporan.lapor_ruangan.store') }}" 
                      method="POST" enctype="multipart/form-data" id="reportForm">
                    @csrf
                    <input type="hidden" name="id_peminjaman" value="{{ $peminjaman->id }}">
                    
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
                                                   value="{{ old('datetime', date('Y-m-d')) }}" 
                                                   required>
                                        </div>
                                        <small class="form-help">Tanggal pelaporan pengembalian ruangan</small>
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
                                            <select class="form-control form-control-modern @error('id_logistik') is-invalid @enderror" 
                                                    id="id_logistik" 
                                                    name="id_logistik" 
                                                    required>
                                                <option value="">Pilih Admin</option>
                                                @if(isset($adminLogistik) && count($adminLogistik) > 0)
                                                    @foreach($adminLogistik as $admin)
                                                        <option value="{{ $admin->id }}">{{ $admin->nama }}</option>
                                                    @endforeach
                                                @else
                                                    <option value="" disabled>Tidak ada admin tersedia</option>
                                                @endif
                                            </select>
                                        </div>
                                        <small class="form-help">Pilih admin yang akan menerima laporan</small>
                                        @error('id_logistik')
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
                                <p class="section-subtitle">Upload foto kondisi awal dan akhir ruangan</p>
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
                                                <p>Upload foto kondisi ruangan saat mulai dipinjam</p>
                                                <input type="file" 
                                                       class="form-control-file @error('foto_awal') is-invalid @enderror" 
                                                       id="foto_awal" 
                                                       name="foto_awal" 
                                                       accept="image/*" 
                                                       required>
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
                                                <p>Upload foto kondisi ruangan saat akan dikembalikan</p>
                                                <input type="file" 
                                                       class="form-control-file @error('foto_akhir') is-invalid @enderror" 
                                                       id="foto_akhir" 
                                                       name="foto_akhir" 
                                                       accept="image/*" 
                                                       required>
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
                                              required>{{ old('deskripsi') }}</textarea>
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
                            <a href="{{ route('mahasiswa.peminjaman.pinjam-ruangan.index') }}" 
                               class="btn btn-secondary btn-lg">
                                <i class="fa fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-success btn-lg" id="submitBtn">
                                <i class="fa fa-paper-plane me-2"></i>Kirim Laporan
                            </button>
                        </div>
                    </div>
                </form>
            @else
                <!-- No Data Section -->
                <div class="section-card mb-4">
                    <div class="section-content">
                        <div class="alert alert-info alert-modern border-0">
                            <div class="d-flex align-items-center">
                                <div class="alert-icon me-3">
                                    <i class="fa fa-info-circle"></i>
                                </div>
                                <div>
                                    <h6 class="alert-title">Data Tidak Tersedia</h6>
                                    <p class="mb-0">Tidak ada data peminjaman yang dipilih atau peminjaman tidak valid.</p>
                                    <a href="{{ route('mahasiswa.peminjaman.pinjam-ruangan.index') }}" 
                                       class="btn btn-primary btn-sm mt-2">
                                        <i class="fa fa-arrow-left me-1"></i>Kembali ke daftar peminjaman
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
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
                submitButton.innerHTML = '<i class="fa fa-spinner fa-spin me-2"></i>Mengirim Laporan...';
                submitButton.disabled = true;
            }
        });
    }
    
   
    const dateInput = document.getElementById('datetime');
    if (dateInput) {
        const today = new Date().toISOString().split('T')[0];
        dateInput.max = today;   
    }
    
   
    const selectInputs = document.querySelectorAll('select');
    selectInputs.forEach(function(select) {
        select.addEventListener('change', function() {
            if (this.value) {
                this.style.color = '#495057';
            } else {
                this.style.color = '#6c757d';
            }
        });
    });
});
</script>
@endpush
@endsection