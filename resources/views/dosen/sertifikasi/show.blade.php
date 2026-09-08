@extends('components.layouts.app')

@section('title', 'Detail Sertifikasi')

@section('content')
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">
                            <i class="bi bi-info-circle"></i> Detail Sertifikasi
                        </h1>
                        <p class="text-muted">Informasi lengkap sertifikasi profesional Anda</p>
                    </div>
                    <div>
                        <a href="{{ route('dosen.sertifikasi.edit', $sertifikasi->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <a href="{{ route('dosen.sertifikasi.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-patch-check me-2 text-success"></i> Informasi Sertifikasi
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="150">Jenis Sertifikasi</th>
                                        <td>: <strong>{{ $sertifikasi->jenis_sertifikasi }}</strong></td>
                                    </tr>
                                    <tr>
                                        <th>Lembaga</th>
                                        <td>: {{ $sertifikasi->lembaga_sertifikasi }}</td>
                                    </tr>
                                    <tr>
                                        <th>No. Sertifikat</th>
                                        <td>: <code>{{ $sertifikasi->nomor_sertifikasi }}</code></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="150">Tanggal Terbit</th>
                                        <td>:
                                            {{ $sertifikasi->tanggal_sertifikasi ? date('d/m/Y', strtotime($sertifikasi->tanggal_sertifikasi)) : '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Valid Until</th>
                                        <td>:
                                            {{ $sertifikasi->valid_until ? date('d/m/Y', strtotime($sertifikasi->valid_until)) : '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>: {!! $sertifikasi->status !!}</td>
                                    </tr>
                                    <tr>
                                        <th>File Sertifikat</th>
                                        <td>:
                                            @if ($sertifikasi->file_sertifikat)
                                                <a href="{{ route('dosen.sertifikasi.download', $sertifikasi->id) }}"
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
