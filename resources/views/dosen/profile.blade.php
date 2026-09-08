@extends('components.layouts.app')

@section('title', 'Profile Saya')

@section('content')
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-md-4">
                <!-- Profile Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-person-circle me-2"></i> Foto Profile
                        </h5>
                    </div>
                    <div class="card-body text-center">
                        <img src="{{ $dosen->photo_url ?? 'https://ui-avatars.com/api/?background=4361ee&color=fff&name=' . urlencode($user->name) }}"
                            class="rounded-circle mb-3" width="150" height="150" style="object-fit: cover;">
                        <h5>{{ $user->name }}</h5>
                        <p class="text-muted mb-2">
                            <i class="bi bi-envelope"></i> {{ $user->email }}
                        </p>
                        <p class="text-muted">
                            <i class="bi bi-shield-check"></i> Role: <span
                                class="badge bg-primary">{{ ucfirst($user->role) }}</span>
                        </p>
                    </div>
                </div>

                <!-- Info Card -->
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-info-circle me-2"></i> Informasi Akun
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Terakhir Login:</span>
                            <span>{{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i:s') : '-' }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">IP Address:</span>
                            <span>{{ $user->last_login_ip ?? '-' }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Member Sejak:</span>
                            <span>{{ $user->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <!-- Edit Profile Form (dengan password) -->
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-pencil-square me-2"></i> Edit Profile
                        </h5>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('dosen.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label for="name" class="form-label fw-bold">Nama Lengkap</label>
                                    <input type="text" name="name" id="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label for="email" class="form-label fw-bold">Email</label>
                                    <input type="email" name="email" id="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label for="photo" class="form-label fw-bold">Foto Profile</label>
                                    <input type="file" name="photo" id="photo"
                                        class="form-control @error('photo') is-invalid @enderror" accept="image/*">
                                    <small class="text-muted">Format: JPG, JPEG, PNG. Maks: 2MB</small>
                                    @error('photo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <hr class="my-4">

                            <h6 class="fw-bold mb-3">
                                <i class="bi bi-key me-2"></i> Ganti Password (Opsional)
                            </h6>

                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label for="current_password" class="form-label fw-bold">Password Saat Ini</label>
                                    <input type="password" name="current_password" id="current_password"
                                        class="form-control @error('current_password') is-invalid @enderror">
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Isi jika ingin mengganti password</small>
                                </div>

                                <div class="col-md-12">
                                    <label for="password" class="form-label fw-bold">Password Baru</label>
                                    <input type="password" name="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Password
                                        Baru</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control">
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-1"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if ($dosen)
            <!-- Data Dosen Card -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 fw-bold">
                                <i class="bi bi-person-badge me-2"></i> Data Dosen
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="info-box">
                                        <small class="text-muted">NIDN</small>
                                        <div class="fw-bold">{{ $dosen->nidn }}</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="info-box">
                                        <small class="text-muted">NIK</small>
                                        <div class="fw-bold">{{ $dosen->nik }}</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="info-box">
                                        <small class="text-muted">Status</small>
                                        <div class="fw-bold">
                                            <span
                                                class="badge bg-{{ $dosen->status == 'tetap' ? 'success' : 'warning' }}">
                                                {{ ucfirst($dosen->status) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="info-box">
                                        <small class="text-muted">Pendidikan</small>
                                        <div class="fw-bold">{{ $dosen->pendidikan_terakhir }}</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="info-box">
                                        <small class="text-muted">Jabatan Fungsional</small>
                                        <div class="fw-bold">{{ $dosen->jabatan_fungsional }}</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="info-box">
                                        <small class="text-muted">Inpassing</small>
                                        <div class="fw-bold">{{ $dosen->inpassing }}</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="info-box">
                                        <small class="text-muted">Kepangkatan</small>
                                        <div class="fw-bold">{{ $dosen->kepangkatan }}</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="info-box">
                                        <small class="text-muted">Email</small>
                                        <div class="fw-bold">{{ $dosen->email }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <style>
        .info-box {
            padding: 10px;
            background: #f8f9fc;
            border-radius: 8px;
            margin-bottom: 10px;
        }
    </style>
@endsection
