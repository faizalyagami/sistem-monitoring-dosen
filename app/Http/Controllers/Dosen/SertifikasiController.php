<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Sertifikasi;
use App\Models\AcademicPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SertifikasiController extends Controller
{
    public function index()
    {
        $sertifikasis = Sertifikasi::where('dosen_id', Auth::user()->dosen_id)
            ->with('academicPeriod')->latest()->paginate(10);
        return view('dosen.sertifikasi.index', compact('sertifikasis'));
    }

    public function create()
    {
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();
        return view('dosen.sertifikasi.create', compact('periods'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'academic_period_id' => 'required|exists:academic_periods,id',
            'jenis_sertifikasi' => 'required|max:100',
            'lembaga_sertifikasi' => 'required|max:100',
            'nomor_sertifikasi' => 'required|unique:sertifikasis|max:100',
            'tanggal_sertifikasi' => 'required|date',
            'valid_until' => 'nullable|date|after:tanggal_sertifikasi',
            'file_sertifikat' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);
        $validated['dosen_id'] = Auth::user()->dosen_id;
        if ($request->hasFile('file_sertifikat')) {
            $validated['file_sertifikat'] = $request->file('file_sertifikat')->store('sertifikasi-file', 'public');
        }
        Sertifikasi::create($validated);
        return redirect()->route('dosen.sertifikasi.index')->with('success', 'Data sertifikasi ditambahkan');
    }

    public function edit($id)
    {
        $sertifikasi = Sertifikasi::where('id', $id)->where('dosen_id', Auth::user()->dosen_id)->firstOrFail();
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();
        return view('dosen.sertifikasi.edit', compact('sertifikasi', 'periods'));
    }

    public function update(Request $request, $id)
    {
        $sertifikasi = Sertifikasi::where('id', $id)->where('dosen_id', Auth::user()->dosen_id)->firstOrFail();
        $validated = $request->validate([
            'academic_period_id' => 'required|exists:academic_periods,id',
            'jenis_sertifikasi' => 'required|max:100',
            'lembaga_sertifikasi' => 'required|max:100',
            'nomor_sertifikasi' => 'required|max:100|unique:sertifikasis,nomor_sertifikasi,' . $id,
            'tanggal_sertifikasi' => 'required|date',
            'valid_until' => 'nullable|date|after:tanggal_sertifikasi',
            'file_sertifikat' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);
        if ($request->hasFile('file_sertifikat')) {
            if ($sertifikasi->file_sertifikat) Storage::disk('public')->delete($sertifikasi->file_sertifikat);
            $validated['file_sertifikat'] = $request->file('file_sertifikat')->store('sertifikasi-file', 'public');
        }
        $sertifikasi->update($validated);
        return redirect()->route('dosen.sertifikasi.index')->with('success', 'Data sertifikasi diupdate');
    }

    public function destroy($id)
    {
        $sertifikasi = Sertifikasi::where('id', $id)->where('dosen_id', Auth::user()->dosen_id)->firstOrFail();
        if ($sertifikasi->file_sertifikat) Storage::disk('public')->delete($sertifikasi->file_sertifikat);
        $sertifikasi->delete();
        return redirect()->route('dosen.sertifikasi.index')->with('success', 'Data sertifikasi dihapus');
    }

    public function download($id)
    {
        $sertifikasi = Sertifikasi::where('id', $id)->where('dosen_id', Auth::user()->dosen_id)->firstOrFail();
        if ($sertifikasi->file_sertifikat && Storage::disk('public')->exists($sertifikasi->file_sertifikat)) {
            return Storage::disk('public')->download($sertifikasi->file_sertifikat);
        }
        return redirect()->back()->with('error', 'File tidak ditemukan');
    }
}
