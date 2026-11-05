@extends('components.layouts.app')

@section('title', 'Tambah PKM')

@section('content')
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold">Tambah PKM</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('dosen.pkm.update') }}" method="PUT" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Judul Penelitian <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="judul_pkm"
                                        class="form-control @error('judul_pkm') is-invalid @enderror"
                                        value="{{ old('judul_pkm') }}" required>
                                    @error('judul_pkm')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Bidang PKM <span class="text-danger">*</span></label>
                                    <input type="text" name="bidang_pkm" class="form-control"
                                        value="{{ old('bidang_pkm') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Jenis PKM <span class="text-danger">*</span></label>
                                    <input type="text" name="jenis_pkm" class="form-control"
                                        value="{{ old('jenis_pkm') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Sumber Dana <span class="text-danger">*</span></label>
                                    <input type="text" name="sumber_dana" class="form-control"
                                        value="{{ old('sumber_dana') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Jumlah Dana (Rp) <span
                                            class="text-danger">*</span></label>
                                    <input type="number" name="jumlah_dana" class="form-control"
                                        value="{{ old('jumlah_dana') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Periode Akademik <span
                                            class="text-danger">*</span></label>
                                    <select name="academic_period_id" class="form-select" required>
                                        <option value="">Pilih Periode</option>
                                        @foreach ($periods as $p)
                                            <option value="{{ $p->id }}"
                                                {{ old('academic_period_id') == $p->id ? 'selected' : '' }}>
                                                {{ $p->nama_periode }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Tahun <span class="text-danger">*</span></label>
                                    <input type="number" name="tahun" class="form-control"
                                        value="{{ old('tahun', date('Y')) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-select" required>
                                        <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif
                                        </option>
                                        <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">File Laporan (PDF/DOC)</label>
                                    <input type="file" name="file_laporan" class="form-control" accept=".pdf,.doc,.docx">
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('dosen.pkm.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
