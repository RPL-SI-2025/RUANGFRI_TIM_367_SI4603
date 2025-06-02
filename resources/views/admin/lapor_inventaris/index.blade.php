@extends('admin.layouts.admin')

@section('title', 'Daftar Laporan Inventaris')

@section('content')
<div class="container">
    <h2 class="mb-4">Daftar Laporan Inventaris</h2>
    
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID Laporan</th>
                            <th>ID Peminjaman</th>
                            <th>Tanggal</th>
                            <th>Mahasiswa</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporan as $item)
                        <tr>
                            <td>{{ $item->id_lapor_inventaris }}</td>
                            <td><strong> {{ $item->peminjaman->id  }}</strong></td>
                            <td>{{ \Carbon\Carbon::parse($item->datetime)->format('d/m/Y H:i') }}</td>
                            <td>{{ $item->mahasiswa->nama_mahasiswa ?? 'N/A' }}</td>
                            <td>{{ \Str::limit($item->deskripsi, 50) }}</td>
                            <td>
                                <!-- Admin hanya bisa melihat detail -->
                                <a href="{{ route('admin.lapor_inventaris.show', $item->id_lapor_inventaris) }}" class="btn btn-info btn-sm">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data laporan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection