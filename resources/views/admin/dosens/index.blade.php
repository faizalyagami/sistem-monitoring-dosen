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
                <p class="text-muted">Kelola data dosen, lihat detail, edit, dan hapus</p>
            </div>
            <div>
                <a href="{{ route('admin.dosens.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Dosen
                </a>
            </div>
        </div>

        <!-- Filter -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.dosens.index') }}" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Cari</label>
                        <input type="text" name="search" class="form-control" placeholder="Nama, NIDN, NIK, Email..."
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
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
                        <label class="form-label">Pendidikan</label>
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

        <!-- Table -->
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50">No</th>
                                <th width="60">Foto</th>
                                <th>NIDN / NIK</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Pendidikan</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dosens ?? [] as $index => $dosen)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <img src="{{ $dosen->photo_url ?? 'https://ui-avatars.com/api/?background=4361ee&color=fff&name=' . urlencode($dosen->nama) }}"
                                            class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                                    </td>
                                    <td>
                                        <strong>{{ $dosen->nidn ?? '-' }}</strong><br>
                                        <small class="text-muted">{{ $dosen->nik ?? '-' }}</small>
                                    </td>
                                    <td>
                                        <strong>{{ $dosen->nama ?? '-' }}</strong><br>
                                        <small class="text-muted">{{ $dosen->jabatan_fungsional ?? '-' }}</small>
                                    </td>
                                    <td>{{ $dosen->email ?? '-' }}</td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'tetap' => 'success',
                                                'kontrak' => 'warning',
                                                'luar_biasa' => 'info',
                                                'pensiun' => 'secondary',
                                            ];
                                            $statusColor = $statusColors[$dosen->status] ?? 'secondary';
                                        @endphp
                                        <span
                                            class="badge bg-{{ $statusColor }}">{{ ucfirst($dosen->status ?? '-') }}</span>
                                    </td>
                                    <td>{{ $dosen->pendidikan_terakhir ?? '-' }}</td>
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
                                            <button type="button" class="btn btn-danger" title="Hapus"
                                                onclick="confirmDelete({{ $dosen->id }})">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                        <form id="delete-form-{{ $dosen->id }}"
                                            action="{{ route('admin.dosens.destroy', $dosen->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <i class="bi bi-inbox fs-1 text-muted"></i>
                                        <p class="mt-2 text-muted">Belum ada data dosen</p>
                                        <a href="{{ route('admin.dosens.create') }}" class="btn btn-sm btn-primary">
                                            Tambah Dosen Sekarang
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if (isset($dosens) && method_exists($dosens, 'links'))
                <div class="card-footer bg-white">
                    {{ $dosens->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
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
@endpush
