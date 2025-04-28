@extends('mahasiswa.layouts.mahasiswa')

@section('content')
<div class="container">
    <h2>Daftar Pelaporan Inventaris</h2>
    
   </div>
    
    <table border="1" cellpadding="10" cellspacing="0" style="width:100%; text-align:center;">
    <table class="table table-bordered">
    <thead>
            <tr>
                <th>ID</th>
                <th>Oleh</th>
                <th>Kepada</th>
                <th>Deskripsi</th>
                <th>Foto Awal</th>
                <th>Foto Akhir</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporan as $lapor)
            <tr>
                <td>{{ $lapor->id_lapor_inventaris }}</td>
                <td>{{ $lapor->oleh }}</td>
                <td>{{ $lapor->kepada }}</td>
                <td>{{ $lapor->deskripsi }}</td>
                <td>
                    @if($lapor->foto_awal)
                        <img src="{{ asset('storage/' . $lapor->foto_awal) }}" width="100">
                    @else
                        Tidak Ada
                    @endif
                </td>
                <td>
                    @if($lapor->foto_akhir)
                        <img src="{{ asset('storage/' . $lapor->foto_akhir) }}" width="100">
                    @else
                        Tidak Ada
                    @endif
                </td>
                <td>
                    <a href="{{ route('mahasiswa.lapor_inventaris.show', $lapor->id_lapor_inventaris) }}" class="btn btn-primary" style="margin-bottom:5px;">Lihat</a>
                    <form method="POST" action="{{ route('admin.lapor_inventaris.destroy', $lapor->id_lapor_inventaris) }}" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Hapus data ini?')" class="btn btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
