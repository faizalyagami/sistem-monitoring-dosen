@extends('components.layouts.app')

@section('title', 'SIPP Saya')

@section('content')
    <div class="container-fluid px-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="bi bi-award"></i> SIPP (Surat Izin Praktik Psikologi)
                </h1>
                <p class="text-muted">Kelola data Surat Izin Praktik Psikologi Anda</p>
            </div>
            <a href="{{ route('dosen.sipp.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah SIPP
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
                                <th>No. Registrasi</th>
                                <th>Bidang Keilmuan</th>
                                <th>Tahun Terbit</th>
                                <th>Status</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sipps as $index => $sipp)
                                <tr>
                                    <td>{{ $sipps->firstItem() + $index }}</td>
                                    <td><code class="fw-bold">{{ $sipp->no_registrasi }}</code></td>
                                    <td>{{ $sipp->bidang_keilmuan }}</td>
                                    <td>{{ $sipp->tahun_terbit }}</td>
                                    <td>{!! $sipp->status_badge !!}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            @if ($sipp->file_sipp)
                                                <a href="{{ route('dosen.sipp.download', $sipp->id) }}"
                                                    class="btn btn-success" title="Download File">
                                                    <i class="bi bi-download"></i>
                                                </a>
                                            @endif
                                            <a href="{{ route('dosen.sipp.edit', $sipp->id) }}" class="btn btn-warning"
                                                title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger"
                                                onclick="confirmDelete({{ $sipp->id }})" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                        <form id="delete-form-{{ $sipp->id }}"
                                            action="{{ route('dosen.sipp.destroy', $sipp->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                        <p class="text-muted mb-2">Belum ada data SIPP</p>
                                        <a href="{{ route('dosen.sipp.create') }}" class="btn btn-sm btn-primary">Tambah
                                            SIPP</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="card-footer bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Menampilkan {{ $sipps->firstItem() ?? 0 }} - {{ $sipps->lastItem() ?? 0 }} dari
                        {{ $sipps->total() }} data
                    </div>
                    <div>
                        {{ $sipps->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>
                </div>
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
