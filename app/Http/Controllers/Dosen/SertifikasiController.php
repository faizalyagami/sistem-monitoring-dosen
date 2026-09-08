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
    public function index(Request $request)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $query = Sertifikasi::where('dosen_id', $dosen->id)
            ->with('academicPeriod');

        // Filter by tahun
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_sertifikasi', $request->tahun);
        }

        $sertifikasis = $query->latest()->paginate(10);
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();
        $tahunList = Sertifikasi::where('dosen_id', $dosen->id)
            ->selectRaw('YEAR(tanggal_sertifikasi) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view('dosen.sertifikasi.index', compact('sertifikasis', 'periods', 'tahunList'));
    }

    public function create()
    {
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();
        $activePeriod = AcademicPeriod::where('is_active', true)->first();

        return view('dosen.sertifikasi.create', compact('periods', 'activePeriod'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $validated = $request->validate([
            'academic_period_id' => 'required|exists:academic_periods,id',
            'jenis_sertifikasi' => 'required|max:100',
            'lembaga_sertifikasi' => 'required|max:100',
            'nomor_sertifikasi' => 'required|unique:sertifikasis|max:50',
            'tanggal_sertifikasi' => 'required|date',
            'valid_until' => 'nullable|date|after:tanggal_sertifikasi',
            'file_sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $validated['dosen_id'] = $dosen->id;

        if ($request->hasFile('file_sertifikat')) {
            $validated['file_sertifikat'] = $request->file('file_sertifikat')->store('sertifikasi-file', 'public');
        }

        Sertifikasi::create($validated);

        return redirect()->route('dosen.sertifikasi.index')
            ->with('success', 'Data sertifikasi berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $sertifikasi = Sertifikasi::where('id', $id)
            ->where('dosen_id', $dosen->id)
            ->firstOrFail();

        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();

        return view('dosen.sertifikasi.edit', compact('sertifikasi', 'periods'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $sertifikasi = Sertifikasi::where('id', $id)
            ->where('dosen_id', $dosen->id)
            ->firstOrFail();

        $validated = $request->validate([
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

        return redirect()->route('dosen.sertifikasi.index')
            ->with('success', 'Data sertifikasi berhasil diupdate');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $sertifikasi = Sertifikasi::where('id', $id)
            ->where('dosen_id', $dosen->id)
            ->firstOrFail();

        if ($sertifikasi->file_sertifikat) {
            Storage::disk('public')->delete($sertifikasi->file_sertifikat);
        }

        $sertifikasi->delete();

        return redirect()->route('dosen.sertifikasi.index')
            ->with('success', 'Data sertifikasi berhasil dihapus');
    }

    public function show($id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $sertifikasi = Sertifikasi::where('id', $id)
            ->where('dosen_id', $dosen->id)
            ->with('academicPeriod')
            ->firstOrFail();

        return view('dosen.sertifikasi.show', compact('sertifikasi'));
    }

    public function download($id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $sertifikasi = Sertifikasi::where('id', $id)
            ->where('dosen_id', $dosen->id)
            ->firstOrFail();

        if ($sertifikasi->file_sertifikat && Storage::disk('public')->exists($sertifikasi->file_sertifikat)) {
            return Storage::disk('public')->download($sertifikasi->file_sertifikat);
        }

        return redirect()->back()->with('error', 'File sertifikat tidak ditemukan');
    }
}
