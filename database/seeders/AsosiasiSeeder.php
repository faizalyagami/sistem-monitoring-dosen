<?php

namespace Database\Seeders;

use App\Models\Asosiasi;
use App\Models\Dosen;
use App\Models\AcademicPeriod;
use Illuminate\Database\Seeder;

class AsosiasiSeeder extends Seeder
{
    public function run(): void
    {
        $dosens = Dosen::all();
        $periods = AcademicPeriod::all();

        $asosiasis = [];

        $namaAsosiasi = [
            'Himpunan Psikologi Indonesia (HIMPSI)',
            'Ikatan Psikolog Klinis Indonesia',
            'Asosiasi Psikologi Pendidikan Indonesia',
            'Perhimpunan Psikologi Sosial Indonesia',
            'Asosiasi Psikologi Industri dan Organisasi',
            'Ikatan Psikologi Perkembangan Indonesia',
            'Forum Psikologi Forensik Indonesia',
            'Asosiasi Praktisi Psikologi',
        ];

        $peran = [
            'Ketua',
            'Sekretaris',
            'Bendahara',
            'Anggota Aktif',
            'Pengurus Harian',
            'Koordinator Bidang',
            'Anggota Biasa',
            'Ketua Divisi'
        ];

        $activePeriod = $periods->where('is_active', true)->first();

        foreach ($dosens as $dosen) {
            $asosiasis[] = [
                'dosen_id' => $dosen->id,
                'academic_period_id' => $activePeriod->id,
                'nama_asosiasi' => $namaAsosiasi[array_rand($namaAsosiasi)],
                'peran' => $peran[array_rand($peran)],
                'masa_aktif' => now()->addMonths(rand(12, 36)),
                'tahun' => 2024,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Asosiasi::insert($asosiasis);
    }
}
