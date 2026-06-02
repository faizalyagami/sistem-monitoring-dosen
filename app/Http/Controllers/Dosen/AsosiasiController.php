<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Asosiasi;
use App\Models\AcademicPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsosiasiController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $query = Asosiasi::where('dosen_id', $dosen->id)->with('academicPeriod');

        $asosiasis = $query->latest()->paginate(10);
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();

        return view('dosen.asosiasi.index', compact('asosiasis', 'periods'));
    }

    public function create()
    {
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();
        return view('dosen.asosiasi.create', compact('periods'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $validated = $request->validate([
            'academic_period_id' => 'required|exists:academic_periods,id',
            'nama_asosiasi' => 'required|max:100',
            'peran' => 'required|max:100',
            'masa_aktif' => 'required|date',
            'tahun' => 'required|integer|min:2000|max:2100',
        ]);

        $validated['dosen_id'] = $dosen->id;

        Asosiasi::create($validated);

        return redirect()->route('dosen.asosiasi.index')
            ->with('success', 'Data asosiasi berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $asosiasi = Asosiasi::where('id', $id)
            ->where('dosen_id', $dosen->id)
            ->firstOrFail();

        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();

        return view('dosen.asosiasi.edit', compact('asosiasi', 'periods'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $asosiasi = Asosiasi::where('id', $id)
            ->where('dosen_id', $dosen->id)
            ->firstOrFail();

        $validated = $request->validate([
            'academic_period_id' => 'required|exists:academic_periods,id',
            'nama_asosiasi' => 'required|max:100',
            'peran' => 'required|max:100',
            'masa_aktif' => 'required|date',
            'tahun' => 'required|integer|min:2000|max:2100',
        ]);

        $asosiasi->update($validated);

        return redirect()->route('dosen.asosiasi.index')
            ->with('success', 'Data asosiasi berhasil diupdate');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $asosiasi = Asosiasi::where('id', $id)
            ->where('dosen_id', $dosen->id)
            ->firstOrFail();

        $asosiasi->delete();

        return redirect()->route('dosen.asosiasi.index')
            ->with('success', 'Data asosiasi berhasil dihapus');
    }
}
