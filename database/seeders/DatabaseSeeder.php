<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        $this->call([
            AdminSeeder::class,
            DosenSeeder::class,
            MahasiswaSeeder::class,
            MataKuliahSeeder::class,
            JadwalKuliahSeeder::class,
            TugasSeeder::class,
            AbsensiSeeder::class,
            PengumpulanSeeder::class,
        ]);
    }
}