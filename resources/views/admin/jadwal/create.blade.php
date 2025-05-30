@extends('admin.layouts.admin')

@section('title', 'Tambah Jadwal')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Tambah Jadwal</h2>
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
            <ul class="nav nav-tabs card-header-tabs" id="jadwalTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="single-tab" data-bs-toggle="tab" data-bs-target="#single-content" 
                            type="button" role="tab" aria-controls="single-content" aria-selected="true">
                        Jadwal Tunggal
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="bulk-tab" data-bs-toggle="tab" data-bs-target="#bulk-content" 
                            type="button" role="tab" aria-controls="bulk-content" aria-selected="false">
                        Generate Jadwal
                    </button>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="jadwalTabsContent">
                <!-- Jadwal Tunggal Form -->
                <div class="tab-pane fade show active" id="single-content" role="tabpanel" aria-labelledby="single-tab">
                    <form action="{{ route('admin.jadwal.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="id_ruangan" class="form-label">Ruangan</label>
                                <select name="id_ruangan" id="id_ruangan" class="form-select @error('id_ruangan') is-invalid @enderror" required>
                                    <option value="">Pilih Ruangan</option>
                                    @foreach($ruangans as $ruangan)
                                        <option value="{{ $ruangan->id }}" {{ old('id_ruangan') == $ruangan->id ? 'selected' : '' }}>
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
                                       value="{{ old('tanggal', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required>
                                @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="jam_mulai" class="form-label">Jam Mulai</label>
                                <input type="time" name="jam_mulai" id="jam_mulai" class="form-control @error('jam_mulai') is-invalid @enderror" 
                                       value="{{ old('jam_mulai', '07:00') }}" required>
                                @error('jam_mulai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="jam_selesai" class="form-label">Jam Selesai</label>
                                <input type="time" name="jam_selesai" id="jam_selesai" class="form-control @error('jam_selesai') is-invalid @enderror" 
                                       value="{{ old('jam_selesai', '21:00') }}" required>
                                @error('jam_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="jeda_waktu" class="form-label">Jeda Waktu (Jam)</label>
                            <select name="jeda_waktu" id="jeda_waktu" class="form-select @error('jeda_waktu') is-invalid @enderror" required>
                                <option value="1" {{ old('jeda_waktu') == '1' ? 'selected' : '' }}>1 Jam</option>
                                <option value="2" {{ old('jeda_waktu') == '2' ? 'selected' : '' }}>2 Jam</option>
                                <option value="3" {{ old('jeda_waktu') == '3' ? 'selected' : '' }}>3 Jam</option>
                                <option value="4" {{ old('jeda_waktu') == '4' ? 'selected' : '' }}>4 Jam</option>
                            </select>
                            @error('jeda_waktu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Jeda waktu akan membuat beberapa slot jadwal dengan interval waktu yang dipilih
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Simpan Jadwal
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Generate Jadwal Form -->
                <div class="tab-pane fade" id="bulk-content" role="tabpanel" aria-labelledby="bulk-tab">
                    <form action="{{ route('admin.jadwal.generate') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="id_ruangan_bulk" class="form-label">Ruangan</label>
                                <select name="id_ruangan" id="id_ruangan_bulk" class="form-select @error('id_ruangan') is-invalid @enderror" required>
                                    <option value="">Pilih Ruangan</option>
                                    @foreach($ruangans as $ruangan)
                                        <option value="{{ $ruangan->id }}" {{ old('id_ruangan') == $ruangan->id ? 'selected' : '' }}>
                                            {{ $ruangan->nama_ruangan }} ({{ $ruangan->lokasi }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_ruangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                                       value="{{ old('tanggal_mulai', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required>
                                @error('tanggal_mulai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                                       value="{{ old('tanggal_selesai', date('Y-m-d', strtotime('+30 days'))) }}" min="{{ date('Y-m-d') }}" required>
                                @error('tanggal_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="jam_mulai_bulk" class="form-label">Jam Mulai</label>
                                <input type="time" name="jam_mulai" id="jam_mulai_bulk" class="form-control @error('jam_mulai') is-invalid @enderror" 
                                       value="{{ old('jam_mulai', '07:00') }}" required>
                                @error('jam_mulai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="jam_selesai_bulk" class="form-label">Jam Selesai</label>
                                <input type="time" name="jam_selesai" id="jam_selesai_bulk" class="form-control @error('jam_selesai') is-invalid @enderror" 
                                       value="{{ old('jam_selesai', '21:00') }}" required>
                                @error('jam_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="jeda_waktu_bulk" class="form-label">Jeda Waktu (Jam)</label>
                            <select name="jeda_waktu" id="jeda_waktu_bulk" class="form-select @error('jeda_waktu') is-invalid @enderror" required>
                                <option value="1" {{ old('jeda_waktu') == '1' ? 'selected' : '' }}>1 Jam</option>
                                <option value="2" {{ old('jeda_waktu') == '2' ? 'selected' : '' }}>2 Jam</option>
                                <option value="3" {{ old('jeda_waktu') == '3' ? 'selected' : '' }}>3 Jam</option>
                                <option value="4" {{ old('jeda_waktu') == '4' ? 'selected' : '' }}>4 Jam</option>
                            </select>
                            @error('jeda_waktu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-block">Hari Operasional</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="hari_0" name="hari_operasional[]" value="0" 
                                       {{ in_array('0', old('hari_operasional', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="hari_0">Minggu</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="hari_1" name="hari_operasional[]" value="1" 
                                       {{ in_array('1', old('hari_operasional', [1,2,3,4,5])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="hari_1">Senin</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="hari_2" name="hari_operasional[]" value="2" 
                                       {{ in_array('2', old('hari_operasional', [1,2,3,4,5])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="hari_2">Selasa</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="hari_3" name="hari_operasional[]" value="3" 
                                       {{ in_array('3', old('hari_operasional', [1,2,3,4,5])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="hari_3">Rabu</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="hari_4" name="hari_operasional[]" value="4" 
                                       {{ in_array('4', old('hari_operasional', [1,2,3,4,5])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="hari_4">Kamis</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="hari_5" name="hari_operasional[]" value="5" 
                                       {{ in_array('5', old('hari_operasional', [1,2,3,4,5])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="hari_5">Jumat</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="hari_6" name="hari_operasional[]" value="6" 
                                       {{ in_array('6', old('hari_operasional', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="hari_6">Sabtu</label>
                            </div>
                            @error('hari_operasional')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                            @error('hari_operasional.*')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-calendar-plus me-1"></i> Generate Jadwal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        if (!@json(old('hari_operasional'))) {
            document.querySelectorAll('input[name="hari_operasional[]"]').forEach(checkbox => {
                const value = parseInt(checkbox.value);
                if (value >= 1 && value <= 5) {
                    checkbox.checked = true;
                }
            });
        }
    });
</script>
@endpush