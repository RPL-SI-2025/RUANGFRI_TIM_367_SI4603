@extends('layouts.app')

@section('title', 'Edit Inventaris')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Inventaris</h2>

    <form action="{{ route('inventaris.update', $inventaris->id_inventaris) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama_inventaris" class="form-label">Nama Inventaris</label>
            <input type="text" class="form-control" id="nama_inventaris" name="nama_inventaris" value="{{ $inventaris->nama_inventaris }}" required>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required>{{ $inventaris->deskripsi }}</textarea>
        </div>

        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" class="form-control" id="jumlah" name="jumlah" value="{{ $inventaris->jumlah }}" required>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status" required>
                <option value="Tersedia" {{ $inventaris->status == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                <option value="Tidak Tersedia" {{ $inventaris->status == 'Tidak Tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="id_logistik" class="form-label">Admin Logistik</label>
            <input type="number" class="form-control" id="id_logistik" name="id_logistik" value="{{ $inventaris->id_logistik }}" required>
            {{-- Kalau mau pakai dropdown, bisa seperti di create --}}
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('inventaris.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
