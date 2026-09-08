<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pkm;
use App\Models\Dosen;
use App\Models\AcademicPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PkmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Pkm::with(['dosen', 'academicPeriod']);

        // Filter by dosen
        if ($request->filled('dosen_id')) {
            $query->where('dosen_id', $request->dosen_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by tahun
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        // Filter by bidang
        if ($request->filled('bidang_pkm')) {
            $query->where('bidang_pkm', 'like', '%' . $request->bidang_pkm . '%');
        }

        // Search by judul
        if ($request->filled('search')) {
            $query->where('judul_pkm', 'like', '%' . $request->search . '%');
        }

        $pkms = $query->orderBy('tahun', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $dosens = Dosen::orderBy('nama')->get();
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();
        $tahunList = Pkm::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');

        return view('admin.pkm.index', compact('pkms', 'dosens', 'periods', 'tahunList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dosens = Dosen::orderBy('nama')->get();
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();
        $activePeriod = AcademicPeriod::where('is_active', true)->first();

        return view('admin.pkm.create', compact('dosens', 'periods', 'activePeriod'));
    }

    /**
     * Store a newly created resource in storage.
     */
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
            'no_sk' => 'nullable|string|max:100',
            'tanggal_sk' => 'nullable|date',
        ]);

        if ($request->hasFile('file_laporan')) {
            $validated['file_laporan'] = $request->file('file_laporan')->store('pkm-laporan', 'public');
        }

        Pkm::create($validated);

        return redirect()->route('admin.pkm.index')
            ->with('success', 'Data PKM berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pkm = Pkm::with(['dosen', 'academicPeriod'])->findOrFail($id);
        return view('admin.pkm.show', compact('pkm'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pkm = Pkm::findOrFail($id);
        $dosens = Dosen::orderBy('nama')->get();
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();

        return view('admin.pkm.edit', compact('pkm', 'dosens', 'periods'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $pkm = Pkm::findOrFail($id);

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
            'no_sk' => 'nullable|string|max:100',
            'tanggal_sk' => 'nullable|date',
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pkm = Pkm::findOrFail($id);

        if ($pkm->file_laporan) {
            Storage::disk('public')->delete($pkm->file_laporan);
        }

        $pkm->delete();

        return redirect()->route('admin.pkm.index')
            ->with('success', 'Data PKM berhasil dihapus');
    }

    /**
     * Download file laporan
     */
    public function downloadLaporan($id)
    {
        $pkm = Pkm::findOrFail($id);

        if ($pkm->file_laporan && Storage::disk('public')->exists($pkm->file_laporan)) {
            return Storage::disk('public')->download($pkm->file_laporan);
        }

        return redirect()->back()->with('error', 'File laporan tidak ditemukan');
    }

    /**
     * Export data to Excel
     */
    public function export(Request $request)
    {
        return redirect()->back()->with('info', 'Fitur export sedang dalam pengembangan');
    }
}
