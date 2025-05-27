
<!-- filepath: resources/views/admin/lapor_inventaris/pdf.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Laporan Inventaris (Admin)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 30px;
            color: #333;
        }
        h1 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 20px;
            color: #2c3e50;
            text-transform: uppercase;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            text-align: left;
            padding: 10px;
            border: 1px solid #ddd;
        }
        table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .section-title {
            font-weight: bold;
            font-size: 20px;
            margin-bottom: 15px;
            color: #495057;
            border-bottom: 2px solid #ddd;
            padding-bottom: 5px;
        }
        .image-container {
            text-align: center;
            margin-top: 15px;
        }
        .image-container img {
            max-width: 300px;
            height: auto;
            border: 1px solid #ddd;
            padding: 5px;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .no-image {
            text-align: center;
            font-style: italic;
            color: #888;
        }
    </style>
</head>
<body>
    <h1>Laporan Inventaris (Admin)</h1>

    <table>
        <tr>
            <th>ID Laporan</th>
            <td>{{ $laporan->id_lapor_inventaris }}</td>
        </tr>
        <tr>
            <th>ID Peminjaman</th>
            <td>{{ $laporan->peminjaman->id ?? '-' }}</td>
        </tr>
        <tr>
            <th>Tanggal Laporan</th>
            <td>{{ \Carbon\Carbon::parse($laporan->datetime)->format('d F Y') }}</td>
        </tr>
        <tr>
            <th>Dibuat Oleh</th>
            <td>{{ $laporan->mahasiswa->nama_mahasiswa ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Ditujukan Kepada</th>
            <td>{{ $laporan->kepada }}</td>
        </tr>
        <tr>
            <th>Admin Logistik</th>
            <td>{{ $laporan->logistik->nama ?? 'N/A' }}</td>
        </tr>
    </table>

    <div class="section">
        <p class="section-title">Foto Kondisi Awal</p>
        <div class="image-container">
            @if($laporan->foto_awal)
                <img src="{{ public_path('storage/' . $laporan->foto_awal) }}" alt="Foto Kondisi Awal">
            @else
                <p class="no-image">Tidak ada foto.</p>
            @endif
        </div>
    </div>

    <div class="section">
        <p class="section-title">Foto Kondisi Akhir</p>
        <div class="image-container">
            @if($laporan->foto_akhir)
                <img src="{{ public_path('storage/' . $laporan->foto_akhir) }}" alt="Foto Kondisi Akhir">
            @else
                <p class="no-image">Tidak ada foto.</p>
            @endif
        </div>
    </div>
</body>
</html>