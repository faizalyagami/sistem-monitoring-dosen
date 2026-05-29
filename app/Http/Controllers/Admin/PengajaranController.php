<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengajaran;
use App\Models\Dosen;
use App\Models\AcademicPeriod;
use Illuminate\Http\Request;

class PengajaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengajaran::with(['dosen', 'academicPeriod']);

        if ($request->has('dosen_id') && $request->dosen_id) {
            $query->where('dosen_id', $request->dosen_id);
        }

        if ($request->has('academic_period_id') && $request->academic_period_id) {
            $query->where('academic_period_id', $request->academic_period_id);
        }

        if ($request->has('semester') && $request->semester) {
            $query->where('semester', $request->semester);
        }

        $pengajarans = $query->latest()->paginate(10);
        $dosens = Dosen::all();
        $periods = AcademicPeriod::orderBy('urutan', 'desc')->get();

        return view('admin.pengajaran.index', compact('pengajarans', 'dosens', 'periods'));
    }

    public function create()
    {
        $dosens = Dosen::all();
        $periods = AcademicPeriod::orderBy('urutan', 'desc')->get();

        return view('admin.pengajaran.create', compact('dosens', 'periods'));
    }

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

    public function edit(Pengajaran $pengajaran)
    {
        $dosens = Dosen::all();
        $periods = AcademicPeriod::orderBy('urutan', 'desc')->get();

        return view('admin.pengajaran.edit', compact('pengajaran', 'dosens', 'periods'));
    }

    public function update(Request $request, Pengajaran $pengajaran)
    {
        $validated = $request->validate([
            'kode_mk' => 'required|max:20|unique:pengajaran,kode_mk,' . $pengajaran->id,
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

    public function destroy(Pengajaran $pengajaran)
    {
        $pengajaran->delete();

        return redirect()->route('admin.pengajaran.index')
            ->with('success', 'Data pengajaran berhasil dihapus');
    }
}
