@extends('components.layouts.app')

@section('title', 'Detail Bimbingan')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800"><i class="bi bi-info-circle"></i> Detail Bimbingan</h1>
                <p class="text-muted">Informasi lengkap data bimbingan mahasiswa</p>
            </div>
            <div>
                <a href="{{ route('dosen.bimbingan.edit', $bimbingan->id) }}" class="btn btn-warning"><i
                        class="bi bi-pencil"></i> Edit</a>
                <a href="{{ route('dosen.bimbingan.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i>
                    Kembali</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">Informasi Bimbingan</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <th width="200">Jenis Bimbingan</th>
                                <td>:
                                    @if ($bimbingan->jenis_bimbingan == 'skripsi')
                                        <span class="badge bg-primary">Skripsi (S1)</span>
                                    @elseif($bimbingan->jenis_bimbingan == 'tesis')
                                        <span class="badge bg-success">Tesis (S2)</span>
                                    @else
                                        <span class="badge bg-info">Disertasi (S3)</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Kategori Bimbingan</th>
                                <td>: <span class="badge bg-secondary">{{ $bimbingan->kategori_bimbingan ?? '-' }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>Jumlah Mahasiswa</th>
                                <td>: <strong>{{ $bimbingan->jumlah_mahasiswa }}</strong> Mahasiswa</td>
                            </tr>
                            <tr>
                                <th>Periode Akademik</th>
                                <td>: {{ $bimbingan->academicPeriod->nama_periode ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Semester</th>
                                <td>: <span
                                        class="badge bg-{{ $bimbingan->semester == 'ganjil' ? 'info' : 'warning' }}">{{ ucfirst($bimbingan->semester) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>Tahun Akademik</th>
                                <td>: {{ $bimbingan->tahun_akademik }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">Informasi Surat Keputusan (SK)</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="p-3 border rounded bg-light mb-3">
                                    <h6 class="fw-bold text-primary">SK Pembimbing</h6>
                                    <p class="mb-1"><strong>No. SK:</strong> {{ $bimbingan->no_sk_pembimbing ?? '-' }}</p>
                                    <p class="mb-0"><strong>Tanggal:</strong>
                                        {{ $bimbingan->tanggal_sk_pembimbing ? $bimbingan->tanggal_sk_pembimbing->format('d/m/Y') : '-' }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 border rounded bg-light mb-3">
                                    <h6 class="fw-bold text-warning">SK Penguji</h6>
                                    <p class="mb-1"><strong>No. SK:</strong> {{ $bimbingan->no_sk_penguji ?? '-' }}</p>
                                    <p class="mb-0"><strong>Tanggal:</strong>
                                        {{ $bimbingan->tanggal_sk_penguji ? $bimbingan->tanggal_sk_penguji->format('d/m/Y') : '-' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
