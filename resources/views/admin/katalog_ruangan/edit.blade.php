@extends('admin.layouts.admin')

@section('title', 'Edit Katalog Ruangan')

@section('content')
<div class="card">
    <div class="card-header bg-warning text-white">
        <h5 class="mb-0">Edit Katalog Ruangan</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.katalog_ruangan.update', $ruangan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nama_ruangan" class="form-label">Nama Ruangan</label>
                <input type="text" class="form-control" name="nama_ruangan" value="{{ $ruangan->nama_ruangan }}" required>
            </div>

            <div class="mb-3">
                <label for="kapasitas" class="form-label">Kapasitas</label>
                <input type="number" class="form-control" name="kapasitas" value="{{ $ruangan->kapasitas }}" required>
            </div>

            <div class="mb-3">
                <label for="fasilitas" class="form-label">Fasilitas</label>
                <textarea name="fasilitas" class="form-control" rows="3" required>{{ $ruangan->fasilitas }}</textarea>
            </div>

            <div class="mb-3">
                <label for="lokasi" class="form-label">Lokasi</label>
                <input type="text" class="form-control" name="lokasi" value="{{ $ruangan->lokasi }}" required>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="Tersedia" {{ $ruangan->status == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="Tidak Tersedia" {{ $ruangan->status == 'Tidak Tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar Ruangan</label><br>
                @if ($ruangan->gambar)
                    <img src="{{ asset('storage/katalog_ruangan/' . $ruangan->gambar) }}" alt="{{ $ruangan->nama_ruangan }}">
                @endif
                <input type="file" class="form-control" name="gambar">
                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar</small>
            </div>

            <button type="submit" class="btn btn-warning">Perbarui</button>
            <a href="{{ route('admin.katalog_ruangan.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
