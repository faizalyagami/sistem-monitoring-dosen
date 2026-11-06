<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Kinerja - {{ $dosen->nama }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Times New Roman', serif;
            padding: 20px;
            font-size: 12px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .header h3 {
            margin: 0;
        }

        @media print {
            .no-print {
                display: none;
            }

            body {
                padding: 0;
            }
        }

        .signature {
            margin-top: 40px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h3>LAPORAN KINERJA DOSEN</h3>
            <h5>{{ $period->nama_periode }}</h5>
            <p class="mb-0">{{ $dosen->nama }} ({{ $dosen->nidn }})</p>
        </div>

        <h5>Ringkasan</h5>
        <table class="table table-bordered">
            <tr>
                <th width="300">Total Pengajaran</th>
                <td>{{ $pengajaran->count() }} Mata Kuliah ({{ $pengajaran->sum('sks') }} SKS)</td>
            </tr>
            <tr>
                <th>Total Penelitian</th>
                <td>{{ $riset->count() }} Proyek</td>
            </tr>
            <tr>
                <th>Total PKM</th>
                <td>{{ $pkm->count() }} Kegiatan</td>
            </tr>
            <tr>
                <th>Total Bimbingan</th>
                <td>{{ $bimbingan->count() }} Bimbingan ({{ $bimbingan->sum('jumlah_mahasiswa') }} Mahasiswa)</td>
            </tr>
        </table>

        <div class="signature">
            <div class="row">
                <div class="col-md-6 text-center">
                    <p>Mengetahui,<br>Dekan Fakultas Psikologi</p>
                    <br><br>
                    <p>(_____________________)</p>
                </div>
                <div class="col-md-6 text-center">
                    <p>{{ $dosen->nama }}<br>Dosen Bersangkutan</p>
                    <br><br>
                    <p>({{ $dosen->nama }})</p>
                </div>
            </div>
        </div>

        <div class="text-center mt-4 small text-muted">
            Dicetak pada: {{ date('d F Y H:i:s') }} | SIMONKER
        </div>
    </div>

    <div class="text-center no-print mt-3">
        <button class="btn btn-primary" onclick="window.print()">Print</button>
        <button class="btn btn-secondary" onclick="window.close()">Close</button>
    </div>
</body>

</html>
