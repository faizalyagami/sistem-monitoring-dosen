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

class DashboardController extends Controller
{
    public function index()
    {
        // Get current active period
        $currentPeriod = AcademicPeriod::where('is_active', true)->first();

        // Stats
        $stats = [
            'total_dosen' => Dosen::count(),
            'total_pengajaran' => Pengajaran::count(),
            'total_riset' => Riset::count(),
            'total_pkm' => Pkm::count(),
            'total_bimbingan' => Bimbingan::count(),
        ];

        // Teaching distribution by field
        $teachingByField = Pengajaran::select('bidang_keilmuan', DB::raw('count(*) as total'))
            ->groupBy('bidang_keilmuan')
            ->get();

        // Research grants by status
        $researchByStatus = Riset::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        // Top 5 lecturers by teaching load
        $topLecturers = Dosen::withCount('pengajarans')
            ->orderBy('pengajarans_count', 'desc')
            ->limit(5)
            ->get();

        // Recent research grants
        $recentRisets = Riset::with('dosen')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Recent PKM
        $recentPkms = Pkm::with('dosen')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Chart data for SKS distribution
        $sksDistribution = Pengajaran::select('sks', DB::raw('count(*) as total'))
            ->groupBy('sks')
            ->orderBy('sks')
            ->get();

        // Dosen status distribution
        $dosenStatus = Dosen::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'teachingByField',
            'researchByStatus',
            'topLecturers',
            'recentRisets',
            'recentPkms',
            'sksDistribution',
            'currentPeriod',
            'dosenStatus'
        ));
    }
}
