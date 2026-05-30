<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Pengajaran;
use App\Models\Riset;
use App\Models\Pkm;
use App\Models\Bimbingan;
use App\Models\AcademicPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    /**
     * Display the reports page.
     */
    public function index(Request $request)
    {
        // Get data for filters
        $dosens = Dosen::orderBy('nama')->get();
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();

        // Default to current active period
        $selectedPeriod = null;
        $selectedDosen = null;
        $reportData = null;

        if ($request->has('period_id') && $request->period_id) {
            $selectedPeriod = AcademicPeriod::find($request->period_id);
            $selectedDosen = $request->has('dosen_id') && $request->dosen_id ? Dosen::find($request->dosen_id) : null;

            $reportData = $this->generateReport($selectedPeriod, $selectedDosen);
        }

        return view('admin.laporan.index', compact('dosens', 'periods', 'selectedPeriod', 'selectedDosen', 'reportData'));
    }

    /**
     * Generate report data
     */
    private function generateReport($period, $dosen = null)
    {
        // Base queries
        $pengajaranQuery = Pengajaran::where('academic_period_id', $period->id);
        $risetQuery = Riset::where('academic_period_id', $period->id);
        $pkmQuery = Pkm::where('academic_period_id', $period->id);
        $bimbinganQuery = Bimbingan::where('academic_period_id', $period->id);

        if ($dosen) {
            $pengajaranQuery->where('dosen_id', $dosen->id);
            $risetQuery->where('dosen_id', $dosen->id);
            $pkmQuery->where('dosen_id', $dosen->id);
            $bimbinganQuery->where('dosen_id', $dosen->id);
        }

        // Summary statistics
        $summary = [
            'total_pengajaran' => $pengajaranQuery->count(),
            'total_sks' => $pengajaranQuery->sum('sks'),
            'total_mahasiswa' => $pengajaranQuery->sum('jumlah_mahasiswa'),
            'total_riset' => $risetQuery->count(),
            'total_dana_riset' => $risetQuery->sum('jumlah_dana'),
            'total_pkm' => $pkmQuery->count(),
            'total_dana_pkm' => $pkmQuery->sum('jumlah_dana'),
            'total_bimbingan' => $bimbinganQuery->count(),
            'total_mahasiswa_bimbingan' => $bimbinganQuery->sum('jumlah_mahasiswa'),
        ];

        // Teaching distribution by field
        $teachingByField = $pengajaranQuery->select('bidang_keilmuan', DB::raw('count(*) as total'))
            ->groupBy('bidang_keilmuan')
            ->get();

        // Research by status
        $researchByStatus = $risetQuery->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        // PKM by status
        $pkmByStatus = $pkmQuery->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        // Teaching by lecturer (for all lecturers or selected)
        $teachingByLecturer = $pengajaranQuery->select('dosen_id', DB::raw('count(*) as total_mk'), DB::raw('sum(sks) as total_sks'))
            ->groupBy('dosen_id')
            ->with('dosen')
            ->get();

        // Research by lecturer
        $researchByLecturer = $risetQuery->select('dosen_id', DB::raw('count(*) as total'))
            ->groupBy('dosen_id')
            ->with('dosen')
            ->get();

        // PKM by lecturer
        $pkmByLecturer = $pkmQuery->select('dosen_id', DB::raw('count(*) as total'))
            ->groupBy('dosen_id')
            ->with('dosen')
            ->get();

        // Bimbingan by type
        $bimbinganByType = $bimbinganQuery->select('jenis_bimbingan', DB::raw('count(*) as total'), DB::raw('sum(jumlah_mahasiswa) as total_mahasiswa'))
            ->groupBy('jenis_bimbingan')
            ->get();

        // Top performers
        $topPengajaran = Pengajaran::select('dosen_id', DB::raw('count(*) as total'))
            ->where('academic_period_id', $period->id)
            ->groupBy('dosen_id')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->with('dosen')
            ->get();

        $topRiset = Riset::select('dosen_id', DB::raw('count(*) as total'))
            ->where('academic_period_id', $period->id)
            ->groupBy('dosen_id')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->with('dosen')
            ->get();

        return [
            'summary' => $summary,
            'teaching_by_field' => $teachingByField,
            'research_by_status' => $researchByStatus,
            'pkm_by_status' => $pkmByStatus,
            'teaching_by_lecturer' => $teachingByLecturer,
            'research_by_lecturer' => $researchByLecturer,
            'pkm_by_lecturer' => $pkmByLecturer,
            'bimbingan_by_type' => $bimbinganByType,
            'top_pengajaran' => $topPengajaran,
            'top_riset' => $topRiset,
        ];
    }

    /**
     * Export report to Excel
     */
    public function exportExcel(Request $request)
    {
        // Validate request
        $request->validate([
            'period_id' => 'required|exists:academic_periods,id',
        ]);

        $period = AcademicPeriod::find($request->period_id);
        $dosen = $request->has('dosen_id') && $request->dosen_id ? Dosen::find($request->dosen_id) : null;

        $reportData = $this->generateReport($period, $dosen);

        // For now, return JSON (will be replaced with actual Excel export)
        return response()->json([
            'success' => true,
            'message' => 'Fitur export Excel sedang dalam pengembangan',
            'data' => $reportData
        ]);

        // When using Laravel Excel package:
        // return Excel::download(new ReportExport($reportData, $period, $dosen), 'laporan_kinerja.xlsx');
    }

    /**
     * Export report to PDF
     */
    public function exportPdf(Request $request)
    {
        $request->validate([
            'period_id' => 'required|exists:academic_periods,id',
        ]);

        $period = AcademicPeriod::find($request->period_id);
        $dosen = $request->has('dosen_id') && $request->dosen_id ? Dosen::find($request->dosen_id) : null;

        $reportData = $this->generateReport($period, $dosen);

        // For now, return JSON (will be replaced with actual PDF export)
        return response()->json([
            'success' => true,
            'message' => 'Fitur export PDF sedang dalam pengembangan',
            'data' => $reportData
        ]);

        // When using DomPDF package:
        // $pdf = PDF::loadView('admin.laporan.pdf', compact('reportData', 'period', 'dosen'));
        // return $pdf->download('laporan_kinerja.pdf');
    }

    /**
     * Print report
     */
    public function print(Request $request)
    {
        $request->validate([
            'period_id' => 'required|exists:academic_periods,id',
        ]);

        $period = AcademicPeriod::find($request->period_id);
        $dosen = $request->has('dosen_id') && $request->dosen_id ? Dosen::find($request->dosen_id) : null;

        $reportData = $this->generateReport($period, $dosen);

        return view('admin.laporan.print', compact('reportData', 'period', 'dosen'));
    }
}
