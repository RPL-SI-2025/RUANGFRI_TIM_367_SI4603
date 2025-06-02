
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
                                <h4 class="text-white mb-1 fw-bold">Detail Peminjaman Ruangan</h4>
                                <p class="text-white-50 mb-3">Informasi lengkap peminjaman ruangan Anda</p>
                                
                                <!-- Status Badge in Header -->
                                <div class="status-badge-header">
                                    @if($pinjamRuangan->status == 0)
                                        <span class="badge badge-header bg-warning-header text-dark">
                                            <i class="fa fa-clock me-1"></i>Menunggu Persetujuan
                                        </span>
                                    @elseif($pinjamRuangan->status == 1)
                                        <span class="badge badge-header bg-success-header text-white">
                                            <i class="fa fa-check me-1"></i>Disetujui
                                        </span>
                                    @elseif($pinjamRuangan->status == 2)
                                        <span class="badge badge-header bg-danger-header text-white">
                                            <i class="fa fa-times me-1"></i>Ditolak
                                        </span>
                                    @elseif($pinjamRuangan->status == 3)
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
                        <a href="{{ route('mahasiswa.peminjaman.pinjam-ruangan.index') }}" 
                           class="btn btn-outline-light btn-floating">
                            <i class="fa fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>

            <!-- Room Details Section -->
            <div class="section-card mb-4">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fa fa-building"></i>
                    </div>
                    <div>
                        <h5 class="section-title">Detail Ruangan</h5>
                        <p class="section-subtitle">Ruangan yang dipinjam</p>
                    </div>
                </div>
                
                <div class="section-content">
                    <div class="table-responsive mb-4">
                        <table class="table table-hover table-modern">
                            <thead>
                                <tr>
                                    <th class="border-0">No</th>
                                    <th class="border-0">Nama Ruangan</th>
                                    <th class="border-0">Lokasi</th>
                                    <th class="border-0">Tanggal</th>
                                    <th class="border-0">Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($relatedRooms as $index => $room)
                                    <tr>
                                        <td>
                                            <div class="number-circle-small">{{ $index + 1 }}</div>
                                        </td>
                                        <td>
                                            <div class="room-info-compact">
                                                <h6 class="mb-1">{{ $room->ruangan->nama_ruangan }}</h6>
                                                <small class="text-muted">
                                                    <i class="fa fa-users me-1"></i>{{ $room->ruangan->kapasitas }} orang
                                                </small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="location-badge">
                                                <i class="fa fa-map-marker me-1"></i>{{ $room->ruangan->lokasi }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="date-display">
                                                <strong>{{ \Carbon\Carbon::parse($room->tanggal_pengajuan)->format('d M Y') }}</strong>
                                                <small class="d-block text-muted">
                                                    s/d {{ \Carbon\Carbon::parse($room->tanggal_selesai)->format('d M Y') }}
                                                </small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="time-display-compact">
                                                <span class="time-badge-small">
                                                    {{ \Carbon\Carbon::parse($room->waktu_mulai)->format('H:i') }} - 
                                                    {{ \Carbon\Carbon::parse($room->waktu_selesai)->format('H:i') }}
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Room Cards for better visual -->
                    <div class="row">
                        @foreach($relatedRooms as $room)
                            <div class="col-md-6 mb-4">
                                <div class="room-card-detailed">
                                    <div class="room-card-header">
                                        <h6 class="mb-0">{{ $room->ruangan->nama_ruangan }}</h6>
                                    </div>
                                    <div class="room-card-body">
                                        <div class="room-image-container">
                                            @if($room->ruangan->gambar)
                                                <img src="{{ asset('storage/katalog_ruangan/'.$room->ruangan->gambar) }}" 
                                                     class="room-image" 
                                                     alt="{{ $room->ruangan->nama_ruangan }}">
                                            @else
                                                <div class="room-placeholder">
                                                    <i class="fa fa-building-o"></i>
                                                    <p>Tidak ada gambar</p>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="room-details-list">
                                            <div class="detail-row">
                                                <span class="detail-label">Kapasitas</span>
                                                <span class="detail-value">{{ $room->ruangan->kapasitas }} orang</span>
                                            </div>
                                            <div class="detail-row">
                                                <span class="detail-label">Lokasi</span>
                                                <span class="detail-value">{{ $room->ruangan->lokasi }}</span>
                                            </div>
                                            @if($room->ruangan->fasilitas)
                                            <div class="detail-row">
                                                <span class="detail-label">Fasilitas</span>
                                                <span class="detail-value">{{ Str::limit($room->ruangan->fasilitas, 100) }}</span>
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
                                <p>{{ \Carbon\Carbon::parse($pinjamRuangan->tanggal_pengajuan)->format('d F Y') }}</p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fa fa-calendar-check"></i>
                            </div>
                            <div class="info-content">
                                <h6>Tanggal Selesai</h6>
                                <p>{{ \Carbon\Carbon::parse($pinjamRuangan->tanggal_selesai)->format('d F Y') }}</p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fa fa-clock"></i>
                            </div>
                            <div class="info-content">
                                <h6>Waktu Peminjaman</h6>
                                <p>
                                    {{ \Carbon\Carbon::parse($pinjamRuangan->waktu_mulai)->format('H:i') }} - 
                                    {{ \Carbon\Carbon::parse($pinjamRuangan->waktu_selesai)->format('H:i') }}
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

            <!-- Purpose Section -->
            <div class="section-card mb-4">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fa fa-clipboard-list"></i>
                    </div>
                    <div>
                        <h5 class="section-title">Tujuan Peminjaman</h5>
                        <p class="section-subtitle">Deskripsi penggunaan ruangan</p>
                    </div>
                </div>
                
                <div class="section-content">
                    <div class="purpose-content">
                        <div class="purpose-text">
                            <p>{{ $pinjamRuangan->tujuan_peminjaman }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documents Section -->
            @if($pinjamRuangan->file_scan)
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
                                <p class="text-muted">{{ $pinjamRuangan->file_scan }}</p>
                                <a href="{{ asset('storage/uploads/file_scan/'.$pinjamRuangan->file_scan) }}" 
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
            @if($pinjamRuangan->status == 2 && $pinjamRuangan->catatan)
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
                                <p class="mb-0">{{ $pinjamRuangan->catatan }}</p>
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
                    @if($pinjamRuangan->status == 0)
                        <a href="{{ route('mahasiswa.peminjaman.pinjam-ruangan.edit', $pinjamRuangan->id) }}" 
                           class="btn btn-warning btn-lg">
                            <i class="fa fa-edit me-2"></i>Edit Peminjaman
                        </a>
                        <form action="{{ route('mahasiswa.peminjaman.pinjam-ruangan.cancel', $pinjamRuangan->id) }}" 
                              method="POST" 
                              onsubmit="return confirm('Apakah Anda yakin ingin membatalkan peminjaman ini?')"
                              class="d-inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-danger btn-lg">
                                <i class="fa fa-times me-2"></i>Batalkan Peminjaman
                            </button>
                        </form>
                    @endif
                    
                    @if($pinjamRuangan->status == 1)
                        @php
                            $existingReport = \App\Models\Pelaporan::where('id_mahasiswa', Session::get('mahasiswa_id'))
                                ->where('datetime', '>=', \Carbon\Carbon::parse($pinjamRuangan->updated_at)->format('Y-m-d'))
                                ->exists();
                        @endphp
                        
                        @if(!$existingReport)
                            <a href="{{ route('mahasiswa.pelaporan.lapor_ruangan.create', ['id' => $pinjamRuangan->id]) }}" 
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