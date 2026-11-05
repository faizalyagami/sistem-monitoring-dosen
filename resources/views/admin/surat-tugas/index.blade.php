@extends('components.layouts.app')
@section('content')
    <div class="container-fluid px-4">
        <h1 class="h3 mb-4">Data Surat Tugas</h1>
        <a href="{{ route('admin.surat-tugas.create') }}" class="btn btn-primary mb-3">Tambah Surat Tugas</a>
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Dosen</th>
                            <th>Nama Surat</th>
                            <th>No. Surat</th>
                            <th>File</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($suratTugas as $i => $item)
                            <tr>
                                <td>{{ $suratTugas->firstItem() + $i }}</td>
                                <td>{{ $item->dosen->nama ?? '-' }}</td>
                                <td>{{ $item->nama_surat_tugas }}</td>
                                <td>{{ $item->no_surat_tugas }}</td>
                                <td>
                                    @if ($item->file_surat)
                                        <a href="{{ route('admin.surat-tugas.download', $item->id) }}"
                                            class="btn btn-sm btn-success"><i class="bi bi-download"></i></a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.surat-tugas.show', $item->id) }}" class="btn btn-info"><i
                                                class="bi bi-eye"></i></a>
                                        <a href="{{ route('admin.surat-tugas.edit', $item->id) }}"
                                            class="btn btn-warning"><i class="bi bi-pencil"></i></a>
                                        <button type="button" class="btn btn-danger" onclick="del({{ $item->id }})"><i
                                                class="bi bi-trash"></i></button>
                                    </div>
                                    <form id="del-{{ $item->id }}"
                                        action="{{ route('admin.surat-tugas.destroy', $item->id) }}" method="POST"
                                        style="display:none">@csrf @method('DELETE')</form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white">{{ $suratTugas->links() }}</div>
        </div>
    </div>
    <script>
        function del(id) {
            Swal.fire({
                title: 'Hapus?',
                icon: 'warning',
                showCancelButton: true
            }).then(r => {
                if (r.isConfirmed) document.getElementById('del-' + id).submit()
            })
        }
    </script>
@endsection
