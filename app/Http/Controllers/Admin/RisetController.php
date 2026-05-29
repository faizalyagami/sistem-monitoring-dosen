<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Riset;
use App\Models\Dosen;
use App\Models\AcademicPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RisetController extends Controller
{
    public function index(Request $request)
    {
        $query = Riset::with(['dosen', 'academicPeriod']);

        if ($request->has('dosen_id') && $request->dosen_id) {
            $query->where('dosen_id', $request->dosen_id);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('tahun') && $request->tahun) {
            $query->where('tahun', $request->tahun);
        }

        $risets = $query->latest()->paginate(10);
        $dosens = Dosen::all();
        $periods = AcademicPeriod::orderBy('urutan', 'desc')->get();

        return view('admin.riset.index', compact('risets', 'dosens', 'periods'));
    }

    public function create()
    {
        $dosens = Dosen::all();
        $periods = AcademicPeriod::orderBy('urutan', 'desc')->get();

        return view('admin.riset.create', compact('dosens', 'periods'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dosen_id' => 'required|exists:dosens,id',
            'academic_period_id' => 'required|exists:academic_periods,id',
            'judul_riset' => 'required|max:255',
            'bidang_riset' => 'required|max:100',
            'jenis_riset' => 'required|max:100',
            'sumber_dana' => 'required|max:100',
            'jumlah_dana' => 'required|integer|min:0',
            'status' => 'required|in:aktif,selesai',
            'tahun' => 'required|integer|min:2000|max:2100',
            'publikasi_link' => 'nullable|url',
            'kolaborator' => 'nullable|max:255',
            'file_laporan' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        if ($request->hasFile('file_laporan')) {
            $validated['file_laporan'] = $request->file('file_laporan')->store('riset-laporan', 'public');
        }

        Riset::create($validated);

        return redirect()->route('admin.riset.index')
            ->with('success', 'Data penelitian berhasil ditambahkan');
    }

    public function edit(Riset $riset)
    {
        $dosens = Dosen::all();
        $periods = AcademicPeriod::orderBy('urutan', 'desc')->get();

        return view('admin.riset.edit', compact('riset', 'dosens', 'periods'));
    }

    public function update(Request $request, Riset $riset)
    {
        $validated = $request->validate([
            'dosen_id' => 'required|exists:dosens,id',
            'academic_period_id' => 'required|exists:academic_periods,id',
            'judul_riset' => 'required|max:255',
            'bidang_riset' => 'required|max:100',
            'jenis_riset' => 'required|max:100',
            'sumber_dana' => 'required|max:100',
            'jumlah_dana' => 'required|integer|min:0',
            'status' => 'required|in:aktif,selesai',
            'tahun' => 'required|integer|min:2000|max:2100',
            'publikasi_link' => 'nullable|url',
            'kolaborator' => 'nullable|max:255',
            'file_laporan' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        if ($request->hasFile('file_laporan')) {
            if ($riset->file_laporan) {
                Storage::disk('public')->delete($riset->file_laporan);
            }
            $validated['file_laporan'] = $request->file('file_laporan')->store('riset-laporan', 'public');
        }

        $riset->update($validated);

        return redirect()->route('admin.riset.index')
            ->with('success', 'Data penelitian berhasil diupdate');
    }

    public function destroy(Riset $riset)
    {
        if ($riset->file_laporan) {
            Storage::disk('public')->delete($riset->file_laporan);
        }

        $riset->delete();

        return redirect()->route('admin.riset.index')
            ->with('success', 'Data penelitian berhasil dihapus');
    }
}
