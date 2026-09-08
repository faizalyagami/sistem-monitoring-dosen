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

        // Judul Penelitian Psikologi
        $juduls = [
            'Pengaruh Media Sosial terhadap Kesehatan Mental Remaja',
            'Efektivitas Cognitive Behavioral Therapy untuk Mengatasi Kecemasan',
            'Hubungan antara Stres Kerja dan Burnout pada Karyawan',
            'Peran Dukungan Sosial dalam Meningkatkan Resiliensi',
            'Faktor-faktor yang Mempengaruhi Kesejahteraan Psikologis Mahasiswa',
            'Pengembangan Alat Ukur Kecerdasan Emosional',
            'Intervensi Mindfulness untuk Mengurangi Stres Akademik',
            'Dinamika Psikologis Korban Bullying di Sekolah',
            'Pola Asuh Orang Tua dan Perkembangan Moral Anak',
            'Pengaruh Pelatihan Keterampilan Sosial terhadap Interaksi Sosial',
        ];

        $bidangs = [
            'Psikologi Klinis',
            'Psikologi Pendidikan',
            'Psikologi Industri',
            'Psikologi Perkembangan',
            'Psikologi Sosial',
            'Psikometri'
        ];

        $jenis = ['Penelitian Dasar', 'Penelitian Terapan', 'Pengembangan Alat Ukur'];
        $sumber_dana = ['DIKTI', 'Kementerian Riset', 'Hibah Internal', 'LPPM Unisba'];

        // Riset untuk periode aktif
        $activePeriod = $periods->where('is_active', true)->first();

        if ($activePeriod) {
            foreach ($dosens as $dosen) {
                $jumlahRiset = rand(1, 2);
                for ($i = 0; $i < $jumlahRiset; $i++) {
                    $risets[] = [
                        'dosen_id' => $dosen->id,
                        'academic_period_id' => $activePeriod->id,
                        'judul_riset' => $juduls[array_rand($juduls)] . ' (' . ($i + 1) . ')',
                        'bidang_riset' => $bidangs[array_rand($bidangs)],
                        'jenis_riset' => $jenis[array_rand($jenis)],
                        'sumber_dana' => $sumber_dana[array_rand($sumber_dana)],
                        'jumlah_dana' => rand(10000000, 75000000),
                        'status' => 'aktif',
                        'publikasi_link' => null,
                        'kolaborator' => 'Kolaborator ' . rand(1, 3),
                        'file_laporan' => null,
                        'tahun' => 2024,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        foreach (array_chunk($risets, 50) as $chunk) {
            Riset::insert($chunk);
        }
    }
}
