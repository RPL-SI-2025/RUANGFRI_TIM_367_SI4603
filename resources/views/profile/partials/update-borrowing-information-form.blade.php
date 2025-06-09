@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card border-0 shadow-lg main-card mb-4">
    <div class="card-header text-white py-3 border-0 card-header-futuristic"
        style="background: linear-gradient(90deg, #0069d9 0%, #0056b3 100%);">
        <div class="d-flex align-items-center">
            <i class="fa fa-book me-3 fs-4 text-white"></i>
            <h5 class="mb-0 fw-bold">Informasi Peminjaman</h5>
        </div>
    </div>

    <div class="card-body">
        <form method="post" action="{{ route('mahasiswa.profile.updateBorrowingInfo') }}" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <div class="mb-3">
                <label for="nim" class="form-label">NIM</label>
                <input type="text"
                    class="form-control @error('nim') is-invalid @enderror"
                    name="nim"
                    value="{{ old('nim', Auth::check() ? Auth::user()->nim : '') }}"
                    placeholder="NIM"
                    pattern="\d{10,12}" maxlength="12"
                    title="NIM harus berupa angka 10-12 digit" required>
                @error('nim') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="program_studi" class="form-label">Program Studi</label>
                <select class="form-select @error('program_studi') is-invalid @enderror" name="program_studi" required>
                    <option value="" disabled {{ old('program_studi', Auth::user()->program_studi ?? '') == '' ? 'selected' : '' }}>-- Pilih Program Studi --</option>
                    <option value="S1 Teknik Industri" {{ old('program_studi', Auth::user()->program_studi ?? '') == 'S1 Teknik Industri' ? 'selected' : '' }}>S1 Teknik Industri</option>
                    <option value="S1 Sistem Informasi" {{ old('program_studi', Auth::user()->program_studi ?? '') == 'S1 Sistem Informasi' ? 'selected' : '' }}>S1 Sistem Informasi</option>
                    <option value="S1 Teknik Logistik" {{ old('program_studi', Auth::user()->program_studi ?? '') == 'S1 Teknik Logistik' ? 'selected' : '' }}>S1 Teknik Logistik</option>
                    <option value="S1 Manajemen Rekayasa" {{ old('program_studi', Auth::user()->program_studi ?? '') == 'S1 Manajemen Rekayasa' ? 'selected' : '' }}>S1 Manajemen Rekayasa</option>
                </select>
                @error('program_studi') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="angkatan" class="form-label">Angkatan</label>
                <input type="text"
                    class="form-control @error('angkatan') is-invalid @enderror"
                    name="angkatan"
                    value="{{ old('angkatan', Auth::check() ? Auth::user()->angkatan : '') }}"
                    placeholder="Contoh: 2022"
                    pattern="20[0-2][0-9]|2025" maxlength="4"
                    title="Angkatan harus 4 digit dan tidak melebihi tahun 2025"
                    required>
                @error('angkatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="instansi" class="form-label">Nama Organisasi/Instansi</label>
                <input type="text"
                    class="form-control @error('instansi') is-invalid @enderror"
                    name="instansi"
                    value="{{ old('instansi', Auth::check() ? Auth::user()->instansi : '') }}"
                    placeholder="Contoh: Himpunan Mahasiswa Sistem Informasi"
                    pattern="[A-Za-z\s]+" title="Hanya huruf dan spasi yang diperbolehkan"
                    required>
                @error('instansi') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="tujuan" class="form-label">Tujuan Peminjaman</label>
                <input type="text"
                    class="form-control @error('tujuan') is-invalid @enderror"
                    name="tujuan"
                    value="{{ old('tujuan', Auth::check() ? Auth::user()->tujuan : '') }}"
                    placeholder="Contoh: Kegiatan Workshop"
                    pattern="[A-Za-z\s]+" title="Hanya huruf dan spasi yang diperbolehkan"
                    required>
                @error('tujuan') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="ktm" class="form-label">Upload KTM <span class="text-danger">*</span></label><br>

                @if (Auth::check() && Auth::user()->ktm)
                    @php
                        $fileExtension = pathinfo(Auth::user()->ktm, PATHINFO_EXTENSION);
                    @endphp

                    @if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'webp']))
                        <img src="{{ asset('storage/' . Auth::user()->ktm) }}"
                            alt="Kartu Tanda Mahasiswa"
                            style="max-width: 200px; height: auto; margin-bottom: 10px;"
                            class="rounded border shadow-sm">
                    @elseif ($fileExtension === 'pdf')
                        <iframe src="{{ asset('storage/' . Auth::user()->ktm) }}"
                            width="100%" height="400px"
                            class="border rounded shadow-sm mb-2"></iframe>
                    @else
                        <a href="{{ asset('storage/' . Auth::user()->ktm) }}" target="_blank"
                            class="text-primary text-decoration-underline d-block mb-2">
                            Lihat KTM
                        </a>
                    @endif
                @endif

                <input type="file"
                    class="form-control @error('ktm') is-invalid @enderror"
                    name="ktm"
                    accept="image/*,application/pdf">
                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah KTM</small>
                @error('ktm') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>


            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-primary bg-gradient-primary px-4">
                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
