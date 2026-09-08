<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\AcademicPeriod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RisetSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil data dosen dan periode akademik
        $dosens = Dosen::all();
        $activePeriod = AcademicPeriod::where('is_active', true)->first();
        $closedPeriods = AcademicPeriod::where('is_closed', true)->take(2)->get();

        if ($dosens->isEmpty()) {
            $this->command->info('Tidak ada data dosen, lewati seeding Riset');
            return;
        }

        $risets = [];

        // Data penelitian untuk periode aktif
        $judulAktif = [
            'Pengembangan Sistem Informasi Akademik Berbasis Web',
            'Implementasi Machine Learning untuk Prediksi Prestasi Mahasiswa',
            'Analisis Big Data untuk Evaluasi Kinerja Dosen',
            'Pengembangan Aplikasi Mobile Learning',
            'Sistem Pakar Diagnosa Penyakit Berbasis AI',
            'Keamanan Data pada Cloud Computing',
            'Optimasi Jaringan Sensor Nirkabel',
            'Pengolahan Citra Digital untuk Deteksi Objek',
        ];

        $bidang = ['Sistem Informasi', 'Kecerdasan Buatan', 'Data Mining', 'Jaringan Komputer', 'Keamanan Cyber'];
        $jenis = ['Penelitian Dasar', 'Penelitian Terapan', 'Pengembangan'];
        $sumberDana = ['DIKTI', 'Kementerian Riset', 'Industri', 'Internal Universitas'];

        // 1. Data penelitian AKTIF untuk periode berjalan
        if ($activePeriod) {
            foreach ($dosens as $dosen) {
                // Setiap dosen punya 1-3 penelitian aktif
                $jumlah = rand(1, 3);
                for ($i = 0; $i < $jumlah; $i++) {
                    $risets[] = [
                        'dosen_id' => $dosen->id,
                        'academic_period_id' => $activePeriod->id,
                        'judul_riset' => $judulAktif[array_rand($judulAktif)] . ' ' . ($i + 1),
                        'bidang_riset' => $bidang[array_rand($bidang)],
                        'jenis_riset' => $jenis[array_rand($jenis)],
                        'sumber_dana' => $sumberDana[array_rand($sumberDana)],
                        'jumlah_dana' => rand(10000000, 100000000),
                        'status' => 'aktif',
                        'publikasi_link' => null,
                        'kolaborator' => 'Kolaborator ' . rand(1, 4),
                        'file_laporan' => null,
                        'tahun' => date('Y'),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        // 2. Data penelitian SELESAI untuk periode lalu
        foreach ($closedPeriods as $period) {
            $ambilDosen = $dosens->take(7);
            foreach ($ambilDosen as $dosen) {
                $risets[] = [
                    'dosen_id' => $dosen->id,
                    'academic_period_id' => $period->id,
                    'judul_riset' => $judulAktif[array_rand($judulAktif)] . ' (Tahun ' . $period->tahun_awal . ')',
                    'bidang_riset' => $bidang[array_rand($bidang)],
                    'jenis_riset' => $jenis[array_rand($jenis)],
                    'sumber_dana' => $sumberDana[array_rand($sumberDana)],
                    'jumlah_dana' => rand(20000000, 150000000),
                    'status' => 'selesai',
                    'publikasi_link' => 'https://doi.org/10.1234/riset.' . rand(1000, 9999),
                    'kolaborator' => 'Kolaborator ' . rand(1, 5),
                    'file_laporan' => null,
                    'tahun' => $period->tahun_awal,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert data
        if (!empty($risets)) {
            foreach (array_chunk($risets, 50) as $chunk) {
                DB::table('table_risets')->insert($chunk);
            }
            $this->command->info(count($risets) . ' data penelitian berhasil ditambahkan');
        } else {
            $this->command->info('Tidak ada data penelitian yang ditambahkan');
        }
    }
}
