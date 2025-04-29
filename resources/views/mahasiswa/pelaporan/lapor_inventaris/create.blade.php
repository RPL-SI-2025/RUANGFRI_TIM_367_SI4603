@extends('mahasiswa.layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="text-primary mb-0 fw-bold">
                            <i class="fas fa-clipboard-check me-2"></i>Pelaporan Pengembalian Inventaris
                        </h4>
                        <a href="{{ route('mahasiswa.peminjaman.pinjam-inventaris.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body px-4">
                    @if (session('error'))
                        <div class="alert alert-danger border-0 shadow-sm">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        </div>
                    @endif

                    @if(isset($peminjaman) && isset($relatedItems))
                        <div class="mb-4">
                            <h5 class="text-secondary fw-bold mb-3">
                                <i class="fas fa-list-alt me-2"></i>Daftar Item yang Dikembalikan
                            </h5>
                            <div class="table-responsive">
                                <table class="table table-hover border">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="py-3">No</th>
                                            <th class="py-3">Nama Inventaris</th>
                                            <th class="py-3">Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($relatedItems as $item)
                                            <tr class="align-middle">
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="fw-medium">{{ $item->inventaris->nama_inventaris ?? 'Tidak ditemukan' }}</td>
                                                <td>{{ $item->jumlah_pinjam }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <form action="{{ route('mahasiswa.pelaporan.lapor_inventaris.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id_peminjaman" value="{{ $peminjaman->id }}">
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="datetime" class="form-label fw-medium">Tanggal Laporan</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-calendar text-primary"></i>
                                            </span>
                                            <input type="date" class="form-control @error('datetime') is-invalid @enderror border-start-0" 
                                                id="datetime" name="datetime" value="{{ old('datetime', date('Y-m-d')) }}" required>
                                        </div>
                                        @error('datetime')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="id_logistik" class="form-label fw-medium">Admin Logistik</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-user text-primary"></i>
                                            </span>
                                            <select class="form-select @error('id_logistik') is-invalid @enderror border-start-0" 
                                                id="id_logistik" name="id_logistik" required>
                                                <option value="">Pilih Admin Logistik</option>
                                                @foreach($adminLogistik as $admin)
                                                    <option value="{{ $admin->id }}">{{ $admin->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('id_logistik')
                                            <small class="text-danger">{{ isset($message) ? $message : 'Terjadi kesalahan pada admin logistik' }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="foto_awal" class="form-label fw-medium">Foto Kondisi Awal</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-camera text-primary"></i>
                                            </span>
                                            <input type="file" class="form-control @error('foto_awal') is-invalid @enderror border-start-0" 
                                                id="foto_awal" name="foto_awal" accept="image/*" required>
                                        </div>
                                        <small class="form-text text-muted">Upload foto kondisi inventaris saat dipinjam</small>
                                        @error('foto_awal')
                                            <small class="text-danger">{{ isset($message) ? $message : 'Terjadi kesalahan pada file foto kondisi awal' }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="foto_akhir" class="form-label fw-medium">Foto Kondisi Akhir</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-camera text-primary"></i>
                                            </span>
                                            <input type="file" class="form-control @error('foto_akhir') is-invalid @enderror border-start-0" 
                                                id="foto_akhir" name="foto_akhir" accept="image/*" required>
                                        </div>
                                        <small class="form-text text-muted">Upload foto kondisi inventaris saat dikembalikan</small>
                                        @error('foto_akhir')
                                            <small class="text-danger">{{ isset($message) ? $message : 'Terjadi kesalahan pada file foto kondisi akhir' }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label for="deskripsi" class="form-label fw-medium">Deskripsi</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-align-left text-primary"></i>
                                    </span>
                                    <textarea class="form-control @error('deskripsi') is-invalid @enderror border-start-0" 
                                        id="deskripsi" name="deskripsi" rows="4" required>{{ old('deskripsi') }}</textarea>
                                </div>
                                <small class="form-text text-muted">Berikan keterangan kondisi inventaris saat dikembalikan</small>
                                @error('deskripsi')
                                    <small class="text-danger">{{ isset($message) ? $message : 'Terjadi kesalahan pada deskripsi' }}</small>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                                <button type="submit" class="btn btn-success rounded-pill px-5">
                                    <i class="fas fa-paper-plane me-2"></i> Kirim Laporan
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Tidak ada data peminjaman yang dipilih atau peminjaman tidak valid. 
                            <a href="{{ route('mahasiswa.peminjaman.pinjam-inventaris.index') }}" class="alert-link">Kembali ke daftar peminjaman</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.input-group-text {
    border-radius: 0.375rem 0 0 0.375rem;
}
.form-control, .form-select {
    border-radius: 0 0.375rem 0.375rem 0;
}
</style>
@endsection