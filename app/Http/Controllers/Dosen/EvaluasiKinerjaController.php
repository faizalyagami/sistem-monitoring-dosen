<?php

namespace App\Http\Controllers\Dosen;

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
use Illuminate\Support\Facades\Auth;

class EvaluasiKinerjaController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        if (!$dosen) {
            return redirect()->route('dosen.dashboard')
                ->with('error', 'Data dosen tidak ditemukan');
        }

        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();

        $selectedPeriod = null;
        $evaluasiData = null;

        if ($request->has('period_id') && $request->period_id) {
            $selectedPeriod = AcademicPeriod::find($request->period_id);

            if ($selectedPeriod) {
                $evaluasiData = $this->calculateEvaluasi($dosen, $selectedPeriod);
            }
        }

        return view('dosen.evaluasi-kinerja.index', compact('dosen', 'periods', 'selectedPeriod', 'evaluasiData'));
    }

    private function calculateEvaluasi($dosen, $period)
    {
        // Get data
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
        // Pelatihan
        $pelatihans = Pelatihan::where('dosen_id', $dosen->id)
            ->where('academic_period_id', $period->id)
            ->get();

        $sksPelatihan = 0;
        foreach ($pelatihans as $pelatihan) {
            $sks = $pelatihan->durasi ? $pelatihan->durasi / 8 : 1;
            $sksPelatihan += $sks;
        }

        // Sertifikasi
        $sertifikasis = Sertifikasi::where('dosen_id', $dosen->id)
            ->where('academic_period_id', $period->id)
            ->get();
        $sksSertifikasi = $sertifikasis->count() * 1;

        // Asosiasi
        $asosiasis = Asosiasi::where('dosen_id', $dosen->id)
            ->where('academic_period_id', $period->id)
            ->get();
        $sksAsosiasi = $asosiasis->count() * 0.5;

        // SIPP
        $sipps = Sipp::where('dosen_id', $dosen->id)->get();
        $sksSipp = 0;
        foreach ($sipps as $sipp) {
            if ($sipp->status == 'aktif') {
                $sksSipp = 2;
            }
        }

        $sksPengembangan = $sksPelatihan + $sksSertifikasi + $sksAsosiasi + $sksSipp;

        // Calculate SKS
        $sksPendidikan = $pengajarans->sum('sks');
        foreach ($bimbingans as $bimbingan) {
            $sksPendidikan += $bimbingan->jumlah_mahasiswa * 0.5;
        }

        $sksPenelitian = 0;
        foreach ($risets as $riset) {
            $sks = 3;
            if ($riset->jumlah_dana > 50000000) $sks = 6;
            elseif ($riset->jumlah_dana > 25000000) $sks = 4;
            $sksPenelitian += $sks;
        }

        $sksPengabdian = 0;
        foreach ($pkms as $pkm) {
            $sks = 2;
            if ($pkm->jumlah_dana > 25000000) $sks = 4;
            elseif ($pkm->jumlah_dana > 10000000) $sks = 3;
            $sksPengabdian += $sks;
        }

        $sksPenunjang = 0.75;
        $targetMinimal = 3;
        $totalSks = $sksPendidikan + $sksPenelitian + $sksPengabdian + $sksPenunjang + $sksPengembangan;

        $kinerjaTable = [
            [
                'no' => 1,
                'jenis_kinerja' => 'Pelaksanaan Pendidikan',
                'syarat' => 'Minimal 3 sks',
                'sks_bkd' => number_format($sksPendidikan, 2),
                'sks_lebih' => number_format(max($sksPendidikan - $targetMinimal, 0), 2),
                'status' => $sksPendidikan >= $targetMinimal ? 'M' : 'TM'
            ],
            [
                'no' => 2,
                'jenis_kinerja' => 'Pelaksanaan Penelitian',
                'syarat' => 'Boleh Kosong',
                'sks_bkd' => number_format($sksPenelitian, 2),
                'sks_lebih' => '0',
                'status' => 'M'
            ],
            [
                'no' => 3,
                'jenis_kinerja' => 'Pelaksanaan Pengabdian',
                'syarat' => 'Boleh Kosong',
                'sks_bkd' => number_format($sksPengabdian, 2),
                'sks_lebih' => '0',
                'status' => 'M'
            ],
            [
                'no' => 4,
                'jenis_kinerja' => 'Pelaksanaan Penunjang',
                'syarat' => 'Boleh Kosong',
                'sks_bkd' => number_format($sksPenunjang, 2),
                'sks_lebih' => '0',
                'status' => 'M'
            ],
            [
                'no' => 5,
                'jenis_kinerja' => 'Pengembangan Profesi',
                'syarat' => 'Boleh Kosong',
                'sks_bkd' => number_format($sksPengembangan, 2),
                'sks_lebih' => '0',
                'status' => 'M'
            ],
        ];

        $summaryRow = [
            'jenis_kinerja' => 'Total Kinerja',
            'syarat' => "Minimal {$targetMinimal} sks",
            'sks_bkd' => number_format($totalSks, 2),
            'sks_lebih' => number_format(max($totalSks - $targetMinimal, 0), 2),
            'status' => $totalSks >= $targetMinimal ? 'M' : 'TM'
        ];

        $detailPengembangan = [
            'pelatihan' => ['jumlah' => $pelatihans->count(), 'sks' => number_format($sksPelatihan, 2)],
            'sertifikasi' => ['jumlah' => $sertifikasis->count(), 'sks' => number_format($sksSertifikasi, 2)],
            'asosiasi' => ['jumlah' => $asosiasis->count(), 'sks' => number_format($sksAsosiasi, 2)],
            'sipp' => ['status' => $sksSipp > 0 ? 'Aktif' : 'Tidak Ada', 'sks' => number_format($sksSipp, 2)]
        ];

        return [
            'pendidikan' => ['sks' => $sksPendidikan],
            'penelitian' => ['sks' => $sksPenelitian],
            'pengabdian' => ['sks' => $sksPengabdian],
            'penunjang' => ['sks' => $sksPenunjang],
            'pengembangan' => ['sks' => $sksPengembangan, 'detail' => $detailPengembangan],
            'kinerja_table' => $kinerjaTable,
            'summary_row' => $summaryRow,
            'total_sks' => $totalSks,
            'status_keseluruhan' => $totalSks >= $targetMinimal ? 'M' : 'TM'
        ];
    }

    public function print(Request $request)
    {
        $user = Auth::user();
        $dosen = $user->dosen;
        $period = AcademicPeriod::find($request->period_id);
        $evaluasiData = $this->calculateEvaluasi($dosen, $period);

        return view('dosen.evaluasi-kinerja.print', compact('dosen', 'period', 'evaluasiData'));
    }
}
