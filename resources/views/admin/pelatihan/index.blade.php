@extends('components.layouts.app')

@section('title', 'Data Pelatihan')

@section('content')
    <div class="container-fluid px-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="bi bi-mortarboard"></i> Data Pelatihan
                </h1>
                <p class="text-muted">Kelola data pelatihan dan workshop dosen</p>
            </div>
            <div>
                <a href="#" class="btn btn-success me-2">
                    <i class="bi bi-file-excel"></i> Export
                </a>
                <a href="{{ route('admin.pelatihan.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Pelatihan
                </a>
            </div>
        </div>

        <!-- Filter -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.pelatihan.index') }}" class="row g-3">
                    <div class="col-md-4">
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
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search"></i> Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Data Table -->
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">Daftar Pelatihan</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50">No</th>
                                <th>Dosen</th>
                                <th>Nama Pelatihan</th>
                                <th>Penyelenggara</th>
                                <th>Tanggal</th>
                                <th>Lokasi</th>
                                <th>Durasi</th>
                                <th>Sertifikat</th>
                                <th width="100">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pelatihans as $index => $pelatihan)
                                <tr>
                                    <td>{{ $pelatihans->firstItem() + $index }}</td>
                                    <td>
                                        <strong>{{ $pelatihan->dosen->nama ?? '-' }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $pelatihan->dosen->nidn ?? '-' }}</small>
                                    </td>
                                    <td><strong>{{ $pelatihan->nama_pelatihan }}</strong></td>
                                    <td>{{ $pelatihan->penyelenggara }}</td>
                                    <td>{{ $pelatihan->tanggal_pelatihan ? date('d/m/Y', strtotime($pelatihan->tanggal_pelatihan)) : '-' }}
                                    </td>
                                    <td>{{ $pelatihan->lokasi }}</td>
                                    <td>{{ $pelatihan->durasi ? $pelatihan->durasi . ' Jam' : '-' }}</td>
                                    <td>
                                        @if ($pelatihan->file_sertifikat)
                                            <a href="{{ route('admin.pelatihan.download', $pelatihan->id) }}"
                                                class="btn btn-sm btn-success" title="Download">
                                                <i class="bi bi-download"></i>
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.pelatihan.show', $pelatihan->id) }}"
                                                class="btn btn-info" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.pelatihan.edit', $pelatihan->id) }}"
                                                class="btn btn-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger"
                                                onclick="confirmDelete({{ $pelatihan->id }})" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                        <form id="delete-form-{{ $pelatihan->id }}"
                                            action="{{ route('admin.pelatihan.destroy', $pelatihan->id) }}" method="POST"
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
                                        <p class="mt-2 text-muted">Belum ada data pelatihan</p>
                                        <a href="{{ route('admin.pelatihan.create') }}" class="btn btn-sm btn-primary">
                                            Tambah Pelatihan
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
                            Menampilkan <strong>{{ $pelatihans->firstItem() ?? 0 }}</strong> -
                            <strong>{{ $pelatihans->lastItem() ?? 0 }}</strong>
                            dari <strong>{{ $pelatihans->total() }}</strong> data
                            @if ($pelatihans->total() > 0)
                                <span class="ms-2">
                                    (Halaman <strong>{{ $pelatihans->currentPage() }}</strong> dari
                                    <strong>{{ $pelatihans->lastPage() }}</strong>)
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-end">
                            @if ($pelatihans->hasPages())
                                <nav aria-label="Page navigation">
                                    <ul class="pagination pagination-sm mb-0">
                                        {{-- Previous Page Link --}}
                                        @if ($pelatihans->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link"><i class="bi bi-chevron-left"></i></span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $pelatihans->previousPageUrl() }}"
                                                    rel="prev">
                                                    <i class="bi bi-chevron-left"></i>
                                                </a>
                                            </li>
                                        @endif

                                        {{-- Pagination Elements --}}
                                        @php
                                            $start = max(1, $pelatihans->currentPage() - 2);
                                            $end = min($pelatihans->lastPage(), $pelatihans->currentPage() + 2);
                                        @endphp

                                        @if ($start > 1)
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $pelatihans->url(1) }}">1</a>
                                            </li>
                                            @if ($start > 2)
                                                <li class="page-item disabled"><span class="page-link">...</span></li>
                                            @endif
                                        @endif

                                        @for ($i = $start; $i <= $end; $i++)
                                            @if ($i == $pelatihans->currentPage())
                                                <li class="page-item active" aria-current="page">
                                                    <span class="page-link">{{ $i }}</span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link"
                                                        href="{{ $pelatihans->url($i) }}">{{ $i }}</a>
                                                </li>
                                            @endif
                                        @endfor

                                        @if ($end < $pelatihans->lastPage())
                                            @if ($end < $pelatihans->lastPage() - 1)
                                                <li class="page-item disabled"><span class="page-link">...</span></li>
                                            @endif
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="{{ $pelatihans->url($pelatihans->lastPage()) }}">{{ $pelatihans->lastPage() }}</a>
                                            </li>
                                        @endif

                                        {{-- Next Page Link --}}
                                        @if ($pelatihans->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $pelatihans->nextPageUrl() }}"
                                                    rel="next">
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

        /* Table styles */
        .table td,
        .table th {
            vertical-align: middle;
            padding: 12px 8px;
        }

        .btn-action {
            padding: 4px 8px;
            margin: 0 2px;
        }
    </style>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data pelatihan yang dihapus tidak dapat dikembalikan!",
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
