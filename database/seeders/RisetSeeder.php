<?php

namespace Database\Seeders;

use App\Models\Riset;
use App\Models\Dosen;
use App\Models\AcademicPeriod;
use Illuminate\Database\Seeder;

class RisetSeeder extends Seeder
{
    public function run(): void
    {
        $dosens = Dosen::all();
        $periods = AcademicPeriod::all();

        $risets = [];

        $juduls = [
            'Pengembangan Sistem Informasi Akademik Berbasis Web',
            'Implementasi Machine Learning untuk Prediksi Prestasi Mahasiswa',
            'Analisis Big Data untuk Evaluasi Kinerja Dosen',
            'Pengembangan Aplikasi Mobile Learning',
            'Sistem Pakar Diagnosa Penyakit Berbasis AI',
            'Keamanan Data pada Cloud Computing',
            'Optimasi Jaringan Sensor Nirkabel',
            'Pengolahan Citra Digital untuk Deteksi Objek',
            'Sistem Rekomendasi Jurusan Berdasarkan Minat',
            'Blockchain untuk Verifikasi Ijazah Digital',
        ];

        $bidangs = [
            'Sistem Informasi',
            'Kecerdasan Buatan',
            'Data Mining',
            'Jaringan Komputer',
            'Keamanan Cyber',
            'Multimedia'
        ];

        $jenis = ['Penelitian Dasar', 'Penelitian Terapan', 'Pengembangan'];
        $sumber_dana = ['DIKTI', 'Kementerian Riset', 'Industri', 'Internal Universitas'];

        // Riset untuk periode aktif
        $activePeriod = $periods->where('is_active', true)->first();

        foreach ($dosens as $dosen) {
            // Setiap dosen punya 1-3 riset aktif
            $jumlahRiset = rand(1, 3);
            for ($i = 0; $i < $jumlahRiset; $i++) {
                $risets[] = [
                    'dosen_id' => $dosen->id,
                    'academic_period_id' => $activePeriod->id,
                    'judul_riset' => $juduls[array_rand($juduls)] . ' ' . ($i + 1),
                    'bidang_riset' => $bidangs[array_rand($bidangs)],
                    'jenis_riset' => $jenis[array_rand($jenis)],
                    'sumber_dana' => $sumber_dana[array_rand($sumber_dana)],
                    'jumlah_dana' => rand(5000000, 50000000),
                    'status' => 'aktif',
                    'tahun' => 2024,
                    'kolaborator' => 'Kolaborator ' . rand(1, 3),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Riset selesai untuk periode lalu
        $oldPeriods = $periods->where('is_active', false)->take(3);

        foreach ($oldPeriods as $period) {
            foreach ($dosens->take(7) as $dosen) {
                $risets[] = [
                    'dosen_id' => $dosen->id,
                    'academic_period_id' => $period->id,
                    'judul_riset' => $juduls[array_rand($juduls)] . ' (Tahun ' . $period->tahun_awal . ')',
                    'bidang_riset' => $bidangs[array_rand($bidangs)],
                    'jenis_riset' => $jenis[array_rand($jenis)],
                    'sumber_dana' => $sumber_dana[array_rand($sumber_dana)],
                    'jumlah_dana' => rand(10000000, 100000000),
                    'status' => 'selesai',
                    'tahun' => $period->tahun_awal,
                    'publikasi_link' => 'https://doi.org/10.1234/riset.' . rand(1000, 9999),
                    'kolaborator' => 'Kolaborator ' . rand(1, 5),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        foreach (array_chunk($risets, 50) as $chunk) {
            Riset::insert($chunk);
        }
    }
}
