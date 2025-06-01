<section>
    <div class="mt-2 text-muted">
        <p>Setelah akun Anda dihapus, semua data dan sumber daya yang berkaitan dengan akun tersebut akan terhapus secara permanen. Sebelum menghapus akun, harap unduh data atau informasi apa pun yang ingin Anda simpan.</p>
    </div>

    <button type="button" class="btn btn-danger mt-3" id="toggleDeleteSection">
        <i class="fas fa-trash-alt me-2"></i>Hapus Akun
    </button>

    <!-- Collapsible Delete Account Section -->
    <div id="deleteAccountSection" style="display: none; margin-top: 1rem;">
        <div class="card border-danger mt-3">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">
                    <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus Akun
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    <p class="mb-0"><strong>Peringatan:</strong> Tindakan ini tidak dapat dibatalkan. Semua data Anda akan dihapus secara permanen.</p>
                </div>
                
                <form method="post" action="{{ route('mahasiswa.profile.delete') }}" id="delete-account-form" class="mt-3">
                    @csrf
                    @method('delete')
                    
                    <div class="mb-3">
                        <label for="delete-password" class="form-label fw-medium">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-lock text-secondary"></i>
                            </span>
                            <input type="password" class="form-control border-start-0" id="delete-password" name="password" 
                                   placeholder="Masukkan password Anda untuk konfirmasi" required>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" class="btn btn-secondary me-2" id="cancelDelete">
                            <i class="fas fa-times me-1"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt me-1"></i>Hapus Akun
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('toggleDeleteSection');
    const cancelBtn = document.getElementById('cancelDelete');
    const deleteSection = document.getElementById('deleteAccountSection');
    
    toggleBtn.addEventListener('click', function() {
        deleteSection.style.display = 'block';
        toggleBtn.style.display = 'none';
        

        deleteSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
    });
    
    cancelBtn.addEventListener('click', function() {
        deleteSection.style.display = 'none';
        toggleBtn.style.display = 'inline-block';
        

        document.getElementById('delete-password').value = '';
        

        toggleBtn.scrollIntoView({ behavior: 'smooth', block: 'center' });
    });
});
</script>

<style>
#deleteAccountSection {
    transition: all 0.3s ease;
    overflow: hidden;
}
.card-header.bg-danger {
    background-color: #dc3545 !important;
}
</style>