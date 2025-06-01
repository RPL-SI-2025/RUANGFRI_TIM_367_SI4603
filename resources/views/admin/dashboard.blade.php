
@extends('admin.layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboardAdmin.css') }}">
@endpush

<div class="container-fluid py-4">
    <!-- Welcome Header -->
    <div class="header-section mb-4 bg-white p-4 rounded-3 shadow-sm border-start border-primary border-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold text-primary mb-2">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard Admin
                </h2>
                <p class="text-muted mb-0">Selamat datang kembali di sistem manajemen fasilitas FRI</p>
            </div>
            <div class="text-end">
                <p class="mb-0 text-muted"><i class="fas fa-calendar-alt me-2"></i>{{ now()->format('l, d F Y') }}</p>
            </div>
        </div>
    </div>
    
    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <!-- Ruangan Stats -->
        <div class="col-md-4">
            <div class="stat-card h-100 border-0 shadow-sm rounded-3 bg-white overflow-hidden">
                <div class="p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-primary fw-medium mb-2">Total Ruangan</p>
                            <h3 class="fw-bold text-dark mb-0">{{ $totalRuangan }}</h3>
                            <div class="mt-3">
                                <span class="badge bg-success-subtle text-success me-2">
                                    <i class="fas fa-check-circle me-1"></i>{{ $ruanganTersedia }} Tersedia
                                </span>
                                <span class="badge bg-danger-subtle text-danger">
                                    <i class="fas fa-times-circle me-1"></i>{{ $ruanganTidakTersedia }} Tidak
                                </span>
                            </div>
                        </div>
                        <div class="stat-icon bg-primary-subtle p-3 rounded-3">
                            <i class="fas fa-building fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
                <div class="progress" style="height: 4px;">
                    <div class="progress-bar bg-primary" style="width: {{ $totalRuangan > 0 ? ($ruanganTersedia/$totalRuangan)*100 : 0 }}%"></div>
                </div>
            </div>
        </div>

        <!-- Inventaris Stats -->
        <div class="col-md-4">
            <div class="stat-card h-100 border-0 shadow-sm rounded-3 bg-white overflow-hidden">
                <div class="p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-success fw-medium mb-2">Total Inventaris</p>
                            <h3 class="fw-bold text-dark mb-0">{{ $totalInventaris }}</h3>
                            <div class="mt-3">
                                <span class="badge bg-success-subtle text-success me-2">
                                    <i class="fas fa-check-circle me-1"></i>{{ $inventarisTersedia }} Tersedia
                                </span>
                                <span class="badge bg-danger-subtle text-danger">
                                    <i class="fas fa-times-circle me-1"></i>{{ $inventarisTidakTersedia }} Tidak
                                </span>
                            </div>
                        </div>
                        <div class="stat-icon bg-success-subtle p-3 rounded-3">
                            <i class="fas fa-boxes fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
                <div class="progress" style="height: 4px;">
                    <div class="progress-bar bg-success" style="width: {{ $totalInventaris > 0 ? ($inventarisTersedia/$totalInventaris)*100 : 0 }}%"></div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-md-4">
            <div class="quick-actions h-100 border-0 shadow-sm rounded-3 bg-white">
                <div class="p-4">
                    <h5 class="fw-bold text-warning mb-3">
                        <i class="fas fa-bolt me-2"></i>Aksi Cepat
                    </h5>
                    <div class="d-grid gap-3">
                        <a href="{{ route('admin.katalog_ruangan.create') }}" 
                           class="btn btn-outline-primary rounded-3 d-flex align-items-center p-3">
                            <i class="fas fa-plus-circle fa-lg me-3"></i>
                            <div class="text-start">
                                <strong>Tambah Ruangan</strong>
                                <small class="d-block text-muted">Tambah ruangan baru ke sistem</small>
                            </div>
                        </a>
                        <a href="{{ route('admin.inventaris.create') }}" 
                           class="btn btn-outline-success rounded-3 d-flex align-items-center p-3">
                            <i class="fas fa-plus-circle fa-lg me-3"></i>
                            <div class="text-start">
                                <strong>Tambah Inventaris</strong>
                                <small class="d-block text-muted">Tambah inventaris baru ke sistem</small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts & Activities -->
    <div class="row g-4">
        <!-- Statistics Chart -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold text-primary mb-0">
                            <i class="fas fa-chart-line me-2"></i>Statistik Peminjaman
                        </h5>
                        <div class="d-flex gap-2">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-outline-primary active" data-type="ruangan">
                                    <i class="fas fa-building me-1"></i>Ruangan
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-primary" data-type="inventaris">
                                    <i class="fas fa-boxes me-1"></i>Inventaris
                                </button>
                            </div>
                            <div class="btn-group ms-2">
                                <button type="button" class="btn btn-sm btn-outline-secondary active" data-period="month">
                                    Bulanan
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" data-period="week">
                                    Mingguan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <canvas id="peminjamanChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
      <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold text-success mb-0">
                        <i class="fas fa-history me-2"></i>Aktivitas Terbaru
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="activity-list">
                        @forelse ($aktivitasTerbaru as $aktivitas)
                            <div class="activity-item p-3 border-bottom">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="activity-icon bg-light rounded-circle p-2 me-3">
                                        @if($aktivitas->type == 'peminjaman_ruangan')
                                            <i class="fas fa-building text-primary"></i>
                                        @elseif($aktivitas->type == 'peminjaman_inventaris')
                                            <i class="fas fa-boxes text-success"></i>
                                        @elseif($aktivitas->type == 'laporan_inventaris')
                                            <i class="fas fa-flag text-warning"></i>
                                        @elseif($aktivitas->type == 'laporan_ruangan')
                                            <i class="fas fa-exclamation-triangle text-warning"></i>
                                        @else
                                            <i class="fas fa-bell text-info"></i>
                                        @endif
                                    </span>
                                    <p class="mb-0 flex-grow-1">{{ $aktivitas->deskripsi }}</p>
                                </div>
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ $aktivitas->created_at->diffForHumans() }}
                                </small>
                            </div>
                        @empty
                            <div class="text-center text-muted py-5">
                                <i class="fas fa-inbox fa-3x mb-3 opacity-50"></i>
                                <p class="mb-0">Belum ada aktivitas terbaru</p>
                            </div>
                        @endforelse
                    </div>
                    <div class="card-footer bg-light py-3 border-top">
                        <div class="row text-center g-3">
                            <div class="col-6">
                                <a href="{{ route('admin.pinjam-ruangan.index') }}" class="text-decoration-none">
                                    <div class="quick-stat p-2 rounded-3 bg-primary bg-opacity-10 text-primary">
                                        <i class="fas fa-clock fa-fw mb-1"></i>
                                        <div class="small fw-medium">Pengajuan Pending</div>
                                        <div class="fw-bold">{{ $pendingPeminjaman ?? 0 }}</div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('admin.lapor_ruangan.index') }}" class="text-decoration-none">
                                    <div class="quick-stat p-2 rounded-3 bg-warning bg-opacity-10 text-warning">
                                        <i class="fas fa-exclamation-triangle fa-fw mb-1"></i>
                                        <div class="small fw-medium">Laporan Baru</div>
                                        <div class="fw-bold">{{ $newLaporan ?? 0 }}</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('peminjamanChart').getContext('2d');
let currentChart = null;

const chartData = {
    ruangan: {
        month: {
            labels: @json($grafik['bulan'] ?? []),
            data: @json($grafik['jumlah'] ?? [])
        },
        week: {
            labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
            data: [4, 6, 8, 5, 7, 3, 2]    
        }
    },
    inventaris: {
        month: {
            labels: @json($grafik['bulan'] ?? []),
            data: @json($grafik['jumlah_inventaris'] ?? [])
        },
        week: {
            labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
            data: [3, 5, 7, 4, 6, 2, 1]    
        }
    }
};

function updateChart(type = 'ruangan', period = 'month') {
    const data = chartData[type][period];
    
    if (currentChart) {
        currentChart.destroy();
    }

    currentChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: data.labels,
            datasets: [{
                label: `Peminjaman ${type === 'ruangan' ? 'Ruangan' : 'Inventaris'}`,
                data: data.data,
                borderColor: type === 'ruangan' ? '#667eea' : '#28a745',
                backgroundColor: type === 'ruangan' ? 'rgba(102, 126, 234, 0.1)' : 'rgba(40, 167, 69, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        display: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
}


updateChart();


document.querySelectorAll('[data-type]').forEach(button => {
    button.addEventListener('click', function() {
        const type = this.dataset.type;

        const period = document.querySelector('[data-period].active').dataset.period;

        document.querySelectorAll('[data-type]').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        
        updateChart(type, period);
    });
});

document.querySelectorAll('[data-period]').forEach(button => {
    button.addEventListener('click', function() {
        const period = this.dataset.period;

        const type = document.querySelector('[data-type].active').dataset.type;

        document.querySelectorAll('[data-period]').forEach(b => b.classList.remove('active'));

        this.classList.add('active');
        
        updateChart(type, period);
    });
});
</script>
@endpush

@endsection