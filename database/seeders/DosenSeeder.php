<?php
// database/seeders/DosenSeeder.php

namespace Database\Seeders;

use App\Models\Dosen;
use Illuminate\Database\Seeder;

class DosenSeeder extends Seeder
{
    public function run(): void
    {
        $dosens = [
            // Psikologi Klinis
            [
                'nidn' => '0010018601',
                'nik' => '3273010010018601',
                'nama' => 'Prof. Dr. Hj. Siti Nurhayati, M.Si., Psikolog',
                'email' => 'siti.nurhayati@unisba.ac.id',
                'photo' => null,
                'status' => 'tetap',
                'pendidikan_terakhir' => 'S3',
                'jabatan_fungsional' => 'Guru Besar',
                'inpassing' => 'IV/e',
                'kepangkatan' => 'Pembina Utama Madya',
                'bidang_keahlian' => 'Psikologi Klinis',
            ],
            [
                'nidn' => '0020038702',
                'nik' => '3273010020038702',
                'nama' => 'Dr. Ahmad Rizal, S.Psi., M.Psi., Psikolog',
                'email' => 'ahmad.rizal@unisba.ac.id',
                'photo' => null,
                'status' => 'tetap',
                'pendidikan_terakhir' => 'S3',
                'jabatan_fungsional' => 'Lektor Kepala',
                'inpassing' => 'IV/d',
                'kepangkatan' => 'Pembina Utama Muda',
                'bidang_keahlian' => 'Psikologi Klinis Anak',
            ],
            // Psikologi Pendidikan
            [
                'nidn' => '0030058803',
                'nik' => '3273010030058803',
                'nama' => 'Dr. Dewi Kartika, M.Pd., Psikolog',
                'email' => 'dewi.kartika@unisba.ac.id',
                'photo' => null,
                'status' => 'tetap',
                'pendidikan_terakhir' => 'S3',
                'jabatan_fungsional' => 'Lektor',
                'inpassing' => 'III/d',
                'kepangkatan' => 'Penata',
                'bidang_keahlian' => 'Psikologi Pendidikan',
            ],
            [
                'nidn' => '0040108904',
                'nik' => '3273010040108904',
                'nama' => 'Dr. Bambang Supriyadi, S.Psi., M.Pd.',
                'email' => 'bambang.supriyadi@unisba.ac.id',
                'photo' => null,
                'status' => 'tetap',
                'pendidikan_terakhir' => 'S3',
                'jabatan_fungsional' => 'Lektor',
                'inpassing' => 'III/c',
                'kepangkatan' => 'Penata',
                'bidang_keahlian' => 'Psikologi Pendidikan',
            ],
            // Psikologi Industri dan Organisasi
            [
                'nidn' => '0050129005',
                'nik' => '3273010050129005',
                'nama' => 'Dr. Eka Prasetya, S.Psi., M.M., Psikolog',
                'email' => 'eka.prasetya@unisba.ac.id',
                'photo' => null,
                'status' => 'tetap',
                'pendidikan_terakhir' => 'S3',
                'jabatan_fungsional' => 'Lektor',
                'inpassing' => 'III/d',
                'kepangkatan' => 'Penata',
                'bidang_keahlian' => 'Psikologi Industri',
            ],
            [
                'nidn' => '0060159106',
                'nik' => '3273010060159106',
                'nama' => 'Rina Febriyanti, S.Psi., M.Si., Psikolog',
                'email' => 'rina.febriyanti@unisba.ac.id',
                'photo' => null,
                'status' => 'tetap',
                'pendidikan_terakhir' => 'S2',
                'jabatan_fungsional' => 'Asisten Ahli',
                'inpassing' => 'III/b',
                'kepangkatan' => 'Penata Muda Tk I',
                'bidang_keahlian' => 'Psikologi Organisasi',
            ],
            // Psikologi Perkembangan
            [
                'nidn' => '0070209207',
                'nik' => '3273010070209207',
                'nama' => 'Prof. Dr. Yaya Sunarya, M.Si., Psikolog',
                'email' => 'yaya.sunarya@unisba.ac.id',
                'photo' => null,
                'status' => 'tetap',
                'pendidikan_terakhir' => 'S3',
                'jabatan_fungsional' => 'Guru Besar',
                'inpassing' => 'IV/e',
                'kepangkatan' => 'Pembina Utama Madya',
                'bidang_keahlian' => 'Psikologi Perkembangan',
            ],
            [
                'nidn' => '0080259308',
                'nik' => '3273010080259308',
                'nama' => 'Maya Sari, S.Psi., M.Psi., Psikolog',
                'email' => 'maya.sari@unisba.ac.id',
                'photo' => null,
                'status' => 'tetap',
                'pendidikan_terakhir' => 'S2',
                'jabatan_fungsional' => 'Asisten Ahli',
                'inpassing' => 'III/a',
                'kepangkatan' => 'Penata Muda',
                'bidang_keahlian' => 'Psikologi Perkembangan',
            ],
            // Psikologi Sosial
            [
                'nidn' => '0090309409',
                'nik' => '3273010090309409',
                'nama' => 'Agus Salim, S.Psi., M.Si., Psikolog',
                'email' => 'agus.salim@unisba.ac.id',
                'photo' => null,
                'status' => 'tetap',
                'pendidikan_terakhir' => 'S2',
                'jabatan_fungsional' => 'Lektor',
                'inpassing' => 'III/c',
                'kepangkatan' => 'Penata',
                'bidang_keahlian' => 'Psikologi Sosial',
            ],
            [
                'nidn' => '0100359510',
                'nik' => '3273010100359510',
                'nama' => 'Linda Wati, S.Psi., M.Si.',
                'email' => 'linda.wati@unisba.ac.id',
                'photo' => null,
                'status' => 'kontrak',
                'pendidikan_terakhir' => 'S2',
                'jabatan_fungsional' => 'Tenaga Pengajar',
                'inpassing' => '-',
                'kepangkatan' => '-',
                'bidang_keahlian' => 'Psikologi Sosial',
            ],
        ];

        foreach ($dosens as $dosen) {
            Dosen::create($dosen);
        }
    }
}
