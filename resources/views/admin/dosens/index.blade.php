{{-- resources/views/admin/dosens/index.blade.php --}}
@extends('components.layouts.app')

@section('title', 'Data Dosen')

@section('content')
    <div class="container-fluid px-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="bi bi-people"></i> Data Dosen
                </h1>
                <p class="text-muted">Kelola data dosen Fakultas Psikologi</p>
            </div>
            <div>
                <!-- TOMBOL IMPORT/EXPORT -->
                <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#importModal">
                    <i class="bi bi-file-earmark-excel"></i> Import
                </button>
                <a href="{{ route('admin.dosens.export') }}" class="btn btn-info me-2">
                    <i class="bi bi-file-excel"></i> Export
                </a>
                <a href="{{ route('admin.dosens.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Dosen
                </a>
            </div>
        </div>

        @include('components.period-info')

        @if (session('import_errors'))
            <div class="alert alert-warning alert-dismissible fade show">
                <h6 class="fw-bold"><i class="bi bi-exclamation-triangle"></i> Beberapa data gagal diimport:</h6>
                <ul class="mb-0">
                    @foreach (session('import_errors') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Filter Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.dosens.index') }}" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Cari</label>
                        <input type="text" name="search" class="form-control" placeholder="Nama, NIDN, NIK, Email..."
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="tetap" {{ request('status') == 'tetap' ? 'selected' : '' }}>Tetap</option>
                            <option value="kontrak" {{ request('status') == 'kontrak' ? 'selected' : '' }}>Kontrak</option>
                            <option value="luar_biasa" {{ request('status') == 'luar_biasa' ? 'selected' : '' }}>Luar Biasa
                            </option>
                            <option value="pensiun" {{ request('status') == 'pensiun' ? 'selected' : '' }}>Pensiun</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Pendidikan</label>
                        <select name="pendidikan" class="form-select">
                            <option value="">Semua Pendidikan</option>
                            <option value="S1" {{ request('pendidikan') == 'S1' ? 'selected' : '' }}>S1</option>
                            <option value="S2" {{ request('pendidikan') == 'S2' ? 'selected' : '' }}>S2</option>
                            <option value="S3" {{ request('pendidikan') == 'S3' ? 'selected' : '' }}>S3</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search"></i> Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Data Table -->
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50">No</th>
                                <th>Foto</th>
                                <th>NIDN / NIK</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Pendidikan</th>
                                <th>Bidang Keahlian</th>
                                <th width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dosens as $index => $dosen)
                                <tr>
                                    <td>{{ $dosens->firstItem() + $index }}</td>
                                    <td>
                                        <img src="{{ $dosen->photo_url }}" alt="{{ $dosen->nama }}"
                                            class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                                    </td>
                                    <td>
                                        <strong>{{ $dosen->nidn }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $dosen->nik }}</small>
                                    </td>
                                    <td>
                                        <strong>{{ $dosen->nama }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $dosen->jabatan_fungsional }}</small>
                                    </td>
                                    <td>{{ $dosen->email }}</td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'tetap' => 'success',
                                                'kontrak' => 'warning',
                                                'luar_biasa' => 'info',
                                                'pensiun' => 'secondary',
                                            ];
                                            $color = $statusColors[$dosen->status] ?? 'secondary';
                                        @endphp
                                        <span class="badge bg-{{ $color }}">{{ ucfirst($dosen->status) }}</span>
                                    </td>
                                    <td>{{ $dosen->pendidikan_terakhir }}</td>
                                    <td>
                                        @if ($dosen->bidang_keahlian)
                                            @php
                                                // Pisahkan teks berdasarkan koma
                                                $bidangs = array_filter(
                                                    array_map('trim', explode(',', $dosen->bidang_keahlian)),
                                                );
                                            @endphp
                                            @foreach ($bidangs as $bidang)
                                                <span class="badge bg-primary mb-1">{{ $bidang }}</span>
                                            @endforeach
                                        @else
                                            <span class="text-muted fst-italic">Belum diisi</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.dosens.show', $dosen->id) }}" class="btn btn-info"
                                                title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.dosens.edit', $dosen->id) }}" class="btn btn-warning"
                                                title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-secondary"
                                                onclick="resetPassword({{ $dosen->id }}, '{{ $dosen->nama }}', '{{ $dosen->nik }}')"
                                                title="Reset Password ke NIK">
                                                <i class="bi bi-key"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger"
                                                onclick="confirmDelete({{ $dosen->id }})" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                        <form id="delete-form-{{ $dosen->id }}"
                                            action="{{ route('admin.dosens.destroy', $dosen->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <form id="reset-form-{{ $dosen->id }}"
                                            action="{{ route('admin.dosens.reset-password', $dosen->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-5">
                                        <i class="bi bi-inbox fs-1 text-muted"></i>
                                        <p class="mt-2 text-muted">Belum ada data dosen</p>
                                        <a href="{{ route('admin.dosens.create') }}" class="btn btn-sm btn-primary">
                                            Tambah Dosen
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- PERBAIKAN PAGINATION -->
            <div class="card-footer bg-white py-3">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="text-muted small">
                            <i class="bi bi-info-circle"></i>
                            Menampilkan <strong>{{ $dosens->firstItem() ?? 0 }}</strong> -
                            <strong>{{ $dosens->lastItem() ?? 0 }}</strong>
                            dari <strong>{{ $dosens->total() }}</strong> data
                            @if ($dosens->total() > 0)
                                <span class="ms-2">
                                    (Halaman <strong>{{ $dosens->currentPage() }}</strong> dari
                                    <strong>{{ $dosens->lastPage() }}</strong>)
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-end">
                            @if ($dosens->hasPages())
                                <nav aria-label="Page navigation">
                                    <ul class="pagination pagination-sm mb-0">
                                        {{-- Previous Page Link --}}
                                        @if ($dosens->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link"><i class="bi bi-chevron-left"></i></span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $dosens->previousPageUrl() }}"
                                                    rel="prev">
                                                    <i class="bi bi-chevron-left"></i>
                                                </a>
                                            </li>
                                        @endif

                                        {{-- Pagination Elements --}}
                                        @php
                                            $start = max(1, $dosens->currentPage() - 2);
                                            $end = min($dosens->lastPage(), $dosens->currentPage() + 2);
                                        @endphp

                                        @if ($start > 1)
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $dosens->url(1) }}">1</a>
                                            </li>
                                            @if ($start > 2)
                                                <li class="page-item disabled"><span class="page-link">...</span></li>
                                            @endif
                                        @endif

                                        @for ($i = $start; $i <= $end; $i++)
                                            @if ($i == $dosens->currentPage())
                                                <li class="page-item active" aria-current="page">
                                                    <span class="page-link">{{ $i }}</span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link"
                                                        href="{{ $dosens->url($i) }}">{{ $i }}</a>
                                                </li>
                                            @endif
                                        @endfor

                                        @if ($end < $dosens->lastPage())
                                            @if ($end < $dosens->lastPage() - 1)
                                                <li class="page-item disabled"><span class="page-link">...</span></li>
                                            @endif
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="{{ $dosens->url($dosens->lastPage()) }}">{{ $dosens->lastPage() }}</a>
                                            </li>
                                        @endif

                                        {{-- Next Page Link --}}
                                        @if ($dosens->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $dosens->nextPageUrl() }}" rel="next">
                                                    <i class="bi bi-chevron-right"></i>
                                                </a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <span class="page-link"><i class="bi bi-chevron-right"></i></span>
                                            </li>
                                        @endif
                                    </ul>
                                </nav>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Import -->
    <div class="modal fade" id="importModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-file-earmark-excel"></i> Import Data Dosen
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.dosens.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <h6 class="fw-bold"><i class="bi bi-info-circle"></i> Petunjuk:</h6>
                            <ol class="mb-0 ps-3">
                                <li>Download template terlebih dahulu</li>
                                <li>Isi data dosen sesuai format</li>
                                <li>Upload file yang sudah diisi</li>
                                <li>Password otomatis menggunakan NIK dosen</li>
                            </ol>
                        </div>

                        <div class="mb-3">
                            <a href="{{ route('admin.dosens.download-template') }}"
                                class="btn btn-outline-success w-100">
                                <i class="bi bi-download"></i> Download Template Excel
                            </a>
                        </div>

                        <div class="mb-3">
                            <label for="file" class="form-label fw-bold">
                                Upload File <span class="text-danger">*</span>
                            </label>
                            <input type="file" name="file" id="file"
                                class="form-control @error('file') is-invalid @enderror" accept=".xlsx,.xls,.csv"
                                required>
                            <small class="text-muted">Format: XLSX, XLS, CSV. Maks: 5MB</small>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-upload"></i> Import Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- CUSTOM CSS UNTUK PAGINATION --}}
    <style>
        .pagination {
            margin-bottom: 0;
            gap: 5px;
        }

        .page-item .page-link {
            border-radius: 8px;
            color: #6c5ce7;
            border: 1px solid #e0e0e0;
            padding: 6px 12px;
            font-size: 0.875rem;
            transition: all 0.3s;
        }

        .page-item .page-link:hover {
            background: linear-gradient(135deg, #6c5ce7, #a29bfe);
            color: white;
            border-color: transparent;
            transform: translateY(-2px);
        }

        .page-item.active .page-link {
            background: linear-gradient(135deg, #6c5ce7, #a29bfe);
            border-color: transparent;
            color: white;
        }

        .page-item.disabled .page-link {
            color: #adb5bd;
            background-color: #f8f9fa;
            border-color: #e9ecef;
            transform: none;
        }
    </style>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data dosen dan akun user akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }

        function resetPassword(id, nama, nik) {
            Swal.fire({
                title: 'Reset Password?',
                html: `Reset password untuk <strong>${nama}</strong>?<br>Password akan direset ke NIK: <code>${nik}</code>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, reset!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('reset-form-' + id).submit();
                }
            });
        }
    </script>
@endsection
