<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Urutan seeding penting karena ada foreign key constraints

        $this->call([
            AcademicPeriodSeeder::class,  // 1. Periode akademik dulu
            DosenSeeder::class,           // 2. Data dosen
            UserSeeder::class,            // 3. User accounts (butuh dosen_id)
            // PengajaranSeeder::class,      // 4. Pengajaran (butuh dosen & period)
            // RisetSeeder::class,           // 5. Penelitian (butuh dosen & period)
            // PkmSeeder::class,             // 6. PKM (butuh dosen & period)
            // BimbinganSeeder::class,       // 7. Bimbingan (butuh dosen & period)
        ]);

        $this->command->info('Semua seeder berhasil dijalankan!');
        $this->command->info('Akun login:');
        $this->command->info('Super Admin: superadmin@unisba.ac.id / password123');
        $this->command->info('Admin: admin@unisba.ac.id / password123');
        $this->command->info('Operator: operator@unisba.ac.id / password123');
        $this->command->info('Viewer: viewer@unisba.ac.id / password123');
        $this->command->info('Dosen: email sesuai data dosen / password123');
    }
}
