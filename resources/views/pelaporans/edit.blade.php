<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pelaporan</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">Edit Pelaporan Peminjaman Ruangan</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pelaporans.update', $pelaporan->id_lapor_ruangan) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="id_logistik" class="block text-sm font-medium">Penerima Kunci (Logistik)</label>
                <select name="id_logistik" id="id_logistik" class="w-full border p-2 rounded @error('id_logistik') border-red-500 @enderror" required>
                    <option value="">Pilih Penerima</option>
                    @foreach ($logistiks as $logistik)
                        <option value="{{ $logistik->id }}" {{ old('id_logistik', $pelaporan->id_logistik) == $logistik->id ? 'selected' : '' }}>
                            {{ $logistik->nama }} ({{ $logistik->id }})
                        </option>
                    @endforeach
                </select>
                @error('id_logistik')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="datetime" class="block text-sm font-medium">Tanggal Penyerahan</label>
                <input type="date" name="datetime" id="datetime" class="w-full border p-2 rounded @error('datetime') border-red-500 @enderror" value="{{ old('datetime', $pelaporan->datetime) }}" required>
                @error('datetime')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="oleh" class="block text-sm font-medium">Pengembali Kunci</label>
                <input type="text" name="oleh" id="oleh" class="w-full border p-2 rounded @error('oleh') border-red-500 @enderror" value="{{ old('oleh', $pelaporan->oleh) }}" required>
                @error('oleh')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="kepada" class="block text-sm font-medium">Nama Penerima Kunci</label>
                <input type="text" name="kepada" id="kepada" class="w-full border p-2 rounded @error('kepada') border-red-500 @enderror" value="{{ old('kepada', $pelaporan->kepada) }}" required>
                @error('kepada')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="deskripsi" class="block text-sm font-medium">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="w-full border p-2 rounded @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi', $pelaporan->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="foto_awal" class="block text-sm font-medium">Foto Awal</label>
                @if ($pelaporan->foto_awal)
                    <img src="{{ Storage::url($pelaporan->foto_awal) }}" alt="Foto Awal" class="w-48 h-48 object-cover mb-2">
                @endif
                <input type="file" name="foto_awal" id="foto_awal" class="w-full border p-2 rounded @error('foto_awal') border-red-500 @enderror" accept="image/*">
                @error('foto_awal')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="foto_akhir" class="block text-sm font-medium">Foto Akhir</label>
                @if ($pelaporan->foto_akhir)
                    <img src="{{ Storage::url($pelaporan->foto_akhir) }}" alt="Foto Akhir" class="w-48 h-48 object-cover mb-2">
                @endif
                <input type="file" name="foto_akhir" id="foto_akhir" class="w-full borderalfour p-2 rounded @error('foto_akhir') border-red-500 @enderror" accept="image/*">
                @error('foto_akhir')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
            <a href="{{ route('pelaporans.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">Batal</a>
        </form>
    </div>
</body>
</html>