<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Sipp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SippController extends Controller
{
    public function index()
    {
        $sipps = Sipp::where('dosen_id', Auth::user()->dosen_id)->latest()->paginate(10);
        return view('dosen.sipp.index', compact('sipps'));
    }

    public function create()
    {
        return view('dosen.sipp.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_registrasi' => 'required|unique:table_sipps|max:50',
            'bidang_keilmuan' => 'required|max:100',
            'tahun_terbit' => 'required|integer',
            'status' => 'required|in:aktif,tidak_aktif',
            'file_sipp' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);
        $validated['dosen_id'] = Auth::user()->dosen_id;

        if ($request->hasFile('file_sipp')) {
            $validated['file_sipp'] = $request->file('file_sipp')->store('sipp-files', 'public');
        }

        Sipp::create($validated);
        return redirect()->route('dosen.sipp.index')->with('success', 'Data SIPP ditambahkan');
    }

    public function edit($id)
    {
        $sipp = Sipp::where('id', $id)->where('dosen_id', Auth::user()->dosen_id)->firstOrFail();
        return view('dosen.sipp.edit', compact('sipp'));
    }

    public function update(Request $request, $id)
    {
        $sipp = Sipp::where('id', $id)->where('dosen_id', Auth::user()->dosen_id)->firstOrFail();
        $validated = $request->validate([
            'no_registrasi' => 'required|max:50|unique:sipps,no_registrasi,' . $id,
            'bidang_keilmuan' => 'required|max:100',
            'tahun_terbit' => 'required|integer',
            'status' => 'required|in:aktif,tidak_aktif',
            'file_sipp' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('file_sipp')) {
            // Hapus file lama jika ada
            if ($sipp->file_sipp) {
                Storage::disk('public')->delete($sipp->file_sipp);
            }
            $validated['file_sipp'] = $request->file('file_sipp')->store('sipp-files', 'public');
        }

        $sipp->update($validated);
        return redirect()->route('dosen.sipp.index')->with('success', 'Data SIPP diupdate');
    }

    public function download($id)
    {
        $sipp = Sipp::where('id', $id)->where('dosen_id', Auth::user()->dosen_id)->firstOrFail();

        if ($sipp->file_sipp && Storage::disk('public')->exists($sipp->file_sipp)) {
            return Storage::disk('public')->download($sipp->file_sipp);
        }
        return redirect()->back()->with('error', 'File tidak ditemukan');
    }

    public function destroy($id)
    {
        Sipp::where('id', $id)->where('dosen_id', Auth::user()->dosen_id)->firstOrFail()->delete();
        return redirect()->route('dosen.sipp.index')->with('success', 'Data SIPP dihapus');
    }
}
