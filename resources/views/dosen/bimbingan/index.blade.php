@extends('components.layouts.app')

@section('title', 'Data Bimbingan Saya')

@section('content')
    <div class="container-fluid px-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="bi bi-chat-dots"></i> Data Bimbingan
                </h1>
                <p class="text-muted">Kelola data bimbingan skripsi, tesis, dan disertasi Anda</p>
            </div>
            <div>
                <a href="{{ route('dosen.bimbingan.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Bimbingan
                </a>
            </div>
        </div>

        <!-- Info Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Total Skripsi</h6>
                                <h4 class="mb-0 mt-2">{{ $bimbingans->where('jenis_bimbingan', 'skripsi')->count() }}</h4>
                            </div>
                            <i class="bi bi-book fs-1 opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Total Tesis</h6>
                                <h4 class="mb-0 mt-2">{{ $bimbingans->where('jenis_bimbingan', 'tesis')->count() }}</h4>
                            </div>
                            <i class="bi bi-mortarboard fs-1 opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Total Disertasi</h6>
                                <h4 class="mb-0 mt-2">{{ $bimbingans->where('jenis_bimbingan', 'disertasi')->count() }}</h4>
                            </div>
                            <i class="bi bi-award fs-1 opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Total Mahasiswa</h6>
                                <h4 class="mb-0 mt-2">{{ $bimbingans->sum('jumlah_mahasiswa') }}</h4>
                            </div>
                            <i class="bi bi-people fs-1 opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('dosen.bimbingan.index') }}" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Jenis Bimbingan</label>
                        <select name="jenis_bimbingan" class="form-select">
                            <option value="">Semua Jenis</option>
                            <option value="skripsi" {{ request('jenis_bimbingan') == 'skripsi' ? 'selected' : '' }}>Skripsi
                            </option>
                            <option value="tesis" {{ request('jenis_bimbingan') == 'tesis' ? 'selected' : '' }}>Tesis
                            </option>
                            <option value="disertasi" {{ request('jenis_bimbingan') == 'disertasi' ? 'selected' : '' }}>
                                Disertasi</option>
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
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Semester</label>
                        <select name="semester" class="form-select">
                            <option value="">Semua</option>
                            <option value="ganjil" {{ request('semester') == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                            <option value="genap" {{ request('semester') == 'genap' ? 'selected' : '' }}>Genap</option>
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
                <h6 class="mb-0 fw-bold">Daftar Bimbingan Mahasiswa</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="40">No</th>
                                <th>Jenis Bimbingan</th>
                                <th>Kategori</th>
                                <th>Jml Mahasiswa</th>
                                <th>No. SK Pembimbing</th>
                                <th>No. SK Penguji</th>
                                <th>Periode/Semester</th>
                                <th width="100">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bimbingans as $index => $bimbingan)
                                <tr>
                                    <td>{{ $bimbingans->firstItem() + $index }}</td>
                                    <td>
                                        @if ($bimbingan->jenis_bimbingan == 'skripsi')
                                            <span class="badge bg-primary">Skripsi</span>
                                        @elseif($bimbingan->jenis_bimbingan == 'tesis')
                                            <span class="badge bg-success">Tesis</span>
                                        @else
                                            <span class="badge bg-info">Disertasi</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $bimbingan->kategori_bimbingan ?? '-' }}</span>
                                    </td>
                                    <td>
                                        <span class="fw-bold">{{ $bimbingan->jumlah_mahasiswa }}</span>
                                    </td>

                                    {{-- SK Pembimbing --}}
                                    <td>
                                        @if ($bimbingan->no_sk_pembimbing)
                                            <span class="badge bg-info" title="{{ $bimbingan->no_sk_pembimbing }}">
                                                <i class="bi bi-file-text"></i>
                                                {{ Str::limit($bimbingan->no_sk_pembimbing, 15) }}
                                            </span>
                                            <br>
                                            <small class="text-muted">
                                                {{ $bimbingan->tanggal_sk_pembimbing ? date('d/m/Y', strtotime($bimbingan->tanggal_sk_pembimbing)) : '-' }}
                                            </small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>

                                    {{-- SK Penguji --}}
                                    <td>
                                        @if ($bimbingan->no_sk_penguji)
                                            <span class="badge bg-warning" title="{{ $bimbingan->no_sk_penguji }}">
                                                <i class="bi bi-file-text"></i>
                                                {{ Str::limit($bimbingan->no_sk_penguji, 15) }}
                                            </span>
                                            <br>
                                            <small class="text-muted">
                                                {{ $bimbingan->tanggal_sk_penguji ? date('d/m/Y', strtotime($bimbingan->tanggal_sk_penguji)) : '-' }}
                                            </small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>

                                    <td>
                                        <small>{{ $bimbingan->academicPeriod->nama_periode ?? '-' }}</small>
                                        <br>
                                        <span class="badge bg-{{ $bimbingan->semester == 'ganjil' ? 'info' : 'warning' }}">
                                            {{ ucfirst($bimbingan->semester) }}
                                        </span>
                                        / {{ $bimbingan->tahun_akademik }}
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('dosen.bimbingan.show', $bimbingan->id) }}"
                                                class="btn btn-info" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('dosen.bimbingan.edit', $bimbingan->id) }}"
                                                class="btn btn-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger"
                                                onclick="confirmDelete({{ $bimbingan->id }})" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                        <form id="delete-form-{{ $bimbingan->id }}"
                                            action="{{ route('dosen.bimbingan.destroy', $bimbingan->id) }}"
                                            method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <i class="bi bi-inbox fs-1 text-muted"></i>
                                        <p class="mt-2 text-muted">Belum ada data bimbingan</p>
                                        <a href="{{ route('dosen.bimbingan.create') }}" class="btn btn-sm btn-primary">
                                            Tambah Bimbingan Sekarang
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
                            Menampilkan {{ $bimbingans->firstItem() ?? 0 }} - {{ $bimbingans->lastItem() ?? 0 }}
                            dari {{ $bimbingans->total() }} data
                            @if ($bimbingans->total() > 0)
                                <span class="ms-2 text-success">
                                    (Halaman {{ $bimbingans->currentPage() }} dari {{ $bimbingans->lastPage() }})
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-end">
                            {{ $bimbingans->withQueryString()->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .badge {
            font-weight: 500;
        }

        .table td,
        .table th {
            padding: 10px 8px;
            vertical-align: middle;
        }

        .pagination {
            margin-bottom: 0;
            gap: 5px;
        }

        .page-item .page-link {
            border-radius: 8px;
            color: #6c5ce7;
            border: 1px solid #e0e0e0;
            padding: 8px 14px;
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
    </style>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data bimbingan yang dihapus tidak dapat dikembalikan!",
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
