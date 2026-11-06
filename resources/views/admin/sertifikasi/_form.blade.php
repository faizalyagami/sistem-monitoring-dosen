@props(['sertifikasi' => null])
<div class="row g-3">
    <div class="col-md-12">
        <label class="form-label fw-bold">Dosen <span class="text-danger">*</span></label>
        <select name="dosen_id" class="form-select @error('dosen_id') is-invalid @enderror" required>
            <option value="">Pilih Dosen</option>
            @foreach ($dosens as $dosen)
                <option value="{{ $dosen->id }}"
                    {{ old('dosen_id', $sertifikasi->dosen_id ?? '') == $dosen->id ? 'selected' : '' }}>
                    {{ $dosen->nama }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-12">
        <label class="form-label fw-bold">Jenis Sertifikasi <span class="text-danger">*</span></label>
        <input type="text" name="jenis_sertifikasi"
            class="form-control @error('jenis_sertifikasi') is-invalid @enderror"
            value="{{ old('jenis_sertifikasi', $sertifikasi->jenis_sertifikasi ?? '') }}" required>
    </div>
    <div class="col-md-12">
        <label class="form-label fw-bold">Lembaga <span class="text-danger">*</span></label>
        <input type="text" name="lembaga_sertifikasi"
            class="form-control @error('lembaga_sertifikasi') is-invalid @enderror"
            value="{{ old('lembaga_sertifikasi', $sertifikasi->lembaga_sertifikasi ?? '') }}" required>
    </div>
    <div class="col-md-12">
        <label class="form-label fw-bold">No. Sertifikat <span class="text-danger">*</span></label>
        <input type="text" name="nomor_sertifikasi"
            class="form-control @error('nomor_sertifikasi') is-invalid @enderror"
            value="{{ old('nomor_sertifikasi', $sertifikasi->nomor_sertifikasi ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label fw-bold">Tanggal Sertifikasi <span class="text-danger">*</span></label>
        <input type="date" name="tanggal_sertifikasi" class="form-control"
            value="{{ old('tanggal_sertifikasi', isset($sertifikasi) && $sertifikasi->tanggal_sertifikasi ? $sertifikasi->tanggal_sertifikasi->format('Y-m-d') : '') }}"
            required>
    </div>
    <div class="col-md-6">
        <label class="form-label fw-bold">Valid Until</label>
        <input type="date" name="valid_until" class="form-control"
            value="{{ old('valid_until', isset($sertifikasi) && $sertifikasi->valid_until ? $sertifikasi->valid_until->format('Y-m-d') : '') }}">
    </div>
    <div class="col-md-12">
        <label class="form-label fw-bold">Periode Akademik <span class="text-danger">*</span></label>
        <select name="academic_period_id" class="form-select" required>
            @foreach ($periods as $p)
                <option value="{{ $p->id }}"
                    {{ old('academic_period_id', $sertifikasi->academic_period_id ?? '') == $p->id ? 'selected' : '' }}>
                    {{ $p->nama_periode }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-12">
        <label class="form-label fw-bold">File Sertifikat</label>
        @if (isset($sertifikasi) && $sertifikasi->file_sertifikat)
            <div class="mb-2"><a href="{{ route('admin.sertifikasi.download', $sertifikasi->id) }}"
                    class="btn btn-sm btn-info">File Saat Ini</a></div>
        @endif
        <input type="file" name="file_sertifikat" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
    </div>
</div>
