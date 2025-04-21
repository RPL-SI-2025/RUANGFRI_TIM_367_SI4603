@extends('admin.layouts.admin')

@section('title', 'lapor Inventaris')

@section('content')
<form method="POST" action="{{ route('laporinventaris.update', $lapor->id_lapor_inventaris) }}" enctype="multipart/form-data">
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
        <label>Foto Awal (Kosongkan jika tidak diganti)</label><br>
        @if($lapor->foto_awal)
            <img src="{{ asset('storage/' . $lapor->foto_awal) }}" width="100"><br>
        @endif
        <input type="file" name="foto_awal" class="form-control mt-2" accept="image/*">
    </div>

    <div class="mb-3">
        <label>Foto Akhir (Kosongkan jika tidak diganti)</label><br>
        @if($lapor->foto_akhir)
            <img src="{{ asset('storage/' . $lapor->foto_akhir) }}" width="100"><br>
        @endif
        <input type="file" name="foto_akhir" class="form-control mt-2" accept="image/*">
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('laporinventaris.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection

