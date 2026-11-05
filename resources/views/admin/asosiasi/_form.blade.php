@props(['asosiasi' => null])

<div class="row g-3">
    <div class="col-md-12">
        <label class="form-label fw-bold">Dosen <span class="text-danger">*</span></label>
        <select name="dosen_id" class="form-select @error('dosen_id') is-invalid @enderror" required>
            <option value="">Pilih Dosen</option>
            @foreach ($dosens as $dosen)
                <option value="{{ $dosen->id }}"
                    {{ old('dosen_id', $asosiasi->dosen_id ?? '') == $dosen->id ? 'selected' : '' }}>
                    {{ $dosen->nama }} ({{ $dosen->nidn }})
                </option>
            @endforeach
        </select>
        @error('dosen_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12">
        <label class="form-label fw-bold">Nama Asosiasi <span class="text-danger">*</span></label>
        <input type="text" name="nama_asosiasi" class="form-control @error('nama_asosiasi') is-invalid @enderror"
            value="{{ old('nama_asosiasi', $asosiasi->nama_asosiasi ?? '') }}" required>
        @error('nama_asosiasi')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-bold">Peran <span class="text-danger">*</span></label>
        <input type="text" name="peran" class="form-control @error('peran') is-invalid @enderror"
            value="{{ old('peran', $asosiasi->peran ?? '') }}" required>
        @error('peran')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-bold">Masa Aktif <span class="text-danger">*</span></label>
        <input type="date" name="masa_aktif" class="form-control @error('masa_aktif') is-invalid @enderror"
            value="{{ old('masa_aktif', isset($asosiasi) && $asosiasi->masa_aktif ? $asosiasi->masa_aktif->format('Y-m-d') : '') }}"
            required>
        @error('masa_aktif')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-bold">Tahun <span class="text-danger">*</span></label>
        <input type="number" name="tahun" class="form-control @error('tahun') is-invalid @enderror"
            value="{{ old('tahun', $asosiasi->tahun ?? date('Y')) }}" required>
        @error('tahun')
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
                    {{ old('academic_period_id', $asosiasi->academic_period_id ?? '') == $p->id ? 'selected' : '' }}>
                    {{ $p->nama_periode }}</option>
            @endforeach
        </select>
        @error('academic_period_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
