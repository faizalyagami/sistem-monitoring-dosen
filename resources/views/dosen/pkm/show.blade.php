@extends('components.layouts.app')

@section('title', 'Detail PKM')

@section('content')
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-md-10 mx-auto">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">
                            <i class="bi bi-info-circle"></i> Detail PKM
                        </h1>
                        <p class="text-muted">Informasi lengkap data pengabdian masyarakat</p>
                    </div>
                    <div>
                        <a href="{{ route('dosen.pkm.edit', $pkm->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <a href="{{ route('dosen.pkm.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <!-- Main Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-people-fill me-2 text-success"></i> Informasi PKM
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="200">Judul PKM</th>
                                        <td>: <strong>{{ $pkm->judul_pkm }}</strong></td>
                                    </tr>
                                    <tr>
                                        <th>Bidang PKM</th>
                                        <td>: <span class="badge bg-info">{{ $pkm->bidang_pkm }}</span></td>
                                    </tr>
                                    <tr>
                                        <th>Jenis PKM</th>
                                        <td>: {{ $pkm->jenis_pkm }}</td>
                                    </tr>
                                    <tr>
                                        <th>Sumber Dana</th>
                                        <td>: {{ $pkm->sumber_dana }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jumlah Dana</th>
                                        <td>: <span
                                                class="text-success fw-bold">{{ 'Rp ' . number_format($pkm->jumlah_dana, 0, ',', '.') }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Lokasi Kegiatan</th>
                                        <td>: <i class="bi bi-geo-alt"></i> {{ $pkm->lokasi_kegiatan }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>:
                                            @if ($pkm->status == 'aktif')
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary">Selesai</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tahun</th>
                                        <td>: {{ $pkm->tahun }}</td>
                                    </tr>
                                    <tr>
                                        <th>Periode Akademik</th>
                                        <td>: {{ $pkm->academicPeriod->nama_periode ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Link Publikasi</th>
                                        <td>:
                                            @if ($pkm->publikasi_link)
                                                <a href="{{ $pkm->publikasi_link }}" target="_blank">
                                                    {{ Str::limit($pkm->publikasi_link, 50) }}
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>File Laporan</th>
                                        <td>:
                                            @if ($pkm->file_laporan)
                                                <a href="{{ route('dosen.pkm.download', $pkm->id) }}"
                                                    class="btn btn-sm btn-success">
                                                    <i class="bi bi-download"></i> Download
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Input</th>
                                        <td>: {{ $pkm->created_at->format('d F Y H:i:s') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Terakhir Update</th>
                                        <td>: {{ $pkm->updated_at->format('d F Y H:i:s') }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <i class="bi bi-person-badge fs-1 text-success"></i>
                                        <h6 class="mt-2">{{ $pkm->dosen->nama ?? '-' }}</h6>
                                        <p class="text-muted small mb-0">{{ $pkm->dosen->nidn ?? '-' }}</p>
                                        <p class="text-muted small">{{ $pkm->dosen->jabatan_fungsional ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-between gap-2">
                    <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                        <i class="bi bi-trash"></i> Hapus Data
                    </button>
                    <div>
                        <a href="{{ route('dosen.pkm.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <a href="{{ route('dosen.pkm.edit', $pkm->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Edit Data
                        </a>
                        <button type="button" class="btn btn-success" onclick="window.print()">
                            <i class="bi bi-printer"></i> Print
                        </button>
                    </div>
                </div>

                <form id="delete-form" action="{{ route('dosen.pkm.destroy', $pkm->id) }}" method="POST"
                    style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>

    <style>
        .table-borderless th,
        .table-borderless td {
            padding: 12px 0;
        }
    </style>

    <script>
        function confirmDelete() {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                html: `Data PKM <strong>{{ $pkm->judul_pkm }}</strong> akan dihapus!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form').submit();
                }
            });
        }
    </script>
@endsection
