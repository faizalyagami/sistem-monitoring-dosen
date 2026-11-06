<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Pengajaran;
use App\Models\Riset;
use App\Models\Pkm;
use App\Models\Bimbingan;
use App\Models\AcademicPeriod;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $dosen = Auth::user()->dosen;

        if (!$dosen) {
            return redirect()->route('login')->with('error', 'Data dosen tidak ditemukan.');
        }

        $currentPeriod = AcademicPeriod::where('is_active', true)->first();

        $stats = [
            'total_pengajaran' => Pengajaran::where('dosen_id', $dosen->id)->count(),
            'total_sks' => Pengajaran::where('dosen_id', $dosen->id)->sum('sks'),
            'total_riset' => Riset::where('dosen_id', $dosen->id)->count(),
            'total_pkm' => Pkm::where('dosen_id', $dosen->id)->count(),
            'total_bimbingan' => Bimbingan::where('dosen_id', $dosen->id)->count(),
        ];

        $recentPengajaran = Pengajaran::where('dosen_id', $dosen->id)->with('academicPeriod')->latest()->limit(5)->get();
        $recentRiset = Riset::where('dosen_id', $dosen->id)->latest()->limit(5)->get();

        return view('dosen.dashboard', compact('dosen', 'stats', 'currentPeriod', 'recentPengajaran', 'recentRiset'));
    }
}
