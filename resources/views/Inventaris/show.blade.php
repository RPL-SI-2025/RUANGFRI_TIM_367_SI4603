@extends('layouts.app')

@section('content')
<h2>{{ $inventaris->nama_inventaris }}</h2>
<p><strong>Deskripsi:</strong> {{ $inventaris->deskripsi }}</p>
<p><strong>Jumlah:</strong> {{ $inventaris->jumlah }}</p>
<p><strong>Status:</strong> {{ $inventaris->status }}</p>

@if(auth()->user()->role === 'mahasiswa')
    <a href="{{ route('inventaris.pinjam', $inventaris->id_inventaris) }}" class="btn btn-success">Pinjam</a>
@endif
@endsection
