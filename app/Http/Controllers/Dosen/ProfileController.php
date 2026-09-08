<?php
// app/Http/Controllers/Dosen/ProfileController.php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Show profile edit form
     */
    public function edit()
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        return view('dosen.profile', compact('user', 'dosen'));
    }

    /**
     * Update profile (including password)
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];

        // Jika password diisi, validasi password
        if ($request->filled('password')) {
            $rules['current_password'] = 'required';
            $rules['password'] = 'required|min:6|confirmed';
        }

        $request->validate($rules);

        // Cek password saat ini jika akan mengganti password
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()
                    ->with('error', 'Password saat ini salah')
                    ->withInput();
            }
            $user->password = Hash::make($request->password);
        }

        // Update user data
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        // Update dosen photo if uploaded
        if ($request->hasFile('photo')) {
            $dosen = $user->dosen;
            if ($dosen) {
                // Delete old photo
                if ($dosen->photo) {
                    Storage::disk('public')->delete($dosen->photo);
                }
                // Upload new photo
                $photoPath = $request->file('photo')->store('dosen-photos', 'public');
                $dosen->photo = $photoPath;
                $dosen->save();
            }
        }

        return redirect()->route('dosen.profile')
            ->with('success', 'Profile berhasil diupdate');
    }
}
