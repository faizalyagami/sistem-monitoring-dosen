<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\SuratTugas;
use App\Models\AcademicPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SuratTugasController extends Controller
{
    public function index()
    {
        $suratTugas = SuratTugas::where('dosen_id', Auth::user()->dosen_id)
            ->with('academicPeriod')->latest()->paginate(10);
        return view('dosen.surat-tugas.index', compact('suratTugas'));
    }

    public function create()
    {
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();
        return view('dosen.surat-tugas.create', compact('periods'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'academic_period_id' => 'required|exists:academic_periods,id',
            'nama_surat_tugas' => 'required|max:150',
            'no_surat_tugas' => 'required|unique:surat_tugas|max:100',
            'perihal' => 'nullable|string',
            'tanggal_surat_tugas' => 'required|date',
            'file_surat' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);
        $validated['dosen_id'] = Auth::user()->dosen_id;
        if ($request->hasFile('file_surat')) {
            $validated['file_surat'] = $request->file('file_surat')->store('surat-tugas', 'public');
        }
        SuratTugas::create($validated);
        return redirect()->route('dosen.surat-tugas.index')->with('success', 'Surat tugas ditambahkan');
    }

    public function edit($id)
    {
        $suratTugas = SuratTugas::where('id', $id)->where('dosen_id', Auth::user()->dosen_id)->firstOrFail();
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();
        return view('dosen.surat-tugas.edit', compact('suratTugas', 'periods'));
    }

    public function update(Request $request, $id)
    {
        $suratTugas = SuratTugas::where('id', $id)->where('dosen_id', Auth::user()->dosen_id)->firstOrFail();
        $validated = $request->validate([
            'academic_period_id' => 'required|exists:academic_periods,id',
            'nama_surat_tugas' => 'required|max:150',
            'no_surat_tugas' => 'required|max:100|unique:surat_tugas,no_surat_tugas,' . $id,
            'perihal' => 'nullable|string',
            'tanggal_surat_tugas' => 'required|date',
            'file_surat' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);
        if ($request->hasFile('file_surat')) {
            if ($suratTugas->file_surat) Storage::disk('public')->delete($suratTugas->file_surat);
            $validated['file_surat'] = $request->file('file_surat')->store('surat-tugas', 'public');
        }
        $suratTugas->update($validated);
        return redirect()->route('dosen.surat-tugas.index')->with('success', 'Surat tugas diupdate');
    }

    public function destroy($id)
    {
        $suratTugas = SuratTugas::where('id', $id)->where('dosen_id', Auth::user()->dosen_id)->firstOrFail();
        if ($suratTugas->file_surat) Storage::disk('public')->delete($suratTugas->file_surat);
        $suratTugas->delete();
        return redirect()->route('dosen.surat-tugas.index')->with('success', 'Surat tugas dihapus');
    }

    public function download($id)
    {
        $suratTugas = SuratTugas::where('id', $id)->where('dosen_id', Auth::user()->dosen_id)->firstOrFail();
        if ($suratTugas->file_surat && Storage::disk('public')->exists($suratTugas->file_surat)) {
            return Storage::disk('public')->download($suratTugas->file_surat);
        }
        return redirect()->back()->with('error', 'File tidak ditemukan');
    }
}
