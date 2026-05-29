<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bimbingan;
use App\Models\Dosen;
use App\Models\AcademicPeriod;
use Illuminate\Http\Request;

class BimbinganController extends Controller
{
    public function index(Request $request)
    {
        $query = Bimbingan::with(['dosen', 'academicPeriod']);

        if ($request->has('dosen_id') && $request->dosen_id) {
            $query->where('dosen_id', $request->dosen_id);
        }

        if ($request->has('jenis_bimbingan') && $request->jenis_bimbingan) {
            $query->where('jenis_bimbingan', $request->jenis_bimbingan);
        }

        $bimbingans = $query->latest()->paginate(10);
        $dosens = Dosen::all();
        $periods = AcademicPeriod::orderBy('urutan', 'desc')->get();

        return view('admin.bimbingan.index', compact('bimbingans', 'dosens', 'periods'));
    }

    public function create()
    {
        $dosens = Dosen::all();
        $periods = AcademicPeriod::orderBy('urutan', 'desc')->get();

        return view('admin.bimbingan.create', compact('dosens', 'periods'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dosen_id' => 'required|exists:dosens,id',
            'academic_period_id' => 'required|exists:academic_periods,id',
            'jenis_bimbingan' => 'required|in:skripsi,tesis,disertasi',
            'kategori_bimbingan' => 'nullable|max:100',
            'jumlah_mahasiswa' => 'required|integer|min:0',
            'semester' => 'required|in:ganjil,genap',
            'tahun_akademik' => 'required|integer|min:2000|max:2100',
        ]);

        Bimbingan::create($validated);

        return redirect()->route('admin.bimbingan.index')
            ->with('success', 'Data bimbingan berhasil ditambahkan');
    }

    public function edit(Bimbingan $bimbingan)
    {
        $dosens = Dosen::all();
        $periods = AcademicPeriod::orderBy('urutan', 'desc')->get();

        return view('admin.bimbingan.edit', compact('bimbingan', 'dosens', 'periods'));
    }

    public function update(Request $request, Bimbingan $bimbingan)
    {
        $validated = $request->validate([
            'dosen_id' => 'required|exists:dosens,id',
            'academic_period_id' => 'required|exists:academic_periods,id',
            'jenis_bimbingan' => 'required|in:skripsi,tesis,disertasi',
            'kategori_bimbingan' => 'nullable|max:100',
            'jumlah_mahasiswa' => 'required|integer|min:0',
            'semester' => 'required|in:ganjil,genap',
            'tahun_akademik' => 'required|integer|min:2000|max:2100',
        ]);

        $bimbingan->update($validated);

        return redirect()->route('admin.bimbingan.index')
            ->with('success', 'Data bimbingan berhasil diupdate');
    }

    public function destroy(Bimbingan $bimbingan)
    {
        $bimbingan->delete();

        return redirect()->route('admin.bimbingan.index')
            ->with('success', 'Data bimbingan berhasil dihapus');
    }
}
