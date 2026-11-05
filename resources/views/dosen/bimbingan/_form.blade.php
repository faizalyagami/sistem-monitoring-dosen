@props(['bimbingan' => null])

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label fw-bold">Jenis Bimbingan <span class="text-danger">*</span></label>
        <select name="jenis_bimbingan" class="form-select @error('jenis_bimbingan') is-invalid @enderror" required>
            <option value="">Pilih Jenis</option>
            <option value="skripsi"
                {{ old('jenis_bimbingan', $bimbingan->jenis_bimbingan ?? '') == 'skripsi' ? 'selected' : '' }}>Skripsi
            </option>
            <option value="tesis"
                {{ old('jenis_bimbingan', $bimbingan->jenis_bimbingan ?? '') == 'tesis' ? 'selected' : '' }}>Tesis
            </option>
            <option value="disertasi"
                {{ old('jenis_bimbingan', $bimbingan->jenis_bimbingan ?? '') == 'disertasi' ? 'selected' : '' }}>
                Disertasi</option>
        </select>
        @error('jenis_bimbingan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-bold">Kategori Bimbingan</label>
        <input type="text" name="kategori_bimbingan"
            class="form-control @error('kategori_bimbingan') is-invalid @enderror"
            value="{{ old('kategori_bimbingan', $bimbingan->kategori_bimbingan ?? '') }}"
            placeholder="Contoh: Pembimbing Utama">
        @error('kategori_bimbingan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-bold">Periode Akademik <span class="text-danger">*</span></label>
        <select name="academic_period_id" class="form-select @error('academic_period_id') is-invalid @enderror"
            required>
            <option value="">Pilih Periode</option>
            @foreach ($periods as $p)
                <option value="{{ $p->id }}"
                    {{ old('academic_period_id', $bimbingan->academic_period_id ?? '') == $p->id ? 'selected' : '' }}>
                    {{ $p->nama_periode }}</option>
            @endforeach
        </select>
        @error('academic_period_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-bold">Jumlah Mahasiswa <span class="text-danger">*</span></label>
        <input type="number" name="jumlah_mahasiswa"
            class="form-control @error('jumlah_mahasiswa') is-invalid @enderror"
            value="{{ old('jumlah_mahasiswa', $bimbingan->jumlah_mahasiswa ?? 1) }}" min="1" required>
        @error('jumlah_mahasiswa')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-bold">Semester <span class="text-danger">*</span></label>
        <select name="semester" class="form-select @error('semester') is-invalid @enderror" required>
            <option value="ganjil" {{ old('semester', $bimbingan->semester ?? '') == 'ganjil' ? 'selected' : '' }}>
                Ganjil</option>
            <option value="genap" {{ old('semester', $bimbingan->semester ?? '') == 'genap' ? 'selected' : '' }}>Genap
            </option>
        </select>
        @error('semester')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-bold">Tahun Akademik <span class="text-danger">*</span></label>
        <input type="number" name="tahun_akademik" class="form-control @error('tahun_akademik') is-invalid @enderror"
            value="{{ old('tahun_akademik', $bimbingan->tahun_akademik ?? date('Y')) }}" required>
        @error('tahun_akademik')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12 mt-4">
        <hr>
        <h6 class="fw-bold"><i class="bi bi-file-earmark-text"></i> Surat Keputusan (SK)</h6>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-bold">No. SK Pembimbing</label>
        <input type="text" name="no_sk_pembimbing"
            class="form-control @error('no_sk_pembimbing') is-invalid @enderror"
            value="{{ old('no_sk_pembimbing', $bimbingan->no_sk_pembimbing ?? '') }}">
        @error('no_sk_pembimbing')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-bold">Tanggal SK Pembimbing</label>
        <input type="date" name="tanggal_sk_pembimbing"
            class="form-control @error('tanggal_sk_pembimbing') is-invalid @enderror"
            value="{{ old('tanggal_sk_pembimbing', isset($bimbingan) && $bimbingan->tanggal_sk_pembimbing ? $bimbingan->tanggal_sk_pembimbing->format('Y-m-d') : '') }}">
        @error('tanggal_sk_pembimbing')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-bold">No. SK Penguji</label>
        <input type="text" name="no_sk_penguji" class="form-control @error('no_sk_penguji') is-invalid @enderror"
            value="{{ old('no_sk_penguji', $bimbingan->no_sk_penguji ?? '') }}">
        @error('no_sk_penguji')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-bold">Tanggal SK Penguji</label>
        <input type="date" name="tanggal_sk_penguji"
            class="form-control @error('tanggal_sk_penguji') is-invalid @enderror"
            value="{{ old('tanggal_sk_penguji', isset($bimbingan) && $bimbingan->tanggal_sk_penguji ? $bimbingan->tanggal_sk_penguji->format('Y-m-d') : '') }}">
        @error('tanggal_sk_penguji')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
