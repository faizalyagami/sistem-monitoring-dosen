@props(['sertifikasi' => null])

<div class="row g-3">
    <div class="col-md-12">
        <label class="form-label fw-bold">Jenis Sertifikasi <span class="text-danger">*</span></label>
        <input type="text" name="jenis_sertifikasi"
            class="form-control @error('jenis_sertifikasi') is-invalid @enderror"
            value="{{ old('jenis_sertifikasi', $sertifikasi->jenis_sertifikasi ?? '') }}" required>
        @error('jenis_sertifikasi')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12">
        <label class="form-label fw-bold">Lembaga Sertifikasi <span class="text-danger">*</span></label>
        <input type="text" name="lembaga_sertifikasi"
            class="form-control @error('lembaga_sertifikasi') is-invalid @enderror"
            value="{{ old('lembaga_sertifikasi', $sertifikasi->lembaga_sertifikasi ?? '') }}" required>
        @error('lembaga_sertifikasi')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12">
        <label class="form-label fw-bold">Nomor Sertifikat <span class="text-danger">*</span></label>
        <input type="text" name="nomor_sertifikasi"
            class="form-control @error('nomor_sertifikasi') is-invalid @enderror"
            value="{{ old('nomor_sertifikasi', $sertifikasi->nomor_sertifikasi ?? '') }}" required>
        @error('nomor_sertifikasi')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-bold">Tanggal Sertifikasi <span class="text-danger">*</span></label>
        <input type="date" name="tanggal_sertifikasi"
            class="form-control @error('tanggal_sertifikasi') is-invalid @enderror"
            value="{{ old('tanggal_sertifikasi', isset($sertifikasi) && $sertifikasi->tanggal_sertifikasi ? $sertifikasi->tanggal_sertifikasi->format('Y-m-d') : '') }}"
            required>
        @error('tanggal_sertifikasi')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-bold">Valid Until</label>
        <input type="date" name="valid_until" class="form-control @error('valid_until') is-invalid @enderror"
            value="{{ old('valid_until', isset($sertifikasi) && $sertifikasi->valid_until ? $sertifikasi->valid_until->format('Y-m-d') : '') }}">
        @error('valid_until')
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
                    {{ old('academic_period_id', $sertifikasi->academic_period_id ?? '') == $p->id ? 'selected' : '' }}>
                    {{ $p->nama_periode }}</option>
            @endforeach
        </select>
        @error('academic_period_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12">
        <label class="form-label fw-bold">File Sertifikat (PDF/JPG/PNG)</label>
        @if (isset($sertifikasi) && $sertifikasi->file_sertifikat)
            <div class="mb-2">
                <a href="{{ route('dosen.sertifikasi.download', $sertifikasi->id) }}" class="btn btn-sm btn-info">
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
