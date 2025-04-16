@extends('layouts.app')

@section('title', 'Register Mahasiswa')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">

        {{-- Alert untuk sukses --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Alert untuk error --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">Register Mahasiswa</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="nim" class="form-label">NIM</label>
                        <input type="text" name="nim" id="nim" class="form-control" value="{{ old('nim') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="nama_mahasiswa" class="form-label">Nama Mahasiswa</label>
                        <input type="text" name="nama_mahasiswa" id="nama_mahasiswa" class="form-control" value="{{ old('nama_mahasiswa') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Mahasiswa</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-success w-100">Daftar</button>
                </form>

                <div class="mt-3 text-center">
                    <small>Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
