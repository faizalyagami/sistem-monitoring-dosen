<?php

namespace Database\Seeders;

use App\Models\Sipp;
use App\Models\Dosen;
use Illuminate\Database\Seeder;

class SippSeeder extends Seeder
{
    public function run(): void
    {
        $dosens = Dosen::all();

        if ($dosens->isEmpty()) {
            $this->command->info('Tidak ada data dosen, lewati seeding SIPP');
            return;
        }

        $sipps = [];

        $bidangKeilmuan = [
            'Psikologi Klinis',
            'Psikologi Pendidikan',
            'Psikologi Industri dan Organisasi',
            'Psikologi Perkembangan',
            'Psikologi Sosial',
            'Psikologi Kognitif',
        ];

        $penerbit = [
            'Himpunan Psikologi Indonesia (HIMPSI)',
            'Ikatan Psikolog Klinis Indonesia',
            'Asosiasi Psikologi Pendidikan Indonesia',
            'Kementerian Kesehatan RI',
        ];

        foreach ($dosens as $dosen) {
            // Dosen Psikologi memiliki SIPP
            if (rand(0, 1) == 1 || str_contains(strtolower($dosen->bidang_keilmuan ?? ''), 'psikologi')) {
                $tanggalTerbit = now()->subYears(rand(0, 5));
                $tanggalKadaluarsa = (clone $tanggalTerbit)->addYears(5);
                $status = now() > $tanggalKadaluarsa ? 'kadaluarsa' : 'aktif';

                $sipps[] = [
                    'dosen_id' => $dosen->id,
                    'no_registrasi' => 'SIPP-' . strtoupper(substr($dosen->nama, 0, 3)) . rand(1000, 9999),
                    'bidang_keilmuan' => $bidangKeilmuan[array_rand($bidangKeilmuan)],
                    'tahun_terbit' => $tanggalTerbit->year,
                    'penerbit' => $penerbit[array_rand($penerbit)],
                    'file_sipp' => null,
                    'status' => $status,
                    'tanggal_terbit' => $tanggalTerbit,
                    'tanggal_kadaluarsa' => $tanggalKadaluarsa,
                    'keterangan' => 'Surat Izin Praktik Psikologi untuk praktik ' . $bidangKeilmuan[array_rand($bidangKeilmuan)],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        if (!empty($sipps)) {
            Sipp::insert($sipps);
        }

        $this->command->info(count($sipps) . ' data SIPP (Surat Izin Praktik Psikologi) berhasil ditambahkan');
    }
}
