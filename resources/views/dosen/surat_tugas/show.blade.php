@extends('components.layouts.app')

@section('title', 'Detail Surat Tugas')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800"><i class="bi bi-info-circle"></i> Detail Surat Tugas</h1>
                <p class="text-muted mb-0">Informasi lengkap surat tugas</p>
            </div>
            <div>
                <a href="{{ route('dosen.surat-tugas.edit', $suratTugas->id) }}" class="btn btn-warning"><i
                        class="bi bi-pencil"></i> Edit</a>
                <a href="{{ route('dosen.surat-tugas.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i>
                    Kembali</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-envelope-paper me-2 text-primary"></i> Informasi Surat
                            Tugas</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <th width="200">Nama Surat Tugas</th>
                                <td>: <strong>{{ $suratTugas->nama_surat_tugas }}</strong></td>
                            </tr>
                            <tr>
                                <th>No. Surat</th>
                                <td>: <code>{{ $suratTugas->no_surat_tugas }}</code></td>
                            </tr>
                            <tr>
                                <th>Tanggal Surat</th>
                                <td>: {{ $suratTugas->tanggal_surat_tugas->format('d F Y') }}</td>
                            </tr>
                            <tr>
                                <th>Periode Akademik</th>
                                <td>: {{ $suratTugas->academicPeriod->nama_periode ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Perihal</th>
                                <td>: {{ $suratTugas->perihal ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>File Surat</th>
                                <td>:
                                    @if ($suratTugas->file_surat)
                                        <a href="{{ route('dosen.surat-tugas.download', $suratTugas->id) }}"
                                            class="btn btn-sm btn-success">
                                            <i class="bi bi-download"></i> Download File
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
@endsection
