<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Pengajaran;
use App\Models\Riset;
use App\Models\Pkm;
use App\Models\Bimbingan;
use App\Models\Pelatihan;
use App\Models\Sertifikasi;
use App\Models\Asosiasi;
use App\Models\Sipp;
use App\Models\AcademicPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EvaluasiKinerjaController extends Controller
{
    /**
     * Display evaluasi kinerja for a lecturer
     */
    public function index(Request $request)
    {
        $dosens = Dosen::orderBy('nama')->get();
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();

        $selectedDosen = null;
        $selectedPeriod = null;
        $evaluasiData = null;

        if ($request->has('dosen_id') && $request->has('period_id')) {
            $selectedDosen = Dosen::find($request->dosen_id);
            $selectedPeriod = AcademicPeriod::find($request->period_id);

            if ($selectedDosen && $selectedPeriod) {
                $evaluasiData = $this->calculateEvaluasi($selectedDosen, $selectedPeriod);
            }
        }

        return view('admin.evaluasi-kinerja.index', compact('dosens', 'periods', 'selectedDosen', 'selectedPeriod', 'evaluasiData'));
    }

    /**
     * Calculate evaluation data for a lecturer
     */
    private function calculateEvaluasi($dosen, $period)
    {
        // Get data for the period
        $pengajarans = Pengajaran::where('dosen_id', $dosen->id)
            ->where('academic_period_id', $period->id)
            ->get();

        $risets = Riset::where('dosen_id', $dosen->id)
            ->where('academic_period_id', $period->id)
            ->get();

        $pkms = Pkm::where('dosen_id', $dosen->id)
            ->where('academic_period_id', $period->id)
            ->get();

        $bimbingans = Bimbingan::where('dosen_id', $dosen->id)
            ->where('academic_period_id', $period->id)
            ->get();

        // ========== PENGEMBANGAN PROFESI ==========
        // 5a. Pelatihan
        $pelatihans = Pelatihan::where('dosen_id', $dosen->id)
            ->where('academic_period_id', $period->id)
            ->get();

        $sksPelatihan = 0;
        foreach ($pelatihans as $pelatihan) {
            // 1 SKS per 8 jam pelatihan (konversi)
            $sks = $pelatihan->durasi ? $pelatihan->durasi / 8 : 1;
            $sksPelatihan += $sks;
        }

        // 5b. Sertifikasi
        $sertifikasis = Sertifikasi::where('dosen_id', $dosen->id)
            ->where('academic_period_id', $period->id)
            ->get();

        $sksSertifikasi = $sertifikasis->count() * 1; // 1 SKS per sertifikasi

        // 5c. Asosiasi Profesi
        $asosiasis = Asosiasi::where('dosen_id', $dosen->id)
            ->where('academic_period_id', $period->id)
            ->get();

        $sksAsosiasi = $asosiasis->count() * 0.5; // 0.5 SKS per asosiasi

        // 5d. SIPP (Sertifikat Pendidik Profesional)
        $sipps = Sipp::where('dosen_id', $dosen->id)->get();
        $sksSipp = 0;
        foreach ($sipps as $sipp) {
            if ($sipp->status == 'aktif') {
                $sksSipp = 2; // Maksimal 2 SKS untuk SIPP aktif
                break;
            }
        }

        // Total SKS Pengembangan Profesi
        $sksPengembangan = $sksPelatihan + $sksSertifikasi + $sksAsosiasi + $sksSipp;

        // 1. Pelaksanaan Pendidikan (Teaching)
        $sksPendidikan = 0;
        $detailPendidikan = [];

        foreach ($pengajarans as $pengajaran) {
            $sks = $pengajaran->sks;
            $sksPendidikan += $sks;

            $detailPendidikan[] = [
                'kegiatan' => $pengajaran->nama_mk . ' (' . $pengajaran->kelas . ')',
                'sks' => $sks,
                'keterangan' => $pengajaran->jumlah_mahasiswa . ' mahasiswa'
            ];
        }

        // Add bimbingan to pendidikan
        foreach ($bimbingans as $bimbingan) {
            $sksBimbingan = $bimbingan->jumlah_mahasiswa * 0.5;
            $sksPendidikan += $sksBimbingan;

            $detailPendidikan[] = [
                'kegiatan' => 'Bimbingan ' . $bimbingan->jenis_bimbingan,
                'sks' => $sksBimbingan,
                'keterangan' => $bimbingan->jumlah_mahasiswa . ' mahasiswa'
            ];
        }

        // 2. Pelaksanaan Penelitian (Research)
        $sksPenelitian = 0;
        $detailPenelitian = [];

        foreach ($risets as $riset) {
            $sks = 3;
            if ($riset->jumlah_dana > 50000000) $sks = 6;
            elseif ($riset->jumlah_dana > 25000000) $sks = 4;

            $sksPenelitian += $sks;

            $detailPenelitian[] = [
                'kegiatan' => $riset->judul_riset,
                'sks' => $sks,
                'keterangan' => $riset->sumber_dana . ' - Rp ' . number_format($riset->jumlah_dana, 0, ',', '.')
            ];
        }

        // 3. Pelaksanaan Pengabdian (PKM)
        $sksPengabdian = 0;
        $detailPengabdian = [];

        foreach ($pkms as $pkm) {
            $sks = 2;
            if ($pkm->jumlah_dana > 25000000) $sks = 4;
            elseif ($pkm->jumlah_dana > 10000000) $sks = 3;

            $sksPengabdian += $sks;

            $detailPengabdian[] = [
                'kegiatan' => $pkm->judul_pkm,
                'sks' => $sks,
                'keterangan' => $pkm->lokasi_kegiatan . ' - Rp ' . number_format($pkm->jumlah_dana, 0, ',', '.')
            ];
        }

        // 4. Pelaksanaan Penunjang (Supporting Activities)
        $sksPenunjang = 0.75;
        $detailPenunjang = [
            [
                'kegiatan' => 'Kegiatan Penunjang Lainnya',
                'sks' => 0.75,
                'keterangan' => 'Sesuai ketentuan'
            ]
        ];

        // Calculate totals and status
        $targetMinimal = 3;
        $targetMaksimal = 16;

        $totalSks = $sksPendidikan + $sksPenelitian + $sksPengabdian + $sksPenunjang + $sksPengembangan;
        $sksLebih = max($totalSks - $targetMinimal, 0);

        // Determine status for each category
        $statusPendidikan = $sksPendidikan >= $targetMinimal ? 'M' : 'TM';
        $statusPenelitian = $sksPenelitian >= 0 ? 'M' : 'TM';
        $statusPengabdian = $sksPengabdian >= 0 ? 'M' : 'TM';
        $statusPenunjang = $sksPenunjang >= 0 ? 'M' : 'TM';
        $statusPengembangan = $sksPengembangan > 0 ? 'M' : 'M';
        $statusKeseluruhan = $totalSks >= $targetMinimal ? 'M' : 'TM';

        // Prepare data for the table
        $kinerjaTable = [
            [
                'no' => 1,
                'jenis_kinerja' => 'Pelaksanaan Pendidikan',
                'syarat' => 'Minimal 3 sks',
                'sks_bkd' => number_format($sksPendidikan, 2),
                'sks_lebih' => number_format(max($sksPendidikan - $targetMinimal, 0), 2),
                'status' => $statusPendidikan
            ],
            [
                'no' => 2,
                'jenis_kinerja' => 'Pelaksanaan Penelitian',
                'syarat' => 'Boleh Kosong',
                'sks_bkd' => number_format($sksPenelitian, 2),
                'sks_lebih' => '0',
                'status' => $statusPenelitian
            ],
            [
                'no' => 3,
                'jenis_kinerja' => 'Pelaksanaan Pengabdian',
                'syarat' => 'Boleh Kosong',
                'sks_bkd' => number_format($sksPengabdian, 2),
                'sks_lebih' => '0',
                'status' => $statusPengabdian
            ],
            [
                'no' => 4,
                'jenis_kinerja' => 'Pelaksanaan Penunjang',
                'syarat' => 'Boleh Kosong',
                'sks_bkd' => number_format($sksPenunjang, 2),
                'sks_lebih' => '0',
                'status' => $statusPenunjang
            ],
            [
                'no' => 5,
                'jenis_kinerja' => 'Pengembangan Profesi',
                'syarat' => 'Boleh Kosong',
                'sks_bkd' => number_format($sksPengembangan, 2),
                'sks_lebih' => '0',
                'status' => $statusPengembangan
            ],
        ];

        // Criteria rows
        $criteriaRows = [
            [
                'jenis_kinerja' => 'Kriteria Pelaksanaan Pendidikan dan Penelitian',
                'syarat' => 'Minimal 3 sks',
                'sks_bkd' => number_format($sksPendidikan + $sksPenelitian, 2),
                'sks_lebih' => number_format(max(($sksPendidikan + $sksPenelitian) - $targetMinimal, 0), 2),
                'status' => ($sksPendidikan + $sksPenelitian) >= $targetMinimal ? 'M' : 'TM'
            ],
            [
                'jenis_kinerja' => 'Kriteria Pelaksanaan Pengabdian dan Penunjang',
                'syarat' => 'Boleh Kosong',
                'sks_bkd' => number_format($sksPengabdian + $sksPenunjang, 2),
                'sks_lebih' => '0',
                'status' => 'M'
            ],
        ];

        // Summary row
        $summaryRow = [
            'jenis_kinerja' => 'Total Kinerja',
            'syarat' => "Minimal {$targetMinimal} sks dan Maksimal {$targetMaksimal} sks",
            'sks_bkd' => number_format($totalSks, 2),
            'sks_lebih' => number_format($sksLebih, 2),
            'status' => $statusKeseluruhan
        ];

        // Detail Pengembangan Profesi
        $detailPengembangan = [
            'pelatihan' => [
                'jumlah' => $pelatihans->count(),
                'sks' => number_format($sksPelatihan, 2),
                'items' => $pelatihans
            ],
            'sertifikasi' => [
                'jumlah' => $sertifikasis->count(),
                'sks' => number_format($sksSertifikasi, 2),
                'items' => $sertifikasis
            ],
            'asosiasi' => [
                'jumlah' => $asosiasis->count(),
                'sks' => number_format($sksAsosiasi, 2),
                'items' => $asosiasis
            ],
            'sipp' => [
                'status' => $sksSipp > 0 ? 'Aktif' : 'Tidak Ada',
                'sks' => number_format($sksSipp, 2)
            ]
        ];

        return [
            'dosen' => $dosen,
            'period' => $period,
            'pendidikan' => [
                'sks' => $sksPendidikan,
                'detail' => $detailPendidikan,
                'status' => $statusPendidikan
            ],
            'penelitian' => [
                'sks' => $sksPenelitian,
                'detail' => $detailPenelitian,
                'status' => $statusPenelitian
            ],
            'pengabdian' => [
                'sks' => $sksPengabdian,
                'detail' => $detailPengabdian,
                'status' => $statusPengabdian
            ],
            'penunjang' => [
                'sks' => $sksPenunjang,
                'detail' => $detailPenunjang,
                'status' => $statusPenunjang
            ],
            'pengembangan' => [
                'sks' => $sksPengembangan,
                'detail' => $detailPengembangan,
                'status' => $statusPengembangan
            ],
            'kinerja_table' => $kinerjaTable,
            'criteria_rows' => $criteriaRows,
            'summary_row' => $summaryRow,
            'total_sks' => $totalSks,
            'status_keseluruhan' => $statusKeseluruhan
        ];
    }

    /**
     * Print evaluasi report
     */
    public function print(Request $request)
    {
        $request->validate([
            'dosen_id' => 'required|exists:dosens,id',
            'period_id' => 'required|exists:academic_periods,id',
        ]);

        $dosen = Dosen::find($request->dosen_id);
        $period = AcademicPeriod::find($request->period_id);
        $evaluasiData = $this->calculateEvaluasi($dosen, $period);

        return view('admin.evaluasi-kinerja.print', compact('dosen', 'period', 'evaluasiData'));
    }

    /**
     * Export to PDF
     */
    public function exportPdf(Request $request)
    {
        return redirect()->back()->with('info', 'Fitur export PDF sedang dalam pengembangan');
    }
}
