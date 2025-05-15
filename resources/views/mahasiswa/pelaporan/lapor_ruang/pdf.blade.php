<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Ruang</title>
    <style>
        body { font-family: sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .content { font-size: 14px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Kerusakan / Masalah Ruang</h2>
    </div>
    <div class="content">
        <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($pelaporan->datetime)->format('d-m-Y H:i') }}</p>
        <p><strong>Oleh:</strong> {{ $pelaporan->oleh }}</p>
        <p><strong>Kepada:</strong> {{ $pelaporan->kepada }}</p>
        <p><strong>Deskripsi:</strong> {{ $pelaporan->deskripsi }}</p>

        @if($pelaporan->foto_awal)
            <p><strong>Foto Awal:</strong></p>
            <img src="{{ public_path('storage/' . $pelaporan->foto_awal) }}" width="200">
        @endif

        @if($pelaporan->foto_akhir)
            <p><strong>Foto Akhir:</strong></p>
            <img src="{{ public_path('storage/' . $pelaporan->foto_akhir) }}" width="200">
        @endif
    </div>
</body>
</html>
