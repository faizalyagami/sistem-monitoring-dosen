@extends('components.layouts.app')

@section('title', 'Asosiasi')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="bi bi-people"></i> Asosiasi Profesi
                </h1>
                <p class="text-muted">Kelola data keanggotaan asosiasi profesi Anda</p>
            </div>
            <a href="{{ route('dosen.asosiasi.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Asosiasi
            </a>
        </div>

        <!-- Data Table -->
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50">No</th>
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
                                    <td><strong>{{ $asosiasi->nama_asosiasi }}</strong></td>
                                    <td>{{ $asosiasi->peran }}</td>
                                    <td>{{ $asosiasi->masa_aktif ? date('d/m/Y', strtotime($asosiasi->masa_aktif)) : '-' }}
                                    </td>
                                    <td>{{ $asosiasi->tahun }}</td>
                                    <td>{{ $asosiasi->academicPeriod->nama_periode ?? '-' }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('dosen.asosiasi.show', $asosiasi->id) }}" class="btn btn-info"
                                                title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('dosen.asosiasi.edit', $asosiasi->id) }}"
                                                class="btn btn-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger"
                                                onclick="confirmDelete({{ $asosiasi->id }})" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                        <form id="delete-form-{{ $asosiasi->id }}"
                                            action="{{ route('dosen.asosiasi.destroy', $asosiasi->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <i class="bi bi-inbox fs-1 text-muted"></i>
                                        <p class="mt-2 text-muted">Belum ada data asosiasi profesi</p>
                                        <a href="{{ route('dosen.asosiasi.create') }}" class="btn btn-sm btn-primary">
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
