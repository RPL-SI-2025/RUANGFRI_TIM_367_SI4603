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
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.jadwal.edit', $jadwal->id) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('admin.jadwal.destroy', $jadwal->id) }}" method="POST" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet">

<script>
document.addEventListener('DOMContentLoaded', function() {
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
    

    document.getElementById('filter-form').addEventListener('submit', function() {

    });
});
</script>
@endpush

@endsection