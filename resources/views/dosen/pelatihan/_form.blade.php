@props(['pelatihan' => null])

<div class="row g-3">
    <div class="col-md-12">
        <label class="form-label fw-bold">Nama Pelatihan <span class="text-danger">*</span></label>
        <input type="text" name="nama_pelatihan" class="form-control @error('nama_pelatihan') is-invalid @enderror"
            value="{{ old('nama_pelatihan', $pelatihan->nama_pelatihan ?? '') }}" required>
        @error('nama_pelatihan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12">
        <label class="form-label fw-bold">Penyelenggara <span class="text-danger">*</span></label>
        <input type="text" name="penyelenggara" class="form-control @error('penyelenggara') is-invalid @enderror"
            value="{{ old('penyelenggara', $pelatihan->penyelenggara ?? '') }}" required>
        @error('penyelenggara')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-bold">Tanggal Pelatihan <span class="text-danger">*</span></label>
        <input type="date" name="tanggal_pelatihan"
            class="form-control @error('tanggal_pelatihan') is-invalid @enderror"
            value="{{ old('tanggal_pelatihan', isset($pelatihan) && $pelatihan->tanggal_pelatihan ? $pelatihan->tanggal_pelatihan->format('Y-m-d') : '') }}"
            required>
        @error('tanggal_pelatihan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-bold">Lokasi <span class="text-danger">*</span></label>
        <input type="text" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror"
            value="{{ old('lokasi', $pelatihan->lokasi ?? '') }}" required>
        @error('lokasi')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-bold">Tahun <span class="text-danger">*</span></label>
        <input type="number" name="tahun" class="form-control @error('tahun') is-invalid @enderror"
            value="{{ old('tahun', $pelatihan->tahun ?? date('Y')) }}" required>
        @error('tahun')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-bold">Durasi (Jam)</label>
        <input type="number" name="durasi" class="form-control @error('durasi') is-invalid @enderror"
            value="{{ old('durasi', $pelatihan->durasi ?? '') }}">
        @error('durasi')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12">
        <label class="form-label fw-bold">Periode Akademik <span class="text-danger">*</span></label>
        <select name="academic_period_id" class="form-select @error('academic_period_id') is-invalid @enderror"
            required>
            <option value="">Pilih Periode</option>
            @foreach ($periods as $p)
                <option value="{{ $p->id }}"
                    {{ old('academic_period_id', $pelatihan->academic_period_id ?? '') == $p->id ? 'selected' : '' }}>
                    {{ $p->nama_periode }}</option>
            @endforeach
        </select>
        @error('academic_period_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12">
        <label class="form-label fw-bold">File Sertifikat (PDF/JPG/PNG)</label>
        @if (isset($pelatihan) && $pelatihan->file_sertifikat)
            <div class="mb-2">
                <a href="{{ route('dosen.pelatihan.download', $pelatihan->id) }}" class="btn btn-sm btn-info">
                    <i class="bi bi-download"></i> File Saat Ini
                </a>
            </div>
            <small class="text-muted d-block mb-1">Kosongkan jika tidak ingin mengubah file.</small>
        @endif
        <input type="file" name="file_sertifikat" class="form-control @error('file_sertifikat') is-invalid @enderror"
            accept=".pdf,.jpg,.jpeg,.png">
        @error('file_sertifikat')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
