@extends('components.layouts.app')

@section('title', 'Laporan Kinerja Dosen')

@section('content')
    <div class="container-fluid px-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="bi bi-file-text"></i> Laporan Kinerja Dosen
                </h1>
                <p class="text-muted">Laporan kinerja dosen per periode akademik</p>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-funnel"></i> Filter Laporan
                </h6>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.laporan.index') }}" id="reportForm">
                    <div class="row g-3">
                        <div class="col-md-5">
                            <label class="form-label fw-bold">
                                Periode Akademik <span class="text-danger">*</span>
                            </label>
                            <select name="period_id" id="period_id" class="form-select" required>
                                <option value="">Pilih Periode</option>
                                @foreach ($periods as $period)
                                    <option value="{{ $period->id }}"
                                        {{ request('period_id') == $period->id ? 'selected' : '' }}>
                                        {{ $period->nama_periode }} ({{ $period->semester }}
                                        {{ $period->tahun_awal }}/{{ $period->tahun_akhir }})
                                        @if ($period->is_active)
                                            - Aktif
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-bold">Dosen (Opsional)</label>
                            <select name="dosen_id" id="dosen_id" class="form-select">
                                <option value="">Semua Dosen</option>
                                @foreach ($dosens as $dosen)
                                    <option value="{{ $dosen->id }}"
                                        {{ request('dosen_id') == $dosen->id ? 'selected' : '' }}>
                                        {{ $dosen->nama }} ({{ $dosen->nidn }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-search"></i> Tampilkan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if ($reportData)
            <!-- Report Result -->
            <div class="mb-4">
                <!-- Export Buttons -->
                <div class="d-flex justify-content-end gap-2 mb-3">
                    <button type="button" class="btn btn-success" onclick="exportReport('excel')">
                        <i class="bi bi-file-excel"></i> Export Excel
                    </button>
                    <button type="button" class="btn btn-danger" onclick="exportReport('pdf')">
                        <i class="bi bi-file-pdf"></i> Export PDF
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="window.print()">
                        <i class="bi bi-printer"></i> Print
                    </button>
                </div>

                <!-- Report Header -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body text-center">
                        <h4 class="mb-2">LAPORAN KINERJA DOSEN</h4>
                        <h6 class="text-muted">
                            Periode: {{ $selectedPeriod->nama_periode }}
                            @if ($selectedDosen)
                                <br>Dosen: {{ $selectedDosen->nama }} ({{ $selectedDosen->nidn }})
                            @else
                                <br>Semua Dosen
                            @endif
                        </h6>
                        <p class="text-muted small mb-0">
                            Dicetak: {{ date('d F Y H:i:s') }}
                        </p>
                    </div>
                </div>

                <!-- Summary Cards -->
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">Total Pengajaran</h6>
                                        <h3 class="mb-0 mt-2">
                                            {{ number_format($reportData['summary']['total_pengajaran']) }}</h3>
                                        <small>{{ $reportData['summary']['total_sks'] }} SKS</small>
                                    </div>
                                    <i class="bi bi-book fs-1 opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">Total Mahasiswa</h6>
                                        <h3 class="mb-0 mt-2">
                                            {{ number_format($reportData['summary']['total_mahasiswa']) }}</h3>
                                        <small>Diajar</small>
                                    </div>
                                    <i class="bi bi-people fs-1 opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-info text-white shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">Total Penelitian</h6>
                                        <h3 class="mb-0 mt-2">{{ number_format($reportData['summary']['total_riset']) }}
                                        </h3>
                                        <small>Rp
                                            {{ number_format($reportData['summary']['total_dana_riset'], 0, ',', '.') }}</small>
                                    </div>
                                    <i class="bi bi-mortarboard fs-1 opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-white shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">Total PKM</h6>
                                        <h3 class="mb-0 mt-2">{{ number_format($reportData['summary']['total_pkm']) }}</h3>
                                        <small>Rp
                                            {{ number_format($reportData['summary']['total_dana_pkm'], 0, ',', '.') }}</small>
                                    </div>
                                    <i class="bi bi-people-fill fs-1 opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Row -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white">
                                <h6 class="mb-0 fw-bold">
                                    <i class="bi bi-bar-chart me-2 text-primary"></i>
                                    Distribusi Pengajaran per Bidang Keilmuan
                                </h6>
                            </div>
                            <div class="card-body">
                                <canvas id="teachingChart" height="250"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white">
                                <h6 class="mb-0 fw-bold">
                                    <i class="bi bi-pie-chart me-2 text-info"></i>
                                    Status Penelitian
                                </h6>
                            </div>
                            <div class="card-body">
                                <canvas id="researchChart" height="250"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bimbingan by Type -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h6 class="mb-0 fw-bold">
                            <i class="bi bi-chat-dots me-2 text-success"></i>
                            Bimbingan Mahasiswa
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Jenis Bimbingan</th>
                                        <th>Jumlah</th>
                                        <th>Total Mahasiswa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reportData['bimbingan_by_type'] as $item)
                                        <tr>
                                            <td>
                                                @if ($item->jenis_bimbingan == 'skripsi')
                                                    <span class="badge bg-primary">Skripsi</span>
                                                @elseif($item->jenis_bimbingan == 'tesis')
                                                    <span class="badge bg-success">Tesis</span>
                                                @else
                                                    <span class="badge bg-info">Disertasi</span>
                                                @endif
                                            </td>
                                            <td>{{ $item->total }} Bimbingan</td>
                                            <td>{{ $item->total_mahasiswa }} Mahasiswa</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Top Performers -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white">
                                <h6 class="mb-0 fw-bold">
                                    <i class="bi bi-trophy me-2 text-warning"></i>
                                    Top 5 Dosen dengan Beban Mengajar Tertinggi
                                </h6>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Dosen</th>
                                                <th>Jumlah MK</th>
                                                <th>Total SKS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($reportData['top_pengajaran'] as $index => $item)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $item->dosen->nama ?? '-' }}</td>
                                                    <td>{{ $item->total }} MK</td>
                                                    <td>{{ $item->dosen->pengajarans->where('academic_period_id', $selectedPeriod->id)->sum('sks') }}
                                                        SKS</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white">
                                <h6 class="mb-0 fw-bold">
                                    <i class="bi bi-award me-2 text-warning"></i>
                                    Top 5 Dosen dengan Penelitian Terbanyak
                                </h6>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Dosen</th>
                                                <th>Jumlah Penelitian</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($reportData['top_riset'] as $index => $item)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $item->dosen->nama ?? '-' }}</td>
                                                    <td>{{ $item->total }} Penelitian</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail Tables -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h6 class="mb-0 fw-bold">
                            <i class="bi bi-table me-2 text-primary"></i>
                            Detail Pengajaran per Dosen
                        </h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Dosen</th>
                                        <th>Jumlah MK</th>
                                        <th>Total SKS</th>
                                        <th>Jumlah Mahasiswa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reportData['teaching_by_lecturer'] as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->dosen->nama ?? '-' }}</td>
                                            <td>{{ $item->total_mk }} MK</td>
                                            <td>{{ $item->total_sks }} SKS</td>
                                            <td>{{ $item->dosen->pengajarans->where('academic_period_id', $selectedPeriod->id)->sum('jumlah_mahasiswa') }}
                                                Mhs</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @elseif(request()->has('period_id'))
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle"></i> Tidak ada data untuk periode yang dipilih.
                </div>
            @else
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> Silakan pilih periode akademik untuk melihat laporan.
                </div>
        @endif
    </div>

    <style>
        .table-bordered td,
        .table-bordered th {
            padding: 10px;
            vertical-align: middle;
        }

        @media print {

            .navbar-top,
            .btn,
            .card-header .btn,
            .d-flex.justify-content-end,
            #sidebar,
            .sidebar-toggle {
                display: none !important;
            }

            #content {
                margin-left: 0 !important;
            }

            .card {
                break-inside: avoid;
            }
        }
    </style>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Export function
        function exportReport(type) {
            const form = document.getElementById('reportForm');
            const periodId = document.getElementById('period_id').value;
            const dosenId = document.getElementById('dosen_id').value;

            if (!periodId) {
                Swal.fire('Error', 'Silakan pilih periode akademik terlebih dahulu!', 'error');
                return;
            }

            let url = type === 'excel' ?
                '{{ route('admin.laporan.export.excel') }}' :
                '{{ route('admin.laporan.export.pdf') }}';

            window.location.href = url + '?period_id=' + periodId + '&dosen_id=' + (dosenId || '');
        }

        @if ($reportData && $reportData['teaching_by_field']->count() > 0)
            // Teaching Chart
            const teachingCtx = document.getElementById('teachingChart').getContext('2d');
            new Chart(teachingCtx, {
                type: 'bar',
                data: {
                    labels: @json($reportData['teaching_by_field']->pluck('bidang_keilmuan')->toArray()),
                    datasets: [{
                        label: 'Jumlah Mata Kuliah',
                        data: @json($reportData['teaching_by_field']->pluck('total')->toArray()),
                        backgroundColor: 'rgba(67, 97, 238, 0.6)',
                        borderColor: '#4361ee',
                        borderWidth: 1,
                        borderRadius: 8
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
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                font: {
                                    size: 10
                                }
                            }
                        },
                        x: {
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
        @endif

        @if ($reportData && $reportData['research_by_status']->count() > 0)
            // Research Chart
            const researchCtx = document.getElementById('researchChart').getContext('2d');
            new Chart(researchCtx, {
                type: 'doughnut',
                data: {
                    labels: @json(
                        $reportData['research_by_status']->pluck('status')->map(function ($status) {
                                return $status == 'aktif' ? 'Aktif' : 'Selesai';
                            })->toArray()),
                    datasets: [{
                        data: @json($reportData['research_by_status']->pluck('total')->toArray()),
                        backgroundColor: ['#28a745', '#dc3545'],
                        borderWidth: 0,
                        hoverOffset: 10
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
                        }
                    },
                    cutout: '65%'
                }
            });
        @endif
    </script>
@endpush
