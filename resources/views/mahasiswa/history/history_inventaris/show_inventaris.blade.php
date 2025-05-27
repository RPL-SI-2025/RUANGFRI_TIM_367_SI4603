
@extends('mahasiswa.layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>
            <i class="fas fa-info-circle me-2"></i>Detail Riwayat Peminjaman Inventaris
        </h4>
        <a href="{{ route('mahasiswa.history.mahasiswa.history.history_inventaris.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <!-- Informasi Utama -->
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="border rounded p-3">
                        <h6 class="border-bottom pb-2 mb-3">Informasi Peminjaman</h6>
                        <table class="table table-borderless m-0">
                            <tr>
                                <td width="140"><strong>ID Pelaporan</strong></td>
                                <td>: {{ $laporan->id_lapor_inventaris }}</td>
                            </tr>
                            <tr>
                                <td><strong>ID Peminjaman</strong></td>
                                <td>: {{ $laporan->peminjaman->id ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal</strong></td>
                                <td>: {{ \Carbon\Carbon::parse($laporan->datetime)->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Status</strong></td>
                                <td>: <span class="badge bg-success">Selesai</span></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="border rounded p-3">
                        <h6 class="border-bottom pb-2 mb-3">Informasi Penanggung Jawab</h6>
                        <table class="table table-borderless m-0">
                            <tr>
                                <td><strong>Admin Logistik</strong></td>
                                <td>: {{ $laporan->logistik->nama ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                    <!-- Deskripsi dan Keterangan -->
                     @if($laporan->deskripsi || $laporan->keterangan)
                    <div class="row  mt-4">
                        @if($laporan->deskripsi)
                        <div class="col-md-6">
                            <div class="border rounded p-3">
                            <h6 class="border-bottom pb-2 mb-3">Deskripsi Pelaporan</h6>
                            <p class="mb-0">{{ $laporan->deskripsi }}</p>
                            </div>
                        </div>
                        @endif
                </div>
            </div>
                       
            <!-- Daftar Inventaris -->
            <div class="mt-4">
                <div class="border rounded p-3">
                    <h6 class="border-bottom pb-2 mb-3">Daftar Inventaris</h6>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th width="60">No</th>
                                    <th>Nama Inventaris</th>
                                    <th width="100" class="text-center">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                               @php 
                                $totalItems = 0; 
                                @endphp
                                @forelse($relatedItems as $index => $item)
                                    @php 
                                        $totalItems += $item->jumlah_pinjam ?? 0; 
                                    @endphp
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->inventaris->nama_inventaris ?? '-' }}</td>
                                        <td class="text-center">{{ $item->jumlah_pinjam ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Tidak ada data inventaris</td>
                                    </tr>
                                @endforelse
                                @if(count($relatedItems) > 0)
                                    <tr class="table-light fw-bold">
                                        <td colspan="2" class="text-end">Total Item:</td>
                                        <td class="text-center">{{ $totalItems }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- File dan Foto -->
            <div class="row g-4 mt-2">
                <div class="col-md-4">
                    <div class="border rounded p-3 h-100">
                        <h6 class="border-bottom pb-2 mb-3">File Scan</h6>
                        @if($laporan->peminjaman && $laporan->peminjaman->file_scan)
                            <a href="{{ asset('storage/uploads/file_scan/' . $laporan->peminjaman->file_scan) }}" 
                               class="btn btn-info w-100" target="_blank">
                                <i class="fas fa-file-pdf me-2"></i>Lihat Dokumen
                            </a>
                        @else
                            <p class="text-muted mb-0">Tidak ada file scan</p>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="border rounded p-3 h-100">
                        <h6 class="border-bottom pb-2 mb-3">Foto Awal</h6>
                        @if($laporan->foto_awal)
                            <img src="{{ asset('storage/' . $laporan->foto_awal) }}" 
                                 class="img-fluid rounded w-100" alt="Foto Awal">
                        @else
                            <p class="text-muted mb-0">Tidak ada foto</p>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="border rounded p-3 h-100">
                        <h6 class="border-bottom pb-2 mb-3">Foto Akhir</h6>
                        @if($laporan->foto_akhir)
                            <img src="{{ asset('storage/' . $laporan->foto_akhir) }}" 
                                 class="img-fluid rounded w-100" alt="Foto Akhir">
                        @else
                            <p class="text-muted mb-0">Tidak ada foto</p>
                        @endif
                    </div>
                </div>
            </div>
                @if($laporan->keterangan)
                <div class="col-md-6">
                    <div class="border rounded p-3">
                        <h6 class="border-bottom pb-2 mb-3">Keterangan Admin</h6>
                        <p class="mb-0">{{ $laporan->keterangan }}</p>
                    </div>
                </div>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>
@endsection