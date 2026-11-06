@extends('components.layouts.app')
@section('title', 'Data Pelatihan')
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800"><i class="bi bi-easel"></i> Data Pelatihan</h1>
            <a href="{{ route('admin.pelatihan.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah
                Pelatihan</a>
        </div>

        @include('components.period-info')

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.pelatihan.index') }}" class="row g-3">
                    <div class="col-md-6">
                        <select name="dosen_id" class="form-select">
                            <option value="">Semua Dosen</option>
                            @foreach ($dosens as $dosen)
                                <option value="{{ $dosen->id }}"
                                    {{ request('dosen_id') == $dosen->id ? 'selected' : '' }}>{{ $dosen->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4"><button type="submit" class="btn btn-primary w-100">Filter</button></div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Dosen</th>
                            <th>Nama Pelatihan</th>
                            <th>Penyelenggara</th>
                            <th>Tgl</th>
                            <th>File</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pelatihans as $i => $item)
                            <tr>
                                <td>{{ $pelatihans->firstItem() + $i }}</td>
                                <td><strong>{{ $item->dosen->nama ?? '-' }}</strong></td>
                                <td>{{ $item->nama_pelatihan }}</td>
                                <td>{{ $item->penyelenggara }}</td>
                                <td>{{ $item->tanggal_pelatihan->format('d/m/Y') }}</td>
                                <td>
                                    @if ($item->file_sertifikat)
                                        <a href="{{ route('admin.pelatihan.download', $item->id) }}"
                                            class="btn btn-sm btn-success"><i class="bi bi-download"></i></a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.pelatihan.show', $item->id) }}" class="btn btn-info"><i
                                                class="bi bi-eye"></i></a>
                                        <a href="{{ route('admin.pelatihan.edit', $item->id) }}" class="btn btn-warning"><i
                                                class="bi bi-pencil"></i></a>
                                        <button type="button" class="btn btn-danger" onclick="del({{ $item->id }})"><i
                                                class="bi bi-trash"></i></button>
                                    </div>
                                    <form id="del-{{ $item->id }}"
                                        action="{{ route('admin.pelatihan.destroy', $item->id) }}" method="POST"
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
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya'
            }).then(r => {
                if (r.isConfirmed) document.getElementById('del-' + id).submit()
            })
        }
    </script>
@endsection
