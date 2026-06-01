@extends('components.layouts.app')

@section('title', 'Tambah PKM')

@section('content')
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-plus-circle me-2"></i> Tambah Data PKM
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('dosen.pkm.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label for="judul_pkm" class="form-label fw-bold">
                                        Judul PKM <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="judul_pkm" id="judul_pkm"
                                        class="form-control @error('judul_pkm') is-invalid @enderror"
                                        value="{{ old('judul_pkm') }}" required>
                                    @error('judul_pkm')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="bidang_pkm" class="form-label fw-bold">
                                        Bidang PKM <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="bidang_pkm" id="bidang_pkm"
                                        class="form-control @error('bidang_pkm') is-invalid @enderror"
                                        value="{{ old('bidang_pkm') }}" required>
                                    @error('bidang_pkm')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="jenis_pkm" class="form-label fw-bold">
                                        Jenis PKM <span class="text-danger">*</span>
                                    </label>
                                    <select name="jenis_pkm" id="jenis_pkm"
                                        class="form-select @error('jenis_pkm') is-invalid @enderror" required>
                                        <option value="">Pilih Jenis</option>
                                        <option value="Pengabdian" {{ old('jenis_pkm') == 'Pengabdian' ? 'selected' : '' }}>
                                            Pengabdian</option>
                                        <option value="Pelatihan" {{ old('jenis_pkm') == 'Pelatihan' ? 'selected' : '' }}>
                                            Pelatihan</option>
                                        <option value="Penyuluhan" {{ old('jenis_pkm') == 'Penyuluhan' ? 'selected' : '' }}>
                                            Penyuluhan</option>
                                        <option value="Pendampingan"
                                            {{ old('jenis_pkm') == 'Pendampingan' ? 'selected' : '' }}>Pendampingan</option>
                                    </select>
                                    @error('jenis_pkm')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="sumber_dana" class="form-label fw-bold">
                                        Sumber Dana <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="sumber_dana" id="sumber_dana"
                                        class="form-control @error('sumber_dana') is-invalid @enderror"
                                        value="{{ old('sumber_dana') }}" required>
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
                                        value="{{ old('jumlah_dana') }}" required>
                                    @error('jumlah_dana')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="lokasi_kegiatan" class="form-label fw-bold">
                                        Lokasi Kegiatan <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="lokasi_kegiatan" id="lokasi_kegiatan"
                                        class="form-control @error('lokasi_kegiatan') is-invalid @enderror"
                                        value="{{ old('lokasi_kegiatan') }}" required>
                                    @error('lokasi_kegiatan')
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
                                                {{ old('academic_period_id') == $period->id ? 'selected' : '' }}>
                                                {{ $period->nama_periode }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('academic_period_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="tahun" class="form-label fw-bold">
                                        Tahun <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" name="tahun" id="tahun"
                                        class="form-control @error('tahun') is-invalid @enderror"
                                        value="{{ old('tahun', date('Y')) }}" required>
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
                                    <label for="publikasi_link" class="form-label fw-bold">Link Publikasi</label>
                                    <input type="url" name="publikasi_link" id="publikasi_link"
                                        class="form-control @error('publikasi_link') is-invalid @enderror"
                                        value="{{ old('publikasi_link') }}">
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
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-1"></i> Simpan
                                </button>
                                <a href="{{ route('dosen.pkm.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-1"></i> Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
