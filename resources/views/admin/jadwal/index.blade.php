@extends('admin.layouts.admin')

@section('title', 'Manajemen Jadwal')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Manajemen Jadwal</h4>
        <div>
            <a href="{{ route('admin.jadwal.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle me-1"></i> Tambah Slot Jadwal
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">Filter Jadwal</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.jadwal.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="ruangan" class="form-label">Ruangan</label>
                    <select name="ruangan" id="ruangan" class="form-select">
                        <option value="">Semua Ruangan</option>
                        @foreach(App\Models\Ruangan::all() as $ruangan)
                            <option value="{{ $ruangan->id }}" {{ request('ruangan') == $ruangan->id ? 'selected' : '' }}>
                                {{ $ruangan->nama_ruangan }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Proses</option>
                        <option value="booked" {{ request('status') == 'booked' ? 'selected' : '' }}>Booked</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">Filter</button>
                    <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm mt-4">
        <div class="card-body p-0">
            @php

                $groupedJadwals = $jadwals->groupBy('id_ruangan');
            @endphp

            @if($groupedJadwals->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-3 py-3">No</th>
                                <th class="px-3 py-3">Ruangan</th>
                                <th class="px-3 py-3">Lokasi</th>
                                <th class="px-3 py-3">Rentang Tanggal</th>
                                <th class="px-3 py-3">Status Ketersediaan</th>
                                <th class="px-3 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($groupedJadwals as $ruanganId => $ruanganJadwals)
                                @php
                                    $ruangan = App\Models\Ruangan::find($ruanganId);
                                    $minDate = $ruanganJadwals->min('tanggal');
                                    $maxDate = $ruanganJadwals->max('tanggal');


                                    $totalSlots = $ruanganJadwals->count();
                                    $availableSlots = $ruanganJadwals->where('status', 'tersedia')->count();
                                    $bookedSlots = $ruanganJadwals->where('status', 'booked')->count();
                                    $processingSlots = $ruanganJadwals->where('status', 'proses')->count();


                                    $startDate = \Carbon\Carbon::parse($minDate);
                                    $endDate = \Carbon\Carbon::parse($maxDate);
                                    $totalDays = $startDate->diffInDays($endDate) + 1;


                                    $availablePercentage = $totalSlots > 0 ? round(($availableSlots / $totalSlots) * 100) : 0;


                                    $dateGroupedSlots = $ruanganJadwals->groupBy('tanggal');
                                    $totalDatesWithSlots = $dateGroupedSlots->count();
                                @endphp
                                <tr>
                                    <td class="px-3 py-3">{{ $loop->iteration }}</td>
                                    <td class="px-3 py-3 fw-medium">{{ $ruangan->nama_ruangan ?? 'Tidak ada data' }}</td>
                                    <td class="px-3 py-3">{{ $ruangan->lokasi ?? 'Tidak ada data' }}</td>
                                    <td class="px-3 py-3">
                                        {{ \Carbon\Carbon::parse($minDate)->format('d M Y') }}
                                        <span class="text-muted">s/d</span>
                                        {{ \Carbon\Carbon::parse($maxDate)->format('d M Y') }}
                                        <div class="small text-muted mt-1">
                                            Total: {{ $totalDays }} hari, {{ $totalDatesWithSlots }} hari terjadwal
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="progress flex-grow-1 me-2" style="height: 10px;">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                     style="width: {{ $availablePercentage }}%"
                                                     aria-valuenow="{{ $availablePercentage }}"
                                                     aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <span class="badge bg-success">{{ $availableSlots }}/{{ $totalSlots }}</span>
                                        </div>
                                        <div class="small mt-1">
                                            <span class="text-success">{{ $availableSlots }} slot tersedia</span> |
                                            <span class="text-warning">{{ $processingSlots }} slot proses</span> |
                                            <span class="text-danger">{{ $bookedSlots }} slot booked</span>
                                        </div>
                                        <div class="small text-muted">
                                            Lihat detail untuk jadwal lengkap per hari dan jam
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 text-center">
                                        <a href="{{ route('admin.jadwal.show', $ruanganId) }}"
                                        class="btn btn-sm btn-primary">
                                            <i class="bi bi-calendar-week me-1"></i> Lihat Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-calendar-x" style="font-size: 4rem; color: #d3d3d3;"></i>
                    <p class="mt-3 text-muted">Belum ada data jadwal</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
