@extends('admin.layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Laporan Ruangan</h1>
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

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Data Laporan Ruangan</h6>
        </div>
        <div class="card-body">
            @if($pelaporans->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-center" width="5%">No</th>
                                <th>ID Peminjaman</th>
                                <th>Tanggal</th>
                                <th>Mahasiswa</th>
                                <th>Ruangan</th>
                                <th>Deskripsi</th>
                                <th class="text-center" width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pelaporans as $index => $item)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $item->peminjaman->id }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->datetime)->format('d M Y H:i') }}</td>
                                    <td>{{ $item->mahasiswa->nama_mahasiswa ?? 'Tidak ada data' }}</td>
                                    <td>{{ $item->ruangan->nama_ruangan ?? 'Tidak ada data' }}</td>
                                    <td>{{ Str::limit($item->deskripsi, 50) }}</td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.lapor_ruangan.show', $item->id_lapor_ruangan) }}" 
                                               class="btn btn-info btn-sm me-2" title="Lihat Detail">
                                                <i class="bi bi-eye"></i> Detail
                                            </a>
                                            <a href="{{ route('mahasiswa.pelaporan.lapor_ruangan.pdf', $item->id_lapor_ruangan) }}" 
                                               class="btn btn-primary btn-sm" title="Download Laporan">
                                                <i class="bi bi-download"></i> Download
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-file-earmark-x" style="font-size: 4rem; color: #d3d3d3;"></i>
                    <p class="mt-3 text-muted">Belum ada data laporan ruangan</p>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            responsive: true,
            columnDefs: [
                { orderable: false, targets: 6 } // Disable sorting on the "Aksi" column
            ]
        });
    });
</script>
@endpush
@endsection