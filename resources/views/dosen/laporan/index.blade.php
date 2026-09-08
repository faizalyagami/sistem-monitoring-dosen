@extends('components.layouts.app')

@section('title', 'Laporan Kinerja Saya')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="bi bi-file-text"></i> Laporan Kinerja Saya
                </h1>
                <p class="text-muted">Rekapitulasi kinerja per periode akademik</p>
            </div>
        </div>

        <!-- Filter -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-funnel"></i> Filter Laporan
                </h6>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('dosen.laporan.index') }}" class="row g-3">
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

        @if ($laporanData)
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">
                        Laporan Kinerja - {{ $selectedPeriod->nama_periode }}
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Summary Cards -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <i class="bi bi-book fs-2"></i>
                                    <h6 class="mt-2">Pendidikan</h6>
                                    <h3>{{ number_format($laporanData['total_sks_pendidikan'], 2) }} <small>SKS</small></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <i class="bi bi-mortarboard fs-2"></i>
                                    <h6 class="mt-2">Penelitian</h6>
                                    <h3>{{ number_format($laporanData['total_sks_penelitian'], 2) }} <small>SKS</small></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <i class="bi bi-people-fill fs-2"></i>
                                    <h6 class="mt-2">PKM</h6>
                                    <h3>{{ number_format($laporanData['total_sks_pkm'], 2) }} <small>SKS</small></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center">
                                    <i class="bi bi-star fs-2"></i>
                                    <h6 class="mt-2">Penunjang</h6>
                                    <h3>{{ number_format($laporanData['total_sks_penunjang'], 2) }} <small>SKS</small></h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Conclusion -->
                    <div
                        class="alert {{ $laporanData['status'] == 'Memenuhi' ? 'alert-success' : 'alert-danger' }} text-center">
                        <h5 class="mb-0">
                            <i class="bi bi-{{ $laporanData['status'] == 'Memenuhi' ? 'check-circle' : 'x-circle' }}"></i>
                            Status: {{ $laporanData['status'] }}
                            (Total SKS: {{ number_format($laporanData['total_sks'], 2) }})
                        </h5>
                    </div>

                    <div class="text-end">
                        <a href="{{ route('dosen.laporan.print', ['period_id' => $selectedPeriod->id]) }}"
                            class="btn btn-secondary" target="_blank">
                            <i class="bi bi-printer"></i> Print
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
