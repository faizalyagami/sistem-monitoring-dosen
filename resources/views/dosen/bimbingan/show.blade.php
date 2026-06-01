@extends('components.layouts.app')

@section('title', 'Detail Bimbingan')

@section('content')
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">
                            <i class="bi bi-info-circle"></i> Detail Bimbingan
                        </h1>
                        <p class="text-muted">Informasi lengkap data bimbingan mahasiswa</p>
                    </div>
                    <div>
                        <a href="{{ route('dosen.bimbingan.edit', $bimbingan->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <a href="{{ route('dosen.bimbingan.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <!-- Main Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-chat-dots me-2 text-primary"></i> Informasi Bimbingan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="200">Dosen Pembimbing</th>
                                        <td>: <strong>{{ $bimbingan->dosen->nama ?? '-' }}</strong></td>
                                    </tr>
                                    <tr>
                                        <th>NIDN</th>
                                        <td>: {{ $bimbingan->dosen->nidn ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jabatan</th>
                                        <td>: {{ $bimbingan->dosen->jabatan_fungsional ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Bimbingan</th>
                                        <td>:
                                            @if ($bimbingan->jenis_bimbingan == 'skripsi')
                                                <span class="badge bg-primary">Skripsi (S1)</span>
                                            @elseif($bimbingan->jenis_bimbingan == 'tesis')
                                                <span class="badge bg-success">Tesis (S2)</span>
                                            @else
                                                <span class="badge bg-info">Disertasi (S3)</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Kategori Bimbingan</th>
                                        <td>: <span
                                                class="badge bg-secondary">{{ $bimbingan->kategori_bimbingan ?? '-' }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Jumlah Mahasiswa</th>
                                        <td>: <span class="fw-bold">{{ $bimbingan->jumlah_mahasiswa }}</span> Mahasiswa</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-5">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <i class="bi bi-people-fill fs-1 text-primary"></i>
                                        <h6 class="mt-2">Total Bimbingan</h6>
                                        <h3 class="mb-0">{{ $bimbingan->jumlah_mahasiswa }}</h3>
                                        <small class="text-muted">Mahasiswa</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-calendar me-2 text-success"></i> Detail Akademik
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="180">Periode Akademik</th>
                                        <td>: {{ $bimbingan->academicPeriod->nama_periode ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Semester</th>
                                        <td>:
                                            <span
                                                class="badge bg-{{ $bimbingan->semester == 'ganjil' ? 'info' : 'warning' }}">
                                                {{ ucfirst($bimbingan->semester) }}
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="180">Tahun Akademik</th>
                                        <td>: <span class="badge bg-dark">{{ $bimbingan->tahun_akademik }}</span></td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Input</th>
                                        <td>: {{ $bimbingan->created_at->format('d F Y H:i:s') }}</td>
                                    </tr>
                                </table>
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
                        <a href="{{ route('dosen.bimbingan.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <a href="{{ route('dosen.bimbingan.edit', $bimbingan->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Edit Data
                        </a>
                        <button type="button" class="btn btn-success" onclick="window.print()">
                            <i class="bi bi-printer"></i> Print
                        </button>
                    </div>
                </div>

                <form id="delete-form" action="{{ route('dosen.bimbingan.destroy', $bimbingan->id) }}" method="POST"
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
            padding: 10px 0;
        }
    </style>

    <script>
        function confirmDelete() {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                html: `Data bimbingan ini akan dihapus!`,
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
