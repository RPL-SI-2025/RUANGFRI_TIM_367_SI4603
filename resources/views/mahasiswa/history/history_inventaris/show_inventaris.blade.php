
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
                                <i class="fa fa-history"></i>
                            </div>
                            <div>
                                <h4 class="text-white mb-1 fw-bold">Detail Riwayat Peminjaman Inventaris</h4>
                                <p class="text-white-50 mb-3">Informasi lengkap riwayat peminjaman dan pelaporan inventaris</p>
                                
                                <!-- Status Badge in Header -->
                                <div class="status-badge-header">
                                    <span class="badge badge-header bg-success-header text-white">
                                        <i class="fa fa-check-circle me-1"></i>Selesai
                                    </span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('mahasiswa.history.inventaris.index') }}" 
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
                        <h5 class="section-title">Informasi Peminjaman</h5>
                        <p class="section-subtitle">Detail data peminjaman dan pelaporan inventaris</p>
                    </div>
                </div>
                
                <div class="section-content">
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <div class="info-content">
                                <h6>Tanggal Peminjaman</h6>
                                <p>
                                    {{ \Carbon\Carbon::parse($laporan->peminjaman->tanggal_pengajuan ?? now())->format('d F Y') }}
                                    <span class="text-muted"> - </span>
                                    {{ \Carbon\Carbon::parse($laporan->peminjaman->tanggal_selesai ?? now())->format('d F Y') }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fa fa-clock"></i>
                            </div>
                            <div class="info-content">
                                <h6>Waktu Peminjaman</h6>
                                <p>
                                    {{ \Carbon\Carbon::parse($laporan->peminjaman->waktu_mulai ?? '00:00')->format('H:i') }} - 
                                    {{ \Carbon\Carbon::parse($laporan->peminjaman->waktu_selesai ?? '00:00')->format('H:i') }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fa fa-calendar-alt"></i>
                            </div>
                            <div class="info-content">
                                <h6>Tanggal Laporan</h6>
                                <p>{{ \Carbon\Carbon::parse($laporan->datetime)->format('d F Y') }}</p>
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
                    </div>
                </div>
            </div>

            <!-- Description Section -->
            @if($laporan->deskripsi)
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
            @endif

            <!-- Inventaris List Section -->
            <div class="section-card mb-4">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fa fa-boxes"></i>
                    </div>
                    <div>
                        <h5 class="section-title">Daftar Inventaris</h5>
                        <p class="section-subtitle">Inventaris yang dipinjam dan dilaporkan</p>
                    </div>
                </div>
                
                <div class="section-content">
                    <div class="table-responsive">
                        <table class="table table-hover table-modern">
                            <thead>
                                <tr>
                                    <th class="border-0" width="60">No</th>
                                    <th class="border-0">Nama Inventaris</th>
                                    <th class="border-0 text-center" width="120">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php 
                                    $totalItems = 0; 
                                @endphp
                                @forelse($relatedItems as $index => $item)
                                    @php 
                                        $totalItems += $item->jumlah_pinjam ?? 0; 
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="number-circle-small">{{ $index + 1 }}</div>
                                        </td>
                                        <td>
                                            <div class="inventaris-info-compact">
                                                <h6 class="mb-1">{{ $item->inventaris->nama_inventaris ?? '-' }}</h6>
                                                @if($item->inventaris && $item->inventaris->deskripsi)
                                                    <small class="text-muted">
                                                        <i class="fa fa-info-circle me-1"></i>
                                                        {{ Str::limit($item->inventaris->deskripsi, 50) }}
                                                    </small>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary rounded-pill">
                                                {{ $item->jumlah_pinjam ?? '-' }} unit
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">
                                            <i class="fa fa-inbox fa-2x mb-2 d-block"></i>
                                            Tidak ada data inventaris
                                        </td>
                                    </tr>
                                @endforelse
                                
                                @if(count($relatedItems) > 0)
                                    <tr class="table-light fw-bold border-top">
                                        <td colspan="2" class="text-end py-3">
                                            <strong>Total Item:</strong>
                                        </td>
                                        <td class="text-center py-3">
                                            <span class="badge bg-success rounded-pill fs-6">
                                                {{ $totalItems }} unit
                                            </span>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
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
                        <h5 class="section-title">Dokumentasi</h5>
                        <p class="section-subtitle">File dan foto terkait peminjaman inventaris</p>
                    </div>
                </div>
                
                <div class="section-content">
                    <div class="row">
                        <!-- File Scan -->
                        <div class="col-md-4 mb-4">
                            <div class="documentation-card">
                                <div class="documentation-header">
                                    <h6 class="mb-0">
                                        <i class="fa fa-file-pdf me-2"></i>File Scan
                                    </h6>
                                </div>
                                <div class="documentation-body">
                                    @if($laporan->peminjaman && $laporan->peminjaman->file_scan)
                                        <div class="text-center">
                                            <i class="fa fa-file-pdf fa-3x text-danger mb-3"></i>
                                            <p class="mb-0">Dokumen tersedia</p>
                                        </div>
                                    @else
                                        <div class="no-image-placeholder">
                                            <i class="fa fa-file"></i>
                                            <p>Tidak ada file</p>
                                        </div>
                                    @endif
                                </div>
                                @if($laporan->peminjaman && $laporan->peminjaman->file_scan)
                                    <div class="documentation-footer">
                                        <a href="{{ asset('storage/uploads/file_scan/' . $laporan->peminjaman->file_scan) }}" 
                                           class="btn btn-outline-primary btn-sm w-100" 
                                           target="_blank">
                                            <i class="fa fa-external-link me-1"></i>Buka Dokumen
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Foto Awal -->
                        <div class="col-md-4 mb-4">
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
                        
                        <!-- Foto Akhir -->
                        <div class="col-md-4 mb-4">
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

            <!-- Admin Notes Section -->
            @if($laporan->keterangan)
            <div class="section-card mb-4">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fa fa-comment"></i>
                    </div>
                    <div>
                        <h5 class="section-title">Keterangan Admin</h5>
                        <p class="section-subtitle">Catatan dari admin logistik</p>
                    </div>
                </div>
                
                <div class="section-content">
                    <div class="description-content">
                        <div class="description-box">
                            <div class="description-text">
                                {{ $laporan->keterangan }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="action-section">
                <div class="action-buttons">
                    <a href="{{ route('mahasiswa.history.inventaris.index') }}" 
                       class="btn btn-secondary btn-lg">
                        <i class="fa fa-arrow-left me-2"></i>Kembali ke Riwayat
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark">
            <div class="modal-header border-0">
                <h5 class="modal-title text-white" id="imageModalLabel">
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
        imageModal.addEventListener('show.bs.modal', function (event) {
            resetZoom();
        });
    }
}

function openImageModal(imgElement) {
    const modal = new bootstrap.Modal(document.getElementById('imageModal'));
    const modalImage = document.getElementById('modalImage');
    
    if (modalImage && imgElement) {
        modalImage.src = imgElement.src;
        modalImage.alt = imgElement.alt;
        modal.show();
        
        console.log('Image modal opened with:', imgElement.src);
    }
}

function zoomIn() {
    console.log('zoomIn called');
    const modalImage = document.getElementById('modalImage');
    if (!modalImage) {
        console.error('Modal image not found');
        return;
    }
    
    currentZoom = Math.min(currentZoom * 1.2, 3);
    modalImage.style.transform = `scale(${currentZoom})`;
    modalImage.style.cursor = currentZoom >= 3 ? 'zoom-out' : 'zoom-in';
    
    console.log('New zoom level:', currentZoom);
    
   
    updateZoomInfo();
}

function zoomOut() {
    console.log('zoomOut called');
    const modalImage = document.getElementById('modalImage');
    if (!modalImage) {
        console.error('Modal image not found');
        return;
    }
    
    currentZoom = Math.max(currentZoom / 1.2, 0.5);
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

   
document.addEventListener('click', function(e) {
   
    if (e.target.id === 'modalImage') {
        if (e.shiftKey) {
            zoomOut();
        } else {
            zoomIn();
        }
    }
    
   
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
}

.description-text {
    line-height: 1.6;
    color: #495057;
}

.inventaris-info-compact h6 {
    color: #2c3e50;
    font-weight: 600;
}

.number-circle-small {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 0.875rem;
}

.table-modern {
    border: none;
}

.table-modern th {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    color: #495057;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
    padding: 15px 12px;
}

.table-modern td {
    padding: 15px 12px;
    vertical-align: middle;
    border-bottom: 1px solid #f1f3f4;
}

.table-modern tbody tr:hover {
    background-color: rgba(102, 126, 234, 0.05);
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}


.image-zoom-container {
    overflow: hidden;
    max-height: 70vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.zoom-image {
    transition: transform 0.3s ease;
    cursor: zoom-in;
}

.zoom-controls {
    display: flex;
    align-items: center;
    gap: 10px;
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
    
    .info-grid {
        grid-template-columns: 1fr;
    }
}
</style>

@endsection