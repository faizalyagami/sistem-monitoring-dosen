@extends('components.layouts.app')

@section('title', 'Surat Tugas Saya')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800"><i class="bi bi-envelope-paper"></i> Surat Tugas</h1>
                <p class="text-muted">Kelola data surat tugas yang Anda terima</p>
            </div>
            <a href="{{ route('dosen.surat-tugas.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Surat Tugas
            </a>
        </div>

        @include('components.period-info')

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50">No</th>
                                <th>Nama Surat Tugas</th>
                                <th>No. Surat</th>
                                <th>Tanggal</th>
                                <th>Perihal</th>
                                <th>Periode</th>
                                <th>File</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($suratTugas as $index => $item)
                                <tr>
                                    <td>{{ $suratTugas->firstItem() + $index }}</td>
                                    <td><strong>{{ $item->nama_surat_tugas }}</strong></td>
                                    <td><code>{{ $item->no_surat_tugas }}</code></td>
                                    <td>{{ $item->tanggal_surat_tugas->format('d/m/Y') }}</td>
                                    <td>{{ Str::limit($item->perihal, 40) ?? '-' }}</td>
                                    <td><small class="text-muted">{{ $item->academicPeriod->nama_periode ?? '-' }}</small>
                                    </td>
                                    <td>
                                        @if ($item->file_surat)
                                            <a href="{{ route('dosen.surat-tugas.download', $item->id) }}"
                                                class="btn btn-sm btn-success" title="Download">
                                                <i class="bi bi-download"></i>
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('dosen.surat-tugas.show', $item->id) }}" class="btn btn-info"
                                                title="Detail"><i class="bi bi-eye"></i></a>
                                            <a href="{{ route('dosen.surat-tugas.edit', $item->id) }}"
                                                class="btn btn-warning" title="Edit"><i class="bi bi-pencil"></i></a>
                                            <button type="button" class="btn btn-danger"
                                                onclick="confirmDelete({{ $item->id }})" title="Hapus"><i
                                                    class="bi bi-trash"></i></button>
                                        </div>
                                        <form id="delete-form-{{ $item->id }}"
                                            action="{{ route('dosen.surat-tugas.destroy', $item->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                        <p class="text-muted mb-2">Belum ada data surat tugas</p>
                                        <a href="{{ route('dosen.surat-tugas.create') }}"
                                            class="btn btn-sm btn-primary">Tambah Surat Tugas</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white">{{ $suratTugas->withQueryString()->links() }}</div>
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                    title: 'Hapus Data?',
                    text: "Data surat tugas tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!'
                })
                .then(r => {
                    if (r.isConfirmed) document.getElementById('delete-form-' + id).submit();
                });
        }
    </script>
@endsection
