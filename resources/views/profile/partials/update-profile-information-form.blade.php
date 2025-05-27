<section>
    <form method="post" action="{{ route('mahasiswa.profile.update') }}" enctype="multipart/form-data" class="mt-3">
        @csrf
        @method('patch')

        {{-- FOTO PROFIL --}}
        <div class="mb-4">
            <label class="block mb-1">Foto Profil</label>
            <div class="flex items-center space-x-4">
                @if(Auth::user()->profile_photo)
                    <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile" class="w-20 h-20 rounded-full object-cover">
                @else
                    <i class="bi bi-person-circle text-6xl text-gray-400"></i>
                @endif
                <input type="file" name="profile_photo" accept="image/*">
                @if(Auth::user()->profile_photo)
                    <button type="submit" name="delete_photo" value="1" class="text-red-600 hover:underline" onclick="return confirm('Yakin ingin menghapus foto profil?')">Hapus Foto</button>
                @endif
            </div>
        </div>

        {{-- DATA PRIBADI --}}
        <div class="mb-3">
            <label for="nama_mahasiswa" class="form-label fw-medium">Nama Lengkap</label>
            <input type="text" class="form-control @error('nama_mahasiswa') is-invalid @enderror"
                name="nama_mahasiswa" value="{{ old('nama_mahasiswa', Auth::user()->nama_mahasiswa) }}" placeholder="Nama lengkap" required>
            @error('nama_mahasiswa') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="nim" class="form-label fw-medium">NIM</label>
            <input type="text" class="form-control" value="{{ Auth::user()->nim }}" disabled>
            <small class="text-muted">NIM tidak dapat diubah.</small>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label fw-medium">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror"
                name="email" value="{{ old('email', Auth::user()->email) }}" placeholder="example@mail.com" required>
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label>Tempat Lahir</label>
                <input type="text" name="tempat_lahir" class="input" placeholder="Bandung"
                       value="{{ old('tempat_lahir', Auth::user()->tempat_lahir) }}">
            </div>
            <div>
                <label>Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" class="input"
                       value="{{ old('tanggal_lahir', Auth::user()->tanggal_lahir) }}">
            </div>
            <div>
                <label>No. WhatsApp</label>
                <input type="text" name="no_wa" class="input" placeholder="08xxxxxxxxxx"
                       value="{{ old('no_wa', Auth::user()->no_wa) }}">
            </div>
            <div>
                <label>Alamat di Bandung</label>
                <input type="text" name="alamat_bdg" class="input" placeholder="Jl. Contoh No. 10"
                       value="{{ old('alamat_bdg', Auth::user()->alamat_bdg) }}">
            </div>
            <div>
                <label>Tahun Angkatan</label>
                <input type="text" name="angkatan" class="input" placeholder="2021"
                       value="{{ old('angkatan', Auth::user()->angkatan) }}">
            </div>
        </div>

        {{-- INFORMASI PEMINJAMAN --}}
        <div class="mt-6">
            <h2 class="font-bold mb-2">Informasi Peminjaman</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label>Tujuan Peminjaman</label>
                    <input type="text" name="tujuan" class="input" placeholder="Untuk kegiatan organisasi..."
                           value="{{ old('tujuan', Auth::user()->tujuan) }}">
                </div>
                <div>
                    <label>Nama Organisasi/Instansi</label>
                    <input type="text" name="instansi" class="input" placeholder="BEM/UKM/HMJ"
                           value="{{ old('instansi', Auth::user()->instansi) }}">
                </div>
            </div>
        </div>

        {{-- UPLOAD KTM --}}
        <div class="mt-6">
            <label>Upload KTM <span class="text-red-600">*</span></label>
            @if(!Auth::user()->ktm)
                <div class="text-red-500 text-sm">Belum upload KTM</div>
            @endif
            <input type="file" name="ktm" accept="image/*,application/pdf" required>
            @if(Auth::user()->ktm)
                <a href="{{ asset('storage/' . Auth::user()->ktm) }}" target="_blank" class="text-blue-600 underline mt-2 block">Lihat KTM</a>
            @endif
        </div>

        {{-- SUBMIT --}}
        <div class="d-flex justify-content-end mt-4">
            <button type="submit" class="btn btn-primary px-4">
                <i class="fas fa-save me-2"></i>Simpan Perubahan
            </button>
        </div>
    </form>
</section>
