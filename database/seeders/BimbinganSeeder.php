<?php

namespace Database\Seeders;

use App\Models\Bimbingan;
use App\Models\Dosen;
use App\Models\AcademicPeriod;
use Illuminate\Database\Seeder;

class BimbinganSeeder extends Seeder
{
    public function run(): void
    {
        $dosens = Dosen::all();
        $periods = AcademicPeriod::all();

        $bimbingans = [];
        $jenis_bimbingan = ['skripsi', 'tesis', 'disertasi'];
        $kategori = ['Pembimbing Utama', 'Pembimbing Pendamping', 'Koordinator'];

        $activePeriod = $periods->where('is_active', true)->first();

        if ($activePeriod) {
            foreach ($dosens as $dosen) {
                $jumlah = rand(3, 8);

                $bimbingans[] = [
                    'dosen_id' => $dosen->id,
                    'academic_period_id' => $activePeriod->id,
                    'jenis_bimbingan' => $jenis_bimbingan[array_rand($jenis_bimbingan)],
                    'kategori_bimbingan' => $kategori[array_rand($kategori)],
                    'jumlah_mahasiswa' => $jumlah,
                    'semester' => 'ganjil',
                    'tahun_akademik' => 2024,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        Bimbingan::insert($bimbingans);
    }
}
