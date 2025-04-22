<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pelaporan</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">Detail Pelaporan Peminjaman Ruangan</h1>

        <div class="bg-white p-6 rounded shadow">
            <p><strong>ID Laporan:</strong> {{ $pelaporan->id_lapor_ruangan }}</p>
            <p><strong>Tanggal Penyerahan:</strong> {{ $pelaporan->datetime }}</p>
            <p><strong>Pengembali Kunci:</strong> {{ $pelaporan->oleh }}</p>
            <p><strong>Penerima Kunci:</strong> {{ $pelaporan->kepada }}</p>
            <p><strong>Deskripsi:</strong> {{ $pelaporan->deskripsi ?? '-' }}</p>
            <p><strong>Foto Awal:</strong>
                @if ($pelaporan->foto_awal)
                    <img src="{{ Storage::url($pelaporan->foto_awal) }}" alt="Foto Awal" class="w-48 h-48 object-cover mt-2">
                @else
                    Tidak ada
                @endif
            </p>
            <p><strong>Foto Akhir:</strong>
                @if ($pelaporan->foto_akhir)
                    <img src="{{ Storage::url($pelaporan->foto_akhir) }}" alt="Foto Akhir" class="w-48 h-48 object-cover mt-2">
                @else
                    Tidak ada
                @endif
            </p>

            <a href="{{ route('pelaporans.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded mt-4 inline-block">Kembali</a>
        </div>
    </div>
</body>
</html>