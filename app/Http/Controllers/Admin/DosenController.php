<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\DosenImport;
use App\Models\Dosen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Dosen::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nidn', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter pendidikan
        if ($request->filled('pendidikan')) {
            $query->where('pendidikan_terakhir', $request->pendidikan);
        }

        $dosens = $query->latest()->paginate(10);

        return view('admin.dosens.index', compact('dosens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.dosens.create');
    }

    /**
     * Store a newly created resource in storage.
     */
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
            'password' => Hash::make($dosen->nik),
            'role' => 'dosen',
            'status' => 'active',
            'dosen_id' => $dosen->id,
        ]);

        return redirect()->route('admin.dosens.index')
            ->with('success', 'Data dosen berhasil ditambahkan. Password default: password123');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $dosen = Dosen::with(['pengajarans', 'risets', 'pkms', 'bimbingans', 'pelatihans', 'asosiasis', 'sertifikasis'])->findOrFail($id);

        $stats = [
            'total_pengajaran' => $dosen->pengajarans->count(),
            'total_sks' => $dosen->pengajarans->sum('sks'),
            'total_riset' => $dosen->risets->count(),
            'total_pkm' => $dosen->pkms->count(),
            'total_bimbingan' => $dosen->bimbingans->count(),
            'total_pelatihan' => $dosen->pelatihans->count(),
            'total_asosiasi' => $dosen->asosiasis->count(),
            'total_sertifikasi' => $dosen->sertifikasis->count()
        ];

        return view('admin.dosens.show', compact('dosen', 'stats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $dosen = Dosen::findOrFail($id);
        return view('admin.dosens.edit', compact('dosen'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $dosen = Dosen::findOrFail($id);

        $validated = $request->validate([
            'nidn' => 'required|max:20|unique:dosens,nidn,' . $id,
            'nik' => 'required|max:20|unique:dosens,nik,' . $id,
            'nama' => 'required|max:100',
            'email' => 'required|email|unique:dosens,email,' . $id,
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $dosen = Dosen::findOrFail($id);

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

    public function export()
    {
        // Will be implemented later
        return redirect()->back()->with('info', 'Fitur export sedang dalam pengembangan');
    }

    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template_import_dosen.csv"',
        ];

        $columns = [
            'nidn',
            'nik',
            'nama',
            'email',
            'status',
            'pendidikan_terakhir',
            'jabatan_fungsional',
            'inpassing',
            'kepangkatan',
            'bidang_keahlian',
        ];

        $sampleData = [
            '0010018601',
            '3273010010018601',
            'Dr. Ahmad Rizal, S.Psi., M.Psi., Psikolog',
            'ahmad.rizal@unisba.ac.id',
            'tetap',
            'S3',
            'Lektor Kepala',
            'IV/d',
            'Pembina Utama Muda',
            'Psikologi Klinis',
        ];

        $callback = function () use ($columns, $sampleData) {
            $file = fopen('php://output', 'w');

            // Header
            fputcsv($file, $columns);

            // Sample row
            fputcsv($file, $sampleData);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Import data dosen dari Excel/CSV
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:5120',
        ]);

        try {
            $import = new DosenImport();
            Excel::import($import, $request->file('file'));

            $successCount = $import->getSuccessCount();
            $failCount = $import->getFailCount();
            $errors = $import->getErrors();

            $message = "Berhasil import {$successCount} data dosen.";
            if ($failCount > 0) {
                $message .= " Gagal: {$failCount} data.";
            }

            if (!empty($errors)) {
                return redirect()->route('admin.dosens.index')
                    ->with('success', $message)
                    ->with('import_errors', $errors);
            }

            return redirect()->route('admin.dosens.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }
}
