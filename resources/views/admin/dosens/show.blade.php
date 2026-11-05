@extends('components.layouts.app')

@section('title', 'Detail Dosen - ' . $dosen->nama)

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('admin.dosens.index') }}" class="btn btn-outline-secondary me-3">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h2 class="page-title mb-0">
                <i class="bi bi-person-badge me-2"></i> Detail Dosen
            </h2>
        </div>

        <div class="row">
            <!-- Profile Card -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0 text-center">
                    <div class="card-body">
                        <img src="{{ $dosen->photo_url }}" alt="{{ $dosen->nama }}" class="rounded-circle mb-3"
                            width="150" height="150" style="object-fit: cover;">
                        <h4>{{ $dosen->nama }}</h4>
                        <p class="text-muted">{{ $dosen->nidn }}</p>
                        {!! $dosen->status_badge !!}
                        <hr>
                        <div class="text-start">
                            <p><i class="bi bi-envelope me-2"></i> {{ $dosen->email }}</p>
                            <p><i class="bi bi-credit-card me-2"></i> NIK: {{ $dosen->nik }}</p>
                            <p><i class="bi bi-mortarboard me-2"></i> {{ $dosen->pendidikan_terakhir }}</p>
                            <p><i class="bi bi-briefcase me-2"></i> {{ $dosen->jabatan_fungsional }}</p>

                            {{-- TAMBAHAN: Tampilkan Bidang Keahlian --}}
                            <p>
                                <i class="bi bi-award me-2"></i> Bidang:
                                @if ($dosen->bidang_keahlian)
                                    @php
                                        $bidangs = array_filter(
                                            array_map('trim', explode(',', $dosen->bidang_keahlian)),
                                        );
                                    @endphp
                                    @foreach ($bidangs as $bidang)
                                        <span class="badge bg-primary mb-1">{{ $bidang }}</span>
                                    @endforeach
                                @else
                                    -
                                @endif
                            </p>

                            <p><i class="bi bi-trophy me-2"></i> {{ $dosen->inpassing }}</p>
                            <p><i class="bi bi-star me-2"></i> {{ $dosen->kepangkatan }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="col-md-8 mb-4">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">Total Pengajaran</h6>
                                        <h3>{{ $stats['total_pengajaran'] ?? 0 }}</h3>
                                        <small>{{ $stats['total_sks'] ?? 0 }} SKS</small>
                                    </div>
                                    <i class="bi bi-book fs-1 opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">Total Penelitian</h6>
                                        <h3>{{ $stats['total_riset'] ?? 0 }}</h3>
                                        <small>Proyek penelitian</small>
                                    </div>
                                    <i class="bi bi-mortarboard fs-1 opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">Total PKM</h6>
                                        <h3>{{ $stats['total_pkm'] ?? 0 }}</h3>
                                        <small>Pengabdian masyarakat</small>
                                    </div>
                                    <i class="bi bi-people-fill fs-1 opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">Bimbingan & Pelatihan</h6>
                                        <h3>{{ ($stats['total_bimbingan'] ?? 0) + ($stats['total_pelatihan'] ?? 0) }}</h3>
                                        <small>{{ $stats['total_bimbingan'] ?? 0 }} Bimbingan,
                                            {{ $stats['total_pelatihan'] ?? 0 }} Pelatihan</small>
                                    </div>
                                    <i class="bi bi-chat-dots fs-1 opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Teaching History -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-book me-2"></i> Riwayat Pengajaran
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Kode MK</th>
                                <th>Nama Mata Kuliah</th>
                                <th>Kelas</th>
                                <th>SKS</th>
                                <th>Semester</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dosen->pengajarans as $pengajaran)
                                <tr>
                                    <td>{{ $pengajaran->kode_mk }}</td>
                                    <td>{{ $pengajaran->nama_mk }}</td>
                                    <td>{{ $pengajaran->kelas }}</td>
                                    <td>{{ $pengajaran->sks }}</td>
                                    <td>{{ $pengajaran->semester }} {{ $pengajaran->tahun_akademik }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-3 text-muted">Belum ada data pengajaran</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Research History (Opsional ditambahkan agar lengkap) -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-mortarboard me-2"></i> Riwayat Penelitian
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Judul Penelitian</th>
                                <th>Bidang</th>
                                <th>Tahun</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dosen->risets as $riset)
                                <tr>
                                    <td>{{ $riset->judul_riset }}</td>
                                    <td>{{ $riset->bidang_riset }}</td>
                                    <td>{{ $riset->tahun }}</td>
                                    <td>
                                        @if ($riset->status == 'aktif')
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-3 text-muted">Belum ada data penelitian</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
