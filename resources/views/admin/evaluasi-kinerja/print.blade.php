<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Evaluasi Kinerja - {{ $dosen->nama }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            padding: 20px;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .header h3 {
            margin-bottom: 5px;
        }

        .table-bordered td,
        .table-bordered th {
            padding: 8px;
            vertical-align: middle;
        }

        .badge {
            font-size: 11px;
        }

        .info-box {
            background: #f8f9fa;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        @media print {
            body {
                margin: 0;
                padding: 10px;
            }

            .no-print {
                display: none;
            }

            .page-break {
                page-break-before: always;
            }
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
        }

        .signature {
            margin-top: 40px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h3>LAPORAN KINERJA DOSEN</h3>
            <h5>{{ $period->nama_periode }}</h5>
            <p>{{ $dosen->nama }} ({{ $dosen->nidn }})</p>
        </div>

        <!-- Info -->
        <div class="info-box">
            <div class="row">
                <div class="col-md-4">
                    <strong>Penarikan Kinerja:</strong><br>
                    {{ $period->tanggal_mulai ? date('d F Y', strtotime($period->tanggal_mulai)) : '-' }}
                    s.d {{ $period->tanggal_selesai ? date('d F Y', strtotime($period->tanggal_selesai)) : '-' }}
                </div>
                <div class="col-md-4">
                    <strong>Periode Pengisian:</strong><br>
                    12 Januari 2026 s.d 31 Mei 2026
                </div>
                <div class="col-md-4">
                    <strong>Periode Penilaian:</strong><br>
                    12 Januari 2026 s.d 31 Mei 2026
                </div>
            </div>
        </div>

        <!-- Summary Badges -->
        <div class="row mb-3">
            <div class="col-md-3 text-center">
                <div class="border p-2">
                    <strong>Pendidikan</strong><br>
                    {{ number_format($evaluasiData['pendidikan']['sks'], 2) }} sks<br>
                    <span class="badge bg-{{ $evaluasiData['pendidikan']['status'] == 'M' ? 'success' : 'danger' }}">
                        {{ $evaluasiData['pendidikan']['status'] == 'M' ? 'Memenuhi' : 'Tidak Memenuhi' }}
                    </span>
                </div>
            </div>
            <div class="col-md-3 text-center">
                <div class="border p-2">
                    <strong>Penelitian</strong><br>
                    {{ number_format($evaluasiData['penelitian']['sks'], 2) }} sks<br>
                    <span class="badge bg-{{ $evaluasiData['penelitian']['status'] == 'M' ? 'success' : 'danger' }}">
                        {{ $evaluasiData['penelitian']['status'] == 'M' ? 'Memenuhi' : 'Tidak Memenuhi' }}
                    </span>
                </div>
            </div>
            <div class="col-md-3 text-center">
                <div class="border p-2">
                    <strong>Pengabdian</strong><br>
                    {{ number_format($evaluasiData['pengabdian']['sks'], 2) }} sks<br>
                    <span class="badge bg-{{ $evaluasiData['pengabdian']['status'] == 'M' ? 'success' : 'danger' }}">
                        {{ $evaluasiData['pengabdian']['status'] == 'M' ? 'Memenuhi' : 'Tidak Memenuhi' }}
                    </span>
                </div>
            </div>
            <div class="col-md-3 text-center">
                <div class="border p-2">
                    <strong>Penunjang</strong><br>
                    {{ number_format($evaluasiData['penunjang']['sks'], 2) }} sks<br>
                    <span class="badge bg-{{ $evaluasiData['penunjang']['status'] == 'M' ? 'success' : 'danger' }}">
                        {{ $evaluasiData['penunjang']['status'] == 'M' ? 'Memenuhi' : 'Tidak Memenuhi' }}
                    </span>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card border-secondary mb-3">
                        <div class="card-header bg-secondary text-white">
                            <i class="bi bi-award"></i> Detail Pengembangan Profesi
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Pelatihan -->
                                <div class="col-md-3">
                                    <strong>Pelatihan</strong><br>
                                    @if (isset($evaluasiData['pengembangan']['detail']['pelatihan']) &&
                                            $evaluasiData['pengembangan']['detail']['pelatihan']['jumlah'] > 0)
                                        {{ $evaluasiData['pengembangan']['detail']['pelatihan']['jumlah'] }} Kegiatan
                                        ({{ $evaluasiData['pengembangan']['detail']['pelatihan']['sks'] }} sks)
                                    @else
                                        Tidak ada data
                                    @endif
                                </div>
                                <!-- Sertifikasi -->
                                <div class="col-md-3">
                                    <strong>Sertifikasi</strong><br>
                                    @if (isset($evaluasiData['pengembangan']['detail']['sertifikasi']) &&
                                            $evaluasiData['pengembangan']['detail']['sertifikasi']['jumlah'] > 0)
                                        {{ $evaluasiData['pengembangan']['detail']['sertifikasi']['jumlah'] }}
                                        Sertifikat
                                        ({{ $evaluasiData['pengembangan']['detail']['sertifikasi']['sks'] }} sks)
                                    @else
                                        Tidak ada data
                                    @endif
                                </div>
                                <!-- Asosiasi -->
                                <div class="col-md-3">
                                    <strong>Asosiasi Profesi</strong><br>
                                    @if (isset($evaluasiData['pengembangan']['detail']['asosiasi']) &&
                                            $evaluasiData['pengembangan']['detail']['asosiasi']['jumlah'] > 0)
                                        {{ $evaluasiData['pengembangan']['detail']['asosiasi']['jumlah'] }} Keanggotaan
                                        ({{ $evaluasiData['pengembangan']['detail']['asosiasi']['sks'] }} sks)
                                    @else
                                        Tidak ada data
                                    @endif
                                </div>
                                <!-- SIPP -->
                                <div class="col-md-3">
                                    <strong>SIPP</strong><br>
                                    @if (isset($evaluasiData['pengembangan']['detail']['sipp']) &&
                                            $evaluasiData['pengembangan']['detail']['sipp']['status'] != 'Tidak Ada')
                                        Status: {{ $evaluasiData['pengembangan']['detail']['sipp']['status'] }}
                                        ({{ $evaluasiData['pengembangan']['detail']['sipp']['sks'] }} sks)
                                    @else
                                        Tidak ada SIPP aktif
                                    @endif
                                </div>
                            </div>
                            <div class="text-end mt-3 pt-2 border-top">
                                <strong>Total SKS Pengembangan Profesi:
                                    {{ number_format($evaluasiData['pengembangan']['sks'], 2) }} sks</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Table -->
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th width="50">No</th>
                    <th>Jenis Kinerja</th>
                    <th>Syarat</th>
                    <th width="100">sks BKD</th>
                    <th width="100">sks Lebih</th>
                    <th width="80">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($evaluasiData['kinerja_table'] as $item)
                    <tr>
                        <td>{{ $item['no'] }}</td>
                        <td>{{ $item['jenis_kinerja'] }}</td>
                        <td>{{ $item['syarat'] }}</td>
                        <td>{{ $item['sks_bkd'] }}</td>
                        <td>{{ $item['sks_lebih'] }}</td>
                        <td class="text-center">{{ $item['status'] }}</td>
                    </tr>
                @endforeach

                @foreach ($evaluasiData['criteria_rows'] as $item)
                    <tr>
                        <td>—</td>
                        <td>{{ $item['jenis_kinerja'] }}</td>
                        <td>{{ $item['syarat'] }}</td>
                        <td>{{ $item['sks_bkd'] }}</td>
                        <td>{{ $item['sks_lebih'] }}</td>
                        <td class="text-center">{{ $item['status'] }}</td>
                    </tr>
                @endforeach

                <tr class="table-secondary">
                    <td colspan="2"><strong>{{ $evaluasiData['summary_row']['jenis_kinerja'] }}</strong></td>
                    <td>{{ $evaluasiData['summary_row']['syarat'] }}</td>
                    <td><strong>{{ $evaluasiData['summary_row']['sks_bkd'] }}</strong></td>
                    <td><strong>{{ $evaluasiData['summary_row']['sks_lebih'] }}</strong></td>
                    <td class="text-center"><strong>{{ $evaluasiData['summary_row']['status'] }}</strong></td>
                </tr>
            </tbody>
        </table>

        <!-- Conclusion -->
        <div
            class="alert alert-{{ $evaluasiData['status_keseluruhan'] == 'M' ? 'success' : 'danger' }} text-center mt-3">
            <h5>
                Simpulan: {{ $evaluasiData['status_keseluruhan'] == 'M' ? 'MEMENUHI' : 'TIDAK MEMENUHI' }}
                (Total sks: {{ number_format($evaluasiData['total_sks'], 2) }})
            </h5>
        </div>

        <!-- Signatures -->
        <div class="signature">
            <div class="row justify-content-end">
                <div class="col-md-4 text-center">
                    <p>Mengetahui,<br>Dekan Fakultas Psikologi</p>
                    <br><br>
                    <p>(Dr. Dewi Rosiana, M.Psi., Psikolog.)</p>
                </div>
                <div class="col-md-4 text-center">
                    <p>{{ $dosen->nama }}<br>Dosen Bersangkutan</p>
                    <br><br>
                    <p>({{ $dosen->nama }})</p>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>Dicetak pada: {{ date('d F Y H:i:s') }}</p>
            <p>Sistem Monitoring Kinerja Dosen (SIMONKER)</p>
        </div>
    </div>

    <div class="text-center no-print mt-3">
        <button class="btn btn-primary" onclick="window.print()">Print</button>
        <button class="btn btn-secondary" onclick="window.close()">Close</button>
    </div>
</body>

</html>
