@extends('components.layouts.app')

@section('title', 'Detail Asosiasi')

@section('content')
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">
                            <i class="bi bi-info-circle"></i> Detail Asosiasi Profesi
                        </h1>
                        <p class="text-muted">Informasi lengkap keanggotaan asosiasi profesi</p>
                    </div>
                    <div>
                        <a href="{{ route('dosen.asosiasi.edit', $asosiasi->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <a href="{{ route('dosen.asosiasi.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-people me-2 text-primary"></i> Informasi Asosiasi
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="150">Nama Asosiasi</th>
                                        <td>: <strong>{{ $asosiasi->nama_asosiasi }}</strong></td>
                                    </tr>
                                    <tr>
                                        <th>Peran</th>
                                        <td>: {{ $asosiasi->peran }}</td>
                                    </tr>
                                    <tr>
                                        <th>Masa Aktif</th>
                                        <td>:
                                            {{ $asosiasi->masa_aktif ? date('d/m/Y', strtotime($asosiasi->masa_aktif)) : '-' }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="150">Tahun</th>
                                        <td>: {{ $asosiasi->tahun }}</td>
                                    </tr>
                                    <tr>
                                        <th>Periode Akademik</th>
                                        <td>: {{ $asosiasi->academicPeriod->nama_periode ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Input</th>
                                        <td>: {{ $asosiasi->created_at->format('d/m/Y H:i:s') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
