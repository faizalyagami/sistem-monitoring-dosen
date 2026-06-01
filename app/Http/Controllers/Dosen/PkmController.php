<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Pkm;
use App\Models\AcademicPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PkmController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $query = Pkm::where('dosen_id', $dosen->id);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        $pkms = $query->orderBy('tahun', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $tahunList = Pkm::where('dosen_id', $dosen->id)
            ->select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view('dosen.pkm.index', compact('pkms', 'tahunList'));
    }

    public function create()
    {
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();
        $activePeriod = AcademicPeriod::where('is_active', true)->first();

        return view('dosen.pkm.create', compact('periods', 'activePeriod'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $validated = $request->validate([
            'academic_period_id' => 'required|exists:academic_periods,id',
            'judul_pkm' => 'required|max:255',
            'bidang_pkm' => 'required|max:100',
            'jenis_pkm' => 'required|max:100',
            'sumber_dana' => 'required|max:100',
            'jumlah_dana' => 'required|integer|min:0',
            'lokasi_kegiatan' => 'required|max:255',
            'status' => 'required|in:aktif,selesai',
            'tahun' => 'required|integer|min:2000|max:2100',
            'publikasi_link' => 'nullable|url',
            'file_laporan' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $validated['dosen_id'] = $dosen->id;

        if ($request->hasFile('file_laporan')) {
            $validated['file_laporan'] = $request->file('file_laporan')->store('pkm-laporan', 'public');
        }

        Pkm::create($validated);

        return redirect()->route('dosen.pkm.index')
            ->with('success', 'Data PKM berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $pkm = Pkm::where('id', $id)
            ->where('dosen_id', $dosen->id)
            ->firstOrFail();

        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();

        return view('dosen.pkm.edit', compact('pkm', 'periods'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $pkm = Pkm::where('id', $id)
            ->where('dosen_id', $dosen->id)
            ->firstOrFail();

        $validated = $request->validate([
            'academic_period_id' => 'required|exists:academic_periods,id',
            'judul_pkm' => 'required|max:255',
            'bidang_pkm' => 'required|max:100',
            'jenis_pkm' => 'required|max:100',
            'sumber_dana' => 'required|max:100',
            'jumlah_dana' => 'required|integer|min:0',
            'lokasi_kegiatan' => 'required|max:255',
            'status' => 'required|in:aktif,selesai',
            'tahun' => 'required|integer|min:2000|max:2100',
            'publikasi_link' => 'nullable|url',
            'file_laporan' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        if ($request->hasFile('file_laporan')) {
            if ($pkm->file_laporan) {
                Storage::disk('public')->delete($pkm->file_laporan);
            }
            $validated['file_laporan'] = $request->file('file_laporan')->store('pkm-laporan', 'public');
        }

        $pkm->update($validated);

        return redirect()->route('dosen.pkm.index')
            ->with('success', 'Data PKM berhasil diupdate');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $pkm = Pkm::where('id', $id)
            ->where('dosen_id', $dosen->id)
            ->firstOrFail();

        if ($pkm->file_laporan) {
            Storage::disk('public')->delete($pkm->file_laporan);
        }

        $pkm->delete();

        return redirect()->route('dosen.pkm.index')
            ->with('success', 'Data PKM berhasil dihapus');
    }

    public function show($id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $pkm = Pkm::where('id', $id)
            ->where('dosen_id', $dosen->id)
            ->firstOrFail();

        return view('dosen.pkm.show', compact('pkm'));
    }

    public function downloadLaporan($id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $pkm = Pkm::where('id', $id)
            ->where('dosen_id', $dosen->id)
            ->firstOrFail();

        if (!$pkm->file_laporan) {
            return redirect()->route('dosen.pkm.show', $pkm->id)
                ->with('error', 'File laporan tidak tersedia');
        }

        return Storage::disk('public')->download($pkm->file_laporan);
    }
}
