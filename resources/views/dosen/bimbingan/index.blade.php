@extends('components.layouts.app')

@section('title', 'Data Bimbingan Saya')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="bi bi-chat-dots"></i> Data Bimbingan
                </h1>
                <p class="text-muted">Kelola data bimbingan skripsi, tesis, dan disertasi</p>
            </div>
            <a href="{{ route('dosen.bimbingan.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Bimbingan
            </a>
        </div>

        <!-- Filter -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('dosen.bimbingan.index') }}" class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Jenis Bimbingan</label>
                        <select name="jenis_bimbingan" class="form-select">
                            <option value="">Semua Jenis</option>
                            <option value="skripsi" {{ request('jenis_bimbingan') == 'skripsi' ? 'selected' : '' }}>Skripsi
                            </option>
                            <option value="tesis" {{ request('jenis_bimbingan') == 'tesis' ? 'selected' : '' }}>Tesis
                            </option>
                            <option value="disertasi" {{ request('jenis_bimbingan') == 'disertasi' ? 'selected' : '' }}>
                                Disertasi</option>
                        </select>
                    </div>
                    <div class="col-md-6 d-flex align-items-end">
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
                                <th>Jenis Bimbingan</th>
                                <th>Kategori</th>
                                <th>Jumlah Mahasiswa</th>
                                <th>Semester</th>
                                <th>Tahun</th>
                                <th width="100">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bimbingans as $index => $bimbingan)
                                <tr>
                                    <td>{{ $bimbingans->firstItem() + $index }}</td>
                                    <td>
                                        @if ($bimbingan->jenis_bimbingan == 'skripsi')
                                            <span class="badge bg-primary">Skripsi</span>
                                        @elseif($bimbingan->jenis_bimbingan == 'tesis')
                                            <span class="badge bg-success">Tesis</span>
                                        @else
                                            <span class="badge bg-info">Disertasi</span>
                                        @endif
                                    </td>
                                    <td>{{ $bimbingan->kategori_bimbingan ?? '-' }}</td>
                                    <td>{{ $bimbingan->jumlah_mahasiswa }} Mahasiswa</td>
                                    <td>{{ ucfirst($bimbingan->semester) }}</td>
                                    <td>{{ $bimbingan->tahun_akademik }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('dosen.bimbingan.show', $bimbingan->id) }}"
                                                class="btn btn-info btn-sm" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('dosen.bimbingan.edit', $bimbingan->id) }}"
                                                class="btn btn-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger"
                                                onclick="confirmDelete({{ $bimbingan->id }})" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                        <form id="delete-form-{{ $bimbingan->id }}"
                                            action="{{ route('dosen.bimbingan.destroy', $bimbingan->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <i class="bi bi-inbox fs-1 text-muted"></i>
                                        <p class="mt-2">Belum ada data bimbingan</p>
                                        <a href="{{ route('dosen.bimbingan.create') }}" class="btn btn-sm btn-primary">
                                            Tambah Bimbingan
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white">
                {{ $bimbingans->withQueryString()->links() }}
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
