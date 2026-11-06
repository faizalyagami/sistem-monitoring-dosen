@extends('components.layouts.app')

@section('title', 'Data Bimbingan Saya')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800"><i class="bi bi-chat-dots"></i> Data Bimbingan</h1>
                <p class="text-muted">Kelola data bimbingan skripsi, tesis, dan disertasi</p>
            </div>
            <a href="{{ route('dosen.bimbingan.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Bimbingan
            </a>
        </div>

        @include('components.period-info')

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50">No</th>
                                <th>Jenis Bimbingan</th>
                                <th>Kategori</th>
                                <th>Jml Mahasiswa</th>
                                <th>No. SK Pembimbing</th>
                                <th>No. SK Penguji</th>
                                <th>Periode/Semester</th>
                                <th width="120">Aksi</th>
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
                                    <td><span class="badge bg-secondary">{{ $bimbingan->kategori_bimbingan ?? '-' }}</span>
                                    </td>
                                    <td><span class="fw-bold">{{ $bimbingan->jumlah_mahasiswa }}</span> Mhs</td>
                                    <td>
                                        @if ($bimbingan->no_sk_pembimbing)
                                            <span class="badge bg-info"
                                                title="{{ $bimbingan->no_sk_pembimbing }}">{{ Str::limit($bimbingan->no_sk_pembimbing, 15) }}</span>
                                            <br><small
                                                class="text-muted">{{ $bimbingan->tanggal_sk_pembimbing ? $bimbingan->tanggal_sk_pembimbing->format('d/m/Y') : '-' }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($bimbingan->no_sk_penguji)
                                            <span class="badge bg-warning text-dark"
                                                title="{{ $bimbingan->no_sk_penguji }}">{{ Str::limit($bimbingan->no_sk_penguji, 15) }}</span>
                                            <br><small
                                                class="text-muted">{{ $bimbingan->tanggal_sk_penguji ? $bimbingan->tanggal_sk_penguji->format('d/m/Y') : '-' }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>{{ $bimbingan->academicPeriod->nama_periode ?? '-' }}</small>
                                        <br>
                                        <span
                                            class="badge bg-{{ $bimbingan->semester == 'ganjil' ? 'info' : 'warning' }}">{{ ucfirst($bimbingan->semester) }}</span>
                                        / {{ $bimbingan->tahun_akademik }}
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('dosen.bimbingan.show', $bimbingan->id) }}"
                                                class="btn btn-info" title="Detail"><i class="bi bi-eye"></i></a>
                                            <a href="{{ route('dosen.bimbingan.edit', $bimbingan->id) }}"
                                                class="btn btn-warning" title="Edit"><i class="bi bi-pencil"></i></a>
                                            <button type="button" class="btn btn-danger"
                                                onclick="confirmDelete({{ $bimbingan->id }})" title="Hapus"><i
                                                    class="bi bi-trash"></i></button>
                                        </div>
                                        <form id="delete-form-{{ $bimbingan->id }}"
                                            action="{{ route('dosen.bimbingan.destroy', $bimbingan->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <i class="bi bi-inbox fs-1 text-muted"></i>
                                        <p class="mt-2 text-muted">Belum ada data bimbingan</p>
                                        <a href="{{ route('dosen.bimbingan.create') }}"
                                            class="btn btn-sm btn-primary">Tambah Bimbingan</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white">{{ $bimbingans->withQueryString()->links() }}</div>
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data bimbingan yang dihapus tidak dapat dikembalikan!",
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
