@extends('components.layouts.app')

@section('title', 'Detail PKM')

@section('content')
    <div class="container-fluid px-4">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Detail PKM</h5>
                    <a href="{{ route('dosen.pkm.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="200">Judul</th>
                            <td>{{ $pkm->judul_pkm }}</td>
                        </tr>
                        <tr>
                            <th>Bidang</th>
                            <td>{{ $pkm->bidang_pkm }}</td>
                        </tr>
                        <tr>
                            <th>Jenis</th>
                            <td>{{ $pkm->jenis_pkm }}</td>
                        </tr>
                        <tr>
                            <th>Sumber Dana</th>
                            <td>{{ $pkm->sumber_dana }}</td>
                        </tr>
                        <tr>
                            <th>Jumlah Dana</th>
                            <td>Rp {{ number_format($pkm->jumlah_dana, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>{{ ucfirst($pkm->status) }}</td>
                        </tr>
                        <tr>
                            <th>Tahun</th>
                            <td>{{ $pkm->tahun }}</td>
                        </tr>
                        <tr>
                            <th>File Laporan</th>
                            <td>
                                @if ($pkm->file_laporan)
                                    <a href="{{ route('dosen.pkm.download', $pkm->id) }}"
                                        class="btn btn-sm btn-success">Download</a>
                                @else
                                    Tidak ada file
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
