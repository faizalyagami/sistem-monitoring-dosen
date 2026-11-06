@props(['suratTugas' => null])

<div class="row g-3">
    <div class="col-md-12">
        <label class="form-label fw-bold">Nama Surat Tugas <span class="text-danger">*</span></label>
        <input type="text" name="nama_surat_tugas" class="form-control @error('nama_surat_tugas') is-invalid @enderror"
            value="{{ old('nama_surat_tugas', $suratTugas->nama_surat_tugas ?? '') }}"
            placeholder="Contoh: Surat Tugas Mengajar Semester Ganjil" required>
        @error('nama_surat_tugas')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12">
        <label class="form-label fw-bold">No. Surat Tugas <span class="text-danger">*</span></label>
        <input type="text" name="no_surat_tugas" class="form-control @error('no_surat_tugas') is-invalid @enderror"
            value="{{ old('no_surat_tugas', $suratTugas->no_surat_tugas ?? '') }}"
            placeholder="Contoh: ST/123/UNISBA/2024" required>
        @error('no_surat_tugas')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-bold">Tanggal Surat <span class="text-danger">*</span></label>
        <input type="date" name="tanggal_surat_tugas"
            class="form-control @error('tanggal_surat_tugas') is-invalid @enderror"
            value="{{ old('tanggal_surat_tugas', isset($suratTugas) && $suratTugas->tanggal_surat_tugas ? $suratTugas->tanggal_surat_tugas->format('Y-m-d') : '') }}"
            required>
        @error('tanggal_surat_tugas')
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
                    {{ old('academic_period_id', $suratTugas->academic_period_id ?? '') == $p->id ? 'selected' : '' }}>
                    {{ $p->nama_periode }}</option>
            @endforeach
        </select>
        @error('academic_period_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12">
        <label class="form-label fw-bold">Perihal</label>
        <textarea name="perihal" class="form-control @error('perihal') is-invalid @enderror" rows="3"
            placeholder="Deskripsi singkat tentang surat tugas ini">{{ old('perihal', $suratTugas->perihal ?? '') }}</textarea>
        @error('perihal')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12">
        <label class="form-label fw-bold">File Surat (PDF/DOC)</label>
        @if (isset($suratTugas) && $suratTugas->file_surat)
            <div class="mb-2">
                <a href="{{ route('dosen.surat-tugas.download', $suratTugas->id) }}" class="btn btn-sm btn-info">
                    <i class="bi bi-download"></i> File Saat Ini
                </a>
            </div>
            <small class="text-muted d-block mb-1">Kosongkan jika tidak ingin mengubah file.</small>
        @endif
        <input type="file" name="file_surat" class="form-control @error('file_surat') is-invalid @enderror"
            accept=".pdf,.doc,.docx">
        <small class="text-muted">Format: PDF, DOC, DOCX. Maks: 5MB</small>
        @error('file_surat')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
