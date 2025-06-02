
@extends('mahasiswa.layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/peminjaman_index.css') }}">
<div class="container py-4">
    <!-- Enhanced Header Section -->
    <div class="header-container">
        <div class="header-background">
            <div class="header-pattern"></div>
            <div class="header-glow"></div>
        </div>
        <div class="header-content">
            <div class="header-left">
                <div class="header-icon-wrapper">
                    <div class="header-icon-bg">
                        <i class="fa fa-history header-icon"></i>
                    </div>
                    <div class="header-icon-pulse"></div>
                </div>
                <div class="header-text">
                    <h1 class="header-title">
                        Riwayat Peminjaman
                        <span class="header-title-highlight">Ruangan</span>
                    </h1>
                    <p class="header-subtitle">
                        <i class="fa fa-chart-line me-2"></i>
                        Lihat riwayat lengkap peminjaman dan pelaporan ruangan yang telah selesai
                    </p>
                    <div class="header-breadcrumb">
                        <span class="breadcrumb-item">
                            <i class="fa fa-home"></i> Dashboard
                        </span>
                        <i class="fa fa-chevron-right breadcrumb-separator"></i>
                        <span class="breadcrumb-item active">Riwayat Ruangan</span>
                    </div>
                </div>
            </div>
            <div class="header-right">
                <div class="header-stats">
                    <div class="stat-card">
                        <div class="stat-number">{{ count($paginatedRuangan) }}</div>
                        <div class="stat-label">Total Riwayat</div>
                        <div class="stat-indicator stat-success"></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">{{ count($paginatedRuangan->where('foto_awal')) }}</div>
                        <div class="stat-label">Dengan Foto</div>
                        <div class="stat-indicator stat-info"></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">{{ $paginatedRuangan->where('created_at', '>=', \Carbon\Carbon::now()->startOfWeek())->count() }}</div>
                        <div class="stat-label">Minggu Ini</div>
                        <div class="stat-indicator stat-warning"></div>
                    </div>
                </div>
                <div class="header-actions">
                    <a href="{{ route('mahasiswa.peminjaman.pinjam-ruangan.index') }}" class="btn-futuristic btn-primary-futuristic">
                        <div class="btn-bg"></div>
                        <div class="btn-content">
                            <i class="fa fa-arrow-left btn-icon"></i>
                            <span class="btn-text">Kembali ke Peminjaman</span>
                            <div class="btn-glow"></div>
                        </div>
                        <div class="btn-particles">
                            <div class="particle"></div>
                            <div class="particle"></div>
                            <div class="particle"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="header-wave">
            <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M0,60 C300,0 600,120 900,60 C1050,30 1150,90 1200,60 L1200,120 L0,120 Z" fill="rgba(255,255,255,0.1)"></path>
            </svg>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-lg alert-futuristic" role="alert">
            <div class="alert-bg"></div>
            <div class="d-flex align-items-center position-relative">
                <div class="alert-icon-wrapper me-3">
                    <div class="alert-icon-bg bg-success">
                        <i class="fa fa-check"></i>
                    </div>
                    <div class="alert-icon-pulse"></div>
                </div>
                <div class="alert-content">
                    <div class="alert-title">Berhasil!</div>
                    <div class="alert-message">{{ session('success') }}</div>
                </div>
                <button type="button" class="btn-close btn-close-futuristic" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-lg alert-futuristic" role="alert">
            <div class="alert-bg alert-bg-danger"></div>
            <div class="d-flex align-items-center position-relative">
                <div class="alert-icon-wrapper me-3">
                    <div class="alert-icon-bg bg-danger">
                        <i class="fa fa-exclamation-triangle"></i>
                    </div>
                    <div class="alert-icon-pulse"></div>
                </div>
                <div class="alert-content">
                    <div class="alert-title">Error!</div>
                    <div class="alert-message">{{ session('error') }}</div>
                </div>
                <button type="button" class="btn-close btn-close-futuristic" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <!-- Main Content Card -->
    <div class="card border-0 shadow-lg main-card">
        <div class="card-header bg-gradient-primary text-white py-3 border-0 card-header-futuristic">
            <div class="card-header-bg"></div>
            <div class="d-flex align-items-center position-relative">
                <div class="icon-circle bg-white text-primary me-3">
                    <i class="fa fa-door-open"></i>
                </div>
                <h5 class="mb-0 fw-bold">Riwayat Peminjaman Ruangan</h5>
                <div class="card-header-glow"></div>
            </div>
        </div>
        
        <div class="card-body p-0">
            @if(count($paginatedRuangan) > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3 fw-bold">
                                    <div class="d-flex align-items-center">
                                        <div class="number-circle bg-primary text-white me-2">
                                            #
                                        </div>
                                        No
                                    </div>
                                </th>
                                <th class="px-4 py-3 fw-bold">
                                    <i class="fa fa-calendar text-primary me-2"></i>Laporan Dibuat
                                </th>
                                <th class="px-4 py-3 fw-bold">
                                    <i class="fa fa-calendar-check text-primary me-2"></i>Tanggal Peminjaman
                                </th>
                                <th class="px-4 py-3 fw-bold">
                                    <i class="fa fa-door-open text-primary me-2"></i>Ruangan
                                </th>
                                <th class="px-4 py-3 fw-bold">
                                    <i class="fa fa-file text-primary me-2"></i>Dokumen
                                </th>
                                <th class="px-4 py-3 fw-bold">
                                    <i class="fa fa-camera text-primary me-2"></i>Foto
                                </th>
                                <th class="px-4 py-3 fw-bold">
                                    <i class="fa fa-info-circle text-primary me-2"></i>Status
                                </th>
                                <th class="px-4 py-3 fw-bold text-center">
                                    <i class="fa fa-cogs text-primary me-2"></i>Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paginatedRuangan as $item)
                                <tr class="hover-row">
                                    <td class="px-4 py-3">
                                        <div class="number-circle bg-light text-dark">
                                            {{ $loop->iteration }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark">{{ \Carbon\Carbon::parse($item->datetime)->format('d M Y') }}</span>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($item->datetime)->format('H:i') }}</small>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark">{{ \Carbon\Carbon::parse($item->peminjaman->tanggal_pengajuan)->format('d M Y') }}</span>
                                            <small class="text-muted">s/d {{ \Carbon\Carbon::parse($item->peminjaman->tanggal_selesai)->format('d M Y') }}</small>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="room-info">
                                            <span class="badge bg-light text-dark border px-3 py-2">
                                                <i class="fa fa-door-open me-1"></i>{{ $item->ruangan->nama_ruangan ?? 'N/A' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center gap-1">
                                            @if($item->peminjaman && $item->peminjaman->file_scan)
                                                <a href="{{ asset('storage/uploads/file_scan/' . $item->peminjaman->file_scan) }}" 
                                                   class="btn btn-sm btn-outline-primary rounded-pill" 
                                                   target="_blank"
                                                   data-bs-toggle="tooltip" title="Lihat File Scan">
                                                    <i class="fas fa-file"></i>
                                                </a>
                                            @else
                                                <span class="badge bg-light text-muted">
                                                    <i class="fas fa-minus"></i> Tidak ada
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center gap-1">
                                            @if($item->foto_awal)
                                                <a href="{{ asset('storage/' . $item->foto_awal) }}" 
                                                   class="btn btn-sm btn-outline-info rounded-pill" 
                                                   target="_blank"
                                                   data-bs-toggle="tooltip" title="Foto Awal">
                                                    <i class="fas fa-image"></i>
                                                </a>
                                            @else
                                                <span class="badge bg-light text-muted">
                                                    <i class="fas fa-minus"></i>
                                                </span>
                                            @endif
                                            
                                            @if($item->foto_akhir)
                                                <a href="{{ asset('storage/' . $item->foto_akhir) }}" 
                                                   class="btn btn-sm btn-outline-success rounded-pill" 
                                                   target="_blank"
                                                   data-bs-toggle="tooltip" title="Foto Akhir">
                                                    <i class="fas fa-image"></i>
                                                </a>
                                            @else
                                                <span class="badge bg-light text-muted">
                                                    <i class="fas fa-minus"></i>
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-info-gradient text-white px-3 py-2 rounded-pill">
                                            <i class="fa fa-check-circle me-1"></i>Selesai
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="action-buttons d-flex justify-content-center gap-1">
                                            <a href="{{ route('mahasiswa.history.ruangan.show', ['ruangan', $item->id_lapor_ruangan]) }}" 
                                               class="btn-link-action text-primary text-decoration-none fw-medium"
                                               data-bs-toggle="tooltip" title="Lihat Detail">
                                                Detail
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center py-4 border-top pagination-wrapper">
                    <div class="pagination-container">
                        {{ $paginatedRuangan->links('pagination.custom-pagination') }}
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="empty-state text-center py-5">
                    <div class="py-4">
                        <div class="mb-4">
                            <i class="fa fa-door-open display-1 text-muted opacity-50"></i>
                        </div>
                        <h4 class="text-muted mb-3 fw-bold">Belum ada riwayat peminjaman ruangan</h4>
                        <p class="text-muted mb-4 lead">
                            Riwayat akan muncul setelah Anda menyelesaikan peminjaman dan pelaporan ruangan
                        </p>
                        <div class="empty-state-actions">
                            <a href="{{ route('mahasiswa.peminjaman.pinjam-ruangan.index') }}" 
                               class="btn btn-primary rounded-pill px-4 py-2 shadow-sm">
                                <i class="fa fa-arrow-left me-2"></i> Kembali ke Daftar Peminjaman
                            </a>
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
   
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
   
    const hoverRows = document.querySelectorAll('.hover-row');
    hoverRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 4px 12px rgba(0,0,0,0.1)';
            this.style.transition = 'all 0.3s ease';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'none';
        });
    });
    
   
    const statNumbers = document.querySelectorAll('.stat-number');
    statNumbers.forEach(stat => {
        const finalValue = parseInt(stat.textContent);
        let currentValue = 0;
        const increment = Math.ceil(finalValue / 20);
        
        const timer = setInterval(() => {
            currentValue += increment;
            if (currentValue >= finalValue) {
                currentValue = finalValue;
                clearInterval(timer);
            }
            stat.textContent = currentValue;
        }, 50);
    });
    
   
    const actionButtons = document.querySelectorAll('.btn-link-action');
    actionButtons.forEach(btn => {
        btn.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-1px)';
            this.style.textShadow = '0 2px 4px rgba(0,0,0,0.1)';
            this.style.transition = 'all 0.3s ease';
        });
        
        btn.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.textShadow = 'none';
        });
    });
});
</script>
@endpush

@push('styles')
<style>

.room-info .badge {
    font-size: 0.875rem;
    border-radius: 8px;
}

.action-buttons .btn-link-action {
    font-size: 0.875rem;
    padding: 0.25rem 0;
    transition: all 0.3s ease;
}

.action-buttons .btn-link-action:hover {
    transform: translateY(-1px);
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.hover-row {
    transition: all 0.3s ease;
    cursor: pointer;
}

.number-circle {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 0.875rem;
}

.badge.bg-primary-gradient {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    border: none;
}

.badge.bg-info-gradient {
    background: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%);
    border: none;
}

.table th {
    border-bottom: 2px solid #dee2e6;
    font-weight: 600;
}

.table td {
    border-bottom: 1px solid #f8f9fa;
    vertical-align: middle;
}

.empty-state {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 15px;
    margin: 20px;
    padding: 60px 20px;
}

.empty-state .display-1 {
    font-size: 4rem;
}

.empty-state-actions .btn {
    transition: all 0.3s ease;
}

.empty-state-actions .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}


.header-title-highlight {
    background: linear-gradient(45deg, #667eea, #764ba2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}


@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        gap: 20px;
    }
    
    .header-stats {
        justify-content: center;
        gap: 10px;
    }
    
    .action-buttons {
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .btn-futuristic .btn-text {
        font-size: 0.875rem;
    }
    
    .stat-card {
        min-width: 80px;
    }
}


@keyframes countUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.stat-number {
    animation: countUp 0.6s ease-out;
}


.main-card {
    transition: all 0.3s ease;
}

.main-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}


.tooltip {
    font-size: 0.875rem;
}

.tooltip-inner {
    background-color: #1f2937;
    border-radius: 6px;
    padding: 8px 12px;
}


.pagination-wrapper {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
}

.pagination-container {
    background: white;
    border-radius: 12px;
    padding: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}
</style>
@endpush

@endsection