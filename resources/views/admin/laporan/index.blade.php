{{-- resources/views/admin/laporan/index.blade.php --}}
<x-layouts.app title="Laporan Kinerja Dosen">
    <div class="container-fluid">
        <h2 class="page-title mb-4">
            <i class="bi bi-file-text me-2"></i> Laporan Kinerja Dosen
        </h2>

        <!-- Filter Form -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.laporan.index') }}" class="row g-3">
                    <div class="col-md-5">
                        <x-forms.select name="period_id" label="Periode Akademik" :options="$periods->pluck('display_name', 'id')->toArray()" :selected="request('period_id')"
                            required />
                    </div>
                    <div class="col-md-5">
                        <x-forms.select name="dosen_id" label="Dosen (Opsional)" :options="$dosens->pluck('nama', 'id')->toArray()" :selected="request('dosen_id')" />
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-graph-up me-1"></i> Tampilkan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if ($laporanData)
            <!-- Report Result -->
            <div class="row">
                <!-- Summary Cards -->
                <div class="col-md-3 mb-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h6>Total Pengajaran</h6>
                            <h3>{{ $laporanData['total_pengajaran'] }}</h3>
                            <small>{{ $laporanData['total_sks'] }} SKS</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h6>Total Mahasiswa</h6>
                            <h3>{{ $laporanData['total_mahasiswa'] }}</h3>
                            <small>Diajar</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <h6>Total Penelitian</h6>
                            <h3>{{ $laporanData['total_riset'] }}</h3>
                            <small>Rp {{ number_format($laporanData['total_dana_riset'], 0, ',', '.') }}</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <h6>Total PKM</h6>
                            <h3>{{ $laporanData['total_pkm'] }}</h3>
                            <small>Rp {{ number_format($laporanData['total_dana_pkm'], 0, ',', '.') }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Tables -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Detail Pengajaran per Dosen</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Dosen</th>
                                    <th>Jumlah Mata Kuliah</th>
                                    <th>Total SKS</th>
                                    <th>Jumlah Mahasiswa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($laporanData['pengajaran_by_dosen'] as $item)
                                    <tr>
                                        <td>{{ $item->dosen->nama }}</td>
                                        <td>{{ $item->total }}</td>
                                        <td>{{ $item->dosen->pengajarans->where('academic_period_id', $selectedPeriod->id)->sum('sks') }}
                                        </td>
                                        <td>{{ $item->dosen->pengajarans->where('academic_period_id', $selectedPeriod->id)->sum('jumlah_mahasiswa') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Status Penelitian</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($laporanData['riset_by_status'] as $item)
                                    <tr>
                                        <td>{{ ucfirst($item->status) }}</td>
                                        <td>{{ $item->total }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-3 text-end">
                <a href="{{ route('admin.laporan.export.excel', request()->all()) }}" class="btn btn-success">
                    <i class="bi bi-file-excel me-2"></i> Export Excel
                </a>
                <a href="{{ route('admin.laporan.export.pdf', request()->all()) }}" class="btn btn-danger">
                    <i class="bi bi-file-pdf me-2"></i> Export PDF
                </a>
            </div>
        @endif
    </div>
</x-layouts.app>
