@extends('admin.layouts.admin')

@section('title', 'Edit Jadwal')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Edit Jadwal</h2>
        <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">Edit Jadwal</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.jadwal.update', $jadwal->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="id_ruangan" class="form-label">Ruangan</label>
                        <select name="id_ruangan" id="id_ruangan" class="form-select @error('id_ruangan') is-invalid @enderror" required>
                            <option value="">Pilih Ruangan</option>
                            @foreach($ruangans as $ruangan)
                                <option value="{{ $ruangan->id }}" {{ old('id_ruangan', $jadwal->id_ruangan) == $ruangan->id ? 'selected' : '' }}>
                                    {{ $ruangan->nama_ruangan }} ({{ $ruangan->lokasi }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_ruangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror" 
                               value="{{ old('tanggal', $jadwal->tanggal) }}" required>
                        @error('tanggal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="jam_mulai" class="form-label">Jam Mulai</label>
                        <input type="time" name="jam_mulai" id="jam_mulai" class="form-control @error('jam_mulai') is-invalid @enderror" 
                               value="{{ old('jam_mulai', Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i')) }}" required>
                        @error('jam_mulai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="jam_selesai" class="form-label">Jam Selesai</label>
                        <input type="time" name="jam_selesai" id="jam_selesai" class="form-control @error('jam_selesai') is-invalid @enderror" 
                               value="{{ old('jam_selesai', Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i')) }}" required>
                        @error('jam_selesai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="tersedia" {{ old('status', $jadwal->status) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="proses" {{ old('status', $jadwal->status) == 'proses' ? 'selected' : '' }}>Proses</option>
                        <option value="booked" {{ old('status', $jadwal->status) == 'booked' ? 'selected' : '' }}>Booked</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                @if($jadwal->id_pinjam_ruangan)
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i> Jadwal ini terkait dengan peminjaman ruangan 
                    <a href="{{ route('admin.pinjam-ruangan.show', $jadwal->id_pinjam_ruangan) }}" class="alert-link">
                        #{{ $jadwal->id_pinjam_ruangan }}
                    </a>
                </div>
                @endif

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection