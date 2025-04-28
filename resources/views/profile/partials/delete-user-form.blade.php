<section>
    <div class="mt-2 text-muted">
        <p>Setelah akun Anda dihapus, semua data dan sumber daya yang berkaitan dengan akun tersebut akan terhapus secara permanen. Sebelum menghapus akun, harap unduh data atau informasi apa pun yang ingin Anda simpan.</p>
    </div>

    <button type="button" class="btn btn-danger mt-3" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
        <i class="fas fa-trash-alt me-2"></i>Hapus Akun
    </button>

    <!-- Modal Konfirmasi Hapus Akun -->
    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="deleteAccountModalLabel">Konfirmasi Hapus Akun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus akun? Tindakan ini tidak dapat dibatalkan dan semua data Anda akan dihapus secara permanen.</p>
                    
                    <form method="post" action="{{ route('mahasiswa.profile.delete') }}" id="delete-account-form" class="mt-3">
                        @csrf
                        @method('delete')
                        
                        <div class="mb-3">
                            <label for="password" class="form-label fw-medium">Password</label>
                            <input type="password" class="form-control" id="password" name="password" 
                                   placeholder="Masukkan password Anda untuk konfirmasi" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" 
                            onclick="document.getElementById('delete-account-form').submit();">
                        Hapus Akun
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>