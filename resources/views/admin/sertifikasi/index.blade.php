@extends('components.layouts.app')

@section('title', 'Sertifikasi')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="bi bi-patch-check"></i> Sertifikasi
                </h1>
                <p class="text-muted">Kelola data sertifikasi dosen</p>
            </div>
            <a href="{{ route('admin.sertifikasi.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Sertifikasi
            </a>
        </div>

        <!-- Filter -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.sertifikasi.index') }}" class="row g-3">
                    <div class="col-md-5">
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
                    <div class="col-md-5">
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
                                <th>Dosen</th>
                                <th>Jenis Sertifikasi</th>
                                <th>Lembaga</th>
                                <th>No. Sertifikat</th>
                                <th>Tanggal</th>
                                <th>Valid Until</th>
                                <th>Status</th>
                                <th>File</th>
                                <th width="100">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sertifikasis as $index => $sertifikasi)
                                <tr>
                                    <td>{{ $sertifikasis->firstItem() + $index }}</td>
                                    <td>
                                        <strong>{{ $sertifikasi->dosen->nama ?? '-' }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $sertifikasi->dosen->nidn ?? '-' }}</small>
                                    </td>
                                    <td>{{ $sertifikasi->jenis_sertifikasi }}</td>
                                    <td>{{ $sertifikasi->lembaga_sertifikasi }}</td>
                                    <td><code>{{ $sertifikasi->nomor_sertifikasi }}</code></td>
                                    <td>{{ $sertifikasi->tanggal_sertifikasi ? date('d/m/Y', strtotime($sertifikasi->tanggal_sertifikasi)) : '-' }}
                                    <td>{{ $sertifikasi->valid_until ? date('d/m/Y', strtotime($sertifikasi->valid_until)) : '-' }}

                                    <td>{!! $sertifikasi->status !!}</td>
                                    <td>
                                        @if ($sertifikasi->file_sertifikat)
                                            <a href="{{ route('admin.sertifikasi.download', $sertifikasi->id) }}"
                                                class="btn btn-sm btn-success" title="Download">
                                                <i class="bi bi-download"></i>
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.sertifikasi.show', $sertifikasi->id) }}"
                                                class="btn btn-info" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.sertifikasi.edit', $sertifikasi->id) }}"
                                                class="btn btn-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger"
                                                onclick="confirmDelete({{ $sertifikasi->id }})" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                        <form id="delete-form-{{ $sertifikasi->id }}"
                                            action="{{ route('admin.sertifikasi.destroy', $sertifikasi->id) }}"
                                            method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-5">
                                        <i class="bi bi-inbox fs-1 text-muted"></i>
                                        <p class="mt-2 text-muted">Belum ada data sertifikasi</p>
                                        <a href="{{ route('admin.sertifikasi.create') }}" class="btn btn-sm btn-primary">
                                            Tambah Sertifikasi
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
                            Menampilkan <strong>{{ $sertifikasis->firstItem() ?? 0 }}</strong> -
                            <strong>{{ $sertifikasis->lastItem() ?? 0 }}</strong>
                            dari <strong>{{ $sertifikasis->total() }}</strong> data
                            @if ($sertifikasis->total() > 0)
                                <span class="ms-2">
                                    (Halaman <strong>{{ $sertifikasis->currentPage() }}</strong> dari
                                    <strong>{{ $sertifikasis->lastPage() }}</strong>)
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-end">
                            @if ($sertifikasis->hasPages())
                                <nav aria-label="Page navigation">
                                    <ul class="pagination pagination-sm mb-0">
                                        {{-- Previous Page Link --}}
                                        @if ($sertifikasis->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link"><i class="bi bi-chevron-left"></i></span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $sertifikasis->previousPageUrl() }}"
                                                    rel="prev">
                                                    <i class="bi bi-chevron-left"></i>
                                                </a>
                                            </li>
                                        @endif

                                        {{-- Pagination Elements --}}
                                        @php
                                            $start = max(1, $sertifikasis->currentPage() - 2);
                                            $end = min($sertifikasis->lastPage(), $sertifikasis->currentPage() + 2);
                                        @endphp

                                        @if ($start > 1)
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $sertifikasis->url(1) }}">1</a>
                                            </li>
                                            @if ($start > 2)
                                                <li class="page-item disabled"><span class="page-link">...</span></li>
                                            @endif
                                        @endif

                                        @for ($i = $start; $i <= $end; $i++)
                                            @if ($i == $sertifikasis->currentPage())
                                                <li class="page-item active" aria-current="page">
                                                    <span class="page-link">{{ $i }}</span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link"
                                                        href="{{ $sertifikasis->url($i) }}">{{ $i }}</a>
                                                </li>
                                            @endif
                                        @endfor

                                        @if ($end < $sertifikasis->lastPage())
                                            @if ($end < $sertifikasis->lastPage() - 1)
                                                <li class="page-item disabled"><span class="page-link">...</span></li>
                                            @endif
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="{{ $sertifikasis->url($sertifikasis->lastPage()) }}">{{ $sertifikasis->lastPage() }}</a>
                                            </li>
                                        @endif

                                        {{-- Next Page Link --}}
                                        @if ($sertifikasis->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $sertifikasis->nextPageUrl() }}"
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
            color: #28a745;
            border: 1px solid #e0e0e0;
            padding: 6px 12px;
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
    </style>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
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
