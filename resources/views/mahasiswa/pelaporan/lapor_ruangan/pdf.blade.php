<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Ruang</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            margin: 40px;
            font-size: 14px;
            color: #333;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #444;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }

        .header h2 {
            font-size: 20px;
            margin: 0;
            text-transform: uppercase;
        }

        .content {
            width: 100%;
        }

        .row {
            display: flex;
            margin-bottom: 10px;
        }

        .label {
            width: 100px;
            font-weight: bold;
        }

        .value {
            flex: 1;
        }

        .image-section {
            margin-top: 20px;
        }

        .image-section .label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .image-section img {
            border: 1px solid #ccc;
            padding: 4px;
            width: 350px;
            height: auto;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Peminjaman Ruangan</h2>
    </div>

    <div class="content">
        <div class="row"><div class="label">Tanggal:</div><div class="value">{{ \Carbon\Carbon::parse($pelaporan->datetime)->format('d-m-Y H:i') }}</div></div>
        <div class="row"><div class="label">Oleh:</div><div class="value">{{ $pelaporan->oleh }}</div></div>
        <div class="row"><div class="label">Kepada:</div><div class="value">{{ $pelaporan->kepada }}</div></div>
        <div class="row"><div class="label">Deskripsi:</div><div class="value">{{ $pelaporan->deskripsi }}</div></div>

        @if($pelaporan->foto_awal)
            <div class="image-section">
                <span class="label">Foto Awal Peminjaman:</span>
                <img src="{{ public_path('storage/' . $pelaporan->foto_awal) }}" alt="Foto Awal">
            </div>
        @endif

        @if($pelaporan->foto_akhir)
            <div class="image-section">
                <span class="label">Foto Setelah Peminjaman:</span>
                <img src="{{ public_path('storage/' . $pelaporan->foto_akhir) }}" alt="Foto Akhir">
            </div>
        @endif
    </div>
</body>
</html>
