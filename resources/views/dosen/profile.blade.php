@extends('components.layouts.app')

@section('title', 'Profile Saya')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800"><i class="bi bi-person-circle"></i> Profile Saya</h1>
                <p class="text-muted">Kelola informasi akun dan data pribadi Anda</p>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <!-- Profile Card -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0 text-center">
                    <div class="card-body">
                        <img src="{{ $dosen->photo_url ?? 'https://ui-avatars.com/api/?background=4361ee&color=fff&name=' . urlencode($user->name) }}"
                            class="rounded-circle mb-3 shadow-sm" width="150" height="150"
                            style="object-fit: cover; border: 4px solid #fff;">
                        <h4 class="fw-bold">{{ $user->name }}</h4>
                        <p class="text-muted mb-1"><i class="bi bi-envelope"></i> {{ $user->email }}</p>
                        <span class="badge bg-primary">{{ ucfirst($user->role) }}</span>
                        <hr>
                        <div class="text-start small">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Terakhir Login</span>
                                <span>{{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : '-' }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Member Sejak</span>
                                <span>{{ $user->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($dosen)
                    <div class="card shadow-sm border-0 mt-3">
                        <div class="card-header bg-white py-3">
                            <h6 class="mb-0 fw-bold"><i class="bi bi-person-badge me-2 text-primary"></i> Data Dosen</h6>
                        </div>
                        <div class="card-body small">
                            <div class="mb-2"><strong>NIDN:</strong> {{ $dosen->nidn }}</div>
                            <div class="mb-2"><strong>NIK:</strong> {{ $dosen->nik }}</div>
                            <div class="mb-2"><strong>Pendidikan:</strong> {{ $dosen->pendidikan_terakhir }}</div>
                            <div class="mb-2"><strong>Jabatan:</strong> {{ $dosen->jabatan_fungsional }}</div>
                            <div class="mb-2"><strong>Inpassing:</strong> {{ $dosen->inpassing }}</div>
                            <div class="mb-2"><strong>Kepangkatan:</strong> {{ $dosen->kepangkatan }}</div>
                            <div class="mb-0"><strong>Bidang:</strong> {{ $dosen->bidang_keahlian }}</div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Edit Form -->
            <div class="col-md-8 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2 text-primary"></i> Edit Profile</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('dosen.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Nama Lengkap</label>
                                    <input type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Email</label>
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Foto Profile</label>
                                    <input type="file" name="photo"
                                        class="form-control @error('photo') is-invalid @enderror" accept="image/*">
                                    <small class="text-muted">Format: JPG, JPEG, PNG. Maks: 2MB</small>
                                    @error('photo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <hr class="my-4">

                            <h6 class="fw-bold mb-3"><i class="bi bi-key me-2 text-warning"></i> Ganti Password (Opsional)
                            </h6>

                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Password Baru</label>
                                    <input type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror">
                                    <small class="text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Konfirmasi Password Baru</label>
                                    <input type="password" name="password_confirmation" class="form-control">
                                </div>
                            </div>

                            <div class="mt-4 pt-3 border-top">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan
                                    Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
