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
    public function index()
    {
        $pelatihans = Pelatihan::where('dosen_id', Auth::user()->dosen_id)
            ->with('academicPeriod')->latest()->paginate(10);
        return view('dosen.pelatihan.index', compact('pelatihans'));
    }

    public function create()
    {
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();
        return view('dosen.pelatihan.create', compact('periods'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'academic_period_id' => 'required|exists:academic_periods,id',
            'nama_pelatihan' => 'required|max:100',
            'penyelenggara' => 'required|max:100',
            'tanggal_pelatihan' => 'required|date',
            'lokasi' => 'required|max:100',
            'tahun' => 'required|integer',
            'durasi' => 'nullable|integer',
            'file_sertifikat' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);
        $validated['dosen_id'] = Auth::user()->dosen_id;
        if ($request->hasFile('file_sertifikat')) {
            $validated['file_sertifikat'] = $request->file('file_sertifikat')->store('pelatihan-sertifikat', 'public');
        }
        Pelatihan::create($validated);
        return redirect()->route('dosen.pelatihan.index')->with('success', 'Data pelatihan ditambahkan');
    }

    public function show($id)
    {
        $pelatihan = Pelatihan::where('id', $id)->where('dosen_id', Auth::user()->dosen_id)->firstOrFail();
        return view('dosen.pelatihan.show', compact('pelatihan'));
    }

    public function edit($id)
    {
        $pelatihan = Pelatihan::where('id', $id)->where('dosen_id', Auth::user()->dosen_id)->firstOrFail();
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();
        return view('dosen.pelatihan.edit', compact('pelatihan', 'periods'));
    }

    public function update(Request $request, $id)
    {
        $pelatihan = Pelatihan::where('id', $id)->where('dosen_id', Auth::user()->dosen_id)->firstOrFail();
        $validated = $request->validate([
            'academic_period_id' => 'required|exists:academic_periods,id',
            'nama_pelatihan' => 'required|max:100',
            'penyelenggara' => 'required|max:100',
            'tanggal_pelatihan' => 'required|date',
            'lokasi' => 'required|max:100',
            'tahun' => 'required|integer',
            'durasi' => 'nullable|integer',
            'file_sertifikat' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);
        if ($request->hasFile('file_sertifikat')) {
            if ($pelatihan->file_sertifikat) Storage::disk('public')->delete($pelatihan->file_sertifikat);
            $validated['file_sertifikat'] = $request->file('file_sertifikat')->store('pelatihan-sertifikat', 'public');
        }
        $pelatihan->update($validated);
        return redirect()->route('dosen.pelatihan.index')->with('success', 'Data pelatihan diupdate');
    }

    public function destroy($id)
    {
        $pelatihan = Pelatihan::where('id', $id)->where('dosen_id', Auth::user()->dosen_id)->firstOrFail();
        if ($pelatihan->file_sertifikat) Storage::disk('public')->delete($pelatihan->file_sertifikat);
        $pelatihan->delete();
        return redirect()->route('dosen.pelatihan.index')->with('success', 'Data pelatihan dihapus');
    }

    public function download($id)
    {
        $pelatihan = Pelatihan::where('id', $id)->where('dosen_id', Auth::user()->dosen_id)->firstOrFail();
        if ($pelatihan->file_sertifikat && Storage::disk('public')->exists($pelatihan->file_sertifikat)) {
            return Storage::disk('public')->download($pelatihan->file_sertifikat);
        }
        return redirect()->back()->with('error', 'File tidak ditemukan');
    }
}
