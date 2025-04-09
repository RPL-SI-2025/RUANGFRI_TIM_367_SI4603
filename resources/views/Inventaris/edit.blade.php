@extends('layouts.app')

@section('content')
<h1>Tambah Inventaris</h1>

<form action="{{ route('inventaris.store') }}" method="GET">
    @csrf
    <label>Nama Inventaris</label>
    <input type="text" name="nama_inventaris" required><br>

    <label>Deskripsi</label>
    <textarea name="deskripsi" required></textarea><br>

    <label>Jumlah</label>
    <input type="number" name="jumlah" required><br>

    <label>Status</label>
    <select name="status">
        <option value="Tersedia">Tersedia</option>
        <option value="Tidak Tersedia">Tidak Tersedia</option>
    </select><br>

    <button type="submit" class="btn btn-primary">Edit</button>
</form>
@endsection
