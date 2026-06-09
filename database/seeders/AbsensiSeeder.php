<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AbsensiSeeder extends Seeder {
    public function run(): void {
        DB::table('absensi')->insert([
            ['id_mk' => 'MK001', 'nim' => '241011065', 'tanggal' => '2026-05-10', 'status' => 'Hadir'],
            ['id_mk' => 'MK001', 'nim' => '241011065', 'tanggal' => '2026-05-10', 'status' => 'Hadir'],
            ['id_mk' => 'MK001', 'nim' => '241011066', 'tanggal' => '2026-05-10', 'status' => 'Hadir'],
            ['id_mk' => 'MK001', 'nim' => '241011071', 'tanggal' => '2026-05-10', 'status' => 'Sakit'],
            ['id_mk' => 'MK001', 'nim' => '241011072', 'tanggal' => '2026-05-10', 'status' => 'Alfa'],
            ['id_mk' => 'MK001', 'nim' => '241011102', 'tanggal' => '2026-05-10', 'status' => 'Hadir'],
        ]);
    }
}