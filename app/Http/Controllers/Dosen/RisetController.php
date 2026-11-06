<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Riset;
use App\Models\AcademicPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RisetController extends Controller
{
    public function index()
    {
        $risets = Riset::where('dosen_id', Auth::user()->dosen->id)->latest()->paginate(10);
        return view('dosen.riset.index', compact('risets'));
    }

    public function create()
    {
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();
        return view('dosen.riset.create', compact('periods'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul_riset' => 'required',
            'bidang_riset' => 'required',
            'jenis_riset' => 'required',
            'sumber_dana' => 'required',
            'jumlah_dana' => 'required|numeric',
            'status' => 'required',
            'tahun' => 'required',
            'academic_period_id' => 'required|exists:academic_periods,id',
            'file_laporan' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $validated['dosen_id'] = Auth::user()->dosen->id;
        if ($request->hasFile('file_laporan')) {
            $validated['file_laporan'] = $request->file('file_laporan')->store('riset-laporan', 'public');
        }
        Riset::create($validated);
        return redirect()->route('dosen.riset.index')->with('success', 'Data penelitian ditambahkan');
    }

    public function show($id)
    {
        $riset = Riset::where('id', $id)->where('dosen_id', Auth::user()->dosen->id)->firstOrFail();
        return view('dosen.riset.show', compact('riset'));
    }

    public function edit($id)
    {
        $riset = Riset::where('id', $id)->where('dosen_id', Auth::user()->dosen->id)->firstOrFail();
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();
        return view('dosen.riset.edit', compact('riset', 'periods'));
    }

    public function update(Request $request, $id)
    {
        $riset = Riset::where('id', $id)->where('dosen_id', Auth::user()->dosen->id)->firstOrFail();
        $validated = $request->validate([
            'judul_riset' => 'required',
            'bidang_riset' => 'required',
            'jenis_riset' => 'required',
            'sumber_dana' => 'required',
            'jumlah_dana' => 'required|numeric',
            'status' => 'required',
            'tahun' => 'required',
            'academic_period_id' => 'required|exists:academic_periods,id',
        ]);
        if ($request->hasFile('file_laporan')) {
            if ($riset->file_laporan) Storage::disk('public')->delete($riset->file_laporan);
            $validated['file_laporan'] = $request->file('file_laporan')->store('riset-laporan', 'public');
        }
        $riset->update($validated);
        return redirect()->route('dosen.riset.index')->with('success', 'Data penelitian diupdate');
    }

    public function destroy($id)
    {
        $riset = Riset::where('id', $id)->where('dosen_id', Auth::user()->dosen->id)->firstOrFail();
        if ($riset->file_laporan) Storage::disk('public')->delete($riset->file_laporan);
        $riset->delete();
        return redirect()->route('dosen.riset.index')->with('success', 'Data penelitian dihapus');
    }

    public function downloadLaporan($id)
    {
        $riset = Riset::where('id', $id)->where('dosen_id', Auth::user()->dosen->id)->firstOrFail();
        if ($riset->file_laporan && Storage::disk('public')->exists($riset->file_laporan)) {
            return Storage::disk('public')->download($riset->file_laporan);
        }
        return redirect()->back()->with('error', 'File tidak ditemukan');
    }
}
