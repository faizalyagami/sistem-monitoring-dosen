@extends('components.layouts.app')
@section('content')
    <div class="container-fluid px-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="200">Dosen</th>
                        <td>: {{ $suratTugas->dosen->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Nama Surat</th>
                        <td>: {{ $suratTugas->nama_surat_tugas }}</td>
                    </tr>
                    <tr>
                        <th>No. Surat</th>
                        <td>: {{ $suratTugas->no_surat_tugas }}</td>
                    </tr>
                    <tr>
                        <th>Perihal</th>
                        <td>: {{ $suratTugas->perihal }}</td>
                    </tr>
                    <tr>
                        <th>File</th>
                        <td>: @if ($suratTugas->file_surat)
                                <a href="{{ route('admin.surat-tugas.download', $suratTugas->id) }}"
                                    class="btn btn-sm btn-info">Download</a>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
