@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Semua Peminjaman Inventaris</h5>
                        <div>
                            <a href="{{ route('admin.approval') }}" class="btn btn-warning">
                                <i class="fa fa-clock"></i> Menunggu Persetujuan
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Inventaris</th>
                                    <th>Peminjam</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($peminjaman as $index => $pinjam)
                                    <tr>
                                        <td>{{ $index + $peminjaman->firstItem() }}</td>
                                        <td>{{ $pinjam->inventaris->nama_inventaris ?? 'N/A' }}</td>
                                        <td>{{ $pinjam->mahasiswa->nama ?? 'N/A' }} ({{ $pinjam->mahasiswa->nim ?? 'N/A' }})</td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($pinjam->tanggal_pengajuan)->format('d-m-Y') }} s/d
                                            {{ \Carbon\Carbon::parse($pinjam->tanggal_selesai)->format('d-m-Y') }}
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($pinjam->waktu_mulai)->format('H:i') }} - 
                                            {{ \Carbon\Carbon::parse($pinjam->waktu_selesai)->format('H:i') }}
                                        </td>
                                        <td>
                                            @php
                                                $badgeClass = '';
                                                switch($pinjam->status) {
                                                    case 0:
                                                        $badgeClass = 'bg-warning';
                                                        break;
                                                    case 1:
                                                        $badgeClass = 'bg-success';
                                                        break;
                                                    case 2:
                                                        $badgeClass = 'bg-danger';
                                                        break;
                                                    case 3:
                                                        $badgeClass = 'bg-info';
                                                        break;
                                                }
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">{{ $pinjam->status_text }}</span>
                                        </td>
                                        <td>
                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="deleteModal{{ $pinjam->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Apakah Anda yakin ingin menghapus data peminjaman inventaris ini?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <form action="{{ route('pinjam-inventaris.destroy', $pinjam->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Status Modal -->
                                            <div class="modal fade" id="statusModal{{ $pinjam->id }}" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="statusModalLabel">Update Status Peminjaman</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('pinjam-inventaris.update-status', $pinjam->id) }}" method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="status" class="form-label">Status</label>
                                                                    <select class="form-select" id="status" name="status" required>
                                                                        <option value="0" {{ $pinjam->status == 0 ? 'selected' : '' }}>Menunggu Persetujuan</option>
                                                                        <option value="1" {{ $pinjam->status == 1 ? 'selected' : '' }}>Disetujui</option>
                                                                        <option value="2" {{ $pinjam->status == 2 ? 'selected' : '' }}>Ditolak</option>
                                                                        <option value="3" {{ $pinjam->status == 3 ? 'selected' : '' }}>Selesai</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data peminjaman inventaris</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center mt-3">
                        {{ $peminjaman->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection