@extends('components.layouts.app')

@section('title', 'Detail Penelitian')

@section('content')
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-md-10 mx-auto">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">
                            <i class="bi bi-info-circle"></i> Detail Penelitian
                        </h1>
                        <p class="text-muted">Informasi lengkap data penelitian</p>
                    </div>
                    <div>
                        <a href="{{ route('dosen.riset.edit', $riset->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <a href="{{ route('dosen.riset.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <!-- Main Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-mortarboard me-2 text-primary"></i> Informasi Penelitian
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="200">Judul Penelitian</th>
                                        <td>: <strong>{{ $riset->judul_riset }}</strong></td>
                                    </tr>
                                    <tr>
                                        <th>Bidang Riset</th>
                                        <td>: <span class="badge bg-info">{{ $riset->bidang_riset }}</span></td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Riset</th>
                                        <td>: {{ $riset->jenis_riset }}</td>
                                    </tr>
                                    <tr>
                                        <th>Sumber Dana</th>
                                        <td>: {{ $riset->sumber_dana }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jumlah Dana</th>
                                        <td>: <span
                                                class="text-success fw-bold">{{ 'Rp ' . number_format($riset->jumlah_dana, 0, ',', '.') }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>:
                                            @if ($riset->status == 'aktif')
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary">Selesai</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tahun</th>
                                        <td>: {{ $riset->tahun }}</td>
                                    </tr>
                                    <tr>
                                        <th>Periode Akademik</th>
                                        <td>: {{ $riset->academicPeriod->nama_periode ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Kolaborator</th>
                                        <td>: {{ $riset->kolaborator ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Link Publikasi</th>
                                        <td>:
                                            @if ($riset->publikasi_link)
                                                <a href="{{ $riset->publikasi_link }}" target="_blank">
                                                    {{ $riset->publikasi_link }}
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>File Laporan</th>
                                        <td>:
                                            @if ($riset->file_laporan)
                                                <a href="{{ route('dosen.riset.download', $riset->id) }}"
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
                                        <td>: {{ $riset->created_at->format('d F Y H:i:s') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Terakhir Update</th>
                                        <td>: {{ $riset->updated_at->format('d F Y H:i:s') }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <i class="bi bi-person-badge fs-1 text-primary"></i>
                                        <h6 class="mt-2">{{ $riset->dosen->nama ?? '-' }}</h6>
                                        <p class="text-muted small mb-0">{{ $riset->dosen->nidn ?? '-' }}</p>
                                        <p class="text-muted small">{{ $riset->dosen->jabatan_fungsional ?? '-' }}</p>
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
                        <a href="{{ route('dosen.riset.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <a href="{{ route('dosen.riset.edit', $riset->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Edit Data
                        </a>
                        <button type="button" class="btn btn-success" onclick="window.print()">
                            <i class="bi bi-printer"></i> Print
                        </button>
                    </div>
                </div>

                <form id="delete-form" action="{{ route('dosen.riset.destroy', $riset->id) }}" method="POST"
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
                html: `Data penelitian <strong>{{ $riset->judul_riset }}</strong> akan dihapus!`,
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
