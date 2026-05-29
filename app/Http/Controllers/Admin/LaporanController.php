<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\AcademicPeriod;
use App\Models\Pengajaran;
use App\Models\Riset;
use App\Models\Pkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $periods = AcademicPeriod::orderBy('urutan', 'desc')->get();
        $dosens = Dosen::all();

        $selectedPeriod = null;
        $selectedDosen = null;
        $laporanData = null;

        if ($request->has('period_id') && $request->period_id) {
            $selectedPeriod = AcademicPeriod::find($request->period_id);
            $selectedDosen = $request->has('dosen_id') && $request->dosen_id ? Dosen::find($request->dosen_id) : null;

            $laporanData = $this->generateReport($selectedPeriod, $selectedDosen);
        }

        return view('admin.laporan.index', compact('periods', 'dosens', 'selectedPeriod', 'selectedDosen', 'laporanData'));
    }

    private function generateReport($period, $dosen = null)
    {
        $query = [
            'pengajaran' => Pengajaran::where('academic_period_id', $period->id),
            'riset' => Riset::where('academic_period_id', $period->id),
            'pkm' => Pkm::where('academic_period_id', $period->id),
        ];

        if ($dosen) {
            $query['pengajaran']->where('dosen_id', $dosen->id);
            $query['riset']->where('dosen_id', $dosen->id);
            $query['pkm']->where('dosen_id', $dosen->id);
        }

        $data = [
            'total_pengajaran' => $query['pengajaran']->count(),
            'total_sks' => $query['pengajaran']->sum('sks'),
            'total_mahasiswa' => $query['pengajaran']->sum('jumlah_mahasiswa'),
            'total_riset' => $query['riset']->count(),
            'total_dana_riset' => $query['riset']->sum('jumlah_dana'),
            'total_pkm' => $query['pkm']->count(),
            'total_dana_pkm' => $query['pkm']->sum('jumlah_dana'),
            'pengajaran_by_dosen' => $query['pengajaran']->select('dosen_id', DB::raw('count(*) as total'))
                ->groupBy('dosen_id')
                ->with('dosen')
                ->get(),
            'riset_by_status' => $query['riset']->select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->get(),
        ];

        return $data;
    }

    public function exportExcel(Request $request)
    {
        // This would require Laravel Excel package
        // For now, we'll redirect back with a message
        return redirect()->back()->with('info', 'Fitur export Excel sedang dalam pengembangan');
    }

    public function exportPdf(Request $request)
    {
        // This would require DomPDF package
        // For now, we'll redirect back with a message
        return redirect()->back()->with('info', 'Fitur export PDF sedang dalam pengembangan');
    }
}
