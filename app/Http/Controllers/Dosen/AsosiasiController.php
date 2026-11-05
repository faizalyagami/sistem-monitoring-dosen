<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Asosiasi;
use App\Models\AcademicPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsosiasiController extends Controller
{
    public function index()
    {
        $asosiasis = Asosiasi::where('dosen_id', Auth::user()->dosen_id)
            ->with('academicPeriod')->latest()->paginate(10);
        return view('dosen.asosiasi.index', compact('asosiasis'));
    }

    public function create()
    {
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();
        return view('dosen.asosiasi.create', compact('periods'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'academic_period_id' => 'required|exists:academic_periods,id',
            'nama_asosiasi' => 'required|max:100',
            'peran' => 'required|max:100',
            'masa_aktif' => 'required|date',
            'tahun' => 'required|integer',
        ]);
        $validated['dosen_id'] = Auth::user()->dosen_id;
        Asosiasi::create($validated);
        return redirect()->route('dosen.asosiasi.index')->with('success', 'Data asosiasi ditambahkan');
    }

    public function show($id)
    {
        $asosiasi = Asosiasi::where('id', $id)->where('dosen_id', Auth::user()->dosen_id)->firstOrFail();
        return view('dosen.asosiasi.show', compact('asosiasi'));
    }

    public function edit($id)
    {
        $asosiasi = Asosiasi::where('id', $id)->where('dosen_id', Auth::user()->dosen_id)->firstOrFail();
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();
        return view('dosen.asosiasi.edit', compact('asosiasi', 'periods'));
    }

    public function update(Request $request, $id)
    {
        $asosiasi = Asosiasi::where('id', $id)->where('dosen_id', Auth::user()->dosen_id)->firstOrFail();
        $validated = $request->validate([
            'academic_period_id' => 'required|exists:academic_periods,id',
            'nama_asosiasi' => 'required|max:100',
            'peran' => 'required|max:100',
            'masa_aktif' => 'required|date',
            'tahun' => 'required|integer',
        ]);
        $asosiasi->update($validated);
        return redirect()->route('dosen.asosiasi.index')->with('success', 'Data asosiasi diupdate');
    }

    public function destroy($id)
    {
        Asosiasi::where('id', $id)->where('dosen_id', Auth::user()->dosen_id)->firstOrFail()->delete();
        return redirect()->route('dosen.asosiasi.index')->with('success', 'Data asosiasi dihapus');
    }
}
