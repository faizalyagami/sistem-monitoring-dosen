<?php

namespace Database\Seeders;

use App\Models\Dosen;
use Illuminate\Database\Seeder;

class DosenSeeder extends Seeder
{
    public function run(): void
    {
        $dosens = [
            [
                'nidn' => '0010018601',
                'nik' => '3273010010018601',
                'nama' => 'Prof. Dr. Ahmad Rizal, M.Sc.',
                'email' => 'ahmad.rizal@university.ac.id',
                'photo' => null,
                'status' => 'tetap',
                'pendidikan_terakhir' => 'S3',
                'jabatan_fungsional' => 'Guru Besar',
                'inpassing' => 'IV/e',
                'kepangkatan' => 'Pembina Utama Madya',
            ],
            [
                'nidn' => '0020038702',
                'nik' => '3273010020038702',
                'nama' => 'Dr. Siti Nurhaliza, M.Kom.',
                'email' => 'siti.nurhaliza@university.ac.id',
                'photo' => null,
                'status' => 'tetap',
                'pendidikan_terakhir' => 'S3',
                'jabatan_fungsional' => 'Lektor Kepala',
                'inpassing' => 'IV/d',
                'kepangkatan' => 'Pembina Utama Muda',
            ],
            [
                'nidn' => '0030058803',
                'nik' => '3273010030058803',
                'nama' => 'Dr. Bambang Supriyadi, S.Si., M.Si.',
                'email' => 'bambang.supriyadi@university.ac.id',
                'photo' => null,
                'status' => 'tetap',
                'pendidikan_terakhir' => 'S3',
                'jabatan_fungsional' => 'Lektor',
                'inpassing' => 'III/d',
                'kepangkatan' => 'Penata',
            ],
            [
                'nidn' => '0040108904',
                'nik' => '3273010040108904',
                'nama' => 'Dewi Kartika, S.Kom., M.T.',
                'email' => 'dewi.kartika@university.ac.id',
                'photo' => null,
                'status' => 'tetap',
                'pendidikan_terakhir' => 'S2',
                'jabatan_fungsional' => 'Asisten Ahli',
                'inpassing' => 'III/b',
                'kepangkatan' => 'Penata Muda Tk I',
            ],
            [
                'nidn' => '0050129005',
                'nik' => '3273010050129005',
                'nama' => 'Eko Prasetyo, S.T., M.Eng.',
                'email' => 'eko.prasetyo@university.ac.id',
                'photo' => null,
                'status' => 'kontrak',
                'pendidikan_terakhir' => 'S2',
                'jabatan_fungsional' => 'Tenaga Pengajar',
                'inpassing' => '-',
                'kepangkatan' => '-',
            ],
            [
                'nidn' => '0060159106',
                'nik' => '3273010060159106',
                'nama' => 'Dr. Rina Febriyanti, S.Pd., M.Pd.',
                'email' => 'rina.febriyanti@university.ac.id',
                'photo' => null,
                'status' => 'tetap',
                'pendidikan_terakhir' => 'S3',
                'jabatan_fungsional' => 'Lektor Kepala',
                'inpassing' => 'IV/c',
                'kepangkatan' => 'Pembina',
            ],
            [
                'nidn' => '0070209207',
                'nik' => '3273010070209207',
                'nama' => 'Ir. Hendra Gunawan, M.M.',
                'email' => 'hendra.gunawan@university.ac.id',
                'photo' => null,
                'status' => 'tetap',
                'pendidikan_terakhir' => 'S2',
                'jabatan_fungsional' => 'Lektor',
                'inpassing' => 'III/c',
                'kepangkatan' => 'Penata',
            ],
            [
                'nidn' => '0080259308',
                'nik' => '3273010080259308',
                'nama' => 'Dr. Maya Sari, S.E., M.Si.',
                'email' => 'maya.sari@university.ac.id',
                'photo' => null,
                'status' => 'tetap',
                'pendidikan_terakhir' => 'S3',
                'jabatan_fungsional' => 'Lektor',
                'inpassing' => 'III/d',
                'kepangkatan' => 'Penata',
            ],
            [
                'nidn' => '0090309409',
                'nik' => '3273010090309409',
                'nama' => 'Agus Salim, S.Sos., M.Si.',
                'email' => 'agus.salim@university.ac.id',
                'photo' => null,
                'status' => 'tetap',
                'pendidikan_terakhir' => 'S2',
                'jabatan_fungsional' => 'Asisten Ahli',
                'inpassing' => 'III/a',
                'kepangkatan' => 'Penata Muda',
            ],
            [
                'nidn' => '0100359510',
                'nik' => '3273010100359510',
                'nama' => 'Dr. Linda Wati, S.Si., M.Sc.',
                'email' => 'linda.wati@university.ac.id',
                'photo' => null,
                'status' => 'tetap',
                'pendidikan_terakhir' => 'S3',
                'jabatan_fungsional' => 'Lektor Kepala',
                'inpassing' => 'IV/a',
                'kepangkatan' => 'Pembina',
            ],
        ];

        foreach ($dosens as $dosen) {
            Dosen::create($dosen);
        }
    }
}
