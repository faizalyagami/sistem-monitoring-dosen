@extends('components.layouts.app')

@section('title', 'Data Pengajaran')

@section('content')
    <div class="container-fluid px-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="bi bi-book"></i> Data Pengajaran
                </h1>
                <p class="text-muted">Kelola data mata kuliah yang diajarkan oleh dosen</p>
            </div>
            <div>
                <a href="{{ route('admin.pengajaran.export') }}" class="btn btn-success me-2">
                    <i class="bi bi-file-excel"></i> Export
                </a>
                <a href="{{ route('admin.pengajaran.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Pengajaran
                </a>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.pengajaran.index') }}" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Cari</label>
                        <input type="text" name="search" class="form-control" placeholder="Kode MK / Nama MK"
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Dosen</label>
                        <select name="dosen_id" class="form-select">
                            <option value="">Semua Dosen</option>
                            @foreach ($dosens as $dosen)
                                <option value="{{ $dosen->id }}"
                                    {{ request('dosen_id') == $dosen->id ? 'selected' : '' }}>
                                    {{ $dosen->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Periode Akademik</label>
                        <select name="academic_period_id" class="form-select">
                            <option value="">Semua Periode</option>
                            @foreach ($periods as $period)
                                <option value="{{ $period->id }}"
                                    {{ request('academic_period_id') == $period->id ? 'selected' : '' }}>
                                    {{ $period->nama_periode }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-bold">Semester</label>
                        <select name="semester" class="form-select">
                            <option value="">Semua</option>
                            <option value="ganjil" {{ request('semester') == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                            <option value="genap" {{ request('semester') == 'genap' ? 'selected' : '' }}>Genap</option>
                        </select>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Data Table -->
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">Daftar Mata Kuliah</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50">No</th>
                                <th>Kode MK</th>
                                <th>Nama Mata Kuliah</th>
                                <th>Dosen</th>
                                <th>Kelas</th>
                                <th>SKS</th>
                                <th>Jumlah Mahasiswa</th>
                                <th>Periode</th>
                                <th width="100">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengajarans as $index => $pengajaran)
                                <tr>
                                    <td>{{ $pengajarans->firstItem() + $index }}</td>
                                    <td><strong>{{ $pengajaran->kode_mk }}</strong></td>
                                    <td>{{ $pengajaran->nama_mk }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar-sm"
                                                style="width: 32px; height: 32px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px;">
                                                {{ substr($pengajaran->dosen->nama ?? 'D', 0, 1) }}
                                            </div>
                                            <div>
                                                <span class="small">{{ $pengajaran->dosen->nama ?? '-' }}</span>
                                                <br>
                                                <small class="text-muted">{{ $pengajaran->dosen->nidn ?? '-' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $pengajaran->kelas }}</td>
                                    <td><span class="badge bg-primary">{{ $pengajaran->sks }} SKS</span></td>
                                    <td><span class="badge bg-info">{{ $pengajaran->jumlah_mahasiswa }} Mhs</span></td>
                                    <td>
                                        <small
                                            class="text-muted">{{ $pengajaran->academicPeriod->nama_periode ?? '-' }}</small>
                                        <br>
                                        <span
                                            class="badge bg-{{ $pengajaran->semester == 'ganjil' ? 'info' : 'warning' }} small">
                                            {{ ucfirst($pengajaran->semester) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.pengajaran.show', $pengajaran->id) }}"
                                                class="btn btn-info" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.pengajaran.edit', $pengajaran->id) }}"
                                                class="btn btn-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger"
                                                onclick="confirmDelete({{ $pengajaran->id }})" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                        <form id="delete-form-{{ $pengajaran->id }}"
                                            action="{{ route('admin.pengajaran.destroy', $pengajaran->id) }}"
                                            method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-5">
                                        <i class="bi bi-inbox fs-1 text-muted"></i>
                                        <p class="mt-2 text-muted">Belum ada data pengajaran</p>
                                        <a href="{{ route('admin.pengajaran.create') }}" class="btn btn-sm btn-primary">
                                            Tambah Pengajaran Sekarang
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- PAGINATION YANG DIPERBAIKI -->
            <div class="card-footer bg-white py-3">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="text-muted small">
                            <i class="bi bi-info-circle"></i>
                            Menampilkan {{ $pengajarans->firstItem() ?? 0 }} - {{ $pengajarans->lastItem() ?? 0 }}
                            dari {{ $pengajarans->total() }} data
                            @if ($pengajarans->total() > 0)
                                <span class="ms-2 text-success">
                                    (Halaman {{ $pengajarans->currentPage() }} dari {{ $pengajarans->lastPage() }})
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-end">
                            {{ $pengajarans->withQueryString()->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Custom Pagination Styles */
        .pagination {
            margin-bottom: 0;
            gap: 5px;
        }

        .page-item .page-link {
            border-radius: 8px;
            color: #4361ee;
            border: 1px solid #e0e0e0;
            padding: 8px 14px;
            font-size: 0.875rem;
            transition: all 0.3s;
        }

        .page-item .page-link:hover {
            background-color: #4361ee;
            color: white;
            border-color: #4361ee;
            transform: translateY(-2px);
        }

        .page-item.active .page-link {
            background: linear-gradient(135deg, #4361ee, #764ba2);
            border-color: #4361ee;
            color: white;
        }

        .page-item.disabled .page-link {
            color: #adb5bd;
            background-color: #f8f9fa;
            border-color: #e9ecef;
        }

        .page-item:first-child .page-link,
        .page-item:last-child .page-link {
            border-radius: 8px;
        }

        /* Table hover effect */
        .table-hover tbody tr:hover {
            background-color: rgba(67, 97, 238, 0.05);
            transition: all 0.3s;
        }

        /* Avatar style */
        .avatar-sm {
            transition: transform 0.3s;
        }

        .table-hover tbody tr:hover .avatar-sm {
            transform: scale(1.1);
        }
    </style>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data pengajaran yang dihapus tidak dapat dikembalikan!",
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
@endsection
