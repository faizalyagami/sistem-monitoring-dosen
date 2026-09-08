<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\AcademicPeriod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PkmSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil data dosen dan periode akademik
        $dosens = Dosen::all();
        $activePeriod = AcademicPeriod::where('is_active', true)->first();
        $closedPeriods = AcademicPeriod::where('is_closed', true)->take(2)->get();

        if ($dosens->isEmpty()) {
            $this->command->info('Tidak ada data dosen, lewati seeding PKM');
            return;
        }

        $pkms = [];

        // Data PKM
        $judulPkm = [
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
            'Program Kampus Mengajar',
            'Kuliah Kerja Nyata Tematik',
        ];

        $bidang = ['Ekonomi', 'Pendidikan', 'Kesehatan', 'Lingkungan', 'Teknologi', 'Sosial'];
        $jenis = ['Pengabdian', 'Pelatihan', 'Penyuluhan', 'Pendampingan', 'Konsultasi'];
        $lokasi = ['Jakarta', 'Bandung', 'Surabaya', 'Medan', 'Semarang', 'Yogyakarta', 'Malang', 'Makassar'];
        $sumberDana = ['DIKTI', 'LPPM', 'CSR Perusahaan', 'Internal Universitas', 'Pemerintah Daerah'];

        // 1. Data PKM AKTIF untuk periode berjalan
        if ($activePeriod) {
            foreach ($dosens as $dosen) {
                // Setiap dosen punya 1-2 PKM aktif
                $jumlah = rand(1, 2);
                for ($i = 0; $i < $jumlah; $i++) {
                    $pkms[] = [
                        'dosen_id' => $dosen->id,
                        'academic_period_id' => $activePeriod->id,
                        'judul_pkm' => $judulPkm[array_rand($judulPkm)] . ' ' . ($i + 1),
                        'bidang_pkm' => $bidang[array_rand($bidang)],
                        'jenis_pkm' => $jenis[array_rand($jenis)],
                        'sumber_dana' => $sumberDana[array_rand($sumberDana)],
                        'jumlah_dana' => rand(5000000, 50000000),
                        'lokasi_kegiatan' => $lokasi[array_rand($lokasi)],
                        'status' => 'aktif',
                        'tahun' => date('Y'),
                        'publikasi_link' => null,
                        'file_laporan' => null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        // 2. Data PKM SELESAI untuk periode lalu
        foreach ($closedPeriods as $period) {
            $ambilDosen = $dosens->take(7);
            foreach ($ambilDosen as $dosen) {
                $pkms[] = [
                    'dosen_id' => $dosen->id,
                    'academic_period_id' => $period->id,
                    'judul_pkm' => $judulPkm[array_rand($judulPkm)],
                    'bidang_pkm' => $bidang[array_rand($bidang)],
                    'jenis_pkm' => $jenis[array_rand($jenis)],
                    'sumber_dana' => $sumberDana[array_rand($sumberDana)],
                    'jumlah_dana' => rand(10000000, 75000000),
                    'lokasi_kegiatan' => $lokasi[array_rand($lokasi)],
                    'status' => 'selesai',
                    'tahun' => $period->tahun_awal,
                    'publikasi_link' => 'https://pkm.ac.id/laporan/' . rand(1000, 9999),
                    'file_laporan' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert data
        if (!empty($pkms)) {
            foreach (array_chunk($pkms, 50) as $chunk) {
                DB::table('table_pkms')->insert($chunk);
            }
            $this->command->info(count($pkms) . ' data PKM berhasil ditambahkan');
        } else {
            $this->command->info('Tidak ada data PKM yang ditambahkan');
        }
    }
}
