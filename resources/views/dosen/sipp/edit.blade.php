@extends('components.layouts.app')

@section('title', 'Edit SIPP')

@section('content')
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-pencil-square me-2"></i> Edit SIPP
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('dosen.sipp.update', $sipp->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label for="no_registrasi" class="form-label fw-bold">
                                        No. Registrasi <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="no_registrasi" id="no_registrasi"
                                        class="form-control @error('no_registrasi') is-invalid @enderror"
                                        value="{{ old('no_registrasi', $sipp->no_registrasi) }}" required>
                                    @error('no_registrasi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label for="bidang_keilmuan" class="form-label fw-bold">
                                        Bidang Keilmuan <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="bidang_keilmuan" id="bidang_keilmuan"
                                        class="form-control @error('bidang_keilmuan') is-invalid @enderror"
                                        value="{{ old('bidang_keilmuan', $sipp->bidang_keilmuan) }}" required>
                                    @error('bidang_keilmuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="tahun_terbit" class="form-label fw-bold">
                                        Tahun Terbit <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" name="tahun_terbit" id="tahun_terbit"
                                        class="form-control @error('tahun_terbit') is-invalid @enderror"
                                        value="{{ old('tahun_terbit', $sipp->tahun_terbit) }}" required>
                                    @error('tahun_terbit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="status" class="form-label fw-bold">
                                        Status <span class="text-danger">*</span>
                                    </label>
                                    <select name="status" id="status"
                                        class="form-select @error('status') is-invalid @enderror" required>
                                        <option value="aktif"
                                            {{ old('status', $sipp->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="tidak_aktif"
                                            {{ old('status', $sipp->status) == 'tidak_aktif' ? 'selected' : '' }}>Tidak
                                            Aktif</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-1"></i> Update
                                </button>
                                <a href="{{ route('dosen.sipp.index') }}" class="btn btn-secondary">
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
