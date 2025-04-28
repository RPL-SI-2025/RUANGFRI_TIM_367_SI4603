@extends('admin.layouts.admin')

@section('title', 'lapor Inventaris')

@section('content')
<div class="card">
    <div class="card-header bg-warning text-white">
        <h5 class="mb-0">Edit Lapor Inventaris</h5>
    </div>
    <div class="card-body">
        
<form method="POST" action="{{ route('admin.lapor_inventaris.update', $lapor->id_lapor_inventaris) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>ID Laporan Inventaris</label>
        <input type="text" name="id_lapor_inventaris" class="form-control" value="{{ $lapor->id_lapor_inventaris }}" readonly>
    </div>

    <div class="mb-3">
        <label>Deskripsi</label>
        <textarea name="deskripsi" class="form-control" required>{{ $lapor->deskripsi }}</textarea>
    </div>

    <div class="mb-3">
        <label>Oleh</label>
        <input type="text" name="oleh" class="form-control" value="{{ $lapor->oleh }}" required>
    </div>

    <div class="mb-3">
        <label>Kepada</label>
        <input type="text" name="kepada" class="form-control" value="{{ $lapor->kepada }}" required>
    </div>

    <div class="mb-3">
        <label>Foto Awal</label><br>
        @if($lapor->foto_awal)
            <img src="{{ asset('storage/' . $lapor->foto_awal) }}" width="100"><br>
        @endif
        <input type="file" name="foto_awal" class="form-control mt-2" accept="image/*">
    </div>

    <div class="mb-3">
        <label>Foto Akhir</label><br>
        @if($lapor->foto_akhir)
            <img src="{{ asset('storage/' . $lapor->foto_akhir) }}" width="100"><br>
        @endif
        <input type="file" name="foto_akhir" class="form-control mt-2" accept="image/*">
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('admin.lapor_inventaris.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection

