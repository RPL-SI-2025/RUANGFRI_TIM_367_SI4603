@extends('admin.layouts.app')

@section('title', 'Tambah Inventaris')

@section('content')
<div class="card">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">Tambah Inventaris</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.inventaris.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="nama_inventaris" class="form-label">Nama Inventaris</label>
                <input type="text" class="form-control" name="nama_inventaris" required>
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label for="jumlah" class="form-label">Jumlah</label>
                <input type="number" class="form-control" name="jumlah" required>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="Tersedia">Tersedia</option>
                    <option value="Tidak Tersedia">Tidak Tersedia</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('admin.inventaris.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
