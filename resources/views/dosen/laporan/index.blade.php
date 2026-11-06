@extends('components.layouts.app')

@section('title', 'Laporan Kinerja Saya')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800"><i class="bi bi-file-text"></i> Laporan Kinerja Saya</h1>
                <p class="text-muted">Rekapitulasi kinerja Anda per periode akademik</p>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-funnel"></i> Filter Laporan</h6>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('dosen.laporan.index') }}" class="row g-3">
                    <div class="col-md-6">
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
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i> Tampilkan</button>
                    </div>
                </form>
            </div>
        </div>

        @if ($laporanData)
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 fw-bold">Laporan Kinerja - {{ $selectedPeriod->nama_periode }}</h5>
                                <a href="{{ route('dosen.laporan.print', ['period_id' => $selectedPeriod->id]) }}"
                                    class="btn btn-sm btn-secondary" target="_blank">
                                    <i class="bi bi-printer"></i> Print
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <div class="card bg-primary text-white border-0">
                                        <div class="card-body text-center">
                                            <i class="bi bi-book fs-2"></i>
                                            <h6 class="mt-2">Pengajaran</h6>
                                            <h3 class="mb-0">{{ $laporanData['pengajaran']->count() }}</h3>
                                            <small>{{ $laporanData['pengajaran']->sum('sks') }} SKS</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-success text-white border-0">
                                        <div class="card-body text-center">
                                            <i class="bi bi-mortarboard fs-2"></i>
                                            <h6 class="mt-2">Penelitian</h6>
                                            <h3 class="mb-0">{{ $laporanData['riset']->count() }}</h3>
                                            <small>Rp
                                                {{ number_format($laporanData['riset']->sum('jumlah_dana'), 0, ',', '.') }}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-info text-white border-0">
                                        <div class="card-body text-center">
                                            <i class="bi bi-people-fill fs-2"></i>
                                            <h6 class="mt-2">PKM</h6>
                                            <h3 class="mb-0">{{ $laporanData['pkm']->count() }}</h3>
                                            <small>Rp
                                                {{ number_format($laporanData['pkm']->sum('jumlah_dana'), 0, ',', '.') }}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-warning text-white border-0">
                                        <div class="card-body text-center">
                                            <i class="bi bi-chat-dots fs-2"></i>
                                            <h6 class="mt-2">Bimbingan</h6>
                                            <h3 class="mb-0">{{ $laporanData['bimbingan']->count() }}</h3>
                                            <small>{{ $laporanData['bimbingan']->sum('jumlah_mahasiswa') }}
                                                Mahasiswa</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <h5 class="fw-bold mb-3">Detail Data</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="card border-primary">
                                        <div class="card-header bg-primary text-white"><i class="bi bi-book"></i> Riwayat
                                            Pengajaran</div>
                                        <div class="card-body p-0">
                                            <ul class="list-group list-group-flush">
                                                @forelse($laporanData['pengajaran'] as $item)
                                                    <li class="list-group-item d-flex justify-content-between">
                                                        <span>{{ $item->nama_mk }} ({{ $item->kelas }})</span>
                                                        <span class="badge bg-primary">{{ $item->sks }} SKS</span>
                                                    </li>
                                                @empty
                                                    <li class="list-group-item text-muted text-center">Belum ada data</li>
                                                @endforelse
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-success">
                                        <div class="card-header bg-success text-white"><i class="bi bi-mortarboard"></i>
                                            Riwayat Penelitian</div>
                                        <div class="card-body p-0">
                                            <ul class="list-group list-group-flush">
                                                @forelse($laporanData['riset'] as $item)
                                                    <li class="list-group-item d-flex justify-content-between">
                                                        <span>{{ Str::limit($item->judul_riset, 40) }}</span>
                                                        <span class="badge bg-success">{{ $item->tahun }}</span>
                                                    </li>
                                                @empty
                                                    <li class="list-group-item text-muted text-center">Belum ada data</li>
                                                @endforelse
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif(request('period_id'))
            <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle"></i> Data tidak ditemukan untuk periode yang dipilih.
            </div>
        @endif
    </div>
@endsection
