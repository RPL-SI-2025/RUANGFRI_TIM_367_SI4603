
@extends('mahasiswa.layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="text-primary mb-0 fw-bold">
                    <i class="fa fa-building me-2"></i>Detail Ruangan
                </h4>
                <a href="{{ route('mahasiswa.katalog.ruangan.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="fa fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-0">
                    <div class="row g-0">
                        <div class="col-md-5">
                            @if($ruangan->gambar)
                                <img src="{{ asset('storage/katalog_ruangan/' . $ruangan->gambar) }}" 
                                     class="img-fluid rounded-start h-100 w-100 object-cover" 
                                     alt="{{ $ruangan->nama_ruangan }}" 
                                     style="object-fit: cover; max-height: 400px;">
                            @else
                                <div class="bg-light h-100 d-flex justify-content-center align-items-center">
                                    <i class="fa fa-building-o text-muted" style="font-size: 5rem;"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-7">
                            <div class="card-body">
                                <h4 class="card-title text-primary fw-bold mb-3">{{ $ruangan->nama_ruangan }}</h4>
                                
                                <div class="mb-3">
                                    <span class="badge bg-secondary rounded-pill me-2">
                                        <i class="fa fa-map-marker me-1"></i> {{ $ruangan->lokasi }}
                                    </span>
                                    <span class="badge bg-info rounded-pill">
                                        <i class="fa fa-users me-1"></i> {{ $ruangan->kapasitas }} orang
                                    </span>
                                </div>
                                
                                <h6 class="fw-bold text-secondary mt-4 mb-2">Fasilitas:</h6>
                                <p class="card-text text-muted">{{ $ruangan->fasilitas }}</p>
                                
                                <h6 class="fw-bold text-secondary mt-4 mb-2">Status:</h6>
                                @if($ruangan->status == 'Tersedia')
                                    <span class="badge bg-success">Tersedia</span>
                                @else
                                    <span class="badge bg-danger">Tidak Tersedia</span>
                                @endif
                                
                                @if($ruangan->status == 'Tersedia')
                                    <form action="{{ route('mahasiswa.cart.keranjang_ruangan.add') }}" method="POST" class="mt-4">
                                        @csrf
                                        <input type="hidden" name="id_ruangan" value="{{ $ruangan->id }}">
                                        <input type="hidden" name="tanggal_booking" value="{{ date('Y-m-d') }}">
                                        <input type="hidden" name="waktu_mulai" value="08:00:00">
                                        <input type="hidden" name="waktu_selesai" value="10:00:00">
                                        
                                        <div class="d-flex mt-4">
                                            <button type="submit" class="btn btn-outline-primary rounded-pill me-2 flex-grow-1">
                                                <i class="fa fa-cart-plus me-1"></i> Tambah ke Keranjang
                                            </button>
                                            <a href="{{ route('mahasiswa.cart.keranjang_ruangan.index') }}" class="btn btn-primary rounded-pill flex-grow-1">
                                                <i class="fa fa-shopping-basket me-1"></i> Lihat Keranjang
                                            </a>
                                        </div>
                                    </form>
                                @else
                                    <div class="alert alert-warning mt-4">
                                        <i class="fa fa-exclamation-circle me-2"></i> 
                                        Ruangan ini sedang tidak tersedia untuk peminjaman
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light py-3">
                    <h5 class="mb-0 fw-bold">Jadwal Ketersediaan</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="calendar-legend d-flex flex-wrap mb-3 justify-content-center">
                            <div class="legend-item mx-2">
                                <span class="legend-indicator tersedia"></span> Tersedia
                            </div>
                            <div class="legend-item mx-2">
                                <span class="legend-indicator proses"></span> Dalam Proses
                            </div>
                            <div class="legend-item mx-2">
                                <span class="legend-indicator booked"></span> Sudah Dipesan
                            </div>
                            <div class="legend-item mx-2">
                                <span class="legend-indicator disabled"></span> Tidak Tersedia
                            </div>
                        </div>
                    </div>
                    
                    <div id="calendar-container" class="mb-3">
                        <div id="full-calendar"></div>
                    </div>
                    
                    <div id="timeslots-container" class="mt-4" style="display: none;">
                        <h6 class="fw-bold text-secondary mb-3">
                            <i class="fa fa-clock-o me-2"></i>Slot Waktu Tersedia <span id="selected-date"></span>
                        </h6>
                        <div class="row" id="timeslots-list"></div>
                        <button id="back-to-calendar" class="btn btn-sm btn-outline-secondary mt-3">
                            <i class="fa fa-arrow-left me-1"></i> Kembali ke Kalender
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <link href="{{ asset('css/ruangan-calendar.css') }}" rel="stylesheet">
@endpush


@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js'></script>
<script src="{{ asset('js/ruangan-calendar.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const ruanganCalendar = new RuanganCalendar({
            ruanganId: {{ $ruangan->id }},
            csrfToken: '{{ csrf_token() }}',
            cartUrl: '{{ route('mahasiswa.cart.keranjang_ruangan.index') }}',
            addToCartUrl: '{{ route('mahasiswa.cart.keranjang_ruangan.add') }}',
            timeSlotsUrl: '/mahasiswa/jadwal/timeslots',
            jadwalUrl: '/mahasiswa/jadwal/ruangan'
        });
    });
</script>
@endpush
@endsection