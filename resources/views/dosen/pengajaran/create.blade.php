@extends('components.layouts.app')

@section('title', 'Tambah Pengajaran')

@section('content')
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-plus-circle me-2"></i> Tambah Data Pengajaran
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('dosen.pengajaran.store') }}" method="POST">
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="kode_mk" class="form-label fw-bold">
                                        Kode MK <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="kode_mk" id="kode_mk"
                                        class="form-control @error('kode_mk') is-invalid @enderror"
                                        value="{{ old('kode_mk') }}" required>
                                    @error('kode_mk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="nama_mk" class="form-label fw-bold">
                                        Nama Mata Kuliah <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="nama_mk" id="nama_mk"
                                        class="form-control @error('nama_mk') is-invalid @enderror"
                                        value="{{ old('nama_mk') }}" required>
                                    @error('nama_mk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="bidang_keilmuan" class="form-label fw-bold">
                                        Bidang Keilmuan <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="bidang_keilmuan" id="bidang_keilmuan"
                                        class="form-control @error('bidang_keilmuan') is-invalid @enderror"
                                        value="{{ old('bidang_keilmuan') }}" required>
                                    @error('bidang_keilmuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="kelas" class="form-label fw-bold">
                                        Kelas <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="kelas" id="kelas"
                                        class="form-control @error('kelas') is-invalid @enderror"
                                        value="{{ old('kelas') }}" required>
                                    @error('kelas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="sks" class="form-label fw-bold">
                                        Jumlah SKS <span class="text-danger">*</span>
                                    </label>
                                    <select name="sks" id="sks"
                                        class="form-select @error('sks') is-invalid @enderror" required>
                                        <option value="">Pilih SKS</option>
                                        <option value="1" {{ old('sks') == 1 ? 'selected' : '' }}>1 SKS</option>
                                        <option value="2" {{ old('sks') == 2 ? 'selected' : '' }}>2 SKS</option>
                                        <option value="3" {{ old('sks') == 3 ? 'selected' : '' }}>3 SKS</option>
                                        <option value="4" {{ old('sks') == 4 ? 'selected' : '' }}>4 SKS</option>
                                        <option value="6" {{ old('sks') == 6 ? 'selected' : '' }}>6 SKS</option>
                                    </select>
                                    @error('sks')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="jumlah_mahasiswa" class="form-label fw-bold">
                                        Jumlah Mahasiswa <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" name="jumlah_mahasiswa" id="jumlah_mahasiswa"
                                        class="form-control @error('jumlah_mahasiswa') is-invalid @enderror"
                                        value="{{ old('jumlah_mahasiswa') }}" required>
                                    @error('jumlah_mahasiswa')
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

                                <div class="col-md-6">
                                    <label for="tahun_akademik" class="form-label fw-bold">
                                        Tahun Akademik <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" name="tahun_akademik" id="tahun_akademik"
                                        class="form-control @error('tahun_akademik') is-invalid @enderror"
                                        value="{{ old('tahun_akademik', date('Y')) }}" required>
                                    @error('tahun_akademik')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-1"></i> Simpan
                                </button>
                                <a href="{{ route('dosen.pengajaran.index') }}" class="btn btn-secondary">
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
