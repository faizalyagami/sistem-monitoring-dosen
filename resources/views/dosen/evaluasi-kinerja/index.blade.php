@extends('components.layouts.app')

@section('title', 'Evaluasi Kinerja Saya')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="bi bi-clipboard-check"></i> Evaluasi Kinerja Saya
                </h1>
                <p class="text-muted">Evaluasi kinerja dosen per periode akademik</p>
            </div>
        </div>

        <!-- Filter -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-funnel"></i> Filter Evaluasi
                </h6>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('dosen.evaluasi-kinerja.index') }}" class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Periode Akademik</label>
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
                    <div class="col-md-6 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search"></i> Tampilkan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if ($evaluasiData)
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">
                        Evaluasi Kinerja - {{ $selectedPeriod->nama_periode }}
                    </h5>
                </div>
                <div class="card-body">
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

                                <!-- Summary Row -->
                                <tr>
                                    <td colspan="2">
                                        <strong>{{ $evaluasiData['summary_row']['jenis_kinerja'] }}</strong>
                                    </td>
                                    <td>{{ $evaluasiData['summary_row']['syarat'] }}</td>
                                    <td><strong>{{ $evaluasiData['summary_row']['sks_bkd'] }}</strong></td>
                                    <td><strong>{{ $evaluasiData['summary_row']['sks_lebih'] }}</strong></td>
                                    <td class="text-center">
                                        <span
                                            class="badge bg-{{ $evaluasiData['summary_row']['status'] == 'M' ? 'success' : 'danger' }} fs-6 px-3 py-2">
                                            {{ $evaluasiData['summary_row']['status'] }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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

                    <div class="text-end mt-3">
                        <a href="{{ route('dosen.evaluasi-kinerja.print', ['period_id' => $selectedPeriod->id]) }}"
                            class="btn btn-secondary" target="_blank">
                            <i class="bi bi-printer"></i> Print
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
