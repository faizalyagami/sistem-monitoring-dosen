@extends('components.layouts.app')

@section('title', 'Dashboard Dosen')

@section('content')
    <div class="container-fluid px-4">
        <!-- Welcome Banner -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-gradient-primary text-white border-0">
                    <div class="card-body py-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="card-title mb-2 fw-bold">
                                    <i class="bi bi-emoji-smile"></i> Selamat Datang, {{ $dosen->nama }}!
                                </h3>
                                <p class="card-text opacity-75 mb-0">
                                    <i class="bi bi-calendar-week"></i> Periode Aktif:
                                    <strong>{{ $currentPeriod->display_name ?? 'Belum ada periode aktif' }}</strong>
                                </p>
                            </div>
                            <div class="text-center d-none d-md-block">
                                <img src="{{ $dosen->photo_url }}" class="rounded-circle border border-white" width="70"
                                    height="70" style="object-fit: cover;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted text-uppercase small fw-bold mb-2">Total Pengajaran</h6>
                                <h2 class="fw-bold mb-0">{{ $stats['total_pengajaran'] }}</h2>
                                <small class="text-success mt-2 d-block">
                                    <i class="bi bi-book"></i> {{ $stats['total_sks'] }} SKS
                                </small>
                            </div>
                            <div class="stats-icon bg-primary bg-opacity-10 text-primary rounded-3 p-3">
                                <i class="bi bi-book fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted text-uppercase small fw-bold mb-2">Total Penelitian</h6>
                                <h2 class="fw-bold mb-0">{{ $stats['total_riset'] }}</h2>
                                <small class="text-info mt-2 d-block">
                                    <i class="bi bi-mortarboard"></i> Proyek Penelitian
                                </small>
                            </div>
                            <div class="stats-icon bg-info bg-opacity-10 text-info rounded-3 p-3">
                                <i class="bi bi-mortarboard fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted text-uppercase small fw-bold mb-2">Total PKM</h6>
                                <h2 class="fw-bold mb-0">{{ $stats['total_pkm'] }}</h2>
                                <small class="text-success mt-2 d-block">
                                    <i class="bi bi-people-fill"></i> Kegiatan PKM
                                </small>
                            </div>
                            <div class="stats-icon bg-success bg-opacity-10 text-success rounded-3 p-3">
                                <i class="bi bi-people-fill fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted text-uppercase small fw-bold mb-2">Total Bimbingan</h6>
                                <h2 class="fw-bold mb-0">{{ $stats['total_bimbingan'] }}</h2>
                                <small class="text-warning mt-2 d-block">
                                    <i class="bi bi-chat-dots"></i> Mahasiswa Bimbingan
                                </small>
                            </div>
                            <div class="stats-icon bg-warning bg-opacity-10 text-warning rounded-3 p-3">
                                <i class="bi bi-chat-dots fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="row g-4">
            <div class="col-xl-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 pt-4">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="bi bi-clock-history me-2 text-primary"></i>
                            Pengajaran Terbaru
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            @forelse($recentPengajaran as $pengajaran)
                                <div class="list-group-item px-0 border-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">{{ $pengajaran->kode_mk }} - {{ $pengajaran->nama_mk }}</h6>
                                            <small class="text-muted">
                                                Kelas: {{ $pengajaran->kelas }} |
                                                {{ $pengajaran->sks }} SKS |
                                                {{ $pengajaran->jumlah_mahasiswa }} Mahasiswa
                                            </small>
                                        </div>
                                        <span class="badge bg-info">{{ $pengajaran->semester }}</span>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4">
                                    <i class="bi bi-inbox fs-1 text-muted"></i>
                                    <p class="text-muted mt-2">Belum ada data pengajaran</p>
                                    <a href="{{ route('dosen.pengajaran.create') }}" class="btn btn-sm btn-primary">
                                        Tambah Pengajaran
                                    </a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 pt-4">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="bi bi-newspaper me-2 text-info"></i>
                            Penelitian Terbaru
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            @forelse($recentRiset as $riset)
                                <div class="list-group-item px-0 border-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">{{ Str::limit($riset->judul_riset, 50) }}</h6>
                                            <small class="text-muted">
                                                {{ $riset->bidang_riset }} |
                                                Dana: {{ 'Rp ' . number_format($riset->jumlah_dana, 0, ',', '.') }}
                                            </small>
                                        </div>
                                        <span class="badge bg-{{ $riset->status == 'aktif' ? 'success' : 'secondary' }}">
                                            {{ $riset->status == 'aktif' ? 'Aktif' : 'Selesai' }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4">
                                    <i class="bi bi-inbox fs-1 text-muted"></i>
                                    <p class="text-muted mt-2">Belum ada data penelitian</p>
                                    <a href="{{ route('dosen.riset.create') }}" class="btn btn-sm btn-primary">
                                        Tambah Penelitian
                                    </a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .stats-icon {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .card {
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
        }
    </style>
@endsection
