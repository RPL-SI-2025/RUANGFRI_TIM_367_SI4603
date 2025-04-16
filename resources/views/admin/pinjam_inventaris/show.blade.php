@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Detail Peminjaman Inventaris</h5>
                        <div>
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('pinjam-inventaris.index') }}" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i> Kembali ke Daftar
                                </a>
                            @else
                                <a href="{{ route('pinjam-inventaris.mahasiswa') }}" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i> Kembali ke Riwayat
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2 mb-3">Informasi Peminjaman</h6>
                            <div class="mb-2">
                                <strong>Status:</strong>
                                @php
                                    $badgeClass = '';
                                    switch($pinjamInventaris->status) {
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
                                <span class="badge {{ $badgeClass }}">{{ $pinjamInventaris->status_text }}</span>
                            </div>
                            <div class="mb-2">
                                <strong>Tanggal Pengajuan:</strong> {{ \Carbon\Carbon::parse($pinjamInventaris->tanggal_pengajuan)->format('d-m-Y') }}
                            </div>
                            <div class="mb-2">
                                <strong>Tanggal Selesai:</strong> {{ \Carbon\Carbon::parse($pinjamInventaris->tanggal_selesai)->format('d-m-Y') }}
                            </div>
                            <div class="mb-2">
                                <strong>Waktu:</strong> 
                                {{ \Carbon\Carbon::parse($pinjamInventaris->waktu_mulai)->format('H:i') }} - 
                                {{ \Carbon\Carbon::parse($pinjamInventaris->waktu_selesai)->format('H:i') }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2 mb-3">Informasi Peminjam</h6>
                            <div class="mb-2">
                                <strong>Nama:</strong> {{ $pinjamInventaris->mahasiswa->nama ?? 'N/A' }}
                            </div>
                            <div class="mb-2">
                                <strong>NIM:</strong> {{ $pinjamInventaris->mahasiswa->nim ?? 'N/A' }}
                            </div>
                            <div class="mb-2">
                                <strong>Program Studi:</strong> {{ $pinjamInventaris->mahasiswa->prodi ?? 'N/A' }}
                            </div>
                            <div class="mb-2">
                                <strong>Email:</strong> {{ $pinjamInventaris->mahasiswa->email ?? 'N/A' }}
                            </div>
                        </div>
                    </div>

                    <h6 class="border-bottom pb-2 mb-3">Detail Inventaris</h6>
                    <div class="mb-4">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <strong>Nama Inventaris:</strong> {{ $pinjamInventaris->inventaris->nama_inventaris ?? 'N/A' }}
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Jumlah:</strong> {{ $pinjamInventaris->inventaris->jumlah ?? 'N/A' }}
                            </div>
                            <div class="col-md-12 mb-2">
                                <strong>Deskripsi:</strong> {{ $pinjamInventaris->inventaris->deskripsi ?? 'N/A' }}
                            </div>
                        </div>
                    </div>

                    @if($pinjamInventaris->file_scan)
                    <h6 class="border-bottom pb-2 mb-3">Dokumen Pendukung</h6>
                    <div class="mb-4">
                        <a href="{{ asset('storage/uploads/file_scan/' . $pinjamInventaris->file_scan) }}" 
                           target="_blank" class="btn btn-outline-secondary">
                            <i class="fa fa-file"></i> Lihat File Scan
                        </a>
                    </div>
                    @endif

                    @if(auth()->user()->role === 'admin' && $pinjamInventaris->status == 0)
                    <div class="border-top pt-3 mt-4">
                        <h6 class="mb-3">Aksi</h6>
                        <div class="d-flex">
                            <form action="{{ route('pinjam-inventaris.update-status', $pinjamInventaris->id_pinjam_inventaris) }}" method="POST" class="me-2">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="1">
                                <button type="submit" class="btn btn-success" onclick="return confirm('Apakah Anda yakin ingin menyetujui peminjaman ini?')">
                                    <i class="fa fa-check"></i> Setujui Peminjaman
                                </button>
                            </form>
                            <form action="{{ route('pinjam-inventaris.update-status', $pinjamInventaris->id_pinjam_inventaris) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="2">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menolak peminjaman ini?')">
                                    <i class="fa fa-times"></i> Tolak Peminjaman
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif

                    @if(auth()->user()->role === 'admin' && $pinjamInventaris->status == 1)
                    <div class="border-top pt-3 mt-4">
                        <form action="{{ route('pinjam-inventaris.update-status', $pinjamInventaris->id_pinjam_inventaris) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="3">
                            <button type="submit" class="btn btn-info" onclick="return confirm('Apakah Anda yakin peminjaman ini telah selesai?')">
                                <i class="fa fa-check-circle"></i> Tandai Selesai
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection