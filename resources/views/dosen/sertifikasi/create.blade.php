@extends('components.layouts.app')

@section('title', 'Tambah Sertifikasi')

@section('content')
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-plus-circle me-2"></i> Tambah Sertifikasi
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('dosen.sertifikasi.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label for="jenis_sertifikasi" class="form-label fw-bold">
                                        Jenis Sertifikasi <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="jenis_sertifikasi" id="jenis_sertifikasi"
                                        class="form-control @error('jenis_sertifikasi') is-invalid @enderror"
                                        value="{{ old('jenis_sertifikasi') }}" required>
                                    @error('jenis_sertifikasi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label for="lembaga_sertifikasi" class="form-label fw-bold">
                                        Lembaga Sertifikasi <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="lembaga_sertifikasi" id="lembaga_sertifikasi"
                                        class="form-control @error('lembaga_sertifikasi') is-invalid @enderror"
                                        value="{{ old('lembaga_sertifikasi') }}" required>
                                    @error('lembaga_sertifikasi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label for="nomor_sertifikasi" class="form-label fw-bold">
                                        Nomor Sertifikat <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="nomor_sertifikasi" id="nomor_sertifikasi"
                                        class="form-control @error('nomor_sertifikasi') is-invalid @enderror"
                                        value="{{ old('nomor_sertifikasi') }}" required>
                                    @error('nomor_sertifikasi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="tanggal_sertifikasi" class="form-label fw-bold">
                                        Tanggal Sertifikasi <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" name="tanggal_sertifikasi" id="tanggal_sertifikasi"
                                        class="form-control @error('tanggal_sertifikasi') is-invalid @enderror"
                                        value="{{ old('tanggal_sertifikasi') }}" required>
                                    @error('tanggal_sertifikasi')
                                        <div class->invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="valid_until" class="form-label fw-bold">Valid Until</label>
                                    <input type="date" name="valid_until" id="valid_until"
                                        class="form-control @error('valid_until') is-invalid @enderror"
                                        value="{{ old('valid_until') }}">
                                    @error('valid_until')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
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

                                <div class="col-md-12">
                                    <label for="file_sertifikat" class="form-label fw-bold">File Sertifikat</label>
                                    <input type="file" name="file_sertifikat" id="file_sertifikat"
                                        class="form-control @error('file_sertifikat') is-invalid @enderror"
                                        accept=".pdf,.jpg,.jpeg,.png">
                                    <small class="text-muted">Format: PDF, JPG, JPEG, PNG. Maks: 2MB</small>
                                    @error('file_sertifikat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-1"></i> Simpan
                                </button>
                                <a href="{{ route('dosen.sertifikasi.index') }}" class="btn btn-secondary">
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
