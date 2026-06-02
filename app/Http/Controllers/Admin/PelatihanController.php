<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelatihan;
use App\Models\Dosen;
use App\Models\AcademicPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PelatihanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pelatihan::with(['dosen', 'academicPeriod']);

        if ($request->filled('dosen_id')) {
            $query->where('dosen_id', $request->dosen_id);
        }

        $pelatihans = $query->latest()->paginate(10);
        $dosens = Dosen::all();
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();

        return view('admin.pelatihan.index', compact('pelatihans', 'dosens', 'periods'));
    }

    public function create()
    {
        $dosens = Dosen::all();
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();
        return view('admin.pelatihan.create', compact('dosens', 'periods'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dosen_id' => 'required|exists:dosens,id',
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
            $validated['file_sertifikat'] = $request->file('file_sertifikat')->store('pelatihan-sertifikat', 'public');
        }

        Pelatihan::create($validated);

        return redirect()->route('admin.pelatihan.index')
            ->with('success', 'Data pelatihan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $pelatihan = Pelatihan::findOrFail($id);
        $dosens = Dosen::all();
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();
        return view('admin.pelatihan.edit', compact('pelatihan', 'dosens', 'periods'));
    }

    public function update(Request $request, $id)
    {
        $pelatihan = Pelatihan::findOrFail($id);

        $validated = $request->validate([
            'dosen_id' => 'required|exists:dosens,id',
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

        return redirect()->route('admin.pelatihan.index')
            ->with('success', 'Data pelatihan berhasil diupdate');
    }

    public function destroy($id)
    {
        $pelatihan = Pelatihan::findOrFail($id);
        if ($pelatihan->file_sertifikat) {
            Storage::disk('public')->delete($pelatihan->file_sertifikat);
        }
        $pelatihan->delete();

        return redirect()->route('admin.pelatihan.index')
            ->with('success', 'Data pelatihan berhasil dihapus');
    }

    public function download($id)
    {
        $pelatihan = Pelatihan::findOrFail($id);
        if ($pelatihan->file_sertifikat && Storage::disk('public')->exists($pelatihan->file_sertifikat)) {
            return Storage::disk('public')->download($pelatihan->file_sertifikat);
        }
        return redirect()->back()->with('error', 'File tidak ditemukan');
    }
}
