<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Sipp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SippController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $query = Sipp::where('dosen_id', $dosen->id);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $sipps = $query->latest()->paginate(10);

        return view('dosen.sipp.index', compact('sipps'));
    }

    public function create()
    {
        return view('dosen.sipp.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $validated = $request->validate([
            'no_registrasi' => 'required|unique:table_sipps|max:50',
            'bidang_keilmuan' => 'required|max:100',
            'tahun_terbit' => 'required|integer|min:2000|max:2100',
            'status' => 'required|in:aktif,tidak_aktif',
        ]);

        $validated['dosen_id'] = $dosen->id;

        Sipp::create($validated);

        return redirect()->route('dosen.sipp.index')
            ->with('success', 'Data SIPP berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $sipp = Sipp::where('id', $id)
            ->where('dosen_id', $dosen->id)
            ->firstOrFail();

        return view('dosen.sipp.edit', compact('sipp'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $sipp = Sipp::where('id', $id)
            ->where('dosen_id', $dosen->id)
            ->firstOrFail();

        $validated = $request->validate([
            'no_registrasi' => 'required|max:50|unique:table_sipps,no_registrasi,' . $id,
            'bidang_keilmuan' => 'required|max:100',
            'tahun_terbit' => 'required|integer|min:2000|max:2100',
            'status' => 'required|in:aktif,tidak_aktif',
        ]);

        $sipp->update($validated);

        return redirect()->route('dosen.sipp.index')
            ->with('success', 'Data SIPP berhasil diupdate');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $sipp = Sipp::where('id', $id)
            ->where('dosen_id', $dosen->id)
            ->firstOrFail();

        $sipp->delete();

        return redirect()->route('dosen.sipp.index')
            ->with('success', 'Data SIPP berhasil dihapus');
    }

    public function show($id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $sipp = Sipp::where('id', $id)
            ->where('dosen_id', $dosen->id)
            ->firstOrFail();

        return view('dosen.sipp.show', compact('sipp'));
    }
}
