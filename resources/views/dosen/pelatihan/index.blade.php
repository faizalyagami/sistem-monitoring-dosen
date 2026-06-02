@extends('components.layouts.app')

@section('title', 'Data Pelatihan Saya')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="bi bi-mortarboard"></i> Data Pelatihan
                </h1>
                <p class="text-muted">Kelola data pelatihan dan workshop yang Anda ikuti</p>
            </div>
            <a href="{{ route('dosen.pelatihan.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Pelatihan
            </a>
        </div>

        <!-- Filter -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('dosen.pelatihan.index') }}" class="row g-3">
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
                                <th>Nama Pelatihan</th>
                                <th>Penyelenggara</th>
                                <th>Tanggal</th>
                                <th>Lokasi</th>
                                <th>Durasi</th>
                                <th>Sertifikat</th>
                                <th width="100">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pelatihans as $index => $pelatihan)
                                <tr>
                                    <td>{{ $pelatihans->firstItem() + $index }}</td>
                                    <td>
                                        <strong>{{ $pelatihan->nama_pelatihan }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $pelatihan->tahun }}</small>
                                    </td>
                                    <td>{{ $pelatihan->penyelenggara }}</td>
                                    <td>{{ $pelatihan->tanggal_pelatihan ? date('d/m/Y', strtotime($pelatihan->tanggal_pelatihan)) : '-' }}
                                    </td>
                                    <td>{{ $pelatihan->lokasi }}</td>
                                    <td>{{ $pelatihan->durasi ? $pelatihan->durasi . ' Jam' : '-' }}</td>
                                    <td>
                                        @if ($pelatihan->file_sertifikat)
                                            <a href="{{ route('dosen.pelatihan.download', $pelatihan->id) }}"
                                                class="btn btn-sm btn-success" title="Download">
                                                <i class="bi bi-download"></i>
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('dosen.pelatihan.edit', $pelatihan->id) }}"
                                                class="btn btn-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger"
                                                onclick="confirmDelete({{ $pelatihan->id }})" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                        <form id="delete-form-{{ $pelatihan->id }}"
                                            action="{{ route('dosen.pelatihan.destroy', $pelatihan->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <i class="bi bi-inbox fs-1 text-muted"></i>
                                        <p class="mt-2 text-muted">Belum ada data pelatihan</p>
                                        <a href="{{ route('dosen.pelatihan.create') }}" class="btn btn-sm btn-primary">
                                            Tambah Pelatihan
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white">
                {{ $pelatihans->withQueryString()->links() }}
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
