@extends('layouts.app')

@section('title', 'Katalog Ruangan')

@section('content')
<div class='card'>
    <div class='card-header bg-primary text-white d-flex justify-content-between align-items-center'>
        <div class='d-flex align-items-center'>
            <h3 class='mb-0'>Katalog Ruangan</h3>
        <h4 class='card-title'>Katalog Ruangan</h4>
        <form action="{{ route('katalog_ruangan.index') }}" method="GET" class="ml-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control me-2" placeholder="Cari ruangan..." value="{{ request()->get('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                </div>
            </div>

@endsection
