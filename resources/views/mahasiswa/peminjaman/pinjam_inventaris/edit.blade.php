@extends('mahasiswa.layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Edit Peminjaman Inventaris</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('pinjam-inventaris.update', $pinjamInventaris->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Tanggal Pengajuan:</strong></div>
                    <div class="col-md-8">
                        <input type="date" name="tanggal_pengajuan" class="form-control" value="{{ $pinjamInventaris->tanggal_pengajuan }}" required>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Tanggal Selesai:</strong></div>
                    <div class="col-md-8">
                        <input type="date" name="tanggal_selesai" class="form-control" value="{{ $pinjamInventaris->tanggal_selesai }}" required>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Waktu Mulai:</strong></div>
                    <div class="col-md-8">
                        <input type="time" name="waktu_mulai" class="form-control" value="{{ $pinjamInventaris->waktu_mulai }}" required>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Waktu Selesai:</strong></div>
                    <div class="col-md-8">
                        <input type="time" name="waktu_selesai" class="form-control" value="{{ $pinjamInventaris->waktu_selesai }}" required>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4"><strong>File Scan:</strong></div>
                    <div class="col-md-8">
                        @if($pinjamInventaris->file_scan)
                            <div class="mb-2">
                                <a href="{{ asset('storage/uploads/file_scan/' . $pinjamInventaris->file_scan) }}" target="_blank" class="btn btn-sm btn-primary">Lihat File</a>
                            </div>
                        @endif
                        <input type="file" name="file_scan" class="form-control">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah file</small>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Inventaris yang Dipinjam:</strong></div>
                    <div class="col-md-8">
                        @php
                            // Find related inventory items from the same request
                            $relatedItems = \App\Models\PinjamInventaris::where('tanggal_pengajuan', $pinjamInventaris->tanggal_pengajuan)
                                ->where('tanggal_selesai', $pinjamInventaris->tanggal_selesai)
                                ->where('waktu_mulai', $pinjamInventaris->waktu_mulai)
                                ->where('waktu_selesai', $pinjamInventaris->waktu_selesai)
                                ->where('file_scan', $pinjamInventaris->file_scan)
                                ->where('id_mahasiswa', $pinjamInventaris->id_mahasiswa)
                                ->get();
                        @endphp
                        
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Inventaris</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($relatedItems as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <input type="text" class="form-control-plaintext" 
                                                value="{{ $item->inventaris->nama_inventaris ?? 'Inventaris tidak ditemukan' }}" 
                                                readonly>
                                            <input type="hidden" name="inventaris[{{ $item->id }}][id]" value="{{ $item->id_inventaris }}">
                                        </td>
                                        <td>
                                            <input type="number" name="inventaris[{{ $item->id }}][jumlah]" 
                                                class="form-control" value="{{ $item->jumlah_pinjam ?? 1 }}" 
                                                min="1" max="{{ $item->inventaris->jumlah ?? 1 }}" required>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('mahasiswa.peminjaman.pinjam-inventaris.show', $pinjamInventaris->id) }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection