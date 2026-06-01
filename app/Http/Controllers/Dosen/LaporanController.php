<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Pengajaran;
use App\Models\Riset;
use App\Models\Pkm;
use App\Models\Bimbingan;
use App\Models\AcademicPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
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
        $laporanData = null;

        if ($request->has('period_id') && $request->period_id) {
            $selectedPeriod = AcademicPeriod::find($request->period_id);

            if ($selectedPeriod) {
                $laporanData = $this->generateLaporan($dosen, $selectedPeriod);
            }
        }

        return view('dosen.laporan.index', compact('dosen', 'periods', 'selectedPeriod', 'laporanData'));
    }

    private function generateLaporan($dosen, $period)
    {
        // Data Pengajaran
        $pengajarans = Pengajaran::where('dosen_id', $dosen->id)
            ->where('academic_period_id', $period->id)
            ->get();

        // Data Penelitian
        $risets = Riset::where('dosen_id', $dosen->id)
            ->where('academic_period_id', $period->id)
            ->get();

        // Data PKM
        $pkms = Pkm::where('dosen_id', $dosen->id)
            ->where('academic_period_id', $period->id)
            ->get();

        // Data Bimbingan
        $bimbingans = Bimbingan::where('dosen_id', $dosen->id)
            ->where('academic_period_id', $period->id)
            ->get();

        // Hitung SKS
        $sksPendidikan = $pengajarans->sum('sks');
        $sksBimbingan = $bimbingans->sum('jumlah_mahasiswa') * 0.5;
        $totalSksPendidikan = $sksPendidikan + $sksBimbingan;

        $totalSksPenelitian = 0;
        foreach ($risets as $riset) {
            $sks = 3;
            if ($riset->jumlah_dana > 50000000) $sks = 6;
            elseif ($riset->jumlah_dana > 25000000) $sks = 4;
            $totalSksPenelitian += $sks;
        }

        $totalSksPkm = 0;
        foreach ($pkms as $pkm) {
            $sks = 2;
            if ($pkm->jumlah_dana > 25000000) $sks = 4;
            elseif ($pkm->jumlah_dana > 10000000) $sks = 3;
            $totalSksPkm += $sks;
        }

        $totalSksPenunjang = 0.75;
        $totalSks = $totalSksPendidikan + $totalSksPenelitian + $totalSksPkm + $totalSksPenunjang;

        $targetMinimal = 3;
        $status = $totalSks >= $targetMinimal ? 'Memenuhi' : 'Tidak Memenuhi';

        return [
            'pengajarans' => $pengajarans,
            'risets' => $risets,
            'pkms' => $pkms,
            'bimbingans' => $bimbingans,
            'total_sks_pendidikan' => $totalSksPendidikan,
            'total_sks_penelitian' => $totalSksPenelitian,
            'total_sks_pkm' => $totalSksPkm,
            'total_sks_penunjang' => $totalSksPenunjang,
            'total_sks' => $totalSks,
            'status' => $status,
        ];
    }

    public function print(Request $request)
    {
        $user = Auth::user();
        $dosen = $user->dosen;
        $period = AcademicPeriod::find($request->period_id);
        $laporanData = $this->generateLaporan($dosen, $period);

        return view('dosen.laporan.print', compact('dosen', 'period', 'laporanData'));
    }
}
