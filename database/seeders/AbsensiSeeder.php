<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AbsensiSeeder extends Seeder {
    public function run(): void {
        DB::table('absensi')->insert([
            ['id_mk' => 'MK001', 'nim' => '241011065', 'tanggal' => '2026-06-23', 'status' => 'Hadir'],
            ['id_mk' => 'MK001', 'nim' => '241011066', 'tanggal' => '2026-06-23', 'status' => 'Hadir'],
            ['id_mk' => 'MK001', 'nim' => '241011071', 'tanggal' => '2026-06-23', 'status' => 'Sakit'],
            ['id_mk' => 'MK001', 'nim' => '241011072', 'tanggal' => '2026-06-23', 'status' => 'Alfa'],
            ['id_mk' => 'MK001', 'nim' => '241011102', 'tanggal' => '2026-06-23', 'status' => 'Hadir'],
            ['id_mk' => 'MK001', 'nim' => '241011065', 'tanggal' => '2026-06-25', 'status' => 'Hadir'],
            ['id_mk' => 'MK002', 'nim' => '241011065', 'tanggal' => '2026-06-24', 'status' => 'Hadir'],
            ['id_mk' => 'MK002', 'nim' => '241011066', 'tanggal' => '2026-06-24', 'status' => 'Izin'],
            ['id_mk' => 'MK002', 'nim' => '241011071', 'tanggal' => '2026-06-24', 'status' => 'Hadir'],
        ]);
    }
}