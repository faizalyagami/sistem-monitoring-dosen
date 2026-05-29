<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DosenController extends Controller
{
    public function index(Request $request)
    {
        $query = Dosen::query();

        if ($request->has('search') && $request->search) {
            $query->where('nama', 'like', '%' . $request->search . '%')
                ->orWhere('nidn', 'like', '%' . $request->search . '%')
                ->orWhere('nik', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $dosens = $query->latest()->paginate(10);

        return view('admin.dosens.index', compact('dosens'));
    }

    public function create()
    {
        return view('admin.dosens.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nidn' => 'required|unique:dosens|max:20',
            'nik' => 'required|unique:dosens|max:20',
            'nama' => 'required|max:100',
            'email' => 'required|email|unique:dosens',
            'status' => 'required|in:tetap,kontrak,luar_biasa,pensiun',
            'pendidikan_terakhir' => 'required|in:S1,S2,S3',
            'jabatan_fungsional' => 'required|max:50',
            'inpassing' => 'required|max:50',
            'kepangkatan' => 'required|max:50',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('dosen-photos', 'public');
        }

        $dosen = Dosen::create($validated);

        // Create user account for lecturer
        User::create([
            'name' => $dosen->nama,
            'email' => $dosen->email,
            'password' => Hash::make('password123'),
            'role' => 'dosen',
            'dosen_id' => $dosen->id,
            'status' => 'active',
        ]);

        return redirect()->route('admin.dosens.index')
            ->with('success', 'Data dosen berhasil ditambahkan. Password default: password123');
    }

    public function show(Dosen $dosen)
    {
        $dosen->load(['pengajarans.academicPeriod', 'risets', 'pkms', 'bimbingans', 'pelatihans']);

        $stats = [
            'total_pengajaran' => $dosen->pengajarans->count(),
            'total_sks' => $dosen->pengajarans->sum('sks'),
            'total_riset' => $dosen->risets->count(),
            'total_pkm' => $dosen->pkms->count(),
            'total_bimbingan' => $dosen->bimbingans->count(),
            'total_pelatihan' => $dosen->pelatihans->count(),
        ];

        return view('admin.dosens.show', compact('dosen', 'stats'));
    }

    public function edit(Dosen $dosen)
    {
        return view('admin.dosens.edit', compact('dosen'));
    }

    public function update(Request $request, Dosen $dosen)
    {
        $validated = $request->validate([
            'nidn' => 'required|max:20|unique:dosens,nidn,' . $dosen->id,
            'nik' => 'required|max:20|unique:dosens,nik,' . $dosen->id,
            'nama' => 'required|max:100',
            'email' => 'required|email|unique:dosens,email,' . $dosen->id,
            'status' => 'required|in:tetap,kontrak,luar_biasa,pensiun',
            'pendidikan_terakhir' => 'required|in:S1,S2,S3',
            'jabatan_fungsional' => 'required|max:50',
            'inpassing' => 'required|max:50',
            'kepangkatan' => 'required|max:50',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($dosen->photo) {
                Storage::disk('public')->delete($dosen->photo);
            }
            $validated['photo'] = $request->file('photo')->store('dosen-photos', 'public');
        }

        $dosen->update($validated);

        // Update user account
        if ($dosen->user) {
            $dosen->user->update([
                'name' => $dosen->nama,
                'email' => $dosen->email,
            ]);
        }

        return redirect()->route('admin.dosens.index')
            ->with('success', 'Data dosen berhasil diupdate');
    }

    public function destroy(Dosen $dosen)
    {
        if ($dosen->photo) {
            Storage::disk('public')->delete($dosen->photo);
        }

        if ($dosen->user) {
            $dosen->user->delete();
        }

        $dosen->delete();

        return redirect()->route('admin.dosens.index')
            ->with('success', 'Data dosen berhasil dihapus');
    }
}
