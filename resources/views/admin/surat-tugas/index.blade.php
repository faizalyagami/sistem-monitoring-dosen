@extends('components.layouts.app')

@section('title', 'Surat Tugas')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="bi bi-envelope-paper"></i> Surat Tugas
                </h1>
                <p class="text-muted">Kelola data surat tugas dosen</p>
            </div>
            <a href="{{ route('admin.surat-tugas.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Surat Tugas
            </a>
        </div>

        <!-- Filter -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.surat-tugas.index') }}" class="row g-3">
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
                                <th>Nama Surat Tugas</th>
                                <th>No. Surat</th>
                                <th>Tanggal Surat</th>
                                <th>Perihal</th>
                                <th>File</th>
                                <th width="100">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($suratTugas as $index => $surat)
                                <tr>
                                    <td>{{ $suratTugas->firstItem() + $index }}</td>
                                    <td>
                                        <strong>{{ $surat->dosen->nama ?? '-' }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $surat->dosen->nidn ?? '-' }}</small>
                                    </td>
                                    <td>{{ $surat->nama_surat_tugas }}</td>
                                    <td><code>{{ $surat->no_surat_tugas }}</code></td>
                                    <td>{{ $surat->tanggal_surat_tugas ? date('d/m/Y', strtotime($surat->tanggal_surat_tugas)) : '-' }}
                                    </td>
                                    <td>{{ Str::limit($surat->perihal, 30) }}</td>
                                    <td>
                                        @if ($surat->file_surat)
                                            <a href="{{ route('admin.surat-tugas.download', $surat->id) }}"
                                                class="btn btn-sm btn-success" title="Download">
                                                <i class="bi bi-download"></i>
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.surat-tugas.edit', $surat->id) }}"
                                                class="btn btn-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger"
                                                onclick="confirmDelete({{ $surat->id }})" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                        <form id="delete-form-{{ $surat->id }}"
                                            action="{{ route('admin.surat-tugas.destroy', $surat->id) }}" method="POST"
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
                                        <p class="mt-2 text-muted">Belum ada data surat tugas</p>
                                        <a href="{{ route('admin.surat-tugas.create') }}" class="btn btn-sm btn-primary">
                                            Tambah Surat Tugas
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white">
                {{ $suratTugas->withQueryString()->links() }}
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
