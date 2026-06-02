<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Pelatihan;
use App\Models\AcademicPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PelatihanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $query = Pelatihan::where('dosen_id', $dosen->id)
            ->with('academicPeriod');

        // Filter by tahun
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        $pelatihans = $query->latest()->paginate(10);
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();
        $tahunList = Pelatihan::where('dosen_id', $dosen->id)
            ->select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view('dosen.pelatihan.index', compact('pelatihans', 'periods', 'tahunList'));
    }

    public function create()
    {
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();
        $activePeriod = AcademicPeriod::where('is_active', true)->first();

        return view('dosen.pelatihan.create', compact('periods', 'activePeriod'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $validated = $request->validate([
            'academic_period_id' => 'required|exists:academic_periods,id',
            'nama_pelatihan' => 'required|max:100',
            'penyelenggara' => 'required|max:100',
            'tanggal_pelatihan' => 'required|date',
            'lokasi' => 'required|max:100',
            'tahun' => 'required|integer|min:2000|max:2100',
            'durasi' => 'nullable|integer|min:1',
            'file_sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $validated['dosen_id'] = $dosen->id;

        if ($request->hasFile('file_sertifikat')) {
            $validated['file_sertifikat'] = $request->file('file_sertifikat')->store('pelatihan-sertifikat', 'public');
        }

        Pelatihan::create($validated);

        return redirect()->route('dosen.pelatihan.index')
            ->with('success', 'Data pelatihan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $pelatihan = Pelatihan::where('id', $id)
            ->where('dosen_id', $dosen->id)
            ->firstOrFail();

        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();

        return view('dosen.pelatihan.edit', compact('pelatihan', 'periods'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $pelatihan = Pelatihan::where('id', $id)
            ->where('dosen_id', $dosen->id)
            ->firstOrFail();

        $validated = $request->validate([
            'academic_period_id' => 'required|exists:academic_periods,id',
            'nama_pelatihan' => 'required|max:100',
            'penyelenggara' => 'required|max:100',
            'tanggal_pelatihan' => 'required|date',
            'lokasi' => 'required|max:100',
            'tahun' => 'required|integer|min:2000|max:2100',
            'durasi' => 'nullable|integer|min:1',
            'file_sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('file_sertifikat')) {
            if ($pelatihan->file_sertifikat) {
                Storage::disk('public')->delete($pelatihan->file_sertifikat);
            }
            $validated['file_sertifikat'] = $request->file('file_sertifikat')->store('pelatihan-sertifikat', 'public');
        }

        $pelatihan->update($validated);

        return redirect()->route('dosen.pelatihan.index')
            ->with('success', 'Data pelatihan berhasil diupdate');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $pelatihan = Pelatihan::where('id', $id)
            ->where('dosen_id', $dosen->id)
            ->firstOrFail();

        if ($pelatihan->file_sertifikat) {
            Storage::disk('public')->delete($pelatihan->file_sertifikat);
        }

        $pelatihan->delete();

        return redirect()->route('dosen.pelatihan.index')
            ->with('success', 'Data pelatihan berhasil dihapus');
    }

    public function show($id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $pelatihan = Pelatihan::where('id', $id)
            ->where('dosen_id', $dosen->id)
            ->with('academicPeriod')
            ->firstOrFail();

        return view('dosen.pelatihan.show', compact('pelatihan'));
    }

    public function download($id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $pelatihan = Pelatihan::where('id', $id)
            ->where('dosen_id', $dosen->id)
            ->firstOrFail();

        if ($pelatihan->file_sertifikat && Storage::disk('public')->exists($pelatihan->file_sertifikat)) {
            return Storage::disk('public')->download($pelatihan->file_sertifikat);
        }

        return redirect()->back()->with('error', 'File sertifikat tidak ditemukan');
    }
}
