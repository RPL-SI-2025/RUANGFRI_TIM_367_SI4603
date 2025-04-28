@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Pelaporan</h2>
    <table border="1" cellpadding="10">
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
            @foreach($pelaporans as $lapor)
            <tr>
                <td>{{ $lapor->id }}</td>
                <td>{{ $lapor->oleh }}</td>
                <td>{{ $lapor->kepada }}</td>
                <td>{{ $lapor->deskripsi }}</td>
                <td>
                    @if($lapor->foto_awal)
                        <img src="{{ asset('storage/' . $lapor->foto_awal) }}" width="100">
                    @endif
                </td>
                <td>
                    @if($lapor->foto_akhir)
                        <img src="{{ asset('storage/' . $lapor->foto_akhir) }}" width="100">
                    @endif
                </td>
                <td>
                    <form method="POST" action="{{ route('pelaporans.destroy', $lapor->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Hapus data ini?')">Hapus</button>
                    </form>
                </td>
            
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
