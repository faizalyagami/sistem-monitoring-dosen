<?php

namespace Database\Seeders;

use App\Models\Dosen;
use Illuminate\Database\Seeder;

class DosenSeeder extends Seeder
{
    public function run(): void
    {
        $dosens = [
            // Psikologi Pendidikan
            [
                'nidn' => '0430068103',
                'nik' => 'D060427',
                'nama' => 'Dr. Dewi Rosiana, M.Psi., Psikolog.',
                'email' => 'dewi.rosiana@unisba.ac.id',
                'photo' => null,
                'status' => 'tetap',
                'pendidikan_terakhir' => 'S3',
                'jabatan_fungsional' => 'Lektor Kepala',
                'inpassing' => 'III/d',
                'kepangkatan' => '-',
                'bidang_keahlian' => 'Psikologi Pendidikan',
            ],

            // Psikologi Islam, Klinis, dan Pendidikan
            [
                'nidn' => '0404117001',
                'nik' => 'D970266',
                'nama' => 'Dr. Eneng Nurlaili Wangi, M.Psi., Psikolog.',
                'email' => 'eneng.nurlailiwangi@unisba.ac.id',
                'photo' => null,
                'status' => 'tetap',
                'pendidikan_terakhir' => 'S3',
                'jabatan_fungsional' => 'Lektor Kepala',
                'inpassing' => 'III/d',
                'kepangkatan' => '-',
                'bidang_keahlian' => 'Psikologi Islam, Psikologi Klinis, Psikologi Pendidikan',
            ],

            // Psikologi Perkembangan
            [
                'nidn' => '0431056801',
                'nik' => 'D940199',
                'nama' => 'Dr. Ihsana Sabriani Borualogo, M.Si., Psikolog.',
                'email' => 'ihsana.sabriani@unisba.ac.id',
                'photo' => null,
                'status' => 'tetap',
                'pendidikan_terakhir' => 'S3',
                'jabatan_fungsional' => 'Lektor Kepala',
                'inpassing' => 'III/d',
                'kepangkatan' => '-',
                'bidang_keahlian' => 'Psikologi Perkembangan',
            ],

            // Psikologi Pendidikan dan Industri & Organisasi
            [
                'nidn' => '0416086502',
                'nik' => 'D940198',
                'nama' => 'Dr. Dewi Sartika, M.Si., Psikolog.',
                'email' => 'dewi.sartika@unisba.aca.id',
                'photo' => null,
                'status' => 'tetap',
                'pendidikan_terakhir' => 'S3',
                'jabatan_fungsional' => 'Lektor',
                'inpassing' => 'III/d',
                'kepangkatan' => '-',
                'bidang_keahlian' => 'Psikologi Pendidikan, Psikologi Industri & Organisasi (PIO)',
            ],

            // Psikologi Klinis
            [
                'nidn' => '0416016601',
                'nik' => 'D970265',
                'nama' => 'Dr. Endah Nawangsih., M.Psi., Psikolog.',
                'email' => 'endah.nawangsih@unisba.ac.id',
                'photo' => null,
                'status' => 'tetap',
                'pendidikan_terakhir' => 'S3',
                'jabatan_fungsional' => 'Lektor',
                'inpassing' => 'III/d',
                'kepangkatan' => '-',
                'bidang_keahlian' => 'Psikologi Klinis',
            ],

            [
                'nidn' => '0409108303',
                'nik' => 'D080472',
                'nama' => 'Dr. Fanni Putri Diantina, S.Psi., M.Psi., Psikolog.',
                'email' => 'fanni.putri@unisba.ac.id',
                'photo' => null,
                'status' => 'tetap',
                'pendidikan_terakhir' => 'S3',
                'jabatan_fungsional' => 'Lektor',
                'inpassing' => 'III/b',
                'kepangkatan' => '-',
                'bidang_keahlian' => 'Psikologi Klinis',
            ],

            // Psikologi Islam
            [
                'nidn' => '0406097005',
                'nik' => 'D040388',
                'nama' => 'Dr. Lilim Halimah, BHSc., MHSPY.',
                'email' => 'lilim.halimah@unisba.ac.id',
                'photo' => null,
                'status' => 'tetap',
                'pendidikan_terakhir' => 'S3',
                'jabatan_fungsional' => 'Lektor',
                'inpassing' => 'III/d',
                'kepangkatan' => '-',
                'bidang_keahlian' => 'Psikologi Islam',
            ],

            // Psikologi Klinis
            [
                'nidn' => '0428046303',
                'nik' => 'D930176',
                'nama' => 'Dr. Muhammad Ilmi Hatta, M.Psi., Psikolog.',
                'email' => 'ilmi.hatta@unisba.ac.id',
                'photo' => null,
                'status' => 'tetap',
                'pendidikan_terakhir' => 'S3',
                'jabatan_fungsional' => 'Lektor',
                'inpassing' => 'III/b',
                'kepangkatan' => '-',
                'bidang_keahlian' => 'Psikologi Klinis',
            ],

            // Psikologi Industri & Organisasi dan Psikologi Sosial
            [
                'nidn' => '0403087903',
                'nik' => 'D070464',
                'nama' => 'Dr. Oki Mardiawan, S.Psi., M.Psi., Psikolog.',
                'email' => 'oki.mardiawan@unisba.ac.id',
                'photo' => null,
                'status' => 'tetap',
                'pendidikan_terakhir' => 'S3',
                'jabatan_fungsional' => 'Lektor',
                'inpassing' => 'III/b',
                'kepangkatan' => '-',
                'bidang_keahlian' => 'Psikologi Industri & Organisasi (PIO), Psikologi Sosial',
            ],
        ];

        foreach ($dosens as $dosen) {
            Dosen::create($dosen);
        }
    }
}
