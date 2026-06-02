@extends('components.layouts.app')

@section('title', 'Sertifikasi Saya')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="bi bi-patch-check"></i> Sertifikasi
                </h1>
                <p class="text-muted">Kelola data sertifikasi profesional Anda</p>
            </div>
            <a href="{{ route('dosen.sertifikasi.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Sertifikasi
            </a>
        </div>

        <!-- Filter -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('dosen.sertifikasi.index') }}" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Tahun</label>
                        <select name="tahun" class="form-select">
                            <option value="">Semua Tahun</option>
                            @foreach ($tahunList as $tahun)
                                <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                    {{ $tahun }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search"></i> Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Data Table -->
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50">No</th>
                                <th>Jenis Sertifikasi</th>
                                <th>Lembaga</th>
                                <th>No. Sertifikat</th>
                                <th>Tanggal</th>
                                <th>Valid Until</th>
                                <th>Status</th>
                                <th>File</th>
                                <th width="100">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sertifikasis as $index => $sertifikasi)
                                <tr>
                                    <td>{{ $sertifikasis->firstItem() + $index }}</td>
                                    <td><strong>{{ $sertifikasi->jenis_sertifikasi }}</strong></td>
                                    <td>{{ $sertifikasi->lembaga_sertifikasi }}</td>
                                    <td><code>{{ $sertifikasi->nomor_sertifikasi }}</code></td>
                                    <td>{{ $sertifikasi->tanggal_sertifikasi ? date('d/m/Y', strtotime($sertifikasi->tanggal_sertifikasi)) : '-' }}
                                    </td>
                                    <td>{{ $sertifikasi->valid_until ? date('d/m/Y', strtotime($sertifikasi->valid_until)) : '-' }}
                                    </td>
                                    <td>{!! $sertifikasi->status !!}</td>
                                    <td>
                                        @if ($sertifikasi->file_sertifikat)
                                            <a href="{{ route('dosen.sertifikasi.download', $sertifikasi->id) }}"
                                                class="btn btn-sm btn-success" title="Download">
                                                <i class="bi bi-download"></i>
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('dosen.sertifikasi.edit', $sertifikasi->id) }}"
                                                class="btn btn-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger"
                                                onclick="confirmDelete({{ $sertifikasi->id }})" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                        <form id="delete-form-{{ $sertifikasi->id }}"
                                            action="{{ route('dosen.sertifikasi.destroy', $sertifikasi->id) }}"
                                            method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-5">
                                        <i class="bi bi-inbox fs-1 text-muted"></i>
                                        <p class="mt-2 text-muted">Belum ada data sertifikasi</p>
                                        <a href="{{ route('dosen.sertifikasi.create') }}" class="btn btn-sm btn-primary">
                                            Tambah Sertifikasi
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white">
                {{ $sertifikasis->withQueryString()->links() }}
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
