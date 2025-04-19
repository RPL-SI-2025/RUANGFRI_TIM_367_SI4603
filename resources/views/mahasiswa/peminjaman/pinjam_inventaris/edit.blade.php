@extends('mahasiswa.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Peminjaman Inventaris</h5>
                    <a href="{{ route('mahasiswa.peminjaman.pinjam-inventaris.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('pinjam-inventaris.update', $pinjamInventaris->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label">Inventaris</label>
                            <input type="text" class="form-control" value="{{ $pinjamInventaris->inventaris->nama_inventaris }}" readonly>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_pengajuan" class="form-label">Tanggal Pengajuan</label>
                                <input type="date" class="form-control @error('tanggal_pengajuan') is-invalid @enderror" 
                                    id="tanggal_pengajuan" name="tanggal_pengajuan" 
                                    value="{{ old('tanggal_pengajuan', date('Y-m-d', strtotime($pinjamInventaris->tanggal_pengajuan))) }}" required>
                                @error('tanggal_pengajuan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                                    id="tanggal_selesai" name="tanggal_selesai" 
                                    value="{{ old('tanggal_selesai', date('Y-m-d', strtotime($pinjamInventaris->tanggal_selesai))) }}" required>
                                @error('tanggal_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                                <input type="time" class="form-control @error('waktu_mulai') is-invalid @enderror" 
                                    id="waktu_mulai" name="waktu_mulai" 
                                    value="{{ old('waktu_mulai', date('H:i', strtotime($pinjamInventaris->waktu_mulai))) }}" required>
                                @error('waktu_mulai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
                                <input type="time" class="form-control @error('waktu_selesai') is-invalid @enderror" 
                                    id="waktu_selesai" name="waktu_selesai" 
                                    value="{{ old('waktu_selesai', date('H:i', strtotime($pinjamInventaris->waktu_selesai))) }}" required>
                                @error('waktu_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="file_scan" class="form-label">File Scan (Opsional)</label>
                            @if($pinjamInventaris->file_scan)
                                <div class="mb-2">
                                    <span class="text-muted">File saat ini:</span> {{ $pinjamInventaris->file_scan }}
                                </div>
                            @endif
                            <input type="file" class="form-control @error('file_scan') is-invalid @enderror" 
                                id="file_scan" name="file_scan">
                            <small class="text-muted">Format: PDF, JPG, JPEG, PNG (maks 2MB)</small>
                            @error('file_scan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection