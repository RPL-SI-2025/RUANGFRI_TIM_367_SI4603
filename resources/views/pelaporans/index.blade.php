<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelaporan Peminjaman Ruangan</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">Daftar Pelaporan Peminjaman Ruangan</h1>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('pelaporans.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Tambah Laporan</a>

        <table class="w-full bg-white shadow rounded">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-3 text-left">ID</th>
                    <th class="p-3 text-left">Tanggal</th>
                    <th class="p-3 text-left">Pengembali</th>
                    <th class="p-3 text-left">Penerima</th>
                    <th class="p-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pelaporans as $pelaporan)
                    <tr>
                        <td class="p-3">{{ $pelaporan->id_lapor_ruangan }}</td>
                        <td class="p-3">{{ $pelaporan->datetime }}</td>
                        <td class="p-3">{{ $pelaporan->oleh }}</td>
                        <td class="p-3">{{ $pelaporan->kepada }}</td>
                        <td class="p-3">
                            <a href="{{ route('pelaporans.show', $pelaporan->id_lapor_ruangan) }}" class="text-blue-500">Lihat</a>
                            <a href="{{ route('pelaporans.edit', $pelaporan->id_lapor_ruangan) }}" class="text-yellow-500 ml-2">Edit</a>
                            <form action="{{ route('pelaporans.destroy', $pelaporan->id_lapor_ruangan) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 ml-2" onclick="return confirm('Hapus laporan ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-3 text-center">Tidak ada laporan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>