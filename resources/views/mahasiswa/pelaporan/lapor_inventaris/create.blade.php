@extends('mahasiswa.layouts.mahasiswa')

@section('title', 'Lapor Inventaris')

@section('content')
        <form method="POST" action="{{ route('mahasiswa.lapor_inventaris.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label>ID Laporan Inventaris</label>
                <input type="text" name="id_lapor_inventaris" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <label>Oleh</label>
                <input type="text" name="oleh" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Kepada</label>
                <input type="text" name="kepada" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Foto Awal</label>
                <input type="file" name="foto_awal" class="form-control" accept="image/*" required>
            </div>

            <div class="mb-3">
                <label>Foto Akhir</label>
                <input type="file" name="foto_akhir" class="form-control" accept="image/*" required>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('mahasiswa.lapor_inventaris.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
