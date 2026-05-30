@extends('components.layouts.app')

@section('title', 'Tambah Penelitian')

@section('content')
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-plus-circle me-2"></i> Tambah Data Penelitian
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.riset.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label for="judul_riset" class="form-label fw-bold">
                                        Judul Penelitian <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="judul_riset" id="judul_riset"
                                        class="form-control @error('judul_riset') is-invalid @enderror"
                                        value="{{ old('judul_riset') }}" placeholder="Masukkan judul penelitian" required>
                                    @error('judul_riset')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="dosen_id" class="form-label fw-bold">
                                        Peneliti (Dosen) <span class="text-danger">*</span>
                                    </label>
                                    <select name="dosen_id" id="dosen_id"
                                        class="form-select @error('dosen_id') is-invalid @enderror" required>
                                        <option value="">Pilih Dosen</option>
                                        @foreach ($dosens as $dosen)
                                            <option value="{{ $dosen->id }}"
                                                {{ old('dosen_id') == $dosen->id ? 'selected' : '' }}>
                                                {{ $dosen->nama }} ({{ $dosen->nidn }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('dosen_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="academic_period_id" class="form-label fw-bold">
                                        Periode Akademik <span class="text-danger">*</span>
                                    </label>
                                    <select name="academic_period_id" id="academic_period_id"
                                        class="form-select @error('academic_period_id') is-invalid @enderror" required>
                                        <option value="">Pilih Periode</option>
                                        @foreach ($periods as $period)
                                            <option value="{{ $period->id }}"
                                                {{ old('academic_period_id') == $period->id ? 'selected' : '' }}
                                                {{ $period->is_active ? 'data-active="true"' : '' }}>
                                                {{ $period->nama_periode }}
                                                @if ($period->is_active)
                                                    (Aktif)
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('academic_period_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="bidang_riset" class="form-label fw-bold">
                                        Bidang Riset <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="bidang_riset" id="bidang_riset"
                                        class="form-control @error('bidang_riset') is-invalid @enderror"
                                        value="{{ old('bidang_riset') }}" placeholder="Contoh: Kecerdasan Buatan" required>
                                    @error('bidang_riset')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="jenis_riset" class="form-label fw-bold">
                                        Jenis Riset <span class="text-danger">*</span>
                                    </label>
                                    <select name="jenis_riset" id="jenis_riset"
                                        class="form-select @error('jenis_riset') is-invalid @enderror" required>
                                        <option value="">Pilih Jenis</option>
                                        <option value="Penelitian Dasar"
                                            {{ old('jenis_riset') == 'Penelitian Dasar' ? 'selected' : '' }}>Penelitian
                                            Dasar</option>
                                        <option value="Penelitian Terapan"
                                            {{ old('jenis_riset') == 'Penelitian Terapan' ? 'selected' : '' }}>Penelitian
                                            Terapan</option>
                                        <option value="Pengembangan"
                                            {{ old('jenis_riset') == 'Pengembangan' ? 'selected' : '' }}>Pengembangan
                                        </option>
                                    </select>
                                    @error('jenis_riset')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="sumber_dana" class="form-label fw-bold">
                                        Sumber Dana <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="sumber_dana" id="sumber_dana"
                                        class="form-control @error('sumber_dana') is-invalid @enderror"
                                        value="{{ old('sumber_dana') }}" placeholder="Contoh: DIKTI, Kemenristek, Industri"
                                        required>
                                    @error('sumber_dana')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="jumlah_dana" class="form-label fw-bold">
                                        Jumlah Dana (Rp) <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" name="jumlah_dana" id="jumlah_dana"
                                        class="form-control @error('jumlah_dana') is-invalid @enderror"
                                        value="{{ old('jumlah_dana') }}" placeholder="Masukkan jumlah dana" required>
                                    @error('jumlah_dana')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="tahun" class="form-label fw-bold">
                                        Tahun <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" name="tahun" id="tahun"
                                        class="form-control @error('tahun') is-invalid @enderror"
                                        value="{{ old('tahun', date('Y')) }}" min="2000" max="2100" required>
                                    @error('tahun')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="status" class="form-label fw-bold">
                                        Status <span class="text-danger">*</span>
                                    </label>
                                    <select name="status" id="status"
                                        class="form-select @error('status') is-invalid @enderror" required>
                                        <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif
                                        </option>
                                        <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label for="kolaborator" class="form-label fw-bold">Kolaborator</label>
                                    <input type="text" name="kolaborator" id="kolaborator"
                                        class="form-control @error('kolaborator') is-invalid @enderror"
                                        value="{{ old('kolaborator') }}"
                                        placeholder="Nama kolaborator (pisahkan dengan koma)">
                                    @error('kolaborator')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label for="publikasi_link" class="form-label fw-bold">Link Publikasi</label>
                                    <input type="url" name="publikasi_link" id="publikasi_link"
                                        class="form-control @error('publikasi_link') is-invalid @enderror"
                                        value="{{ old('publikasi_link') }}" placeholder="https://doi.org/...">
                                    @error('publikasi_link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label for="file_laporan" class="form-label fw-bold">File Laporan</label>
                                    <input type="file" name="file_laporan" id="file_laporan"
                                        class="form-control @error('file_laporan') is-invalid @enderror"
                                        accept=".pdf,.doc,.docx">
                                    <small class="text-muted">Format: PDF, DOC, DOCX. Maks: 5MB</small>
                                    @error('file_laporan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="mt-2" id="filePreview"></div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-1"></i> Simpan
                                </button>
                                <a href="{{ route('admin.riset.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-1"></i> Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Preview file name
        document.getElementById('file_laporan').addEventListener('change', function(e) {
            const preview = document.getElementById('filePreview');
            const fileName = e.target.files[0]?.name;
            if (fileName) {
                preview.innerHTML = `<div class="alert alert-info py-2">
                <i class="bi bi-file-earmark-pdf"></i> File siap diupload: ${fileName}
            </div>`;
            } else {
                preview.innerHTML = '';
            }
        });
    </script>
@endsection
