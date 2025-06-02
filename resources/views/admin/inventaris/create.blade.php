
@extends('admin.layouts.admin')

@section('title', 'Tambah Inventaris')

@section('content')
<div class="card">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">Tambah Inventaris</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.inventaris.store') }}" enctype="multipart/form-data" method="POST">
            @csrf

            <div class="mb-3">
                <label for="gambar_inventaris" class="form-label">Gambar</label>
                <input type="file" class="form-control" name="gambar_inventaris" accept="image/*" required>
                @error('gambar_inventaris')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="nama_inventaris" class="form-label">Nama Inventaris</label>
                <input type="text" class="form-control" name="nama_inventaris" value="{{ old('nama_inventaris') }}" required>
                @error('nama_inventaris')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="kategori_id" class="form-label">Kategori</label>
                <select name="kategori_id" class="form-select" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
                @error('kategori_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3" required>{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="jumlah" class="form-label">Jumlah</label>
                <input type="number" class="form-control" name="jumlah" value="{{ old('jumlah') }}" required>
                @error('jumlah')
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

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('admin.inventaris.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection



