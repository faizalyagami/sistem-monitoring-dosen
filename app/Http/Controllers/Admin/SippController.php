<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sipp;
use App\Models\Dosen;
use Illuminate\Http\Request;

class SippController extends Controller
{
    public function index(Request $request)
    {
        $query = Sipp::with('dosen');

        if ($request->filled('dosen_id')) {
            $query->where('dosen_id', $request->dosen_id);
        }

        $sipps = $query->latest()->paginate(10);
        $dosens = Dosen::all();

        return view('admin.sipp.index', compact('sipps', 'dosens'));
    }

    public function create()
    {
        $dosens = Dosen::all();
        return view('admin.sipp.create', compact('dosens'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dosen_id' => 'required|exists:dosens,id',
            'no_registrasi' => 'required|unique:table_sipps|max:50',
            'bidang_keilmuan' => 'required|max:100',
            'tahun_terbit' => 'required|integer|min:2000|max:2100',
            'status' => 'required|in:aktif,tidak_aktif',
        ]);

        Sipp::create($validated);

        return redirect()->route('admin.sipp.index')
            ->with('success', 'Data SIPP berhasil ditambahkan');
    }

    public function edit($id)
    {
        $sipp = Sipp::findOrFail($id);
        $dosens = Dosen::all();
        return view('admin.sipp.edit', compact('sipp', 'dosens'));
    }

    public function show($id)
    {
        $sipp = Sipp::with('dosen')->findOrFail($id);
        return view('admin.sipp.show', compact('sipp'));
    }

    public function update(Request $request, $id)
    {
        $sipp = Sipp::findOrFail($id);

        $validated = $request->validate([
            'dosen_id' => 'required|exists:dosens,id',
            'no_registrasi' => 'required|max:50|unique:table_sipps,no_registrasi,' . $id,
            'bidang_keilmuan' => 'required|max:100',
            'tahun_terbit' => 'required|integer|min:2000|max:2100',
            'status' => 'required|in:aktif,tidak_aktif',
        ]);

        $sipp->update($validated);

        return redirect()->route('admin.sipp.index')
            ->with('success', 'Data SIPP berhasil diupdate');
    }

    public function destroy($id)
    {
        $sipp = Sipp::findOrFail($id);
        $sipp->delete();

        return redirect()->route('admin.sipp.index')
            ->with('success', 'Data SIPP berhasil dihapus');
    }
}
