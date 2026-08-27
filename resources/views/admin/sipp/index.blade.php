@extends('components.layouts.app')

@section('title', 'SIPP - Surat Izin Praktik Psikologi')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="bi bi-award"></i> Surat Izin Praktik Psikologi (SIPP)
                </h1>
                <p class="text-muted">Kelola data Surat Izin Praktik Psikologi (SIPP) untuk Psikolog</p>
            </div>
            <a href="{{ route('admin.sipp.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah SIPP
            </a>
        </div>

        <!-- Filter -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.sipp.index') }}" class="row g-3">
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
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="kadaluarsa" {{ request('status') == 'kadaluarsa' ? 'selected' : '' }}>Kadaluarsa
                            </option>
                            <option value="dicabut" {{ request('status') == 'dicabut' ? 'selected' : '' }}>Dicabut</option>
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
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50">No</th>
                                <th>Dosen</th>
                                <th>No. Registrasi</th>
                                <th>Bidang Keilmuan</th>
                                <th>Penerbit</th>
                                <th>Tahun Terbit</th>
                                <th>Tanggal Kadaluarsa</th>
                                <th>Status</th>
                                <th width="100">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sipps as $index => $sipp)
                                <tr>
                                    <td>{{ $sipps->firstItem() + $index }}</td>
                                    <td>
                                        <strong>{{ $sipp->dosen->nama ?? '-' }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $sipp->dosen->nidn ?? '-' }}</small>
                                    </td>
                                    <td><code>{{ $sipp->no_registrasi }}</code></td>
                                    <td>{{ $sipp->bidang_keilmuan }}</span></td>
                                    <td>{{ $sipp->penerbit ?? '-' }}</span></td>
                                    <td>{{ $sipp->tahun_terbit }}</span></td>
                                    <td>
                                        @if ($sipp->tanggal_kadaluarsa)
                                            {{ date('d/m/Y', strtotime($sipp->tanggal_kadaluarsa)) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{!! $sipp->status_badge !!}</span></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.sipp.show', $sipp->id) }}" class="btn btn-info"
                                                title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.sipp.edit', $sipp->id) }}" class="btn btn-warning"
                                                title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger"
                                                onclick="confirmDelete({{ $sipp->id }})" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                        <form id="delete-form-{{ $sipp->id }}"
                                            action="{{ route('admin.sipp.destroy', $sipp->id) }}" method="POST"
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
                                        <p class="mt-2 text-muted">Belum ada data SIPP (Surat Izin Praktik Psikologi)</p>
                                        <a href="{{ route('admin.sipp.create') }}" class="btn btn-sm btn-primary">
                                            Tambah SIPP
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white">
                {{ $sipps->withQueryString()->links() }}
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data SIPP yang dihapus tidak dapat dikembalikan!",
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
