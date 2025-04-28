
@extends('mahasiswa.layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Peminjaman Inventaris</h1>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(count($pinjamInventaris) > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Item(s) Dipinjam</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                        // Group peminjaman by tanggal_pengajuan, tanggal_selesai, waktu_mulai, waktu_selesai, file_scan
                        $groupedPinjam = $pinjamInventaris->groupBy(function($item) {
                            return $item->tanggal_pengajuan . '-' . $item->tanggal_selesai . '-' . 
                                  $item->waktu_mulai . '-' . $item->waktu_selesai . '-' . $item->file_scan;
                        });
                        $i = 1;
                    @endphp

                    @foreach($groupedPinjam as $group)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ \Carbon\Carbon::parse($group->first()->tanggal_pengajuan)->format('d-m-Y') }}</td>
                            <td>
                                <ul>
                                @foreach($group as $pinjam)
                                    <li>{{ $pinjam->inventaris->nama_inventaris ?? 'Inventaris tidak ditemukan' }}</li>
                                @endforeach
                                </ul>
                            </td>
                            <td>
                                @if($group->first()->status == 0)
                                    <span class="badge bg-warning">Menunggu Persetujuan</span>
                                @elseif($group->first()->status == 1)
                                    <span class="badge bg-success">Disetujui</span>
                                @elseif($group->first()->status == 2)
                                    <span class="badge bg-danger">Ditolak</span>
                                @elseif($group->first()->status == 3)
                                    <span class="badge bg-info">Selesai</span>
                                @elseif ($group->first()->status == 4)
                                    <span class="badge bg-secondary">Dibatalkan</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('mahasiswa.peminjaman.pinjam-inventaris.show', $group->first()->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                                
                                @if($group->first()->status == 1) {{-- Only show the "Selesai" button if status is approved (1) --}}
                                    <a href="{{ route('mahasiswa.pelaporan.lapor_inventaris.create', ['id_peminjaman' => $group->first()->id]) }}" 
                                    class="btn btn-success btn-sm">
                                        <i class="fas fa-check-circle"></i> Selesai
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">Anda belum memiliki peminjaman inventaris.</div>
    @endif
</div>
@endsection