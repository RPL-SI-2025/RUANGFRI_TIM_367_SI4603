
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
                                <h4 class="text-white mb-1 fw-bold">Detail Laporan Inventaris</h4>
                                <p class="text-white-50 mb-3">Informasi lengkap laporan pengembalian inventaris</p>
                                
                                <!-- Status Badge in Header -->
                                <div class="status-badge-header">
                                    <span class="badge badge-header bg-success-header text-white">
                                        <i class="fa fa-check-circle me-1"></i>Laporan Selesai
                                    </span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('mahasiswa.pelaporan.lapor_inventaris.index') }}" 
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
                        <p class="section-subtitle">Detail data laporan pengembalian inventaris</p>
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
                                <p>{{ $laporan->id_lapor_inventaris }}</p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fa fa-link"></i>
                            </div>
                            <div class="info-content">
                                <h6>ID Peminjaman</h6>
                                <p><strong>{{ $laporan->peminjaman->id }}</strong></p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <div class="info-content">
                                <h6>Tanggal Laporan</h6>
                                <p>{{ \Carbon\Carbon::parse($laporan->datetime)->format('d F Y') }}</p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fa fa-user"></i>
                            </div>
                            <div class="info-content">
                                <h6>Dibuat Oleh</h6>
                                <p>{{ $laporan->mahasiswa->nama_mahasiswa ?? 'N/A' }}</p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fa fa-user-tie"></i>
                            </div>
                            <div class="info-content">
                                <h6>Admin Logistik</h6>
                                <p>{{ $laporan->logistik->nama ?? 'N/A' }}</p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fa fa-paper-plane"></i>
                            </div>
                            <div class="info-content">
                                <h6>Ditujukan Kepada</h6>
                                <p>{{ $laporan->kepada }}</p>
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
                        <p class="section-subtitle">Keterangan kondisi inventaris</p>
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
                        <p class="section-subtitle">Foto kondisi inventaris sebelum dan sesudah digunakan</p>
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
                    <a href="{{ route('mahasiswa.pelaporan.lapor_inventaris.edit', $laporan->id_lapor_inventaris) }}" 
                       class="btn btn-warning btn-lg">
                        <i class="fa fa-edit me-2"></i>Edit Laporan
                    </a>
                    <a href="{{ route('mahasiswa.pelaporan.lapor_inventaris.download-pdf', $laporan->id_lapor_inventaris) }}" 
                       class="btn btn-success btn-lg">
                        <i class="fa fa-file-pdf me-2"></i>Download PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="imageModalTitle">
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
    const modalImage = document.getElementById('modalImage');
    
    if (!imageModal || !modalImage) {
        console.error('Modal elements not found');
        return;
    }
    
   
    imageModal.addEventListener('wheel', function(e) {
        if (e.target.id === 'modalImage') {
            e.preventDefault();
            if (e.deltaY < 0) {
                zoomIn();
            } else {
                zoomOut();
            }
        }
    });
    
   
    modalImage.addEventListener('click', function() {
        if (currentZoom < 2) {
            zoomIn();
        } else {
            resetZoom();
        }
    });
    
   
    imageModal.addEventListener('hidden.bs.modal', function() {
        resetZoom();
    });
}

   
function openImageModal(img) {
    if (!img || !img.src) {
        console.error('Invalid image element');
        return;
    }
    
    const imageModal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    const modalTitle = document.getElementById('imageModalTitle');
    
    if (!imageModal || !modalImage || !modalTitle) {
        console.error('Modal elements not found');
        return;
    }
    
    modalImage.src = img.src;
    modalTitle.innerHTML = '<i class="fa fa-search-plus me-2"></i>' + img.alt;
    
   
    currentZoom = 1;
    modalImage.style.transform = `scale(${currentZoom})`;
    modalImage.style.cursor = 'zoom-in';
    
   
    const modal = new bootstrap.Modal(imageModal, {
        backdrop: true,
        keyboard: true,
        focus: true
    });
    modal.show();
    
   
    setTimeout(() => {
        updateZoomInfo();
    }, 100);
}

   
function zoomIn() {
    console.log('zoomIn called, current zoom:', currentZoom);
    const modalImage = document.getElementById('modalImage');
    if (!modalImage) {
        console.error('Modal image not found');
        return;
    }
    
    currentZoom = Math.min(currentZoom + 0.25, 3);   
    modalImage.style.transform = `scale(${currentZoom})`;
    modalImage.style.cursor = currentZoom >= 3 ? 'zoom-out' : 'zoom-in';
    
    console.log('New zoom level:', currentZoom);
    
   
    updateZoomInfo();
}

function zoomOut() {
    console.log('zoomOut called, current zoom:', currentZoom);
    const modalImage = document.getElementById('modalImage');
    if (!modalImage) {
        console.error('Modal image not found');
        return;
    }
    
    currentZoom = Math.max(currentZoom - 0.25, 0.5);   
    modalImage.style.transform = `scale(${currentZoom})`;
    modalImage.style.cursor = currentZoom <= 0.5 ? 'zoom-in' : 'zoom-out';
    
    console.log('New zoom level:', currentZoom);
    
   
    updateZoomInfo();
}

function resetZoom() {
    console.log('resetZoom called');
    const modalImage = document.getElementById('modalImage');
    if (!modalImage) {
        console.error('Modal image not found');
        return;
    }
    
    currentZoom = 1;
    modalImage.style.transform = `scale(${currentZoom})`;
    modalImage.style.cursor = 'zoom-in';
    
    console.log('Zoom reset to:', currentZoom);
    
   
    updateZoomInfo();
}

function updateZoomInfo() {
    const zoomPercentage = Math.round(currentZoom * 100);
    const zoomIndicator = document.getElementById('zoomIndicator');
    if (zoomIndicator) {
        zoomIndicator.textContent = `${zoomPercentage}%`;
        console.log(`Zoom indicator updated: ${zoomPercentage}%`);
    } else {
        console.error('Zoom indicator not found');
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

   
document.addEventListener('click', function(e) {
   
    if (e.target.closest('[onclick="zoomIn()"]')) {
        e.preventDefault();
        zoomIn();
    }
    
   
    if (e.target.closest('[onclick="zoomOut()"]')) {
        e.preventDefault();
        zoomOut();
    }
    
   
    if (e.target.closest('[onclick="resetZoom()"]')) {
        e.preventDefault();
        resetZoom();
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
    background: #f8f9fa;
    border-top: 1px solid #e9ecef;
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