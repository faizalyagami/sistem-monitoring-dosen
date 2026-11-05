@extends('components.layouts.app')

@section('title', 'Data Pengajaran Saya')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800"><i class="bi bi-book"></i> Data Pengajaran</h1>
                <p class="text-muted">Kelola mata kuliah yang Anda ajarkan</p>
            </div>
            <a href="{{ route('dosen.pengajaran.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Pengajaran
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Kode MK</th>
                                <th>Nama Mata Kuliah</th>
                                <th>Kelas</th>
                                <th>SKS</th>
                                <th>Mhs</th>
                                <th>Semester</th>
                                <th width="100">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengajarans as $index => $item)
                                <tr>
                                    <td>{{ $pengajarans->firstItem() + $index }}</td>
                                    <td><strong>{{ $item->kode_mk }}</strong></td>
                                    <td>{{ $item->nama_mk }}</td>
                                    <td>{{ $item->kelas }}</td>
                                    <td>{{ $item->sks }}</td>
                                    <td>{{ $item->jumlah_mahasiswa }}</td>
                                    <td>{{ ucfirst($item->semester) }} {{ $item->tahun_akademik }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('dosen.pengajaran.show', $item->id) }}"
                                                class="btn btn-info"><i class="bi bi-eye"></i></a>
                                            <a href="{{ route('dosen.pengajaran.edit', $item->id) }}"
                                                class="btn btn-warning"><i class="bi bi-pencil"></i></a>
                                            <button type="button" class="btn btn-danger"
                                                onclick="confirmDelete({{ $item->id }})"><i
                                                    class="bi bi-trash"></i></button>
                                        </div>
                                        <form id="delete-form-{{ $item->id }}"
                                            action="{{ route('dosen.pengajaran.destroy', $item->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">Belum ada data pengajaran</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white">{{ $pengajarans->links() }}</div>
        </div>
    </div>
    <script>
        function confirmDelete(id) {
            Swal.fire({
                    title: 'Hapus Data?',
                    text: "Data tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!'
                })
                .then((result) => {
                    if (result.isConfirmed) document.getElementById('delete-form-' + id).submit();
                });
        }
    </script>
@endsection
