@extends('mahasiswa.layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Daftar Peminjaman Inventaris</h2>
        <a href="{{ route('pinjam-inventaris.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Peminjaman
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Inventaris</th>
                            <th>Peminjam</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Tanggal Selesai</th>
                            <th>Waktu</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($peminjaman as $index => $pinjam)
                            <tr>
                                <td>{{ $index + $peminjaman->firstItem() }}</td>
                                <td>{{ $pinjam->inventaris->nama_inventaris }}</td>
                                <td>{{ $pinjam->mahasiswa->nama }} ({{ $pinjam->mahasiswa->nim }})</td>
                                <td>{{ date('d-m-Y', strtotime($pinjam->tanggal_pengajuan)) }}</td>
                                <td>{{ date('d-m-Y', strtotime($pinjam->tanggal_selesai)) }}</td>
                                <td>{{ date('H:i', strtotime($pinjam->waktu_mulai)) }} - {{ date('H:i', strtotime($pinjam->waktu_selesai)) }}</td>
                                <td>
                                    @if($pinjam->status == 0)
                                        <span class="badge bg-warning">Menunggu Persetujuan</span>
                                    @elseif($pinjam->status == 1)
                                        <span class="badge bg-success">Disetujui</span>
                                    @elseif($pinjam->status == 2)
                                        <span class="badge bg-danger">Ditolak</span>
                                    @elseif($pinjam->status == 3)
                                        <span class="badge bg-info">Selesai</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('pinjam-inventaris.show', $pinjam->id_pimjam_inventaris) }}" class="btn btn-sm btn-info text-white">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('pinjam-inventaris.edit', $pinjam->id_pimjam_inventaris) }}" class="btn btn-sm btn-warning text-white">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $pinjam->id_pimjam_inventaris }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        
                                        <!-- Update Status Button -->
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#statusModal{{ $pinjam->id_pimjam_inventaris }}">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $pinjam->id_pimjam_inventaris }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
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
                                                    <form action="{{ route('pinjam-inventaris.destroy', $pinjam->id_pimjam_inventaris) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Status Modal -->
                                    <div class="modal fade" id="statusModal{{ $pinjam->id_pimjam_inventaris }}" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="statusModalLabel">Update Status Peminjaman</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('pinjam-inventaris.update-status', $pinjam->id_pimjam_inventaris) }}" method="POST">
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
                                <td colspan="8" class="text-center">Tidak ada data peminjaman inventaris</td>
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
@endsection