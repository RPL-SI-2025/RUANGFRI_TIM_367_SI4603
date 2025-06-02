
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
                        <i class="fa fa-box header-icon"></i>
                    </div>
                    <div class="header-icon-pulse"></div>
                </div>
                <div class="header-text">
                    <h1 class="header-title">
                        Daftar Peminjaman
                        <span class="header-title-highlight">Inventaris</span>
                    </h1>
                    <p class="header-subtitle">
                        <i class="fa fa-chart-line me-2"></i>
                        Kelola dan pantau status peminjaman inventaris Anda secara real-time
                    </p>
                    <div class="header-breadcrumb">
                        <span class="breadcrumb-item">
                            <i class="fa fa-home"></i> Dashboard
                        </span>
                        <i class="fa fa-chevron-right breadcrumb-separator"></i>
                        <span class="breadcrumb-item active">Peminjaman Inventaris</span>
                    </div>
                </div>
            </div>
            <div class="header-right">
                <div class="header-stats">
                    <div class="stat-card">
                        <div class="stat-number">{{ $pinjamInventaris->where('status', 0)->count() }}</div>
                        <div class="stat-label">Menunggu</div>
                        <div class="stat-indicator stat-warning"></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">{{ $pinjamInventaris->where('status', 1)->count() }}</div>
                        <div class="stat-label">Disetujui</div>
                        <div class="stat-indicator stat-success"></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">{{ $pinjamInventaris->where('status', 3)->count() }}</div>
                        <div class="stat-label">Selesai</div>
                        <div class="stat-indicator stat-info"></div>
                    </div>
                </div>
                <div class="header-actions">
                    <a href="{{ route('mahasiswa.katalog.inventaris.index') }}" class="btn-futuristic btn-primary-futuristic">
                        <div class="btn-bg"></div>
                        <div class="btn-content">
                            <i class="fa fa-plus btn-icon"></i>
                            <span class="btn-text">Pinjam Inventaris</span>
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
                    <i class="fa fa-list"></i>
                </div>
                <h5 class="mb-0 fw-bold">Riwayat Peminjaman</h5>
                <div class="card-header-glow"></div>
            </div>
        </div>
        
        <div class="card-body p-0">
            @php
                $groupedPinjamInventaris = $pinjamInventaris->groupBy(function($item) {
                    return $item->tanggal_pengajuan . '-' . $item->tanggal_selesai . '-' . 
                           $item->waktu_mulai . '-' . $item->waktu_selesai . '-' . 
                           ($item->file_scan ?? 'no-file') . '-' . $item->id_mahasiswa;
                });
            @endphp
            
            @if($pinjamInventaris->count() > 0)
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
                                    <i class="fa fa-calendar text-primary me-2"></i>Tanggal
                                </th>
                                <th class="px-4 py-3 fw-bold">
                                    <i class="fa fa-box text-primary me-2"></i>Daftar Inventaris
                                </th>
                                <th class="px-4 py-3 fw-bold">
                                    <i class="fa fa-clock text-primary me-2"></i>Waktu
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
                            @foreach($groupedPinjamInventaris as $index => $group)
                                @php
                                    $firstItem = $group->first();
                                @endphp
                                <tr class="hover-row">
                                    <td class="px-4 py-3">
                                        <div class="number-circle bg-light text-dark">
                                            {{ $loop->iteration }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark">{{ \Carbon\Carbon::parse($firstItem->tanggal_pengajuan)->format('d M Y') }}</span>
                                            <small class="text-muted">s/d {{ \Carbon\Carbon::parse($firstItem->tanggal_selesai)->format('d M Y') }}</small>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="item-list">
                                            @foreach($group as $pinjam)
                                                <div class="d-flex align-items-center mb-1">
                                                    <div class="item-bullet bg-primary"></div>
                                                    <span class="fw-medium">{{ $pinjam->inventaris->nama_inventaris ?? 'Inventaris tidak ditemukan' }}</span>
                                                    <span class="badge bg-light text-dark ms-2">({{ $pinjam->jumlah_pinjam }})</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="time-range">
                                            <i class="fa fa-clock text-muted me-1"></i>
                                            <span class="fw-medium">{{ \Carbon\Carbon::parse($firstItem->waktu_mulai)->format('H:i') }}</span>
                                            <span class="text-muted mx-1">-</span>
                                            <span class="fw-medium">{{ \Carbon\Carbon::parse($firstItem->waktu_selesai)->format('H:i') }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($firstItem->status == 0)
                                            <span class="badge bg-warning-gradient text-dark px-3 py-2 rounded-pill">
                                                <i class="fa fa-clock me-1"></i>Menunggu
                                            </span>
                                        @elseif($firstItem->status == 1)
                                            <span class="badge bg-success-gradient text-white px-3 py-2 rounded-pill">
                                                <i class="fa fa-check me-1"></i>Disetujui
                                            </span>
                                        @elseif($firstItem->status == 2)
                                            <span class="badge bg-danger-gradient text-white px-3 py-2 rounded-pill">
                                                <i class="fa fa-times me-1"></i>Ditolak
                                            </span>
                                        @elseif($firstItem->status == 3)
                                            <span class="badge bg-info-gradient text-white px-3 py-2 rounded-pill">
                                                <i class="fa fa-flag-checkered me-1"></i>Selesai
                                            </span>
                                        @else
                                            <span class="badge bg-secondary-gradient text-white px-3 py-2 rounded-pill">
                                                <i class="fa fa-ban me-1"></i>Dibatalkan
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="action-buttons d-flex justify-content-center gap-1">
                                            <a href="{{ route('mahasiswa.peminjaman.pinjam-inventaris.show', $firstItem->id) }}" 
                                               class="btn-link-action text-primary text-decoration-none fw-medium" 
                                               data-bs-toggle="tooltip" title="Lihat Detail">
                                                Detail
                                            </a>
                                            
                                            @if($firstItem->status == 0)
                                                <span class="text-muted mx-1">/</span>
                                                <a href="{{ route('mahasiswa.peminjaman.pinjam-inventaris.edit', $firstItem->id) }}" 
                                                   class="btn-link-action text-success text-decoration-none fw-medium"
                                                   data-bs-toggle="tooltip" title="Edit Peminjaman">
                                                    Edit
                                                </a>
                                                <span class="text-muted mx-1">/</span>
                                                <form action="{{ route('mahasiswa.peminjaman.pinjam-inventaris.destroy', $firstItem->id) }}" 
                                                      method="POST" class="d-inline" 
                                                      onsubmit="return confirm('Apakah Anda yakin ingin membatalkan peminjaman ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn-link-action text-danger border-0 bg-transparent p-0 fw-medium"
                                                            data-bs-toggle="tooltip" title="Batalkan Peminjaman">
                                                        Hapus
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            @if($firstItem->status == 1)
                                                <span class="text-muted mx-1">/</span>
                                                <a href="{{ route('mahasiswa.pelaporan.lapor_inventaris.create', ['id_peminjaman' => $firstItem->id]) }}" 
                                                   class="btn-link-action text-warning text-decoration-none fw-medium"
                                                   data-bs-toggle="tooltip" title="Buat Laporan">
                                                    Lapor
                                                </a>
                                            @endif
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
                    {{ $pinjamInventaris->links('pagination.custom-pagination') }}
                </div>
            </div>
            @else
                <!-- Empty State -->
                <div class="empty-state text-center py-5">
                    <div class="py-4">
                        <div class="mb-4">
                            <i class="fa fa-box-open display-1 text-muted opacity-50"></i>
                        </div>
                        <h4 class="text-muted mb-3 fw-bold">Belum ada peminjaman inventaris</h4>
                        <p class="text-muted mb-4 lead">
                            Mulai pinjam inventaris untuk kebutuhan akademik Anda
                        </p>
                        <div class="empty-state-actions">
                            <a href="{{ route('mahasiswa.katalog.inventaris.index') }}" 
                               class="btn btn-primary rounded-pill px-4 py-2 shadow-sm">
                                <i class="fa fa-plus me-2"></i> Mulai Peminjaman Inventaris
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection

