@extends('components.layouts.app')

@section('title', 'Tambah Pengajaran')

@section('content')
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold">Tambah Pengajaran</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('dosen.pengajaran.update') }}" method="PUT">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Kode MK <span class="text-danger">*</span></label>
                                    <input type="text" name="kode_mk" class="form-control" value="{{ old('kode_mk') }}"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nama Mata Kuliah <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_mk" class="form-control" value="{{ old('nama_mk') }}"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Bidang Keilmuan <span class="text-danger">*</span></label>
                                    <input type="text" name="bidang_keilmuan" class="form-control"
                                        value="{{ old('bidang_keilmuan') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Kelas <span class="text-danger">*</span></label>
                                    <input type="text" name="kelas" class="form-control" value="{{ old('kelas') }}"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">SKS <span class="text-danger">*</span></label>
                                    <input type="number" name="sks" class="form-control" value="{{ old('sks') }}"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Jumlah Mahasiswa <span class="text-danger">*</span></label>
                                    <input type="number" name="jumlah_mahasiswa" class="form-control"
                                        value="{{ old('jumlah_mahasiswa') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Periode Akademik <span class="text-danger">*</span></label>
                                    <select name="academic_period_id" class="form-select" required>
                                        @foreach ($periods as $p)
                                            <option value="{{ $p->id }}">{{ $p->nama_periode }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Semester <span class="text-danger">*</span></label>
                                    <select name="semester" class="form-select" required>
                                        <option value="ganjil">Ganjil</option>
                                        <option value="genap">Genap</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tahun Akademik <span class="text-danger">*</span></label>
                                    <input type="number" name="tahun_akademik" class="form-control"
                                        value="{{ date('Y') }}" required>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('dosen.pengajaran.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
