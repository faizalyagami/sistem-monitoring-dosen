@extends('components.layouts.app')

@section('title', 'Data Pengajaran Saya')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="bi bi-book"></i> Data Pengajaran
                </h1>
                <p class="text-muted">Kelola data mata kuliah yang Anda ajarkan</p>
            </div>
            <a href="{{ route('dosen.pengajaran.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Pengajaran
            </a>
        </div>

        <!-- Filter -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('dosen.pengajaran.index') }}" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Cari</label>
                        <input type="text" name="search" class="form-control" placeholder="Kode MK / Nama MK"
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Periode</label>
                        <select name="academic_period_id" class="form-select">
                            <option value="">Semua Periode</option>
                            @foreach ($periods as $period)
                                <option value="{{ $period->id }}"
                                    {{ request('academic_period_id') == $period->id ? 'selected' : '' }}>
                                    {{ $period->nama_periode }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Semester</label>
                        <select name="semester" class="form-select">
                            <option value="">Semua</option>
                            <option value="ganjil" {{ request('semester') == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                            <option value="genap" {{ request('semester') == 'genap' ? 'selected' : '' }}>Genap</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
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
                                <th>Kode MK</th>
                                <th>Nama Mata Kuliah</th>
                                <th>Kelas</th>
                                <th>SKS</th>
                                <th>Mahasiswa</th>
                                <th>Semester</th>
                                <th>Tahun</th>
                                <th width="100">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengajarans as $index => $pengajaran)
                                <tr>
                                    <td>{{ $pengajarans->firstItem() + $index }}</td>
                                    <td><strong>{{ $pengajaran->kode_mk }}</strong></td>
                                    <td>{{ $pengajaran->nama_mk }}</td>
                                    <td>{{ $pengajaran->kelas }}</td>
                                    <td>{{ $pengajaran->sks }} SKS</td>
                                    <td>{{ $pengajaran->jumlah_mahasiswa }} Mhs</td>
                                    <td>{{ ucfirst($pengajaran->semester) }}</td>
                                    <td>{{ $pengajaran->tahun_akademik }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('dosen.pengajaran.show', $pengajaran->id) }}"
                                                class="btn btn-info" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('dosen.pengajaran.edit', $pengajaran->id) }}"
                                                class="btn btn-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger"
                                                onclick="confirmDelete({{ $pengajaran->id }})" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                        <form id="delete-form-{{ $pengajaran->id }}"
                                            action="{{ route('dosen.pengajaran.destroy', $pengajaran->id) }}"
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
                                        <p class="mt-2 text-muted">Belum ada data pengajaran</p>
                                        <a href="{{ route('dosen.pengajaran.create') }}" class="btn btn-sm btn-primary">
                                            Tambah Pengajaran
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white">
                {{ $pengajarans->withQueryString()->links() }}
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
