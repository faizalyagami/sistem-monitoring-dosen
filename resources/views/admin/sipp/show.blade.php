@extends('components.layouts.app')
@section('content')
    <div class="container-fluid px-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="200">Dosen</th>
                        <td>: {{ $sipp->dosen->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>No. Registrasi</th>
                        <td>: {{ $sipp->no_registrasi }}</td>
                    </tr>
                    <tr>
                        <th>Bidang Keilmuan</th>
                        <td>: {{ $sipp->bidang_keilmuan }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>: {!! $sipp->status_badge !!}</td>
                    </tr>
                    <tr>
                        <th>File</th>
                        <td>: @if ($sipp->file_sipp)
                                <a href="{{ route('admin.sipp.download', $sipp->id) }}"
                                    class="btn btn-sm btn-info">Download</a>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
