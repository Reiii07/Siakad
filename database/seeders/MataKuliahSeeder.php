<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MataKuliahSeeder extends Seeder {
    public function run(): void {
        DB::table('mata_kuliah')->insert([
            ['id_mk' => 'MK001', 'nip_dosen' => '198501012024', 'nama_mk' => 'Pemrograman Web'],
            ['id_mk' => 'MK002', 'nip_dosen' => '198601012024', 'nama_mk' => 'Kecerdasan Buatan'],
        ]);
    }
}