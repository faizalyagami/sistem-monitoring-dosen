<?php

namespace Database\Seeders;

use App\Models\Pelatihan;
use App\Models\Dosen;
use App\Models\AcademicPeriod;
use Illuminate\Database\Seeder;

class PelatihanSeeder extends Seeder
{
    public function run(): void
    {
        $dosens = Dosen::all();
        $periods = AcademicPeriod::all();

        $pelatihans = [];

        $namaPelatihan = [
            'Pelatihan Cognitive Behavioral Therapy (CBT)',
            'Workshop Penyusunan Alat Ukur Psikologi',
            'Pelatihan Konseling Online',
            'Workshop Penulisan Jurnal Psikologi',
            'Pelatihan Asesmen Psikologi Anak',
            'Workshop Psikologi Industri dan Organisasi',
            'Pelatihan Mindfulness untuk Praktisi Klinis',
            'Workshop Psikologi Pendidikan Terkini',
            'Pelatihan Intervensi Psikososial',
            'Sertifikasi Konselor Profesional',
        ];

        $penyelenggara = [
            'Himpunan Psikologi Indonesia (HIMPSI)',
            'Ikatan Psikolog Klinis Indonesia',
            'Asosiasi Psikologi Pendidikan Indonesia',
            'Fakultas Psikologi Unisba',
            'Lembaga Sertifikasi Psikologi',
            'Kementerian Pendidikan',
        ];

        $lokasi = ['Bandung', 'Jakarta', 'Online', 'Yogyakarta', 'Semarang'];

        foreach ($dosens as $dosen) {
            $jumlahPelatihan = rand(1, 3);
            for ($i = 0; $i < $jumlahPelatihan; $i++) {
                $pelatihans[] = [
                    'dosen_id' => $dosen->id,
                    'academic_period_id' => $periods->where('is_active', true)->first()->id,
                    'nama_pelatihan' => $namaPelatihan[array_rand($namaPelatihan)],
                    'penyelenggara' => $penyelenggara[array_rand($penyelenggara)],
                    'tanggal_pelatihan' => now()->subMonths(rand(1, 12)),
                    'lokasi' => $lokasi[array_rand($lokasi)],
                    'tahun' => 2024,
                    'durasi' => [8, 16, 24, 32, 40][array_rand([8, 16, 24, 32, 40])],
                    'file_sertifikat' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        foreach (array_chunk($pelatihans, 50) as $chunk) {
            Pelatihan::insert($chunk);
        }
    }
}
