<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Riset;
use App\Models\Dosen;
use App\Models\AcademicPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class RisetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Riset::with(['dosen', 'academicPeriod']);

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

        // Filter by bidang riset
        if ($request->filled('bidang_riset')) {
            $query->where('bidang_riset', 'like', '%' . $request->bidang_riset . '%');
        }

        // Search by judul
        if ($request->filled('search')) {
            $query->where('judul_riset', 'like', '%' . $request->search . '%');
        }

        $risets = $query->orderBy('tahun', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $dosens = Dosen::orderBy('nama')->get();
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();
        $tahunList = Riset::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');

        return view('admin.riset.index', compact('risets', 'dosens', 'periods', 'tahunList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dosens = Dosen::orderBy('nama')->get();
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();
        $activePeriod = AcademicPeriod::where('is_active', true)->first();

        return view('admin.riset.create', compact('dosens', 'periods', 'activePeriod'));
    }

    /**
     * Store a newly created resource in storage.
     */
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
            'no_sk' => 'nullable|string|max:100',
            'tanggal_sk' => 'nullable|date',
        ]);

        if ($request->hasFile('file_laporan')) {
            $validated['file_laporan'] = $request->file('file_laporan')->store('riset-laporan', 'public');
        }

        Riset::create($validated);

        return redirect()->route('admin.riset.index')
            ->with('success', 'Data penelitian berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $riset = Riset::with(['dosen', 'academicPeriod'])->findOrFail($id);
        return view('admin.riset.show', compact('riset'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $riset = Riset::findOrFail($id);
        $dosens = Dosen::orderBy('nama')->get();
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();

        return view('admin.riset.edit', compact('riset', 'dosens', 'periods'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $riset = Riset::findOrFail($id);

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
            'no_sk' => 'nullable|string|max:100',
            'tanggal_sk' => 'nullable|date',
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $riset = Riset::findOrFail($id);

        if ($riset->file_laporan) {
            Storage::disk('public')->delete($riset->file_laporan);
        }

        $riset->delete();

        return redirect()->route('admin.riset.index')
            ->with('success', 'Data penelitian berhasil dihapus');
    }

    /**
     * Download file laporan
     */
    public function downloadLaporan($id)
    {
        $riset = Riset::findOrFail($id);

        if ($riset->file_laporan && Storage::disk('public')->exists($riset->file_laporan)) {
            return Storage::disk('public')->download($riset->file_laporan);
        }

        return redirect()->back()->with('error', 'File laporan tidak ditemukan');
    }

    /**
     * Export data to Excel
     */
    public function export(Request $request)
    {
        // Will be implemented later
        return redirect()->back()->with('info', 'Fitur export sedang dalam pengembangan');
    }
}
