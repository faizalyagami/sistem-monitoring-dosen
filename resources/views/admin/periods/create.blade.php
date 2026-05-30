@extends('components.layouts.app')

@section('title', 'Tambah Periode Akademik')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-plus-circle me-2"></i> Tambah Periode Akademik
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.periods.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="nama_periode" class="form-label fw-bold">
                                    Nama Periode <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="nama_periode" id="nama_periode"
                                    class="form-control @error('nama_periode') is-invalid @enderror"
                                    value="{{ old('nama_periode') }}" placeholder="Contoh: Semester Ganjil 2024/2025"
                                    required>
                                @error('nama_periode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="semester" class="form-label fw-bold">
                                        Semester <span class="text-danger">*</span>
                                    </label>
                                    <select name="semester" id="semester"
                                        class="form-select @error('semester') is-invalid @enderror" required>
                                        <option value="">Pilih Semester</option>
                                        <option value="ganjil" {{ old('semester') == 'ganjil' ? 'selected' : '' }}>Ganjil
                                        </option>
                                        <option value="genap" {{ old('semester') == 'genap' ? 'selected' : '' }}>Genap
                                        </option>
                                    </select>
                                    @error('semester')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="tahun_awal" class="form-label fw-bold">
                                        Tahun Awal <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" name="tahun_awal" id="tahun_awal"
                                        class="form-control @error('tahun_awal') is-invalid @enderror"
                                        value="{{ old('tahun_awal', date('Y')) }}" required>
                                    @error('tahun_awal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="tahun_akhir" class="form-label fw-bold">
                                        Tahun Akhir <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" name="tahun_akhir" id="tahun_akhir"
                                        class="form-control @error('tahun_akhir') is-invalid @enderror"
                                        value="{{ old('tahun_akhir', date('Y') + 1) }}" required>
                                    @error('tahun_akhir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tanggal_mulai" class="form-label fw-bold">
                                        Tanggal Mulai
                                    </label>
                                    <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                                        class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                        value="{{ old('tanggal_mulai') }}">
                                    @error('tanggal_mulai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="tanggal_selesai" class="form-label fw-bold">
                                        Tanggal Selesai
                                    </label>
                                    <input type="date" name="tanggal_selesai" id="tanggal_selesai"
                                        class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                        value="{{ old('tanggal_selesai') }}">
                                    @error('tanggal_selesai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input"
                                            value="1" {{ old('is_active') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Set sebagai periode aktif
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" name="is_closed" id="is_closed" class="form-check-input"
                                            value="1" {{ old('is_closed') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_closed">
                                            Tutup periode (tidak dapat diubah)
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="keterangan" class="form-label fw-bold">Keterangan</label>
                                <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror"
                                    rows="3">{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-1"></i> Simpan
                                </button>
                                <a href="{{ route('admin.periods.index') }}" class="btn btn-secondary">
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
