@extends('admin.layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Semua Peminjaman Inventaris</h5>
                        <div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Inventaris</th>
                                    <th>Peminjam</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($peminjaman as $index => $pinjam)
                                    <tr>
                                        <td>{{ $index + $peminjaman->firstItem() }}</td>
                                        <td>{{ $pinjam->inventaris->nama_inventaris ?? 'N/A' }}</td>
                                        <td>{{ $pinjam->mahasiswa->nama ?? 'N/A' }} ({{ $pinjam->mahasiswa->nim ?? 'N/A' }})</td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($pinjam->tanggal_pengajuan)->format('d-m-Y') }} s/d
                                            {{ \Carbon\Carbon::parse($pinjam->tanggal_selesai)->format('d-m-Y') }}
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($pinjam->waktu_mulai)->format('H:i') }} - 
                                            {{ \Carbon\Carbon::parse($pinjam->waktu_selesai)->format('H:i') }}
                                        </td>
                                        <td>
                                            @php
                                                $badgeClass = '';
                                                switch($pinjam->status) {
                                                    case 0:
                                                        $badgeClass = 'bg-warning';
                                                        break;
                                                    case 1:
                                                        $badgeClass = 'bg-success';
                                                        break;
                                                    case 2:
                                                        $badgeClass = 'bg-danger';
                                                        break;
                                                    case 3:
                                                        $badgeClass = 'bg-info';
                                                        break;
                                                }
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">{{ $pinjam->status_text }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <!-- Detail Button -->
                                                <a href="{{ route('pinjam-inventaris.show', $pinjam->id) }}" class="btn btn-sm btn-info text-white">
                                                    <i class="fa fa-eye"></i> Detail
                                                </a>
                                                
                                                <!-- Actions Dropdown -->
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="actionMenu{{ $pinjam->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa fa-cog"></i> Tindakan
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="actionMenu{{ $pinjam->id }}">
                                                        @if($pinjam->status == 0)
                                                        <li>
                                                            <form action="{{ route('pinjam-inventaris.update-status', $pinjam->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="status" value="1">
                                                                <button type="submit" class="dropdown-item text-success" onclick="return confirm('Apakah Anda yakin ingin menyetujui peminjaman ini?')">
                                                                    <i class="fa fa-check me-2"></i> Setujui
                                                                </button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('pinjam-inventaris.update-status', $pinjam->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="status" value="2">
                                                                <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Apakah Anda yakin ingin menolak peminjaman ini?')">
                                                                    <i class="fa fa-times me-2"></i> Tolak
                                                                </button>
                                                            </form>
                                                        </li>
                                                        @endif
                                                        
                                                        @if($pinjam->status == 1)
                                                        <li>
                                                            <form action="{{ route('pinjam-inventaris.update-status', $pinjam->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="status" value="3">
                                                                <button type="submit" class="dropdown-item text-primary" onclick="return confirm('Apakah Anda yakin peminjaman ini telah selesai?')">
                                                                    <i class="fa fa-check-circle me-2"></i> Selesai
                                                                </button>
                                                            </form>
                                                        </li>
                                                        @endif
                                                        
                                                        <li>
                                                            <button type="button" class="dropdown-item text-secondary" data-bs-toggle="modal" data-bs-target="#statusModal{{ $pinjam->id }}">
                                                                <i class="fa fa-edit me-2"></i> Ubah Status
                                                            </button>
                                                        </li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $pinjam->id }}">
                                                                <i class="fa fa-trash me-2"></i> Hapus
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data peminjaman inventaris</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center mt-3">
                        {{ $peminjaman->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection