
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
                        <i class="fa fa-tachometer-alt header-icon"></i>
                    </div>
                    <div class="header-icon-pulse"></div>
                </div>
                <div class="header-text">
                    <h1 class="header-title">
                        Dashboard
                        <span class="header-title-highlight">Mahasiswa</span>
                    </h1>
                    <p class="header-subtitle">
                        <i class="fa fa-home me-2"></i>
                        Selamat datang di sistem manajemen fasilitas FRI
                    </p>
                    <div class="header-breadcrumb">
                        <span class="breadcrumb-item active">
                            <i class="fa fa-home"></i> Dashboard
                        </span>
                    </div>
                </div>
            </div>
            <div class="header-right">
                <div class="header-stats">
                    <div class="stat-card">
                        <div class="stat-number">{{ $peminjamanDiterima->count() }}</div>
                        <div class="stat-label">Disetujui</div>
                        <div class="stat-indicator stat-success"></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">{{ $peminjamanPending->count() }}</div>
                        <div class="stat-label">Pending</div>
                        <div class="stat-indicator stat-warning"></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">{{ $peminjamanDitolak->count() }}</div>
                        <div class="stat-label">Ditolak</div>
                        <div class="stat-indicator stat-danger"></div>
                    </div>
                </div>
                <div class="header-actions">
                    <div class="date-display">
                        <i class="fa fa-calendar-alt me-2"></i>
                        {{ now()->format('l, d F Y') }}
                    </div>
                </div>
            </div>
        </div>
        <div class="header-wave">
            <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M0,60 C300,0 600,120 900,60 C1050,30 1150,90 1200,60 L1200,120 L0,120 Z" fill="rgba(255,255,255,0.1)"></path>
            </svg>
        </div>
    </div>

    <!-- Quick Stats Overview -->
    <div class="card border-0 shadow-lg main-card mb-4">
        <div class="card-header bg-gradient-primary text-white py-3 border-0 card-header-futuristic">
            <div class="card-header-bg"></div>
            <div class="d-flex align-items-center position-relative">
                <div class="icon-circle bg-white text-primary me-3">
                    <i class="fa fa-chart-bar"></i>
                </div>
                <h5 class="mb-0 fw-bold">Status Peminjaman Overview</h5>
                <div class="card-header-glow"></div>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="row g-4">
                <!-- Diterima Card -->
                <div class="col-md-4">
                    <div class="status-card-modern bg-success-gradient">
                        <div class="status-header">
                            <div class="status-icon-wrapper">
                                <div class="status-icon bg-success">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="status-pulse success"></div>
                            </div>
                            <div class="status-info">
                                <h3 class="status-count">{{ $peminjamanDiterima->count() }}</h3>
                                <span class="status-label">Diterima</span>
                            </div>
                        </div>
                        <div class="status-list">
                            @forelse($peminjamanDiterima->take(3) as $peminjaman)
                                <div class="status-item">
                                    <a href="{{ $peminjaman['jenis'] == 'Ruangan' ? 
                                        route('mahasiswa.peminjaman.pinjam-ruangan.show', $peminjaman['id']) : 
                                        route('mahasiswa.peminjaman.pinjam-inventaris.show', $peminjaman['id']) }}" 
                                        class="status-link">
                                        <div class="item-icon">
                                            <i class="fas {{ $peminjaman['jenis'] == 'Ruangan' ? 'fa-building' : 'fa-box' }}"></i>
                                        </div>
                                        <div class="item-content">
                                            <span class="item-name">{{ Str::limit($peminjaman['nama'], 30) }}</span>
                                            <small class="item-date">{{ \Carbon\Carbon::parse($peminjaman['tanggal'])->format('d M Y') }}</small>
                                        </div>
                                        @if($peminjaman['count'] > 1)
                                            <span class="item-badge">{{ $peminjaman['count'] }}</span>
                                        @endif
                                    </a>
                                </div>
                            @empty
                                <div class="empty-state-mini">
                                    <i class="fa fa-check-circle"></i>
                                    <span>Belum ada peminjaman disetujui</span>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Pending Card -->
                <div class="col-md-4">
                    <div class="status-card-modern bg-warning-gradient">
                        <div class="status-header">
                            <div class="status-icon-wrapper">
                                <div class="status-icon bg-warning">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="status-pulse warning"></div>
                            </div>
                            <div class="status-info">
                                <h3 class="status-count">{{ $peminjamanPending->count() }}</h3>
                                <span class="status-label">Pending</span>
                            </div>
                        </div>
                        <div class="status-list">
                            @forelse($peminjamanPending->take(3) as $peminjaman)
                                <div class="status-item">
                                    <a href="{{ $peminjaman['jenis'] == 'Ruangan' ? 
                                        route('mahasiswa.peminjaman.pinjam-ruangan.show', $peminjaman['id']) : 
                                        route('mahasiswa.peminjaman.pinjam-inventaris.show', $peminjaman['id']) }}" 
                                        class="status-link">
                                        <div class="item-icon">
                                            <i class="fas {{ $peminjaman['jenis'] == 'Ruangan' ? 'fa-building' : 'fa-box' }}"></i>
                                        </div>
                                        <div class="item-content">
                                            <span class="item-name">{{ Str::limit($peminjaman['nama'], 30) }}</span>
                                            <small class="item-date">{{ \Carbon\Carbon::parse($peminjaman['tanggal'])->format('d M Y') }}</small>
                                        </div>
                                        @if($peminjaman['count'] > 1)
                                            <span class="item-badge">{{ $peminjaman['count'] }}</span>
                                        @endif
                                    </a>
                                </div>
                            @empty
                                <div class="empty-state-mini">
                                    <i class="fa fa-clock"></i>
                                    <span>Tidak ada peminjaman pending</span>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Ditolak Card -->
                <div class="col-md-4">
                    <div class="status-card-modern bg-danger-gradient">
                        <div class="status-header">
                            <div class="status-icon-wrapper">
                                <div class="status-icon bg-danger">
                                    <i class="fas fa-times-circle"></i>
                                </div>
                                <div class="status-pulse danger"></div>
                            </div>
                            <div class="status-info">
                                <h3 class="status-count">{{ $peminjamanDitolak->count() }}</h3>
                                <span class="status-label">Ditolak</span>
                            </div>
                        </div>
                        <div class="status-list">
                            @forelse($peminjamanDitolak->take(3) as $peminjaman)
                                <div class="status-item">
                                    <a href="{{ $peminjaman['jenis'] == 'Ruangan' ? 
                                        route('mahasiswa.peminjaman.pinjam-ruangan.show', $peminjaman['id']) : 
                                        route('mahasiswa.peminjaman.pinjam-inventaris.show', $peminjaman['id']) }}" 
                                        class="status-link">
                                        <div class="item-icon">
                                            <i class="fas {{ $peminjaman['jenis'] == 'Ruangan' ? 'fa-building' : 'fa-box' }}"></i>
                                        </div>
                                        <div class="item-content">
                                            <span class="item-name">{{ Str::limit($peminjaman['nama'], 30) }}</span>
                                            <small class="item-date">{{ \Carbon\Carbon::parse($peminjaman['tanggal'])->format('d M Y') }}</small>
                                            @if(isset($peminjaman['notes']) && $peminjaman['notes'])
                                                <small class="item-notes">{{ Str::limit($peminjaman['notes'], 40) }}</small>
                                            @endif
                                        </div>
                                        @if($peminjaman['count'] > 1)
                                            <span class="item-badge">{{ $peminjaman['count'] }}</span>
                                        @endif
                                    </a>
                                </div>
                            @empty
                                <div class="empty-state-mini">
                                    <i class="fa fa-times-circle"></i>
                                    <span>Tidak ada peminjaman ditolak</span>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Katalog Overview -->
    <div class="row g-4">
        <!-- Katalog Ruangan -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-lg catalog-card">
                <div class="card-header bg-gradient-info text-white py-3 border-0 card-header-futuristic">
                    <div class="card-header-bg"></div>
                    <div class="d-flex align-items-center justify-content-between position-relative">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle bg-white text-info me-3">
                                <i class="fa fa-building"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold">Katalog Ruangan</h5>
                                <small class="opacity-75">{{ $ruangans->count() }} ruangan tersedia</small>
                            </div>
                        </div>
                        <a href="{{ route('mahasiswa.katalog.ruangan.index') }}" class="btn btn-light btn-sm">
                            <i class="fa fa-arrow-right me-1"></i>Lihat Semua
                        </a>
                        <div class="card-header-glow"></div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="catalog-list">
                        @foreach($ruangans->take(4) as $ruangan)
                            <div class="catalog-item">
                                <a href="{{ route('mahasiswa.katalog.ruangan.show', $ruangan->id) }}" class="catalog-link">
                                    <div class="catalog-image">
                                        <img src="{{ $ruangan->gambar ? asset('storage/katalog_ruangan/' . $ruangan->gambar) : asset('images/default-room.jpg') }}" 
                                             alt="{{ $ruangan->nama_ruangan }}">
                                        <div class="catalog-overlay">
                                            <i class="fa fa-eye"></i>
                                        </div>
                                    </div>
                                    <div class="catalog-content">
                                        <h6 class="catalog-title">{{ $ruangan->nama_ruangan }}</h6>
                                        <div class="catalog-meta">
                                            <span class="catalog-location">
                                                <i class="fa fa-map-marker-alt"></i>
                                                {{ $ruangan->lokasi }}
                                            </span>
                                            <span class="catalog-capacity">
                                                <i class="fa fa-users"></i>
                                                {{ $ruangan->kapasitas }} orang
                                            </span>
                                        </div>
                                    </div>
                                    <div class="catalog-status">
                                        <span class="status-badge {{ $ruangan->status == 'Tersedia' ? 'status-available' : 'status-unavailable' }}">
                                            <i class="fa {{ $ruangan->status == 'Tersedia' ? 'fa-check' : 'fa-times' }}"></i>
                                            {{ $ruangan->status }}
                                        </span>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Katalog Inventaris -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-lg catalog-card">
                <div class="card-header bg-gradient-success text-white py-3 border-0 card-header-futuristic">
                    <div class="card-header-bg"></div>
                    <div class="d-flex align-items-center justify-content-between position-relative">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle bg-white text-success me-3">
                                <i class="fa fa-boxes"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold">Katalog Inventaris</h5>
                                <small class="opacity-75">{{ $inventaris->count() }} item tersedia</small>
                            </div>
                        </div>
                        <a href="{{ route('mahasiswa.katalog.inventaris.index') }}" class="btn btn-light btn-sm">
                            <i class="fa fa-arrow-right me-1"></i>Lihat Semua
                        </a>
                        <div class="card-header-glow"></div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="catalog-list">
                        @foreach($inventaris->take(4) as $item)
                            <div class="catalog-item">
                                <a href="{{ route('mahasiswa.katalog.inventaris.show', $item->id) }}" class="catalog-link">
                                    <div class="catalog-image">
                                        <img src="{{ $item->gambar_inventaris ? asset('storage/katalog_inventaris/' . $item->gambar_inventaris) : asset('images/default-image.png') }}" 
                                             alt="{{ $item->nama_inventaris }}">
                                        <div class="catalog-overlay">
                                            <i class="fa fa-eye"></i>
                                        </div>
                                    </div>
                                    <div class="catalog-content">
                                        <h6 class="catalog-title">{{ $item->nama_inventaris }}</h6>
                                        <div class="catalog-meta">
                                            <span class="catalog-type">
                                                <i class="fa fa-tag"></i>
                                                {{ $item->jenis }}
                                            </span>
                                            <span class="catalog-stock">
                                                <i class="fa fa-cubes"></i>
                                                {{ $item->jumlah_tersedia }} unit
                                            </span>
                                        </div>
                                    </div>
                                    <div class="catalog-status">
                                        <span class="status-badge {{ $item->status == 'Tersedia' ? 'status-available' : 'status-unavailable' }}">
                                            <i class="fa {{ $item->status == 'Tersedia' ? 'fa-check' : 'fa-times' }}"></i>
                                            {{ $item->status }}
                                        </span>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>

.status-card-modern {
    background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
    border-radius: 16px;
    padding: 20px;
    border: 1px solid rgba(255,255,255,0.1);
    backdrop-filter: blur(10px);
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
}

.status-card-modern:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
}

.bg-success-gradient {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

.bg-warning-gradient {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
}

.bg-danger-gradient {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
}

.status-header {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}

.status-icon-wrapper {
    position: relative;
    margin-right: 15px;
}

.status-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
}

.status-pulse {
    position: absolute;
    top: 0;
    left: 0;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    animation: pulse 2s infinite;
}

.status-pulse.success {
    background: rgba(16, 185, 129, 0.4);
}

.status-pulse.warning {
    background: rgba(245, 158, 11, 0.4);
}

.status-pulse.danger {
    background: rgba(239, 68, 68, 0.4);
}

@keyframes pulse {
    0% {
        transform: scale(0.95);
        box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.7);
    }
    70% {
        transform: scale(1);
        box-shadow: 0 0 0 10px rgba(255, 255, 255, 0);
    }
    100% {
        transform: scale(0.95);
        box-shadow: 0 0 0 0 rgba(255, 255, 255, 0);
    }
}

.status-info {
    color: white;
}

.status-count {
    font-size: 28px;
    font-weight: bold;
    margin: 0;
    line-height: 1;
}

.status-label {
    font-size: 14px;
    opacity: 0.9;
}

.status-list {
    max-height: 200px;
    overflow-y: auto;
}

.status-item {
    margin-bottom: 10px;
}

.status-link {
    display: flex;
    align-items: center;
    padding: 12px;
    background: rgba(255,255,255,0.1);
    border-radius: 8px;
    text-decoration: none;
    color: white;
    transition: all 0.3s ease;
}

.status-link:hover {
    background: rgba(255,255,255,0.2);
    color: white;
    transform: translateX(5px);
}

.item-icon {
    width: 35px;
    height: 35px;
    border-radius: 8px;
    background: rgba(255,255,255,0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
    font-size: 14px;
}

.item-content {
    flex: 1;
}

.item-name {
    display: block;
    font-weight: 500;
    font-size: 14px;
    margin-bottom: 2px;
}

.item-date {
    font-size: 12px;
    opacity: 0.8;
    display: block;
}

.item-notes {
    font-size: 11px;
    opacity: 0.7;
    display: block;
    background: rgba(255,255,255,0.1);
    padding: 2px 6px;
    border-radius: 4px;
    margin-top: 2px;
}

.item-badge {
    background: rgba(255,255,255,0.2);
    color: white;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 500;
}

.empty-state-mini {
    text-align: center;
    padding: 20px;
    color: rgba(255,255,255,0.7);
}

.empty-state-mini i {
    font-size: 24px;
    margin-bottom: 8px;
    display: block;
}


.catalog-card {
    transition: all 0.3s ease;
}

.catalog-card:hover {
    transform: translateY(-2px);
}

.catalog-list {
    padding: 0;
}

.catalog-item {
    border-bottom: 1px solid #f0f0f0;
}

.catalog-item:last-child {
    border-bottom: none;
}

.catalog-link {
    display: flex;
    align-items: center;
    padding: 16px 20px;
    text-decoration: none;
    color: inherit;
    transition: all 0.3s ease;
}

.catalog-link:hover {
    background: #f8f9fa;
    color: inherit;
    transform: translateX(5px);
}

.catalog-image {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    overflow: hidden;
    margin-right: 15px;
    position: relative;
}

.catalog-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.catalog-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    color: white;
}

.catalog-link:hover .catalog-overlay {
    opacity: 1;
}

.catalog-link:hover .catalog-image img {
    transform: scale(1.1);
}

.catalog-content {
    flex: 1;
}

.catalog-title {
    font-weight: 600;
    margin-bottom: 5px;
    font-size: 14px;
}

.catalog-meta {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.catalog-meta span {
    font-size: 12px;
    color: #6c757d;
}

.catalog-meta i {
    width: 12px;
    margin-right: 5px;
}

.catalog-status {
    margin-left: 10px;
}

.status-badge {
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.status-available {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
    border: 1px solid rgba(16, 185, 129, 0.2);
}

.status-unavailable {
    background: rgba(239, 68, 68, 0.1);
    color: #dc2626;
    border: 1px solid rgba(239, 68, 68, 0.2);
}


.date-display {
    background: rgba(255,255,255,0.1);
    padding: 8px 16px;
    border-radius: 8px;
    color: white;
    font-size: 14px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.1);
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
    
    .status-card-modern {
        margin-bottom: 20px;
    }
    
    .catalog-link {
        padding: 12px 16px;
    }
    
    .catalog-image {
        width: 50px;
        height: 50px;
    }
    
    .catalog-meta {
        gap: 1px;
    }
    
    .status-list {
        max-height: 150px;
    }
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
   
    const statNumbers = document.querySelectorAll('.stat-number, .status-count');
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
    
   
    const catalogItems = document.querySelectorAll('.catalog-item');
    catalogItems.forEach((item, index) => {
        item.style.animationDelay = `${index * 0.1}s`;
        item.style.animation = 'fadeInUp 0.6s ease forwards';
    });
    
   
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const headerBg = document.querySelector('.header-background');
        if (headerBg) {
            headerBg.style.transform = `translateY(${scrolled * 0.5}px)`;
        }
    });
});

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
</script>
@endpush
@endsection