@extends('components.layouts.app')

@section('title', 'Evaluasi Kinerja Dosen')

@section('content')
    <div class="container-fluid px-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="bi bi-clipboard-check"></i> Evaluasi Kinerja Dosen
                </h1>
                <p class="text-muted">Evaluasi dan rekapitulasi kinerja dosen per semester</p>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-funnel"></i> Filter Data
                </h6>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.evaluasi-kinerja.index') }}" class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label fw-bold">Dosen <span class="text-danger">*</span></label>
                        <select name="dosen_id" class="form-select" required>
                            <option value="">Pilih Dosen</option>
                            @foreach ($dosens as $dosen)
                                <option value="{{ $dosen->id }}"
                                    {{ request('dosen_id') == $dosen->id ? 'selected' : '' }}>
                                    {{ $dosen->nama }} ({{ $dosen->nidn }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label fw-bold">Periode Akademik <span class="text-danger">*</span></label>
                        <select name="period_id" class="form-select" required>
                            <option value="">Pilih Periode</option>
                            @foreach ($periods as $period)
                                <option value="{{ $period->id }}"
                                    {{ request('period_id') == $period->id ? 'selected' : '' }}>
                                    {{ $period->nama_periode }} ({{ $period->semester }}
                                    {{ $period->tahun_awal }}/{{ $period->tahun_akhir }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search"></i> Tampilkan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if ($evaluasiData)
            <!-- Evaluasi Result -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0 fw-bold">
                                <i class="bi bi-file-text me-2 text-primary"></i>
                                Laporan Kinerja - {{ $selectedPeriod->nama_periode }}
                            </h5>
                        </div>
                        <div>
                            <a href="{{ route('admin.evaluasi-kinerja.print', ['dosen_id' => $selectedDosen->id, 'period_id' => $selectedPeriod->id]) }}"
                                class="btn btn-sm btn-secondary" target="_blank">
                                <i class="bi bi-printer"></i> Print
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Info Panel -->
                    <div class="alert alert-info mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <small class="text-muted">Penarikan Kinerja</small>
                                <div class="fw-bold">
                                    {{ $selectedPeriod->tanggal_mulai ? date('d F Y', strtotime($selectedPeriod->tanggal_mulai)) : '-' }}
                                    sampai
                                    {{ $selectedPeriod->tanggal_selesai ? date('d F Y', strtotime($selectedPeriod->tanggal_selesai)) : '-' }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted">Periode Pengisian</small>
                                <div class="fw-bold">12 Januari 2026 sampai 31 Mei 2026</div>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted">Periode Penilaian</small>
                                <div class="fw-bold">12 Januari 2026 sampai 31 Mei 2026</div>
                            </div>
                        </div>
                    </div>

                    <!-- Summary Cards -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-2">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <i class="bi bi-book fs-2 text-primary"></i>
                                    <h6 class="mt-2 mb-0">Pendidikan</h6>
                                    <h4 class="mb-0">{{ number_format($evaluasiData['pendidikan']['sks'], 2) }}
                                        <small>sks</small>
                                    </h4>
                                    <span
                                        class="badge bg-{{ $evaluasiData['pendidikan']['status'] == 'M' ? 'success' : 'danger' }}">
                                        {{ $evaluasiData['pendidikan']['status'] == 'M' ? 'M' : 'TM' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <i class="bi bi-mortarboard fs-2 text-success"></i>
                                    <h6 class="mt-2 mb-0">Penelitian</h6>
                                    <h4 class="mb-0">{{ number_format($evaluasiData['penelitian']['sks'], 2) }}
                                        <small>sks</small>
                                    </h4>
                                    <span
                                        class="badge bg-{{ $evaluasiData['penelitian']['status'] == 'M' ? 'success' : 'danger' }}">
                                        {{ $evaluasiData['penelitian']['status'] == 'M' ? 'M' : 'TM' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <i class="bi bi-people-fill fs-2 text-info"></i>
                                    <h6 class="mt-2 mb-0">Pengabdian</h6>
                                    <h4 class="mb-0">{{ number_format($evaluasiData['pengabdian']['sks'], 2) }}
                                        <small>sks</small>
                                    </h4>
                                    <span
                                        class="badge bg-{{ $evaluasiData['pengabdian']['status'] == 'M' ? 'success' : 'danger' }}">
                                        {{ $evaluasiData['pengabdian']['status'] == 'M' ? 'M' : 'TM' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <i class="bi bi-star fs-2 text-warning"></i>
                                    <h6 class="mt-2 mb-0">Penunjang</h6>
                                    <h4 class="mb-0">{{ number_format($evaluasiData['penunjang']['sks'], 2) }}
                                        <small>sks</small>
                                    </h4>
                                    <span
                                        class="badge bg-{{ $evaluasiData['penunjang']['status'] == 'M' ? 'success' : 'danger' }}">
                                        {{ $evaluasiData['penunjang']['status'] == 'M' ? 'M' : 'TM' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-3">
                        <div class="d-flex gap-3">
                            <div><span class="badge bg-success">M</span> = Memenuhi</div>
                            <div><span class="badge bg-danger">TM</span> = Tidak Memenuhi</div>
                        </div>
                    </div>

                    <!-- Main Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th width="50">No</th>
                                    <th>Jenis Kinerja</th>
                                    <th>Syarat</th>
                                    <th width="120">sks BKD</th>
                                    <th width="120">sks Lebih</th>
                                    <th width="100">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($evaluasiData['kinerja_table'] as $item)
                                    <tr>
                                        <td>{{ $item['no'] }}</td>
                                        <td><strong>{{ $item['jenis_kinerja'] }}</strong></td>
                                        <td>{{ $item['syarat'] }}</td>
                                        <td>{{ $item['sks_bkd'] }}</td>
                                        <td>{{ $item['sks_lebih'] }}</td>
                                        <td class="text-center">
                                            <span
                                                class="badge bg-{{ $item['status'] == 'M' ? 'success' : 'danger' }} fs-6 px-3 py-2">
                                                {{ $item['status'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach

                                <!-- Criteria Rows -->
                                @foreach ($evaluasiData['criteria_rows'] as $item)
                                    <tr>
                                        <td>—</span></td>
                                        <td><strong>{{ $item['jenis_kinerja'] }}</strong></td>
                                        <td>{{ $item['syarat'] }}</td>
                                        <td>{{ $item['sks_bkd'] }}</td>
                                        <td>{{ $item['sks_lebih'] }}</td>
                                        <td class="text-center">
                                            <span
                                                class="badge bg-{{ $item['status'] == 'M' ? 'success' : 'danger' }} fs-6 px-3 py-2">
                                                {{ $item['status'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach

                                <!-- Summary Row -->
                                <tr>
                                    <td colspan="2">
                                        <strong>{{ $evaluasiData['summary_row']['jenis_kinerja'] }}</strong>
                                        </span>
                                    </td>
                                    <td>{{ $evaluasiData['summary_row']['syarat'] }}</span></td>
                                    <td><strong>{{ $evaluasiData['summary_row']['sks_bkd'] }}</strong></span></td>
                                    <td><strong>{{ $evaluasiData['summary_row']['sks_lebih'] }}</strong></span></td>
                                    <td class="text-center">
                                        <span
                                            class="badge bg-{{ $evaluasiData['summary_row']['status'] == 'M' ? 'success' : 'danger' }} fs-6 px-3 py-2">
                                            {{ $evaluasiData['summary_row']['status'] }}
                                        </span>
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Detail Sections -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card border-primary mb-3">
                                <div class="card-header bg-primary text-white">
                                    <i class="bi bi-book"></i> Detail Pelaksanaan Pendidikan
                                </div>
                                <div class="card-body">
                                    @if (count($evaluasiData['pendidikan']['detail']) > 0)
                                        <ul class="list-group list-group-flush">
                                            @foreach ($evaluasiData['pendidikan']['detail'] as $detail)
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    {{ $detail['kegiatan'] }}
                                                    <span class="badge bg-primary rounded-pill">{{ $detail['sks'] }}
                                                        sks</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="text-muted">Tidak ada data pendidikan</p>
                                    @endif
                                    <div class="mt-3 text-end">
                                        <strong>Total: {{ number_format($evaluasiData['pendidikan']['sks'], 2) }}
                                            sks</strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card border-success mb-3">
                                <div class="card-header bg-success text-white">
                                    <i class="bi bi-mortarboard"></i> Detail Pelaksanaan Penelitian
                                </div>
                                <div class="card-body">
                                    @if (count($evaluasiData['penelitian']['detail']) > 0)
                                        <ul class="list-group list-group-flush">
                                            @foreach ($evaluasiData['penelitian']['detail'] as $detail)
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    {{ Str::limit($detail['kegiatan'], 50) }}
                                                    <span class="badge bg-success rounded-pill">{{ $detail['sks'] }}
                                                        sks</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="text-muted">Tidak ada data penelitian</p>
                                    @endif
                                    <div class="mt-3 text-end">
                                        <strong>Total: {{ number_format($evaluasiData['penelitian']['sks'], 2) }}
                                            sks</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card border-info mb-3">
                                <div class="card-header bg-info text-white">
                                    <i class="bi bi-people-fill"></i> Detail Pelaksanaan Pengabdian
                                </div>
                                <div class="card-body">
                                    @if (count($evaluasiData['pengabdian']['detail']) > 0)
                                        <ul class="list-group list-group-flush">
                                            @foreach ($evaluasiData['pengabdian']['detail'] as $detail)
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    {{ Str::limit($detail['kegiatan'], 50) }}
                                                    <span class="badge bg-info rounded-pill">{{ $detail['sks'] }}
                                                        sks</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="text-muted">Tidak ada data pengabdian</p>
                                    @endif
                                    <div class="mt-3 text-end">
                                        <strong>Total: {{ number_format($evaluasiData['pengabdian']['sks'], 2) }}
                                            sks</strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card border-warning mb-3">
                                <div class="card-header bg-warning text-white">
                                    <i class="bi bi-star"></i> Detail Pelaksanaan Penunjang
                                </div>
                                <div class="card-body">
                                    @if (count($evaluasiData['penunjang']['detail']) > 0)
                                        <ul class="list-group list-group-flush">
                                            @foreach ($evaluasiData['penunjang']['detail'] as $detail)
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    {{ $detail['kegiatan'] }}
                                                    <span class="badge bg-warning rounded-pill">{{ $detail['sks'] }}
                                                        sks</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="text-muted">Tidak ada data penunjang</p>
                                    @endif
                                    <div class="mt-3 text-end">
                                        <strong>Total: {{ number_format($evaluasiData['penunjang']['sks'], 2) }}
                                            sks</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ========== DETAIL PENGEMBANGAN PROFESI ========== -->
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <div class="card border-secondary mb-3">
                                <div class="card-header bg-secondary text-white">
                                    <i class="bi bi-award"></i> Detail Pengembangan Profesi
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Pelatihan -->
                                        <div class="col-md-3 mb-3">
                                            <div class="card h-100">
                                                <div class="card-header bg-primary text-white text-center py-2">
                                                    <i class="bi bi-mortarboard"></i> Pelatihan
                                                </div>
                                                <div class="card-body p-2">
                                                    @if (isset($evaluasiData['pengembangan']['detail']['pelatihan']) &&
                                                            $evaluasiData['pengembangan']['detail']['pelatihan']['jumlah'] > 0)
                                                        <div class="text-center mb-2">
                                                            <h5 class="mb-0">
                                                                {{ $evaluasiData['pengembangan']['detail']['pelatihan']['jumlah'] }}
                                                            </h5>
                                                            <small class="text-muted">Kegiatan</small>
                                                            <h6>{{ $evaluasiData['pengembangan']['detail']['pelatihan']['sks'] }}
                                                                sks</h6>
                                                        </div>
                                                        <ul class="list-group list-group-flush small">
                                                            @foreach ($evaluasiData['pengembangan']['detail']['pelatihan']['items']->take(3) as $item)
                                                                <li class="list-group-item p-1">
                                                                    <small>{{ Str::limit($item->nama_pelatihan, 30) }}</small>
                                                                    <span
                                                                        class="badge bg-primary float-end">{{ $item->durasi ? $item->durasi / 8 : 1 }}
                                                                        sks</span>
                                                                </li>
                                                            @endforeach
                                                            @if ($evaluasiData['pengembangan']['detail']['pelatihan']['jumlah'] > 3)
                                                                <li class="list-group-item text-center">
                                                                    <small>+{{ $evaluasiData['pengembangan']['detail']['pelatihan']['jumlah'] - 3 }}
                                                                        lainnya</small>
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    @else
                                                        <p class="text-muted text-center mb-0">Tidak ada data</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Sertifikasi -->
                                        <div class="col-md-3 mb-3">
                                            <div class="card h-100">
                                                <div class="card-header bg-success text-white text-center py-2">
                                                    <i class="bi bi-patch-check"></i> Sertifikasi
                                                </div>
                                                <div class="card-body p-2">
                                                    @if (isset($evaluasiData['pengembangan']['detail']['sertifikasi']) &&
                                                            $evaluasiData['pengembangan']['detail']['sertifikasi']['jumlah'] > 0)
                                                        <div class="text-center mb-2">
                                                            <h5 class="mb-0">
                                                                {{ $evaluasiData['pengembangan']['detail']['sertifikasi']['jumlah'] }}
                                                            </h5>
                                                            <small class="text-muted">Sertifikat</small>
                                                            <h6>{{ $evaluasiData['pengembangan']['detail']['sertifikasi']['sks'] }}
                                                                sks</h6>
                                                        </div>
                                                        <ul class="list-group list-group-flush small">
                                                            @foreach ($evaluasiData['pengembangan']['detail']['sertifikasi']['items']->take(3) as $item)
                                                                <li class="list-group-item p-1">
                                                                    <small>{{ Str::limit($item->jenis_sertifikasi, 30) }}</small>
                                                                    <span class="badge bg-success float-end">1</span>
                                                                </li>
                                                            @endforeach
                                                            @if ($evaluasiData['pengembangan']['detail']['sertifikasi']['jumlah'] > 3)
                                                                <li class="list-group-item text-center">
                                                                    <small>+{{ $evaluasiData['pengembangan']['detail']['sertifikasi']['jumlah'] - 3 }}
                                                                        lainnya</small>
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    @else
                                                        <p class="text-muted text-center mb-0">Tidak ada data</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Asosiasi Profesi -->
                                        <div class="col-md-3 mb-3">
                                            <div class="card h-100">
                                                <div class="card-header bg-info text-white text-center py-2">
                                                    <i class="bi bi-people"></i> Asosiasi Profesi
                                                </div>
                                                <div class="card-body p-2">
                                                    @if (isset($evaluasiData['pengembangan']['detail']['asosiasi']) &&
                                                            $evaluasiData['pengembangan']['detail']['asosiasi']['jumlah'] > 0)
                                                        <div class="text-center mb-2">
                                                            <h5 class="mb-0">
                                                                {{ $evaluasiData['pengembangan']['detail']['asosiasi']['jumlah'] }}
                                                            </h5>
                                                            <small class="text-muted">Keanggotaan</small>
                                                            <h6>{{ $evaluasiData['pengembangan']['detail']['asosiasi']['sks'] }}
                                                                sks</h6>
                                                        </div>
                                                        <ul class="list-group list-group-flush small">
                                                            @foreach ($evaluasiData['pengembangan']['detail']['asosiasi']['items']->take(3) as $item)
                                                                <li class="list-group-item p-1">
                                                                    <small>{{ Str::limit($item->nama_asosiasi, 30) }}</small>
                                                                    <span class="badge bg-info float-end">0.5</span>
                                                                </li>
                                                            @endforeach
                                                            @if ($evaluasiData['pengembangan']['detail']['asosiasi']['jumlah'] > 3)
                                                                <li class="list-group-item text-center">
                                                                    <small>+{{ $evaluasiData['pengembangan']['detail']['asosiasi']['jumlah'] - 3 }}
                                                                        lainnya</small>
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    @else
                                                        <p class="text-muted text-center mb-0">Tidak ada data</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- SIPP -->
                                        <div class="col-md-3 mb-3">
                                            <div class="card h-100">
                                                <div class="card-header bg-warning text-dark text-center py-2">
                                                    <i class="bi bi-award"></i> SIPP
                                                </div>
                                                <div class="card-body p-2">
                                                    @if (isset($evaluasiData['pengembangan']['detail']['sipp']) &&
                                                            $evaluasiData['pengembangan']['detail']['sipp']['status'] != 'Tidak Ada')
                                                        <div class="text-center">
                                                            <h5 class="mb-0">
                                                                {{ $evaluasiData['pengembangan']['detail']['sipp']['status'] }}
                                                            </h5>
                                                            <small class="text-muted">Status SIPP</small>
                                                            <h6>{{ $evaluasiData['pengembangan']['detail']['sipp']['sks'] }}
                                                                sks</h6>
                                                            <span class="badge bg-success mt-2">Aktif</span>
                                                        </div>
                                                    @else
                                                        <p class="text-muted text-center mb-0">Tidak ada SIPP aktif</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Total Pengembangan Profesi -->
                                    <div class="text-end mt-3 pt-2 border-top">
                                        <strong>Total SKS Pengembangan Profesi:
                                            {{ number_format($evaluasiData['pengembangan']['sks'], 2) }} sks</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Conclusion -->
                    <div
                        class="alert {{ $evaluasiData['status_keseluruhan'] == 'M' ? 'alert-success' : 'alert-danger' }} text-center mt-3">
                        <h5 class="mb-0">
                            <i
                                class="bi bi-{{ $evaluasiData['status_keseluruhan'] == 'M' ? 'check-circle' : 'x-circle' }}"></i>
                            Simpulan: {{ $evaluasiData['status_keseluruhan'] == 'M' ? 'MEMENUHI' : 'TIDAK MEMENUHI' }}
                            (Total sks: {{ number_format($evaluasiData['total_sks'], 2) }})
                        </h5>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <style>
        .table-bordered td,
        .table-bordered th {
            vertical-align: middle;
            padding: 12px;
        }

        .badge.fs-6 {
            font-size: 0.9rem;
            font-weight: 500;
        }

        .list-group-item {
            border-left: none;
            border-right: none;
        }

        .card-header {
            font-weight: 600;
        }

        .card {
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-3px);
        }
    </style>
@endsection
