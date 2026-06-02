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
    public function index(Request $request)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $query = SuratTugas::where('dosen_id', $dosen->id)
            ->with('academicPeriod');

        // Filter by tahun
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_surat_tugas', $request->tahun);
        }

        $suratTugas = $query->latest()->paginate(10);
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();
        $tahunList = SuratTugas::where('dosen_id', $dosen->id)
            ->selectRaw('YEAR(tanggal_surat_tugas) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view('dosen.surat-tugas.index', compact('suratTugas', 'periods', 'tahunList'));
    }

    public function create()
    {
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();
        $activePeriod = AcademicPeriod::where('is_active', true)->first();

        return view('dosen.surat-tugas.create', compact('periods', 'activePeriod'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $validated = $request->validate([
            'academic_period_id' => 'required|exists:academic_periods,id',
            'nama_surat_tugas' => 'required|max:100',
            'no_surat_tugas' => 'required|unique:surat_tugas|max:50',
            'perihal' => 'nullable|string',
            'tanggal_surat_tugas' => 'required|date',
            'file_surat' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $validated['dosen_id'] = $dosen->id;

        if ($request->hasFile('file_surat')) {
            $validated['file_surat'] = $request->file('file_surat')->store('surat-tugas', 'public');
        }

        SuratTugas::create($validated);

        return redirect()->route('dosen.surat-tugas.index')
            ->with('success', 'Surat tugas berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $suratTugas = SuratTugas::where('id', $id)
            ->where('dosen_id', $dosen->id)
            ->firstOrFail();

        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();

        return view('dosen.surat-tugas.edit', compact('suratTugas', 'periods'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $suratTugas = SuratTugas::where('id', $id)
            ->where('dosen_id', $dosen->id)
            ->firstOrFail();

        $validated = $request->validate([
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

        return redirect()->route('dosen.surat-tugas.index')
            ->with('success', 'Surat tugas berhasil diupdate');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $suratTugas = SuratTugas::where('id', $id)
            ->where('dosen_id', $dosen->id)
            ->firstOrFail();

        if ($suratTugas->file_surat) {
            Storage::disk('public')->delete($suratTugas->file_surat);
        }

        $suratTugas->delete();

        return redirect()->route('dosen.surat-tugas.index')
            ->with('success', 'Surat tugas berhasil dihapus');
    }

    public function show($id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $suratTugas = SuratTugas::where('id', $id)
            ->where('dosen_id', $dosen->id)
            ->with('academicPeriod')
            ->firstOrFail();

        return view('dosen.surat-tugas.show', compact('suratTugas'));
    }

    public function download($id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $suratTugas = SuratTugas::where('id', $id)
            ->where('dosen_id', $dosen->id)
            ->firstOrFail();

        if ($suratTugas->file_surat && Storage::disk('public')->exists($suratTugas->file_surat)) {
            return Storage::disk('public')->download($suratTugas->file_surat);
        }

        return redirect()->back()->with('error', 'File surat tugas tidak ditemukan');
    }
}
