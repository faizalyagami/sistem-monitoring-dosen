@props(['sipp' => null])
<div class="row g-3">
    <div class="col-md-12">
        <label class="form-label fw-bold">Dosen <span class="text-danger">*</span></label>
        <select name="dosen_id" class="form-select @error('dosen_id') is-invalid @enderror" required>
            <option value="">Pilih Dosen</option>
            @foreach ($dosens as $dosen)
                <option value="{{ $dosen->id }}"
                    {{ old('dosen_id', $sipp->dosen_id ?? '') == $dosen->id ? 'selected' : '' }}>{{ $dosen->nama }}
                </option>
            @endforeach
        </select>
        @error('dosen_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-12">
        <label class="form-label fw-bold">No. Registrasi <span class="text-danger">*</span></label>
        <input type="text" name="no_registrasi" class="form-control @error('no_registrasi') is-invalid @enderror"
            value="{{ old('no_registrasi', $sipp->no_registrasi ?? '') }}" required>
        @error('no_registrasi')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-12">
        <label class="form-label fw-bold">Bidang Keilmuan <span class="text-danger">*</span></label>
        <input type="text" name="bidang_keilmuan" class="form-control @error('bidang_keilmuan') is-invalid @enderror"
            value="{{ old('bidang_keilmuan', $sipp->bidang_keilmuan ?? '') }}" required>
        @error('bidang_keilmuan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label fw-bold">Tahun Terbit <span class="text-danger">*</span></label>
        <input type="number" name="tahun_terbit" class="form-control @error('tahun_terbit') is-invalid @enderror"
            value="{{ old('tahun_terbit', $sipp->tahun_terbit ?? date('Y')) }}" required>
        @error('tahun_terbit')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
            <option value="aktif" {{ old('status', $sipp->status ?? '') == 'aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="tidak_aktif" {{ old('status', $sipp->status ?? '') == 'tidak_aktif' ? 'selected' : '' }}>
                Tidak Aktif</option>
        </select>
        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-12">
        <label class="form-label fw-bold">File SIPP (PDF/JPG/PNG)</label>
        @if (isset($sipp) && $sipp->file_sipp)
            <div class="mb-2"><a href="{{ route('admin.sipp.download', $sipp->id) }}" class="btn btn-sm btn-info"><i
                        class="bi bi-download"></i> File Saat Ini</a></div>
        @endif
        <input type="file" name="file_sipp" class="form-control @error('file_sipp') is-invalid @enderror"
            accept=".pdf,.jpg,.jpeg,.png">
        @error('file_sipp')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
