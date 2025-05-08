@extends('admin.layouts.admin')

@section('title', 'Edit Inventaris')

@section('content')
<div class="card">
    <div class="card-header bg-warning text-white">
        <h5 class="mb-0">Edit Inventaris</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.inventaris.update', $inventaris->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="gambar_inventaris" class="form-label">Gambar</label>
                <input type="file" class="form-control" name="gambar_inventaris" accept="image/*">
                
                @if ($inventaris->gambar_inventaris)
                    <div class="mt-2">
                        <img src="{{ asset('storage/katalog_inventaris/' . $inventaris->gambar_inventaris) }}" alt="Gambar Inventaris" width="150">
                    </div>
                @endif
            </div>

            <div class="mb-3">
                <label for="nama_inventaris" class="form-label">Nama Inventaris</label>
                <input type="text" class="form-control" name="nama_inventaris" value="{{ $inventaris->nama_inventaris }}" required>
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <input type="text" class="form-control" name="deskripsi" value="{{ $inventaris->deskripsi }}" required>
            </div>

            <div class="mb-3">
                <label for="jumlah" class="form-label">Jumlah</label>
                <input type="number" class="form-control" name="jumlah" value="{{ $inventaris->jumlah }}" required>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="Tersedia" {{ $inventaris->status == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="Tidak Tersedia" {{ $inventaris->status == 'Tidak Tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                </select>
            </div>

            <button type="submit" class="btn btn-warning">Perbarui</button>
            <a href="{{ route('admin.inventaris.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
