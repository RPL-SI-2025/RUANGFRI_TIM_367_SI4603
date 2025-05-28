
@extends('admin.layouts.admin')

@section('title', 'Daftar Laporan Ruangan')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Card dengan Gradient -->
    <div class="card border-0 shadow-lg mb-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="bg-gradient-primary text-white p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-2 fw-bold">
                            <i class="fas fa-clipboard-list me-3"></i>Daftar Laporan Ruangan
                        </h3>

                    </div>
                    <div class="text-end">
                        <div class="d-flex align-items-center">
                            <span class="badge bg-light text-primary rounded-pill px-3 py-2 me-2 shadow-sm">
                                <i class="fas fa-list me-1"></i> {{ $pelaporans->count() }} Laporan
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-light p-3 border-top border-white border-opacity-25">
                <div class="d-flex align-items-center justify-content-center">
                    <i class="fas fa-clock text-primary me-2"></i>
                    <span class="text-muted fw-medium">Terakhir diperbarui:</span>
                    <strong class="ms-2 text-dark">{{ now()->format('d M Y H:i') }}</strong>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle text-success me-3 fs-4"></i>
                <div>
                    <strong>Berhasil!</strong> {{ session('success') }}
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-circle text-danger me-3 fs-4"></i>
                <div>
                    <strong>Error!</strong> {{ session('error') }}
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Main Content Card -->
    <div class="card border-0 shadow-lg hover-lift">
        <div class="card-header bg-gradient-info text-white py-4 border-0">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-white text-info me-3 shadow">
                        <i class="fas fa-table"></i>
                    </div>
                    <h4 class="mb-0 fw-bold">Data Laporan Ruangan</h4>
                </div>
                <div class="d-flex align-items-center">
                    <span class="opacity-90 me-3">
                        <i class="fas fa-database me-1"></i>
                        Data Management
                    </span>
                </div>
            </div>
        </div>
        
        <div class="card-body p-0">
            @if($pelaporans->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3 fw-bold text-dark">
                                    <i class="fas fa-hashtag me-2 text-primary"></i>No
                                </th>
                                <th class="px-4 py-3 fw-bold text-dark">
                                    <i class="fas fa-calendar-alt me-2 text-success"></i>Tanggal Pelaporan
                                </th>
                                <th class="px-4 py-3 fw-bold text-dark">
                                    <i class="fas fa-calendar-check me-2 text-warning"></i>Tanggal Peminjaman
                                </th>
                                <th class="px-4 py-3 fw-bold text-dark">
                                    <i class="fas fa-door-open me-2 text-info"></i>Ruangan
                                </th>
                                <th class="px-4 py-3 fw-bold text-dark">
                                    <i class="fas fa-comment-dots me-2 text-purple"></i>Deskripsi
                                </th>
                                <th class="px-4 py-3 fw-bold text-dark">
                                    <i class="fas fa-user-tie me-2 text-danger"></i>Diberikan Kepada
                                </th>
                                <th class="px-4 py-3 fw-bold text-dark text-center">
                                    <i class="fas fa-cogs me-2 text-secondary"></i>Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pelaporans as $index => $item)
                                <tr class="border-bottom border-light hover-row">
                                    <td class="px-4 py-4">
                                        <div class="d-flex align-items-center">
                                            <div class="number-circle bg-primary text-white me-3">
                                                {{ $index + 1 }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="d-flex flex-column">
                                            <span class="fw-medium text-dark">
                                                {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                                            </span>
                                            <small class="text-muted">
                                                <i class="fas fa-clock me-1"></i>
                                                {{ \Carbon\Carbon::parse($item->created_at)->format('H:i') }}
                                            </small>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="d-flex flex-column">
                                            <span class="fw-medium text-dark">
                                                {{ \Carbon\Carbon::parse($item->peminjaman->tanggal_pengajuan)->format('d M Y') }}
                                            </span>
                                            <small class="text-muted">
                                                <i class="fas fa-arrow-right me-1"></i>
                                                {{ \Carbon\Carbon::parse($item->peminjaman->tanggal_pengajuan)->format('d M Y') }}
                                            </small>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="room-info">
                                            <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3 py-2">
                                                <i class="fas fa-building me-1"></i>
                                                {{ $item->ruangan->nama_ruangan ?? 'Tidak ada data' }}
                                            </span>
                                            @if($item->ruangan->lokasi)
                                                <div class="mt-1">
                                                    <small class="text-muted">
                                                        <i class="fas fa-map-marker-alt me-1"></i>
                                                        {{ $item->ruangan->lokasi }}
                                                    </small>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="description-preview">
                                            <p class="mb-1 text-dark">
                                                {{ \Str::limit($item->deskripsi ?? 'Tidak ada data', 50) }}
                                            </p>
                                            @if(strlen($item->deskripsi) > 50)
                                                <small class="text-primary">
                                                    <i class="fas fa-eye me-1"></i>Lihat detail...
                                                </small>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="admin-info">
                                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">
                                                <i class="fas fa-user-check me-1"></i>
                                                {{ $item->logistik->nama ?? 'Tidak ada data' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.lapor_ruangan.show', $item->id_lapor_ruangan) }}" 
                                               class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm hover-scale">
                                                <i class="fas fa-eye me-1"></i> Detail
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state text-center py-5">
                    <div class="py-4">
                        <div class="mb-4">
                            <i class="fas fa-clipboard-list display-1 text-muted opacity-50"></i>
                        </div>
                        <h4 class="text-muted mb-3 fw-bold">Belum ada laporan ruangan</h4>
                        <p class="text-muted mb-4 lead">
                            Laporan akan muncul saat mahasiswa menyelesaikan peminjaman ruangan dan mengisi laporan pengembalian.
                        </p>
                        <div class="empty-state-actions">
                            <a href="{{ route('admin.pinjam-ruangan.index') }}" 
                               class="btn btn-primary rounded-pill px-4 py-2 me-2 shadow-sm">
                                <i class="fas fa-list me-2"></i> Lihat Peminjaman
                            </a>
                            <a href="{{ route('admin.katalog_ruangan.index') }}" 
                               class="btn btn-outline-primary rounded-pill px-4 py-2 shadow-sm">
                                <i class="fas fa-building me-2"></i> Kelola Ruangan
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>

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

/* Icon Circle */
.icon-circle {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    font-weight: bold;
}

/* Number Circle */
.number-circle {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 0.875rem;
}

/* Table Styles */
.table {
    border: none;
}

.table thead th {
    border-bottom: 2px solid #e9ecef;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
}

.hover-row {
    transition: all 0.3s ease;
}

.hover-row:hover {
    background-color: #f8f9fa !important;
    transform: scale(1.01);
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
}

/* Badge Styles */
.badge {
    font-weight: 500;
    border: 1px solid transparent;
}

.badge.bg-info.bg-opacity-10 {
    border-color: rgba(13, 202, 240, 0.2);
}

.badge.bg-success.bg-opacity-10 {
    border-color: rgba(25, 135, 84, 0.2);
}

/* Button Styles */
.btn {
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.hover-scale:hover {
    transform: scale(1.05) translateY(-2px);
}

/* Alert Styles */
.alert {
    border-radius: 1rem;
    border: none;
}

/* Room Info */
.room-info {
    max-width: 200px;
}

/* Description Preview */
.description-preview {
    max-width: 250px;
}

/* Admin Info */
.admin-info {
    max-width: 180px;
}

/* Empty State */
.empty-state {
    padding: 3rem 2rem;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 1rem;
    margin: 2rem;
}

.empty-state-actions .btn {
    transition: all 0.3s ease;
}

.empty-state-actions .btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

/* Text Colors */
.text-purple {
    color: #6f42c1 !important;
}

/* Responsive */
@media (max-width: 768px) {
    .container-fluid {
        padding: 1rem;
    }
    
    .card-body {
        padding: 1rem !important;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .icon-circle {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
    
    .number-circle {
        width: 30px;
        height: 30px;
        font-size: 0.75rem;
    }
    
    .px-4 {
        padding-left: 1rem !important;
        padding-right: 1rem !important;
    }
    
    .py-4 {
        padding-top: 0.75rem !important;
        padding-bottom: 0.75rem !important;
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

.hover-row {
    animation: fadeInUp 0.5s ease-out;
}

.hover-row:nth-child(1) { animation-delay: 0.1s; }
.hover-row:nth-child(2) { animation-delay: 0.15s; }
.hover-row:nth-child(3) { animation-delay: 0.2s; }
.hover-row:nth-child(4) { animation-delay: 0.25s; }
.hover-row:nth-child(5) { animation-delay: 0.3s; }

/* Badge Hover Effects */
.badge {
    transition: all 0.3s ease;
}

.badge:hover {
    transform: scale(1.05);
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

/* Table Header Gradient */
.table-light {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

/* Smooth scroll */
html {
    scroll-behavior: smooth;
}
</style>

@push('scripts')
<script>
    $(document).ready(function() {

        $('.hover-row').each(function(index) {
            $(this).css('animation-delay', (index * 0.05) + 's');
        });
        

        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    });
</script>
@endpush

@endsection