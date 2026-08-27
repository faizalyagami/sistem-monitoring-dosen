@extends('components.layouts.app')

@section('title', 'Asosiasi Profesi')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="bi bi-people"></i> Asosiasi Profesi
                </h1>
                <p class="text-muted">Kelola data keanggotaan asosiasi profesi dosen</p>
            </div>
            <a href="{{ route('admin.asosiasi.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Asosiasi
            </a>
        </div>

        <!-- Filter -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.asosiasi.index') }}" class="row g-3">
                    <div class="col-md-6">
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
                    <div class="col-md-4 d-flex align-items-end">
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
                                <th>Nama Asosiasi</th>
                                <th>Peran</th>
                                <th>Masa Aktif</th>
                                <th>Tahun</th>
                                <th>Periode</th>
                                <th width="100">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($asosiasis as $index => $asosiasi)
                                <tr>
                                    <td>{{ $asosiasis->firstItem() + $index }}</td>
                                    <td>
                                        <strong>{{ $asosiasi->dosen->nama ?? '-' }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $asosiasi->dosen->nidn ?? '-' }}</small>
                                    </td>
                                    <td>{{ $asosiasi->nama_asosiasi }}</td>
                                    <td>{{ $asosiasi->peran }}</td>
                                    <td>{{ $asosiasi->masa_aktif ? date('d/m/Y', strtotime($asosiasi->masa_aktif)) : '-' }}
                                    </td>
                                    <td>{{ $asosiasi->tahun }}</td>
                                    <td>{{ $asosiasi->academicPeriod->nama_periode ?? '-' }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.asosiasi.show', $asosiasi->id) }}"
                                                class="btn btn-info" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.asosiasi.edit', $asosiasi->id) }}"
                                                class="btn btn-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger"
                                                onclick="confirmDelete({{ $asosiasi->id }})" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                        <form id="delete-form-{{ $asosiasi->id }}"
                                            action="{{ route('admin.asosiasi.destroy', $asosiasi->id) }}" method="POST"
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
                                        <p class="mt-2 text-muted">Belum ada data asosiasi profesi</p>
                                        <a href="{{ route('admin.asosiasi.create') }}" class="btn btn-sm btn-primary">
                                            Tambah Asosiasi
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white">
                {{ $asosiasis->withQueryString()->links() }}
            </div>
        </div>
    </div>

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
