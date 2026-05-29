<?php

namespace Database\Seeders;

use App\Models\Evaluasi;
use App\Models\Dosen;
use App\Models\AcademicPeriod;
use Illuminate\Database\Seeder;

class EvaluasiSeeder extends Seeder
{
    public function run(): void
    {
        $dosens = Dosen::all();
        $periods = AcademicPeriod::where('is_closed', true)->get();

        $evaluasis = [];

        $jenis_evaluasi = ['Kinerja Mengajar', 'Penelitian', 'Pengabdian', 'Kinerja Umum'];
        $kategori = ['Sangat Baik', 'Baik', 'Cukup', 'Kurang'];

        foreach ($periods as $period) {
            foreach ($dosens as $dosen) {
                $nilai = rand(70, 98) / 10; // 7.0 - 9.8
                $status = $nilai >= 8.0 ? 'memenuhi' : 'belum_memenuhi';

                $evaluasis[] = [
                    'dosen_id' => $dosen->id,
                    'academic_period_id' => $period->id,
                    'jenis_evaluasi' => $jenis_evaluasi[array_rand($jenis_evaluasi)],
                    'kategori_evaluasi' => $kategori[array_rand($kategori)],
                    'nama_evaluasi' => 'Evaluasi Kinerja ' . $period->nama_periode,
                    'nilai_evaluasi' => $nilai,
                    'status' => $status,
                    'komentar' => $nilai >= 8.0 ? 'Kinerja sangat baik, pertahankan!' : 'Perlu peningkatan dalam beberapa aspek',
                    'tahun' => $period->tahun_awal,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        foreach (array_chunk($evaluasis, 50) as $chunk) {
            Evaluasi::insert($chunk);
        }
    }
}
