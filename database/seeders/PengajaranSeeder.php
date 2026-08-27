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

        // Mata Kuliah Psikologi
        $courses = [
            // Psikologi Klinis
            ['kode_mk' => 'PSI101', 'nama_mk' => 'Psikologi Klinis Dasar', 'bidang' => 'Psikologi Klinis', 'sks' => 3],
            ['kode_mk' => 'PSI102', 'nama_mk' => 'Psikopatologi', 'bidang' => 'Psikologi Klinis', 'sks' => 3],
            ['kode_mk' => 'PSI103', 'nama_mk' => 'Psikoterapi', 'bidang' => 'Psikologi Klinis', 'sks' => 4],
            ['kode_mk' => 'PSI104', 'nama_mk' => 'Tes Psikologi', 'bidang' => 'Psikologi Klinis', 'sks' => 3],

            // Psikologi Pendidikan
            ['kode_mk' => 'PSI201', 'nama_mk' => 'Psikologi Pendidikan', 'bidang' => 'Psikologi Pendidikan', 'sks' => 3],
            ['kode_mk' => 'PSI202', 'nama_mk' => 'Psikologi Belajar', 'bidang' => 'Psikologi Pendidikan', 'sks' => 3],
            ['kode_mk' => 'PSI203', 'nama_mk' => 'Bimbingan Konseling', 'bidang' => 'Psikologi Pendidikan', 'sks' => 4],
            ['kode_mk' => 'PSI204', 'nama_mk' => 'Psikologi Anak Berkebutuhan Khusus', 'bidang' => 'Psikologi Pendidikan', 'sks' => 3],

            // Psikologi Industri
            ['kode_mk' => 'PSI301', 'nama_mk' => 'Psikologi Industri', 'bidang' => 'Psikologi Industri', 'sks' => 3],
            ['kode_mk' => 'PSI302', 'nama_mk' => 'Psikologi Sumber Daya Manusia', 'bidang' => 'Psikologi Industri', 'sks' => 3],
            ['kode_mk' => 'PSI303', 'nama_mk' => 'Perilaku Organisasi', 'bidang' => 'Psikologi Industri', 'sks' => 3],

            // Psikologi Perkembangan
            ['kode_mk' => 'PSI401', 'nama_mk' => 'Psikologi Perkembangan', 'bidang' => 'Psikologi Perkembangan', 'sks' => 3],
            ['kode_mk' => 'PSI402', 'nama_mk' => 'Psikologi Anak', 'bidang' => 'Psikologi Perkembangan', 'sks' => 3],
            ['kode_mk' => 'PSI403', 'nama_mk' => 'Psikologi Remaja', 'bidang' => 'Psikologi Perkembangan', 'sks' => 2],
            ['kode_mk' => 'PSI404', 'nama_mk' => 'Psikologi Dewasa dan Lansia', 'bidang' => 'Psikologi Perkembangan', 'sks' => 3],

            // Psikologi Sosial
            ['kode_mk' => 'PSI501', 'nama_mk' => 'Psikologi Sosial', 'bidang' => 'Psikologi Sosial', 'sks' => 3],
            ['kode_mk' => 'PSI502', 'nama_mk' => 'Dinamika Kelompok', 'bidang' => 'Psikologi Sosial', 'sks' => 2],
            ['kode_mk' => 'PSI503', 'nama_mk' => 'Psikologi Lintas Budaya', 'bidang' => 'Psikologi Sosial', 'sks' => 3],

            // Mata Kuliah Umum
            ['kode_mk' => 'PSI601', 'nama_mk' => 'Metodologi Penelitian Psikologi', 'bidang' => 'Metodologi', 'sks' => 4],
            ['kode_mk' => 'PSI602', 'nama_mk' => 'Statistik Psikologi', 'bidang' => 'Metodologi', 'sks' => 3],
            ['kode_mk' => 'PSI603', 'nama_mk' => 'Etika Profesi Psikologi', 'bidang' => 'Profesi', 'sks' => 2],
        ];

        // Semester Ganjil 2024/2025 (periode aktif)
        $activePeriod = $periods->where('is_active', true)->first();

        if ($activePeriod) {
            foreach ($dosens as $index => $dosen) {
                $assignedCourses = array_slice($courses, ($index * 2) % count($courses), 2);
                foreach ($assignedCourses as $course) {
                    $pengajarans[] = [
                        'kode_mk' => $course['kode_mk'],
                        'nama_mk' => $course['nama_mk'],
                        'bidang_keilmuan' => $course['bidang'],
                        'kelas' => ['A', 'B', 'C', 'D'][array_rand(['A', 'B', 'C', 'D'])],
                        'sks' => $course['sks'],
                        'jumlah_mahasiswa' => rand(25, 60),
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

        foreach (array_chunk($pengajarans, 50) as $chunk) {
            Pengajaran::insert($chunk);
        }
    }
}
