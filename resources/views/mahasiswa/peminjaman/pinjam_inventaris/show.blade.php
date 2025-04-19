@extends('mahasiswa.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Peminjaman Inventaris</h5>
                    <a href="{{ route('mahasiswa.peminjaman.pinjam-inventaris.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="border-bottom pb-2 mb-3">Informasi Peminjaman</h6>
                        
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Status</div>
                            <div class="col-md-8">
                                @if($pinjamInventaris->status == 0)
                                    <span class="badge bg-warning">Menunggu Persetujuan</span>
                                @elseif($pinjamInventaris->status == 1)
                                    <span class="badge bg-success">Disetujui</span>
                                @elseif($pinjamInventaris->status == 2)
                                    <span class="badge bg-danger">Ditolak</span>
                                @elseif($pinjamInventaris->status == 3)
                                    <span class="badge bg-info">Selesai</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Inventaris</div>
                            <div class="col-md-8">{{ $pinjamInventaris->inventaris->nama_inventaris }}</div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Peminjam</div>
                            <div class="col-md-8">{{ $pinjamInventaris->mahasiswa->nama }} ({{ $pinjamInventaris->mahasiswa->nim }})</div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Tanggal Pengajuan</div>
                            <div class="col-md-8">{{ date('d-m-Y', strtotime($pinjamInventaris->tanggal_pengajuan)) }}</div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Tanggal Selesai</div>
                            <div class="col-md-8">{{ date('d-m-Y', strtotime($pinjamInventaris->tanggal_selesai)) }}</div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Waktu</div>
                            <div class="col-md-8">{{ date('H:i', strtotime($pinjamInventaris->waktu_mulai)) }} - {{ date('H:i', strtotime($pinjamInventaris->waktu_selesai)) }}</div>
                        </div>
                        
                        @if($pinjamInventaris->file_scan)
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">File Scan</div>
                            <div class="col-md-8">
                                <a href="{{ asset('storage/uploads/file_scan/'.$pinjamInventaris->file_scan) }}" 
                                   target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-file-download me-1"></i> Lihat File
                                </a>
                            </div>
                        </div>
                        @endif
                        
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Tanggal Dibuat</div>
                            <div class="col-md-8">{{ $pinjamInventaris->created_at->format('d-m-Y H:i') }}</div>
                        </div>
                        
                        @if($pinjamInventaris->created_at != $pinjamInventaris->updated_at)
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Terakhir Diupdate</div>
                            <div class="col-md-8">{{ $pinjamInventaris->updated_at->format('d-m-Y H:i') }}</div>
                        </div>
                        @endif
                    </div>
                    
                    <div class="d-flex justify-content-between mt-4">
                        @if($pinjamInventaris->status == 0 || $pinjamInventaris->status == 2)
                            <a href="{{ route('mahasiswa.peminjaman.pinjam-inventaris.edit', $pinjamInventaris->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit me-1"></i> Edit Peminjaman
                            </a>
                            
                            <form action="{{ route('pinjam-inventaris.destroy', $pinjamInventaris->id) }}" method="POST" 
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus peminjaman ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash-alt me-1"></i> Hapus
                                </button>
                            </form>
                        @else
                            <div></div> <!-- Empty div for flex spacing -->
                            
                            @if($pinjamInventaris->status == 1)
                                <button type="button" class="btn btn-success" disabled>
                                    <i class="fas fa-check-circle me-1"></i> Peminjaman Disetujui
                                </button>
                            @elseif($pinjamInventaris->status == 3)
                                <button type="button" class="btn btn-info text-white" disabled>
                                    <i class="fas fa-check-double me-1"></i> Peminjaman Selesai
                                </button>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection