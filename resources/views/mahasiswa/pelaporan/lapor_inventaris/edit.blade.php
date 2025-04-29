@extends('mahasiswa.layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="text-primary mb-0 fw-bold">
                            <i class="fas fa-edit me-2"></i>Edit Laporan Inventaris
                        </h4>
                        <a href="{{ route('mahasiswa.pelaporan.lapor_inventaris.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
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

                    <form action="{{ route('mahasiswa.pelaporan.lapor_inventaris.update', $laporan->id_lapor_inventaris) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="datetime" class="form-label fw-medium">Tanggal Laporan</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-calendar text-primary"></i>
                                        </span>
                                        <input type="date" class="form-control @error('datetime') is-invalid @enderror border-start-0" 
                                            id="datetime" name="datetime" value="{{ old('datetime', $laporan->datetime ? date('Y-m-d', strtotime($laporan->datetime)) : '') }}" readonly>
                                    </div>
                                    <small class="text-muted">Tanggal laporan tidak dapat diubah</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="id_logistik" class="form-label fw-medium">Admin Logistik</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-user text-primary"></i>
                                        </span>
                                        <input type="text" class="form-control border-start-0" 
                                            value="{{ $laporan->logistik->nama ?? 'N/A' }}" readonly>
                                        <input type="hidden" name="id_logistik" value="{{ $laporan->id_logistik }}">
                                    </div>
                                    <small class="text-muted">Admin logistik tidak dapat diubah</small>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="foto_awal" class="form-label fw-medium">Foto Kondisi Awal</label>
                                    @if($laporan->foto_awal)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $laporan->foto_awal) }}" class="img-thumbnail" width="200">
                                        </div>
                                    @endif
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-camera text-primary"></i>
                                        </span>
                                        <input type="file" class="form-control @error('foto_awal') is-invalid @enderror border-start-0" 
                                            id="foto_awal" name="foto_awal" accept="image/*">
                                    </div>
                                    <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah foto</small>
                                    @error('foto_awal')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="foto_akhir" class="form-label fw-medium">Foto Kondisi Akhir</label>
                                    @if($laporan->foto_akhir)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $laporan->foto_akhir) }}" class="img-thumbnail" width="200">
                                        </div>
                                    @endif
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-camera text-primary"></i>
                                        </span>
                                        <input type="file" class="form-control @error('foto_akhir') is-invalid @enderror border-start-0" 
                                            id="foto_akhir" name="foto_akhir" accept="image/*">
                                    </div>
                                    <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah foto</small>
                                    @error('foto_akhir')
                                        <small class="text-danger">{{ $message }}</small>
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
                                    id="deskripsi" name="deskripsi" rows="4" required>{{ old('deskripsi', $laporan->deskripsi) }}</textarea>
                            </div>
                            <small class="form-text text-muted">Berikan keterangan kondisi inventaris saat dikembalikan</small>
                            @error('deskripsi')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                            <button type="submit" class="btn btn-success rounded-pill px-5">
                                <i class="fas fa-save me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
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