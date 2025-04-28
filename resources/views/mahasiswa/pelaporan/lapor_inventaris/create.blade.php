@extends('mahasiswa.layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="text-primary mb-4">Buat Laporan Peminjaman Inventaris</h1>

    <!-- Identitas Peminjam -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Identitas Peminjam</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Nama:</strong> {{ Auth::guard('mahasiswa')->user()->nama_mahasiswa }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>ID Mahasiswa:</strong> {{ Auth::guard('mahasiswa')->user()->id }}</p>
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
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('mahasiswa.pelaporan.lapor_inventaris.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="id_mahasiswa" value="{{ Auth::guard('mahasiswa')->user()->id }}">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="oleh" class="form-label">Dikembalikan Oleh</label>
                        <input type="text" id="oleh" name="oleh" class="form-control @error('oleh') is-invalid @enderror" value="{{ old('oleh') }}" required>
                        @error('oleh')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="id_logistik" class="form-label">Dikembalikan Kepada</label>
                        <select id="id_logistik" name="id_logistik" class="form-select @error('id_logistik') is-invalid @enderror" required>
                            <option value="">-- Pilih Admin Logistik --</option>
                            @foreach($logistiks as $logistik)
                                <option value="{{ $logistik->id }}">{{ $logistik->nama }}</option>
                            @endforeach
                        </select>
                        @error('id_logistik')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- <div class="mb-3">
                    <label for="kepada" class="form-label">Nama Admin Logistik</label>
                    <select id="kepada" name="kepada" class="form-select @error('kepada') is-invalid @enderror" required>
                        <option value="">-- Pilih Nama Admin Logistik --</option>
                        @foreach($logistiks as $logistik)
                            <option value="{{ $logistik->nama }}">{{ $logistik->nama }}</option>
                        @endforeach
                    </select>
                    @error('kepada')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div> -->

                <div class="mb-3">
                    <label for="datetime" class="form-label">Tanggal Pengembalian</label>
                    <input type="datetime-local" id="datetime" name="datetime" class="form-control @error('datetime') is-invalid @enderror" value="{{ old('datetime') }}" required>
                    @error('datetime')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="foto_awal" class="form-label">Foto Awal Peminjaman (PNG)</label>
                        <input type="file" id="foto_awal" name="foto_awal" accept="image/png" class="form-control @error('foto_awal') is-invalid @enderror" required>
                        @error('foto_awal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="foto_akhir" class="form-label">Foto Akhir Peminjaman (PNG)</label>
                        <input type="file" id="foto_akhir" name="foto_akhir" accept="image/png" class="form-control @error('foto_akhir') is-invalid @enderror" required>
                        @error('foto_akhir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="5" class="form-control @error('deskripsi') is-invalid @enderror" required>{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary shadow-sm">
                        <i class="fas fa-save me-2"></i> Simpan Laporan
                    </button>
                    <a href="{{ route('mahasiswa.pelaporan.lapor_inventaris.index') }}" class="btn btn-secondary shadow-sm">
                        <i class="fas fa-arrow-left me-2"></i> Batal
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
