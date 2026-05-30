@extends('components.layouts.app')

@section('title', 'Data PKM')

@section('content')
    <div class="container-fluid px-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="bi bi-people-fill"></i> Data Pengabdian Masyarakat (PKM)
                </h1>
                <p class="text-muted">Kelola data PKM dan pengabdian masyarakat dosen</p>
            </div>
            <div>
                <a href="{{ route('admin.pkm.export') }}" class="btn btn-success me-2">
                    <i class="bi bi-file-excel"></i> Export
                </a>
                <a href="{{ route('admin.pkm.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah PKM
                </a>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.pkm.index') }}" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Cari</label>
                        <input type="text" name="search" class="form-control" placeholder="Judul PKM"
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
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
                    <div class="col-md-2">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-bold">Tahun</label>
                        <select name="tahun" class="form-select">
                            <option value="">Semua Tahun</option>
                            @foreach ($tahunList as $tahun)
                                <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                    {{ $tahun }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-bold">Bidang</label>
                        <input type="text" name="bidang_pkm" class="form-control" placeholder="Bidang PKM"
                            value="{{ request('bidang_pkm') }}">
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
                <h6 class="mb-0 fw-bold">Daftar Pengabdian Masyarakat (PKM)</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50">No</th>
                                <th>Judul PKM</th>
                                <th>Ketua Pelaksana</th>
                                <th>Bidang</th>
                                <th>Lokasi</th>
                                <th>Tahun</th>
                                <th>Dana</th>
                                <th>Status</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pkms as $index => $pkm)
                                <tr>
                                    <td>{{ $pkms->firstItem() + $index }}</td>
                                    <td>
                                        <strong>{{ Str::limit($pkm->judul_pkm, 50) }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $pkm->jenis_pkm }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar-sm"
                                                style="width: 32px; height: 32px; background: linear-gradient(135deg, #28a745, #20c997); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px;">
                                                {{ substr($pkm->dosen->nama ?? 'P', 0, 1) }}
                                            </div>
                                            <div>
                                                <span class="small">{{ $pkm->dosen->nama ?? '-' }}</span>
                                                <br>
                                                <small class="text-muted">{{ $pkm->dosen->nidn ?? '-' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $pkm->bidang_pkm }}</span>
                                    </td>
                                    <td>
                                        <i class="bi bi-geo-alt"></i> {{ Str::limit($pkm->lokasi_kegiatan, 20) }}
                                    </td>
                                    <td><span class="fw-bold">{{ $pkm->tahun }}</span></td>
                                    <td>
                                        <span class="text-success fw-bold">
                                            {{ 'Rp ' . number_format($pkm->jumlah_dana, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($pkm->status == 'aktif')
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Selesai</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.pkm.show', $pkm->id) }}" class="btn btn-info"
                                                title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.pkm.edit', $pkm->id) }}" class="btn btn-warning"
                                                title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger"
                                                onclick="confirmDelete({{ $pkm->id }}, '{{ $pkm->judul_pkm }}')"
                                                title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                        <form id="delete-form-{{ $pkm->id }}"
                                            action="{{ route('admin.pkm.destroy', $pkm->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-5">
                                        <i class="bi bi-inbox fs-1 text-muted"></i>
                                        <p class="mt-2 text-muted">Belum ada data PKM</p>
                                        <a href="{{ route('admin.pkm.create') }}" class="btn btn-sm btn-primary">
                                            Tambah PKM Sekarang
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="card-footer bg-white py-3">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="text-muted small">
                            <i class="bi bi-info-circle"></i>
                            Menampilkan {{ $pkms->firstItem() ?? 0 }} - {{ $pkms->lastItem() ?? 0 }}
                            dari {{ $pkms->total() }} data
                            @if ($pkms->total() > 0)
                                <span class="ms-2 text-success">
                                    (Halaman {{ $pkms->currentPage() }} dari {{ $pkms->lastPage() }})
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-end">
                            {{ $pkms->withQueryString()->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .avatar-sm {
            transition: transform 0.3s;
        }

        .table-hover tbody tr:hover .avatar-sm {
            transform: scale(1.1);
        }

        .pagination {
            margin-bottom: 0;
            gap: 5px;
        }

        .page-item .page-link {
            border-radius: 8px;
            color: #28a745;
            border: 1px solid #e0e0e0;
            padding: 8px 14px;
            font-size: 0.875rem;
            transition: all 0.3s;
        }

        .page-item .page-link:hover {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            border-color: transparent;
            transform: translateY(-2px);
        }

        .page-item.active .page-link {
            background: linear-gradient(135deg, #28a745, #20c997);
            border-color: transparent;
            color: white;
        }
    </style>

    <script>
        function confirmDelete(id, title) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                html: `Data PKM <strong>${title}</strong> akan dihapus!`,
                text: "Data yang dihapus tidak dapat dikembalikan!",
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
