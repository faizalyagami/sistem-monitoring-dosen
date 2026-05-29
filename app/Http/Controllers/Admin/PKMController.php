<?php
// app/Http/Controllers/Admin/PkmController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PKM;
use App\Models\Dosen;
use App\Models\AcademicPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PKMController extends Controller
{
    public function index(Request $request)
    {
        $query = PKM::with(['dosen', 'academicPeriod']);

        if ($request->has('dosen_id') && $request->dosen_id) {
            $query->where('dosen_id', $request->dosen_id);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $pkms = $query->latest()->paginate(10);
        $dosens = Dosen::all();
        $periods = AcademicPeriod::orderBy('urutan', 'desc')->get();

        return view('admin.pkm.index', compact('pkms', 'dosens', 'periods'));
    }

    public function create()
    {
        $dosens = Dosen::all();
        $periods = AcademicPeriod::orderBy('urutan', 'desc')->get();

        return view('admin.pkm.create', compact('dosens', 'periods'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dosen_id' => 'required|exists:dosens,id',
            'academic_period_id' => 'required|exists:academic_periods,id',
            'judul_pkm' => 'required|max:255',
            'bidang_pkm' => 'required|max:100',
            'jenis_pkm' => 'required|max:100',
            'sumber_dana' => 'required|max:100',
            'jumlah_dana' => 'required|integer|min:0',
            'lokasi_kegiatan' => 'required|max:255',
            'status' => 'required|in:aktif,selesai',
            'tahun' => 'required|integer|min:2000|max:2100',
            'publikasi_link' => 'nullable|url',
            'file_laporan' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        if ($request->hasFile('file_laporan')) {
            $validated['file_laporan'] = $request->file('file_laporan')->store('pkm-laporan', 'public');
        }

        Pkm::create($validated);

        return redirect()->route('admin.pkm.index')
            ->with('success', 'Data PKM berhasil ditambahkan');
    }

    public function edit(Pkm $pkm)
    {
        $dosens = Dosen::all();
        $periods = AcademicPeriod::orderBy('urutan', 'desc')->get();

        return view('admin.pkm.edit', compact('pkm', 'dosens', 'periods'));
    }

    public function update(Request $request, Pkm $pkm)
    {
        $validated = $request->validate([
            'dosen_id' => 'required|exists:dosens,id',
            'academic_period_id' => 'required|exists:academic_periods,id',
            'judul_pkm' => 'required|max:255',
            'bidang_pkm' => 'required|max:100',
            'jenis_pkm' => 'required|max:100',
            'sumber_dana' => 'required|max:100',
            'jumlah_dana' => 'required|integer|min:0',
            'lokasi_kegiatan' => 'required|max:255',
            'status' => 'required|in:aktif,selesai',
            'tahun' => 'required|integer|min:2000|max:2100',
            'publikasi_link' => 'nullable|url',
            'file_laporan' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        if ($request->hasFile('file_laporan')) {
            if ($pkm->file_laporan) {
                Storage::disk('public')->delete($pkm->file_laporan);
            }
            $validated['file_laporan'] = $request->file('file_laporan')->store('pkm-laporan', 'public');
        }

        $pkm->update($validated);

        return redirect()->route('admin.pkm.index')
            ->with('success', 'Data PKM berhasil diupdate');
    }

    public function destroy(PKM $pkm)
    {
        if ($pkm->file_laporan) {
            Storage::disk('public')->delete($pkm->file_laporan);
        }

        $pkm->delete();

        return redirect()->route('admin.pkm.index')
            ->with('success', 'Data PKM berhasil dihapus');
    }
}
