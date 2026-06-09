<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengumpulanSeeder extends Seeder {
    public function run(): void {
        DB::table('pengumpulan')->insert([
            ['id_tugas' => 1, 'nim' => '241011065', 'tanggal_kumpul' => '2026-05-09 20:00:00', 'file_tugas' => '241011065_Tugas1_pdf'],
            ['id_tugas' => 1, 'nim' => '241011066', 'tanggal_kumpul' => '2026-05-09 20:15:00', 'file_tugas' => '241011066_Tugas1.pdf'],
            ['id_tugas' => 1, 'nim' => '241011102', 'tanggal_kumpul' => '2026-05-09 17:16:00', 'file_tugas' => '241011102_Tugas1.pdf'],
        ]);
    }
}