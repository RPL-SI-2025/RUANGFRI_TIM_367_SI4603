@extends('mahasiswa.layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="text-primary mb-4">Edit Laporan Peminjaman Ruangan</h1>

    <!-- Identitas Peminjam -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Identitas Peminjam</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Nama:</strong> {{ Auth::user()->name }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>ID Mahasiswa:</strong> {{ Auth::user()->id }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Pelaporan -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Form Pelaporan</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('pelaporans.update', $pelaporan->id_lapor_ruangan) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="oleh" class="form-label">Dikembalikan Oleh</label>
                        <input type="text" class="form-control @error('oleh') is-invalid @enderror" id="oleh" name="oleh" value="{{ old('oleh', $pelaporan->oleh) }}" required>
                        @error('oleh')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="id_logistik" class="form-label">Dikembalikan Kepada</label>
                        <select class="form-control @error('id_logistik') is-invalid @enderror" id="id_logistik" name="id_logistik" required>
                            <option value="">Pilih Admin Logistik</option>
                            @foreach($logistiks as $logistik)
                                <option value="{{ $logistik->id }}" {{ old('id_logistik', $pelaporan->id_logistik) == $logistik->id ? 'selected' : '' }}>{{ $logistik->name }}</option>
                            @endforeach
                        </select>
                        @error('id_logistik')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="datetime" class="form-label">Tanggal Pengembalian</label>
                    <input type="datetime-local" class="form-control @error('datetime') is-invalid @enderror" id="datetime" name="datetime" value="{{ old('datetime', $pelaporan->datetime->format('Y-m-d\TH:i')) }}" required>
                    @error('datetime')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="foto_awal" class="form-label">Foto Awal Peminjaman (PNG)</label>
                        <input type="file" class="form-control @error('foto_awal') is-invalid @enderror" id="foto_awal" name="foto_awal" accept="image/png">
                        @if($pelaporan->foto_awal)
                            <p class="mt-2">Foto saat ini: <a href="{{ Storage::url($pelaporan->foto_awal) }}" target="_blank" class="text-primary">Lihat</a></p>
                        @endif
                        @error('foto_awal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="foto_akhir" class="form-label">Foto Akhir Peminjaman (PNG)</label>
                        <input type="file" class="form-control @error('foto_akhir') is-invalid @enderror" id="foto_akhir" name="foto_akhir" accept="image/png">
                        @if($pelaporan->foto_akhir)
                            <p class="mt-2">Foto saat ini: <a href="{{ Storage::url($pelaporan->foto_akhir) }}" target="_blank" class="text-primary">Lihat</a></p>
                        @endif
                        @error('foto_akhir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="5">{{ old('deskripsi', $pelaporan->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary shadow-sm">
                        <i class="fas fa-save me-2"></i>Update Laporan
                    </button>
                    <a href="{{ route('pelaporans.index') }}" class="btn btn-secondary shadow-sm">
                        <i class="fas fa-arrow-left me-2"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    .card-header {
        border-bottom: none;
    }
    .form-label {
        font-weight: 500;
    }
    .btn i {
        font-size: 1rem;
    }
</style>
@endsection