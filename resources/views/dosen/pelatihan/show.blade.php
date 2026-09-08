@extends('components.layouts.app')

@section('title', 'Detail Pelatihan')

@section('content')
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">
                            <i class="bi bi-info-circle"></i> Detail Pelatihan
                        </h1>
                        <p class="text-muted">Informasi lengkap pelatihan yang Anda ikuti</p>
                    </div>
                    <div>
                        <a href="{{ route('dosen.pelatihan.edit', $pelatihan->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <a href="{{ route('dosen.pelatihan.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-mortarboard me-2 text-success"></i> Informasi Pelatihan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="150">Nama Pelatihan</th>
                                        <td>: <strong>{{ $pelatihan->nama_pelatihan }}</strong></td>
                                    </tr>
                                    <tr>
                                        <th>Penyelenggara</th>
                                        <td>: {{ $pelatihan->penyelenggara }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal</th>
                                        <td>:
                                            {{ $pelatihan->tanggal_pelatihan ? date('d/m/Y', strtotime($pelatihan->tanggal_pelatihan)) : '-' }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="150">Lokasi</th>
                                        <td>: {{ $pelatihan->lokasi }}</td>
                                    </tr>
                                    <tr>
                                        <th>Durasi</th>
                                        <td>: {{ $pelatihan->durasi ? $pelatihan->durasi . ' Jam' : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Periode Akademik</th>
                                        <td>: {{ $pelatihan->academicPeriod->nama_periode ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Sertifikat</th>
                                        <td>:
                                            @if ($pelatihan->file_sertifikat)
                                                <a href="{{ route('dosen.pelatihan.download', $pelatihan->id) }}"
                                                    class="btn btn-sm btn-success">
                                                    <i class="bi bi-download"></i> Download
                                                </a>
                                            @else
                                                <span class="text-muted">Tidak ada file</span>
                                            @endif
                                        </td>
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
