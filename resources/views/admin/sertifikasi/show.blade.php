@extends('components.layouts.app')
@section('content')
    <div class="container-fluid px-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="200">Dosen</th>
                        <td>: {{ $sertifikasi->dosen->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Jenis</th>
                        <td>: {{ $sertifikasi->jenis_sertifikasi }}</td>
                    </tr>
                    <tr>
                        <th>Lembaga</th>
                        <td>: {{ $sertifikasi->lembaga_sertifikasi }}</td>
                    </tr>
                    <tr>
                        <th>No. Sertifikat</th>
                        <td>: {{ $sertifikasi->nomor_sertifikasi }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>: {!! $sertifikasi->status !!}</td>
                    </tr>
                    <tr>
                        <th>File</th>
                        <td>: @if ($sertifikasi->file_sertifikat)
                                <a href="{{ route('admin.sertifikasi.download', $sertifikasi->id) }}"
                                    class="btn btn-sm btn-info">Download</a>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
