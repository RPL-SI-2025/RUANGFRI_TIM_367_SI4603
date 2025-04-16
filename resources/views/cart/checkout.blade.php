@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Pengajuan Peminjaman Inventaris</h5>
                        <a href="{{ route('cart.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Kembali ke Keranjang
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <h6 class="mb-4">Item yang akan dipinjam:</h6>
                    <table class="table table-bordered mb-4">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Inventaris</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $id => $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item['nama_inventaris'] }}</td>
                                    <td>{{ $item['jumlah'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <form action="{{ route('pinjam-inventaris.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_pengajuan">Tanggal Pengajuan</label>
                                    <input type="date" class="form-control @error('tanggal_pengajuan') is-invalid @enderror" 
                                        id="tanggal_pengajuan" name="tanggal_pengajuan" value="{{ old('tanggal_pengajuan', date('Y-m-d')) }}" required>
                                    @error('tanggal_pengajuan')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_selesai">Tanggal Selesai</label>
                                    <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                                        id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" required>
                                    @error('tanggal_selesai')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="waktu_mulai">Waktu Mulai</label>
                                    <input type="time" class="form-control @error('waktu_mulai') is-invalid @enderror" 
                                        id="waktu_mulai" name="waktu_mulai" value="{{ old('waktu_mulai') }}" required>
                                    @error('waktu_mulai')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="waktu_selesai">Waktu Selesai</label>
                                    <input type="time" class="form-control @error('waktu_selesai') is-invalid @enderror" 
                                        id="waktu_selesai" name="waktu_selesai" value="{{ old('waktu_selesai') }}" required>
                                    @error('waktu_selesai')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="file_scan">File Scan (Opsional)</label>
                            <input type="file" class="form-control @error('file_scan') is-invalid @enderror" 
                                id="file_scan" name="file_scan">
                            <small class="form-text text-muted">Upload surat permohonan atau dokumen pendukung (PDF, JPG, PNG, max 2MB)</small>
                            @error('file_scan')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-paper-plane"></i> Ajukan Peminjaman
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection