<div class="section-card mb-4">
    <div class="section-header">
        <div class="section-icon">
            <i class="fa fa-book"></i>
        </div>
        <div>
            <h5 class="section-title">Informasi Peminjaman</h5>
            <p class="section-subtitle">Data ini akan membantu proses peminjaman</p>
        </div>
    </div>

    <div class="section-content">
        <form method="post" action="{{ route('mahasiswa.profile.updateBorrowingInfo') }}" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group-modern">
                        <label for="angkatan" class="form-label-modern">
                            <i class="fa fa-graduation-cap me-2"></i>Angkatan
                        </label>
                        <div class="input-group-modern">
                            <input id="angkatan" type="text"
                                   class="form-control form-control-modern @error('angkatan') is-invalid @enderror"
                                   name="angkatan"
                                   value="{{ old('angkatan', $user?->angkatan) }}"
                                   placeholder="Contoh: 2022"
                                   required>
                        </div>
                        @error('angkatan') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group-modern">
                        <label for="instansi" class="form-label-modern">
                            <i class="fa fa-building me-2"></i>Nama Organisasi/Instansi
                        </label>
                        <div class="input-group-modern">
                            <input id="instansi" type="text"
                                   class="form-control form-control-modern @error('instansi') is-invalid @enderror"
                                   name="instansi"
                                   value="{{ old('instansi', $user?->instansi) }}"
                                   placeholder="Contoh: Himpunan Mahasiswa"
                                   required>
                        </div>
                        @error('instansi') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <div class="form-group-modern">
                <label for="tujuan" class="form-label-modern">
                    <i class="fa fa-bullseye me-2"></i>Tujuan Peminjaman
                </label>
                <div class="input-group-modern">
                    <input id="tujuan" type="text"
                           class="form-control form-control-modern @error('tujuan') is-invalid @enderror"
                           name="tujuan"
                           value="{{ old('tujuan', $user?->tujuan) }}"
                           placeholder="Contoh: Kegiatan Workshop"
                           required>
                </div>
                @error('tujuan') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>

            <div class="form-group-modern">
                <label for="ktm" class="form-label-modern">
                    <i class="fa fa-id-badge me-2"></i>Upload KTM
                </label>

                @if ($user?->ktm)
                    @php
                        $fileExtension = pathinfo($user->ktm, PATHINFO_EXTENSION);
                    @endphp
                    <div class="current-file mb-3">
                        <div class="mb-2 fw-semibold">KTM saat ini</div>
                        @if (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'webp']))
                            <img src="{{ asset('storage/' . $user->ktm) }}" alt="Kartu Tanda Mahasiswa"
                                 class="img-fluid rounded border shadow-sm" style="max-width: 260px;">
                        @elseif (strtolower($fileExtension) === 'pdf')
                            <iframe src="{{ asset('storage/' . $user->ktm) }}"
                                    width="100%" height="360" class="border rounded shadow-sm"></iframe>
                        @else
                            <a href="{{ asset('storage/' . $user->ktm) }}" target="_blank"
                               class="text-decoration-underline">Lihat KTM</a>
                        @endif
                    </div>
                @endif

                <div class="file-upload-area">
                    <div class="upload-box">
                        <div class="upload-icon">
                            <i class="fa fa-cloud-upload"></i>
                        </div>
                        <div class="upload-content">
                            <h6>Upload KTM (Opsional)</h6>
                            <p>Format: PDF, JPG, PNG (Max: 2MB)</p>
                            <input id="ktm" type="file"
                                   class="form-control-file @error('ktm') is-invalid @enderror"
                                   name="ktm"
                                   accept="image/*,application/pdf">
                            <small class="file-info">Biarkan kosong jika tidak ingin mengubah KTM</small>
                        </div>
                    </div>
                </div>
                @error('ktm') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>

            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
