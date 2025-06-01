
@extends('mahasiswa.layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="text-primary mb-0 fw-bold">
                            <i class="fas fa-edit me-2"></i>Edit Laporan Ruangan
                        </h4>
                        <a href="{{ route('mahasiswa.pelaporan.lapor_ruangan.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
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

                    <form method="POST" action="{{ route('mahasiswa.pelaporan.lapor_ruangan.update', $laporan->id_lapor_ruangan) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="id_ruangan" class="form-label fw-medium">Ruangan</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-door-open text-primary"></i>
                                        </span>
                                        <select class="form-select border-start-0" id="id_ruangan" disabled>
                                            @foreach($ruangan as $item)
                                                <option value="{{ $item->id }}" {{ $laporan->id_ruangan == $item->id ? 'selected' : '' }}>
                                                    {{ $item->nama_ruangan }} ({{ $item->lokasi }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="id_ruangan" value="{{ $laporan->id_ruangan }}">
                                    </div>
                                    <small class="text-muted">Ruangan tidak dapat diubah setelah laporan dibuat</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group mb-3">
                                    <label for="lokasi" class="form-label fw-medium">Lokasi Ruangan <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-map-marker-alt text-primary"></i>
                                        </span>
                                        <input type="text" class="form-control border-start-0" 
                                            id="lokasi" name="lokasi" value="{{ $laporan->ruangan->lokasi ?? '' }}" disabled>
                                        <input type="hidden" name="lokasi" value="{{ $laporan->ruangan->lokasi ?? '' }}">
                                    </div>
                                    <small class="text-muted">Lokasi ruangan tidak dapat diubah</small>
                                </div>
                            </div>

                            
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="oleh" class="form-label fw-medium">Pelapor</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-user text-primary"></i>
                                        </span>
                                        <input type="text" class="form-control border-start-0" 
                                            id="oleh" value="{{ $laporan->oleh }}" disabled>
                                        <input type="hidden" name="oleh" value="{{ $laporan->oleh }}">
                                    </div>
                                    <small class="text-muted">Nama pelapor tidak dapat diubah</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="kepada" class="form-label fw-medium">Dilaporkan Kepada <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-user-tie text-primary"></i>
                                        </span>
                                        <input type="text" class="form-control @error('kepada') is-invalid @enderror border-start-0" 
                                            id="kepada" name="kepada" value="{{ old('kepada') ?? $laporan->kepada }}" required>
                                    </div>
                                    @error('kepada')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="deskripsi" class="form-label fw-medium">Deskripsi Masalah <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-comment-alt text-primary"></i>
                                </span>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror border-start-0" 
                                    id="deskripsi" name="deskripsi" rows="4" required>{{ old('deskripsi') ?? $laporan->deskripsi }}</textarea>
                            </div>
                            @error('deskripsi')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>             
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="foto_awal" class="form-label fw-medium">Foto Kondisi Awal</label>
                                    @if($laporan->foto_awal)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $laporan->foto_awal) }}" alt="Foto Kondisi Awal" class="img-thumbnail" style="max-height: 200px;">
                                        </div>
                                    @endif
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-image text-primary"></i>
                                        </span>
                                        <input type="file" class="form-control @error('foto_awal') is-invalid @enderror border-start-0" 
                                            id="foto_awal" name="foto_awal">
                                    </div>
                                    <small class="form-text text-muted mt-1">
                                        Format: JPG, JPEG, PNG. Maksimal 2MB. Biarkan kosong jika tidak ingin mengubah foto.
                                    </small>
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
                                            <img src="{{ asset('storage/' . $laporan->foto_akhir) }}" alt="Foto Kondisi Akhir" class="img-thumbnail" style="max-height: 200px;">
                                        </div>
                                    @endif
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-image text-primary"></i>
                                        </span>
                                        <input type="file" class="form-control @error('foto_akhir') is-invalid @enderror border-start-0" 
                                            id="foto_akhir" name="foto_akhir">
                                    </div>
                                    <small class="form-text text-muted mt-1">
                                        Format: JPG, JPEG, PNG. Maksimal 2MB. Biarkan kosong jika tidak ingin mengubah foto.
                                    </small>
                                    @error('foto_akhir')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-5 pt-3 border-top">
                            <a href="{{ route('mahasiswa.pelaporan.lapor_ruangan.index') }}" class="btn btn-outline-secondary rounded-pill px-4 me-2">
                                <i class="fas fa-times me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary rounded-pill px-5">
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