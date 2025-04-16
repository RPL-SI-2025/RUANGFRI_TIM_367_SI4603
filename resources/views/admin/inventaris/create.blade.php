@extends('layouts.app')

@section('title', 'Tambah Inventaris')

@section('content')
<div class="container">
    <h2 class="mb-4">Tambah Inventaris</h2>

    <form action="{{ route('inventaris.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nama_inventaris" class="form-label">Nama Inventaris</label>
            <input type="text" class="form-control" id="nama_inventaris" name="nama_inventaris" required>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" class="form-control" id="jumlah" name="jumlah" required>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status" required>
                <option value="Tersedia">Tersedia</option>
                <option value="Tidak Tersedia">Tidak Tersedia</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="id_logistik" class="form-label">Admin Logistik</label>
            <input type="number" class="form-control" id="id_logistik" name="id_logistik" required>
            {{-- Jika kamu ingin dropdown, tinggal kirim data dari controller --}}
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('inventaris.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
