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

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        if (!$dosen) {
            return redirect()->route('dosen.profile')
                ->with('error', 'Data dosen tidak ditemukan. Silakan hubungi admin.');
        }

        $currentPeriod = AcademicPeriod::where('is_active', true)->first();

        // Stats untuk periode aktif
        $stats = [
            'total_pengajaran' => Pengajaran::where('dosen_id', $dosen->id)->count(),
            'total_sks' => Pengajaran::where('dosen_id', $dosen->id)->sum('sks'),
            'total_riset' => Riset::where('dosen_id', $dosen->id)->count(),
            'total_pkm' => Pkm::where('dosen_id', $dosen->id)->count(),
            'total_bimbingan' => Bimbingan::where('dosen_id', $dosen->id)->count(),
        ];

        // Data periode aktif
        if ($currentPeriod) {
            $stats['pengajaran_aktif'] = Pengajaran::where('dosen_id', $dosen->id)
                ->where('academic_period_id', $currentPeriod->id)
                ->count();
            $stats['riset_aktif'] = Riset::where('dosen_id', $dosen->id)
                ->where('academic_period_id', $currentPeriod->id)
                ->count();
            $stats['pkm_aktif'] = Pkm::where('dosen_id', $dosen->id)
                ->where('academic_period_id', $currentPeriod->id)
                ->count();
        }

        // Recent data
        $recentPengajaran = Pengajaran::where('dosen_id', $dosen->id)
            ->with('academicPeriod')
            ->latest()
            ->limit(5)
            ->get();

        $recentRiset = Riset::where('dosen_id', $dosen->id)
            ->latest()
            ->limit(5)
            ->get();

        return view('dosen.dashboard', compact('dosen', 'stats', 'currentPeriod', 'recentPengajaran', 'recentRiset'));
    }
}
