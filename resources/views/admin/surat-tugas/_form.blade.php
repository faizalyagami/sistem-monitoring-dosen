@props(['suratTugas' => null])
<div class="row g-3">
    <div class="col-md-12">
        <label class="form-label fw-bold">Dosen <span class="text-danger">*</span></label>
        <select name="dosen_id" class="form-select" required>
            @foreach ($dosens as $dosen)
                <option value="{{ $dosen->id }}"
                    {{ old('dosen_id', $suratTugas->dosen_id ?? '') == $dosen->id ? 'selected' : '' }}>
                    {{ $dosen->nama }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-12">
        <label class="form-label fw-bold">Nama Surat Tugas <span class="text-danger">*</span></label>
        <input type="text" name="nama_surat_tugas" class="form-control"
            value="{{ old('nama_surat_tugas', $suratTugas->nama_surat_tugas ?? '') }}" required>
    </div>
    <div class="col-md-12">
        <label class="form-label fw-bold">No. Surat Tugas <span class="text-danger">*</span></label>
        <input type="text" name="no_surat_tugas" class="form-control"
            value="{{ old('no_surat_tugas', $suratTugas->no_surat_tugas ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label fw-bold">Tanggal Surat <span class="text-danger">*</span></label>
        <input type="date" name="tanggal_surat_tugas" class="form-control"
            value="{{ old('tanggal_surat_tugas', isset($suratTugas) && $suratTugas->tanggal_surat_tugas ? $suratTugas->tanggal_surat_tugas->format('Y-m-d') : '') }}"
            required>
    </div>
    <div class="col-md-6">
        <label class="form-label fw-bold">Periode Akademik <span class="text-danger">*</span></label>
        <select name="academic_period_id" class="form-select" required>
            @foreach ($periods as $p)
                <option value="{{ $p->id }}"
                    {{ old('academic_period_id', $suratTugas->academic_period_id ?? '') == $p->id ? 'selected' : '' }}>
                    {{ $p->nama_periode }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-12">
        <label class="form-label fw-bold">Perihal</label>
        <textarea name="perihal" class="form-control">{{ old('perihal', $suratTugas->perihal ?? '') }}</textarea>
    </div>
    <div class="col-md-12">
        <label class="form-label fw-bold">File Surat (PDF/DOC)</label>
        @if (isset($suratTugas) && $suratTugas->file_surat)
            <div class="mb-2"><a href="{{ route('admin.surat-tugas.download', $suratTugas->id) }}"
                    class="btn btn-sm btn-info">File Saat Ini</a></div>
        @endif
        <input type="file" name="file_surat" class="form-control" accept=".pdf,.doc,.docx">
    </div>
</div>
