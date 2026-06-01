<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Pengajaran;
use App\Models\AcademicPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajaranController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $query = Pengajaran::where('dosen_id', $dosen->id)
            ->with('academicPeriod');

        // Filter by periode
        if ($request->filled('academic_period_id')) {
            $query->where('academic_period_id', $request->academic_period_id);
        }

        // Filter by semester
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('kode_mk', 'like', '%' . $request->search . '%')
                    ->orWhere('nama_mk', 'like', '%' . $request->search . '%');
            });
        }

        $pengajarans = $query->orderBy('tahun_akademik', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();

        return view('dosen.pengajaran.index', compact('pengajarans', 'periods'));
    }

    public function create()
    {
        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();
        $activePeriod = AcademicPeriod::where('is_active', true)->first();

        return view('dosen.pengajaran.create', compact('periods', 'activePeriod'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $validated = $request->validate([
            'kode_mk' => 'required|unique:pengajaran|max:20',
            'nama_mk' => 'required|max:100',
            'bidang_keilmuan' => 'required|max:50',
            'kelas' => 'required|max:10',
            'sks' => 'required|integer|min:1|max:6',
            'jumlah_mahasiswa' => 'required|integer|min:1',
            'semester' => 'required|in:ganjil,genap',
            'tahun_akademik' => 'required|integer|min:2000|max:2100',
            'academic_period_id' => 'required|exists:academic_periods,id',
        ]);

        $validated['dosen_id'] = $dosen->id;

        Pengajaran::create($validated);

        return redirect()->route('dosen.pengajaran.index')
            ->with('success', 'Data pengajaran berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $pengajaran = Pengajaran::where('id', $id)
            ->where('dosen_id', $dosen->id)
            ->firstOrFail();

        $periods = AcademicPeriod::orderBy('tahun_awal', 'desc')->get();

        return view('dosen.pengajaran.edit', compact('pengajaran', 'periods'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $pengajaran = Pengajaran::where('id', $id)
            ->where('dosen_id', $dosen->id)
            ->firstOrFail();

        $validated = $request->validate([
            'kode_mk' => 'required|max:20|unique:pengajaran,kode_mk,' . $id,
            'nama_mk' => 'required|max:100',
            'bidang_keilmuan' => 'required|max:50',
            'kelas' => 'required|max:10',
            'sks' => 'required|integer|min:1|max:6',
            'jumlah_mahasiswa' => 'required|integer|min:1',
            'semester' => 'required|in:ganjil,genap',
            'tahun_akademik' => 'required|integer|min:2000|max:2100',
            'academic_period_id' => 'required|exists:academic_periods,id',
        ]);

        $pengajaran->update($validated);

        return redirect()->route('dosen.pengajaran.index')
            ->with('success', 'Data pengajaran berhasil diupdate');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $pengajaran = Pengajaran::where('id', $id)
            ->where('dosen_id', $dosen->id)
            ->firstOrFail();

        $pengajaran->delete();

        return redirect()->route('dosen.pengajaran.index')
            ->with('success', 'Data pengajaran berhasil dihapus');
    }

    public function show($id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $pengajaran = Pengajaran::where('id', $id)
            ->where('dosen_id', $dosen->id)
            ->with('academicPeriod')
            ->firstOrFail();

        return view('dosen.pengajaran.show', compact('pengajaran'));
    }
}
