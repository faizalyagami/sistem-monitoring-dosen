<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sertifikasi;
use App\Models\Dosen;
use App\Models\AcademicPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SertifikasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Sertifikasi::with(['dosen', 'academicPeriod']);

        if ($request->filled('dosen_id')) {
            $query->where('dosen_id', $request->dosen_id);
        }

        $sertifikasis = $query->latest()->paginate(10);
        $dosens = Dosen::all();
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();

        $tahunList = Sertifikasi::selectRaw('YEAR(tanggal_sertifikasi) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view('admin.sertifikasi.index', compact('sertifikasis', 'dosens', 'periods', 'tahunList'));
    }

    public function create()
    {
        $dosens = Dosen::all();
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();
        return view('admin.sertifikasi.create', compact('dosens', 'periods'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dosen_id' => 'required|exists:dosens,id',
            'academic_period_id' => 'required|exists:academic_periods,id',
            'jenis_sertifikasi' => 'required|max:100',
            'lembaga_sertifikasi' => 'required|max:100',
            'nomor_sertifikasi' => 'required|unique:sertifikasis|max:50',
            'tanggal_sertifikasi' => 'required|date',
            'valid_until' => 'nullable|date|after:tanggal_sertifikasi',
            'file_sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('file_sertifikat')) {
            $validated['file_sertifikat'] = $request->file('file_sertifikat')->store('sertifikasi-file', 'public');
        }

        Sertifikasi::create($validated);

        return redirect()->route('admin.sertifikasi.index')
            ->with('success', 'Data sertifikasi berhasil ditambahkan');
    }

    public function edit($id)
    {
        $sertifikasi = Sertifikasi::findOrFail($id);
        $dosens = Dosen::all();
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();
        return view('admin.sertifikasi.edit', compact('sertifikasi', 'dosens', 'periods'));
    }

    public function show($id)
    {
        $sertifikasi = Sertifikasi::with(['dosen', 'academicPeriod'])->findOrFail($id);
        return view('admin.sertifikasi.show', compact('sertifikasi'));
    }

    public function update(Request $request, $id)
    {
        $sertifikasi = Sertifikasi::findOrFail($id);

        $validated = $request->validate([
            'dosen_id' => 'required|exists:dosens,id',
            'academic_period_id' => 'required|exists:academic_periods,id',
            'jenis_sertifikasi' => 'required|max:100',
            'lembaga_sertifikasi' => 'required|max:100',
            'nomor_sertifikasi' => 'required|max:50|unique:sertifikasis,nomor_sertifikasi,' . $id,
            'tanggal_sertifikasi' => 'required|date',
            'valid_until' => 'nullable|date|after:tanggal_sertifikasi',
            'file_sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('file_sertifikat')) {
            if ($sertifikasi->file_sertifikat) {
                Storage::disk('public')->delete($sertifikasi->file_sertifikat);
            }
            $validated['file_sertifikat'] = $request->file('file_sertifikat')->store('sertifikasi-file', 'public');
        }

        $sertifikasi->update($validated);

        return redirect()->route('admin.sertifikasi.index')
            ->with('success', 'Data sertifikasi berhasil diupdate');
    }

    public function destroy($id)
    {
        $sertifikasi = Sertifikasi::findOrFail($id);
        if ($sertifikasi->file_sertifikat) {
            Storage::disk('public')->delete($sertifikasi->file_sertifikat);
        }
        $sertifikasi->delete();

        return redirect()->route('admin.sertifikasi.index')
            ->with('success', 'Data sertifikasi berhasil dihapus');
    }

    public function download($id)
    {
        $sertifikasi = Sertifikasi::findOrFail($id);
        if ($sertifikasi->file_sertifikat && Storage::disk('public')->exists($sertifikasi->file_sertifikat)) {
            return Storage::disk('public')->download($sertifikasi->file_sertifikat);
        }
        return redirect()->back()->with('error', 'File tidak ditemukan');
    }
}
