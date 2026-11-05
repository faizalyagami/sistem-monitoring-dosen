@extends('components.layouts.app')

@section('title', 'Data Penelitian Saya')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800"><i class="bi bi-mortarboard"></i> Data PKM</h1>
                <p class="text-muted">Kelola data PKM Anda</p>
            </div>
            <a href="{{ route('dosen.pkm.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah PKM
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50">No</th>
                                <th>Judul PKM</th>
                                <th>Bidang</th>
                                <th>Tahun</th>
                                <th>Dana</th>
                                <th>Status</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pkms as $index => $item)
                                <tr>
                                    <td>{{ $pkms->firstItem() + $index }}</td>
                                    <td><strong>{{ Str::limit($item->judul_pkm, 50) }}</strong></td>
                                    <td><span class="badge bg-info">{{ $item->bidang_pkm }}</span></td>
                                    <td>{{ $item->tahun }}</td>
                                    <td>Rp {{ number_format($item->jumlah_dana, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $item->status == 'aktif' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('dosen.pkm.show', $item->id) }}" class="btn btn-info"
                                                title="Detail"><i class="bi bi-eye"></i></a>
                                            <a href="{{ route('dosen.pkm.edit', $item->id) }}" class="btn btn-warning"
                                                title="Edit"><i class="bi bi-pencil"></i></a>
                                            <button type="button" class="btn btn-danger"
                                                onclick="confirmDelete({{ $item->id }})" title="Hapus"><i
                                                    class="bi bi-trash"></i></button>
                                        </div>
                                        <form id="delete-form-{{ $item->id }}"
                                            action="{{ route('dosen.pkm.destroy', $item->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <i class="bi bi-inbox fs-1 text-muted"></i>
                                        <p class="mt-2 text-muted">Belum ada data penelitian</p>
                                        <a href="{{ route('dosen.pkm.create') }}" class="btn btn-sm btn-primary">Tambah
                                            Penelitian</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white">{{ $pkms->withQueryString()->links() }}</div>
        </div>
    </div>
    <script>
        function confirmDelete(id) {
            Swal.fire({
                    title: 'Hapus Data?',
                    text: "Data tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!'
                })
                .then((result) => {
                    if (result.isConfirmed) document.getElementById('delete-form-' + id).submit();
                });
        }
    </script>
@endsection
