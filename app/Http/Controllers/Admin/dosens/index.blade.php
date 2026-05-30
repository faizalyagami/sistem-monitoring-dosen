{{-- resources/views/admin/dosens/index.blade.php --}}
@extends('components.layouts.app')

@section('title', 'Data Dosen')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Data Dosen</li>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="page-header">
                        <h5 class="page-title mb-0">
                            <i class="bi bi-people me-2"></i> Data Dosen
                        </h5>
                        <small class="text-muted">Kelola data dosen, lihat detail, edit, dan hapus</small>
                    </div>
                    <div>
                        <a href="{{ route('admin.dosens.export') }}" class="btn btn-success me-2">
                            <i class="bi bi-file-excel me-1"></i> Export
                        </a>
                        <a href="{{ route('admin.dosens.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i> Tambah Dosen
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body py-3">
                <form method="GET" action="{{ route('admin.dosens.index') }}" id="filterForm">
                    <div class="row g-2 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Cari</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent"><i class="bi bi-search"></i></span>
                                <input type="text" name="search" class="form-control"
                                    placeholder="Nama, NIDN, NIK, Email..." value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Status</label>
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                @foreach ($statusList as $status)
                                    <option value="{{ $status }}"
                                        {{ request('status') == $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Pendidikan</label>
                            <select name="pendidikan" class="form-select">
                                <option value="">Semua Pendidikan</option>
                                @foreach ($pendidikanList as $pendidikan)
                                    <option value="{{ $pendidikan }}"
                                        {{ request('pendidikan') == $pendidikan ? 'selected' : '' }}>
                                        {{ $pendidikan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-funnel me-1"></i> Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Data Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="40">No</th>
                                <th width="50">Foto</th>
                                <th>NIDN / NIK</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Pendidikan</th>
                                <th width="120">Aksi</th>
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
                                        <strong class="small">{{ $dosen->nidn }}</strong><br>
                                        <span class="text-muted small">{{ $dosen->nik }}</span>
                                    </td>
                                    <td>
                                        <strong class="small">{{ $dosen->nama }}</strong><br>
                                        <span class="text-muted small">{{ $dosen->jabatan_fungsional }}</span>
                                    </td>
                                    <td>
                                        <span class="small">{{ $dosen->email }}</span>
                                    </td>
                                    <td>
                                        @if ($dosen->status == 'tetap')
                                            <span class="badge bg-success">Tetap</span>
                                        @elseif($dosen->status == 'kontrak')
                                            <span class="badge bg-warning">Kontrak</span>
                                        @elseif($dosen->status == 'luar_biasa')
                                            <span class="badge bg-info">Luar Biasa</span>
                                        @else
                                            <span class="badge bg-secondary">Pensiun</span>
                                        @endif
                                    </td>
                                    <td><span class="small">{{ $dosen->pendidikan_terakhir }}</span></td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('admin.dosens.show', $dosen) }}"
                                                class="btn btn-info btn-action" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.dosens.edit', $dosen) }}"
                                                class="btn btn-warning btn-action" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-action" title="Hapus"
                                                onclick="confirmDelete({{ $dosen->id }})">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                        <form id="delete-form-{{ $dosen->id }}"
                                            action="{{ route('admin.dosens.destroy', $dosen) }}" method="POST"
                                            class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                        <span class="text-muted">Tidak ada data dosen</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="small text-muted">
                        Menampilkan {{ $dosens->firstItem() ?? 0 }} - {{ $dosens->lastItem() ?? 0 }}
                        dari {{ $dosens->total() }} data
                    </div>
                    <div>
                        {{ $dosens->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .btn-action {
            padding: 4px 8px;
            margin: 0 2px;
        }

        .btn-action i {
            font-size: 0.8rem;
        }

        .table td {
            vertical-align: middle;
        }
    </style>
@endsection

@push('scripts')
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data dosen yang dihapus tidak dapat dikembalikan!",
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
    </script>
@endpush
