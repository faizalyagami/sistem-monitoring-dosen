<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\AcademicPeriod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BimbinganSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil data dosen dan periode akademik
        $dosens = Dosen::all();
        $activePeriod = AcademicPeriod::where('is_active', true)->first();
        $closedPeriods = AcademicPeriod::where('is_closed', true)->take(2)->get();

        if ($dosens->isEmpty()) {
            $this->command->info('Tidak ada data dosen, lewati seeding Bimbingan');
            return;
        }

        $bimbingans = [];

        $jenisBimbingan = ['skripsi', 'tesis', 'disertasi'];
        $kategoriBimbingan = ['Pembimbing Utama', 'Pembimbing Pendamping', 'Koordinator', 'Penguji'];

        // 1. Data bimbingan untuk periode AKTIF
        if ($activePeriod) {
            foreach ($dosens as $dosen) {
                // Setiap dosen membimbing 2-8 mahasiswa
                $jumlahMahasiswa = rand(2, 8);

                $bimbingans[] = [
                    'dosen_id' => $dosen->id,
                    'academic_period_id' => $activePeriod->id,
                    'jenis_bimbingan' => $jenisBimbingan[array_rand($jenisBimbingan)],
                    'kategori_bimbingan' => $kategoriBimbingan[array_rand($kategoriBimbingan)],
                    'jumlah_mahasiswa' => $jumlahMahasiswa,
                    'semester' => $activePeriod->semester,
                    'tahun_akademik' => $activePeriod->tahun_awal,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // 2. Data bimbingan untuk periode LALU
        foreach ($closedPeriods as $period) {
            $ambilDosen = $dosens->take(8);
            foreach ($ambilDosen as $dosen) {
                $bimbingans[] = [
                    'dosen_id' => $dosen->id,
                    'academic_period_id' => $period->id,
                    'jenis_bimbingan' => $jenisBimbingan[array_rand($jenisBimbingan)],
                    'kategori_bimbingan' => $kategoriBimbingan[array_rand($kategoriBimbingan)],
                    'jumlah_mahasiswa' => rand(3, 10),
                    'semester' => $period->semester,
                    'tahun_akademik' => $period->tahun_awal,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert data
        if (!empty($bimbingans)) {
            foreach (array_chunk($bimbingans, 50) as $chunk) {
                DB::table('bimbingans')->insert($chunk);
            }
            $this->command->info(count($bimbingans) . ' data bimbingan berhasil ditambahkan');
        } else {
            $this->command->info('Tidak ada data bimbingan yang ditambahkan');
        }
    }
}
