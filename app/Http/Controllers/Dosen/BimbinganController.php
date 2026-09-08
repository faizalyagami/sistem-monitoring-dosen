<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Bimbingan;
use App\Models\AcademicPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BimbinganController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $query = Bimbingan::where('dosen_id', $dosen->id)->with('academicPeriod');

        if ($request->filled('jenis_bimbingan')) {
            $query->where('jenis_bimbingan', $request->jenis_bimbingan);
        }

        if ($request->filled('academic_period_id')) {
            $query->where('academic_period_id', $request->academic_period_id);
        }

        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        $bimbingans = $query->orderBy('tahun_akademik', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();

        $allBimbingans = Bimbingan::where('dosen_id', $dosen->id)->get();

        return view('dosen.bimbingan.index', compact('bimbingans', 'periods', 'allBimbingans'));
    }

    public function create()
    {
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();
        $activePeriod = AcademicPeriod::where('is_active', true)->first();

        return view('dosen.bimbingan.create', compact('periods', 'activePeriod'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $validated = $request->validate([
            'academic_period_id' => 'required|exists:academic_periods,id',
            'jenis_bimbingan' => 'required|in:skripsi,tesis,disertasi',
            'kategori_bimbingan' => 'nullable|max:100',
            'jumlah_mahasiswa' => 'required|integer|min:1',
            'semester' => 'required|in:ganjil,genap',
            'tahun_akademik' => 'required|integer|min:2000|max:2100',
        ]);

        $validated['dosen_id'] = $dosen->id;

        Bimbingan::create($validated);

        return redirect()->route('dosen.bimbingan.index')
            ->with('success', 'Data bimbingan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $bimbingan = Bimbingan::where('id', $id)
            ->where('dosen_id', $dosen->id)
            ->firstOrFail();

        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();

        return view('dosen.bimbingan.edit', compact('bimbingan', 'periods'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $bimbingan = Bimbingan::where('id', $id)
            ->where('dosen_id', $dosen->id)
            ->firstOrFail();

        $validated = $request->validate([
            'academic_period_id' => 'required|exists:academic_periods,id',
            'jenis_bimbingan' => 'required|in:skripsi,tesis,disertasi',
            'kategori_bimbingan' => 'nullable|max:100',
            'jumlah_mahasiswa' => 'required|integer|min:1',
            'semester' => 'required|in:ganjil,genap',
            'tahun_akademik' => 'required|integer|min:2000|max:2100',
        ]);

        $bimbingan->update($validated);

        return redirect()->route('dosen.bimbingan.index')
            ->with('success', 'Data bimbingan berhasil diupdate');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $bimbingan = Bimbingan::where('id', $id)
            ->where('dosen_id', $dosen->id)
            ->firstOrFail();

        $bimbingan->delete();

        return redirect()->route('dosen.bimbingan.index')
            ->with('success', 'Data bimbingan berhasil dihapus');
    }

    public function show($id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $bimbingan = Bimbingan::where('id', $id)
            ->where('dosen_id', $dosen->id)
            ->firstOrFail();

        return view('dosen.bimbingan.show', compact('bimbingan'));
    }
}
