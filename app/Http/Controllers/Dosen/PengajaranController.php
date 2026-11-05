<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Pengajaran;
use App\Models\AcademicPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajaranController extends Controller
{
    public function index(Request $request)
    {
        $dosen = Auth::user()->dosen;
        $query = Pengajaran::where('dosen_id', $dosen->id)->with('academicPeriod');

        if ($request->filled('academic_period_id')) $query->where('academic_period_id', $request->academic_period_id);
        if ($request->filled('semester')) $query->where('semester', $request->semester);

        $pengajarans = $query->orderBy('tahun_akademik', 'desc')->paginate(10);
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();

        return view('dosen.pengajaran.index', compact('pengajarans', 'periods'));
    }

    public function create()
    {
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();
        return view('dosen.pengajaran.create', compact('periods'));
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
            'tahun_akademik' => 'required|integer',
            'academic_period_id' => 'required|exists:academic_periods,id',
            'no_sk' => 'nullable|string',
            'tanggal_sk' => 'nullable|date',
        ]);

        $validated['dosen_id'] = Auth::user()->dosen->id;
        Pengajaran::create($validated);

        return redirect()->route('dosen.pengajaran.index')->with('success', 'Data pengajaran ditambahkan');
    }

    public function show($id)
    {
        $pengajaran = Pengajaran::where('id', $id)->where('dosen_id', Auth::user()->dosen->id)->firstOrFail();
        return view('dosen.pengajaran.show', compact('pengajaran'));
    }

    public function edit($id)
    {
        $pengajaran = Pengajaran::where('id', $id)->where('dosen_id', Auth::user()->dosen->id)->firstOrFail();
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();
        return view('dosen.pengajaran.edit', compact('pengajaran', 'periods'));
    }

    public function update(Request $request, $id)
    {
        $pengajaran = Pengajaran::where('id', $id)->where('dosen_id', Auth::user()->dosen->id)->firstOrFail();

        $validated = $request->validate([
            'kode_mk' => 'required|max:20|unique:pengajaran,kode_mk,' . $id,
            'nama_mk' => 'required|max:100',
            'bidang_keilmuan' => 'required|max:50',
            'kelas' => 'required|max:10',
            'sks' => 'required|integer|min:1|max:6',
            'jumlah_mahasiswa' => 'required|integer|min:1',
            'semester' => 'required|in:ganjil,genap',
            'tahun_akademik' => 'required|integer',
            'academic_period_id' => 'required|exists:academic_periods,id',
        ]);

        $pengajaran->update($validated);
        return redirect()->route('dosen.pengajaran.index')->with('success', 'Data pengajaran diupdate');
    }

    public function destroy($id)
    {
        $pengajaran = Pengajaran::where('id', $id)->where('dosen_id', Auth::user()->dosen->id)->firstOrFail();
        $pengajaran->delete();
        return redirect()->route('dosen.pengajaran.index')->with('success', 'Data pengajaran dihapus');
    }
}
