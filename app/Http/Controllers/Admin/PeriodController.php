<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicPeriod;
use Illuminate\Http\Request;

class PeriodController extends Controller
{
    public function index()
    {
        $periods = AcademicPeriod::orderBy('urutan', 'desc')->paginate(10);
        return view('admin.periods.index', compact('periods'));
    }

    public function create()
    {
        return view('admin.periods.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_periode' => 'required|max:100',
            'semester' => 'required|in:ganjil,genap',
            'tahun_awal' => 'required|integer|min:2000|max:2100',
            'tahun_akhir' => 'required|integer|min:2000|max:2100',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after:tanggal_mulai',
            'is_active' => 'boolean',
            'is_closed' => 'boolean',
            'keterangan' => 'nullable|max:255',
        ]);

        $validated['kode_periode'] = $validated['tahun_awal'] . ($validated['semester'] == 'ganjil' ? '1' : '2');
        $validated['urutan'] = $validated['tahun_awal'] * 10 + ($validated['semester'] == 'ganjil' ? 1 : 2);

        // If this period is set as active, deactivate others
        if (isset($validated['is_active']) && $validated['is_active']) {
            AcademicPeriod::where('is_active', true)->update(['is_active' => false]);
        }

        AcademicPeriod::create($validated);

        return redirect()->route('admin.periods.index')
            ->with('success', 'Periode akademik berhasil ditambahkan');
    }

    public function edit(AcademicPeriod $period)
    {
        return view('admin.periods.edit', compact('period'));
    }

    public function update(Request $request, AcademicPeriod $period)
    {
        $validated = $request->validate([
            'nama_periode' => 'required|max:100',
            'semester' => 'required|in:ganjil,genap',
            'tahun_awal' => 'required|integer|min:2000|max:2100',
            'tahun_akhir' => 'required|integer|min:2000|max:2100',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after:tanggal_mulai',
            'is_active' => 'boolean',
            'is_closed' => 'boolean',
            'keterangan' => 'nullable|max:255',
        ]);

        $validated['kode_periode'] = $validated['tahun_awal'] . ($validated['semester'] == 'ganjil' ? '1' : '2');
        $validated['urutan'] = $validated['tahun_awal'] * 10 + ($validated['semester'] == 'ganjil' ? 1 : 2);

        // If this period is set as active, deactivate others
        if (isset($validated['is_active']) && $validated['is_active']) {
            AcademicPeriod::where('id', '!=', $period->id)->where('is_active', true)->update(['is_active' => false]);
        }

        $period->update($validated);

        return redirect()->route('admin.periods.index')
            ->with('success', 'Periode akademik berhasil diupdate');
    }

    public function destroy(AcademicPeriod $period)
    {
        // Check if period has related data
        if ($period->pengajarans()->count() > 0 || $period->risets()->count() > 0) {
            return redirect()->route('admin.periods.index')
                ->with('error', 'Periode tidak dapat dihapus karena memiliki data terkait');
        }

        $period->delete();

        return redirect()->route('admin.periods.index')
            ->with('success', 'Periode akademik berhasil dihapus');
    }

    public function setActive(AcademicPeriod $period)
    {
        AcademicPeriod::where('is_active', true)->update(['is_active' => false]);
        $period->update(['is_active' => true]);

        return redirect()->route('admin.periods.index')
            ->with('success', 'Periode aktif berhasil diubah');
    }
}
