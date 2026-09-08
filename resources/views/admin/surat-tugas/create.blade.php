@extends('components.layouts.app')

@section('title', 'Tambah Surat Tugas')

@section('content')
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-plus-circle me-2"></i> Tambah Surat Tugas
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.surat-tugas.store') }}" method="POST" enctype="multipart/form-data">
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
                                    <label for="nama_surat_tugas" class="form-label fw-bold">
                                        Nama Surat Tugas <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="nama_surat_tugas" id="nama_surat_tugas"
                                        class="form-control @error('nama_surat_tugas') is-invalid @enderror"
                                        value="{{ old('nama_surat_tugas') }}" required>
                                    @error('nama_surat_tugas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label for="no_surat_tugas" class="form-label fw-bold">
                                        No. Surat Tugas <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="no_surat_tugas" id="no_surat_tugas"
                                        class="form-control @error('no_surat_tugas') is-invalid @enderror"
                                        value="{{ old('no_surat_tugas') }}" required>
                                    @error('no_surat_tugas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="tanggal_surat_tugas" class="form-label fw-bold">
                                        Tanggal Surat Tugas <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" name="tanggal_surat_tugas" id="tanggal_surat_tugas"
                                        class="form-control @error('tanggal_surat_tugas') is-invalid @enderror"
                                        value="{{ old('tanggal_surat_tugas') }}" required>
                                    @error('tanggal_surat_tugas')
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

                                <div class="col-md-12">
                                    <label for="perihal" class="form-label fw-bold">Perihal</label>
                                    <textarea name="perihal" id="perihal" class="form-control @error('perihal') is-invalid @enderror" rows="3">{{ old('perihal') }}</textarea>
                                    @error('perihal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label for="file_surat" class="form-label fw-bold">File Surat</label>
                                    <input type="file" name="file_surat" id="file_surat"
                                        class="form-control @error('file_surat') is-invalid @enderror"
                                        accept=".pdf,.doc,.docx">
                                    <small class="text-muted">Format: PDF, DOC, DOCX. Maks: 5MB</small>
                                    @error('file_surat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-1"></i> Simpan
                                </button>
                                <a href="{{ route('admin.surat-tugas.index') }}" class="btn btn-secondary">
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
