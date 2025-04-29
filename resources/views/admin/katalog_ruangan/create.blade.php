@extends('admin.layouts.app')

@section('title', 'Tambah Ruangan')

@section('content')
<div class="card">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">Tambah Ruangan</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.katalog_ruangan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="nama_ruangan" class="form-label">Nama Ruangan</label>
                <input type="text" class="form-control" name="nama_ruangan" value="{{ old('nama_ruangan') }}" required>
                @error('nama_ruangan')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="kapasitas" class="form-label">Kapasitas</label>
                <input type="number" class="form-control" name="kapasitas" value="{{ old('kapasitas') }}" required>
                @error('kapasitas')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="fasilitas" class="form-label">Fasilitas</label>
                <textarea name="fasilitas" class="form-control" rows="3" required>{{ old('fasilitas') }}</textarea>
                @error('fasilitas')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="lokasi" class="form-label">Lokasi</label>
                <input type="text" class="form-control" name="lokasi" value="{{ old('lokasi') }}" required>
                @error('lokasi')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="Tersedia" {{ old('status') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="Tidak Tersedia" {{ old('status') == 'Tidak Tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                </select>
                @error('status')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar Ruangan (opsional)</label>
                <input type="file" class="form-control" name="gambar" accept="image/*">
                @error('gambar')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('admin.katalog_ruangan.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
