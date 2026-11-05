@extends('components.layouts.app')
@section('content')
    <div class="container-fluid px-4">
        <h1 class="h3 mb-4">Detail Pelatihan</h1>
        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="200">Dosen</th>
                        <td>: {{ $pelatihan->dosen->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Nama Pelatihan</th>
                        <td>: {{ $pelatihan->nama_pelatihan }}</td>
                    </tr>
                    <tr>
                        <th>Penyelenggara</th>
                        <td>: {{ $pelatihan->penyelenggara }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal</th>
                        <td>: {{ $pelatihan->tanggal_pelatihan->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th>Lokasi</th>
                        <td>: {{ $pelatihan->lokasi }}</td>
                    </tr>
                    <tr>
                        <th>Durasi</th>
                        <td>: {{ $pelatihan->durasi ?? '-' }} Jam</td>
                    </tr>
                    <tr>
                        <th>File</th>
                        <td>: @if ($pelatihan->file_sertifikat)
                                <a href="{{ route('admin.pelatihan.download', $pelatihan->id) }}"
                                    class="btn btn-sm btn-info">Download</a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
