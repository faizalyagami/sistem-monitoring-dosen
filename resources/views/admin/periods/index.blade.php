@extends('components.layouts.app')

@section('title', 'Periode Akademik')

@section('content')
    <div class="container-fluid px-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="bi bi-calendar"></i> Periode Akademik
                </h1>
                <p class="text-muted">Kelola periode akademik, set periode aktif, dan monitoring periode</p>
            </div>
            <div>
                <a href="{{ route('admin.periods.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Periode
                </a>
            </div>
        </div>

        <!-- Period Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Periode Aktif</h6>
                                <h4 class="mb-0 mt-2">{{ $activePeriod ? $activePeriod->nama_periode : '-' }}</h4>
                            </div>
                            <i class="bi bi-calendar-check fs-1 opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Total Periode</h6>
                                <h4 class="mb-0 mt-2">{{ $periods->total() ?? 0 }}</h4>
                            </div>
                            <i class="bi bi-calendar fs-1 opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h6 class="mb-0 fw-bold">Daftar Periode Akademik</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50">No</th>
                                <th>Nama Periode</th>
                                <th>Kode</th>
                                <th>Semester</th>
                                <th>Tahun Ajaran</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($periods ?? [] as $index => $period)
                                <tr>
                                    <td>{{ $periods->firstItem() + $index }}</td>
                                    <td>
                                        <strong>{{ $period->nama_periode }}</strong>
                                        @if ($period->is_active)
                                            <span class="badge bg-success ms-2">Aktif</span>
                                        @endif
                                    </td>
                                    <td><code>{{ $period->kode_periode }}</code></td>
                                    <td>
                                        <span class="badge bg-{{ $period->semester == 'ganjil' ? 'primary' : 'warning' }}">
                                            {{ ucfirst($period->semester) }}
                                        </span>
                                    </td>
                                    <td>{{ $period->tahun_awal }}/{{ $period->tahun_akhir }}</td>
                                    <td>
                                        @if ($period->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @elseif($period->is_closed)
                                            <span class="badge bg-secondary">Ditutup</span>
                                        @else
                                            <span class="badge bg-info">Mendatang</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>
                                            {{ $period->tanggal_mulai ? date('d/m/Y', strtotime($period->tanggal_mulai)) : '-' }}
                                            <br>
                                            {{ $period->tanggal_selesai ? date('d/m/Y', strtotime($period->tanggal_selesai)) : '-' }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            @if (!$period->is_active && !$period->is_closed)
                                                <button type="button" class="btn btn-success"
                                                    onclick="setActive({{ $period->id }})" title="Set Aktif">
                                                    <i class="bi bi-check-circle"></i>
                                                </button>
                                            @endif
                                            <a href="{{ route('admin.periods.edit', $period->id) }}"
                                                class="btn btn-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger"
                                                onclick="confirmDelete({{ $period->id }})" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                        <form id="delete-form-{{ $period->id }}"
                                            action="{{ route('admin.periods.destroy', $period->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <form id="active-form-{{ $period->id }}"
                                            action="{{ route('admin.periods.set-active', $period->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <i class="bi bi-inbox fs-1 text-muted"></i>
                                        <p class="mt-2 text-muted">Belum ada periode akademik</p>
                                        <a href="{{ route('admin.periods.create') }}" class="btn btn-sm btn-primary">
                                            Tambah Periode Sekarang
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if (isset($periods) && method_exists($periods, 'links'))
                <div class="card-footer bg-white">
                    {{ $periods->withQueryString()->links() }}
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
                text: "Periode akademik yang dihapus tidak dapat dikembalikan!",
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

        function setActive(id) {
            Swal.fire({
                title: 'Set Periode Aktif?',
                text: "Periode ini akan menjadi periode aktif saat ini",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, set aktif!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('active-form-' + id).submit();
                }
            });
        }
    </script>
@endpush
