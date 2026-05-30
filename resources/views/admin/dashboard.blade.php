@extends('components.layouts.app')

@section('title', 'Dashboard Admin')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Welcome Banner -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-gradient-primary text-white border-0">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="card-title mb-1 fw-bold">
                                    <i class="bi bi-emoji-smile"></i> Selamat Datang, {{ Auth::user()->name }}!
                                </h4>
                                <p class="card-text opacity-75 mb-0 small">
                                    <i class="bi bi-calendar-week"></i> Sistem Monitoring Kinerja Dosen -
                                    Periode Aktif:
                                    <strong>{{ $currentPeriod->display_name ?? 'Belum ada periode aktif' }}</strong>
                                </p>
                            </div>
                            <div class="text-center d-none d-md-block">
                                <i class="bi bi-calendar-check fs-2 opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted text-uppercase small fw-bold mb-1">Total Dosen</h6>
                                <h3 class="fw-bold mb-0">{{ number_format($stats['total_dosen']) }}</h3>
                                <small class="text-success mt-1 d-block small">
                                    <i class="bi bi-arrow-up-short"></i> +12%
                                </small>
                            </div>
                            <div class="stats-icon bg-primary bg-opacity-10 text-primary rounded-3 p-2">
                                <i class="bi bi-people fs-3"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted text-uppercase small fw-bold mb-1">Total Mata Kuliah</h6>
                                <h3 class="fw-bold mb-0">{{ number_format($stats['total_pengajaran']) }}</h3>
                                <small class="text-success mt-1 d-block small">
                                    <i class="bi bi-arrow-up-short"></i> +8%
                                </small>
                            </div>
                            <div class="stats-icon bg-success bg-opacity-10 text-success rounded-3 p-2">
                                <i class="bi bi-book fs-3"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted text-uppercase small fw-bold mb-1">Total Penelitian</h6>
                                <h3 class="fw-bold mb-0">{{ number_format($stats['total_riset']) }}</h3>
                                <small class="text-success mt-1 d-block small">
                                    <i class="bi bi-arrow-up-short"></i> +15%
                                </small>
                            </div>
                            <div class="stats-icon bg-info bg-opacity-10 text-info rounded-3 p-2">
                                <i class="bi bi-mortarboard fs-3"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted text-uppercase small fw-bold mb-1">Total PKM</h6>
                                <h3 class="fw-bold mb-0">{{ number_format($stats['total_pkm']) }}</h3>
                                <small class="text-danger mt-1 d-block small">
                                    <i class="bi bi-arrow-down-short"></i> -3%
                                </small>
                            </div>
                            <div class="stats-icon bg-warning bg-opacity-10 text-warning rounded-3 p-2">
                                <i class="bi bi-people-fill fs-3"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row - DIPERKECIL UKURANNYA -->
        <div class="row g-3 mb-4">
            <div class="col-xl-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 pt-3 pb-0">
                        <h6 class="card-title mb-0 fw-bold">
                            <i class="bi bi-bar-chart me-2 text-primary"></i>
                            Distribusi Pengajaran per Bidang Keilmuan
                        </h6>
                    </div>
                    <div class="card-body pt-2">
                        <canvas id="teachingChart" height="250" style="max-height: 250px;"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 pt-3 pb-0">
                        <h6 class="card-title mb-0 fw-bold">
                            <i class="bi bi-pie-chart me-2 text-info"></i>
                            Status Penelitian
                        </h6>
                    </div>
                    <div class="card-body pt-2">
                        <canvas id="researchChart" height="250" style="max-height: 250px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top 5 Dosen -->
        <div class="row g-3 mb-4">
            <div class="col-xl-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 pt-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="card-title mb-0 fw-bold">
                                <i class="bi bi-trophy me-2 text-warning"></i>
                                Top 5 Dosen Beban Mengajar Tertinggi
                            </h6>
                            <a href="{{ route('admin.dosens.index') }}"
                                class="btn btn-sm btn-link text-decoration-none small">
                                Lihat Semua <i class="bi bi-arrow-right small"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body pt-2">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th width="40">#</th>
                                        <th>Dosen</th>
                                        <th width="80">Jumlah MK</th>
                                        <th width="80">Total SKS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($topLecturers as $index => $dosen)
                                        <tr>
                                            <td>
                                                <span class="badge bg-primary rounded-circle px-2 py-1">
                                                    {{ $index + 1 }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <img src="{{ $dosen->photo_url }}" class="rounded-circle" width="30"
                                                        height="30" style="object-fit: cover;">
                                                    <div>
                                                        <strong class="small">{{ $dosen->nama }}</strong>
                                                        <br>
                                                        <small class="text-muted">{{ $dosen->jabatan_fungsional }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $dosen->pengajarans_count }}</span>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-success">{{ $dosen->pengajarans->sum('sks') }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-3 small">Belum ada data pengajaran
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Penelitian Terbaru -->
            <div class="col-xl-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 pt-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="card-title mb-0 fw-bold">
                                <i class="bi bi-newspaper me-2 text-info"></i>
                                Penelitian Terbaru
                            </h6>
                            <a href="{{ route('admin.riset.index') }}"
                                class="btn btn-sm btn-link text-decoration-none small">
                                Lihat Semua <i class="bi bi-arrow-right small"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body pt-2">
                        <div class="list-group list-group-flush">
                            @forelse($recentRisets as $riset)
                                <div class="list-group-item px-0 py-2 border-0">
                                    <div class="d-flex w-100 justify-content-between">
                                        <div>
                                            <p class="mb-0 fw-bold small">{{ Str::limit($riset->judul_riset, 50) }}</p>
                                            <small class="text-muted">
                                                <i class="bi bi-person"></i>
                                                {{ $riset->dosen->nama ?? 'Tidak diketahui' }}
                                            </small>
                                        </div>
                                        <small class="text-muted">{{ $riset->tahun }}</small>
                                    </div>
                                    <div class="mt-1">
                                        <span class="badge bg-light text-dark small">
                                            <i class="bi bi-cash"></i> {{ $riset->formatted_dana_attribute }}
                                        </span>
                                        @if ($riset->status == 'aktif')
                                            <span class="badge bg-success small ms-1">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary small ms-1">Selesai</span>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-3">
                                    <i class="bi bi-inbox fs-4 text-muted"></i>
                                    <p class="text-muted small mt-1">Belum ada data penelitian</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- PKM Terbaru -->
        <div class="row g-3">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 pt-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="card-title mb-0 fw-bold">
                                <i class="bi bi-people-fill me-2 text-success"></i>
                                Pengabdian Masyarakat Terbaru
                            </h6>
                            <a href="{{ route('admin.pkm.index') }}"
                                class="btn btn-sm btn-link text-decoration-none small">
                                Lihat Semua <i class="bi bi-arrow-right small"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body pt-2">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Judul PKM</th>
                                        <th>Dosen</th>
                                        <th>Lokasi</th>
                                        <th width="80">Status</th>
                                        <th width="60">Tahun</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentPkms ?? [] as $pkm)
                                        <tr>
                                            <td><span class="small">{{ Str::limit($pkm->judul_pkm, 40) }}</span></td>
                                            <td><span class="small">{{ $pkm->dosen->nama ?? 'Tidak diketahui' }}</span>
                                            </td>
                                            <td><span class="small">{{ $pkm->lokasi_kegiatan }}</span></td>
                                            <td>
                                                @if ($pkm->status == 'aktif')
                                                    <span class="badge bg-success small">Aktif</span>
                                                @else
                                                    <span class="badge bg-secondary small">Selesai</span>
                                                @endif
                                            </td>
                                            <td><span class="small">{{ $pkm->tahun }}</span></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-3 small">Belum ada data PKM</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .stats-icon {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .card {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1) !important;
        }

        /* Ukuran chart lebih kecil */
        canvas {
            max-height: 250px;
            width: 100%;
        }
    </style>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Teaching Chart - Ukuran lebih kecil
        const teachingCtx = document.getElementById('teachingChart').getContext('2d');
        new Chart(teachingCtx, {
            type: 'bar',
            data: {
                labels: @json($teachingByField->pluck('bidang_keilmuan')->toArray()),
                datasets: [{
                    label: 'Jumlah Mata Kuliah',
                    data: @json($teachingByField->pluck('total')->toArray()),
                    backgroundColor: 'rgba(67, 97, 238, 0.6)',
                    borderColor: '#4361ee',
                    borderWidth: 1,
                    borderRadius: 6,
                    barPercentage: 0.7,
                    categoryPercentage: 0.8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                size: 11
                            }
                        }
                    },
                    tooltip: {
                        bodyFont: {
                            size: 11
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                size: 10
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 10
                            },
                            rotation: 0
                        }
                    }
                }
            }
        });

        // Research Chart - Ukuran lebih kecil
        const researchCtx = document.getElementById('researchChart').getContext('2d');
        new Chart(researchCtx, {
            type: 'doughnut',
            data: {
                labels: @json(
                    $researchByStatus->pluck('status')->map(function ($status) {
                            return $status == 'aktif' ? 'Aktif' : 'Selesai';
                        })->toArray()),
                datasets: [{
                    data: @json($researchByStatus->pluck('total')->toArray()),
                    backgroundColor: ['#4caf50', '#f44336'],
                    borderWidth: 0,
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: {
                                size: 11
                            }
                        }
                    },
                    tooltip: {
                        bodyFont: {
                            size: 11
                        }
                    }
                },
                cutout: '65%'
            }
        });
    </script>
@endpush
