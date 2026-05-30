@extends('components.layouts.app')

@section('title', 'Tambah Dosen')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dosens.index') }}">Data Dosen</a></li>
    <li class="breadcrumb-item active">Tambah Dosen</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="bi bi-plus-circle me-2"></i> Form Tambah Dosen
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.dosens.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nidn" class="form-label small fw-bold">
                                        NIDN <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="nidn" id="nidn"
                                        class="form-control @error('nidn') is-invalid @enderror" value="{{ old('nidn') }}"
                                        required>
                                    @error('nidn')
                                        <div class="invalid-feedback small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="nik" class="form-label small fw-bold">
                                        NIK <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="nik" id="nik"
                                        class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik') }}"
                                        required>
                                    @error('nik')
                                        <div class="invalid-feedback small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="nama" class="form-label small fw-bold">
                                        Nama Lengkap <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="nama" id="nama"
                                        class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}"
                                        required>
                                    @error('nama')
                                        <div class="invalid-feedback small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label small fw-bold">
                                        Email <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" name="email" id="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="status" class="form-label small fw-bold">
                                        Status <span class="text-danger">*</span>
                                    </label>
                                    <select name="status" id="status"
                                        class="form-select @error('status') is-invalid @enderror" required>
                                        <option value="">Pilih Status</option>
                                        <option value="tetap" {{ old('status') == 'tetap' ? 'selected' : '' }}>Tetap
                                        </option>
                                        <option value="kontrak" {{ old('status') == 'kontrak' ? 'selected' : '' }}>Kontrak
                                        </option>
                                        <option value="luar_biasa" {{ old('status') == 'luar_biasa' ? 'selected' : '' }}>
                                            Luar Biasa</option>
                                        <option value="pensiun" {{ old('status') == 'pensiun' ? 'selected' : '' }}>Pensiun
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="pendidikan_terakhir" class="form-label small fw-bold">
                                        Pendidikan Terakhir <span class="text-danger">*</span>
                                    </label>
                                    <select name="pendidikan_terakhir" id="pendidikan_terakhir"
                                        class="form-select @error('pendidikan_terakhir') is-invalid @enderror" required>
                                        <option value="">Pilih Pendidikan</option>
                                        <option value="S1" {{ old('pendidikan_terakhir') == 'S1' ? 'selected' : '' }}>
                                            S1</option>
                                        <option value="S2" {{ old('pendidikan_terakhir') == 'S2' ? 'selected' : '' }}>
                                            S2</option>
                                        <option value="S3" {{ old('pendidikan_terakhir') == 'S3' ? 'selected' : '' }}>
                                            S3</option>
                                    </select>
                                    @error('pendidikan_terakhir')
                                        <div class="invalid-feedback small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="jabatan_fungsional" class="form-label small fw-bold">
                                        Jabatan Fungsional <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="jabatan_fungsional" id="jabatan_fungsional"
                                        class="form-control @error('jabatan_fungsional') is-invalid @enderror"
                                        value="{{ old('jabatan_fungsional') }}" required>
                                    @error('jabatan_fungsional')
                                        <div class="invalid-feedback small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="inpassing" class="form-label small fw-bold">
                                        Inpassing <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="inpassing" id="inpassing"
                                        class="form-control @error('inpassing') is-invalid @enderror"
                                        value="{{ old('inpassing') }}" required>
                                    @error('inpassing')
                                        <div class="invalid-feedback small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="kepangkatan" class="form-label small fw-bold">
                                        Kepangkatan <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="kepangkatan" id="kepangkatan"
                                        class="form-control @error('kepangkatan') is-invalid @enderror"
                                        value="{{ old('kepangkatan') }}" required>
                                    @error('kepangkatan')
                                        <div class="invalid-feedback small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label for="photo" class="form-label small fw-bold">Foto</label>
                                    <input type="file" name="photo" id="photo"
                                        class="form-control @error('photo') is-invalid @enderror" accept="image/*"
                                        onchange="previewImage(this)">
                                    <small class="text-muted">Format: JPG, JPEG, PNG. Maks: 2MB</small>
                                    <div class="mt-2" id="imagePreview"></div>
                                    @error('photo')
                                        <div class="invalid-feedback small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-1"></i> Simpan
                                </button>
                                <a href="{{ route('admin.dosens.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-1"></i> Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" class="img-thumbnail" width="150">`;
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.innerHTML = '';
            }
        }
    </script>
@endsection
