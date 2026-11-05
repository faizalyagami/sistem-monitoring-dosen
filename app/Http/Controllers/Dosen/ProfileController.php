<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $dosen = $user->dosen;
        return view('dosen.profile', compact('user', 'dosen'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) $user->password = Hash::make($request->password);
        $user->save();

        if ($request->hasFile('photo')) {
            $dosen = $user->dosen;
            if ($dosen) {
                if ($dosen->photo) Storage::disk('public')->delete($dosen->photo);
                $dosen->photo = $request->file('photo')->store('dosen-photos', 'public');
                $dosen->save();
            }
        }
        return redirect()->route('dosen.profile')->with('success', 'Profile berhasil diupdate');
    }
}
