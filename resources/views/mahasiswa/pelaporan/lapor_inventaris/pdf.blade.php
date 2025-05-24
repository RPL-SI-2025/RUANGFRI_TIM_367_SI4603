
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Inventaris</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            line-height: 1.6; 
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .section {
            margin-bottom: 20px;
        }
        .images {
            text-align: center;
            margin: 20px 0;
        }
        .images img {
            max-width: 300px;
            margin: 10px;
        }
        .label {
            font-weight: bold;
            width: 200px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN PEMINJAMAN INVENTARIS</h2>
        <p>Fakultas Rekayasa Industri</p>
    </div>

    <div class="section">
        <table class="table">
            <tr>
                <td class="label">ID Laporan</td>
                <td>{{ $laporan->id_lapor_inventaris }}</td>
            </tr>
            <tr>
                <td class="label">ID Peminjaman</td>
                <td>{{ $laporan->peminjaman->id ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Laporan</td>
                <td>{{ \Carbon\Carbon::parse($laporan->datetime)->format('d F Y H:i') }}</td>
            </tr>
            <tr>
                <td class="label">Nama Mahasiswa</td>
                <td>{{ $laporan->mahasiswa->nama_mahasiswa ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Admin Logistik</td>
                <td>{{ $laporan->logistik->nama ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Status</td>
                <td>{{ $laporan->peminjaman->status == 3 ? 'Selesai' : 'Dalam Proses' }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h3>Deskripsi Laporan</h3>
        <p>{{ $laporan->deskripsi ?? 'Tidak ada deskripsi' }}</p>
    </div>

    @if($laporan->foto_awal )
    <div class="section">
        <h3>Dokumentasi</h3>
        <div class="images">
            @if($laporan->foto_awal)
            <div style="margin-bottom: 20px;">
                <p><strong>Foto Kondisi Awal:</strong></p>
                 <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(storage_path('app/public/' . $laporan->foto_awal))) }}" alt="Foto Awal">
            </div>
            @endif

            @if($laporan->foto_akhir)
            <div>
                <p><strong>Foto Kondisi Akhir:</strong></p>
                  <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(storage_path('app/public/' . $laporan->foto_akhir))) }}" alt="Foto Akhir">
            </div>
            @endif
        </div>
    </div>
    @endif

    <div style="position: fixed; bottom: 0; width: 100%;">
        <p style="text-align: right; font-style: italic;">
            Dicetak pada: {{ now()->format('d F Y H:i:s') }}
        </p>
    </div>
</body>
</html>