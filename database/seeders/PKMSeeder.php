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

        $juduls = [
            'Pelatihan Digital Marketing untuk UMKM',
            'Sosialisasi Bahaya Narkoba di Kalangan Remaja',
            'Pemberdayaan Masyarakat melalui Bank Sampah',
            'Pelatihan Keterampilan Menjahit untuk Ibu Rumah Tangga',
            'Penyuluhan Kesehatan Reproduksi Remaja',
            'Pengembangan Desa Wisata',
            'Pelatihan Pembuatan Pupuk Organik',
            'Sosialisasi Literasi Keuangan',
            'Pendampingan Legalitas Usaha UMKM',
            'Pelatihan English for Tourism',
        ];

        $bidangs = ['Ekonomi', 'Pendidikan', 'Kesehatan', 'Lingkungan', 'Teknologi'];
        $jenis = ['Pengabdian', 'Pelatihan', 'Penyuluhan', 'Pendampingan'];
        $lokasis = ['Jakarta', 'Bandung', 'Surabaya', 'Medan', 'Semarang', 'Yogyakarta'];
        $sumber_dana = ['DIKTI', 'LPPM', 'CSR Perusahaan', 'Internal'];

        // PKM untuk periode aktif
        $activePeriod = $periods->where('is_active', true)->first();

        foreach ($dosens as $dosen) {
            $jumlahPkm = rand(1, 2);
            for ($i = 0; $i < $jumlahPkm; $i++) {
                $pkms[] = [
                    'dosen_id' => $dosen->id,
                    'academic_period_id' => $activePeriod->id,
                    'judul_pkm' => $juduls[array_rand($juduls)] . ' ' . ($i + 1),
                    'bidang_pkm' => $bidangs[array_rand($bidangs)],
                    'jenis_pkm' => $jenis[array_rand($jenis)],
                    'sumber_dana' => $sumber_dana[array_rand($sumber_dana)],
                    'jumlah_dana' => rand(2000000, 20000000),
                    'lokasi_kegiatan' => $lokasis[array_rand($lokasis)],
                    'status' => 'aktif',
                    'tahun' => 2024,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // PKM selesai untuk periode lalu
        $oldPeriods = $periods->where('is_active', false)->take(3);

        foreach ($oldPeriods as $period) {
            foreach ($dosens->take(7) as $dosen) {
                $pkms[] = [
                    'dosen_id' => $dosen->id,
                    'academic_period_id' => $period->id,
                    'judul_pkm' => $juduls[array_rand($juduls)],
                    'bidang_pkm' => $bidangs[array_rand($bidangs)],
                    'jenis_pkm' => $jenis[array_rand($jenis)],
                    'sumber_dana' => $sumber_dana[array_rand($sumber_dana)],
                    'jumlah_dana' => rand(1000000, 15000000),
                    'lokasi_kegiatan' => $lokasis[array_rand($lokasis)],
                    'status' => 'selesai',
                    'tahun' => $period->tahun_awal,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        foreach (array_chunk($pkms, 50) as $chunk) {
            Pkm::insert($chunk);
        }
    }
}
