
@extends('admin.layouts.admin')

@section('title', 'Detail Jadwal Ruangan')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Detail Jadwal: {{ $ruangan->nama_ruangan ?? 'Tidak ada data' }}</h2>
        <div>
            <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="mb-3">Informasi Ruangan</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Nama Ruangan</th>
                            <td>{{ $ruangan->nama_ruangan ?? 'Tidak ada data' }}</td>
                        </tr>
                        <tr>
                            <th>Lokasi</th>
                            <td>{{ $ruangan->lokasi ?? 'Tidak ada data' }}</td>
                        </tr>
                        <tr>
                            <th>Kapasitas</th>
                            <td>{{ $ruangan->kapasitas ?? 'Tidak ada data' }} orang</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>{{ $ruangan->status ?? 'Tidak ada data' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5 class="mb-3">Ketersediaan Jadwal</h5>
                    <div class="calendar-legend mb-3">
                        <div class="d-flex flex-wrap gap-3">
                            <div class="legend-item d-flex align-items-center">
                                <span class="legend-indicator me-2" style="background-color: #d1e7dd; width: 16px; height: 16px; display: inline-block; border-radius: 4px;"></span>
                                <span>Tersedia</span>
                            </div>
                            <div class="legend-item d-flex align-items-center">
                                <span class="legend-indicator me-2" style="background-color: #fff3cd; width: 16px; height: 16px; display: inline-block; border-radius: 4px;"></span>
                                <span>Dalam Proses</span>
                            </div>
                            <div class="legend-item d-flex align-items-center">
                                <span class="legend-indicator me-2" style="background-color: #f8d7da; width: 16px; height: 16px; display: inline-block; border-radius: 4px;"></span>
                                <span>Booked</span>
                            </div>
                        </div>
                    </div>
                    <div id="calendar-container">
                        <!-- Calendar will be rendered here by JS -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">Filter Jadwal</h5>
        </div>
        <div class="card-body">
            <form id="filter-form" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="status" class="form-label">Status Ketersediaan</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Dalam Proses</option>
                        <option value="booked" {{ request('status') == 'booked' ? 'selected' : '' }}>Booked</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="start_date" class="form-label">Tanggal Mulai</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-3">
                    <label for="end_date" class="form-label">Tanggal Selesai</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-filter me-1"></i> Filter
                    </button>
                    <a href="{{ route('admin.jadwal.show', $ruangan->id) }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-repeat me-1"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Slot Jadwal</h5>
            <div>
                <span class="badge bg-primary">Total: {{ $jadwals->count() }} slot</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-3 py-3">No</th>
                            <th class="px-3 py-3">Tanggal</th>
                            <th class="px-3 py-3">Waktu</th>
                            <th class="px-3 py-3">Status</th>
                            <th class="px-3 py-3">Peminjam</th>
                            <th class="px-3 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jadwals as $jadwal)
                            <tr>
                                <td class="px-3 py-3">{{ $loop->iteration }}</td>
                                <td class="px-3 py-3">{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }}</td>
                                <td class="px-3 py-3">
                                    {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - 
                                    {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                </td>
                                <td class="px-3 py-3">
                                    @if($jadwal->status == 'tersedia')
                                        <span class="badge bg-success">Tersedia</span>
                                    @elseif($jadwal->status == 'proses')
                                        <span class="badge bg-warning text-dark">Proses</span>
                                    @elseif($jadwal->status == 'booked')
                                        <span class="badge bg-danger">Booked</span>
                                    @else
                                        <span class="badge bg-secondary">Tidak Diketahui</span>
                                    @endif
                                </td>
                                <td class="px-3 py-3">
                                    @if($jadwal->id_pinjam_ruangan)
                                        {{ $jadwal->pinjamRuangan->mahasiswa->nama_mahasiswa ?? 'Tidak ada data' }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-3 py-3">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="{{ route('admin.jadwal.edit', $jadwal->id) }}" 
                                           class="btn btn-warning me-2"
                                           data-bs-toggle="tooltip" 
                                           data-bs-placement="top" 
                                           title="Edit Jadwal">
                                            <i class="bi bi-pencil-square me-1"></i>
                                            <span class="d-none d-lg-inline">Edit</span>
                                        </a>
                                        <form action="{{ route('admin.jadwal.destroy', $jadwal->id) }}" method="POST" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')"
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-danger"
                                                    data-bs-toggle="tooltip" 
                                                    data-bs-placement="top" 
                                                    title="Hapus Jadwal">
                                                <i class="bi bi-trash me-1"></i>
                                                <span class="d-none d-lg-inline">Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($jadwals->count() == 0)
            <div class="text-center py-5">
                <i class="bi bi-calendar-x" style="font-size: 4rem; color: #d3d3d3;"></i>
                <p class="mt-3 text-muted">Tidak ada jadwal yang sesuai dengan filter</p>
            </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>

.btn {
    transition: all 0.3s ease;
    font-weight: 500;
    border-radius: 0.375rem; 
    padding: 0.375rem 0.75rem; 
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}


.btn-warning {
    background-color: #ffc107;
    border-color: #ffc107;
    color: #000;
}

.btn-warning:hover {
    background-color: #ffca2c;
    border-color: #ffc720;
    color: #000;
}

.btn-danger {
    background-color: #dc3545;
    border-color: #dc3545;
    color: #fff;
}

.btn-danger:hover {
    background-color: #c82333;
    border-color: #bd2130;
    color: #fff;
}

.btn-primary {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.btn-primary:hover {
    background-color: #0b5ed7;
    border-color: #0a58ca;
}

.btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
}

.btn-secondary:hover {
    background-color: #5c636a;
    border-color: #565e64;
}


@media (max-width: 991.98px) {
    .d-none.d-lg-inline {
        display: none !important;
    }
    
    .btn {
        padding: 0.375rem 0.5rem !important;
        min-width: 40px;
    }
}

@media (min-width: 992px) {
    .d-none.d-lg-inline {
        display: inline !important;
    }
}


.table-hover tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.05);
    transition: all 0.2s ease;
}


.badge {
    font-weight: 600;
    letter-spacing: 0.5px;
    padding: 0.5em 0.75em;
    border-radius: 0.375rem;
    font-size: 0.75rem;
}

.badge.bg-success {
    background-color: #198754 !important;
}

.badge.bg-warning {
    background-color: #ffc107 !important;
    color: #000 !important;
}

.badge.bg-danger {
    background-color: #dc3545 !important;
}

.badge.bg-primary {
    background-color: #0d6efd !important;
}


.card {
    border: 1px solid #dee2e6;
    border-radius: 0.5rem;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    transition: all 0.3s ease;
}

.card:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
    font-weight: 600;
}


.table th {
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
    color: #495057;
}

.table td {
    vertical-align: middle;
    border-bottom: 1px solid #dee2e6;
}


.d-flex.gap-2 > * {
    margin: 0;
}


th:last-child,
td:last-child {
    text-align: center;
    width: 160px;
    min-width: 160px;
}


.tooltip {
    font-size: 0.875rem;
}

.tooltip-inner {
    background-color: #343a40;
    border-radius: 0.375rem;
    padding: 0.5rem 0.75rem;
}


.btn:disabled {
    opacity: 0.65;
    cursor: not-allowed;
    transform: none !important;
}


.form-select:focus,
.form-control:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.form-label {
    font-weight: 500;
    color: #495057;
}


#calendar-container {
    border-radius: 0.5rem;
    overflow: hidden;
    box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
}


.legend-item {
    padding: 0.5rem;
    border-radius: 0.375rem;
    background-color: #f8f9fa;
    transition: all 0.2s ease;
    border: 1px solid #dee2e6;
}

.legend-item:hover {
    background-color: #e9ecef;
    transform: translateY(-1px);
}

.legend-indicator {
    border: 1px solid rgba(0,0,0,0.1) !important;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}


@media (max-width: 768px) {
    .px-3 {
        padding-left: 0.5rem !important;
        padding-right: 0.5rem !important;
    }
    
    .py-3 {
        padding-top: 0.5rem !important;
        padding-bottom: 0.5rem !important;
    }
    
    .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
    
    .table {
        font-size: 0.875rem;
    }
    
    th:last-child,
    td:last-child {
        width: 120px;
        min-width: 120px;
    }
    
    .me-2 {
        margin-right: 0.25rem !important;
    }
}


.d-flex.gap-2 .btn {
    margin-right: 0;
}

.d-flex.gap-2 .btn:not(:last-child) {
    margin-right: 0.5rem;
}


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
    animation: fadeInUp 0.6s ease-out;
}

.card:nth-child(1) { animation-delay: 0.1s; }
.card:nth-child(2) { animation-delay: 0.2s; }
.card:nth-child(3) { animation-delay: 0.3s; }


form .btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
}


.btn i {
    line-height: 1;
}
</style>
@endpush

@push('scripts')
<script src="https:
<link href="https:

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn && submitBtn.type === 'submit') {
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i><span class="d-none d-lg-inline">Memproses...</span>';
                submitBtn.disabled = true;
                
                
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }, 5000);
            }
        });
    });

    
    const calendarEl = document.getElementById('calendar-container');
    
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek'
        },
        events: {!! json_encode(
            $allJadwals->map(function($jadwal) {
                $colors = [
                    'tersedia' => [
                        'backgroundColor' => '#d1e7dd',
                        'borderColor' => '#badbcc',
                        'textColor' => '#0f5132',
                    ],
                    'proses' => [
                        'backgroundColor' => '#fff3cd',
                        'borderColor' => '#ffecb5',
                        'textColor' => '#664d03',
                    ],
                    'booked' => [
                        'backgroundColor' => '#f8d7da',
                        'borderColor' => '#f5c2c7',
                        'textColor' => '#842029',
                    ],
                    'default' => [
                        'backgroundColor' => '#e9ecef',
                        'borderColor' => '#dee2e6',
                        'textColor' => '#495057',
                    ]
                ];
                $color = $colors[$jadwal->status] ?? $colors['default'];
                return [
                    'title' => \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') . ' - ' . \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i'),
                    'start' => $jadwal->tanggal . 'T' . $jadwal->jam_mulai,
                    'end' => $jadwal->tanggal . 'T' . $jadwal->jam_selesai,
                    'backgroundColor' => $color['backgroundColor'],
                    'borderColor' => $color['borderColor'],
                    'textColor' => $color['textColor'],
                    'url' => route('admin.jadwal.edit', $jadwal->id),
                ];
            })
        ) !!},
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        }
    });
    
    calendar.render();
});
</script>
@endpush

@endsection