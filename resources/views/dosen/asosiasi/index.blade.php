@extends('components.layouts.app')
@section('title', 'Asosiasi Profesi Saya')
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800"><i class="bi bi-people"></i> Asosiasi Profesi</h1>
            <a href="{{ route('dosen.asosiasi.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah
                Asosiasi</a>
        </div>
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Asosiasi</th>
                            <th>Peran</th>
                            <th>Masa Aktif</th>
                            <th>Tahun</th>
                            <th>Periode</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($asosiasis as $i => $item)
                            <tr>
                                <td>{{ $asosiasis->firstItem() + $i }}</td>
                                <td>{{ $item->nama_asosiasi }}</td>
                                <td><span class="badge bg-secondary">{{ $item->peran }}</span></td>
                                <td>{{ $item->masa_aktif->format('d/m/Y') }}</td>
                                <td>{{ $item->tahun }}</td>
                                <td>{{ $item->academicPeriod->nama_periode ?? '-' }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('dosen.asosiasi.edit', $item->id) }}" class="btn btn-warning"><i
                                                class="bi bi-pencil"></i></a>
                                        <button type="button" class="btn btn-danger" onclick="del({{ $item->id }})"><i
                                                class="bi bi-trash"></i></button>
                                    </div>
                                    <form id="del-{{ $item->id }}"
                                        action="{{ route('dosen.asosiasi.destroy', $item->id) }}" method="POST"
                                        style="display:none">@csrf @method('DELETE')</form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Belum ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white">{{ $asosiasis->links() }}</div>
        </div>
    </div>
    <script>
        function del(id) {
            Swal.fire({
                title: 'Hapus?',
                text: "Data tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!'
            }).then(r => {
                if (r.isConfirmed) document.getElementById('del-' + id).submit()
            })
        }
    </script>
@endsection
