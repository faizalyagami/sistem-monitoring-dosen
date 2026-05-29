<?php
// database/seeders/AcademicPeriodSeeder.php

namespace Database\Seeders;

use App\Models\AcademicPeriod;
use Illuminate\Database\Seeder;

class AcademicPeriodSeeder extends Seeder
{
    public function run(): void
    {
        $periods = [
            [
                'nama_periode' => 'Semester Ganjil 2022/2023',
                'semester' => 'ganjil',
                'tahun_awal' => 2022,
                'tahun_akhir' => 2023,
                'tanggal_mulai' => '2022-08-01',
                'tanggal_selesai' => '2022-12-31',
                'is_active' => false,
                'is_closed' => true,
                'keterangan' => 'Periode sudah selesai',
                // HAPUS 'kode_periode' dan 'urutan' - akan diisi otomatis oleh model
            ],
            [
                'nama_periode' => 'Semester Genap 2022/2023',
                'semester' => 'genap',
                'tahun_awal' => 2022,
                'tahun_akhir' => 2023,
                'tanggal_mulai' => '2023-02-01',
                'tanggal_selesai' => '2023-06-30',
                'is_active' => false,
                'is_closed' => true,
                'keterangan' => 'Periode sudah selesai',
            ],
            [
                'nama_periode' => 'Semester Ganjil 2023/2024',
                'semester' => 'ganjil',
                'tahun_awal' => 2023,
                'tahun_akhir' => 2024,
                'tanggal_mulai' => '2023-08-01',
                'tanggal_selesai' => '2023-12-31',
                'is_active' => false,
                'is_closed' => true,
                'keterangan' => 'Periode sudah selesai',
            ],
            [
                'nama_periode' => 'Semester Genap 2023/2024',
                'semester' => 'genap',
                'tahun_awal' => 2023,
                'tahun_akhir' => 2024,
                'tanggal_mulai' => '2024-02-01',
                'tanggal_selesai' => '2024-06-30',
                'is_active' => false,
                'is_closed' => true,
                'keterangan' => 'Periode sudah selesai',
            ],
            [
                'nama_periode' => 'Semester Ganjil 2024/2025',
                'semester' => 'ganjil',
                'tahun_awal' => 2024,
                'tahun_akhir' => 2025,
                'tanggal_mulai' => '2024-08-01',
                'tanggal_selesai' => '2024-12-31',
                'is_active' => true,
                'is_closed' => false,
                'keterangan' => 'Periode sedang berjalan',
            ],
            [
                'nama_periode' => 'Semester Genap 2024/2025',
                'semester' => 'genap',
                'tahun_awal' => 2024,
                'tahun_akhir' => 2025,
                'tanggal_mulai' => '2025-02-01',
                'tanggal_selesai' => '2025-06-30',
                'is_active' => false,
                'is_closed' => false,
                'keterangan' => 'Periode mendatang',
            ],
        ];

        foreach ($periods as $period) {
            AcademicPeriod::create($period);
        }
    }
}
