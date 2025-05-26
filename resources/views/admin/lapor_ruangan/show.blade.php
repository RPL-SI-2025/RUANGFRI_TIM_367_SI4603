
@extends('admin.layouts.admin')

@section('title', 'Detail Laporan Ruangan')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Card dengan Gradient -->
    <div class="card border-0 shadow-lg mb-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="bg-gradient-primary text-white p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-2 fw-bold">
                            <i class="fas fa-clipboard-check me-3"></i>Detail Laporan Ruangan #{{ $pelaporan->id_lapor_ruangan }}
                        </h3>
                    </div>
                    <div class="text-end">
                        @if(isset($pelaporan->status))
                            @if($pelaporan->status == 1)
                                <span class="badge bg-success rounded-pill px-4 py-2 fs-6 shadow">
                                    <i class="fas fa-check-circle me-2"></i> Diverifikasi
                                </span>
                            @else
                                <span class="badge bg-warning rounded-pill px-4 py-2 fs-6 shadow">
                                    <i class="fas fa-clock me-2"></i> Menunggu Verifikasi
                                </span>
                            @endif
                        @endif
                        <div class="mt-2">
                            <a href="{{ route('admin.lapor_ruangan.index') }}" class="btn btn-light rounded-pill px-4 py-2 fw-medium">
                                <i class="fas fa-arrow-left me-2"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-light p-3 border-top border-white border-opacity-25">
                <div class="d-flex align-items-center justify-content-center">
                    <i class="fas fa-calendar-alt text-primary me-2"></i>
                    <span class="text-muted fw-medium">Dilaporkan pada:</span>
                    <strong class="ms-2 text-dark">{{ \Carbon\Carbon::parse($pelaporan->created_at)->format('d M Y H:i') }}</strong>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Informasi Laporan Card -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100 hover-lift">
                <div class="card-header bg-gradient-info text-white py-3 border-0">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-info text-white me-3 shadow-sm">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <h5 class="mb-0 fw-bold">Informasi Laporan</h5>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="info-list">
                        <div class="info-item mb-3 p-3 bg-white rounded-3 border">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-calendar-range text-primary me-3 fs-5"></i>
                                <div>
                                    <strong class="d-block text-dark">Tanggal Peminjaman</strong>
                                    <span class="text-muted">
                                        {{ \Carbon\Carbon::parse($pelaporan->peminjaman->tanggal_pengajuan)->format('d M Y') }}
                                        <span class="mx-2">s/d</span>
                                        {{ \Carbon\Carbon::parse($pelaporan->peminjaman->tanggal_pengajuan)->format('d M Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="info-item mb-3 p-3 bg-white rounded-3 border">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-door-open text-success me-3 fs-5"></i>
                                <div>
                                    <strong class="d-block text-dark">Ruangan</strong>
                                    <span class="text-muted">{{ $pelaporan->ruangan->nama_ruangan ?? 'Tidak ada data' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="info-item mb-3 p-3 bg-white rounded-3 border">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-map-marker-alt text-danger me-3 fs-5"></i>
                                <div>
                                    <strong class="d-block text-dark">Lokasi</strong>
                                    <span class="text-muted">{{ $pelaporan->ruangan->lokasi ?? 'Tidak ada data' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="info-item mb-3 p-3 bg-white rounded-3 border">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user text-warning me-3 fs-5"></i>
                                <div>
                                    <strong class="d-block text-dark">Dibuat Oleh</strong>
                                    <span class="text-muted">{{ $pelaporan->oleh }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="info-item p-3 bg-white rounded-3 border">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user-tie text-purple me-3 fs-5"></i>
                                <div>
                                    <strong class="d-block text-dark">Diberikan Kepada</strong>
                                    <span class="text-muted">{{ $pelaporan->logistik->nama ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Deskripsi Card -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100 hover-lift">
                <div class="card-header bg-gradient-warning text-white py-3 border-0">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-warning text-white me-3 shadow-sm">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <h5 class="mb-0 fw-bold">Deskripsi Laporan</h5>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="description-content">
                        <div class="bg-white border-start border-0  p-4 rounded-3 mb-4 border ">
                            <h6 class="text-primary fw-bold mb-2">
                                <i class="fas fa-quote-left me-2"></i>Laporan Mahasiswa
                            </h6>
                            <p class="mb-0 text-dark lh-lg">{{ $pelaporan->deskripsi }}</p>
                        </div>
                        @if($pelaporan->keterangan)
                        <div class="bg-white border-start border-4 border-success p-4 rounded-3 border shadow-sm">
                            <h6 class="text-success fw-bold mb-2">
                                <i class="fas fa-user-cog me-2"></i>Keterangan Admin
                            </h6>
                            <p class="mb-0 text-dark lh-lg">{{ $pelaporan->keterangan }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dokumentasi Section Card -->
    <div class="card border-0 shadow-lg hover-lift">
        <div class="card-header bg-gradient-dark text-white py-4 border-0">
            <div class="d-flex align-items-center justify-content-center">
                <div class="icon-circle bg-dark text-white me-3 shadow">
                    <i class="fas fa-camera"></i>
                </div>
                <h4 class="mb-0 fw-bold">Dokumentasi Foto</h4>
            </div>
        </div>
        <div class="card-body p-5">
            <div class="row g-4">
                <!-- Foto Kondisi Awal -->
                <div class="col-md-6">
                    <div class="photo-card border-0 shadow-sm h-100 hover-lift">
                        <div class="photo-header bg-gradient-primary text-white p-3 rounded-top">
                            <h6 class="mb-0 fw-bold text-center">
                                <i class="fas fa-camera-retro me-2"></i>Foto Kondisi Awal
                            </h6>
                        </div>
                        <div class="photo-body p-4 text-center bg-light rounded-bottom">
                            @if($pelaporan->foto_awal)
                                <div class="position-relative d-inline-block">
                                    <img src="{{ asset('storage/' . $pelaporan->foto_awal) }}" 
                                         class="img-fluid rounded-3 shadow-sm mb-3 photo-hover" 
                                         alt="Foto Kondisi Awal"
                                         style="max-height: 250px; object-fit: cover; width: 100%;">
                                    <div class="photo-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center rounded-3">
                                        <a href="{{ asset('storage/' . $pelaporan->foto_awal) }}" 
                                           class="btn btn-primary rounded-pill px-4 py-2 shadow" 
                                           target="_blank">
                                            <i class="fas fa-expand-alt me-2"></i> Lihat Full
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="empty-photo bg-white border border-dashed border-2 border-primary rounded-3 p-5">
                                    <i class="fas fa-image text-primary display-4 mb-3"></i>
                                    <p class="text-muted mb-0 fw-medium">Tidak ada foto tersedia</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Foto Kondisi Akhir -->
                <div class="col-md-6">
                    <div class="photo-card border-0 shadow-sm h-100 hover-lift">
                        <div class="photo-header bg-gradient-success text-white p-3 rounded-top">
                            <h6 class="mb-0 fw-bold text-center">
                                <i class="fas fa-camera me-2"></i>Foto Kondisi Akhir
                            </h6>
                        </div>
                        <div class="photo-body p-4 text-center bg-light rounded-bottom">
                            @if($pelaporan->foto_akhir)
                                <div class="position-relative d-inline-block">
                                    <img src="{{ asset('storage/' . $pelaporan->foto_akhir) }}" 
                                         class="img-fluid rounded-3 shadow-sm mb-3 photo-hover" 
                                         alt="Foto Kondisi Akhir"
                                         style="max-height: 250px; object-fit: cover; width: 100%;">
                                    <div class="photo-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center rounded-3">
                                        <a href="{{ asset('storage/' . $pelaporan->foto_akhir) }}" 
                                           class="btn btn-success rounded-pill px-4 py-2 shadow" 
                                           target="_blank">
                                            <i class="fas fa-expand-alt me-2"></i> Lihat Full
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="empty-photo bg-white border border-dashed border-2 border-success rounded-3 p-5">
                                    <i class="fas fa-image text-success display-4 mb-3"></i>
                                    <p class="text-muted mb-0 fw-medium">Tidak ada foto tersedia</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Primary Styles */
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    --success-gradient: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
    --dark-gradient: linear-gradient(135deg, #2c3e50 0%, #4ca1af 100%);
}

.bg-gradient-primary {
    background: var(--primary-gradient);
}

.bg-gradient-info {
    background: var(--info-gradient);
}

.bg-gradient-warning {
    background: var(--warning-gradient);
}

.bg-gradient-success {
    background: var(--success-gradient);
}

.bg-gradient-dark {
    background: var(--dark-gradient);
}

/* Card Styles */
.card {
    border-radius: 1rem;
    overflow: hidden;
    transition: all 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
}

.card-header {
    border-bottom: none;
}

/* Enhanced Icon Circle */
.icon-circle {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    font-weight: bold;
    transition: all 0.3s ease;
}

/* Enhanced Info List Styles */
.info-list .info-item {
    transition: all 0.3s ease;
    border: 1px solid #e9ecef !important;
    background-color: #ffffff !important;
    box-shadow: 0 2px 4px rgba(0,0,0,0.04);
}

.info-list .info-item:hover {
    background-color: #f8f9fa !important;
    border-color: #dee2e6 !important;
    transform: translateX(5px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

/* Enhanced Description Content */
.description-content .border-start {
    transition: all 0.3s ease;
    background-color: #ffffff !important;
    box-shadow: 0 2px 4px rgba(0,0,0,0.04);
}

.description-content .border-start:hover {
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transform: translateX(5px);
    background-color: #f8f9fa !important;
}

/* Photo Styles */
.photo-card {
    border-radius: 1rem;
    overflow: hidden;
}

.photo-hover {
    transition: all 0.3s ease;
}

.photo-overlay {
    background: rgba(0,0,0,0.7);
    opacity: 0;
    transition: all 0.3s ease;
}

.photo-card:hover .photo-overlay {
    opacity: 1;
}

.photo-card:hover .photo-hover {
    transform: scale(1.05);
}

/* Badge Styles */
.badge {
    font-weight: 600;
    letter-spacing: 0.5px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

/* Button Styles */
.btn {
    font-weight: 600;
    transition: all 0.3s ease;
    border-radius: 50rem;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

/* Empty Photo Styles */
.empty-photo {
    transition: all 0.3s ease;
}

.empty-photo:hover {
    border-color: var(--bs-primary) !important;
    background-color: rgba(var(--bs-primary-rgb), 0.05);
}

/* Text Colors */
.text-purple {
    color: #6f42c1 !important;
}

/* Card Body Background */
.card-body {
    background-color: #f8f9fa;
}

/* Responsive */
@media (max-width: 768px) {
    .container-fluid {
        padding: 1rem;
    }
    
    .card-body {
        padding: 1.5rem !important;
    }
    
    .icon-circle {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
}

/* Animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.card {
    animation: fadeInUp 0.5s ease-out;
}

.card:nth-child(1) { animation-delay: 0.1s; }
.card:nth-child(2) { animation-delay: 0.2s; }
.card:nth-child(3) { animation-delay: 0.3s; }
</style>
@endsection