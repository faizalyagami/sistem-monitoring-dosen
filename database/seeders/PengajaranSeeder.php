<?php

namespace Database\Seeders;

use App\Models\Pengajaran;
use App\Models\Dosen;
use App\Models\AcademicPeriod;
use Illuminate\Database\Seeder;

class PengajaranSeeder extends Seeder
{
    public function run(): void
    {
        $dosens = Dosen::all();
        $periods = AcademicPeriod::all();

        $pengajarans = [];

        // Semester Ganjil 2024/2025 (periode aktif)
        $activePeriod = $periods->where('is_active', true)->first();

        // Data pengajaran untuk setiap dosen
        foreach ($dosens as $index => $dosen) {
            $courses = [
                0 => [ // Untuk dosen 1
                    ['kode_mk' => 'IF101', 'nama_mk' => 'Algoritma dan Pemrograman', 'sks' => 3, 'jumlah_mahasiswa' => 45],
                    ['kode_mk' => 'IF102', 'nama_mk' => 'Struktur Data', 'sks' => 3, 'jumlah_mahasiswa' => 40],
                ],
                1 => [
                    ['kode_mk' => 'IF201', 'nama_mk' => 'Basis Data', 'sks' => 3, 'jumlah_mahasiswa' => 50],
                    ['kode_mk' => 'IF202', 'nama_mk' => 'Sistem Informasi', 'sks' => 2, 'jumlah_mahasiswa' => 45],
                ],
                2 => [
                    ['kode_mk' => 'IF301', 'nama_mk' => 'Jaringan Komputer', 'sks' => 3, 'jumlah_mahasiswa' => 35],
                    ['kode_mk' => 'IF302', 'nama_mk' => 'Keamanan Komputer', 'sks' => 2, 'jumlah_mahasiswa' => 30],
                ],
                3 => [
                    ['kode_mk' => 'IF401', 'nama_mk' => 'Pemrograman Web', 'sks' => 3, 'jumlah_mahasiswa' => 55],
                    ['kode_mk' => 'IF402', 'nama_mk' => 'Pemrograman Mobile', 'sks' => 3, 'jumlah_mahasiswa' => 40],
                ],
                4 => [
                    ['kode_mk' => 'IF501', 'nama_mk' => 'Kecerdasan Buatan', 'sks' => 3, 'jumlah_mahasiswa' => 25],
                    ['kode_mk' => 'IF502', 'nama_mk' => 'Machine Learning', 'sks' => 3, 'jumlah_mahasiswa' => 20],
                ],
                5 => [
                    ['kode_mk' => 'IF601', 'nama_mk' => 'Metodologi Penelitian', 'sks' => 2, 'jumlah_mahasiswa' => 60],
                    ['kode_mk' => 'IF602', 'nama_mk' => 'Statistika', 'sks' => 2, 'jumlah_mahasiswa' => 55],
                ],
                6 => [
                    ['kode_mk' => 'IF701', 'nama_mk' => 'Manajemen Proyek', 'sks' => 2, 'jumlah_mahasiswa' => 35],
                    ['kode_mk' => 'IF702', 'nama_mk' => 'E-Business', 'sks' => 3, 'jumlah_mahasiswa' => 30],
                ],
                7 => [
                    ['kode_mk' => 'IF801', 'nama_mk' => 'Audit Sistem Informasi', 'sks' => 3, 'jumlah_mahasiswa' => 28],
                    ['kode_mk' => 'IF802', 'nama_mk' => 'Tata Kelola TI', 'sks' => 2, 'jumlah_mahasiswa' => 25],
                ],
                8 => [
                    ['kode_mk' => 'IF901', 'nama_mk' => 'Interaksi Manusia Komputer', 'sks' => 2, 'jumlah_mahasiswa' => 42],
                    ['kode_mk' => 'IF902', 'nama_mk' => 'Desain UX', 'sks' => 3, 'jumlah_mahasiswa' => 38],
                ],
                9 => [
                    ['kode_mk' => 'IF1001', 'nama_mk' => 'Sistem Terdistribusi', 'sks' => 3, 'jumlah_mahasiswa' => 22],
                    ['kode_mk' => 'IF1002', 'nama_mk' => 'Cloud Computing', 'sks' => 3, 'jumlah_mahasiswa' => 18],
                ],
            ];

            if (isset($courses[$index])) {
                foreach ($courses[$index] as $course) {
                    $pengajarans[] = [
                        'kode_mk' => $course['kode_mk'],
                        'nama_mk' => $course['nama_mk'],
                        'bidang_keilmuan' => 'Ilmu Komputer',
                        'kelas' => 'A-' . rand(1, 3),
                        'sks' => $course['sks'],
                        'jumlah_mahasiswa' => $course['jumlah_mahasiswa'],
                        'semester' => 'ganjil',
                        'tahun_akademik' => 2024,
                        'dosen_id' => $dosen->id,
                        'academic_period_id' => $activePeriod->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        // Tambahkan data untuk periode sebelumnya
        $oldPeriods = $periods->where('is_active', false)->take(2);

        foreach ($oldPeriods as $period) {
            foreach ($dosens->take(5) as $dosen) {
                $pengajarans[] = [
                    'kode_mk' => 'IFOLD' . rand(100, 999),
                    'nama_mk' => 'Mata Kuliah Lama ' . rand(1, 5),
                    'bidang_keilmuan' => 'Ilmu Komputer',
                    'kelas' => 'B-' . rand(1, 2),
                    'sks' => rand(2, 3),
                    'jumlah_mahasiswa' => rand(20, 50),
                    'semester' => $period->semester,
                    'tahun_akademik' => $period->tahun_awal,
                    'dosen_id' => $dosen->id,
                    'academic_period_id' => $period->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        foreach (array_chunk($pengajarans, 50) as $chunk) {
            Pengajaran::insert($chunk);
        }
    }
}
