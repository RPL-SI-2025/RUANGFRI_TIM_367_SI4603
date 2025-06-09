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
                @error('kapasitas')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Fasilitas</label>
                    <div id="fasilitas-wrapper">
                        @php
                            $fasilitasList = explode(',', $ruangan->fasilitas); // asumsikan fasilitas dipisah koma
                        @endphp

                        @foreach ($fasilitasList as $index => $fasilitasItem)
                            <div class="input-group mb-2">
                                <input type="text" name="fasilitas[]" class="form-control" placeholder="Fasilitas" value="{{ trim($fasilitasItem) }}" required>
                                @if ($index == 0)
                                    <button type="button" class="btn btn-success add-fasilitas">+</button>
                                @else
                                    <button type="button" class="btn btn-danger remove-fasilitas">-</button>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @error('fasilitas')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="lokasi" class="form-label">Lokasi</label>
                <select name="lokasi" class="form-select" required>
                    <option value="">-- Pilih Lokasi --</option>
                    <option value="Gedung B (Cacuk)" {{ (old('lokasi', $ruangan->lokasi) == 'Gedung B (Cacuk)') ? 'selected' : '' }}>Gedung B (Cacuk)</option>
                    <option value="Telkom University Landmark Tower (TULT)" {{ (old('lokasi', $ruangan->lokasi) == 'Telkom University Landmark Tower (TULT)') ? 'selected' : '' }}>Telkom University Landmark Tower (TULT)</option>
                    <option value="Gedung Kuliah Umum (GKU)" {{ (old('lokasi', $ruangan->lokasi) == 'Gedung Kuliah Umum (GKU)') ? 'selected' : '' }}>Gedung Kuliah Umum (GKU)</option>
                </select>
                @error('lokasi')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
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
                    <img src="{{ asset('storage/katalog_ruangan/' . $ruangan->gambar) }}"
                    alt="{{ $ruangan->nama_ruangan }}"
                    style="max-width: 200px; height: auto; margin-bottom: 10px;">
                @endif
                <input type="file" class="form-control" name="gambar">
                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar</small>
            </div>

            <button type="submit" class="btn btn-warning">Perbarui</button>
            <a href="{{ route('admin.katalog_ruangan.index') }}" class="btn btn-secondary">Kembali</a>
        </form>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const fasilitasWrapper = document.getElementById('fasilitas-wrapper');

                fasilitasWrapper.addEventListener('click', function(e) {
                    if (e.target.classList.contains('add-fasilitas')) {
                        // buat input baru dengan tombol remove
                        const newInputGroup = document.createElement('div');
                        newInputGroup.classList.add('input-group', 'mb-2');
                        newInputGroup.innerHTML = `
                            <input type="text" name="fasilitas[]" class="form-control" placeholder="Fasilitas" required>
                            <button type="button" class="btn btn-danger remove-fasilitas">-</button>
                        `;
                        fasilitasWrapper.appendChild(newInputGroup);
                    }

                    if (e.target.classList.contains('remove-fasilitas')) {
                        e.target.parentElement.remove();
                    }
                });
            });
        </script>
    </div>
</div>
@endsection
