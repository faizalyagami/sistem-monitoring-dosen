@extends('components.layouts.app')
@section('title', 'Data Asosiasi Profesi')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800"><i class="bi bi-diagram-3"></i> Asosiasi Profesi</h1>
                <p class="text-muted">Kelola data keanggotaan asosiasi profesi dosen</p>
            </div>
            <a href="{{ route('admin.asosiasi.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah
                Asosiasi</a>
        </div>

        @include('components.period-info')

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.asosiasi.index') }}" class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Dosen</label>
                        <select name="dosen_id" class="form-select">
                            <option value="">Semua Dosen</option>
                            @foreach ($dosens as $dosen)
                                <option value="{{ $dosen->id }}"
                                    {{ request('dosen_id') == $dosen->id ? 'selected' : '' }}>{{ $dosen->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i> Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Dosen</th>
                                <th>Nama Asosiasi</th>
                                <th>Peran</th>
                                <th>Masa Aktif</th>
                                <th>Tahun</th>
                                <th>Periode</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($asosiasis as $index => $item)
                                <tr>
                                    <td>{{ $asosiasis->firstItem() + $index }}</td>
                                    <td>
                                        <strong>{{ $item->dosen->nama ?? '-' }}</strong><br>
                                        <small class="text-muted">{{ $item->dosen->nidn ?? '-' }}</small>
                                    </td>
                                    <td>{{ $item->nama_asosiasi }}</td>
                                    <td><span class="badge bg-secondary">{{ $item->peran }}</span></td>
                                    <td>{{ $item->masa_aktif ? $item->masa_aktif->format('d/m/Y') : '-' }}</td>
                                    <td>{{ $item->tahun }}</td>
                                    <td>{{ $item->academicPeriod->nama_periode ?? '-' }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.asosiasi.show', $item->id) }}" class="btn btn-info"
                                                title="Detail"><i class="bi bi-eye"></i></a>
                                            <a href="{{ route('admin.asosiasi.edit', $item->id) }}" class="btn btn-warning"
                                                title="Edit"><i class="bi bi-pencil"></i></a>
                                            <button type="button" class="btn btn-danger"
                                                onclick="del({{ $item->id }})" title="Hapus"><i
                                                    class="bi bi-trash"></i></button>
                                        </div>
                                        <form id="del-{{ $item->id }}"
                                            action="{{ route('admin.asosiasi.destroy', $item->id) }}" method="POST"
                                            style="display:none">@csrf @method('DELETE')</form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">Belum ada data asosiasi</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white">{{ $asosiasis->withQueryString()->links() }}</div>
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
                })
                .then(r => {
                    if (r.isConfirmed) document.getElementById('del-' + id).submit();
                });
        }
    </script>
@endsection
