<?php
// database/seeders/UserSeeder.php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Dosen;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Admin (bukan superadmin)
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@unisba.ac.id',
            'password' => Hash::make('password123'),
            'role' => 'admin',  // Ganti dari 'superadmin' ke 'admin'
            'status' => 'active',
            'dosen_id' => null,
        ]);

        // Optional: Buat admin kedua
        User::create([
            'name' => 'Admin Operator',
            'email' => 'operator@unisba.ac.id',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'status' => 'active',
            'dosen_id' => null,
        ]);

        // 2. Buat akun untuk setiap dosen (1 dosen = 1 user)
        $dosens = Dosen::all();

        foreach ($dosens as $dosen) {
            // Cek apakah user sudah ada
            if (!User::where('email', $dosen->email)->exists()) {
                User::create([
                    'name' => $dosen->nama,
                    'email' => $dosen->email,
                    'password' => Hash::make('password123'),
                    'role' => 'dosen',
                    'status' => 'active',
                    'dosen_id' => $dosen->id,
                ]);
            }
        }
    }
}
