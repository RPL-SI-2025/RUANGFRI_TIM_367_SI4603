<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Ruang</title>
    <style>
        body {
        font-family: 'Segoe UI', Tahoma, sans-serif;
        margin: 40px;
        font-size: 16px; /* Diperbesar dari 14px */
        color: #333;
        background-color: #f9f9f9;
    }


        .header {
            text-align: center;
            border-bottom: 3px solid #444;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }

        .header h2 {
            font-size: 22px;
            margin: 0;
            text-transform: uppercase;
            color: #222;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        table th,
        table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #f1f1f1;
            font-weight: bold;
            color: #555;
            width: 20%;
        }

        .image-section {
            margin-top: 20px;
        }

        .image-section .label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            font-size: 15px;
            color: #444;
        }

        .image-section img {
            border: 1px solid #ccc;
            padding: 5px;
            width: 350px;
            height: auto;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Peminjaman Ruangan</h2>
    </div>

    <table>
        <tr>
            <th>Tanggal</th>
            <td>{{ \Carbon\Carbon::parse($pelaporan->datetime)->format('d-m-Y H:i') }}</td>
        </tr>
        <tr>
            <th>Oleh</th>
            <td>{{ $pelaporan->oleh }}</td>
        </tr>
        <tr>
            <th>Kepada</th>
            <td>{{ $pelaporan->kepada }}</td>
        </tr>
        <tr>
            <th>Deskripsi</th>
            <td>{{ $pelaporan->deskripsi }}</td>
        </tr>
    </table>

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
</body>
</html>
