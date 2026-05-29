{{-- resources/views/admin/dosens/show.blade.php --}}
<x-layouts.app title="Detail Dosen - {{ $dosen->nama }}">
    <div class="container-fluid">
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
                                        <h3>{{ $stats['total_pengajaran'] }}</h3>
                                        <small>{{ $stats['total_sks'] }} SKS</small>
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
                                        <h3>{{ $stats['total_riset'] }}</h3>
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
                                        <h3>{{ $stats['total_pkm'] }}</h3>
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
                                        <h3>{{ $stats['total_bimbingan'] + $stats['total_pelatihan'] }}</h3>
                                        <small>{{ $stats['total_bimbingan'] }} bimbingan</small>
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
                    <table class="table table-sm">
                        <thead>
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
                                    <td colspan="5" class="text-center">Belum ada data pengajaran</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
