<?php

namespace Database\Seeders;

use App\Models\Pkm;
use App\Models\Dosen;
use App\Models\AcademicPeriod;
use Illuminate\Database\Seeder;

class PkmSeeder extends Seeder
{
    public function run(): void
    {
        $dosens = Dosen::all();
        $periods = AcademicPeriod::all();

        $pkms = [];

        // Judul PKM Psikologi
        $juduls = [
            'Pendampingan Psikologis Korban Bencana Alam',
            'Pelatihan Kesehatan Mental bagi Remaja',
            'Sosialisasi Bahaya Bullying di Sekolah',
            'Program Parenting untuk Meningkatkan Pola Asuh Positif',
            'Pelatihan Manajemen Stres bagi Karyawan UMKM',
            'Penyuluhan Kesehatan Mental di Tempat Kerja',
            'Pendampingan Anak Berkebutuhan Khusus',
            'Program Peningkatan Resiliensi pada Remaja',
            'Pelatihan Keterampilan Konseling Dasar untuk Guru',
            'Sosialisasi Pentingnya Kesehatan Mental Remaja',
        ];

        $bidangs = ['Psikologi Klinis', 'Psikologi Pendidikan', 'Psikologi Industri', 'Psikologi Sosial'];
        $jenis = ['Pendampingan', 'Pelatihan', 'Penyuluhan', 'Konsultasi'];
        $lokasis = ['Bandung', 'Cimahi', 'Kab Bandung', 'Garut', 'Sumedang', 'Jakarta'];
        $sumber_dana = ['DIKTI', 'LPPM Unisba', 'CSR', 'Hibah Internal'];

        // PKM untuk periode aktif
        $activePeriod = $periods->where('is_active', true)->first();

        if ($activePeriod) {
            foreach ($dosens as $dosen) {
                $jumlahPkm = rand(1, 2);
                for ($i = 0; $i < $jumlahPkm; $i++) {
                    $pkms[] = [
                        'dosen_id' => $dosen->id,
                        'academic_period_id' => $activePeriod->id,
                        'judul_pkm' => $juduls[array_rand($juduls)],
                        'bidang_pkm' => $bidangs[array_rand($bidangs)],
                        'jenis_pkm' => $jenis[array_rand($jenis)],
                        'sumber_dana' => $sumber_dana[array_rand($sumber_dana)],
                        'jumlah_dana' => rand(5000000, 30000000),
                        'lokasi_kegiatan' => $lokasis[array_rand($lokasis)],
                        'status' => 'aktif',
                        'tahun' => 2024,
                        'publikasi_link' => null,
                        'file_laporan' => null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        foreach (array_chunk($pkms, 50) as $chunk) {
            Pkm::insert($chunk);
        }
    }
}
