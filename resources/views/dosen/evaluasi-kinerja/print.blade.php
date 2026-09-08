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

        .table-bordered td,
        .table-bordered th {
            padding: 8px;
            vertical-align: middle;
        }

        @media print {
            body {
                margin: 0;
                padding: 10px;
            }

            .no-print {
                display: none;
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
        <div class="header">
            <h3>EVALUASI KINERJA DOSEN</h3>
            <h5>{{ $period->nama_periode }}</h5>
            <p>{{ $dosen->nama }} ({{ $dosen->nidn }})</p>
        </div>

        <!-- Summary Cards -->
        <div class="row mb-3">
            <div class="col-md-3 text-center">
                <div class="border p-2">
                    <strong>Pendidikan</strong><br>
                    {{ number_format($evaluasiData['pendidikan']['sks'], 2) }} sks
                </div>
            </div>
            <div class="col-md-3 text-center">
                <div class="border p-2">
                    <strong>Penelitian</strong><br>
                    {{ number_format($evaluasiData['penelitian']['sks'], 2) }} sks
                </div>
            </div>
            <div class="col-md-3 text-center">
                <div class="border p-2">
                    <strong>Pengabdian</strong><br>
                    {{ number_format($evaluasiData['pengabdian']['sks'], 2) }} sks
                </div>
            </div>
            <div class="col-md-3 text-center">
                <div class="border p-2">
                    <strong>Penunjang</strong><br>
                    {{ number_format($evaluasiData['penunjang']['sks'], 2) }} sks
                </div>
            </div>
        </div>

        <!-- Keterangan -->
        <div class="mb-2">
            <span class="badge bg-success">M</span> = Memenuhi &nbsp;&nbsp;
            <span class="badge bg-danger">TM</span> = Tidak Memenuhi
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
                    <p>(_____________________)</p>
                </div>

                <div class="col-md-4 text-center">
                    <p>{{ $dosen->nama }}<br>Dosen Bersangkutan</p>
                    <br><br>
                    <p>(_____________________)</p>
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
