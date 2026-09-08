<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengajaran;
use App\Models\Dosen;
use App\Models\AcademicPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Pengajaran::with(['dosen', 'academicPeriod']);

        // Filter by dosen
        if ($request->filled('dosen_id')) {
            $query->where('dosen_id', $request->dosen_id);
        }

        // Filter by periode
        if ($request->filled('academic_period_id')) {
            $query->where('academic_period_id', $request->academic_period_id);
        }

        // Filter by semester
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        // Search by kode_mk or nama_mk
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_mk', 'like', "%{$search}%")
                    ->orWhere('nama_mk', 'like', "%{$search}%");
            });
        }

        $pengajarans = $query->orderBy('tahun_akademik', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $dosens = Dosen::orderBy('nama')->get();
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();

        return view('admin.pengajaran.index', compact('pengajarans', 'dosens', 'periods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dosens = Dosen::orderBy('nama')->get();
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();
        $activePeriod = AcademicPeriod::where('is_active', true)->first();

        return view('admin.pengajaran.create', compact('dosens', 'periods', 'activePeriod'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_mk' => 'required|unique:pengajaran|max:20',
            'nama_mk' => 'required|max:100',
            'bidang_keilmuan' => 'required|max:50',
            'kelas' => 'required|max:10',
            'sks' => 'required|integer|min:1|max:6',
            'jumlah_mahasiswa' => 'required|integer|min:1',
            'semester' => 'required|in:ganjil,genap',
            'tahun_akademik' => 'required|integer|min:2000|max:2100',
            'dosen_id' => 'required|exists:dosens,id',
            'academic_period_id' => 'required|exists:academic_periods,id',
        ]);

        Pengajaran::create($validated);

        return redirect()->route('admin.pengajaran.index')
            ->with('success', 'Data pengajaran berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pengajaran = Pengajaran::with(['dosen', 'academicPeriod'])->findOrFail($id);
        return view('admin.pengajaran.show', compact('pengajaran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pengajaran = Pengajaran::findOrFail($id);
        $dosens = Dosen::orderBy('nama')->get();
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();

        return view('admin.pengajaran.edit', compact('pengajaran', 'dosens', 'periods'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $pengajaran = Pengajaran::findOrFail($id);

        $validated = $request->validate([
            'kode_mk' => 'required|max:20|unique:pengajaran,kode_mk,' . $id,
            'nama_mk' => 'required|max:100',
            'bidang_keilmuan' => 'required|max:50',
            'kelas' => 'required|max:10',
            'sks' => 'required|integer|min:1|max:6',
            'jumlah_mahasiswa' => 'required|integer|min:1',
            'semester' => 'required|in:ganjil,genap',
            'tahun_akademik' => 'required|integer|min:2000|max:2100',
            'dosen_id' => 'required|exists:dosens,id',
            'academic_period_id' => 'required|exists:academic_periods,id',
        ]);

        $pengajaran->update($validated);

        return redirect()->route('admin.pengajaran.index')
            ->with('success', 'Data pengajaran berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pengajaran = Pengajaran::findOrFail($id);
        $pengajaran->delete();

        return redirect()->route('admin.pengajaran.index')
            ->with('success', 'Data pengajaran berhasil dihapus');
    }

    /**
     * Export data to Excel
     */
    public function export(Request $request)
    {
        // Will be implemented later
        return redirect()->back()->with('info', 'Fitur export sedang dalam pengembangan');
    }

    /**
     * Print data
     */
    public function print(Request $request)
    {
        // Will be implemented later
        return redirect()->back()->with('info', 'Fitur print sedang dalam pengembangan');
    }
}
