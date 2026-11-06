<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Pkm;
use App\Models\AcademicPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PkmController extends Controller
{
    public function index()
    {
        $pkms = Pkm::where('dosen_id', Auth::user()->dosen->id)->latest()->paginate(10);
        return view('dosen.pkm.index', compact('pkms'));
    }

    public function create()
    {
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();
        return view('dosen.pkm.create', compact('periods'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul_pkm' => 'required',
            'bidang_pkm' => 'required',
            'jenis_pkm' => 'required',
            'sumber_dana' => 'required',
            'jumlah_dana' => 'required|numeric',
            'lokasi_kegiatan' => 'required',
            'status' => 'required',
            'tahun' => 'required',
            'academic_period_id' => 'required|exists:academic_periods,id',
            'file_laporan' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);
        $validated['dosen_id'] = Auth::user()->dosen->id;
        if ($request->hasFile('file_laporan')) {
            $validated['file_laporan'] = $request->file('file_laporan')->store('pkm-laporan', 'public');
        }
        Pkm::create($validated);
        return redirect()->route('dosen.pkm.index')->with('success', 'Data PKM ditambahkan');
    }

    public function show($id)
    {
        $pkm = Pkm::where('id', $id)->where('dosen_id', Auth::user()->dosen->id)->firstOrFail();
        return view('dosen.pkm.show', compact('pkm'));
    }

    public function edit($id)
    {
        $pkm = Pkm::where('id', $id)->where('dosen_id', Auth::user()->dosen->id)->firstOrFail();
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();
        return view('dosen.pkm.edit', compact('pkm', 'periods'));
    }

    public function update(Request $request, $id)
    {
        $pkm = Pkm::where('id', $id)->where('dosen_id', Auth::user()->dosen->id)->firstOrFail();
        $validated = $request->validate([
            'judul_pkm' => 'required',
            'bidang_pkm' => 'required',
            'jenis_pkm' => 'required',
            'sumber_dana' => 'required',
            'jumlah_dana' => 'required|numeric',
            'lokasi_kegiatan' => 'required',
            'status' => 'required',
            'tahun' => 'required',
            'academic_period_id' => 'required|exists:academic_periods,id',
        ]);
        if ($request->hasFile('file_laporan')) {
            if ($pkm->file_laporan) Storage::disk('public')->delete($pkm->file_laporan);
            $validated['file_laporan'] = $request->file('file_laporan')->store('pkm-laporan', 'public');
        }
        $pkm->update($validated);
        return redirect()->route('dosen.pkm.index')->with('success', 'Data PKM diupdate');
    }

    public function destroy($id)
    {
        $pkm = Pkm::where('id', $id)->where('dosen_id', Auth::user()->dosen->id)->firstOrFail();
        if ($pkm->file_laporan) Storage::disk('public')->delete($pkm->file_laporan);
        $pkm->delete();
        return redirect()->route('dosen.pkm.index')->with('success', 'Data PKM dihapus');
    }

    public function downloadLaporan($id)
    {
        $pkm = Pkm::where('id', $id)->where('dosen_id', Auth::user()->dosen->id)->firstOrFail();
        if ($pkm->file_laporan && Storage::disk('public')->exists($pkm->file_laporan)) {
            return Storage::disk('public')->download($pkm->file_laporan);
        }
        return redirect()->back()->with('error', 'File tidak ditemukan');
    }
}
