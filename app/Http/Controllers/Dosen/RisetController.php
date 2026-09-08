<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Riset;
use App\Models\AcademicPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RisetController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $query = Riset::where('dosen_id', $dosen->id);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        if ($request->filled('search')) {
            $query->where('judul_riset', 'like', '%' . $request->search . '%');
        }

        $risets = $query->orderBy('tahun', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $tahunList = Riset::where('dosen_id', $dosen->id)
            ->select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view('dosen.riset.index', compact('risets', 'tahunList'));
    }

    public function create()
    {
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();
        $activePeriod = AcademicPeriod::where('is_active', true)->first();

        return view('dosen.riset.create', compact('periods', 'activePeriod'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $validated = $request->validate([
            'academic_period_id' => 'required|exists:academic_periods,id',
            'judul_riset' => 'required|max:255',
            'bidang_riset' => 'required|max:100',
            'jenis_riset' => 'required|max:100',
            'sumber_dana' => 'required|max:100',
            'jumlah_dana' => 'required|integer|min:0',
            'status' => 'required|in:aktif,selesai',
            'tahun' => 'required|integer|min:2000|max:2100',
            'publikasi_link' => 'nullable|url',
            'kolaborator' => 'nullable|max:255',
            'file_laporan' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $validated['dosen_id'] = $dosen->id;

        if ($request->hasFile('file_laporan')) {
            $validated['file_laporan'] = $request->file('file_laporan')->store('riset-laporan', 'public');
        }

        Riset::create($validated);

        return redirect()->route('dosen.riset.index')
            ->with('success', 'Data penelitian berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $riset = Riset::where('id', $id)
            ->where('dosen_id', $dosen->id)
            ->firstOrFail();

        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();

        return view('dosen.riset.edit', compact('riset', 'periods'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $riset = Riset::where('id', $id)
            ->where('dosen_id', $dosen->id)
            ->firstOrFail();

        $validated = $request->validate([
            'academic_period_id' => 'required|exists:academic_periods,id',
            'judul_riset' => 'required|max:255',
            'bidang_riset' => 'required|max:100',
            'jenis_riset' => 'required|max:100',
            'sumber_dana' => 'required|max:100',
            'jumlah_dana' => 'required|integer|min:0',
            'status' => 'required|in:aktif,selesai',
            'tahun' => 'required|integer|min:2000|max:2100',
            'publikasi_link' => 'nullable|url',
            'kolaborator' => 'nullable|max:255',
            'file_laporan' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        if ($request->hasFile('file_laporan')) {
            if ($riset->file_laporan) {
                Storage::disk('public')->delete($riset->file_laporan);
            }
            $validated['file_laporan'] = $request->file('file_laporan')->store('riset-laporan', 'public');
        }

        $riset->update($validated);

        return redirect()->route('dosen.riset.index')
            ->with('success', 'Data penelitian berhasil diupdate');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $riset = Riset::where('id', $id)
            ->where('dosen_id', $dosen->id)
            ->firstOrFail();

        if ($riset->file_laporan) {
            Storage::disk('public')->delete($riset->file_laporan);
        }

        $riset->delete();

        return redirect()->route('dosen.riset.index')
            ->with('success', 'Data penelitian berhasil dihapus');
    }

    public function show($id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $riset = Riset::where('id', $id)
            ->where('dosen_id', $dosen->id)
            ->firstOrFail();

        return view('dosen.riset.show', compact('riset'));
    }

    public function downloadLaporan($id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $riset = Riset::where('id', $id)
            ->where('dosen_id', $dosen->id)
            ->firstOrFail();

        if (!$riset->file_laporan) {
            return redirect()->route('dosen.riset.show', $riset->id)
                ->with('error', 'File laporan tidak tersedia');
        }

        return Storage::disk('public')->download($riset->file_laporan);
    }
}
