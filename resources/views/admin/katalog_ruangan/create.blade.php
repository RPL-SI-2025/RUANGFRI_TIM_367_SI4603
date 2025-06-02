@extends('admin.layouts.admin')

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
                <label class="form-label">Fasilitas</label>
                <div id="fasilitas-wrapper">
                    <div class="input-group mb-2">
                        <input type="text" name="fasilitas[]" class="form-control" placeholder="Fasilitas" required>
                        <button type="button" class="btn btn-success add-fasilitas">+</button>
                    </div>
                </div>
                @error('fasilitas')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="lokasi" class="form-label">Lokasi</label>
                <select name="lokasi" class="form-select" required>
                    <option value="">-- Pilih Lokasi --</option>
                    <option value="Gedung B (Cacuk)" {{ old('lokasi') == 'Gedung B (Cacuk)' ? 'selected' : '' }}>Gedung B (Cacuk)</option>
                    <option value="Telkom University Landmark Tower (TULT)" {{ old('lokasi') == 'Telkom University Landmark Tower (TULT)' ? 'selected' : '' }}>Telkom University Landmark Tower (TULT)</option>
                    <option value="Gedung Kuliah Umum (GKU)" {{ old('lokasi') == 'Gedung Kuliah Umum (GKU)' ? 'selected' : '' }}>Gedung Kuliah Umum (GKU)</option>
                </select>
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

        @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const wrapper = document.getElementById('fasilitas-wrapper');

                wrapper.addEventListener('click', function (e) {
                    if (e.target.classList.contains('add-fasilitas')) {
                        e.preventDefault();

                        const newInput = document.createElement('div');
                        newInput.classList.add('input-group', 'mb-2');

                        newInput.innerHTML = `
                            <input type="text" name="fasilitas[]" class="form-control" placeholder="Fasilitas" required>
                            <button type="button" class="btn btn-danger remove-fasilitas">−</button>
                        `;

                        wrapper.appendChild(newInput);
                    }

                    if (e.target.classList.contains('remove-fasilitas')) {
                        e.preventDefault();
                        e.target.closest('.input-group').remove();
                    }
                });
            });
        </script>
        @endpush

    </div>
</div>
@endsection
