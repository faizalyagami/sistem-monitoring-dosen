@extends('components.layouts.app')

@section('title', 'Tambah Pelatihan')

@section('content')
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-plus-circle me-2"></i> Tambah Pelatihan
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('dosen.pelatihan.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label for="nama_pelatihan" class="form-label fw-bold">
                                        Nama Pelatihan <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="nama_pelatihan" id="nama_pelatihan"
                                        class="form-control @error('nama_pelatihan') is-invalid @enderror"
                                        value="{{ old('nama_pelatihan') }}" required>
                                    @error('nama_pelatihan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label for="penyelenggara" class="form-label fw-bold">
                                        Penyelenggara <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="penyelenggara" id="penyelenggara"
                                        class="form-control @error('penyelenggara') is-invalid @enderror"
                                        value="{{ old('penyelenggara') }}" required>
                                    @error('penyelenggara')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="tanggal_pelatihan" class="form-label fw-bold">
                                        Tanggal Pelatihan <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" name="tanggal_pelatihan" id="tanggal_pelatihan"
                                        class="form-control @error('tanggal_pelatihan') is-invalid @enderror"
                                        value="{{ old('tanggal_pelatihan') }}" required>
                                    @error('tanggal_pelatihan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="lokasi" class="form-label fw-bold">
                                        Lokasi <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="lokasi" id="lokasi"
                                        class="form-control @error('lokasi') is-invalid @enderror"
                                        value="{{ old('lokasi') }}" required>
                                    @error('lokasi')
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
                                    <label for="durasi" class="form-label fw-bold">Durasi (Jam)</label>
                                    <input type="number" name="durasi" id="durasi"
                                        class="form-control @error('durasi') is-invalid @enderror"
                                        value="{{ old('durasi') }}">
                                    @error('durasi')
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
                                <a href="{{ route('dosen.pelatihan.index') }}" class="btn btn-secondary">
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
