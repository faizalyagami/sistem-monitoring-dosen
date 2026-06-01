@extends('components.layouts.app')

@section('title', 'Detail Pengajaran')

@section('content')
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">
                            <i class="bi bi-info-circle"></i> Detail Pengajaran
                        </h1>
                        <p class="text-muted">Informasi lengkap mata kuliah yang diajarkan</p>
                    </div>
                    <div>
                        <a href="{{ route('dosen.pengajaran.edit', $pengajaran->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <a href="{{ route('dosen.pengajaran.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <!-- Main Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-book me-2 text-primary"></i> Informasi Mata Kuliah
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="150">Kode Mata Kuliah</th>
                                        <td>: <code class="fw-bold">{{ $pengajaran->kode_mk }}</code></td>
                                    </tr>
                                    <tr>
                                        <th>Nama Mata Kuliah</th>
                                        <td>: <strong>{{ $pengajaran->nama_mk }}</strong></td>
                                    </tr>
                                    <tr>
                                        <th>Bidang Keilmuan</th>
                                        <td>: <span class="badge bg-info">{{ $pengajaran->bidang_keilmuan }}</span></td>
                                    </tr>
                                    <tr>
                                        <th>Kelas</th>
                                        <td>: <span class="badge bg-secondary">{{ $pengajaran->kelas }}</span></td>
                                    </tr>
                                    <tr>
                                        <th>Jumlah SKS</th>
                                        <td>: <span class="badge bg-primary">{{ $pengajaran->sks }} SKS</span></td>
                                    </tr>
                                    <tr>
                                        <th>Jumlah Mahasiswa</th>
                                        <td>: <i class="bi bi-people"></i> {{ $pengajaran->jumlah_mahasiswa }} Mahasiswa
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="150">Semester</th>
                                        <td>:
                                            <span
                                                class="badge bg-{{ $pengajaran->semester == 'ganjil' ? 'primary' : 'warning' }}">
                                                {{ ucfirst($pengajaran->semester) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tahun Akademik</th>
                                        <td>: {{ $pengajaran->tahun_akademik }}</td>
                                    </tr>
                                    <tr>
                                        <th>Periode Akademik</th>
                                        <td>:
                                            <strong>{{ $pengajaran->academicPeriod->nama_periode ?? '-' }}</strong>
                                            @if ($pengajaran->academicPeriod && $pengajaran->academicPeriod->is_active)
                                                <span class="badge bg-success ms-2">Aktif</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Total Jam Mengajar</th>
                                        <td>: <i class="bi bi-clock"></i> {{ $pengajaran->sks * 16 }} Jam/Semester</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Input</th>
                                        <td>: {{ $pengajaran->created_at->format('d F Y H:i:s') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Terakhir Update</th>
                                        <td>: {{ $pengajaran->updated_at->format('d F Y H:i:s') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dosen Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-person-badge me-2 text-success"></i> Informasi Dosen Pengajar
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 text-center">
                                <img src="{{ $pengajaran->dosen->photo_url ?? 'https://ui-avatars.com/api/?background=4361ee&color=fff&name=' . urlencode($pengajaran->dosen->nama) }}"
                                    class="rounded-circle mb-2" width="100" height="100" style="object-fit: cover;">
                                <h6 class="mt-2">{{ $pengajaran->dosen->nama }}</h6>
                                <span class="badge bg-secondary">{{ $pengajaran->dosen->status ?? '-' }}</span>
                            </div>
                            <div class="col-md-9">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="150">NIDN</th>
                                        <td>: {{ $pengajaran->dosen->nidn ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>NIK</th>
                                        <td>: {{ $pengajaran->dosen->nik ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>: <a
                                                href="mailto:{{ $pengajaran->dosen->email }}">{{ $pengajaran->dosen->email }}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Jabatan Fungsional</th>
                                        <td>: {{ $pengajaran->dosen->jabatan_fungsional ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Pendidikan Terakhir</th>
                                        <td>: {{ $pengajaran->dosen->pendidikan_terakhir ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Kepangkatan</th>
                                        <td>: {{ $pengajaran->dosen->kepangkatan ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistics Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-graph-up me-2 text-warning"></i> Statistik
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-4 mb-3">
                                <div class="border rounded p-3">
                                    <i class="bi bi-people fs-2 text-primary"></i>
                                    <h4 class="mt-2 mb-0">{{ $pengajaran->jumlah_mahasiswa }}</h4>
                                    <small class="text-muted">Jumlah Mahasiswa</small>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="border rounded p-3">
                                    <i class="bi bi-clock fs-2 text-success"></i>
                                    <h4 class="mt-2 mb-0">{{ $pengajaran->sks * 16 }}</h4>
                                    <small class="text-muted">Total Jam (per Semester)</small>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="border rounded p-3">
                                    <i class="bi bi-calendar-week fs-2 text-info"></i>
                                    <h4 class="mt-2 mb-0">{{ $pengajaran->sks * 16 * 50 }} Menit</h4>
                                    <small class="text-muted">Total Menit Mengajar</small>
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
                        <a href="{{ route('dosen.pengajaran.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <a href="{{ route('dosen.pengajaran.edit', $pengajaran->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Edit Data
                        </a>
                        <button type="button" class="btn btn-success" onclick="window.print()">
                            <i class="bi bi-printer"></i> Print
                        </button>
                    </div>
                </div>

                <!-- Delete Form -->
                <form id="delete-form" action="{{ route('dosen.pengajaran.destroy', $pengajaran->id) }}" method="POST"
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
            padding: 8px 0;
        }

        .border {
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .border:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
    </style>

    <script>
        function confirmDelete() {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                html: `Data pengajaran <strong>{{ $pengajaran->kode_mk }} - {{ $pengajaran->nama_mk }}</strong> akan dihapus!`,
                text: "Data yang dihapus tidak dapat dikembalikan!",
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
