@extends('mahasiswa.layouts.app')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4">
        <i class="fas fa-door-closed fa-sm me-2"></i>Daftar Laporan Ruangan
    </h4>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            @if($laporan->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Pelaporan</th>
                                <th>Tanggal Peminjaman</th>
                                <th>Ruangan</th>
                                <th>Deskripsi</th>
                                <th>Diberikan Kepada</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($laporan as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y H:i') }}</td>
                                    <td class="px-3 py-3">
                                        {{ \Carbon\Carbon::parse($item->peminjaman->tanggal_pengajuan)->format('d M Y') }}
                                        <span class="text-muted"> s/d </span>
                                        {{ \Carbon\Carbon::parse($item->peminjaman->tanggal_pengajuan)->format('d M Y') }}
                                    </td>
                                    <td>{{ $item->ruangan->nama_ruangan ?? 'Tidak ada data' }}</td>
                                    <td>{{$item->deskripsi ?? 'Tidak ada data'}}</td>
                                    <td>{{ $item->logistik->nama ?? 'Tidak ada data' }}</td>
                                    <td>
                                        <a href="{{ route('mahasiswa.pelaporan.lapor_ruangan.show', $item->id_lapor_ruangan) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('mahasiswa.pelaporan.lapor_ruangan.edit', $item->id_lapor_ruangan) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-clipboard fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada laporan ruangan</h5>
                    <p class="text-muted">Laporan akan muncul saat Anda menyelesaikan peminjaman Ruangan.</p>
                    <a href="{{ route('mahasiswa.peminjaman.pinjam-ruangan.index') }}" class="btn btn-primary mt-2">
                        <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Peminjaman
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
@endpush