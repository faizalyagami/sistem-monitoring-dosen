<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Kinerja Dosen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Times New Roman', serif;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .table th,
        .table td {
            padding: 8px;
            vertical-align: middle;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h3>LAPORAN KINERJA DOSEN</h3>
            <h5>Periode: {{ $period->nama_periode }}</h5>
            @if ($dosen)
                <p>Dosen: {{ $dosen->nama }} ({{ $dosen->nidn }})</p>
            @else
                <p>Semua Dosen</p>
            @endif
            <p>Tanggal Cetak: {{ date('d F Y H:i:s') }}</p>
        </div>

        <!-- Summary -->
        <div class="row mb-4">
            <div class="col-md-3">
                <strong>Total Pengajaran:</strong> {{ $reportData['summary']['total_pengajaran'] }} MK
                ({{ $reportData['summary']['total_sks'] }} SKS)
            </div>
            <div class="col-md-3">
                <strong>Total Mahasiswa:</strong> {{ $reportData['summary']['total_mahasiswa'] }}
            </div>
            <div class="col-md-3">
                <strong>Total Penelitian:</strong> {{ $reportData['summary']['total_riset'] }}
            </div>
            <div class="col-md-3">
                <strong>Total PKM:</strong> {{ $reportData['summary']['total_pkm'] }}
            </div>
        </div>

        <!-- Add more content as needed -->

        <div class="text-center mt-5">
            <p>Laporan ini dicetak secara otomatis dari sistem SIMONKER</p>
        </div>
    </div>

    <div class="text-center no-print mt-3">
        <button class="btn btn-primary" onclick="window.print()">Print</button>
        <button class="btn btn-secondary" onclick="window.close()">Close</button>
    </div>
</body>

</html>
