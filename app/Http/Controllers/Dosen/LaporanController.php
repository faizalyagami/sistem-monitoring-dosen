<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\AcademicPeriod;
use App\Models\Pengajaran;
use App\Models\Riset;
use App\Models\Pkm;
use App\Models\Bimbingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $dosen = Auth::user()->dosen;
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();
        $selectedPeriod = null;
        $laporanData = null;

        if ($request->filled('period_id')) {
            $selectedPeriod = AcademicPeriod::find($request->period_id);
            if ($selectedPeriod) {
                $laporanData = [
                    'pengajaran' => Pengajaran::where('dosen_id', $dosen->id)->where('academic_period_id', $selectedPeriod->id)->get(),
                    'riset' => Riset::where('dosen_id', $dosen->id)->where('academic_period_id', $selectedPeriod->id)->get(),
                    'pkm' => Pkm::where('dosen_id', $dosen->id)->where('academic_period_id', $selectedPeriod->id)->get(),
                    'bimbingan' => Bimbingan::where('dosen_id', $dosen->id)->where('academic_period_id', $selectedPeriod->id)->get(),
                ];
            }
        }
        return view('dosen.laporan.index', compact('periods', 'selectedPeriod', 'laporanData'));
    }

    public function print(Request $request)
    {
        $dosen = Auth::user()->dosen;
        $period = AcademicPeriod::findOrFail($request->period_id);

        $pengajaran = Pengajaran::where('dosen_id', $dosen->id)->where('academic_period_id', $period->id)->get();
        $riset = Riset::where('dosen_id', $dosen->id)->where('academic_period_id', $period->id)->get();
        $pkm = Pkm::where('dosen_id', $dosen->id)->where('academic_period_id', $period->id)->get();
        $bimbingan = Bimbingan::where('dosen_id', $dosen->id)->where('academic_period_id', $period->id)->get();

        return view('dosen.laporan.print', compact('dosen', 'period', 'pengajaran', 'riset', 'pkm', 'bimbingan'));
    }
}
