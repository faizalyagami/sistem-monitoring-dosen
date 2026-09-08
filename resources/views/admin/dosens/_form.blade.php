@props(['dosen' => null])

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="nidn" class="form-label fw-bold">
                NIDN <span class="text-danger">*</span>
            </label>
            <input type="text" name="nidn" id="nidn" class="form-control @error('nidn') is-invalid @enderror"
                value="{{ old('nidn', $dosen->nidn ?? '') }}" required>
            @error('nidn')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="nik" class="form-label fw-bold">
                NIK <span class="text-danger">*</span>
            </label>
            <input type="text" name="nik" id="nik" class="form-control @error('nik') is-invalid @enderror"
                value="{{ old('nik', $dosen->nik ?? '') }}" required>
            @error('nik')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="nama" class="form-label fw-bold">
                Nama Lengkap <span class="text-danger">*</span>
            </label>
            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror"
                value="{{ old('nama', $dosen->nama ?? '') }}" required>
            @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="email" class="form-label fw-bold">
                Email <span class="text-danger">*</span>
            </label>
            <input type="email" name="email" id="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email', $dosen->email ?? '') }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="status" class="form-label fw-bold">
                Status <span class="text-danger">*</span>
            </label>
            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                <option value="">Pilih Status</option>
                <option value="tetap" {{ old('status', $dosen->status ?? '') == 'tetap' ? 'selected' : '' }}>Tetap
                </option>
                <option value="kontrak" {{ old('status', $dosen->status ?? '') == 'kontrak' ? 'selected' : '' }}>Kontrak
                </option>
                <option value="luar_biasa" {{ old('status', $dosen->status ?? '') == 'luar_biasa' ? 'selected' : '' }}>
                    Luar Biasa</option>
                <option value="pensiun" {{ old('status', $dosen->status ?? '') == 'pensiun' ? 'selected' : '' }}>
                    Pensiun</option>
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="pendidikan_terakhir" class="form-label fw-bold">
                Pendidikan Terakhir <span class="text-danger">*</span>
            </label>
            <select name="pendidikan_terakhir" id="pendidikan_terakhir"
                class="form-select @error('pendidikan_terakhir') is-invalid @enderror" required>
                <option value="">Pilih Pendidikan</option>
                <option value="S1"
                    {{ old('pendidikan_terakhir', $dosen->pendidikan_terakhir ?? '') == 'S1' ? 'selected' : '' }}>S1
                </option>
                <option value="S2"
                    {{ old('pendidikan_terakhir', $dosen->pendidikan_terakhir ?? '') == 'S2' ? 'selected' : '' }}>S2
                </option>
                <option value="S3"
                    {{ old('pendidikan_terakhir', $dosen->pendidikan_terakhir ?? '') == 'S3' ? 'selected' : '' }}>S3
                </option>
            </select>
            @error('pendidikan_terakhir')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="jabatan_fungsional" class="form-label fw-bold">
                Jabatan Fungsional <span class="text-danger">*</span>
            </label>
            <input type="text" name="jabatan_fungsional" id="jabatan_fungsional"
                class="form-control @error('jabatan_fungsional') is-invalid @enderror"
                value="{{ old('jabatan_fungsional', $dosen->jabatan_fungsional ?? '') }}" required>
            @error('jabatan_fungsional')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="inpassing" class="form-label fw-bold">
                Inpassing <span class="text-danger">*</span>
            </label>
            <input type="text" name="inpassing" id="inpassing"
                class="form-control @error('inpassing') is-invalid @enderror"
                value="{{ old('inpassing', $dosen->inpassing ?? '') }}" required>
            @error('inpassing')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="kepangkatan" class="form-label fw-bold">
                Kepangkatan <span class="text-danger">*</span>
            </label>
            <input type="text" name="kepangkatan" id="kepangkatan"
                class="form-control @error('kepangkatan') is-invalid @enderror"
                value="{{ old('kepangkatan', $dosen->kepangkatan ?? '') }}" required>
            @error('kepangkatan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-12">
        <div class="mb-3">
            <label for="photo" class="form-label fw-bold">Foto</label>
            @if (isset($dosen) && $dosen->photo)
                <div class="mb-2">
                    <img src="{{ $dosen->photo_url }}" class="img-thumbnail" width="150" alt="Current photo">
                    <small class="d-block text-muted">Foto saat ini</small>
                </div>
            @endif
            <input type="file" name="photo" id="photo"
                class="form-control @error('photo') is-invalid @enderror" accept="image/*">
            <small class="text-muted">Format: JPG, JPEG, PNG. Maks: 2MB</small>
            <div id="photoPreview" class="mt-2"></div>
            @error('photo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

@push('scripts')
    <script>
        // Preview image before upload
        document.getElementById('photo')?.addEventListener('change', function(e) {
            const preview = document.getElementById('photoPreview');
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    preview.innerHTML = `<img src="${event.target.result}" class="img-thumbnail" width="150">`;
                };
                reader.readAsDataURL(e.target.files[0]);
            } else {
                preview.innerHTML = '';
            }
        });
    </script>
@endpush
