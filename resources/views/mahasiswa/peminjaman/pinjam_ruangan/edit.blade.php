
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
                                <h4 class="text-white mb-1 fw-bold">Edit Pengajuan Peminjaman Ruangan</h4>
                                <p class="text-white-50 mb-0">Perbarui informasi peminjaman ruangan Anda</p>
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
                    <span>Waktu & Tanggal</span>
                </div>
                <div class="progress-line"></div>
                <div class="progress-step active">
                    <div class="step-number">3</div>
                    <span>Informasi Tambahan</span>
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
                        @foreach($relatedBookings as $booking)
                            <div class="room-card">
                                <div class="room-number">{{ $loop->iteration }}</div>
                                <div class="room-info">
                                    <h6 class="room-name">{{ $booking->ruangan->nama_ruangan }}</h6>
                                    <div class="room-details">
                                        <span class="detail-item">
                                            <i class="fa fa-users"></i>
                                            {{ $booking->ruangan->kapasitas }} orang
                                        </span>
                                        <span class="detail-item">
                                            <i class="fa fa-map-marker"></i>
                                            {{ $booking->ruangan->lokasi }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Edit Form -->
            <form action="{{ route('mahasiswa.peminjaman.pinjam-ruangan.update', $pinjamRuangan->id) }}" 
                  method="POST" enctype="multipart/form-data" id="editForm">
                @csrf
                @method('PUT')
                
                <!-- Date & Time Section -->
                <div class="section-card mb-4">
                    <div class="section-header">
                        <div class="section-icon">
                            <i class="fa fa-calendar-alt"></i>
                        </div>
                        <div>
                            <h5 class="section-title">Waktu & Tanggal</h5>
                            <p class="section-subtitle">Pilih tanggal dan waktu peminjaman</p>
                        </div>
                    </div>
                    
                    <div class="section-content">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="form-group-modern">
                                    <label for="tanggal_booking" class="form-label-modern">
                                        <i class="fa fa-calendar me-2"></i>Tanggal Peminjaman
                                    </label>
                                    <div class="input-group-modern">
                                        <input type="date" 
                                               class="form-control form-control-modern date-picker" 
                                               id="tanggal_booking" 
                                               name="tanggal_pengajuan" 
                                               value="{{ old('tanggal_pengajuan', $pinjamRuangan->tanggal_pengajuan) }}" 
                                               required>
                                    </div>
                                    <small class="form-help">Pilih tanggal untuk melihat slot waktu tersedia</small>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <div class="current-selection">
                                    <h6 class="mb-3 text-primary">
                                        <i class="fa fa-clock-o me-2"></i>Waktu Terpilih Saat Ini
                                    </h6>
                                    <div class="time-display">
                                        <span class="time-badge">
                                            {{ date('H:i', strtotime($pinjamRuangan->waktu_mulai)) }} - 
                                            {{ date('H:i', strtotime($pinjamRuangan->waktu_selesai)) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Loading Slots -->
                        <div id="loadingSlots" class="loading-container" style="display: none;">
                            <div class="loading-spinner">
                                <div class="spinner"></div>
                                <p>Memuat slot waktu tersedia...</p>
                            </div>
                        </div>
                        
                        <!-- Time Slots Container -->
                        <div id="timeSlots" class="time-slots-container">
                            <!-- Time slots will be loaded here -->
                        </div>
                        
                        <!-- Hidden Inputs -->
                        <input type="hidden" name="waktu_mulai" id="waktu_mulai" value="{{ old('waktu_mulai', $pinjamRuangan->waktu_mulai) }}">
                        <input type="hidden" name="waktu_selesai" id="waktu_selesai" value="{{ old('waktu_selesai', $pinjamRuangan->waktu_selesai) }}">
                        <input type="hidden" name="selected_slots_json" id="selected_slots_json" value="">
                        <input type="hidden" name="tanggal_selesai" value="{{ old('tanggal_selesai', $pinjamRuangan->tanggal_selesai) }}">
                        
                        <!-- Time Range Summary -->
                        <div id="timeRangeSummary" class="time-summary">
                            <div class="alert alert-info alert-modern border-0">
                                <i class="fa fa-info-circle me-2"></i>
                                <strong>Waktu terpilih:</strong> 
                                {{ date('H:i', strtotime($pinjamRuangan->waktu_mulai)) }} - 
                                {{ date('H:i', strtotime($pinjamRuangan->waktu_selesai)) }}
                            </div>
                        </div>
                    </div>
                </div>
                
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
                                          placeholder="Contoh: Rapat organisasi, seminar, workshop, dll."
                                          required>{{ old('tujuan_peminjaman', $pinjamRuangan->tujuan_peminjaman) }}</textarea>
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
                            
                            @if($pinjamRuangan->file_scan)
                                <div class="current-file">
                                    <div class="file-preview">
                                        <div class="file-icon">
                                            <i class="fa fa-file-pdf-o"></i>
                                        </div>
                                        <div class="file-details">
                                            <h6>File Saat Ini</h6>
                                            <p>{{ $pinjamRuangan->file_scan }}</p>
                                            <a href="{{ asset('storage/uploads/file_scan/' . $pinjamRuangan->file_scan) }}" 
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
                        <a href="{{ route('mahasiswa.peminjaman.pinjam-ruangan.show', $pinjamRuangan->id) }}" 
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
  <!-- Buttons -->
@push('scripts')
<script src="{{ asset('js/timeslot-selector.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const datePicker = document.getElementById('tanggal_booking');
    
   
    const existingWaktuMulai = "{{ date('H:i', strtotime($pinjamRuangan->waktu_mulai)) }}";
    const existingWaktuSelesai = "{{ date('H:i', strtotime($pinjamRuangan->waktu_selesai)) }}";
    const existingTanggal = "{{ $pinjamRuangan->tanggal_pengajuan }}";
    
   
    const timeSlotSelector = new TimeSlotSelector({
        containerId: 'timeSlots',
        loadingId: 'loadingSlots',
        startTimeInputId: 'waktu_mulai',
        endTimeInputId: 'waktu_selesai',
        slotsJsonInputId: 'selected_slots_json',
        summaryId: 'timeRangeSummary',
        submitButtonId: 'submitBtn',
        initialSlots: [],
        ruanganId: {{ $relatedBookings[0]->id_ruangan }}
    });
    
   
    function preserveExistingSelection() {
        const summaryElement = document.getElementById('timeRangeSummary');
        if (summaryElement && datePicker.value === existingTanggal) {
            summaryElement.innerHTML = `
                <div class="alert alert-info alert-modern border-0">
                    <div class="d-flex align-items-center">
                        <div class="alert-icon me-3">
                            <i class="fa fa-clock-o"></i>
                        </div>
                        <div>
                            <strong>Waktu terpilih saat ini:</strong> ${existingWaktuMulai} - ${existingWaktuSelesai}
                        </div>
                    </div>
                </div>
            `;
        }
    }
    
   
    datePicker.addEventListener('change', function() {
        if (this.value) {
            timeSlotSelector.loadTimeSlots(this.value);
            
   
            if (this.value === existingTanggal) {
                setTimeout(() => {
                    preserveExistingSelection();
                }, 500);
            }
        }
    });
    
   
    if (datePicker.value) {
        timeSlotSelector.loadTimeSlots(datePicker.value);
        
   
        if (datePicker.value === existingTanggal) {
            setTimeout(() => {
                preserveExistingSelection();
            }, 500);
        }
    }
    
   
    const originalUpdateTimeRange = timeSlotSelector.updateTimeRange;
    timeSlotSelector.updateTimeRange = function() {
        if (datePicker.value === existingTanggal && this.selectedSlots.length === 0) {
            preserveExistingSelection();
            return;
        }
        originalUpdateTimeRange.call(this);
    };
    
   
    const submitBtn = document.getElementById('submitBtn');
    if (submitBtn && datePicker.value === existingTanggal) {
        submitBtn.disabled = false;
    }
    
   
    const fileInput = document.getElementById('file_scan');
    const uploadBox = document.querySelector('.upload-box');
    
    if (fileInput && uploadBox) {
   
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
});
</script>
@endpush
@endsection