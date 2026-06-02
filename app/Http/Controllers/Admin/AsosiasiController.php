<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asosiasi;
use App\Models\Dosen;
use App\Models\AcademicPeriod;
use Illuminate\Http\Request;

class AsosiasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Asosiasi::with(['dosen', 'academicPeriod']);

        if ($request->filled('dosen_id')) {
            $query->where('dosen_id', $request->dosen_id);
        }

        $asosiasis = $query->latest()->paginate(10);
        $dosens = Dosen::all();
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();

        return view('admin.asosiasi.index', compact('asosiasis', 'dosens', 'periods'));
    }

    public function create()
    {
        $dosens = Dosen::all();
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();
        return view('admin.asosiasi.create', compact('dosens', 'periods'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dosen_id' => 'required|exists:dosens,id',
            'academic_period_id' => 'required|exists:academic_periods,id',
            'nama_asosiasi' => 'required|max:100',
            'peran' => 'required|max:100',
            'masa_aktif' => 'required|date',
            'tahun' => 'required|integer|min:2000|max:2100',
        ]);

        Asosiasi::create($validated);

        return redirect()->route('admin.asosiasi.index')
            ->with('success', 'Data asosiasi berhasil ditambahkan');
    }

    public function edit($id)
    {
        $asosiasi = Asosiasi::findOrFail($id);
        $dosens = Dosen::all();
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();
        return view('admin.asosiasi.edit', compact('asosiasi', 'dosens', 'periods'));
    }

    public function update(Request $request, $id)
    {
        $asosiasi = Asosiasi::findOrFail($id);

        $validated = $request->validate([
            'dosen_id' => 'required|exists:dosens,id',
            'academic_period_id' => 'required|exists:academic_periods,id',
            'nama_asosiasi' => 'required|max:100',
            'peran' => 'required|max:100',
            'masa_aktif' => 'required|date',
            'tahun' => 'required|integer|min:2000|max:2100',
        ]);

        $asosiasi->update($validated);

        return redirect()->route('admin.asosiasi.index')
            ->with('success', 'Data asosiasi berhasil diupdate');
    }

    public function destroy($id)
    {
        $asosiasi = Asosiasi::findOrFail($id);
        $asosiasi->delete();

        return redirect()->route('admin.asosiasi.index')
            ->with('success', 'Data asosiasi berhasil dihapus');
    }
}
