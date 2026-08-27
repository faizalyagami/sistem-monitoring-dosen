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
        $this->call([
            AcademicPeriodSeeder::class,
            DosenSeeder::class,
            UserSeeder::class,
            PengajaranSeeder::class,
            RisetSeeder::class,
            PkmSeeder::class,
            BimbinganSeeder::class,
            PelatihanSeeder::class,
            SippSeeder::class,
            AsosiasiSeeder::class,
            SertifikasiSeeder::class
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
