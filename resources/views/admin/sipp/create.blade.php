@extends('components.layouts.app')

@section('title', 'Tambah SIPP - Surat Izin Praktik Psikologi')

@section('content')
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-plus-circle me-2"></i> Tambah Surat Izin Praktik Psikologi (SIPP)
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.sipp.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label for="dosen_id" class="form-label fw-bold">
                                        Dosen <span class="text-danger">*</span>
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

                                <div class="col-md-12">
                                    <label for="no_registrasi" class="form-label fw-bold">
                                        No. Registrasi SIPP <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="no_registrasi" id="no_registrasi"
                                        class="form-control @error('no_registrasi') is-invalid @enderror"
                                        value="{{ old('no_registrasi') }}" required>
                                    @error('no_registrasi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label for="bidang_keilmuan" class="form-label fw-bold">
                                        Bidang Keilmuan <span class="text-danger">*</span>
                                    </label>
                                    <select name="bidang_keilmuan" id="bidang_keilmuan"
                                        class="form-select @error('bidang_keilmuan') is-invalid @enderror" required>
                                        <option value="">Pilih Bidang Keilmuan</option>
                                        <option value="Psikologi Klinis"
                                            {{ old('bidang_keilmuan') == 'Psikologi Klinis' ? 'selected' : '' }}>Psikologi
                                            Klinis</option>
                                        <option value="Psikologi Pendidikan"
                                            {{ old('bidang_keilmuan') == 'Psikologi Pendidikan' ? 'selected' : '' }}>
                                            Psikologi Pendidikan</option>
                                        <option value="Psikologi Industri dan Organisasi"
                                            {{ old('bidang_keilmuan') == 'Psikologi Industri dan Organisasi' ? 'selected' : '' }}>
                                            Psikologi Industri dan Organisasi</option>
                                        <option value="Psikologi Perkembangan"
                                            {{ old('bidang_keilmuan') == 'Psikologi Perkembangan' ? 'selected' : '' }}>
                                            Psikologi Perkembangan</option>
                                        <option value="Psikologi Sosial"
                                            {{ old('bidang_keilmuan') == 'Psikologi Sosial' ? 'selected' : '' }}>Psikologi
                                            Sosial</option>
                                        <option value="Psikologi Kognitif"
                                            {{ old('bidang_keilmuan') == 'Psikologi Kognitif' ? 'selected' : '' }}>
                                            Psikologi Kognitif</option>
                                    </select>
                                    @error('bidang_keilmuan')
                                        <div class->invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="tahun_terbit" class="form-label fw-bold">
                                        Tahun Terbit <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" name="tahun_terbit" id="tahun_terbit"
                                        class="form-control @error('tahun_terbit') is-invalid @enderror"
                                        value="{{ old('tahun_terbit', date('Y')) }}" required>
                                    @error('tahun_terbit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="penerbit" class="form-label fw-bold">
                                        Penerbit <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="penerbit" id="penerbit"
                                        class="form-control @error('penerbit') is-invalid @enderror"
                                        value="{{ old('penerbit') }}" required>
                                    @error('penerbit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="tanggal_terbit" class="form-label fw-bold">
                                        Tanggal Terbit <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" name="tanggal_terbit" id="tanggal_terbit"
                                        class="form-control @error('tanggal_terbit') is-invalid @enderror"
                                        value="{{ old('tanggal_terbit') }}" required>
                                    @error('tanggal_terbit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="tanggal_kadaluarsa" class="form-label fw-bold">
                                        Tanggal Kadaluarsa
                                    </label>
                                    <input type="date" name="tanggal_kadaluarsa" id="tanggal_kadaluarsa"
                                        class="form-control @error('tanggal_kadaluarsa') is-invalid @enderror"
                                        value="{{ old('tanggal_kadaluarsa') }}">
                                    @error('tanggal_kadaluarsa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Kosongkan jika tidak ada masa kadaluarsa</small>
                                </div>

                                <div class="col-md-12">
                                    <label for="status" class="form-label fw-bold">
                                        Status <span class="text-danger">*</span>
                                    </label>
                                    <select name="status" id="status"
                                        class="form-select @error('status') is-invalid @enderror" required>
                                        <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif
                                        </option>
                                        <option value="kadaluarsa" {{ old('status') == 'kadaluarsa' ? 'selected' : '' }}>
                                            Kadaluarsa</option>
                                        <option value="dicabut" {{ old('status') == 'dicabut' ? 'selected' : '' }}>Dicabut
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label for="keterangan" class="form-label fw-bold">Keterangan</label>
                                    <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror"
                                        rows="2">{{ old('keterangan') }}</textarea>
                                    @error('keterangan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Informasi tambahan tentang SIPP</small>
                                </div>

                                <div class="col-md-12">
                                    <label for="file_sipp" class="form-label fw-bold">File SIPP (PDF)</label>
                                    <input type="file" name="file_sipp" id="file_sipp"
                                        class="form-control @error('file_sipp') is-invalid @enderror" accept=".pdf">
                                    <small class="text-muted">Format: PDF. Maks: 2MB</small>
                                    @error('file_sipp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-1"></i> Simpan
                                </button>
                                <a href="{{ route('admin.sipp.index') }}" class="btn btn-secondary">
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
