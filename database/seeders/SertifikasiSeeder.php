<?php

namespace Database\Seeders;

use App\Models\Sertifikasi;
use App\Models\Dosen;
use App\Models\AcademicPeriod;
use Illuminate\Database\Seeder;

class SertifikasiSeeder extends Seeder
{
    public function run(): void
    {
        $dosens = Dosen::all();
        $periods = AcademicPeriod::all();

        $sertifikasis = [];

        $jenisSertifikasi = [
            'Sertifikasi Psikolog Klinis',
            'Sertifikasi Konselor Profesional',
            'Sertifikasi Tes Psikologi',
            'Sertifikasi CBT Practitioner',
            'Sertifikasi Konseling Online',
            'Sertifikasi Asesmen Anak',
            'Sertifikasi Psikologi Industri',
            'TOEFL (Test of English as a Foreign Language)',
        ];

        $lembagaSertifikasi = [
            'HIMPSI',
            'Ikatan Psikolog Klinis',
            'BNSP',
            'LSP Psikologi',
            'Lembaga Sertifikasi Profesi',
            'Universitas Indonesia',
            'Cambridge',
        ];

        $activePeriod = $periods->where('is_active', true)->first();

        foreach ($dosens as $dosen) {
            $jumlahSertifikasi = rand(1, 2);
            for ($i = 0; $i < $jumlahSertifikasi; $i++) {
                $tanggalTerbit = now()->subYears(rand(1, 4));
                $validUntil = (clone $tanggalTerbit)->addYears(rand(2, 5));

                $sertifikasis[] = [
                    'dosen_id' => $dosen->id,
                    'academic_period_id' => $activePeriod->id,
                    'jenis_sertifikasi' => $jenisSertifikasi[array_rand($jenisSertifikasi)],
                    'lembaga_sertifikasi' => $lembagaSertifikasi[array_rand($lembagaSertifikasi)],
                    'nomor_sertifikasi' => 'SERTIF-' . strtoupper(substr($dosen->nama, 0, 2)) . rand(10000, 99999),
                    'tanggal_sertifikasi' => $tanggalTerbit,
                    'valid_until' => $validUntil,
                    'file_sertifikat' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        foreach (array_chunk($sertifikasis, 50) as $chunk) {
            Sertifikasi::insert($chunk);
        }
    }
}
