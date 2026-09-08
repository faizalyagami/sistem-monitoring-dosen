<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bimbingan;
use App\Models\Dosen;
use App\Models\AcademicPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BimbinganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Bimbingan::with(['dosen', 'academicPeriod']);

        // Filter by dosen
        if ($request->filled('dosen_id')) {
            $query->where('dosen_id', $request->dosen_id);
        }

        // Filter by jenis bimbingan
        if ($request->filled('jenis_bimbingan')) {
            $query->where('jenis_bimbingan', $request->jenis_bimbingan);
        }

        // Filter by periode
        if ($request->filled('academic_period_id')) {
            $query->where('academic_period_id', $request->academic_period_id);
        }

        // Filter by semester
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        // Filter by tahun
        if ($request->filled('tahun_akademik')) {
            $query->where('tahun_akademik', $request->tahun_akademik);
        }

        $bimbingans = $query->orderBy('tahun_akademik', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $dosens = Dosen::orderBy('nama')->get();
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();
        $tahunList = Bimbingan::select('tahun_akademik')->distinct()->orderBy('tahun_akademik', 'desc')->pluck('tahun_akademik');

        return view('admin.bimbingan.index', compact('bimbingans', 'dosens', 'periods', 'tahunList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dosens = Dosen::orderBy('nama')->get();
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();
        $activePeriod = AcademicPeriod::where('is_active', true)->first();

        return view('admin.bimbingan.create', compact('dosens', 'periods', 'activePeriod'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'dosen_id' => 'required|exists:dosens,id',
            'academic_period_id' => 'required|exists:academic_periods,id',
            'jenis_bimbingan' => 'required|in:skripsi,tesis,disertasi',
            'kategori_bimbingan' => 'nullable|max:100',
            'jumlah_mahasiswa' => 'required|integer|min:1',
            'semester' => 'required|in:ganjil,genap',
            'tahun_akademik' => 'required|integer|min:2000|max:2100',
        ]);

        Bimbingan::create($validated);

        return redirect()->route('admin.bimbingan.index')
            ->with('success', 'Data bimbingan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $bimbingan = Bimbingan::with(['dosen', 'academicPeriod'])->findOrFail($id);
        return view('admin.bimbingan.show', compact('bimbingan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $bimbingan = Bimbingan::findOrFail($id);
        $dosens = Dosen::orderBy('nama')->get();
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();

        return view('admin.bimbingan.edit', compact('bimbingan', 'dosens', 'periods'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $bimbingan = Bimbingan::findOrFail($id);

        $validated = $request->validate([
            'dosen_id' => 'required|exists:dosens,id',
            'academic_period_id' => 'required|exists:academic_periods,id',
            'jenis_bimbingan' => 'required|in:skripsi,tesis,disertasi',
            'kategori_bimbingan' => 'nullable|max:100',
            'jumlah_mahasiswa' => 'required|integer|min:1',
            'semester' => 'required|in:ganjil,genap',
            'tahun_akademik' => 'required|integer|min:2000|max:2100',
        ]);

        $bimbingan->update($validated);

        return redirect()->route('admin.bimbingan.index')
            ->with('success', 'Data bimbingan berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $bimbingan = Bimbingan::findOrFail($id);
        $bimbingan->delete();

        return redirect()->route('admin.bimbingan.index')
            ->with('success', 'Data bimbingan berhasil dihapus');
    }

    /**
     * Export data to Excel
     */
    public function export(Request $request)
    {
        return redirect()->back()->with('info', 'Fitur export sedang dalam pengembangan');
    }
}
