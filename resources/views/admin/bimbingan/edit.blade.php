@extends('components.layouts.app')

@section('title', 'Edit Bimbingan')

@section('content')
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-pencil-square me-2"></i> Edit Data Bimbingan
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.bimbingan.update', $bimbingan->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label for="dosen_id" class="form-label fw-bold">
                                        Dosen Pembimbing <span class="text-danger">*</span>
                                    </label>
                                    <select name="dosen_id" id="dosen_id"
                                        class="form-select @error('dosen_id') is-invalid @enderror" required>
                                        <option value="">Pilih Dosen</option>
                                        @foreach ($dosens as $dosen)
                                            <option value="{{ $dosen->id }}"
                                                {{ old('dosen_id', $bimbingan->dosen_id) == $dosen->id ? 'selected' : '' }}>
                                                {{ $dosen->nama }} ({{ $dosen->nidn }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('dosen_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="jenis_bimbingan" class="form-label fw-bold">
                                        Jenis Bimbingan <span class="text-danger">*</span>
                                    </label>
                                    <select name="jenis_bimbingan" id="jenis_bimbingan"
                                        class="form-select @error('jenis_bimbingan') is-invalid @enderror" required>
                                        <option value="skripsi"
                                            {{ old('jenis_bimbingan', $bimbingan->jenis_bimbingan) == 'skripsi' ? 'selected' : '' }}>
                                            Skripsi (S1)</option>
                                        <option value="tesis"
                                            {{ old('jenis_bimbingan', $bimbingan->jenis_bimbingan) == 'tesis' ? 'selected' : '' }}>
                                            Tesis (S2)</option>
                                        <option value="disertasi"
                                            {{ old('jenis_bimbingan', $bimbingan->jenis_bimbingan) == 'disertasi' ? 'selected' : '' }}>
                                            Disertasi (S3)</option>
                                    </select>
                                    @error('jenis_bimbingan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="kategori_bimbingan" class="form-label fw-bold">
                                        Kategori Bimbingan
                                    </label>
                                    <select name="kategori_bimbingan" id="kategori_bimbingan"
                                        class="form-select @error('kategori_bimbingan') is-invalid @enderror">
                                        <option value="">Pilih Kategori</option>
                                        <option value="Pembimbing Utama"
                                            {{ old('kategori_bimbingan', $bimbingan->kategori_bimbingan) == 'Pembimbing Utama' ? 'selected' : '' }}>
                                            Pembimbing Utama</option>
                                        <option value="Pembimbing Pendamping"
                                            {{ old('kategori_bimbingan', $bimbingan->kategori_bimbingan) == 'Pembimbing Pendamping' ? 'selected' : '' }}>
                                            Pembimbing Pendamping</option>
                                        <option value="Koordinator"
                                            {{ old('kategori_bimbingan', $bimbingan->kategori_bimbingan) == 'Koordinator' ? 'selected' : '' }}>
                                            Koordinator</option>
                                        <option value="Penguji"
                                            {{ old('kategori_bimbingan', $bimbingan->kategori_bimbingan) == 'Penguji' ? 'selected' : '' }}>
                                            Penguji</option>
                                    </select>
                                    @error('kategori_bimbingan')
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
                                                {{ old('academic_period_id', $bimbingan->academic_period_id) == $period->id ? 'selected' : '' }}>
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
                                    <label for="jumlah_mahasiswa" class="form-label fw-bold">
                                        Jumlah Mahasiswa <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" name="jumlah_mahasiswa" id="jumlah_mahasiswa"
                                        class="form-control @error('jumlah_mahasiswa') is-invalid @enderror"
                                        value="{{ old('jumlah_mahasiswa', $bimbingan->jumlah_mahasiswa) }}" min="1"
                                        required>
                                    @error('jumlah_mahasiswa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="semester" class="form-label fw-bold">
                                        Semester <span class="text-danger">*</span>
                                    </label>
                                    <select name="semester" id="semester"
                                        class="form-select @error('semester') is-invalid @enderror" required>
                                        <option value="ganjil"
                                            {{ old('semester', $bimbingan->semester) == 'ganjil' ? 'selected' : '' }}>
                                            Ganjil</option>
                                        <option value="genap"
                                            {{ old('semester', $bimbingan->semester) == 'genap' ? 'selected' : '' }}>Genap
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
                                        value="{{ old('tahun_akademik', $bimbingan->tahun_akademik) }}" min="2000"
                                        max="2100" required>
                                    @error('tahun_akademik')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="no_sk_pembimbing" class="form-label fw-bold">No. SK Pembimbing</label>
                                    <input type="text" name="no_sk_pembimbing" id="no_sk_pembimbing"
                                        class="form-control @error('no_sk_pembimbing') is-invalid @enderror"
                                        value="{{ old('no_sk_pembimbing', $bimbingan->no_sk_pembimbing ?? '') }}">
                                    @error('no_sk_pembimbing')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="tanggal_sk_pembimbing" class="form-label fw-bold">Tanggal SK
                                        Pembimbing</label>
                                    <input type="date" name="tanggal_sk_pembimbing" id="tanggal_sk_pembimbing"
                                        class="form-control @error('tanggal_sk_pembimbing') is-invalid @enderror"
                                        value="{{ old('tanggal_sk_pembimbing', isset($bimbingan) && $bimbingan->tanggal_sk_pembimbing ? $bimbingan->tanggal_sk_pembimbing->format('Y-m-d') : '') }}">
                                    @error('tanggal_sk_pembimbing')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="no_sk_penguji" class="form-label fw-bold">No. SK Penguji</label>
                                    <input type="text" name="no_sk_penguji" id="no_sk_penguji"
                                        class="form-control @error('no_sk_penguji') is-invalid @enderror"
                                        value="{{ old('no_sk_penguji', $bimbingan->no_sk_penguji ?? '') }}">
                                    @error('no_sk_penguji')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="tanggal_sk_penguji" class="form-label fw-bold">Tanggal SK Penguji</label>
                                    <input type="date" name="tanggal_sk_penguji" id="tanggal_sk_penguji"
                                        class="form-control @error('tanggal_sk_penguji') is-invalid @enderror"
                                        value="{{ old('tanggal_sk_penguji', isset($bimbingan) && $bimbingan->tanggal_sk_penguji ? $bimbingan->tanggal_sk_penguji->format('Y-m-d') : '') }}">
                                    @error('tanggal_sk_penguji')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-1"></i> Update
                                </button>
                                <a href="{{ route('admin.bimbingan.index') }}" class="btn btn-secondary">
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
