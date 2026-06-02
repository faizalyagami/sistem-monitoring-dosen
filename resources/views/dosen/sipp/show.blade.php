@extends('components.layouts.app')

@section('title', 'Detail SIPP')

@section('content')
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">
                            <i class="bi bi-info-circle"></i> Detail SIPP
                        </h1>
                        <p class="text-muted">Informasi lengkap Sertifikat Pendidik Profesional Anda</p>
                    </div>
                    <div>
                        <a href="{{ route('dosen.sipp.edit', $sipp->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <a href="{{ route('dosen.sipp.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-award me-2 text-primary"></i> Informasi SIPP
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="150">No. Registrasi</th>
                                        <td>: <code>{{ $sipp->no_registrasi }}</code></td>
                                    </tr>
                                    <tr>
                                        <th>Bidang Keilmuan</th>
                                        <td>: {{ $sipp->bidang_keilmuan }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="150">Tahun Terbit</th>
                                        <td>: {{ $sipp->tahun_terbit }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>: {!! $sipp->status_badge !!}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Input</th>
                                        <td>: {{ $sipp->created_at->format('d/m/Y H:i:s') }}</td>
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
