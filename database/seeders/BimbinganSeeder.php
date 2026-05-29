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

        foreach ($dosens as $dosen) {
            // Setiap dosen bimbing 3-10 mahasiswa
            $jumlah = rand(3, 10);

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

        // Bimbingan periode lalu
        $oldPeriods = $periods->where('is_active', false)->take(2);

        foreach ($oldPeriods as $period) {
            foreach ($dosens->take(8) as $dosen) {
                $bimbingans[] = [
                    'dosen_id' => $dosen->id,
                    'academic_period_id' => $period->id,
                    'jenis_bimbingan' => $jenis_bimbingan[array_rand($jenis_bimbingan)],
                    'kategori_bimbingan' => $kategori[array_rand($kategori)],
                    'jumlah_mahasiswa' => rand(2, 8),
                    'semester' => $period->semester,
                    'tahun_akademik' => $period->tahun_awal,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        Bimbingan::insert($bimbingans);
    }
}
