<div class="section-card mb-4">
    <div class="section-header">
        <div class="section-icon">
            <i class="fa fa-user"></i>
        </div>
        <div>
            <h5 class="section-title">Informasi Profil</h5>
            <p class="section-subtitle">Lengkapi data diri Anda</p>
        </div>
    </div>

    <div class="section-content">
        <form method="post" action="{{ route('mahasiswa.profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group-modern">
                        <label for="nim" class="form-label-modern">
                            <i class="fa fa-id-card me-2"></i>NIM
                        </label>
                        <div class="input-group-modern">
                            <input id="nim" type="text" readonly
                                   class="form-control form-control-modern bg-light @error('nim') is-invalid @enderror"
                                   name="nim" value="{{ old('nim', $user?->nim) }}"
                                   placeholder="NIM">
                        </div>
                        @error('nim') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group-modern">
                        <label for="nama_mahasiswa" class="form-label-modern">
                            <i class="fa fa-user me-2"></i>Nama Lengkap
                        </label>
                        <div class="input-group-modern">
                            <input id="nama_mahasiswa" type="text" readonly
                                   class="form-control form-control-modern bg-light @error('nama_mahasiswa') is-invalid @enderror"
                                   name="nama_mahasiswa" value="{{ old('nama_mahasiswa', $user?->nama_mahasiswa) }}"
                                   placeholder="Nama lengkap">
                        </div>
                        @error('nama_mahasiswa') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group-modern">
                        <label for="email" class="form-label-modern">
                            <i class="fa fa-envelope me-2"></i>Email
                        </label>
                        <div class="input-group-modern">
                            <input id="email" type="email" readonly
                                   class="form-control form-control-modern bg-light @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email', $user?->email) }}"
                                   placeholder="Email">
                        </div>
                        @error('email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group-modern">
                        <label for="wa" class="form-label-modern">
                            <i class="fab fa-whatsapp me-2"></i>No. WhatsApp
                        </label>
                        <div class="input-group-modern">
                            <input id="wa" type="text"
                                   class="form-control form-control-modern @error('wa') is-invalid @enderror"
                                   name="wa" value="{{ old('wa', $user?->wa) }}"
                                   placeholder="Contoh: 08xxxxxxxxxx">
                        </div>
                        @error('wa') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group-modern">
                        <label for="tempat_lahir" class="form-label-modern">
                            <i class="fa fa-map-marker-alt me-2"></i>Tempat Lahir
                        </label>
                        <div class="input-group-modern">
                            <input id="tempat_lahir" type="text"
                                   class="form-control form-control-modern @error('tempat_lahir') is-invalid @enderror"
                                   name="tempat_lahir" value="{{ old('tempat_lahir', $user?->tempat_lahir) }}"
                                   placeholder="Tempat lahir">
                        </div>
                        @error('tempat_lahir') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group-modern">
                        <label for="tanggal_lahir" class="form-label-modern">
                            <i class="fa fa-calendar me-2"></i>Tanggal Lahir
                        </label>
                        <div class="input-group-modern">
                            <input id="tanggal_lahir" type="date"
                                   class="form-control form-control-modern @error('tanggal_lahir') is-invalid @enderror"
                                   name="tanggal_lahir" value="{{ old('tanggal_lahir', $user?->tanggal_lahir) }}">
                        </div>
                        @error('tanggal_lahir') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <div class="form-group-modern">
                <label for="alamat" class="form-label-modern">
                    <i class="fa fa-home me-2"></i>Alamat
                </label>
                <div class="input-group-modern">
                    <textarea id="alamat" rows="3"
                              class="form-control form-control-modern @error('alamat') is-invalid @enderror"
                              name="alamat"
                              placeholder="Alamat lengkap">{{ old('alamat', $user?->alamat) }}</textarea>
                </div>
                @error('alamat') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>

            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
