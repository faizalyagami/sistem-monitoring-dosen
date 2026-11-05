@extends('components.layouts.app')
@section('title', 'Pelatihan Saya')
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800"><i class="bi bi-mortarboard"></i> Data Pelatihan</h1>
            <a href="{{ route('dosen.pelatihan.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah
                Pelatihan</a>
        </div>
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Pelatihan</th>
                            <th>Penyelenggara</th>
                            <th>Tanggal</th>
                            <th>Durasi</th>
                            <th>Sertifikat</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pelatihans as $i => $item)
                            <tr>
                                <td>{{ $pelatihans->firstItem() + $i }}</td>
                                <td><strong>{{ $item->nama_pelatihan }}</strong><br><small
                                        class="text-muted">{{ $item->lokasi }}</small></td>
                                <td>{{ $item->penyelenggara }}</td>
                                <td>{{ $item->tanggal_pelatihan->format('d/m/Y') }}</td>
                                <td>{{ $item->durasi ? $item->durasi . ' Jam' : '-' }}</td>
                                <td>
                                    @if ($item->file_sertifikat)
                                        <a href="{{ route('dosen.pelatihan.download', $item->id) }}"
                                            class="btn btn-sm btn-success"><i class="bi bi-download"></i></a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('dosen.pelatihan.edit', $item->id) }}" class="btn btn-warning"><i
                                                class="bi bi-pencil"></i></a>
                                        <button type="button" class="btn btn-danger" onclick="del({{ $item->id }})"><i
                                                class="bi bi-trash"></i></button>
                                    </div>
                                    <form id="del-{{ $item->id }}"
                                        action="{{ route('dosen.pelatihan.destroy', $item->id) }}" method="POST"
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
            <div class="card-footer bg-white">{{ $pelatihans->links() }}</div>
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
