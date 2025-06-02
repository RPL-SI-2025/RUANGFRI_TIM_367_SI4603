
@extends('mahasiswa.layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/show_peminjaman.css') }}">
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-10 col-xl-9">
            <!-- Enhanced Header Card with Status -->
            <div class="card border-0 shadow-lg mb-4 header-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper me-3">
                                <i class="fa fa-info-circle"></i>
                            </div>
                            <div>
                                <h4 class="text-white mb-1 fw-bold">Detail Peminjaman Inventaris</h4>
                                <p class="text-white-50 mb-3">Informasi lengkap peminjaman inventaris Anda</p>
                                
                                <!-- Status Badge in Header -->
                                <div class="status-badge-header">
                                    @if($pinjamInventaris->status == 0)
                                        <span class="badge badge-header bg-warning-header text-dark">
                                            <i class="fa fa-clock me-1"></i>Menunggu Persetujuan
                                        </span>
                                    @elseif($pinjamInventaris->status == 1)
                                        <span class="badge badge-header bg-success-header text-white">
                                            <i class="fa fa-check me-1"></i>Disetujui
                                        </span>
                                    @elseif($pinjamInventaris->status == 2)
                                        <span class="badge badge-header bg-danger-header text-white">
                                            <i class="fa fa-times me-1"></i>Ditolak
                                        </span>
                                    @elseif($pinjamInventaris->status == 3)
                                        <span class="badge badge-header bg-info-header text-white">
                                            <i class="fa fa-flag-checkered me-1"></i>Selesai
                                        </span>
                                    @else
                                        <span class="badge badge-header bg-secondary-header text-white">
                                            <i class="fa fa-ban me-1"></i>Dibatalkan
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('mahasiswa.peminjaman.pinjam-inventaris.index') }}" 
                           class="btn btn-outline-light btn-floating">
                            <i class="fa fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>

            <!-- Inventaris Details Section -->
            <div class="section-card mb-4">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fa fa-box"></i>
                    </div>
                    <div>
                        <h5 class="section-title">Detail Inventaris</h5>
                        <p class="section-subtitle">Inventaris yang dipinjam</p>
                    </div>
                </div>
                
                <div class="section-content">
                    <div class="table-responsive mb-4">
                        <table class="table table-hover table-modern">
                            <thead>
                                <tr>
                                    <th class="border-0">No</th>
                                    <th class="border-0">Nama Inventaris</th>
                                    <th class="border-0">Jumlah</th>
                                    <th class="border-0">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $relatedItems = \App\Models\PinjamInventaris::where('tanggal_pengajuan', $pinjamInventaris->tanggal_pengajuan)
                                        ->where('tanggal_selesai', $pinjamInventaris->tanggal_selesai)
                                        ->where('waktu_mulai', $pinjamInventaris->waktu_mulai)
                                        ->where('waktu_selesai', $pinjamInventaris->waktu_selesai)
                                        ->where('file_scan', $pinjamInventaris->file_scan)
                                        ->where('id_mahasiswa', $pinjamInventaris->id_mahasiswa)
                                        ->with('inventaris')
                                        ->get();
                                @endphp
                                
                                @foreach($relatedItems as $index => $item)
                                    <tr>
                                        <td>
                                            <div class="number-circle-small">{{ $index + 1 }}</div>
                                        </td>
                                        <td>
                                            <div class="room-info-compact">
                                                <h6 class="mb-1">{{ $item->inventaris->nama_inventaris ?? 'Inventaris tidak ditemukan' }}</h6>
                                                <small class="text-muted">
                                                    <i class="fa fa-info-circle me-1"></i>{{ Str::limit($item->inventaris->deskripsi ?? 'Tidak ada deskripsi', 50) }}
                                                </small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="location-badge">
                                                <i class="fa fa-cubes me-1"></i>{{ $item->jumlah_pinjam }} unit
                                            </span>
                                        </td>
                                        <td>
                                            <div class="time-display-compact">
                                                <span class="time-badge-small bg-primary text-white">
                                                    Tersedia
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Inventaris Cards for better visual -->
                    <div class="row">
                        @foreach($relatedItems as $item)
                            <div class="col-md-6 mb-4">
                                <div class="room-card-detailed">
                                    <div class="room-card-header">
                                        <h6 class="mb-0">{{ $item->inventaris->nama_inventaris ?? 'Inventaris tidak ditemukan' }}</h6>
                                    </div>
                                    <div class="room-card-body">
                                        <div class="room-image-container">
                                            @if($item->inventaris && $item->inventaris->gambar_inventaris)
                                                <img src="{{ asset('storage/katalog_inventaris/'.$item->inventaris->gambar_inventaris) }}" 
                                                     class="room-image" 
                                                     alt="{{ $item->inventaris->nama_inventaris }}">
                                            @else
                                                <div class="room-placeholder">
                                                    <i class="fa fa-box"></i>
                                                    <p>Tidak ada gambar</p>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="room-details-list">
                                            <div class="detail-row">
                                                <span class="detail-label">Jumlah</span>
                                                <span class="detail-value">{{ $item->jumlah_pinjam }} unit</span>
                                            </div>
                                            @if($item->inventaris && $item->inventaris->deskripsi)
                                            <div class="detail-row">
                                                <span class="detail-label">Deskripsi</span>
                                                <span class="detail-value">{{ Str::limit($item->inventaris->deskripsi, 100) }}</span>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Booking Information Section -->
            <div class="section-card mb-4">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fa fa-calendar-alt"></i>
                    </div>
                    <div>
                        <h5 class="section-title">Informasi Peminjaman</h5>
                        <p class="section-subtitle">Detail waktu dan tanggal peminjaman</p>
                    </div>
                </div>
                
                <div class="section-content">
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <div class="info-content">
                                <h6>Tanggal Pengajuan</h6>
                                <p>{{ \Carbon\Carbon::parse($pinjamInventaris->tanggal_pengajuan)->format('d F Y') }}</p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fa fa-calendar-check"></i>
                            </div>
                            <div class="info-content">
                                <h6>Tanggal Selesai</h6>
                                <p>{{ \Carbon\Carbon::parse($pinjamInventaris->tanggal_selesai)->format('d F Y') }}</p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fa fa-clock"></i>
                            </div>
                            <div class="info-content">
                                <h6>Waktu Peminjaman</h6>
                                <p>
                                    {{ \Carbon\Carbon::parse($pinjamInventaris->waktu_mulai)->format('H:i') }} - 
                                    {{ \Carbon\Carbon::parse($pinjamInventaris->waktu_selesai)->format('H:i') }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fa fa-user"></i>
                            </div>
                            <div class="info-content">
                                <h6>Pemohon</h6>
                                <p>{{ Session::get('mahasiswa_nama') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documents Section -->
            @if($pinjamInventaris->file_scan)
            <div class="section-card mb-4">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fa fa-paperclip"></i>
                    </div>
                    <div>
                        <h5 class="section-title">Dokumen Pendukung</h5>
                        <p class="section-subtitle">File yang dilampirkan</p>
                    </div>
                </div>
                
                <div class="section-content">
                    <div class="document-preview">
                        <div class="document-card">
                            <div class="document-icon">
                                <i class="fa fa-file-pdf-o"></i>
                            </div>
                            <div class="document-info">
                                <h6>Dokumen Peminjaman</h6>
                                <p class="text-muted">{{ $pinjamInventaris->file_scan }}</p>
                                <a href="{{ asset('storage/uploads/file_scan/'.$pinjamInventaris->file_scan) }}" 
                                   class="btn btn-outline-primary btn-sm" 
                                   target="_blank">
                                    <i class="fa fa-eye me-1"></i>Lihat Dokumen
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Admin Notes Section -->
            @if($pinjamInventaris->status == 2 && $pinjamInventaris->notes)
            <div class="section-card mb-4">
                <div class="section-header">
                    <div class="section-icon bg-danger">
                        <i class="fa fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <h5 class="section-title text-danger">Catatan Penolakan</h5>
                        <p class="section-subtitle">Alasan penolakan dari admin</p>
                    </div>
                </div>
                
                <div class="section-content">
                    <div class="alert alert-danger alert-modern border-0">
                        <div class="d-flex align-items-start">
                            <div class="alert-icon me-3">
                                <i class="fa fa-exclamation-triangle"></i>
                            </div>
                            <div>
                                <h6 class="alert-title">Peminjaman Ditolak</h6>
                                <p class="mb-0">{{ $pinjamInventaris->notes }}</p>
                                <small class="text-muted mt-2 d-block">
                                    <i class="fa fa-info-circle me-1"></i>
                                    Silakan perbaiki sesuai catatan di atas untuk pengajuan selanjutnya.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="action-section">
                <div class="action-buttons">
                    @if($pinjamInventaris->status == 0)
                        <a href="{{ route('mahasiswa.peminjaman.pinjam-inventaris.edit', $pinjamInventaris->id) }}" 
                           class="btn btn-warning btn-lg">
                            <i class="fa fa-edit me-2"></i>Edit Peminjaman
                        </a>
                        <form action="{{ route('mahasiswa.peminjaman.pinjam-inventaris.destroy', $pinjamInventaris->id) }}" 
                              method="POST" 
                              onsubmit="return confirm('Apakah Anda yakin ingin membatalkan peminjaman ini?')"
                              class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-lg">
                                <i class="fa fa-times me-2"></i>Batalkan Peminjaman
                            </button>
                        </form>
                    @endif
                    
                    @if($pinjamInventaris->status == 1)
                        @php
                            $existingReport = \App\Models\LaporInventaris::where('id_mahasiswa', Session::get('mahasiswa_id'))
                                ->where('datetime', '>=', \Carbon\Carbon::parse($pinjamInventaris->updated_at)->format('Y-m-d'))
                                ->exists();
                        @endphp
                        
                        @if(!$existingReport)
                            <a href="{{ route('mahasiswa.pelaporan.lapor_inventaris.create', ['id_peminjaman' => $pinjamInventaris->id]) }}" 
                               class="btn btn-success btn-lg">
                                <i class="fa fa-flag me-2"></i>Buat Laporan Pengembalian
                            </a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
   
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
    
   
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin me-2"></i>Memproses...';
                submitBtn.disabled = true;
                
   
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }, 3000);
            }
        });
    });
});
</script>
@endpush
@endsection