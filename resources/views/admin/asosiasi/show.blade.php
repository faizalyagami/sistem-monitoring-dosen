@extends('components.layouts.app')
@section('title', 'Detail Asosiasi Profesi')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('admin.asosiasi.index') }}" class="btn btn-outline-secondary me-3"><i
                    class="bi bi-arrow-left"></i></a>
            <h1 class="h3 mb-0 text-gray-800"><i class="bi bi-info-circle"></i> Detail Asosiasi Profesi</h1>
        </div>

        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">Informasi Asosiasi</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <th width="200">Dosen</th>
                                <td>: <strong>{{ $asosiasi->dosen->nama ?? '-' }}</strong>
                                    ({{ $asosiasi->dosen->nidn ?? '-' }})</td>
                            </tr>
                            <tr>
                                <th>Nama Asosiasi</th>
                                <td>: {{ $asosiasi->nama_asosiasi }}</td>
                            </tr>
                            <tr>
                                <th>Peran</th>
                                <td>: <span class="badge bg-secondary">{{ $asosiasi->peran }}</span></td>
                            </tr>
                            <tr>
                                <th>Masa Aktif</th>
                                <td>: {{ $asosiasi->masa_aktif ? $asosiasi->masa_aktif->format('d F Y') : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tahun</th>
                                <td>: {{ $asosiasi->tahun }}</td>
                            </tr>
                            <tr>
                                <th>Periode Akademik</th>
                                <td>: {{ $asosiasi->academicPeriod->nama_periode ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Terakhir Diupdate</th>
                                <td>: {{ $asosiasi->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="card-footer bg-white text-end">
                        <a href="{{ route('admin.asosiasi.edit', $asosiasi->id) }}" class="btn btn-warning"><i
                                class="bi bi-pencil"></i> Edit Data</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
