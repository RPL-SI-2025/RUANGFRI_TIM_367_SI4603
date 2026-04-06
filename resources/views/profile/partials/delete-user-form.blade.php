<div class="section-card mb-4">
    <div class="section-header">
        <div class="section-icon">
            <i class="fas fa-trash-alt"></i>
        </div>
        <div>
            <h5 class="section-title">Hapus Akun</h5>
            <p class="section-subtitle">Tindakan ini bersifat permanen</p>
        </div>
    </div>

    <div class="section-content">
        <div class="alert alert-danger alert-modern mb-4" role="alert">
            <div class="d-flex align-items-center">
                <div class="alert-icon me-3">
                    <i class="fa fa-exclamation-triangle"></i>
                </div>
                <div>
                    <strong>Peringatan</strong>
                    <p class="mb-0 mt-1">Setelah akun dihapus, semua data yang terkait akan terhapus permanen dan tidak dapat dikembalikan.</p>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <button class="btn btn-danger btn-lg" type="button" data-bs-toggle="collapse" data-bs-target="#deleteAccountSection" aria-expanded="false" aria-controls="deleteAccountSection">
                <i class="fas fa-trash-alt me-2"></i>Lanjut Hapus Akun
            </button>
        </div>

        <div class="collapse mt-3" id="deleteAccountSection">
            <div class="section-card">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <h5 class="section-title">Konfirmasi Penghapusan</h5>
                        <p class="section-subtitle">Masukkan password untuk melanjutkan</p>
                    </div>
                </div>
                <div class="section-content">
                    <form method="post" action="{{ route('mahasiswa.profile.delete') }}" class="mt-1">
                        @csrf
                        @method('delete')

                        <div class="form-group-modern">
                            <label for="delete_password" class="form-label-modern">
                                <i class="fas fa-lock me-2"></i>Password
                            </label>
                            <div class="input-group-modern">
                                <input id="delete_password" type="password"
                                       class="form-control form-control-modern @error('password') is-invalid @enderror"
                                       name="password"
                                       placeholder="Masukkan password Anda untuk konfirmasi" required>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="button" class="btn btn-secondary btn-lg" data-bs-toggle="collapse" data-bs-target="#deleteAccountSection">
                                <i class="fas fa-times me-1"></i>Batal
                            </button>
                            <button type="submit" class="btn btn-danger btn-lg">
                                <i class="fas fa-trash-alt me-1"></i>Hapus Permanen
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
