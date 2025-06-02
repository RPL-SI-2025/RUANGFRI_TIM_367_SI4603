
@extends('mahasiswa.layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/show_peminjaman.css') }}">
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-10 col-xl-9">
            <!-- Enhanced Header Card with Status -->
            <div class="card border-0 shadow-lg mb-4 header-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper me-3">
                                <i class="fa fa-clipboard-check"></i>
                            </div>
                            <div>
                                <h4 class="text-white mb-1 fw-bold">Detail Laporan Ruangan</h4>
                                <p class="text-white-50 mb-3">Informasi lengkap laporan pengembalian ruangan</p>
                                
                                <!-- Status Badge in Header -->
                                <div class="status-badge-header">
                                    <span class="badge badge-header bg-success-header text-white">
                                        <i class="fa fa-check-circle me-1"></i>Laporan Selesai
                                    </span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('mahasiswa.pelaporan.lapor_ruangan.index') }}" 
                           class="btn btn-outline-light btn-floating">
                            <i class="fa fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>

            <!-- Report Information Section -->
            <div class="section-card mb-4">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fa fa-info-circle"></i>
                    </div>
                    <div>
                        <h5 class="section-title">Informasi Laporan</h5>
                        <p class="section-subtitle">Detail laporan pengembalian ruangan</p>
                    </div>
                </div>
                
                <div class="section-content">
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fa fa-hashtag"></i>
                            </div>
                            <div class="info-content">
                                <h6>ID Laporan</h6>
                                <p>{{ $laporan->id_lapor_ruangan }}</p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <div class="info-content">
                                <h6>Tanggal Pelaporan</h6>
                                <p>{{ \Carbon\Carbon::parse($laporan->created_at)->format('d F Y H:i') }}</p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fa fa-calendar-check"></i>
                            </div>
                            <div class="info-content">
                                <h6>Tanggal Peminjaman</h6>
                                <p>
                                    {{ \Carbon\Carbon::parse($laporan->peminjaman->tanggal_pengajuan)->format('d F Y') }}
                                    <span class="text-muted"> - </span>
                                    {{ \Carbon\Carbon::parse($laporan->peminjaman->tanggal_selesai)->format('d F Y') }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fa fa-building"></i>
                            </div>
                            <div class="info-content">
                                <h6>Ruangan</h6>
                                <p>{{ $laporan->ruangan->nama_ruangan ?? 'Tidak ada data' }}</p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fa fa-map-marker"></i>
                            </div>
                            <div class="info-content">
                                <h6>Lokasi</h6>
                                <p>{{ $laporan->ruangan->lokasi ?? 'Tidak ada data' }}</p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fa fa-user"></i>
                            </div>
                            <div class="info-content">
                                <h6>Dibuat Oleh</h6>
                                <p>{{ $laporan->oleh }}</p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fa fa-user-tie"></i>
                            </div>
                            <div class="info-content">
                                <h6>Diberikan Kepada</h6>
                                <p>{{ $laporan->logistik->nama ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description Section -->
            <div class="section-card mb-4">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fa fa-file-text"></i>
                    </div>
                    <div>
                        <h5 class="section-title">Deskripsi Laporan</h5>
                        <p class="section-subtitle">Keterangan kondisi ruangan</p>
                    </div>
                </div>
                
                <div class="section-content">
                    <div class="description-content">
                        <div class="description-box">
                            <div class="description-text">
                                {{ $laporan->deskripsi }}
                            </div>
                        </div>
                    </div>
                    
                    @if($laporan->keterangan)
                    <div class="admin-notes-section">
                        <div class="admin-notes-header">
                            <h6 class="mb-0">
                                <i class="fa fa-comment-dots me-2"></i>Keterangan Admin
                            </h6>
                        </div>
                        <div class="admin-notes-content">
                            <div class="alert alert-info alert-modern border-0">
                                <div class="d-flex align-items-start">
                                    <div class="alert-icon me-3">
                                        <i class="fa fa-info-circle"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0">{{ $laporan->keterangan }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
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
                        <p class="section-subtitle">Foto kondisi ruangan sebelum dan sesudah digunakan</p>
                    </div>
                </div>
                
                <div class="section-content">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="documentation-card">
                                <div class="documentation-header">
                                    <h6 class="mb-0">
                                        <i class="fa fa-camera me-2"></i>Foto Kondisi Awal
                                    </h6>
                                </div>
                                <div class="documentation-body">
                                    @if($laporan->foto_awal)
                                        <div class="image-container">
                                            <img src="{{ asset('storage/' . $laporan->foto_awal) }}" 
                                                 class="documentation-image" 
                                                 alt="Foto Kondisi Awal"
                                                 onclick="openImageModal(this)">
                                        </div>
                                    @else
                                        <div class="no-image-placeholder">
                                            <i class="fa fa-image"></i>
                                            <p>Tidak ada foto</p>
                                        </div>
                                    @endif
                                </div>
                                @if($laporan->foto_awal)
                                    <div class="documentation-footer">
                                        <a href="{{ asset('storage/' . $laporan->foto_awal) }}" 
                                           class="btn btn-outline-primary btn-sm" 
                                           target="_blank">
                                            <i class="fa fa-external-link me-1"></i>Buka di Tab Baru
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <div class="documentation-card">
                                <div class="documentation-header">
                                    <h6 class="mb-0">
                                        <i class="fa fa-camera me-2"></i>Foto Kondisi Akhir
                                    </h6>
                                </div>
                                <div class="documentation-body">
                                    @if($laporan->foto_akhir)
                                        <div class="image-container">
                                            <img src="{{ asset('storage/' . $laporan->foto_akhir) }}" 
                                                 class="documentation-image" 
                                                 alt="Foto Kondisi Akhir"
                                                 onclick="openImageModal(this)">
                                        </div>
                                    @else
                                        <div class="no-image-placeholder">
                                            <i class="fa fa-image"></i>
                                            <p>Tidak ada foto</p>
                                        </div>
                                    @endif
                                </div>
                                @if($laporan->foto_akhir)
                                    <div class="documentation-footer">
                                        <a href="{{ asset('storage/' . $laporan->foto_akhir) }}" 
                                           class="btn btn-outline-primary btn-sm" 
                                           target="_blank">
                                            <i class="fa fa-external-link me-1"></i>Buka di Tab Baru
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-section">
                <div class="action-buttons">
                    <a href="{{ route('mahasiswa.pelaporan.lapor_ruangan.edit', $laporan->id_lapor_ruangan) }}" 
                       class="btn btn-warning btn-lg">
                        <i class="fa fa-edit me-2"></i>Edit Laporan
                    </a>
                    <a href="{{ route('mahasiswa.pelaporan.lapor_ruangan.download-pdf', $laporan->id_lapor_ruangan) }}" 
                       class="btn btn-success btn-lg">
                        <i class="fa fa-download me-2"></i>Download Laporan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Preview Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="imageModalLabel">
                    <i class="fa fa-search-plus me-2"></i>Preview Foto
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-0">
                <div class="image-zoom-container">
                    <img id="modalImage" src="" class="img-fluid zoom-image" alt="Preview">
                </div>
            </div>
            <div class="modal-footer bg-light">
                <div class="zoom-controls">
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="zoomOut()">
                        <i class="fa fa-search-minus"></i> Zoom Out
                    </button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="resetZoom()">
                        <i class="fa fa-refresh"></i> Reset
                    </button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="zoomIn()">
                        <i class="fa fa-search-plus"></i> Zoom In
                    </button>
                    <span class="badge bg-secondary ms-2" id="zoomIndicator">100%</span>
                </div>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fa fa-times me-1"></i>Tutup
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let currentZoom = 1;

document.addEventListener('DOMContentLoaded', function() {
   
    initializeImageModal();
    
   
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
});

function initializeImageModal() {
    const imageModal = document.getElementById('imageModal');
    if (imageModal) {
        imageModal.addEventListener('hidden.bs.modal', function () {
            resetZoom();
        });
    }
}

function openImageModal(imgElement) {
    const modal = new bootstrap.Modal(document.getElementById('imageModal'));
    const modalImage = document.getElementById('modalImage');
    modalImage.src = imgElement.src;
    modalImage.alt = imgElement.alt;
    resetZoom();
    modal.show();
}

function zoomIn() {
    currentZoom = Math.min(currentZoom + 0.2, 3);
    updateZoom();
}

function zoomOut() {
    currentZoom = Math.max(currentZoom - 0.2, 0.5);
    updateZoom();
}

function resetZoom() {
    currentZoom = 1;
    updateZoom();
}

function updateZoom() {
    const modalImage = document.getElementById('modalImage');
    const zoomIndicator = document.getElementById('zoomIndicator');
    
    if (modalImage) {
        modalImage.style.transform = `scale(${currentZoom})`;
        modalImage.style.transformOrigin = 'center center';
    }
    
    if (zoomIndicator) {
        zoomIndicator.textContent = Math.round(currentZoom * 100) + '%';
    }
}

   
document.addEventListener('keydown', function(e) {
    const imageModal = document.getElementById('imageModal');
    if (imageModal && imageModal.classList.contains('show')) {
        switch(e.key) {
            case '+':
            case '=':
                e.preventDefault();
                zoomIn();
                break;
            case '-':
                e.preventDefault();
                zoomOut();
                break;
            case '0':
                e.preventDefault();
                resetZoom();
                break;
            case 'Escape':
   
                break;
        }
    }
});
</script>
@endpush

<style>

.documentation-card {
    background: #fff;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    height: 100%;
    display: flex;
    flex-direction: column;
}

.documentation-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 15px;
    font-weight: 600;
}

.documentation-body {
    padding: 15px;
    height: 300px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-grow: 1;
}

.documentation-footer {
    padding: 15px;
    border-top: 1px solid #e9ecef;
    background: #f8f9fa;
    display: flex;
    gap: 8px;
    justify-content: center;
}

.image-container {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.documentation-image {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    border-radius: 8px;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.documentation-image:hover {
    transform: scale(1.05);
}

.no-image-placeholder {
    text-align: center;
    color: #6c757d;
}

.no-image-placeholder i {
    font-size: 3rem;
    margin-bottom: 10px;
    opacity: 0.5;
}

.no-image-placeholder p {
    margin: 0;
    font-style: italic;
}

.description-content {
    padding: 20px 0;
}

.description-box {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 20px;
    border-left: 4px solid #28a745;
}

.description-text {
    font-size: 16px;
    line-height: 1.6;
    color: #495057;
    margin: 0;
}

.admin-notes-section {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid #e9ecef;
}

.admin-notes-header {
    margin-bottom: 15px;
}

.admin-notes-header h6 {
    color: #495057;
    font-weight: 600;
}


.zoom-btn {
    transition: all 0.3s ease;
}

.zoom-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}


.image-zoom-container {
    overflow: auto;
    max-height: 70vh;
    position: relative;
}

.zoom-image {
    transition: transform 0.3s ease;
    max-width: none;
    cursor: zoom-in;
}

.zoom-controls {
    display: flex;
    gap: 8px;
    align-items: center;
}

.modal-xl {
    max-width: 90%;
}


@media (max-width: 768px) {
    .documentation-footer {
        flex-direction: column;
        gap: 8px;
    }
    
    .documentation-footer .btn {
        width: 100%;
    }
    
    .zoom-controls {
        flex-direction: column;
        gap: 5px;
    }
    
    .zoom-controls .btn {
        width: 100%;
    }
}
</style>

@endsection