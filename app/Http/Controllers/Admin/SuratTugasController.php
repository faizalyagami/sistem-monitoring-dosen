<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SuratTugas;
use App\Models\Dosen;
use App\Models\AcademicPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratTugasController extends Controller
{
    public function index(Request $request)
    {
        $query = SuratTugas::with(['dosen', 'academicPeriod']);

        if ($request->filled('dosen_id')) {
            $query->where('dosen_id', $request->dosen_id);
        }

        $suratTugas = $query->latest()->paginate(10);
        $dosens = Dosen::all();
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();

        return view('admin.surat-tugas.index', compact('suratTugas', 'dosens', 'periods'));
    }

    public function create()
    {
        $dosens = Dosen::all();
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();
        return view('admin.surat-tugas.create', compact('dosens', 'periods'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dosen_id' => 'required|exists:dosens,id',
            'academic_period_id' => 'required|exists:academic_periods,id',
            'nama_surat_tugas' => 'required|max:100',
            'no_surat_tugas' => 'required|unique:surat_tugas|max:50',
            'perihal' => 'nullable|string',
            'tanggal_surat_tugas' => 'required|date',
            'file_surat' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        if ($request->hasFile('file_surat')) {
            $validated['file_surat'] = $request->file('file_surat')->store('surat-tugas', 'public');
        }

        SuratTugas::create($validated);

        return redirect()->route('admin.surat-tugas.index')
            ->with('success', 'Surat tugas berhasil ditambahkan');
    }

    public function edit($id)
    {
        $suratTugas = SuratTugas::findOrFail($id);
        $dosens = Dosen::all();
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();
        return view('admin.surat-tugas.edit', compact('suratTugas', 'dosens', 'periods'));
    }

    public function update(Request $request, $id)
    {
        $suratTugas = SuratTugas::findOrFail($id);

        $validated = $request->validate([
            'dosen_id' => 'required|exists:dosens,id',
            'academic_period_id' => 'required|exists:academic_periods,id',
            'nama_surat_tugas' => 'required|max:100',
            'no_surat_tugas' => 'required|max:50|unique:surat_tugas,no_surat_tugas,' . $id,
            'perihal' => 'nullable|string',
            'tanggal_surat_tugas' => 'required|date',
            'file_surat' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        if ($request->hasFile('file_surat')) {
            if ($suratTugas->file_surat) {
                Storage::disk('public')->delete($suratTugas->file_surat);
            }
            $validated['file_surat'] = $request->file('file_surat')->store('surat-tugas', 'public');
        }

        $suratTugas->update($validated);

        return redirect()->route('admin.surat-tugas.index')
            ->with('success', 'Surat tugas berhasil diupdate');
    }

    public function destroy($id)
    {
        $suratTugas = SuratTugas::findOrFail($id);
        if ($suratTugas->file_surat) {
            Storage::disk('public')->delete($suratTugas->file_surat);
        }
        $suratTugas->delete();

        return redirect()->route('admin.surat-tugas.index')
            ->with('success', 'Surat tugas berhasil dihapus');
    }

    public function download($id)
    {
        $suratTugas = SuratTugas::findOrFail($id);
        if ($suratTugas->file_surat && Storage::disk('public')->exists($suratTugas->file_surat)) {
            return Storage::disk('public')->download($suratTugas->file_surat);
        }
        return redirect()->back()->with('error', 'File tidak ditemukan');
    }
}
