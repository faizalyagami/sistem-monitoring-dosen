@extends('components.layouts.app')
@section('title', 'Sertifikasi Saya')
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800"><i class="bi bi-patch-check"></i> Data Sertifikasi</h1>
            <a href="{{ route('dosen.sertifikasi.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah
                Sertifikasi</a>
        </div>
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Jenis Sertifikasi</th>
                            <th>Lembaga</th>
                            <th>No. Sertifikat</th>
                            <th>Tanggal</th>
                            <th>Valid Until</th>
                            <th>Status</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sertifikasis as $i => $item)
                            <tr>
                                <td>{{ $sertifikasis->firstItem() + $i }}</td>
                                <td>{{ $item->jenis_sertifikasi }}</td>
                                <td>{{ $item->lembaga_sertifikasi }}</td>
                                <td><code>{{ $item->nomor_sertifikasi }}</code></td>
                                <td>{{ $item->tanggal_sertifikasi->format('d/m/Y') }}</td>
                                <td>{{ $item->valid_until ? $item->valid_until->format('d/m/Y') : '-' }}</td>
                                <td>{!! $item->status !!}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        @if ($item->file_sertifikat)
                                            <a href="{{ route('dosen.sertifikasi.download', $item->id) }}"
                                                class="btn btn-success"><i class="bi bi-download"></i></a>
                                        @endif
                                        <a href="{{ route('dosen.sertifikasi.edit', $item->id) }}"
                                            class="btn btn-warning"><i class="bi bi-pencil"></i></a>
                                        <button type="button" class="btn btn-danger" onclick="del({{ $item->id }})"><i
                                                class="bi bi-trash"></i></button>
                                    </div>
                                    <form id="del-{{ $item->id }}"
                                        action="{{ route('dosen.sertifikasi.destroy', $item->id) }}" method="POST"
                                        style="display:none">@csrf @method('DELETE')</form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">Belum ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white">{{ $sertifikasis->links() }}</div>
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
