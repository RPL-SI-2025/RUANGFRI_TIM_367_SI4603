
@extends('mahasiswa.layouts.app')

@section('content')
<div class="container py-4">
    <!-- Welcome Section -->
    <div class="header-section mb-4 bg-white p-4 rounded-3 shadow-sm border-start border-primary border-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold text-primary mb-2">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard Mahasiswa
                </h2>
                <p class="text-muted mb-0">Selamat datang di sistem manajemen fasilitas FRI</p>
            </div>
            <div class="text-end">
                <p class="mb-0 text-muted"><i class="fas fa-calendar-alt me-2"></i>{{ now()->format('l, d F Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Katalog Overview -->
    <div class="row g-4 mb-4">
        <!-- Ruangan Section -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold text-primary">
                        <i class="fas fa-building me-2"></i>Katalog Ruangan
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($ruangans as $ruangan)
                            <a href="{{ route('mahasiswa.katalog.ruangan.show', $ruangan->id) }}" 
                               class="list-group-item list-group-item-action p-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <div class="room-image-wrapper me-3">
                                            <img src="{{ $ruangan->gambar ? asset('storage/katalog_ruangan/' . $ruangan->gambar) : asset('images/default-room.jpg') }}" 
                                                 alt="{{ $ruangan->nama_ruangan }}" 
                                                 class="rounded-3" 
                                                 style="width: 60px; height: 60px; object-fit: cover;">
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-semibold">{{ $ruangan->nama_ruangan }}</h6>
                                            <small class="text-muted"><i class="fas fa-map-marker-alt me-1"></i>{{ $ruangan->lokasi }}</small>
                                        </div>
                                    </div>
                                    <span class="badge rounded-pill {{ $ruangan->status == 'Tersedia' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                                        <i class="fas {{ $ruangan->status == 'Tersedia' ? 'fa-check-circle' : 'fa-times-circle' }} me-1"></i>
                                        {{ $ruangan->status }}
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Inventaris Section -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold text-success">
                        <i class="fas fa-boxes me-2"></i>Katalog Inventaris
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($inventaris as $item)
                            <a href="{{ route('mahasiswa.katalog.inventaris.show', $item->id) }}" 
                               class="list-group-item list-group-item-action p-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <div class="inventory-image-wrapper me-3">
                                            <img src="{{ $item->gambar_inventaris ? asset('storage/katalog_inventaris/' . $item->gambar_inventaris) : asset('images/default-image.png') }}" 
                                                 alt="{{ $item->nama_inventaris }}" 
                                                 class="rounded-3" 
                                                 style="width: 60px; height: 60px; object-fit: cover;">
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-semibold">{{ $item->nama_inventaris }}</h6>
                                            <small class="text-muted"><i class="fas fa-tag me-1"></i>{{ $item->jenis }}</small>
                                        </div>
                                    </div>
                                    <span class="badge rounded-pill {{ $item->status == 'Tersedia' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                                        <i class="fas {{ $item->status == 'Tersedia' ? 'fa-check-circle' : 'fa-times-circle' }} me-1"></i>
                                        {{ $item->status }}
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Peminjaman -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="mb-0 fw-bold text-primary">
                <i class="fas fa-clipboard-check me-2"></i>Status Peminjaman
            </h5>
            <small class="text-muted">Peminjaman dikelompokkan berdasarkan pengajuan yang sama</small>
        </div>
        <div class="card-body">
            <div class="row g-4">
                <!-- Diterima Card -->
                <div class="col-md-4">
                    <div class="status-card bg-success-subtle p-4 rounded-3 border border-success border-opacity-25">
                        <div class="d-flex align-items-center mb-3">
                            <div class="status-icon bg-success text-white rounded-circle p-3 me-3">
                                <i class="fas fa-check-circle fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-success mb-0">Diterima</h6>
                                <small class="text-success opacity-75">{{ $peminjamanDiterima->count() }} pengajuan</small>
                            </div>
                        </div>
                        <ul class="list-unstyled mb-0">
                            @forelse($peminjamanDiterima as $peminjaman)
                                <li class="mb-2">
                                    <a href="{{ $peminjaman['jenis'] == 'Ruangan' ? 
                                        route('mahasiswa.peminjaman.pinjam-ruangan.show', $peminjaman['id']) : 
                                        route('mahasiswa.peminjaman.pinjam-inventaris.show', $peminjaman['id']) }}" 
                                        class="text-success text-decoration-none d-flex align-items-center p-2 rounded-2 hover-bg">
                                        <i class="fas {{ $peminjaman['jenis'] == 'Ruangan' ? 'fa-building' : 'fa-box' }} me-2"></i>
                                        <div class="flex-grow-1">
                                            <span class="d-block">{{ Str::limit($peminjaman['nama'], 50) }}</span>
                                            <small class="opacity-75">
                                                {{ \Carbon\Carbon::parse($peminjaman['tanggal'])->format('d M Y') }}
                                                @if($peminjaman['count'] > 1)
                                                    <span class="badge bg-success-subtle text-success ms-1">{{ $peminjaman['count'] }} item</span>
                                                @endif
                                            </small>
                                        </div>
                                    </a>
                                </li>
                            @empty
                                <li class="text-success opacity-75">Belum ada peminjaman yang disetujui</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <!-- Ditolak Card -->
                <div class="col-md-4">
                    <div class="status-card bg-danger-subtle p-4 rounded-3 border border-danger border-opacity-25">
                        <div class="d-flex align-items-center mb-3">
                            <div class="status-icon bg-danger text-white rounded-circle p-3 me-3">
                                <i class="fas fa-times-circle fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-danger mb-0">Ditolak</h6>
                                <small class="text-danger opacity-75">{{ $peminjamanDitolak->count() }} pengajuan</small>
                            </div>
                        </div>
                       <ul class="list-unstyled mb-0">
                            @forelse($peminjamanDitolak as $peminjaman)
                                <li class="mb-2">
                                    <a href="{{ $peminjaman['jenis'] == 'Ruangan' ? 
                                        route('mahasiswa.peminjaman.pinjam-ruangan.show', $peminjaman['id']) : 
                                        route('mahasiswa.peminjaman.pinjam-inventaris.show', $peminjaman['id']) }}" 
                                        class="text-danger text-decoration-none d-flex align-items-center p-2 rounded-2 hover-bg">
                                        <i class="fas {{ $peminjaman['jenis'] == 'Ruangan' ? 'fa-building' : 'fa-box' }} me-2"></i>
                                        <div class="flex-grow-1">
                                            <span class="d-block">{{ Str::limit($peminjaman['nama'], 50) }}</span>
                                            <small class="opacity-75">
                                                {{ \Carbon\Carbon::parse($peminjaman['tanggal'])->format('d M Y') }}
                                                @if($peminjaman['count'] > 1)
                                                    <span class="badge bg-danger-subtle text-danger ms-1">{{ $peminjaman['count'] }} item</span>
                                                @endif
                                            </small>
                                            @if(isset($peminjaman['notes']) && $peminjaman['notes'])
                                                <small class="d-block mt-1 text-danger-emphasis bg-danger-subtle rounded-1 p-1">
                                                    <i class="fas fa-info-circle me-1"></i>{{ Str::limit($peminjaman['notes'], 50) }}
                                                </small>
                                            @endif
                                        </div>
                                    </a>
                                </li>
                            @empty
                                <li class="text-danger opacity-75">Tidak ada peminjaman yang ditolak</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <!-- Pending Card -->
                <div class="col-md-4">
                    <div class="status-card bg-warning-subtle p-4 rounded-3 border border-warning border-opacity-25">
                        <div class="d-flex align-items-center mb-3">
                            <div class="status-icon bg-warning text-white rounded-circle p-3 me-3">
                                <i class="fas fa-clock fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-warning mb-0">Pending</h6>
                                <small class="text-warning opacity-75">{{ $peminjamanPending->count() }} pengajuan</small>
                            </div>
                        </div>
                    <ul class="list-unstyled mb-0">
                        @forelse($peminjamanPending as $peminjaman)
                            <li class="mb-2">
                                <a href="{{ $peminjaman['jenis'] == 'Ruangan' ? 
                                    route('mahasiswa.peminjaman.pinjam-ruangan.show', $peminjaman['id']) : 
                                    route('mahasiswa.peminjaman.pinjam-inventaris.show', $peminjaman['id']) }}" 
                                    class="text-warning text-decoration-none d-flex align-items-center p-2 rounded-2 hover-bg">
                                    <i class="fas {{ $peminjaman['jenis'] == 'Ruangan' ? 'fa-building' : 'fa-box' }} me-2"></i>
                                    <div class="flex-grow-1">
                                        <span class="d-block">{{ Str::limit($peminjaman['nama'], 50) }}</span>
                                        <small class="opacity-75">
                                            {{ \Carbon\Carbon::parse($peminjaman['tanggal'])->format('d M Y') }}
                                            @if($peminjaman['count'] > 1)
                                                <span class="badge bg-warning-subtle text-warning ms-1">{{ $peminjaman['count'] }} item</span>
                                            @endif
                                        </small>
                                    </div>
                                </a>
                            </li>
                        @empty
                            <li class="text-warning opacity-75">Tidak ada peminjaman yang pending</li>
                        @endforelse
                    </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Enhanced styles for grouped borrowing display */
.hover-bg {
    transition: all 0.2s ease;
    border-left: 3px solid transparent;
}

.hover-bg:hover {
    background-color: rgba(0,0,0,0.05);
    transform: translateX(5px);
}

.text-success .hover-bg:hover {
    border-left-color: #198754;
}

.text-danger .hover-bg:hover {
    border-left-color: #dc3545;
}

.text-warning .hover-bg:hover {
    border-left-color: #ffc107;
}

.text-success:hover {
    color: #198754 !important;
}

.text-danger:hover {
    color: #dc3545 !important;
}

.text-warning:hover {
    color: #ffc107 !important;
}


.status-icon {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.card {
    transition: all 0.3s ease;
}

.list-group-item {
    transition: all 0.3s ease;
}

.list-group-item:hover {
    transform: translateX(5px);
    background-color: #f8f9fa;
}

.status-card {
    height: 100%;
    transition: all 0.3s ease;
}

.status-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.badge {
    font-weight: 500;
    padding: 0.4em 0.6em;
    font-size: 0.75em;
}

/* Custom badge styles for item count */
.badge.bg-success-subtle {
    background-color: rgba(25, 135, 84, 0.1) !important;
    border: 1px solid rgba(25, 135, 84, 0.2);
}

.badge.bg-danger-subtle {
    background-color: rgba(220, 53, 69, 0.1) !important;
    border: 1px solid rgba(220, 53, 69, 0.2);
}

.badge.bg-warning-subtle {
    background-color: rgba(255, 193, 7, 0.1) !important;
    border: 1px solid rgba(255, 193, 7, 0.2);
}

/* Tooltip for grouped items */
.status-card ul li a {
    position: relative;
}

.status-card ul li a:hover .badge {
    transform: scale(1.1);
    transition: transform 0.2s ease;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .status-card {
        margin-bottom: 1rem;
    }
    
    .hover-bg:hover {
        transform: none;
    }
    
    .list-group-item:hover {
        transform: none;
    }
}
</style>
@endsection