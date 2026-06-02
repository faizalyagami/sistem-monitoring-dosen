@extends('components.layouts.app')

@section('title', 'Edit Asosiasi')

@section('content')
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-pencil-square me-2"></i> Edit Asosiasi Profesi
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('dosen.asosiasi.update', $asosiasi->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label for="nama_asosiasi" class="form-label fw-bold">
                                        Nama Asosiasi <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="nama_asosiasi" id="nama_asosiasi"
                                        class="form-control @error('nama_asosiasi') is-invalid @enderror"
                                        value="{{ old('nama_asosiasi', $asosiasi->nama_asosiasi) }}" required>
                                    @error('nama_asosiasi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label for="peran" class="form-label fw-bold">
                                        Peran <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="peran" id="peran"
                                        class="form-control @error('peran') is-invalid @enderror"
                                        value="{{ old('peran', $asosiasi->peran) }}" required>
                                    @error('peran')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="masa_aktif" class="form-label fw-bold">
                                        Masa Aktif <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" name="masa_aktif" id="masa_aktif"
                                        class="form-control @error('masa_aktif') is-invalid @enderror"
                                        value="{{ old('masa_aktif', $asosiasi->masa_aktif ? date('Y-m-d', strtotime($asosiasi->masa_aktif)) : '') }}"
                                        required>
                                    @error('masa_aktif')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="tahun" class="form-label fw-bold">
                                        Tahun <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" name="tahun" id="tahun"
                                        class="form-control @error('tahun') is-invalid @enderror"
                                        value="{{ old('tahun', $asosiasi->tahun) }}" required>
                                    @error('tahun')
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
                                                {{ old('academic_period_id', $asosiasi->academic_period_id) == $period->id ? 'selected' : '' }}>
                                                {{ $period->nama_periode }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('academic_period_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-1"></i> Update
                                </button>
                                <a href="{{ route('dosen.asosiasi.index') }}" class="btn btn-secondary">
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
