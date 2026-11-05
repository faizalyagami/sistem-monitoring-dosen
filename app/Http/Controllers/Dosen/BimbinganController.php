<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Bimbingan;
use App\Models\AcademicPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BimbinganController extends Controller
{
    public function index()
    {
        $bimbingans = Bimbingan::where('dosen_id', Auth::user()->dosen->id)->latest()->paginate(10);
        return view('dosen.bimbingan.index', compact('bimbingans'));
    }

    public function create()
    {
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();
        return view('dosen.bimbingan.create', compact('periods'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_bimbingan' => 'required|in:skripsi,tesis,disertasi',
            'kategori_bimbingan' => 'nullable|string',
            'jumlah_mahasiswa' => 'required|integer|min:1',
            'semester' => 'required|in:ganjil,genap',
            'tahun_akademik' => 'required|integer',
            'academic_period_id' => 'required|exists:academic_periods,id',
            'no_sk_pembimbing' => 'nullable|string',
            'tanggal_sk_pembimbing' => 'nullable|date',
            'no_sk_penguji' => 'nullable|string',
            'tanggal_sk_penguji' => 'nullable|date',
        ]);
        $validated['dosen_id'] = Auth::user()->dosen->id;
        Bimbingan::create($validated);
        return redirect()->route('dosen.bimbingan.index')->with('success', 'Data bimbingan ditambahkan');
    }

    public function show($id)
    {
        $bimbingan = Bimbingan::where('id', $id)->where('dosen_id', Auth::user()->dosen->id)->firstOrFail();
        return view('dosen.bimbingan.show', compact('bimbingan'));
    }

    public function edit($id)
    {
        $bimbingan = Bimbingan::where('id', $id)->where('dosen_id', Auth::user()->dosen->id)->firstOrFail();
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();
        return view('dosen.bimbingan.edit', compact('bimbingan', 'periods'));
    }

    public function update(Request $request, $id)
    {
        $bimbingan = Bimbingan::where('id', $id)->where('dosen_id', Auth::user()->dosen->id)->firstOrFail();
        $validated = $request->validate([
            'jenis_bimbingan' => 'required|in:skripsi,tesis,disertasi',
            'kategori_bimbingan' => 'nullable|string',
            'jumlah_mahasiswa' => 'required|integer|min:1',
            'semester' => 'required|in:ganjil,genap',
            'tahun_akademik' => 'required|integer',
            'academic_period_id' => 'required|exists:academic_periods,id',
            'no_sk_pembimbing' => 'nullable|string',
            'tanggal_sk_pembimbing' => 'nullable|date',
            'no_sk_penguji' => 'nullable|string',
            'tanggal_sk_penguji' => 'nullable|date',
        ]);
        $bimbingan->update($validated);
        return redirect()->route('dosen.bimbingan.index')->with('success', 'Data bimbingan diupdate');
    }

    public function destroy($id)
    {
        $bimbingan = Bimbingan::where('id', $id)->where('dosen_id', Auth::user()->dosen->id)->firstOrFail();
        $bimbingan->delete();
        return redirect()->route('dosen.bimbingan.index')->with('success', 'Data bimbingan dihapus');
    }
}
