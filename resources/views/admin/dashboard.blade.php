@extends('admin.layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Dashboard Admin</h2>
    
    <div class="row g-4">
        {{-- Baris 1 --}}
        <div class="col-md-4">
            <div class="card text-white bg-primary shadow">
                <div class="card-body">
                    <h5 class="card-title">Total Jumlah Ruangan</h5>
                    <p class="card-text fs-4"> {{ $totalRuangan }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-secondary shadow">
                <div class="card-body">
                    <h5 class="card-title">Ruangan Tersedia</h5>
                    <p class="card-text fs-4">{{ $ruanganTersedia }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-dark shadow">
                <div class="card-body">
                    <h5 class="card-title">Ruangan Tidak Tersedia</h5>
                    <p class="card-text fs-4">{{ $ruanganTidakTersedia }}</p>
                </div>
            </div>
        </div>

        {{-- Baris 2 --}}
        <div class="col-md-4">
            <div class="card text-white bg-success shadow">
                <div class="card-body">
                    <h5 class="card-title">Total Jumlah Inventaris</h5>
                    <p class="card-text fs-4">{{ $totalInventaris }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-warning shadow">
                <div class="card-body">
                    <h5 class="card-title">Inventaris Tersedia</h5>
                    <p class="card-text fs-4">{{ $inventarisTersedia }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-danger shadow">
                <div class="card-body">
                    <h5 class="card-title">Inventaris Tidak Tersedia</h5>
                    <p class="card-text fs-4">{{ $inventarisTidakTersedia }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Baris 3: Pengajuan Belum Disetujui --}}
<div class="row g-4 mt-3">
    <div class="col-md-4">
        <div class="card text-white bg-info shadow">
            <div class="card-body">
                <h5 class="card-title">Pengajuan Belum Disetujui</h5>
                {{-- <p class="card-text fs-4">{{ $pengajuanBelumDisetujui }}</p> --}}
            </div>
        </div>
    </div>

    {{-- Aksi Cepat --}}
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-body">
                <h5 class="card-title">Aksi Cepat</h5>
                <a href="{{ route('admin.katalog_ruangan.create') }}" class="btn btn-primary me-2">+ Tambah Ruangan</a>
                <a href="{{ route('admin.inventaris.create') }}" class="btn btn-success me-2">+ Tambah Inventaris</a>
                <a href="{{-- {{ route('pinjam.approval') }} --}}" class="btn btn-warning me-2">✔️ Persetujuan</a>
                <a href="{{-- {{ route('laporan.index') }} --}}" class="btn btn-dark">📄 Laporan</a>
            </div>
        </div>
    </div>
</div>

{{-- Baris 4: Grafik Statistik --}}
<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-body">
                <h5 class="card-title">Statistik Peminjaman Bulanan</h5>
                <canvas id="peminjamanChart"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- Baris 5: Aktivitas Terbaru --}}
<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-body">
                <h5 class="card-title">Aktivitas Terbaru</h5>
                <ul class="list-group">
                    @forelse ($aktivitasTerbaru as $aktivitas)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $aktivitas->deskripsi }}
                            <span class="badge bg-secondary">{{ $aktivitas->created_at->diffForHumans() }}</span>
                        </li>
                    @empty
                        <li class="list-group-item">Tidak ada aktivitas terbaru.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
</div>
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('peminjamanChart').getContext('2d');
    const peminjamanChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($grafik['bulan']) !!},
            datasets: [{
                label: 'Jumlah Peminjaman',
                data: {!! json_encode($grafik['jumlah']) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection

@endsection
