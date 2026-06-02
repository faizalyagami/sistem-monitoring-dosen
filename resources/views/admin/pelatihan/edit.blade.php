@extends('components.layouts.app')

@section('title', 'Edit Pelatihan')

@section('content')
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-pencil-square me-2"></i> Edit Pelatihan
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.pelatihan.update', $pelatihan->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

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
                                                {{ old('dosen_id', $pelatihan->dosen_id) == $dosen->id ? 'selected' : '' }}>
                                                {{ $dosen->nama }} ({{ $dosen->nidn }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('dosen_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label for="nama_pelatihan" class="form-label fw-bold">
                                        Nama Pelatihan <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="nama_pelatihan" id="nama_pelatihan"
                                        class="form-control @error('nama_pelatihan') is-invalid @enderror"
                                        value="{{ old('nama_pelatihan', $pelatihan->nama_pelatihan) }}" required>
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
                                        value="{{ old('penyelenggara', $pelatihan->penyelenggara) }}" required>
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
                                        value="{{ old('tanggal_pelatihan', $pelatihan->tanggal_pelatihan ? date('Y-m-d', strtotime($pelatihan->tanggal_pelatihan)) : '') }}"
                                        required>
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
                                        value="{{ old('lokasi', $pelatihan->lokasi) }}" required>
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
                                        value="{{ old('tahun', $pelatihan->tahun) }}" required>
                                    @error('tahun')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="durasi" class="form-label fw-bold">Durasi (Jam)</label>
                                    <input type="number" name="durasi" id="durasi"
                                        class="form-control @error('durasi') is-invalid @enderror"
                                        value="{{ old('durasi', $pelatihan->durasi) }}">
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
                                                {{ old('academic_period_id', $pelatihan->academic_period_id) == $period->id ? 'selected' : '' }}>
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
                                    @if ($pelatihan->file_sertifikat)
                                        <div class="mb-2">
                                            <a href="{{ route('admin.pelatihan.download', $pelatihan->id) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="bi bi-download"></i> File Saat Ini
                                            </a>
                                        </div>
                                    @endif
                                    <input type="file" name="file_sertifikat" id="file_sertifikat"
                                        class="form-control @error('file_sertifikat') is-invalid @enderror"
                                        accept=".pdf,.jpg,.jpeg,.png">
                                    <small class="text-muted">Kosongkan jika tidak ingin mengubah file</small>
                                    @error('file_sertifikat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-1"></i> Update
                                </button>
                                <a href="{{ route('admin.pelatihan.index') }}" class="btn btn-secondary">
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
