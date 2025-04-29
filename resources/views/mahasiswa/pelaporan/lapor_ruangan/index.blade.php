@extends('mahasiswa.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Ruangan</h1>
        <a href="{{ route('mahasiswa.pelaporan.lapor_ruangan.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Buat Laporan Baru
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Laporan Ruangan</h6>
        </div>
        <div class="card-body">
            @if($laporan->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Ruangan</th>
                                <th>Deskripsi</th>
                                <th>Admin Logistik</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($laporan as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="px-3 py-3">
                                        {{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d M Y') }}
                                        <span class="text-muted"> s/d </span>
                                        {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}
                                    </td>
                                    <td>{{ $item->ruangan->nama_ruangan ?? 'Tidak ada data' }}</td>
                                    <td>{{$item->deskripsi ?? 'Tidak ada data'}}</td>
                                    <td>{{ $item->logistik->nama ?? 'Tidak ada data' }}</td>
                                    <td>
                                        <a href="{{ route('mahasiswa.pelaporan.lapor_ruangan.show', $item->id_lapor_ruangan) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($item->status == 'pending')
                                            <a href="{{ route('mahasiswa.pelaporan.lapor_ruangan.edit', $item->id_lapor_ruangan) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $item->id_lapor_ruangan }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <img src="{{ asset('img/empty-data.svg') }}" alt="Data Kosong" class="img-fluid mb-3" style="max-height: 150px;">
                    <h5 class="text-muted">Belum ada laporan ruangan</h5>
                    <p class="text-muted">Buat laporan baru dengan mengklik tombol "Buat Laporan Baru" di atas.</p>
                    <a href="{{ route('mahasiswa.pelaporan.lapor_ruangan.create') }}" class="btn btn-primary mt-2">
                        <i class="fas fa-plus mr-1"></i> Buat Laporan Baru
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